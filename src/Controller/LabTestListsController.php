<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * LabLetterRegisters Controller
 *
 * @property \App\Model\Table\LabLetterRegistersTable $LabLetterRegisters
 */
class LabTestListsController extends AppController
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
        $labTestList = $this->LabTestLists->newEntity();
        if ($this->request->is('post'))
        {
            $data = $this->request->data;
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            $data['status']=1;
            $labTestList = $this->LabTestLists->patchEntity($labTestList, $data);

            if($this->LabTestLists->save($labTestList))
            {
                $this->Flash->success(__('Lab Test Saved Successfully.'));
                return $this->redirect(['action' => 'index']);
            }else
            {
                $this->Flash->error(__('Lab Test could not be saved. Please, try again.'));
            }
        }

        $this->loadModel('LabTestGroup');
        $labTestGroups=$this->LabTestGroup->find('list');

        $this->set(compact('labTestList','labTestGroups'));
        $this->set('_serialize', ['labTestList']);
    }

// edit lab test

    public function edit($id=null)
    {
        $user = $user = $this->Auth->user();
        $labTestList=$this->LabTestLists->get($id);
        if($this->request->is(['put','post','patch']))
        {
            $data = $this->request->data;
            $data['update_by']=$user['id'];
            $data['update_date']=time();
            $labTestList = $this->LabTestLists->patchEntity($labTestList, $data);
            if($this->LabTestLists->save($labTestList))
            {
                $this->Flash->success(__('Lab Test Updated Successfully.'));
                return $this->redirect(['action' => 'index']);
            }else
            {
                $this->Flash->error(__('Lab Test could not be updated. Please, try again.'));
            }
        }
        $this->loadModel('LabTestGroup');
        $labTestGroups=$this->LabTestGroup->find('list');


        $this->set(compact('labTestList','labTestGroups'));
    }

    //delete test list

    public function delete($id=null)
    {
        $labTestList=$this->LabTestLists->get($id);
        $delete=$this->LabTestLists->delete($labTestList);
        if($delete)
        {
            $this->Flash->success(__('Lab Test Deleted Successfully.'));
            return $this->redirect(['action' => 'index']);
        }else
        {
            $this->Flash->error(__('Lab Test could not be deleted. Please, try again.'));
        }
    }

//    ajax
    public function ajax($action = null)
    {
        if($action == 'get_grid_data')
        {
            $user = $this->Auth->user();
            $this->loadModel('LabTestLists');
            $labTestLists=$this->LabTestLists->find('all')
                ->contain(['LabTestGroup'])
                ->order(['LabTestLists.id'=>'DESC'])
                ->toArray();
            foreach($labTestLists as & $labTestList)
            {
                $labTestList['action'] = '<a class="icon-pencil3" href="'.$this->request->webroot.'LabTestLists/edit/'.$labTestList['id'].'" ><a>';
                $labTestList['action'] =  $labTestList['action'] .'&nbsp;<a class="icon-remove" href="'.$this->request->webroot.'LabTestLists/delete/'.$labTestList['id'].'" ><a>';
                if($labTestList['status']==1)
                {
                    $labTestList['status_text']="Active";
                }else
                {
                    $labTestList['status_text']="Inactive";
                }
                $labTestList['lab_test_group_name']=$labTestList['lab_test_group']['name_en'];


            }


            $this->response->body(json_encode($labTestLists));
            return $this->response;
        }

    }
    //    Print report
    public function print_it()
    {
        $user = $this->Auth->user();
        $this->layout='print';
        $this->view='print';
        if ($this->request->data('type') == 'by_date')
        {
            $start_date = strtotime($this->request->data('start_date'). '00:00:00 GMT');// TODO:check time issue
            $end_date = strtotime($this->request->data('end_date'). '23:59:59 GMT');// TODO:check time issue

            $labTestFeeRegisterTable = TableRegistry::get('lab_test_fee_registers');
            $labTestFeeRegisters =$labTestFeeRegisterTable->find()
                ->autoFields(true)
                ->select(['schemes.name_en','schemes.name_bn','lab_letter_registers.work_description'])
                ->where([
                    'lab_test_fee_registers.payment_date >='=>$start_date,
                    'lab_test_fee_registers.payment_date <='=>$end_date,
                    'lab_test_fee_registers.status !='=>99,
                    'lab_letter_registers.office_id'=>$user['office_id']
                ])
                ->leftJoin('lab_letter_registers','lab_letter_registers.id = lab_test_fee_registers.lab_letter_registers_id')
                ->leftJoin('schemes','schemes.id = lab_letter_registers.scheme_id');
            // OFFICE
            $officeTable = TableRegistry::get('offices');
            $office = $officeTable->find()
                ->where(['id'=>$user['office_id']])
                ->first();
            $this->set(compact('labTestFeeRegisters','office'));
        }
        else
        {
            $labTestFeeRegisterTable = TableRegistry::get('lab_test_fee_registers');
            $labTestFeeRegisters =$labTestFeeRegisterTable->find()
                ->autoFields(true)
                ->select(['schemes.name_en','schemes.name_bn','lab_letter_registers.work_description'])
                ->where([
                    'lab_test_fee_registers.payment_date >='=>strtotime('00:00'),
                    'lab_test_fee_registers.payment_date <='=>strtotime('23:59'),
                    'lab_test_fee_registers.status !='=>99,
                    'lab_letter_registers.office_id'=>$user['office_id']
                ])
                ->leftJoin('lab_letter_registers','lab_letter_registers.id = lab_test_fee_registers.lab_letter_registers_id')
                ->leftJoin('schemes','schemes.id = lab_letter_registers.scheme_id');

            //OFFICE
            $officeTable = TableRegistry::get('offices');
            $office = $officeTable->find()
                ->where(['id'=>$user['office_id']])
                ->first();

            $this->set(compact('labTestFeeRegisters','office'));
        }
    }

}
