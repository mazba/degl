<?php
namespace App\Controller;

use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;

/**
 * LabLetterRegisters Controller
 *
 * @property \App\Model\Table\LabLetterRegistersTable $LabLetterRegisters
 */
class LabBillsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $user = $user = $this->Auth->user();
        $this->loadModel('LabBills');
        $labBill = $this->LabBills->newEntity();

        if ($this->request->is('post')) {
            $inputs = $this->request->data;
            $con = ConnectionManager::get('default');

            try {

                $con->transactional(function ($con) use ($inputs, $labBill, $user) {

                    $data = array();
                    if ($inputs['related_to'] == 'letter') {
                        $data['type'] = 'letter';
                        $data['reference_id'] = $inputs['letter_id'];
                    } elseif ($inputs['related_to'] == 'scheme') {
                        $data['type'] = 'scheme';
                        $data['reference_id'] = $inputs['scheme_id'];
                    }
                    $data['total_amount'] = $inputs['total_amount'];
                    $data['net_payable'] = $inputs['net_payable'];
                    $data['status'] = 1;
                    $data['created_date'] = time();
                    $data['created_by'] = $user['id'];
                    $labBill = $this->LabBills->patchEntity($labBill, $data);
                    if (!$bill = $this->LabBills->save($labBill)) {
                        throw new \Exception();
                    }

                    if (!empty($inputs['parent_id'])) {
                        $this->loadModel('nothi_assigns');
                        $nothi_data = array();
                        $nothi_data['nothi_register_id'] = $inputs['parent_id'];
                        $nothi_data['lab_bill_id'] = $bill['id'];
                        $new_nothi = $this->nothi_assigns->newEntity();
                        $nothi = $this->nothi_assigns->patchEntity($new_nothi, $nothi_data);
                        if (!$this->nothi_assigns->save($nothi)) {
                            throw new \Exception();
                        }
                    }

                    if ($inputs['related_to'] == 'letter') {
                        $this->loadModel('LabActualTests');
                        $tests = $this->LabActualTests->find()->where(['lab_letter_registers_id' => $inputs['letter_id'], 'is_billed' => 0]);
                        foreach ($tests as $test) {
                            $this->loadModel('LabBillDetails');
                            $labBillDetail = $this->LabBillDetails->newEntity();
                            $labBillDetail->lab_bill_id = $bill['id'];
                            $labBillDetail->lab_actual_test_id = $test['id'];
                            if (!$this->LabBillDetails->save($labBillDetail)) {
                                throw new \Exception();
                            }

                        }
                        $this->LabActualTests->updateAll(['is_billed' => 1], ['lab_letter_registers_id' => $inputs['letter_id'], 'is_billed' => 0]);


                    } elseif ($inputs['related_to'] == 'scheme') {
                        $this->loadModel('LabActualTests');
                        $tests = $this->LabActualTests->find()->where(['scheme_id' => $inputs['scheme_id'], 'is_billed' => 0]);
                        foreach ($tests as $test) {
                            $this->loadModel('LabBillDetails');
                            $labBillDetail = $this->LabBillDetails->newEntity();
                            $labBillDetail->lab_bill_id = $bill['id'];
                            $labBillDetail->lab_actual_test_id = $test['id'];
                            $labBillDetail->lab_test_group_id = $test['lab_test_group_id'];
                            if (!$this->LabBillDetails->save($labBillDetail)) {
                                throw new \Exception();
                            }

                        }

                        $this->LabActualTests->updateAll(['is_billed' => 1], ['scheme_id' => $inputs['scheme_id'], 'is_billed' => 0]);

                    }
                    if (!empty($inputs['user'])) {
                        $arr = array();
                        $arr['sender_id'] = $user['id'];
                        $arr['subject'] = $inputs['subject'];
                        $arr['message_text'] = $inputs['message'];
                        $arr['resource_id'] = $bill['id'];
                        $arr['msg_type'] = 'labBill';
                        $arr['created_date'] = time();
                        $arr['created_by'] = $user['id'];
                        $arr['status'] = 1;
                        $this->loadModel('MessageRegisters');
                        $messageRegisters = $this->MessageRegisters->newEntity();
                        $messageRegisters = $this->MessageRegisters->patchEntity($messageRegisters, $arr);
                        if (!$msg = $this->MessageRegisters->save($messageRegisters)) {
                            throw new \Exception();
                        }
                        foreach ($inputs['user'] as $user_id) {
                            $recipient_data['message_register_id'] = $msg['id'];
                            $recipient_data['user_id'] = $user_id;
                            $recipient_data['created_date'] = time();
                            $recipient_data['created_by'] = $user['id'];
                            $recipient_data['status'] = 1;

                            $this->loadModel('Recipients');
                            $recipients = $this->Recipients->newEntity();
                            $recipients = $this->Recipients->patchEntity($recipients, $recipient_data);
                            if (!$this->Recipients->save($recipients)) {
                                throw new \Exception();
                            }
                        }
                    }
                    $this->Flash->success('Bill sent and save successfully.');
                    return $this->redirect(['action' => 'index']);
                });

            } catch (\Exception $e) {
                echo "<pre>";
                print_r($e);
                echo "</pre>";
                die;
                $this->Flash->error('Bill can not save. Please try again');
                return $this->redirect($this->referer());
            }

        }
        $office_id = $this->Auth->user('office_id');
        $this->loadModel('Departments');

        $departments = $this->Departments->find()->hydrate(false)
            ->select(['designations.name_bn', 'users.id', 'users.name_bn', 'Departments.name_bn'])
            ->where(['Departments.office_id' => $office_id])
            ->leftJoin('users', 'users.department_id=Departments.id and users.status=1')
            ->leftJoin('designations', 'designations.id=users.designation_id')
            ->order(['Departments.order_no' => 'asc', 'designations.order_no' => 'asc']);

        $this->loadModel('Schemes');
        $schemes = $this->Schemes->find('list')
            ->where(['Schemes.status' => 1]);

        $this->loadModel('LabLetterRegisters');
        $labLetterRegisters = $this->LabLetterRegisters->find('list', ['conditions' => ['scheme_id is' => NULL]]);
        $this->loadModel('NothiRegisters');
        $nothiRegisters = $this->NothiRegisters->find('list', [
            'conditions' => ['status' => 1, 'parent_id' => 0],
        ])->toArray();

        $this->set(compact('labBill', 'labLetterRegisters', 'departments', 'schemes', 'nothiRegisters'));
    }

    // add lab test
    public function add($id = null)
    {


    }


    // view lab test

    public function view($id = null)
    {

        $labBills = $this->LabBills->find()
            ->select(['LabBills.reference_id', 'LabBills.total_amount', 'LabBills.net_payable'])
            ->where(['LabBills.id' => $id])
            ->first();
        $this->loadModel('LabLetterRegisters');
        $labTests = $this->LabLetterRegisters->find()
            ->autoFields(true)
            ->select(['lab_actual_tests.lab_test_short_name', 'lab_actual_tests.number_of_test', 'lab_actual_tests.rate'])
            ->where(['LabLetterRegisters.scheme_id' => $labBills->reference_id])
            ->leftJoin('lab_actual_tests', 'lab_actual_tests.lab_letter_registers_id=LabLetterRegisters.id')
            ->order(['lab_actual_tests.id' => 'desc']);

        $this->loadModel('Schemes');
        $scheme = $this->Schemes->find()
            ->select(['contractors.contractor_title', 'projects.name_bn', 'Schemes.id', 'Schemes.name_bn'])
            ->where(['Schemes.id' => $labBills->reference_id])
            ->leftJoin('projects', 'projects.id=Schemes.project_id')
            ->leftJoin('scheme_contractors', 'scheme_contractors.scheme_id=Schemes.id and scheme_contractors.is_lead=1')
            ->leftJoin('contractors', 'contractors.id=scheme_contractors.contractor_id')
            ->toArray();


        $this->set(compact(['labTests', 'scheme', 'labBills']));
    }

