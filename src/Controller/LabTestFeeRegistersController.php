<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * LabLetterRegisters Controller
 *
 * @property \App\Model\Table\LabLetterRegistersTable $LabLetterRegisters
 */
class LabTestFeeRegistersController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {

    }
    // add fee
    public function add($id = null)
    {
        $user = $user = $this->Auth->user();
        if ($this->request->is(['patch', 'post', 'put']))
        {
            //
            $data = $this->request->data;
            $data['lab_letter_registers_id'] = $id;
            $data['payment_date'] = strtotime($data['payment_date']);
            $data['created_by'] = $user['id'];
            $data['created_date'] = time();
            $data['status'] = 1;
            $lab_test_fee_registers = TableRegistry::get('lab_test_fee_registers');
            $query = $lab_test_fee_registers->query();
            $query->insert(array_keys($data))
                ->values($data)
                ->execute();

            //update the fee setup status
            $this->loadModel('LabLetterRegisters');
            $LabLetterRegisters['fee_setup_status'] = 1;
            $query = $this->LabLetterRegisters->query();
            $query->update()
                ->set($LabLetterRegisters)
                ->where(['id' => $id])
                ->execute();

            $this->Flash->success(__('Fee Register Saved Successfully.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->loadModel('LabLetterRegisters');
        $labLetterRegisters = $this->LabLetterRegisters->find()
            ->select(['LabLetterRegisters.work_description','schemes.name_en'])
            ->leftJoin('schemes', 'schemes.id = LabLetterRegisters.scheme_id')
            ->where(['LabLetterRegisters.id'=>$id])
            ->first()
            ->toArray();

        $this->set(compact('labLetterRegisters','id'));
    }
//    ajax
    public function ajax($action = null)
    {
        if($action == 'get_grid_data')
        {
            $user = $this->Auth->user();
            $this->loadModel('LabLetterRegisters');
            $labLetterRegisters = $this->LabLetterRegisters->find('all')
                ->select(['LabLetterRegisters.receive_date','LabLetterRegisters.received_from','LabLetterRegisters.id','LabLetterRegisters.letter_no','LabLetterRegisters.work_description','schemes.name_en','fee_setup_status'])
                ->leftJoin('schemes', 'schemes.id = LabLetterRegisters.scheme_id')
                ->where(['LabLetterRegisters.fee_setup_status !='=>1,'LabLetterRegisters.office_id'=>$user['office_id']])
                ->order(['LabLetterRegisters.id'=>'DESC'])
                ->toArray();
            foreach($labLetterRegisters as &$labLetterRegister)
            {
                $labLetterRegister['schemes_or_work_description'] = (!empty($labLetterRegister['work_description']) ? $labLetterRegister['work_description'] : $labLetterRegister['schemes']['name_en']);
                $labLetterRegister['receive_date'] = date('d-m-Y',$labLetterRegister['receive_date']);
                $labLetterRegister['action'] = '<a class="icon-paypal2" href="'.$this->request->webroot.'LabTestFeeRegisters/add/'.$labLetterRegister['id'].'" ><a>';
            }
            $this->response->body(json_encode($labLetterRegisters));
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
