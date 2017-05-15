<?php
namespace App\Controller;

use Cake\ORM\Query;
use Cake\ORM\TableRegistry;

/**
 * NothiRegisters Controller
 *
 * @property \App\Model\Table\NothiRegistersTable $NothiRegisters
 */
class NothiRegistersController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $user = $this->Auth->user();
        if ($user['user_group_id'] == 1) {
            $nothiRegisters = $this->NothiRegisters->find('all', [
                'conditions' => ['NothiRegisters.status !=' => 99, 'parent_id' => 0],
                'contain' => ['Offices', 'Projects', 'Schemes'],
                'order' => ['NothiRegisters.created_date' => 'desc']
            ]);
        } else {
            $nothiRegisters = $this->NothiRegisters->find('all', [
                'conditions' => ['NothiRegisters.status !=' => 99, 'NothiRegisters.office_id' => $user['office_id'], 'parent_id' => 0],
                'contain' => ['Offices', 'Projects', 'Schemes'],
                'order' => ['NothiRegisters.created_date' => 'desc']
            ]);
        }

        $this->set('nothiRegisters', $nothiRegisters);
        $this->set('_serialize', ['nothiRegisters']);
    }

    /**
     * View method
     *
     * @param string|null $id Nothi Register id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
//    public function view($id = null)
//    {
//        $this->loadModel('NothiAssigns');
//
//        $query = $this->NothiAssigns->find('all')
//            ->where(['NothiAssigns.nothi_register_id =' => $id])
//            ->contain(['NothiRegisters', 'Schemes']);
//        $nothiRegister=$query->first();
    //echo "<pre>";print_r($nothiRegister);die();
//        $this->set('nothiRegister', $nothiRegister);
//        $this->set('_serialize', ['nothiRegister']);
//    }

    public function view($id = null)
    {
        ini_set('max_execution_time', 300);
        $this->loadModel('SchemeProgresses');
        $schemeProgress = $this->SchemeProgresses->newEntity();
        $user=$this->Auth->user();
        if ($this->request->is('post'))
        {

            $data=$this->request->data;
          //  echo "<pre>";print_r($data);die();
            $data['office_id']=$user['office_id'];
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            $scheme=TableRegistry::get('SchemeProgresses');
            $query=$scheme->query();
            $query->update()
                ->set(['status'=>0])
                ->where(['scheme_id'=>$data['scheme_id']])
                ->execute();

            $schemeProgress = $this->SchemeProgresses->patchEntity($schemeProgress, $data);
            if ($this->SchemeProgresses->save($schemeProgress))
            {
                $this->Flash->success(__('The scheme progress has been saved.'));
                return $this->redirect(['action' => 'view',$id]);
            }
            else
            {
                $this->Flash->error(__('The scheme progress could not be saved. Please, try again.'));
            }
        }
        $this->loadModel('NothiAssigns');

        $nothiRegister = $this->NothiRegisters->get($id, [
            'contain' => ['Offices', 'Projects', 'NothiRegister']
        ]);

        $query = $this->NothiAssigns->find('all')
            ->where(['NothiAssigns.nothi_register_id =' => $id])
            ->contain(
                [
                    'Schemes' => [
                        'Packages',
                        'Upazilas',
                        'FinancialYearEstimates',
                        'SchemeProgresses' =>
                            function ($q) {
                                return $q
                                    ->where(['SchemeProgresses.status' => 1])
                                    ->limit(1);
                            }
                    ]]);

        $nothiNothiAssigns = $query->first();


        $asset_list=$this->NothiAssigns->find('all')
            ->where(['nothi_register_id ' => $id])
            ->contain('Assets')
            ->toArray();

//10-nov-2016 by Sylvester Antu Rozario

        $nothi_related_scheme=$this->NothiAssigns->find('all')
            ->where(['nothi_register_id ' => $id,'scheme_id >'=> 0])
            ->toArray();

        $nothi_related_dake_file=$this->NothiAssigns->find('all')
            ->where(['nothi_register_id ' => $id,'receive_file_register_id >'=> 0])
            ->toArray();

        // added by Durjoy
        if($nothi_related_dake_file){

            $this->loadModel('ReceiveFileRegisters');
            $this->loadModel('LetterApprovals');
            $this->loadModel('Users');
            $querys_data = $this->ReceiveFileRegisters->find()
//                ->select([
//                    'ReceiveFileRegisters.subject',
//                    'ReceiveFileRegisters.sender_name',
//                    'ReceiveFileRegisters.sender_office_name',
//                    'ReceiveFileRegisters.sarok_no',
//                    'ReceiveFileRegisters.letter_date',
//                    'ReceiveFileRegisters.letter_description',
//                    'LetterIssueRegisters.subject',
//                    'LetterIssueRegisters.reminder_number',
//                    'LetterIssueRegisters.created_date',
//                    'LetterIssueRegisters.description',
//                    'MessageRegisters.id',
//                    'files.file_path',
////                    'Users.user_signature',
//                ])
//                ->autoFields(true)
                ->leftJoin('nothi_assigns', 'ReceiveFileRegisters.id=nothi_assigns.receive_file_register_id')
                ->contain(['LetterIssueRegisters','LetterApprovals.Users','Files', 'MessageRegisters' ])
//                ->leftJoin('files', 'files.table_key = ReceiveFileRegisters.id' )
                ->where(['nothi_assigns.nothi_register_id' => $id])
                ->where(['Files.table_name' => 'receive_file_registers'])
                ->order(['ReceiveFileRegisters.created_date' => 'asc'])
//                ->hydrate(false)
                ->toArray();
//            pr($querys_data);die;
        }

        $nothi_related_project=$this->NothiAssigns->find('all')
            ->where(['nothi_register_id ' => $id,'project_id >'=> 0])
            ->toArray();

        $nothi_related_lab_bill=$this->NothiAssigns->find('all')
            ->where(['nothi_register_id ' => $id,'lab_bill_id >'=> 0])
            ->toArray();

        $nothi_related_hire_charge=$this->NothiAssigns->find('all')
            ->where(['nothi_register_id ' => $id,'hire_charge_id >'=> 0])
            ->toArray();

        $nothi_related_purto_bill=$this->NothiAssigns->find('all')
            ->where(['nothi_register_id ' => $id,'purto_bill_id >'=> 0])
            ->toArray();
        $nothi_related_allotment_registe=$this->NothiAssigns->find('all')
            ->where(['nothi_register_id ' => $id,'allotment_register_id >'=> 0])
            ->toArray();


     //  echo "<pre>";print_r($nothi_related_scheme);die();
        //echo "<pre>";print_r($nothiNothiAssigns);die();
        // Investigation report part
        $project_images = TableRegistry::get('project_images')->find('all');
        $project_images->select(['users.name_bn', 'users.picture']);
        $project_images->autoFields(true);

            $project_images->where(['project_images.scheme_id' => $nothiNothiAssigns['scheme']['id']]);

        //  $project_images->where(['project_images.project_id'=>$input['project_id']]);
        $project_images->leftJoin('users', 'users.id=project_images.created_by');
        $project_images = $project_images->toArray();
        // echo "<pre>";print_r($project_images);die();
        $project_videos = TableRegistry::get('project_videos')->find('all');
        $project_videos->select(['users.name_bn', 'users.picture']);
        $project_videos->autoFields(true);
            $project_videos->where(['project_videos.scheme_id' => $nothiNothiAssigns['scheme']['id']]);

        // $project_videos->where(['project_videos.project_id'=>$input['project_id']]);
        $project_videos->leftJoin('users', 'users.id=project_videos.created_by');
        $project_videos = $project_videos->toArray();

        //get employee details
        $employee_details= $this->NothiAssigns->find('all');
        $employee_details->select(['employees.id', 'employees.name_en','employees.name_bn','designations.name_bn','offices.name_bn']);
        $employee_details->where(['NothiAssigns.nothi_register_id' => $id]);
        $employee_details->innerJoin('employees', 'employees.id = NothiAssigns.employee_id');
        $employee_details->innerJoin('designations', 'designations.id = employees.designation_id');
        $employee_details->innerJoin('offices', 'offices.id = employees.office_id');
        $employee_details=$employee_details->toArray();

        //echo "<pre>";print_r($employee_details);die();
        $this->set(compact('nothi_related_scheme','nothi_related_dake_file','nothi_related_project','nothi_related_lab_bill','nothi_related_hire_charge','nothi_related_purto_bill','nothi_related_allotment_registe','asset_list','nothiRegister', 'nothiNothiAssigns', 'project_images', 'project_videos','schemeProgress','employee_details','querys_data'));
        //$this->set('nothiRegister', $nothiRegister);
        $this->set('_serialize', ['nothiRegister']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $nothiRegister = $this->NothiRegisters->newEntity();
        $user = $this->Auth->user();
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $x = strtotime($data['nothi_date']);
            if ($x !== false) {
                $data['nothi_date'] = $x;
            } else {
                $data['nothi_date'] = 0;
            }

            $data['office_id'] = $user['office_id'];
            $data['created_by'] = $user['id'];
            $data['created_date'] = time();
            $nothiRegister = $this->NothiRegisters->patchEntity($nothiRegister, $data);
            if ($this->NothiRegisters->save($nothiRegister)) {
                $this->Flash->success(__('The nothi register has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The nothi register could not be saved. Please, try again.'));
            }
        }
        //$offices = $this->NothiRegisters->Offices->find('list');
        if ($user['user_group_id'] == 1) {
            $projects = $this->NothiRegisters->Projects->find('list');
            $schemes = $this->NothiRegisters->Schemes->find('list');
        } else {
            $projects = $this->NothiRegisters->Projects->find('list')
                ->innerJoin('project_offices', 'project_offices.project_id = Projects.id')
                ->where(['project_offices.office_id' => $user['office_id']]);

            $schemes = $this->NothiRegisters->Schemes->find('list')
                ->innerJoin('project_offices', 'project_offices.project_id = Schemes.project_id')
                ->leftJoin('projects', 'projects.id = Schemes.project_id')
                ->where(['project_offices.office_id' => $user['office_id']]);
        }

        $nothiRegisters = $this->NothiRegisters->find('list', ['conditions' => ['parent_id' => 0, 'status !=' => 99], 'fields' => ['id', 'nothi_no']]);

        $this->set(compact('nothiRegister', 'nothiRegisters', 'offices', 'projects', 'schemes'));
        $this->set('_serialize', ['nothiRegister']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Nothi Register id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $nothiRegister = $this->NothiRegisters->get($id, [
            'contain' => []
        ]);
        $user = $this->Auth->user();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->data;

            $data = $this->request->data;
            $x = strtotime($data['nothi_date']);
            if ($x !== false) {
                $data['nothi_date'] = $x;
            } else {
                $data['nothi_date'] = 0;
            }
            $data['updated_by'] = $user['id'];
            $data['updated_date'] = time();
            $nothiRegister = $this->NothiRegisters->patchEntity($nothiRegister, $data);
            if ($this->NothiRegisters->save($nothiRegister)) {
                $this->Flash->success(__('The nothi register has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The nothi register could not be saved. Please, try again.'));
            }
        }
        //$offices = $this->NothiRegisters->Offices->find('list');
        if ($user['user_group_id'] == 1) {
            $projects = $this->NothiRegisters->Projects->find('list');
            $schemes = $this->NothiRegisters->Schemes->find('list');
        } else {
            $projects = $this->NothiRegisters->Projects->find('list')
                ->innerJoin('project_offices', 'project_offices.project_id = Projects.id')
                ->where(['project_offices.office_id' => $user['office_id']]);

            $schemes = $this->NothiRegisters->Schemes->find('list')
                ->innerJoin('project_offices', 'project_offices.project_id = Schemes.project_id')
                ->leftJoin('projects', 'projects.id = Schemes.project_id')
                ->where(['project_offices.office_id' => $user['office_id']]);

        }
        $nothiRegisters = $this->NothiRegisters->find('list', ['conditions' => ['parent_id' => 0], 'fields' => ['id', 'nothi_no']]);
        $this->set(compact('nothiRegister', 'nothiRegisters', 'offices', 'projects', 'schemes'));
        $this->set('_serialize', ['nothiRegister']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Nothi Register id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $nothiRegister = $this->NothiRegisters->get($id);

        $user = $this->Auth->user();
        $data = $this->request->data;
        $data['updated_by'] = $user['id'];
        $data['updated_date'] = time();
        $data['status'] = 99;
        $nothiRegister = $this->NothiRegisters->patchEntity($nothiRegister, $data);
        if ($this->NothiRegisters->save($nothiRegister)) {
            $this->Flash->success(__('The nothi register has been deleted.'));
        } else {
            $this->Flash->error(__('The nothi register could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function ajax($action = null, $id = null)
    {
        if ($action == 'get_dak_file') {
            $this->loadModel('ReceiveFileRegisters');
            $querys = $this->ReceiveFileRegisters->find()
                ->autoFields(true)
                ->leftJoin('nothi_assigns', 'ReceiveFileRegisters.id=nothi_assigns.receive_file_register_id')
                ->where(['nothi_assigns.nothi_register_id' => $id])
                ->order(['ReceiveFileRegisters.created_date' => 'desc'])
                ->toArray();


            $my_files = array();
            foreach ($querys as $query) {

                $arr['action'] = '<a target="_blank" class="icon-newspaper" href="' . $this->request->webroot . 'NothiRegisters/dak_file_view/' . $query['id'] . '" ><a>';
                $arr['subject'] = $query['subject'];
                $arr['created_date'] = date('d/m/Y', $query['created_date']);
                $arr['sender_name'] = $query['sender_name'];
                $arr['sender_office_name'] = $query['sender_office_name'];
                $my_files[] = $arr;
            }

            $this->response->body(json_encode($my_files));
            return $this->response;


        } elseif ($action == 'get_projects') {

            $this->loadModel('nothi_assigns');
            $querys = $this->nothi_assigns->find()
                ->select(['projects.short_code', 'projects.name_bn', 'projects.id', 'development_partners.name_bn'])
                ->where(['nothi_assigns.nothi_register_id' => $id, 'nothi_assigns.project_id IS NOT' => NULL])
                ->leftJoin('projects', 'projects.id=nothi_assigns.project_id')
                ->leftJoin('development_partners', 'development_partners.id=projects.development_partner_id')
                ->order(['projects.id' => 'desc']);

            $my_files = array();
            foreach ($querys as $key => $query) {

                $arr['action'] = '<a target="_blank" class="icon-newspaper" href="' . $this->request->webroot . 'Projects/view/' . $query['projects']['id'] . '" ><a>';
                $arr['short_code'] = $query['projects']['short_code'];
                $arr['name_bn'] = $query['projects']['name_bn'];
                $arr['development_partner'] = $query['development_partners']['name_bn'];
                $arr['sl_no'] = $key + 1;
                $my_files[] = $arr;
            }

            $this->response->body(json_encode($my_files));
            return $this->response;

        } elseif ($action == 'get_schemes') {

            $this->loadModel('nothi_assigns');
            $querys = $this->nothi_assigns->find()
                ->select(['schemes.scheme_code', 'schemes.name_bn', 'schemes.id'])
                ->where(['nothi_assigns.nothi_register_id' => $id, 'nothi_assigns.scheme_id IS NOT' => NULL])
                ->leftJoin('schemes', 'schemes.id=nothi_assigns.scheme_id')
                ->order(['schemes.id' => 'desc']);

            $my_files = array();
            foreach ($querys as $key => $query) {

                $arr['action'] = '<a target="_blank" class="icon-newspaper" href="' . $this->request->webroot . 'Schemes/edit/' . $query['schemes']['id'] . '" ><a>';
                $arr['scheme_code'] = $query['schemes']['scheme_code'];
                $arr['name_bn'] = $query['schemes']['name_bn'];
                $arr['sl_no'] = $key + 1;
                $my_files[] = $arr;
            }

            $this->response->body(json_encode($my_files));
            return $this->response;

        } elseif ($action == 'get_lab_bills') {

            $this->loadModel('nothi_assigns');
            $querys = $this->nothi_assigns->find()
                ->select(['lab_bills.total_amount', 'lab_bills.net_payable', 'lab_bills.type', 'lab_letter_registers.subject', 'lab_letter_registers.id'])
                ->where(['nothi_assigns.nothi_register_id' => $id, 'nothi_assigns.lab_bill_id IS NOT' => NULL])
                ->leftJoin('lab_bills', 'lab_bills.id=nothi_assigns.lab_bill_id')
                ->where(['lab_bills.type' => 'letter'])
                ->leftJoin('lab_letter_registers', 'lab_letter_registers.id=lab_bills.reference_id')
                ->order(['lab_bills.id' => 'desc']);

            $my_files = array();
            foreach ($querys as $key => $query) {

                $arr['action'] = '<a target="_blank" class="icon-newspaper" href="' . $this->request->webroot . 'add_new_lab_tests/report/' . $query['lab_letter_registers']['id'] . '" ><a>';
                $arr['total_amount'] = $query['lab_bills']['total_amount'];
                $arr['net_payable'] = $query['lab_bills']['net_payable'];
                $arr['type'] = $query['lab_bills']['type'];
                $arr['title'] = $query['lab_letter_registers']['subject'];
                $my_files[] = $arr;
            }

            $querys = $this->nothi_assigns->find()
                ->select(['lab_bills.total_amount', 'lab_bills.net_payable', 'lab_bills.type', 'lab_bills.id', 'lab_bills.reference_id', 'schemes.name_bn', 'schemes.id'])
                ->where(['nothi_assigns.nothi_register_id' => $id, 'nothi_assigns.lab_bill_id IS NOT' => NULL])
                ->leftJoin('lab_bills', 'lab_bills.id=nothi_assigns.lab_bill_id')
                ->where(['lab_bills.type' => 'scheme'])
                ->leftJoin('schemes', 'schemes.id=lab_bills.reference_id')
                ->order(['lab_bills.id' => 'desc']);

            foreach ($querys as $key => $query) {

                $arr['action'] = '<a target="_blank" class="icon-newspaper" href="' . $this->request->webroot . 'lab_bills/getLabBillDetails/' . $query['lab_bills']['id'] . '/' . $query['lab_bills']['type'] . '/' . $query['lab_bills']['reference_id'] . '" ><a>';
                $arr['total_amount'] = $query['lab_bills']['total_amount'];
                $arr['net_payable'] = $query['lab_bills']['net_payable'];
                $arr['type'] = $query['lab_bills']['type'];
                $arr['title'] = $query['schemes']['name_bn'];
                $my_files[] = $arr;
            }

            $this->response->body(json_encode($my_files));
            return $this->response;
        } elseif ($action == 'get_mechanical_bills') {

            $this->loadModel('nothi_assigns');
            $querys = $this->nothi_assigns->find()
                ->select(['hire_charges.total_amount', 'hire_charges.net_payable', 'hire_charges.id', 'schemes.name_bn'])
                ->where(['nothi_assigns.nothi_register_id' => $id, 'nothi_assigns.hire_charge_id IS NOT' => NULL])
                ->leftJoin('hire_charges', 'hire_charges.id=nothi_assigns.hire_charge_id')
                ->leftJoin('schemes', 'schemes.id=hire_charges.scheme_id')
                ->order(['hire_charges.id' => 'desc']);

            $my_files = array();
            foreach ($querys as $key => $query) {

                $arr['action'] = '<a target="_blank" class="icon-newspaper" href="' . $this->request->webroot . 'hire_charges/view/' . $query['hire_charges']['id'] . '" ><a>';
                $arr['total_amount'] = $query['hire_charges']['total_amount'];
                $arr['net_payable'] = $query['hire_charges']['net_payable'];
                $arr['title'] = $query['schemes']['name_bn'];
                $my_files[] = $arr;
            }

            $this->response->body(json_encode($my_files));
            return $this->response;
        } elseif ($action == 'get_purto_bills') {

            $this->loadModel('nothi_assigns');
            $querys = $this->nothi_assigns->find()
                ->select(['purto_bills.bill_type', 'purto_bills.bill_date', 'purto_bills.gross_bill', 'purto_bills.net_taka', 'purto_bills.id'])
                ->where(['nothi_assigns.nothi_register_id' => $id, 'nothi_assigns.purto_bill_id IS NOT' => NULL])
                ->leftJoin('purto_bills', 'purto_bills.id=nothi_assigns.purto_bill_id')
                ->order(['purto_bills.id' => 'desc']);

            $my_files = array();
            foreach ($querys as $key => $query) {

                $arr['action'] = '<a target="_blank" class="icon-newspaper" href="' . $this->request->webroot . 'purto_bills/view/' . $query['purto_bills']['id'] . '" ><a>';
                $arr['bill_date'] = date('d-m-Y', $query['purto_bills']['bill_date']);
                $arr['bill_type'] = $query['purto_bills']['bill_type'];
                $arr['gross_bill'] = $query['purto_bills']['gross_bill'];
                $arr['net_bill'] = $query['purto_bills']['net_taka'];
                $my_files[] = $arr;
            }

            $this->response->body(json_encode($my_files));
            return $this->response;
        } elseif ($action == 'get_allotments') {

            $this->loadModel('nothi_assigns');
            $querys = $this->nothi_assigns->find()
                ->select(['allotment_registers.dr_cr', 'allotment_registers.allotment_date', 'allotment_registers.allotment_amount', 'allotment_registers.id', 'projects.name_bn'])
                ->where(['nothi_assigns.nothi_register_id' => $id, 'nothi_assigns.allotment_register_id IS NOT' => NULL])
                ->leftJoin('allotment_registers', 'allotment_registers.id=nothi_assigns.allotment_register_id')
                ->leftJoin('projects', 'projects.id=allotment_registers.project_id')
                ->order(['allotment_registers.id' => 'desc']);

            $my_files = array();
            foreach ($querys as $key => $query) {

                $arr['action'] = '<a target="_blank" class="icon-newspaper" href="' . $this->request->webroot . 'allotment_registers/view/' . $query['allotment_registers']['id'] . '" ><a>';
                $arr['allotment_date'] = date('d-m-Y', $query['allotment_registers']['allotment_date']);
                $arr['dr_cr'] = $query['allotment_registers']['dr_cr'];
                $arr['allotment_amount'] = $query['allotment_registers']['allotment_amount'];
                $arr['project'] = $query['projects']['name_bn'];
                $my_files[] = $arr;
            }

            $this->response->body(json_encode($my_files));
            return $this->response;
        }
        $this->autoRender = false;

    }

    public function dak_file_view($id = null)
    {
        $this->loadModel('MessageRegisters');
        $my_file = $this->MessageRegisters->find('all', ['conditions' => ['MessageRegisters.resource_id' => $id]])->first();

        $history = $this->MessageRegisters->find('all')
            ->select(['recipients.user_id', 'users.id', 'users.name_en', 'designations.name_en'])
            ->autoFields(true)
            ->where(['MessageRegisters.thread_id' => $my_file->id,])
            ->orWhere(['MessageRegisters.id' => $my_file->id])
            ->leftJoin('recipients', 'recipients.message_register_id=MessageRegisters.id')
            ->leftJoin('users', 'users.id=MessageRegisters.sender_id')
            ->leftJoin('designations', 'designations.id=users.designation_id')
            ->order(['MessageRegisters.id' => 'desc'])

            ->toArray();
        $i = 0;
        foreach ($history as $data) {
            $uid = $data['recipients']['user_id'];
            $this->loadModel('Users');
            $users = $this->Users->find()
                ->select(['designations.name_en', 'Users.name_en'])
                ->where(['Users.id' => $uid])
                ->leftJoin('designations', 'designations.id=Users.designation_id')
                ->toArray();

            $history[$i]['recipient_name'] = $users[0]['name_en'] . " (" . $users[0]['designations']['name_en'] . ")";
            $i++;

        }
        $query = TableRegistry::get('files');
        $attach = $query
            ->find()
            ->where(['table_key' => $id, 'table_name' => 'receive_file_registers']);

        $reply = $this->MessageRegisters->find()
            ->select(['files.file_path'])
            ->where(['MessageRegisters.thread_id' => $my_file->id, 'MessageRegisters.msg_type' => 'reply', 'MessageRegisters.is_attached' => 1])
            ->leftJoin('files', 'files.table_key=MessageRegisters.id and files.table_name="message_registers"')
            ->order(['MessageRegisters.created_date' => 'desc'])
            ->toArray();
        $this->set(compact(['my_file', 'history', 'attach', 'reply']));
    }

    // print
    public function print_it()
    {
        $user = $this->Auth->user();
        $this->layout = 'print';
        $this->view = 'print';

        $start_date = strtotime($this->request->data('start_date'));// TODO:check time issue
        $end_date = strtotime($this->request->data('end_date'));// TODO:check time issue
        $nothiRegisters = $this->NothiRegisters->find()
            ->where(['nothi_date >=' => $start_date])
            ->where(['nothi_date <=' => $end_date])
            ->where(['status !=' => 99, 'office_id' => $user['office_id']]);
        $office = $this->NothiRegisters->Offices->find()
            ->where(['id' => $user['office_id']])
            ->first();
        $this->set(compact('nothiRegisters', 'office'));
    }

    public function view_sub_nothi($parent_id)
    {
        $user = $this->Auth->user();
        $nothiRegisters = $this->NothiRegisters->find('all', [
            'contain' => ['ParentNothi'],
            'conditions' => ['NothiRegisters.status !=' => 99, 'NothiRegisters.office_id' => $user['office_id'], 'NothiRegisters.parent_id' => $parent_id],
            'order' => ['NothiRegisters.created_date' => 'desc']
        ]);

        $this->set('nothiRegisters', $nothiRegisters);
    }

    public function getSubNOthi()
    {
        $user = $this->Auth->user();
        $nothiRegisters = $this->NothiRegisters->find('list', [
            'conditions' => ['NothiRegisters.status' => 1, 'NothiRegisters.office_id' => $user['office_id'], 'parent_id' => $this->request->data('parent_id')],
        ])->toArray();

        $this->set(compact('nothiRegisters'));
        $this->layout = 'ajax';
    }

    public function modalData()
    {
        $input = $this->request->data();
        $receive_file_register_id = $input['letter_new_id'];
        $this->loadModel('LetterIssueRegisters');
        $letter_data = $this->LetterIssueRegisters->find()
            ->where(['receive_file_register_id' => $receive_file_register_id, 'status' => 1])
            ->first();
        $this->layout='ajax';
        $this->set(compact('letter_data'));

    }
}