// edit lab test

    public function edit($id = null)
    {


    }

    //delete test list

    public function delete($id = null)
    {

    }

//    ajax
    public function ajax($action = null)
    {
        if ($action == 'get_grid_data') {

        }

    }

    //    Print report
    public function print_it()
    {
        $user = $this->Auth->user();
        $this->layout = 'print';
        $this->view = 'print';
        if ($this->request->data('type') == 'by_date') {
            $start_date = strtotime($this->request->data('start_date') . '00:00:00 GMT');// TODO:check time issue
            $end_date = strtotime($this->request->data('end_date') . '23:59:59 GMT');// TODO:check time issue

            $labTestFeeRegisterTable = TableRegistry::get('lab_test_fee_registers');
            $labTestFeeRegisters = $labTestFeeRegisterTable->find()
                ->autoFields(true)
                ->select(['schemes.name_en', 'schemes.name_bn', 'lab_letter_registers.work_description'])
                ->where([
                    'lab_test_fee_registers.payment_date >=' => $start_date,
                    'lab_test_fee_registers.payment_date <=' => $end_date,
                    'lab_test_fee_registers.status !=' => 99,
                    'lab_letter_registers.office_id' => $user['office_id']
                ])
                ->leftJoin('lab_letter_registers', 'lab_letter_registers.id = lab_test_fee_registers.lab_letter_registers_id')
                ->leftJoin('schemes', 'schemes.id = lab_letter_registers.scheme_id');
            // OFFICE
            $officeTable = TableRegistry::get('offices');
            $office = $officeTable->find()
                ->where(['id' => $user['office_id']])
                ->first();
            $this->set(compact('labTestFeeRegisters', 'office'));
        } else {
            $labTestFeeRegisterTable = TableRegistry::get('lab_test_fee_registers');
            $labTestFeeRegisters = $labTestFeeRegisterTable->find()
                ->autoFields(true)
                ->select(['schemes.name_en', 'schemes.name_bn', 'lab_letter_registers.work_description'])
                ->where([
                    'lab_test_fee_registers.payment_date >=' => strtotime('00:00'),
                    'lab_test_fee_registers.payment_date <=' => strtotime('23:59'),
                    'lab_test_fee_registers.status !=' => 99,
                    'lab_letter_registers.office_id' => $user['office_id']
                ])
                ->leftJoin('lab_letter_registers', 'lab_letter_registers.id = lab_test_fee_registers.lab_letter_registers_id')
                ->leftJoin('schemes', 'schemes.id = lab_letter_registers.scheme_id');

            //OFFICE
            $officeTable = TableRegistry::get('offices');
            $office = $officeTable->find()
                ->where(['id' => $user['office_id']])
                ->first();

            $this->set(compact('labTestFeeRegisters', 'office'));
        }
    }

    //report test

    public function report()
    {
        if ($this->request->data('type') == 'letter') {
            $letter_id = $this->request->data('scheme_id');
            $this->loadModel('LabActualTests');
            $tests = $this->LabActualTests->find()
                ->where(['lab_letter_registers_id' => $letter_id])
                ->group(['lab_test_group_id','lab_test_list_id','created_date']);


            $labTests = [];
            foreach ($tests as $key => $test) {
                if ($test['is_billed']) {
                    $labTests[$test['lab_test_list_id']]['lab_test_short_name'] = $test['lab_test_short_name'];
                    $labTests[$test['lab_test_list_id']]['number_of_test'] = isset($labTests[$test['lab_test_list_id']]['number_of_test']) ? $labTests[$test['lab_test_list_id']]['number_of_test'] + $test['number_of_test'] : $test['number_of_test'];
                    $labTests[$test['lab_test_list_id']]['latest_number_of_test'] = isset($labTests[$test['lab_test_list_id']]['latest_number_of_test']) ? $labTests[$test['lab_test_list_id']]['latest_number_of_test'] : 0;
                    $labTests[$test['lab_test_list_id']]['rate'] = $test['rate'];
                    $labTests[$test['lab_test_list_id']]['total'] = isset($labTests[$test['lab_test_list_id']]['total']) ? $labTests[$test['lab_test_list_id']]['total'] + $test['rate'] * $test['number_of_test'] : $test['rate'] * $test['number_of_test'];
                    $labTests[$test['lab_test_list_id']]['latest_total'] = isset($labTests[$test['lab_test_list_id']]['latest_total']) ? $labTests[$test['lab_test_list_id']]['latest_total'] : 0;

                } else {
                    $labTests[$test['lab_test_list_id']]['lab_test_short_name'] = $test['lab_test_short_name'];
                    $labTests[$test['lab_test_list_id']]['number_of_test'] = isset($labTests[$test['lab_test_list_id']]['number_of_test']) ? $labTests[$test['lab_test_list_id']]['number_of_test'] + $test['number_of_test'] : $test['number_of_test'];
                    $labTests[$test['lab_test_list_id']]['latest_number_of_test'] = isset($labTests[$test['lab_test_list_id']]['latest_number_of_test']) ? $labTests[$test['lab_test_list_id']]['latest_number_of_test'] + $test['number_of_test'] : $test['number_of_test'];
                    $labTests[$test['lab_test_list_id']]['rate'] = $test['rate'];
                    $labTests[$test['lab_test_list_id']]['total'] = isset($labTests[$test['lab_test_list_id']]['total']) ? $labTests[$test['lab_test_list_id']]['total'] + $test['rate'] * $test['number_of_test'] : $test['rate'] * $test['number_of_test'];
                    $labTests[$test['lab_test_list_id']]['latest_total'] = isset($labTests[$test['lab_test_list_id']]['latest_total']) ? $labTests[$test['lab_test_list_id']]['latest_total'] + $test['rate'] * $test['number_of_test'] : $test['rate'] * $test['number_of_test'];
                }
            }

            $this->loadModel('LabLetterRegisters');
            $labLetter = $this->LabLetterRegisters->get($letter_id);

            $labBills = $this->LabBills->find()
                ->select(['total_amount', 'net_payable'])
                ->where(['LabBills.reference_id' => $letter_id, 'LabBills.type' => 'letter'])
                ->order(['LabBills.created_date' => 'desc'])
                ->first();

            $this->loadModel('nothi_assigns');

            $arr = [];
            $arr['test'] = $labTests;
            $arr['scheme'] = $labLetter->toArray();
            $arr['prebill'] = $labBills;


            $this->response->body(json_encode($arr));
            return $this->response;


        } elseif ($this->request->data('type') == 'scheme') {
            $id = $this->request->data['scheme_id'];
            $this->loadModel('LabActualTests');
            $tests = $this->LabActualTests->find()->where(['scheme_id' => $id])
                ->group(['lab_test_group_id','lab_test_list_id','created_date']);


            $this->loadModel('Schemes');
            $scheme = $this->Schemes->find()
                ->select(['contractors.contractor_title', 'projects.name_bn',  'packages.name_bn', 'Schemes.id', 'Schemes.name_bn'])
                ->where(['Schemes.id' => $id])
                ->leftJoin('packages', 'packages.id=Schemes.package_id')
                ->leftJoin('projects', 'projects.id=Schemes.project_id')
                ->leftJoin('scheme_contractors', 'scheme_contractors.scheme_id=Schemes.id and scheme_contractors.is_lead=1')
                ->leftJoin('contractors', 'contractors.id=scheme_contractors.contractor_id');


            $labBills = $this->LabBills->find()
                ->select(['total_amount', 'net_payable'])
                ->where(['LabBills.reference_id' => $id, 'LabBills.type' => 'scheme'])
                ->order(['LabBills.created_date' => 'desc'])
                ->first();

            $labTests = [];
            foreach ($tests as $test) {
                if ($test['is_billed']) {
                    $labTests[$test['lab_test_list_id']]['lab_test_short_name'] = $test['lab_test_short_name'];
                    $labTests[$test['lab_test_list_id']]['number_of_test'] = isset($labTests[$test['lab_test_list_id']]['number_of_test']) ? $labTests[$test['lab_test_list_id']]['number_of_test'] + $test['number_of_test'] : $test['number_of_test'];
                    $labTests[$test['lab_test_list_id']]['latest_number_of_test'] = isset($labTests[$test['lab_test_list_id']]['latest_number_of_test']) ? $labTests[$test['lab_test_list_id']]['latest_number_of_test'] : 0;
                    $labTests[$test['lab_test_list_id']]['rate'] = $test['rate'];
                    $labTests[$test['lab_test_list_id']]['total'] = isset($labTests[$test['lab_test_list_id']]['total']) ? $labTests[$test['lab_test_list_id']]['total'] + $test['rate'] * $test['number_of_test'] : $test['rate'] * $test['number_of_test'];
                    $labTests[$test['lab_test_list_id']]['latest_total'] = isset($labTests[$test['lab_test_list_id']]['latest_total']) ? $labTests[$test['lab_test_list_id']]['latest_total'] : 0;

                } else {
                    $labTests[$test['lab_test_list_id']]['lab_test_short_name'] = $test['lab_test_short_name'];
                    $labTests[$test['lab_test_list_id']]['number_of_test'] = isset($labTests[$test['lab_test_list_id']]['number_of_test']) ? $labTests[$test['lab_test_list_id']]['number_of_test'] + $test['number_of_test'] : $test['number_of_test'];
                    $labTests[$test['lab_test_list_id']]['latest_number_of_test'] = isset($labTests[$test['lab_test_list_id']]['latest_number_of_test']) ? $labTests[$test['lab_test_list_id']]['latest_number_of_test'] + $test['number_of_test'] : $test['number_of_test'];
                    $labTests[$test['lab_test_list_id']]['rate'] = $test['rate'];
                    $labTests[$test['lab_test_list_id']]['total'] = isset($labTests[$test['lab_test_list_id']]['total']) ? $labTests[$test['lab_test_list_id']]['total'] + $test['rate'] * $test['number_of_test'] : $test['rate'] * $test['number_of_test'];
                    $labTests[$test['lab_test_list_id']]['latest_total'] = isset($labTests[$test['lab_test_list_id']]['latest_total']) ? $labTests[$test['lab_test_list_id']]['latest_total'] + $test['rate'] * $test['number_of_test'] : $test['rate'] * $test['number_of_test'];
                }

            }

            $this->loadModel('nothi_assigns');

            $arr = [];
            $arr['test'] = $labTests;
            $arr['scheme'] = $scheme->toArray();
            $arr['prebill'] = $labBills;

            $this->response->body(json_encode($arr));
            return $this->response;
        }


    }

    public function lab_bill_by_scheme($scheme_id)
    {
        if ($this->user_roles['index']) {
            $this->loadModel('LabLetterRegisters');
            $LabLetterRegisters = $this->LabLetterRegisters->find('all', [
                'contain' => ['LabActualTests', 'Schemes'],
                'conditions' => ['LabLetterRegisters.scheme_id' => $scheme_id]
            ])->toArray();
            $this->set(compact('LabLetterRegisters'));
        } else {
            $this->Flash->error('You dont have access to the task');
            return $this->redirect(['controller' => 'dashboard', 'action' => 'index']);
        }

    }

    public function lists()
    {
        $this->loadModel('Schemes');
        $schemes = $this->Schemes->find('list')
            ->where(['Schemes.status' => 1]);

        $this->loadModel('LabLetterRegisters');
        $labLetterRegisters = $this->LabLetterRegisters->find('list', ['conditions' => ['scheme_id is' => NULL]]);

        $this->set(compact('labLetterRegisters'));
    }

    public function getLabBillLists()
    {
        $type = $this->request->data['related_to'];

        if (isset($this->request->data['letter_id'])) {
            $reference_id = $this->request->data['letter_id'];
        } elseif (isset($this->request->data['scheme_id'])) {
            $reference_id = $this->request->data['scheme_id'];
        }

        $labBills = $this->LabBills->find()
            ->where(['type' => $type, 'reference_id' => $reference_id])
            ->order(['created_date' => 'desc']);


        $this->set(compact('labBills'));
        $this->layout = 'ajax';
    }

    public function getSchemeLists()
    {
        $this->layout = 'ajax';
        if ($this->request->data['type'] == 'letter') {
            $this->loadModel('LabLetterRegisters');
            $labLetterRegisters = $this->LabLetterRegisters->find('list', ['conditions' => ['scheme_id is' => NULL]]);
            $this->set(compact('labLetterRegisters'));

        } elseif ($this->request->data['type'] == 'scheme') {
            $this->loadModel('Schemes');
            $schemes = $this->Schemes->find('list')
                ->where(['Schemes.status' => 1]);

            $arr = array();
            foreach ($schemes as $key => $scheme) {
                $arr[$key] = substr($scheme, 0, 100);
                $arr[$key] = substr($arr[$key], 0, strrpos($arr[$key], ' ')) . ' ... ';

            }
            $schemes = $arr;

            $this->set(compact('schemes'));
        }
    }

    public function getLabBillDetails($bill_id = null, $type = null, $reference_id = null)
    {
        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $bill_id = $this->request->data('bill_id');
            $type = $this->request->data('type');
            $reference_id = $this->request->data('reference_id');
        } else {
            $this->view = 'get_lab_bill_detail';
        }

        $this->loadModel('LabBills');
        $labBills = $this->LabBills->find()->hydrate(false)
            ->where(['LabBills.id <= ' => $bill_id, 'LabBills.type' => $type, 'LabBills.reference_id' => $reference_id])
            ->contain(['LabBillDetails'=>
                function ($q) {
                    return $q->group(['LabBillDetails.lab_test_group_id','LabBillDetails.lab_bill_id'])
                        ->contain(['LabActualTests'])
                        ->autoFields(true);
                }
            ])
