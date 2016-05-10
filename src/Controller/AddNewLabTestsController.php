<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * LabLetterRegisters Controller
 *
 * @property \App\Model\Table\LabLetterRegistersTable $LabLetterRegisters
 */
class AddNewLabTestsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {

    }

    // add lab test
    public function add($id = null)
    {
        $user = $user = $this->Auth->user();
        $this->loadModel('LabActualTests');

        if ($this->request->is('post')) {
            $inputs = $this->request->data;
            $i = 0;
            $flag = 0;
            for ($i; $i < count($inputs['rate']); $i++) {
                $data = array();
                $data['lab_letter_registers_id'] = $inputs['lab_letter_registers_id'];
                if(!empty($inputs['scheme_id'])){
                    $data['scheme_id'] = $inputs['scheme_id'];
                }
                $data['office_id'] = $user['office_id'];
                $data['lab_test_list_id'] = $inputs['lab_test_list_id'][$i];
                $data['financial_year'] = $inputs['financial_year'][$i];
                $data['lab_test_short_name'] = $inputs['lab_test_short_name'][$i];
                $data['lab_test_full_name'] = $inputs['lab_test_full_name'][$i];
                $data['rate'] = $inputs['rate'][$i];
                $data['number_of_test'] = $inputs['number_of_test'][$i];
                $data['created_by'] = $user['id'];
                $data['created_date'] = time();
                $data['status'] = 1;
                $labTest = $this->LabActualTests->newEntity();
                $labTest = $this->LabActualTests->patchEntity($labTest, $data);
                if ($this->LabActualTests->save($labTest)) {
                    $flag = 1;
                } else {
                    $flag = 0;
                }

            }


            if ($flag) {
                $this->Flash->success(__('Lab Test Saved Successfully.'));
                return $this->redirect(['controller' => 'LabLetterRegisters', 'action' => 'view', $inputs['lab_letter_registers_id']]);
            } else {
                $this->Flash->error(__('Lab Test could not be saved. Please, try again.'));
            }
        }
        $this->loadModel('LabLetterRegisters');
        $labLetterRegister = $this->LabLetterRegisters->get($id, [
            'contain' => ['Offices', 'Schemes', 'CreatedUser', 'UpdatedUser']
        ]);

        $this->loadModel('LabTestGroup');
        $labTestGroups = $this->LabTestGroup->find('list', ['conditions' => ['status'=>1]]);
        $labTest = $this->LabActualTests->newEntity();
        $this->set(compact(['labTest', 'labLetterRegister', 'labTestGroups']));
        $this->set('_serialize', ['labTestList']);
    }


    // view lab test

    public function view($id = null)
    {


        $this->loadModel('LabLetterRegisters');
        $labLetterRegister = $this->LabLetterRegisters->get($id, [
            'contain' => ['Offices', 'Schemes', 'CreatedUser', 'UpdatedUser']
        ]);

        $this->loadModel('LabActualTests');
        $tests = $this->LabActualTests->find()
            ->autoFields(true)
            ->select(['file_path'=>'lab_test_reports.file_path'])
            ->where(['LabActualTests.lab_letter_registers_id' => $id])
            ->leftJoin('lab_test_reports','lab_test_reports.lab_actual_test_id=LabActualTests.id')
            ->toArray();

        $this->set(compact(['labLetterRegister', 'tests']));
        $this->set('_serialize', ['labTestList']);
    }

// edit lab test

    public function edit($id = null)
    {
        $user = $user = $this->Auth->user();
        $inputs = $this->request->data;
        $i=0;
        foreach($inputs['report'] as $value)
        {
            $files = array();
            foreach($value as $image)
            {
                if($image['tmp_name'])
                {
                    $base_upload_path = WWW_ROOT . 'files/lab_test_files';
                    $name = time() . '_' . str_replace(' ', '_', $image['name']);
                    if (move_uploaded_file($image['tmp_name'], $base_upload_path . '/' . $name)) {
                        $files[]['file_path'] = $name;
                    }
                }
            }

            $files_table = TableRegistry::get('lab_test_reports');
            foreach ($files as $file) {
                $file_data = array();
                $file_data['file_path'] = $file['file_path'];
                $file_data['lab_actual_test_id'] = $inputs['test_id'][$i];
                $file_data['created_by'] = $user['id'];
                $file_data['created_date'] = time();
                $file_data['status'] = 1;
                $file_query = $files_table->query();
                $file_query->insert(array_keys($file_data))
                    ->values($file_data)
                    ->execute();
            }
            $this->loadModel('LabActualTests');
            $labTest=$this->LabActualTests->get($inputs['test_id'][$i]);
            $data['is_ok']=$inputs['is_ok'][$i];
            $labTest=$this->LabActualTests->patchEntity($labTest,$data);
            $this->LabActualTests->save($labTest);


            $i++;
        }

        return $this->redirect(['controller' => 'AddNewLabTests', 'action' => 'view', $id]);


    }

    //delete test list

    public function delete($id = null)
    {
        $labTestList = $this->LabTestLists->get($id);
        $delete = $this->LabTestLists->delete($labTestList);
        if ($delete) {
            $this->Flash->success(__('Lab Test Deleted Successfully.'));
            return $this->redirect(['action' => 'index']);
        } else {
            $this->Flash->error(__('Lab Test could not be deleted. Please, try again.'));
        }
    }

