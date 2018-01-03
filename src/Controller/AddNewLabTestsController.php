<?php
namespace App\Controller;

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
            //  echo "<pre>";print_r($inputs);die();
            // $i = 0;
            $flag = 0;
            for ($i=0; $i < count($inputs['rate']); $i++) {
                $time= time();
                for ($j = 1; $j <= $inputs['number_of_test'][$i]; $j++) {
                    $data = array();
                    $data['lab_letter_registers_id'] = $inputs['lab_letter_registers_id'];
                    if (!empty($inputs['scheme_id'])) {
                        $data['scheme_id'] = $inputs['scheme_id'];
                    }
                    $data['office_id'] = $user['office_id'];
                    $data['lab_test_group_id'] = $inputs['lab_test_group_id'][$i];
                    $data['lab_test_list_id'] = $inputs['lab_test_list_id'][$i];
                    $data['financial_year'] = $inputs['financial_year'][$i];
                    $data['lab_test_short_name'] = $inputs['lab_test_short_name'][$i];
                    $data['lab_test_full_name'] = $inputs['lab_test_full_name'][$i];
                    $data['rate'] = $inputs['rate'][$i];
                    $data['number_of_test'] = $inputs['number_of_test'][$i];
                    $data['created_by'] = $user['id'];
                    $data['created_date'] = $time;
                    $data['status'] = 1;
                    $labTest = $this->LabActualTests->newEntity();
                    $labTest = $this->LabActualTests->patchEntity($labTest, $data);
                    if ($this->LabActualTests->save($labTest)) {
                        $flag = 1;
                    } else {
                        $flag = 0;
                    }
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
        $labTestGroups = $this->LabTestGroup->find('list', ['conditions' => ['status' => 1]]);
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
            ->select(['file_path' => 'lab_test_reports.file_path'])
            ->where(['LabActualTests.lab_letter_registers_id' => $id])
            ->leftJoin('lab_test_reports', 'lab_test_reports.lab_actual_test_id=LabActualTests.id')
            ->toArray();

        $this->set(compact(['labLetterRegister', 'tests']));
        $this->set('_serialize', ['labTestList']);
    }

// edit lab test

    public function edit($id = null)
    {
        $user = $user = $this->Auth->user();
        $inputs = $this->request->data;
        $i = 0;
        foreach ($inputs['report'] as $value) {
            $files = array();
            foreach ($value as $image) {
                if ($image['tmp_name']) {
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
            $labTest = $this->LabActualTests->get($inputs['test_id'][$i]);
            $data['is_ok'] = $inputs['is_ok'][$i];
            $labTest = $this->LabActualTests->patchEntity($labTest, $data);
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

    public function get_previous_number_of_test(){
        $this->loadModel('LabActualTests');
        $data=$this->request->data;
        if($data['scheme_id']){
            $tests = $this->LabActualTests->find()
                ->select(['test_number' => 'number_of_test'])
                ->autoFields(false)
                ->where(['scheme_id'=>$data['scheme_id'],'lab_test_group_id'=>$data['lab_test_group'],'lab_test_list_id' => $data['test_list_id']])
                ->group(['lab_test_group_id','lab_test_list_id','created_date'])
                ->toArray();
            //  echo "<pre>";print_r($tests);die();

            $total=0;
            foreach($tests as $test){
                $total+= $test['test_number'];
            }
            // echo $total;die();
            $this->response->body(json_encode($total));
            return $this->response;

        }else{
            $tests = $this->LabActualTests->find()
                ->select(['test_number' => 'number_of_test'])
                ->autoFields(false)
                ->where(['lab_letter_registers_id'=>$data['lab_letter_registers_id'],'lab_test_group_id'=>$data['lab_test_group'],'lab_test_list_id' => $data['test_list_id']])
                ->group(['lab_test_group_id','lab_test_list_id','created_date'])
                ->toArray();
            //  echo "<pre>";print_r($tests);die();

            $total=0;
            foreach($tests as $test){
                $total+= $test['test_number'];
            }
            //  echo $total;die();
            $this->response->body(json_encode($total));
            return $this->response;

        }
    }

    public function getRate()
    {
        $financial_year_id = $this->request->data['financial_year_id'];
        $lab_test_id = $this->request->data['lab_test_id'];
        $this->loadModel('LabTestRates');
        $results = $this->LabTestRates->find()
            ->select(['financial_year_estimates.name', 'lab_test_lists.test_short_name_en', 'lab_test_lists.test_full_name_en', 'LabTestRates.rate'])
            ->where(['LabTestRates.financial_year_estimate_id' => $financial_year_id, 'LabTestRates.lab_test_list_id' => $lab_test_id])
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
        if ($labLetterRegister->scheme_id) {
            $this->loadModel('Schemes');
            $scheme = $this->Schemes->find()
                ->select(['contractors.contractor_title', 'projects.name_bn', 'Schemes.id', 'Schemes.name_bn'])
                ->where(['Schemes.id' => $labLetterRegister->scheme_id])
                ->leftJoin('projects', 'projects.id=Schemes.project_id')
                ->leftJoin('scheme_contractors', 'scheme_contractors.scheme_id=Schemes.id and scheme_contractors.is_lead=1')
                ->leftJoin('contractors', 'contractors.id=scheme_contractors.contractor_id')
                // ->group(['Articles.id'])
                ->toArray();

            $this->loadModel('LabActualTests');
            $tests = $this->LabActualTests->find()
                ->select(['LabActualTests' => 'lab_test_short_name', 'lab_test_group' => 'name_en'])
                ->autoFields(true)
                ->where(['LabActualTests.lab_letter_registers_id' => $id,'LabActualTests.scheme_id' => $labLetterRegister->scheme_id])
                ->leftJoin('lab_test_group', 'lab_test_group.id=LabActualTests.lab_test_group_id')
                ->group(['LabActualTests.lab_test_list_id','LabActualTests.created_date'])
                ->toArray();
        } else {
            $scheme = "";

            $this->loadModel('LabActualTests');
            $tests = $this->LabActualTests->find()
                ->select(['LabActualTests' => 'lab_test_short_name', 'lab_test_group' => 'name_en'])
                ->autoFields(true)
                ->where(['LabActualTests.lab_letter_registers_id' => $id])
                ->where(function ($exp, $q) {
                    return $exp->isNull('LabActualTests.scheme_id');
                })
                ->leftJoin('lab_test_group', 'lab_test_group.id=LabActualTests.lab_test_group_id')
                ->group(['LabActualTests.lab_test_list_id','LabActualTests.created_date'])
                ->toArray();
//            pr($tests);die;
        }


        $this->set(compact(['labLetterRegister', 'tests', 'scheme']));
        $this->set('_serialize', ['labTestList']);
    }

    public function getTestNumber()
    {
        $inputs = $this->request->data;
        //  print_r($inputs);die();
        $this->loadModel('LabTestFrequency');
        $labTestFrequency = $this->LabTestFrequency->find('all', ['conditions' => ['lab_test_group_id' => $inputs['lab_test_group'], 'lab_test_list_id' => $inputs['testList']]])->first();

        $arr = [];
        if ($labTestFrequency) {
            if ($inputs['work_done_quantity'] <= $labTestFrequency->per_unit) {
                $arr['test_needed'] = $labTestFrequency->test_no;
                $arr['test_no_type'] = $labTestFrequency->test_no_type ? $labTestFrequency->test_no_type : 0;
            } else {
                $test_needed = $inputs['work_done_quantity'] / $labTestFrequency->per_unit;
                $whole = (int)$test_needed;
                $frac = $test_needed - (int)$test_needed;
                if ($frac > .2) {
                    $test = $whole + 1;
                } else {
                    $test = $whole;
                }
                $arr['test_needed'] = $test;
                $arr['test_no_type'] = $labTestFrequency->test_no_type ? $labTestFrequency->test_no_type : 0;
            }

        }

        $this->response->body(json_encode($arr));
        return $this->response;
    }

    /*
     * Total report
     */
    public function total(){

        if($this->request->is('post')){
            $data = $this->request->data();
            $date_from = strtotime($data['date_from']);
            $date_from = strtotime(date('Y-m-d 00:00:01', $date_from));
            $date_to = strtotime($data['date_to']);
            $date_to = strtotime(date('Y-m-d 23:59:59', $date_to));
            $this->loadModel('LabActualTests');
            $query = $this->LabActualTests->find();
            $query = $query->select([
				'id' => 'LabActualTests.id',
                'rate' => 'LabActualTests.rate',
                'number_of_test' => $query->func()->sum('LabActualTests.number_of_test'),
                'lab_test_short_name' => 'LabActualTests.lab_test_short_name',
                'group_name' => 'lab_test_group.name_en',
                'test_count' => $query->func()->count('LabActualTests.id')
            ])
			->where([
			'LabActualTests.created_date >=' =>$date_from, 
			'LabActualTests.created_date <=' => $date_to,
			'LabActualTests.status ' => 1
			])
			->order(['LabActualTests.id' => 'ASC'])
                ->leftJoin('lab_test_group', 'lab_test_group.id=LabActualTests.lab_test_group_id');
            $results = $query->group(['lab_test_list_id'])->hydrate(false)->toArray();
            $this->set(compact('results'));
        }

    }

}