//            ->group(['LabBillDetails.lab_bill_id'])
            ->order(['LabBills.id' => 'desc']);

      // echo "<pre>";print_r($labBills->toArray());die();

        if ($type == 'letter') {
            $this->loadModel('LabLetterRegisters');
            $labLetter = $this->LabLetterRegisters->get($reference_id);
            $this->set(compact('labLetter'));

        } elseif ($type == 'scheme') {
            $this->loadModel('Schemes');
            $scheme = $this->Schemes->find()
                ->select(['contractors.contractor_title', 'projects.name_bn', 'Schemes.id', 'Schemes.name_bn'])
                ->where(['Schemes.id ' => $reference_id])
                ->leftJoin('projects', 'projects.id=Schemes.project_id')
                ->leftJoin('scheme_contractors', 'scheme_contractors.scheme_id=Schemes.id and scheme_contractors.is_lead=1')
                ->leftJoin('contractors', 'contractors.id=scheme_contractors.contractor_id')
                ->toArray();
            $this->set(compact('scheme'));
        }
       // echo "<pre>";print_r($labBills->toArray());die();
        $labTests = [];
        $i = 0;
        foreach ($labBills as $labBill) {
            foreach ($labBill['lab_bill_details'] as $bill_detail) {
                if ($i == 0) {
                    $labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['lab_test_short_name'] = $bill_detail['lab_actual_test']['lab_test_short_name'];
                    $labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['number_of_test'] = 0;
                    $labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['latest_number_of_test'] = $bill_detail['lab_actual_test']['number_of_test'];
                    $labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['rate'] = $bill_detail['lab_actual_test']['rate'];
                    $labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['total'] = 0;
                    $labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['latest_total'] = $bill_detail['lab_actual_test']['rate'] * $bill_detail['lab_actual_test']['number_of_test'];

                } else {
                    $lab_bill_id_test=0;
                    $labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['lab_test_short_name'] = $bill_detail['lab_actual_test']['lab_test_short_name'];
                    $labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['number_of_test'] = isset($labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['number_of_test']) ? $labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['number_of_test'] + $bill_detail['lab_actual_test']['number_of_test'] : $bill_detail['lab_actual_test']['number_of_test'];
                    //$labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['number_of_test'] =  $bill_detail['lab_actual_test']['number_of_test'];
                    $labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['latest_number_of_test'] = isset($labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['latest_number_of_test']) ? $labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['latest_number_of_test'] : 0;
                    $labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['rate'] = $bill_detail['lab_actual_test']['rate'];
                   $labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['total'] = isset($labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['total']) ? $labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['total'] + $bill_detail['lab_actual_test']['rate'] * $bill_detail['lab_actual_test']['number_of_test'] : $bill_detail['lab_actual_test']['rate'] * $bill_detail['lab_actual_test']['number_of_test'];
                   // $labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['total'] =  $bill_detail['lab_actual_test']['rate'] * $bill_detail['lab_actual_test']['number_of_test'];
                    $labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['latest_total'] = isset($labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['latest_total']) ? $labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['latest_total'] : 0;
                }
            }

            $i++;
        }

        /*echo "<pre>";
        print_r($labTests);
        echo "</pre>";
        die;*/

        $this->set(compact('labTests'));


    }

    public function sendLabBill($id=null){
        $user = $user = $this->Auth->user();


            $this->layout = 'ajax';
            $bill_id = $this->request->data('bill_id');
        $office_id = $this->Auth->user('office_id');
        $this->loadModel('Departments');

        if ($this->request->is('post') && !$this->request->is('ajax')) {

          //  echo "<pre>";print_r($id);die();
            $inputs = $this->request->data;
           // echo "<pre>";print_r($inputs);die();
            $arr = array();
            $arr['sender_id'] = $user['id'];
            $arr['subject'] = $inputs['subject'];
            $arr['message_text'] = $inputs['message'];
            $arr['resource_id'] = $id;
            $arr['msg_type'] = 'labBill';
            $arr['created_date'] = time();
            $arr['created_by'] = $user['id'];
            $arr['status'] = 1;
            $this->loadModel('MessageRegisters');
            $messageRegisters = $this->MessageRegisters->newEntity();
           $messageRegisters = $this->MessageRegisters->patchEntity($messageRegisters, $arr);
            if ($msg = $this->MessageRegisters->save($messageRegisters)){
            foreach ($inputs['user'] as $user_id) {


                $this->loadModel('users');
                $user_info = $this->users->get($user_id);
                if($user_info->user_group_id ==7 ){

                    $lab_bills = TableRegistry::get('lab_bills');
                    $query = $lab_bills->query();
                    $query->update()
                        ->set(['is_sent_to_accounts' => 1])
                        ->where(['id' => $id])
                        ->execute();
                }
              //  echo "<pre>";print_r($user_info);die();

                $recipient_data['message_register_id'] = $msg['id'];
                $recipient_data['user_id'] = $user_id;
                $recipient_data['created_date'] = time();
                $recipient_data['created_by'] = $user['id'];
                $recipient_data['status'] = 1;

                $this->loadModel('Recipients');
                $recipients = $this->Recipients->newEntity();
                $recipients = $this->Recipients->patchEntity($recipients, $recipient_data);
               $result= $this->Recipients->save($recipients);
               // die();
            }
        }
          if($result){
              $this->Flash->success('Bill sent and save successfully.');
              return $this->redirect(['action' => 'lists']);
          }else{
              $this->Flash->error('Bill can not save. Please try again');
              return $this->redirect(['action' => 'lists']);
          }
        }

        $departments = $this->Departments->find()->hydrate(false)
            ->select(['designations.name_bn', 'users.id', 'users.name_bn', 'Departments.name_bn'])
            ->where(['Departments.office_id' => $office_id])
            ->leftJoin('users', 'users.department_id=Departments.id and users.status=1')
            ->leftJoin('designations', 'designations.id=users.designation_id')
            ->order(['Departments.order_no' => 'asc', 'designations.order_no' => 'asc']);

            //echo "<pre>";print_r($bill_id);die();
            $this->set(compact('bill_id','departments'));


    }

