<?php
namespace App\Controller;

use Cake\ORM\TableRegistry;

/**
 * LabLetterRegisters Controller
 *
 * @property \App\Model\Table\LabLetterRegistersTable $LabLetterRegisters
 */
class TestRateAssignsController extends AppController
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
        $this->loadModel('LabTestRates');
        $testRateAssign = $this->LabTestRates->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $data['office_id'] = $user['office_id'];
            $data['created_by'] = $user['id'];
            $data['created_date'] = time();
            $data['status'] = 1;
            $testRateAssign = $this->LabTestRates->patchEntity($testRateAssign, $data);

            if ($this->LabTestRates->save($testRateAssign)) {
                $this->Flash->success(__('Test Rate Assigned Successfully.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Test Rate could not be assigned. Please, try again.'));
            }
        }

        $this->loadModel('LabTestGroup');
        $labTestGroup = $this->LabTestGroup->find('list', ['conditions' => ['status' => 1]]);

        $this->loadModel('FinancialYearEstimates');
        $financialYear = $this->FinancialYearEstimates->find('list', ['conditions' => ['status' => 1]]);

        $this->set(compact(['testRateAssign', 'labTestGroup', 'financialYear']));
        $this->set('_serialize', ['testRateAssign']);
    }

// edit lab test

    public function edit($id = null)
    {
        $user = $user = $this->Auth->user();
        $this->loadModel('LabTestRates');
        $testRateAssign = $this->LabTestRates->get($id);
        if ($this->request->is(['put', 'post', 'patch'])) {
            $data = $this->request->data;
            $data['office_id'] = $user['office_id'];
            $data['update_by'] = $user['id'];
            $data['update_date'] = time();
            $testRateAssign = $this->LabTestRates->patchEntity($testRateAssign, $data);
            if ($this->LabTestRates->save($testRateAssign)) {
                $this->Flash->success(__('Test Rate Assign Updated Successfully.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Test rate assign could not be updated. Please, try again.'));
            }
        }


        $this->loadModel('LabTestLists');
        $labTestList = $this->LabTestLists->find('list');

        $this->loadModel('FinancialYearEstimates');
        $financialYear = $this->FinancialYearEstimates->find('list');

        $this->set(compact(['testRateAssign', 'labTestList', 'financialYear']));
        $this->set('_serialize', ['testRateAssign']);
    }

    //delete test list

    public function delete($id = null)
    {
        $this->loadModel('LabTestRates');
        $testRateAssign = $this->LabTestRates->get($id);
        $delete = $this->LabTestRates->delete($testRateAssign);
        if ($delete) {
            $this->Flash->success(__('Test Rate Assign Deleted Successfully.'));
            return $this->redirect(['action' => 'index']);
        } else {
            $this->Flash->error(__('Test rate assign could not be deleted. Please, try again.'));
        }
    }

//    ajax
    public function ajax($action = null)
    {
        if ($action == 'get_grid_data') {
            $user = $this->Auth->user();
            $this->loadModel('LabTestRates');
            $labTestRates = $this->LabTestRates->find('all')
                ->autoFields(true)
                ->select(['lab_test_lists.test_full_name_en', 'financial_year_estimates.name'])
                ->leftJoin('financial_year_estimates', 'financial_year_estimates.id=LabTestRates.financial_year_estimate_id')
                ->order(['financial_year_estimates.created_date' => 'DESC'])
                ->leftJoin('lab_test_lists', 'lab_test_lists.id=LabTestRates.lab_test_list_id')
                ->toArray();
            foreach ($labTestRates as & $labTestRate) {
                $labTestRate['action'] = '<a class="icon-pencil3" href="' . $this->request->webroot . 'TestRateAssigns/edit/' . $labTestRate['id'] . '" ><a>';
                $labTestRate['action'] = $labTestRate['action'] . '&nbsp;<a class="icon-remove" href="' . $this->request->webroot . 'TestRateAssigns/delete/' . $labTestRate['id'] . '" ><a>';
                if ($labTestRate['status'] == 1) {
                    $labTestRate['status_text'] = "Active";
                } else {
                    $labTestRate['status_text'] = "Inactive";
                }
                $labTestRate['created_date'] = date('d-m-Y', $labTestRate['created_date']);
                $labTestRate['test_full_name_en'] = $labTestRate['lab_test_lists']['test_full_name_en'];
                $labTestRate['financial_year'] = $labTestRate['financial_year_estimates']['name'];

            }
            $this->response->body(json_encode($labTestRates));
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

}