//    ajax
    public function ajax($action = null)
    {
        if ($action == 'get_grid_data') {
            $user = $this->Auth->user();
            $this->loadModel('LabTestLists');
            $labTestLists = $this->LabTestLists->find('all')
                ->order(['LabTestLists.id' => 'DESC'])
                ->toArray();
            foreach ($labTestLists as & $labTestList) {
                $labTestList['action'] = '<a class="icon-pencil3" href="' . $this->request->webroot . 'LabTestLists/edit/' . $labTestList['id'] . '" ><a>';
                $labTestList['action'] = $labTestList['action'] . '&nbsp;<a class="icon-remove" href="' . $this->request->webroot . 'LabTestLists/delete/' . $labTestList['id'] . '" ><a>';
                if ($labTestList['status'] == 1) {
                    $labTestList['status_text'] = "Active";
                } else {
                    $labTestList['status_text'] = "Inactive";
                }

            }
            $this->response->body(json_encode($labTestLists));
            return $this->response;
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

    public function getFinancialYear()
    {
        $test_id = $this->request->data['test_id'];
        $this->loadModel('LabTestRates');
        $results = $this->LabTestRates->find()
            ->select(['financial_year_estimates.id', 'financial_year_estimates.name'])
            ->where(['LabTestRates.lab_test_list_id' => $test_id])
            ->leftJoin('financial_year_estimates', 'financial_year_estimates.id=LabTestRates.financial_year_estimate_id')
            ->toArray();

        $data = [];
        $i = 0;
        foreach ($results as $result) {
            $data[$i]['id'] = $result['financial_year_estimates']['id'];
            $data[$i]['name'] = $result['financial_year_estimates']['name'];
            $i++;
        }

        $this->response->body(json_encode($data));
        return $this->response;

    }

    public function getRate()
    {
        $financial_year_id = $this->request->data['financial_year_id'];
        $lab_test_id = $this->request->data['lab_test_id'];
        $this->loadModel('LabTestRates');
        $results = $this->LabTestRates->find()
            ->select(['financial_year_estimates.name', 'lab_test_lists.test_short_name_en', 'lab_test_lists.test_full_name_en', 'LabTestRates.rate'])
            ->where(['LabTestRates.financial_year_estimate_id' => $financial_year_id,'LabTestRates.lab_test_list_id' => $lab_test_id])
            ->leftJoin('lab_test_lists', 'lab_test_lists.id=LabTestRates.lab_test_list_id')
            ->leftJoin('financial_year_estimates', 'financial_year_estimates.id=LabTestRates.financial_year_estimate_id')
            ->first()
            ->toArray();
        $this->response->body(json_encode($results));
        return $this->response;

    }

    //report test

    public function report($id = null)
    {


        $this->loadModel('LabLetterRegisters');
        $labLetterRegister = $this->LabLetterRegisters->get($id, [
            'contain' => ['Offices', 'Schemes', 'CreatedUser', 'UpdatedUser']
        ]);

        $this->loadModel('Schemes');
        $scheme = $this->Schemes->find()
            ->select(['contractors.contractor_title', 'projects.name_bn', 'Schemes.id', 'Schemes.name_bn'])
            ->where(['Schemes.id' => $labLetterRegister->scheme_id])
            ->leftJoin('projects', 'projects.id=Schemes.project_id')
            ->leftJoin('scheme_contractors', 'scheme_contractors.scheme_id=Schemes.id and scheme_contractors.is_lead=1')
            ->leftJoin('contractors', 'contractors.id=scheme_contractors.contractor_id')
            ->toArray();

        $this->loadModel('LabActualTests');
        $tests = $this->LabActualTests->find()
            ->autoFields(true)
            ->where(['LabActualTests.lab_letter_registers_id' => $id])
            ->toArray();

        $this->set(compact(['labLetterRegister', 'tests','scheme']));
        $this->set('_serialize', ['labTestList']);
    }

}
