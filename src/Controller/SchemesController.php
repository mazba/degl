<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;


/**
 * Schemes Controller
 *
 * @property \App\Model\Table\SchemesTable $Schemes
 */
class SchemesController extends AppController
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
            $schemes = $this->Schemes->find('all', [
                'conditions' => ['Schemes.status' => 1],
                'contain' => ['Projects', 'Districts']
            ])
                ->toArray();
            foreach ($schemes as &$scheme) {
                $scheme['district'] = $scheme->district['name_en'];
                $scheme['project'] = $scheme->project['name_en'];
            }
        } else {
            $schemes = $this->Schemes->find('all')
                ->autoFields(true)
                ->select(['projects.name_en', 'districts.name_en'])
                ->distinct(['Schemes.id'])
                ->innerJoin('project_offices', 'project_offices.project_id = Schemes.project_id')
                ->leftJoin('projects', 'projects.id = Schemes.project_id')
                ->leftJoin('districts', 'districts.id = Schemes.district_id')
                ->where(['Schemes.status' => 1, 'project_offices.office_id' => $user['office_id']])
                ->order(['Schemes.id' => 'asc'])
                ->toArray();
            foreach ($schemes as &$scheme) {
                $scheme['project'] = $scheme['projects']['name_en'];
                $scheme['district'] = $scheme['districts']['name_en'];
            }
        }

        $this->set('schemes', $schemes);
        $this->set('_serialize', ['schemes']);
    }

    /**
     * View method
     *
     * @param string|null $id Scheme id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    /*public function view($id = null)
    {
        $scheme = $this->Schemes->get($id, [
            'contain' => ['Projects', 'WorkTypes', 'WorkSubTypes', 'Districts', 'Upazilas', 'Municipalities', 'FinancialYearEstimates', 'CreatedUser', 'UpdatedUser', 'ReceiveFileRegisters', 'SchemeDetails']
        ]);
        $this->set('scheme', $scheme);
        $this->set('_serialize', ['scheme']);
    }*/

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Auth->user();
        $scheme = $this->Schemes->newEntity();
        if ($this->request->is('post')) {

            $data = $this->request->data;

            if (isset($data['contract_date'])) {
                $data['contract_date'] = strtotime($data['contract_date']);
            }
            $newspaper = array();
            for ($i = 0; $i < count($data['newspaper']); $i++) {
                $newspaper[$i]['name'] = $data['newspaper'][$i];
                $newspaper[$i]['date'] = $data['publicationdate'][$i];
            }

            $data['ads_paper'] = json_encode($newspaper);
            unset($data['newspaper']);
            unset($data['publicationdate']);

            $data['created_by'] = $user['id'];
            $data['created_date'] = time();
            $x = strtotime($data['proposed_start_date']);
            if ($x !== false) {
                $data['proposed_start_date'] = $x;
            } else {
                $data['proposed_start_date'] = '';
            }

            $x = strtotime($data['expected_complete_date']);
            if ($x !== false) {
                $data['expected_complete_date'] = $x;
                $data['completion_date'] = $x;
            } else {
                $data['expected_complete_date'] = '';
            }
            $x = strtotime($data['actual_start_date']);
            if ($x !== false) {
                $data['actual_start_date'] = $x;
            } else {
                $data['actual_start_date'] = '';
            }

            $x = strtotime($data['work_order_date']);
            if ($x !== false) {
                $data['work_order_date'] = $x;
            } else {
                $data['work_order_date'] = '';
            }
            if (isset($data['allotment_date'])) {
                $data['allotment_date'] = strtotime($data['allotment_date']);
            }
            if (isset($data['eve_approval_date'])) {
                $data['eve_approval_date'] = strtotime($data['eve_approval_date']);
            }
            if (isset($data['etender_date'])) {
                $data['etender_date'] = strtotime($data['etender_date']);
            }


            $scheme = $this->Schemes->patchEntity($scheme, $data);
            if ($scheme = $this->Schemes->save($scheme)) {

                if (!empty($data['parent_id'])) {
                    $this->loadModel('nothi_assigns');
                    $nothi_data = array();
                    $nothi_data['nothi_register_id'] = $data['parent_id'];
                    $nothi_data['scheme_id'] = $scheme['id'];
                    $new_nothi = $this->nothi_assigns->newEntity();
                    $nothi = $this->nothi_assigns->patchEntity($new_nothi, $nothi_data);
                    $this->nothi_assigns->save($nothi);
                }
                $this->Flash->success(__('The scheme has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The scheme could not be saved. Please, try again.'));
            }
        }
        if ($user['user_group_id'] == 1) {
            $projects = $this->Schemes->Projects->find('list');
            $office_type = 'HEAD_QUARTER';
            $districts = $this->Schemes->Districts->find('list');
            $upazilas = [];
            $municipalities = [];
        } else {
            $this->loadModel('Projects');
            $projects = $this->Projects->find('list')
                ->InnerJoin('project_offices', 'project_offices.project_id = Projects.id')
                ->where(['project_offices.office_id' => $user['office_id']]);

            $this->loadModel('Offices');
            $office = $this->Offices->find()
                ->where(['id' => $user['office_id']])
                ->first();
            $office_type = $office->office_level;
            if (in_array($office->office_level, ['HEAD_QUARTER', 'DIVISION', 'ZONAL'])) {
                $districts = $this->Schemes->Districts->find('list');
                $upazilas = [];
                $municipalities = [];
            } else {
                $districts = $this->Schemes->Districts->find('list')
                    ->where(['id' => $office['district_id']]);
                if (in_array($office->office_level, ['UPAZILA'])) {
                    $upazilas = $this->Schemes->Upazilas->find('list')
                        ->where(['id' => $office['upazila_id']]);

                } else {
                    $upazilas = $this->Schemes->Upazilas->find('list')
                        ->where(['district_id' => $office['district_id']]);
                }

                $municipalities = $this->Schemes->Municipalities->find('list')
                    ->where(['district_id' => $office['district_id']]);

            }
        }
        $this->loadModel('Packages');
        $packages = $this->Packages->find('list');
        $workTypes = $this->Schemes->WorkTypes->find('list');
        $workSubTypes = [];
        $financialYearEstimates = $this->Schemes->FinancialYearEstimates->find('list');
        $scheme_types = $this->Schemes->SchemeTypes->find('list');
        $this->loadModel('NothiRegisters');
        $nothiRegisters = $this->NothiRegisters->find('list', [
            'conditions' => ['status' => 1, 'office_id' => $user['office_id'], 'parent_id' => 0],
        ])->toArray();

        $this->set(compact('scheme', 'projects', 'nothiRegisters', 'workTypes', 'workSubTypes', 'scheme_types', 'districts', 'upazilas', 'municipalities', 'financialYearEstimates', 'office_type', 'packages'));
        $this->set('_serialize', ['scheme']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Scheme id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Auth->user();
        $scheme = $this->Schemes->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->data;
            $newspaper = array();
            for ($i = 0; $i < count($data['newspaper']); $i++) {
                $newspaper[$i]['name'] = $data['newspaper'][$i];
                $newspaper[$i]['date'] = $data['publicationdate'][$i];
            }

            $data['ads_paper'] = json_encode($newspaper);
            unset($data['newspaper']);
            unset($data['publicationdate']);
            $user = $this->Auth->user();
            $data = $this->request->data;
            if (isset($data['contract_date'])) {
                $data['contract_date'] = strtotime($data['contract_date']);
            }
            $data['updated_by'] = $user['id'];
            $data['updated_date'] = time();
            $x = strtotime($data['proposed_start_date']);
            if ($x !== false) {
                $data['proposed_start_date'] = $x;
            } else {
                $data['proposed_start_date'] = '';
            }
            /*$x=strtotime($data['tender_date']);
            if($x!==false)
            {
                $data['tender_date']=$x;
            }
            else
            {
                $data['tender_date']='';
            }*/
            $x = strtotime($data['expected_complete_date']);
            if ($x !== false) {
                $data['expected_complete_date'] = $x;
                $data['completion_date'] = $x;
            } else {
                $data['expected_complete_date'] = '';
            }
            $x = strtotime($data['actual_start_date']);
            if ($x !== false) {
                $data['actual_start_date'] = $x;
            } else {
                $data['actual_start_date'] = '';
            }
            $x = strtotime($data['approve_extended_date']);
            if ($x !== false) {
                $data['approve_extended_date'] = $x;
                $data['completion_date'] = $x;
            } else {
                $data['approve_extended_date'] = '';
            }
            $x = strtotime($data['actual_complete_date']);
            if ($x !== false) {
                $data['actual_complete_date'] = $x;
                $data['completion_date'] = $x;
            } else {
                $data['actual_complete_date'] = '';
            }
            if (isset($data['allotment_date'])) {
                $data['allotment_date'] = strtotime($data['allotment_date']);
            }
            if (isset($data['eve_approval_date'])) {
                $data['eve_approval_date'] = strtotime($data['eve_approval_date']);
            }
            if (isset($data['etender_date'])) {
                $data['etender_date'] = strtotime($data['etender_date']);
            }


            $x = strtotime($data['work_order_date']);
            if ($x !== false) {
                $data['work_order_date'] = $x;
            } else {
                $data['work_order_date'] = '';
            }

            $scheme = $this->Schemes->patchEntity($scheme, $data);
            if ($this->Schemes->save($scheme)) {
                if (!empty($data['parent_id'])) {

                    $this->loadModel('nothi_assigns');
                    $nothi_file = $this->nothi_assigns->find()
                        ->where(['scheme_id' => $id])
                        ->first();

                    if (!empty($nothi_file)) {
                        $arr = array();
                        $arr['nothi_register_id'] = $data['parent_id'];
                        $nothi = $this->nothi_assigns->patchEntity($nothi_file, $arr);
                        $this->nothi_assigns->save($nothi);
                    } else {
                        $nothi_data = array();
                        $nothi_data['nothi_register_id'] = $data['parent_id'];
                        $nothi_data['scheme_id'] = $id;
                        $new_nothi = $this->nothi_assigns->newEntity();
                        $nothi = $this->nothi_assigns->patchEntity($new_nothi, $nothi_data);
                        $this->nothi_assigns->save($nothi);
                    }

                }
                $this->Flash->success(__('The scheme has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The scheme could not be saved. Please, try again.'));
            }
        }

        if ($user['user_group_id'] == 1) {
            $projects = $this->Schemes->Projects->find('list');
            $office_type = 'HEAD_QUARTER';
            $districts = $this->Schemes->Districts->find('list');
            $upazilas = [];
            $municipalities = [];
        } else {
            $this->loadModel('Projects');
            $projects = $this->Projects->find('list')
                ->InnerJoin('project_offices', 'project_offices.project_id = Projects.id')
                ->where(['project_offices.office_id' => $user['office_id']]);

            $this->loadModel('Offices');
            $office = $this->Offices->find()
                ->where(['id' => $user['office_id']])
                ->first();
            $office_type = $office->office_level;
            if (in_array($office->office_level, ['HEAD_QUARTER', 'DIVISION', 'ZONAL'])) {
                $districts = $this->Schemes->Districts->find('list');
                $upazilas = [];
                $municipalities = [];
            } else {
                $districts = $this->Schemes->Districts->find('list')
                    ->where(['id' => $office['district_id']]);
                if (in_array($office->office_level, ['UPAZILA'])) {
                    $upazilas = $this->Schemes->Upazilas->find('list')
                        ->where(['id' => $office['upazila_id']]);

                } else {
                    $upazilas = $this->Schemes->Upazilas->find('list')
                        ->where(['district_id' => $office['district_id']]);
                }

                $municipalities = $this->Schemes->Municipalities->find('list')
                    ->where(['district_id' => $office['district_id']]);

            }

            if (empty($upazilas)) {
                $this->loadModel('Upazilas');
                $upazilas = $this->Upazilas->find('list', ['conditions' => ['district_id' => $scheme->district_id]]);
            }
        }
        $this->loadModel('Packages');
        $packages = $this->Packages->find('list');
        $workTypes = $this->Schemes->WorkTypes->find('list');
        $workSubTypes = $this->Schemes->WorkSubTypes->find('list');
        $financialYearEstimates = $this->Schemes->FinancialYearEstimates->find('list');
        $scheme_types = $this->Schemes->SchemeTypes->find('list');
        $scheme_sub_types = $this->Schemes->SubSchemeTypes->find('list');
        $this->loadModel('NothiRegisters');
        $nothiRegisters = $this->NothiRegisters->find('list', [
            'conditions' => ['status' => 1, 'office_id' => $user['office_id'], 'parent_id' => 0],
        ])->toArray();

        $this->loadModel('nothi_assigns');
        $nothi = $this->nothi_assigns->find()->select(['nothi_register_id'])->where(['scheme_id' => $id])->first();
        if (!empty($nothi)) {
            $selected_nothi=$this->NothiRegisters->find()->select(['nothi_no'])->where(['id'=>$nothi['nothi_register_id']])->first();
            $this->set(compact('selected_nothi'));
        }

        $this->set(compact('scheme_sub_types', 'nothiRegisters', 'scheme_types', 'scheme', 'projects', 'workTypes', 'workSubTypes', 'districts', 'upazilas', 'municipalities', 'financialYearEstimates', 'office_type', 'packages'));
        $this->set('_serialize', ['scheme']);
    }

    // View . .. .. . . .. .
    public function view($id = null)
    {
        $multimedia_data = $this->Schemes->get($id, [
            'contain' => ['Projects', 'Districts', 'multimedia']
        ]);
//      Investigations Reports (Image)
        $project_images = TableRegistry::get('project_images')->find('all');
        $project_images->select(['users.name_bn', 'users.picture']);
        $project_images->autoFields(true);
        $project_images->where(['project_images.scheme_id' => $id]);
        $project_images->leftJoin('users', 'users.id=project_images.created_by');
//      Investigations Reports (Videos)
        $project_videos = TableRegistry::get('project_videos')->find('all');
        $project_videos->select(['users.name_bn', 'users.picture']);
        $project_videos->autoFields(true);
        $project_videos->where(['project_videos.scheme_id' => $id]);
        $project_videos->leftJoin('users', 'users.id=project_videos.created_by');

        $this->set('project_images', $project_images);
        $this->set('project_videos', $project_videos);

        $this->set('multimedia_data', $multimedia_data);
    }

    /**
     * Delete method
     *
     * @param string|null $id Scheme id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $scheme = $this->Schemes->get($id);

        $user = $this->Auth->user();
        $data = $this->request->data;
        $data['updated_by'] = $user['id'];
        $data['updated_date'] = time();
        $data['status'] = 99;
        $scheme = $this->Schemes->patchEntity($scheme, $data);
        if ($this->Schemes->save($scheme)) {
            $this->Flash->success(__('The scheme has been deleted.'));
        } else {
            $this->Flash->error(__('The scheme could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function ajax($task)
    {
        $this->layout = 'ajax';
        if ($task == 'get_subwork_by_worktype_id') {
            $this->view = 'get_subwork_by_worktype_id';
            $workSubTypes = $this->Schemes->WorkSubTypes->find('list')
                ->where(['work_type_id' => $this->request->data['work_type_id']]);
            $this->set(compact('workSubTypes'));
            //$this -> render('get_modules_by_componentId');
        } elseif ($task == 'get_upazila_municpaltiy_by_disctrict_id') {

            $district_id = $this->request->data['district_id'];
            $this->view = 'get_upazila_municpaltiy_by_disctrict_id';
            $upazilas = $this->Schemes->Upazilas->find('list')
                ->where(['district_id' => $district_id]);
            $municipalities = $this->Schemes->Municipalities->find('list')
                ->where(['district_id' => $district_id]);

            $this->set(compact('upazilas', 'municipalities'));

        } elseif ($task == 'get_sub_scheme_type_by_scheme_type_id') {

            $schemeTypeId = $this->request->data['schemeTypeId'];
            $sub_scheme_types = $this->Schemes->SubSchemeTypes->find('list')
                ->where(['scheme_type_id' => $schemeTypeId]);
            $this->response->body(json_encode($sub_scheme_types));
            return $this->response;

        }
    }

    public function close_scheme($id = null)
    {
        $scheme = $this->Schemes->get($id);
        if ($this->request->is(['post', 'put'])) {

            $inputs = $this->request->data;
            $user = $this->Auth->user();
            $data['updated_by'] = $user['id'];
            $data['updated_date'] = time();
            $data['status'] = Configure::read('scheme_complete_status');
            $data['work_remarks'] = $inputs['work_remarks'];
            $data['actual_complete_date'] = strtotime($inputs['actual_complete_date']);

            $scheme = $this->Schemes->patchEntity($scheme, $data);

            if ($this->Schemes->save($scheme)) {
                $this->Flash->success(__('The scheme has been closed.'));
            } else {
                $this->Flash->error(__('The scheme could not be closed. Please, try again.'));
            }
            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('scheme'));


    }

    /*Assign Contractors to a Scheme*/


    public function assign_contractors($id = null)
    {
        if (!($this->get_access($this->user_roles, 'edit'))) {
            $this->Flash->error(__('You don\'t have access to the task'));
            return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
        }

        $this->loadModel('Schemes');//also update scheme items table
        $scheme = $this->Schemes->get($id);
        $this->loadModel('Contractors');
        $contractors = $this->Contractors->find('all', ['fields' => ['id', 'contractor_title']])->toArray();
        $this->loadModel('SchemeContractors');
        $assigned_contractors = $this->SchemeContractors->find('all', ['conditions' => ['scheme_id' => $id], 'fields' => ['id' => 'contractor_id']])->hydrate(false)->toArray();
        $is_lead = $this->SchemeContractors->find('all', ['conditions' => ['scheme_id' => $id, 'is_lead' => 1], 'fields' => ['id' => 'contractor_id']])->first();

        if ($this->request->is(['patch', 'post', 'put'])) {

            //Delete all contractors
            $scheme_contractors = TableRegistry::get('scheme_contractors');
            $query = $scheme_contractors->query();
            $query->delete()
                ->where(['scheme_id' => $id])
                ->execute();
            //End

            $tender_documents = array();
            $tender_notices = array();
            $tender_contracts = array();

            $file_upload_complete = true;

            $base_upload_path = WWW_ROOT . 'files/contractor';
            // upload tender_documents:::
            for ($i = 0; $i < sizeof($_FILES['tender_documents']['name']); $i++) {
                $tmp_name = $_FILES['tender_documents']['tmp_name'][$i];
                //Get the temp file path
                if ($tmp_name) {

                    $name = time() . '_' . str_replace(' ', '_', $_FILES['tender_documents']['name'][$i]);
                    if (move_uploaded_file($tmp_name, $base_upload_path . '/' . $name)) {
                        $tender_documents[]['file_path'] = $name;
                    } else {
                        $file_upload_complete = false;
                        break;
                    }
                }
            }
            // upload tender notices:::
            for ($i = 0; $i < sizeof($_FILES['tender_notices']['name']); $i++) {
                $tmp_name = $_FILES['tender_notices']['tmp_name'][$i];
                //Get the temp file path
                if ($tmp_name) {

                    $name = time() . '_' . str_replace(' ', '_', $_FILES['tender_notices']['name'][$i]);
                    if (move_uploaded_file($tmp_name, $base_upload_path . '/' . $name)) {
                        $tender_notices[]['file_path'] = $name;
                    } else {
                        $file_upload_complete = false;
                        break;
                    }
                }
            }
            // upload tender contracts:::
            for ($i = 0; $i < sizeof($_FILES['tender_contracts']['name']); $i++) {
                $tmp_name = $_FILES['tender_contracts']['tmp_name'][$i];
                //Get the temp file path
                if ($tmp_name) {

                    $name = time() . '_' . str_replace(' ', '_', $_FILES['tender_contracts']['name'][$i]);
                    if (move_uploaded_file($tmp_name, $base_upload_path . '/' . $name)) {
                        $tender_contracts[]['file_path'] = $name;
                    } else {
                        $file_upload_complete = false;
                        break;
                    }
                }
            }

            // SAVE THE DATA
            if ($file_upload_complete) {
                $user = $this->Auth->user();
                $data = $this->request->data;

                // save data into scheme table
                $scheme_data['actual_start_date'] = strtotime($data['actual_start_date']);
                $scheme_data['assigned'] = 1;
                $scheme_data['updated_by'] = $user['id'];
                $scheme_data['updated_date'] = time();

                $scheme = $this->Schemes->patchEntity($scheme, $scheme_data);

                if ($this->Schemes->save($scheme)) {
                    $scheme_contractors = TableRegistry::get('scheme_contractors');

                    $all_contractor = $data['contractors'];
                    $lead_contractor = $data['lead_contractor'];

                    //if lead contractor already assigned
                    if (!in_array($data['lead_contractor'], $all_contractor)) {
                        $all_contractor[] = $lead_contractor;
                    }
                    //save scheme_contractor
                    foreach ($all_contractor as $contractor) {
                        $contractor_data['scheme_id'] = $id;
                        $contractor_data['contractor_id'] = $contractor;
                        $contractor_data['is_lead'] = ($contractor == $lead_contractor) ? 1 : '';

                        $file_query = $scheme_contractors->query();
                        $file_query->insert(array_keys($contractor_data))
                            ->values($contractor_data)
                            ->execute();
                    }

                    //:::::: save contractor files in files table ::::

                    $files_table = TableRegistry::get('files');
                    // save tender_documents
                    foreach ($tender_documents as $file) {
                        $file_data = array();
                        $file_data['file_path'] = $file['file_path'];
                        $file_data['table_name'] = 'scheme_tender_documents';
                        $file_data['table_key'] = $id;
                        $file_data['created_by'] = $user['id'];
                        $file_data['created_date'] = time();
                        $file_data['status'] = 1;
                        $file_query = $files_table->query();
                        $file_query->insert(array_keys($file_data))
                            ->values($file_data)
                            ->execute();
                    }
                    // save tender_notices
                    foreach ($tender_notices as $file) {
                        $file_data = array();
                        $file_data['file_path'] = $file['file_path'];
                        $file_data['table_name'] = 'scheme_tender_notices';
                        $file_data['table_key'] = $id;
                        $file_data['created_by'] = $user['id'];
                        $file_data['created_date'] = time();
                        $file_data['status'] = 1;
                        $file_query = $files_table->query();
                        $file_query->insert(array_keys($file_data))
                            ->values($file_data)
                            ->execute();
                    }
                    // save tender_contracts
                    foreach ($tender_contracts as $file) {
                        $file_data = array();
                        $file_data['file_path'] = $file['file_path'];
                        $file_data['table_name'] = 'scheme_tender_contracts';
                        $file_data['table_key'] = $id;
                        $file_data['created_by'] = $user['id'];
                        $file_data['created_date'] = time();
                        $file_data['status'] = 1;
                        $file_query = $files_table->query();
                        $file_query->insert(array_keys($file_data))
                            ->values($file_data)
                            ->execute();
                    }


                    //:::::: save remarks scheme remarks table ::::

                    $files_table = TableRegistry::get('scheme_remarks');
                    if ($data['remarks']) {
                        $remarks_data['scheme_id'] = $id;
                        $remarks_data['remarks'] = $data['remarks'];
                        $remarks_data['remarks_type'] = 'scheme_assign';
                        $remarks_data['user_id'] = $user['id'];
                        $remarks_data['created_by'] = $user['id'];
                        $remarks_data['created_date'] = time();

                        $file_query = $files_table->query();
                        $file_query->insert(array_keys($remarks_data))
                            ->values($remarks_data)
                            ->execute();
                    }

                    $this->Flash->success(__('The scheme has been assigned.'));
                    return $this->redirect(['action' => 'index']);

                } else {
                    $this->Flash->error(__('The scheme has can not assigned'));
                }
            } else {
                $this->Flash->error(__('File Upload Error. Please, try again.'));
            }
        }
        $this->set(compact('scheme', 'contractors', 'id', 'assigned_contractors', 'is_lead'));
    }


}