//    public  function  test(){
//      return   "it's ok";
//    }
    public function labBillDetails($bill_id = null, $type = null, $reference_id = null)
    {
        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $bill_id = $this->request->data('bill_id');
            $type = $this->request->data('type');
            $reference_id = $this->request->data('reference_id');
        } else {
            $this->view = 'get_lab_bill_detail';
        }

        $this->loadModel('LabBills');
        $labBills = $this->LabBills->find()->hydrate(false)
            ->where(['LabBills.id <=' => $bill_id, 'LabBills.type' => $type, 'LabBills.reference_id' => $reference_id])
            ->contain(['LabBillDetails'=>
                function ($q) {
                    return $q->group(['LabBillDetails.lab_test_group_id','LabBillDetails.lab_bill_id'])
                        ->contain(['LabActualTests'])
                        ->autoFields(true);
                }
            ])
//            ->group(['LabBillDetails.lab_bill_id'])
            ->order(['LabBills.id' => 'desc']);

       // echo "<pre>";print_r($labBills->toArray());die();

        if ($type == 'letter') {
            $this->loadModel('LabLetterRegisters');
            $labLetter = $this->LabLetterRegisters->get($reference_id);
            $this->set(compact('labLetter'));

        } elseif ($type == 'scheme') {
            $this->loadModel('Schemes');
            $scheme = $this->Schemes->find()
                ->select(['contractors.contractor_title', 'projects.name_bn', 'Schemes.id', 'Schemes.name_bn'])
                ->where(['Schemes.id ' => $reference_id])
                ->leftJoin('projects', 'projects.id=Schemes.project_id')
                ->leftJoin('scheme_contractors', 'scheme_contractors.scheme_id=Schemes.id and scheme_contractors.is_lead=1')
                ->leftJoin('contractors', 'contractors.id=scheme_contractors.contractor_id')
                ->toArray();
            $this->set(compact('scheme'));
        }
        // echo "<pre>";print_r($labBills->toArray());die();
        $labTests = [];
        $i = 0;
        foreach ($labBills as $labBill) {
            foreach ($labBill['lab_bill_details'] as $bill_detail) {
                if ($i == 0) {
                    $labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['lab_test_short_name'] = $bill_detail['lab_actual_test']['lab_test_short_name'];
                    $labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['number_of_test'] = 0;
                    $labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['latest_number_of_test'] = $bill_detail['lab_actual_test']['number_of_test'];
                    $labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['rate'] = $bill_detail['lab_actual_test']['rate'];
                    $labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['total'] = 0;
                    $labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['latest_total'] = $bill_detail['lab_actual_test']['rate'] * $bill_detail['lab_actual_test']['number_of_test'];

                } else {
                    $lab_bill_id_test=0;
                    $labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['lab_test_short_name'] = $bill_detail['lab_actual_test']['lab_test_short_name'];
                    $labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['number_of_test'] = isset($labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['number_of_test']) ? $labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['number_of_test'] + $bill_detail['lab_actual_test']['number_of_test'] : $bill_detail['lab_actual_test']['number_of_test'];
                    //$labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['number_of_test'] =  $bill_detail['lab_actual_test']['number_of_test'];
                    $labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['latest_number_of_test'] = isset($labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['latest_number_of_test']) ? $labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['latest_number_of_test'] : 0;
                    $labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['rate'] = $bill_detail['lab_actual_test']['rate'];
                    $labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['total'] = isset($labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['total']) ? $labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['total'] + $bill_detail['lab_actual_test']['rate'] * $bill_detail['lab_actual_test']['number_of_test'] : $bill_detail['lab_actual_test']['rate'] * $bill_detail['lab_actual_test']['number_of_test'];
                    // $labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['total'] =  $bill_detail['lab_actual_test']['rate'] * $bill_detail['lab_actual_test']['number_of_test'];
                    $labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['latest_total'] = isset($labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['latest_total']) ? $labTests[$bill_detail['lab_actual_test']['lab_test_list_id']]['latest_total'] : 0;
                }
            }

            $i++;
        }

        /*echo "<pre>";
        print_r($labTests);
        echo "</pre>";
        die;*/

        $this->set(compact('labTests'));


    }

}
