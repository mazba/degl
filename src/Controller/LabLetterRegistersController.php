<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * LabLetterRegisters Controller
 *
 * @property \App\Model\Table\LabLetterRegistersTable $LabLetterRegisters
 */
class LabLetterRegistersController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {

    }

    /**
     * View method
     *
     * @param string|null $id Lab Letter Register id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user=$this->Auth->user();
        $labLetterRegister = $this->LabLetterRegisters->get($id, [
            'contain' => ['Offices', 'Schemes','CreatedUser', 'UpdatedUser']
        ]);

        $this->loadModel('Files');
        $files=$this->Files->find()
            ->select(['Files.file_path'])
            ->where(['Files.table_key'=>$labLetterRegister->resource_id,'Files.table_name'=>'receive_file_registers']);
        $this->set(compact(['labLetterRegister','files']));
        $this->set('_serialize', ['labLetterRegister']);
    }

    public function add()
    {
        $user=$this->Auth->user();
        $labLetterRegister = $this->LabLetterRegisters->newEntity();
        if ($this->request->is('post'))
        {

            $input = $this->request->data;
//            if($input['scheme_id'])
//            {
//                $data['scheme_id'] = $input['scheme_id'];
//                $data['contractor_id'] = $input['contractor_id'];
//                $data['client_name'] = $input['contractor_name'];
//            }
//            else
//            {
//                $data['client_name'] = $input['client_name'];
//                $data['client_designation'] = $input['client_designation'];
//                $data['client_phone'] = $input['client_phone'];
//                $data['client_email'] = $input['client_email'];
//                $data['client_address'] = $input['client_address'];
//            }
//

            $data['scheme_id'] = $input['scheme_id'];
            $data['office_id'] = $user['office_id'];
            $data['subject'] = $input['subject'];
            $data['letter_no'] = $input['letter_no'];
            $data['letter_date'] = strtotime($input['letter_date']);
            $data['received_from'] = $input['received_from'];
            $data['receive_date'] = strtotime($input['receive_date']);
            $data['work_description'] = $input['work_description'];
            $data['created_by']=$user['id'];
            $data['created_date']=time();

            $labLetterRegister = $this->LabLetterRegisters->patchEntity($labLetterRegister, $data);
            if ($this->LabLetterRegisters->save($labLetterRegister))
            {
                $this->Flash->success(__('The lab letter register has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The lab letter register could not be saved. Please, try again.'));
            }
        }
        $schemes = $this->LabLetterRegisters->Schemes->find('list')
            ->select(['Schemes.id'])
            ->innerJoin('project_offices', 'project_offices.project_id = Schemes.project_id')
            ->distinct(['Schemes.id'])
            ->leftJoin('projects', 'projects.id = Schemes.project_id')
            ->where(['project_offices.office_id'=>$user['office_id']])
            ->toArray();

        $this->set(compact('labLetterRegister', 'schemes'));
        $this->set('_serialize', ['labLetterRegister']);
    }

    //ajax response
    public function get_contractor_by_scheme()
    {
        $scheme_id = $this->request->data['scheme_id'];
        $scheme_contractors = TableRegistry::get('scheme_contractors');
        $data = $scheme_contractors->find()
            ->select(['contractors.contractor_title','contractors.id'])
            ->innerJoin('contractors', 'contractors.id = scheme_contractors.contractor_id')
            ->where(['scheme_id'=>$scheme_id,'is_lead'=>1])
            ->first();
        $data = $data['contractors'];
        $this->response->body(json_encode($data));
        return $this->response;
    }
    public function ajax($action = null)
    {
        if($action == 'get_grid_data')
        {
            $user = $this->Auth->user();
            $labLetterRegisters = $this->LabLetterRegisters->find('all', [
                'conditions' =>['LabLetterRegisters.status !=' => 99,'LabLetterRegisters.office_id'=>$user['office_id']],'order'=>['LabLetterRegisters.id'=>'DESC']
            ])->toArray();
            foreach($labLetterRegisters as &$labLetterRegister)
            {
                $labLetterRegister['action'] = '<a class="icon-newspaper" href="'.$this->request->webroot.'LabLetterRegisters/view/'.$labLetterRegister['id'].'" ><a>';
                $labLetterRegister['created_date'] = date('d/m/Y',$labLetterRegister['created_date']);
                $labLetterRegister['receive_date'] = date('d/m/Y',$labLetterRegister['receive_date']);
            }
//            pr($labLetterRegisters);die;

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
            $labLetterRegisters = $this->LabLetterRegisters->find()
                ->where(['created_date >='=>$start_date])
                ->where(['created_date <='=>$end_date])
                ->where(['status !='=>99,'office_id'=>$user['office_id']]);
            $office = $this->LabLetterRegisters->Offices->find()
                ->where(['id'=>$user['office_id']])
                ->first();
            $this->set(compact('labLetterRegisters','office'));
        }
        else
        {
            $labLetterRegisters = $this->LabLetterRegisters->find('all', [
                'conditions' =>[
                    'LabLetterRegisters.status !=' => 99,
                    'LabLetterRegisters.office_id'=>$user['office_id'],
                    'created_date >='=>strtotime('00:00'),// TODO:check time issue
                    'created_date <='=>strtotime('23:59'),// TODO:check time issue
                ]
            ]);
            $office = $this->LabLetterRegisters->Offices->find()
                ->where(['id'=>$user['office_id']])
                ->first();

            $this->set(compact('labLetterRegisters','office'));
        }
    }

}
