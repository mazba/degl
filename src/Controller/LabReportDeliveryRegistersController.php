<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * LabReportDeliveryRegistersController Controller
 *
 * @property \App\Model\Table\TaskManagementTable $TaskManagement
 */
class LabReportDeliveryRegistersController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {

    }
    // show all lab test
    public function view($id = null)
    {
        $user = $this->Auth->user();
        // for view
        $this->loadModel('LabLetterRegisters');
        $labLetterRegisters = $this->LabLetterRegisters->find()
            ->select(['LabLetterRegisters.work_description','schemes.name_en'])
            ->leftJoin('schemes', 'schemes.id = LabLetterRegisters.scheme_id')
            ->where(['LabLetterRegisters.id'=>$id])
            ->first()
            ->toArray();
        $lab_test = TableRegistry::get('lab_test');
        $all_tests = $lab_test->find()
            ->where(['lab_test.lab_letter_registers_id'=>$id])
            ->hydrate(false)
            ->toArray();
        $this->set(compact('labLetterRegisters','id','all_tests'));
    }
    // Report Delivery save
    public function add($id = null)
    {
        $user = $this->Auth->user();
        //report delivery
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $input = $this->request->data;
            $file_upload_complete = true;
            $file_type_valid = true;

            //check file type and upload
            if(substr($_FILES["file"]["type"],0,5) == 'image')
            {
                $base_upload_path = WWW_ROOT.'files/report_delivery';
                    $tmp_name = $_FILES['file']['tmp_name'];
                    //Get the temp file path
                    if($tmp_name)
                    {
                        $name = time().'_'.str_replace(' ','_',$_FILES['file']['name']);
                        if(move_uploaded_file($tmp_name, $base_upload_path.'/'.$name))
                        {
                            $file_link = $name;
                        }
                        else
                        {
                            $file_upload_complete = false;
                        }
                    }
            }
            else
            {
                $file_upload_complete = false;
            }
            if($file_upload_complete)
            {
                // save lab report delivery
                $data = $input;
                $x=strtotime($data['date_of_delivery']);
                if($x!==false)
                {
                    $data['date_of_delivery']=$x;
                }
                else
                {
                    $data['date_of_delivery']=0;
                }
                $x = strtotime($data['sample_date']);
                if($x!==false)
                {
                    $data['sample_date']=$x;
                }
                else
                {
                    $data['sample_date']=0;
                }
                $data['lab_test_id'] = $id;
                $data['created_date'] = time();
                $data['created_by'] = $user['id'];
                $data['office_id'] = $user['office_id'];
                $data['status'] = 1;
                $data['file_link'] = $file_link;
                unset($data['file']);
                $lab_test_report_delivery_register = TableRegistry::get('lab_test_report_delivery_register');
                $query = $lab_test_report_delivery_register->query();
                $query->insert(array_keys($data))
                    ->values($data)
                    ->execute();

                // update lab test status
                $lab_test = TableRegistry::get('lab_test');
                $data = array();
                $data['report_delivery_status'] = 1;
                $query = $lab_test->query();
                $query->update()
                    ->set($data)
                    ->where(['id' => $id])
                    ->execute();
                $this->Flash->success(__('Report Delivered Successfully.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('Cannot upload the file'));
            }
        }
        // for view
        $lab_test = TableRegistry::get('lab_test')
                    ->find()
                    ->select(['lab_letter_registers.client_name','lab_letter_registers.work_description'])
                    ->leftJoin('lab_letter_registers', 'lab_letter_registers.id = lab_test.lab_letter_registers_id')
                    ->where(['lab_test.id'=>$id])
                    ->first()
                    ->toArray();
        $lab_letter_registers = $lab_test['lab_letter_registers'];
        $this->set(compact('id','client_name','lab_letter_registers'));
    }
    // Ajax
    public function ajax($action = null)
    {
        if($action == 'get_grid_data')
        {
            $user=$this->Auth->user();
            $this->loadModel('LabLetterRegisters');

            $allLabLetterRegisters = $this->LabLetterRegisters->find('all')
                ->select(['LabLetterRegisters.id','LabLetterRegisters.receive_date','LabLetterRegisters.scheme_id','LabLetterRegisters.letter_no','LabLetterRegisters.work_description','schemes.name_en','fee_setup_status'])
                ->leftJoin('schemes', 'schemes.id = LabLetterRegisters.scheme_id')
                ->where(['LabLetterRegisters.office_id'=>$user['office_id']])
                ->order(['LabLetterRegisters.id'=>'DESC'])
                ->toArray();
            $labLetterRegisters = array();
            foreach($allLabLetterRegisters as $labLetterRegister)
            {
                if(($labLetterRegister['scheme_id']) ||($labLetterRegister['fee_setup_status'] == 1))
                {
                    $labLetterRegisters[] = [
                        'id'=>$labLetterRegister['id'],
                        'receive_date'=>date('d/m/Y',$labLetterRegister['receive_date']),
                        'letter_no'=>$labLetterRegister['letter_no'],
                        'action'=>'<a class="icon-upload3" href="'.$this->request->webroot.'LabReportDeliveryRegisters/view/'.$labLetterRegister['id'].'" ><a>',
                        'scheme_or_work_description'=> (!empty($labLetterRegister['scheme_id']) ? $labLetterRegister['schemes']['name_en'] : $labLetterRegister['work_description']),
                    ];
                }
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

        $labReportDeliveryTable = TableRegistry::get('lab_test_report_delivery_register');
        $officesTable = TableRegistry::get('offices');
        if ($this->request->data('type') == 'by_date')
        {
            $start_date = strtotime($this->request->data('start_date'). '00:00:00');// TODO:check time issue
            $end_date = strtotime($this->request->data('end_date'). '23:59:59');// TODO:check time issue
            $deliveryReports = $labReportDeliveryTable->find('all')
                ->where(['date_of_delivery >='=>$start_date])
                ->where(['date_of_delivery <='=>$end_date])
                ->where(['office_id'=>$user['office_id']]);
            $office = $officesTable->find()
                ->where(['id'=>$user['office_id']])
                ->first();
        }
        else
        {
            $deliveryReports = $labReportDeliveryTable->find('all', [
                'conditions' =>[
                    'office_id'=>$user['office_id'],
                    'date_of_delivery >='=>strtotime('00:00'),// TODO:check time issue
                    'date_of_delivery <='=>strtotime('23:59'),// TODO:check time issue
                ]
            ]);
            $office = $officesTable->find()
                ->where(['id'=>$user['office_id']])
                ->first();
        }
        $this->set(compact('deliveryReports','office'));
    }
}
