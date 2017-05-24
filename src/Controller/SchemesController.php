<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

/**
 * Schemes Controller
 *
 * @property \App\Model\Table\SchemesTable $Schemes
 */
class SchemesController extends AppController {

  /**
   * Index method
   *
   * @return void
   */
  public function index() {

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
  public function add() {
    $user = $this->Auth->user();
    $scheme = $this->Schemes->newEntity();
    if ($this->request->is('post')) {

      $data = $this->request->data;
      //   echo "<pre>";print_r($data);die();
//
      $newspaper = array();
      for ($i = 0; $i < count($data['newspaper']); $i++) {
        $newspaper[$i]['name'] = $data['newspaper'][$i];
        $newspaper[$i]['date'] = $data['publicationdate'][$i];
      }

      $data['ads_paper'] = json_encode($newspaper);
      unset($data['newspaper']);
      unset($data['publicationdate']);

      $data['app_sent'] = strtotime($data['app_sent']);
      $data['app_approved'] = strtotime($data['app_approved']);
      $data['noa_date'] = strtotime($data['noa_date']);
      $data['insurance_date'] = strtotime($data['insurance_date']);

      $data['created_by'] = $user['id'];
      $data['created_date'] = time();

      $x = strtotime($data['proposed_start_date']);
      if ($x !== FALSE) {
        $data['proposed_start_date'] = $x;
      } else {
        $data['proposed_start_date'] = '';
      }

      $x = strtotime($data['contract_date']);
      if ($x !== FALSE) {
        $data['contract_date'] = $x;
      } else {
        $data['contract_date'] = '';
      }

      $x = strtotime($data['expected_complete_date']);
      if ($x !== FALSE) {
        $data['expected_complete_date'] = $x;
        $data['completion_date'] = $x;
      } else {
        $data['expected_complete_date'] = '';
      }
      $x = strtotime($data['actual_start_date']);
      if ($x !== FALSE) {
        $data['actual_start_date'] = $x;
      } else {
        $data['actual_start_date'] = '';
      }

      $x = strtotime($data['work_order_date']);
      if ($x !== FALSE) {
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
      $data['approved'] = 1;

      $scheme = $this->Schemes->patchEntity($scheme, $data);
      //  echo "<pre>";print_r($scheme);die();
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
    $nothiRegisters = $this->NothiRegisters->find('list', ['conditions' => ['status' => 1, 'office_id' => $user['office_id'], 'parent_id' => 0],])
        ->toArray();

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
  public function edit($id = NULL) {
    $user = $this->Auth->user();
    $scheme = $this->Schemes->get($id);
    if ($this->request->is(['patch', 'post', 'put'])) {
      $data = $this->request->data;

      // echo "<pre>";print_r($data);die();
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
      if ($x !== FALSE) {
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
      if ($x !== FALSE) {
        $data['expected_complete_date'] = $x;
        $data['completion_date'] = $x;
      } else {
        $data['expected_complete_date'] = '';
      }
      $x = strtotime($data['actual_start_date']);
      if ($x !== FALSE) {
        $data['actual_start_date'] = $x;
      } else {
        $data['actual_start_date'] = '';
      }
//            $x = strtotime($data['approve_extended_date']);
//            if ($x !== false) {
//                $data['approve_extended_date'] = $x;
//                $data['completion_date'] = $x;
//            } else {
//                $data['approve_extended_date'] = '';
//            }
//            $x = strtotime($data['actual_complete_date']);
//            if ($x !== false) {
//                $data['actual_complete_date'] = $x;
//                $data['completion_date'] = $x;
//            } else {
//                $data['actual_complete_date'] = '';
//            }
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
      if ($x !== FALSE) {
        $data['work_order_date'] = $x;
      } else {
        $data['work_order_date'] = '';
      }

      $scheme = $this->Schemes->patchEntity($scheme, $data);
//            echo "<pre>";print_r($scheme);die();
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
        return $this->redirect(['action' => 'index']);
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
    $nothiRegisters = $this->NothiRegisters->find('list', ['conditions' => ['status' => 1, 'office_id' => $user['office_id'], 'parent_id' => 0],])
        ->toArray();

    $this->loadModel('nothi_assigns');
    $nothi = $this->nothi_assigns->find()
        ->select(['nothi_register_id'])
        ->where(['scheme_id' => $id])
        ->first();
    if (!empty($nothi)) {
      $selected_nothi = $this->NothiRegisters->find()
          ->select(['nothi_no'])
          ->where(['id' => $nothi['nothi_register_id']])
          ->first();
      $this->set(compact('selected_nothi'));
    }

    $this->set(compact('scheme_sub_types', 'nothiRegisters', 'scheme_types', 'scheme', 'projects', 'workTypes', 'workSubTypes', 'districts', 'upazilas', 'municipalities', 'financialYearEstimates', 'office_type', 'packages'));
    $this->set('_serialize', ['scheme']);
  }

  // View . .. .. . . .. .
  public function view($id = NULL) {
    $multimedia_data = $this->Schemes->get($id, ['contain' => ['Projects', 'Districts', 'multimedia']]);
//      Investigations Reports (Image)
    $project_images = TableRegistry::get('project_images')
        ->find('all');
    $project_images->select(['users.name_bn', 'users.picture']);
    $project_images->autoFields(TRUE);
    $project_images->where(['project_images.scheme_id' => $id]);
    $project_images->leftJoin('users', 'users.id=project_images.created_by');
//      Investigations Reports (Videos)
    $project_videos = TableRegistry::get('project_videos')
        ->find('all');
    $project_videos->select(['users.name_bn', 'users.picture']);
    $project_videos->autoFields(TRUE);
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
  public function delete($id = NULL) {

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

  public function ajax($task) {
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

  public function close_scheme($id = NULL) {
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

  public function assign_contractors($id = NULL) {
    ini_set('max_execution_time', 300);
    //  echo "<pre>";print_r($id);die();
    if (!($this->get_access($this->user_roles, 'edit'))) {
      $this->Flash->error(__('You don\'t have access to the task'));
      return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
    }

    $this->loadModel('Schemes');//also update scheme items table
    $scheme = $this->Schemes->get($id);
    $this->loadModel('Contractors');
    $contractors = $this->Contractors->find('all', ['fields' => ['id', 'contractor_title']])
        ->toArray();
    $this->loadModel('SchemeContractors');
    $assigned_contractors = $this->SchemeContractors->find('all', ['conditions' => ['scheme_id' => $id], 'fields' => ['id' => 'contractor_id']])
        ->hydrate(FALSE)
        ->toArray();
    $is_lead = $this->SchemeContractors->find('all', ['conditions' => ['scheme_id' => $id, 'is_lead' => 1], 'fields' => ['id' => 'contractor_id']])
        ->first();

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

      $file_upload_complete = TRUE;

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
            $file_upload_complete = FALSE;
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
            $file_upload_complete = FALSE;
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
            $file_upload_complete = FALSE;
            break;
          }
        }
      }

      // SAVE THE DATA
      if ($file_upload_complete) {
        $user = $this->Auth->user();
        $data = $this->request->data;

        // save data into scheme table
        if (isset($data['actual_start_date']) && $data['actual_start_date'] != "") {
          $scheme_data['actual_start_date'] = strtotime($data['actual_start_date']);
        }
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

  public function index_ajax($action = NULL)
  {
    if ($action == 'get_grid_data' && $this->user_roles['index'])
    {
      $user = $this->Auth->user();
      if ($user['user_group_id'] == 1)
      {
        $schemes = $this->Schemes->find('all', ['conditions' => ['Schemes.status' => 1], 'contain' => ['Projects', 'Districts']])
            ->toArray();

        foreach ($schemes as &$scheme) {
          $scheme['district'] = $scheme->district['name_en'];
          $scheme['project'] = $scheme->project['name_en'];
        }

      }
      else
      {
        $schemes = $this->Schemes->find('all')//->autoFields(true)
        ->select(['financial_year' => 'financial_year_estimates.name', 'scheme_name' => 'Schemes.name_en', 'projects_name' => 'projects.short_code', 'districts_name' => 'districts.name_en', 'upazilas_name' => 'upazilas.name_en', 'contractor_name' => 'contractors.contractor_title', 'contract_amount' => 'Schemes.contract_amount', 'contract_date' => 'Schemes.contract_date', /*'scheme_progresses' => 'scheme_progresses.progress_value',*/
            'expected_complete_date' => 'Schemes.expected_complete_date', 'scheme_id' => 'Schemes.id', 'scheme_progresses' => '(SELECT `progress_value` FROM `scheme_progresses`  WHERE `scheme_id` = `Schemes`.`id` ORDER BY `id` DESC LIMIT 1)'])
            ->distinct(['Schemes.id'])
            ->innerJoin('project_offices', 'project_offices.project_id = Schemes.project_id')
            ->leftJoin('projects', 'projects.id = Schemes.project_id')
            ->leftJoin('districts', 'districts.id = Schemes.district_id')
            ->leftJoin('upazilas', 'upazilas.id = Schemes.upazila_id')
            ->leftJoin('scheme_progresses', 'scheme_progresses.scheme_id = Schemes.id')
            ->leftJoin('upazilas', 'upazilas.id = Schemes.upazila_id')
            ->leftJoin('scheme_contractors', 'scheme_contractors.scheme_id = Schemes.id')
            ->leftJoin('contractors', 'contractors.id = scheme_contractors.contractor_id')
            ->leftJoin('financial_year_estimates', 'financial_year_estimates.id = Schemes.financial_year_estimate_id')
            ->where(['Schemes.status' => 1, 'project_offices.office_id' => $user['office_id']])
            ->order(['Schemes.id' => 'desc'])
            ->toArray();
        //echo "<pre>", print_r($schemes, 1), "</pre>";
        $sl = 1;
        foreach ($schemes as &$scheme) {
          $scheme['sl'] = $sl;
          $scheme['contract_date'] = date('d/m/Y', $scheme['contract_date']);
          $scheme['expected_complete_date'] = date('d/m/Y', $scheme['expected_complete_date']);
          //$scheme['action'] = '<button title="' . __('Edit') . ' " data-scheme_id="' . $scheme['scheme_id'] . '" class="icon-newspaper text-danger edit" > </button>';
          $scheme['action'] =
              '<button title="' . __('Edit') . ' " data-scheme_id="' . $scheme['scheme_id'] . '" class="icon-newspaper text-danger edit" > </button>'.''.
              '<button title="' . __('Work Order') . ' " data-scheme_id="' . $scheme['scheme_id'] . '" class="icon-newspaper text workOrder" > </button>' . '' .
              '&nbsp;<a class="" title="Assign Contractors" href="' . $this->request->webroot . 'Schemes/assign_contractors/' . $scheme['scheme_id'] . '" ><i class="icon-user-plus"></i><a>'. '' .
              '&nbsp;<a class="" title="Scheme Nothi" href="' . $this->request->webroot . 'note_sheet_events/view/' . $scheme['scheme_id'] . '" target="_blank" ><i class="icon-redo"></i><a>';

          $sl++;
        }
      }
      $this->response->body(json_encode($schemes));
      return $this->response;

    } else {
      return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
    }

  }

  public function view_by_id() {

    $this->layout = 'ajax';

    if ($this->request->is(['post', 'put'])) {

      $inputs = $this->request->data;
      $id = $inputs['id'];

      $scheme = $this->Schemes->get($id, ['contain' => ['Projects', 'WorkTypes', 'WorkSubTypes', 'Districts', 'Upazilas', 'Municipalities', 'FinancialYearEstimates', 'ReceiveFileRegisters', 'SchemeDetails', 'SchemeProgresses' => function ($q) {
        return $q->where(['SchemeProgresses.status' => 1])
            ->limit(1);
      }]]);

      //  echo "<pre>";print_r($scheme);die();
      $this->set('scheme', $scheme);

    }

  }

  public function edit_by_id($id) {
    // echo "ok"; die();
    // echo "<pre>";print_r($id);die();

    $user = $this->Auth->user();

    $this->layout = 'ajax';

//        $scheme = $this->Schemes->get($id, [
//            'contain' => ['Projects', 'WorkTypes', 'WorkSubTypes', 'Districts', 'Upazilas', 'Municipalities', 'FinancialYearEstimates', 'ReceiveFileRegisters', 'SchemeDetails', 'SchemeProgresses' =>
//                function ($q) {
//                    return $q
//                        ->where(['SchemeProgresses.status' => 1])
//                        ->limit(1);
//                }]
//        ]);

    $scheme = $this->Schemes->get($id, ['contain' => ['Projects', 'WorkTypes', 'WorkSubTypes', 'Districts', 'Upazilas', 'Municipalities', 'FinancialYearEstimates', 'SchemeDetails']]);
    //echo "<pre>",print_r($scheme),"<pre>";die();
    if ($this->request->is(['patch', 'post', 'put'])) {
      $data = $this->request->data;
      $newspaper = array();
      for ($i = 0; $i < count($data['newspaper']); $i++) {
        $newspaper[$i]['name'] = $data['newspaper'][$i];
        $newspaper[$i]['date'] = $data['publicationdate'][$i];
      }

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
      if ($x !== FALSE) {
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
      if ($x !== FALSE) {
        $data['expected_complete_date'] = $x;
        $data['completion_date'] = $x;
      } else {
        $data['expected_complete_date'] = '';
      }
      $x = strtotime($data['actual_start_date']);
      if ($x !== FALSE) {
        $data['actual_start_date'] = $x;
      } else {
        $data['actual_start_date'] = '';
      }
//            $x = strtotime($data['approve_extended_date']);
//            if ($x !== false) {
//                $data['approve_extended_date'] = $x;
//                $data['completion_date'] = $x;
//            } else {
//                $data['approve_extended_date'] = '';
//            }
//            $x = strtotime($data['actual_complete_date']);
//            if ($x !== false) {
//                $data['actual_complete_date'] = $x;
//                $data['completion_date'] = $x;
//            } else {
//                $data['actual_complete_date'] = '';
//            }
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
      if ($x !== FALSE) {
        $data['work_order_date'] = $x;
      } else {
        $data['work_order_date'] = '';
      }
      $data['ads_paper'] = json_encode($newspaper);
      $scheme = $this->Schemes->patchEntity($scheme, $data);
//            echo "<pre>";print_r($scheme);die();
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
    $nothiRegisters = $this->NothiRegisters->find('list', ['conditions' => ['status' => 1, 'office_id' => $user['office_id'], 'parent_id' => 0],])
        ->toArray();

    $this->loadModel('nothi_assigns');
    $nothi = $this->nothi_assigns->find()
        ->select(['nothi_register_id'])
        ->where(['scheme_id' => $id])
        ->first();
    if (!empty($nothi)) {
      $selected_nothi = $this->NothiRegisters->find()
          ->select(['nothi_no'])
          ->where(['id' => $nothi['nothi_register_id']])
          ->first();
      $this->set(compact('selected_nothi'));
    }

  // newspaper data read
    $newspaperData = $this->Schemes->find()
        ->select('ads_paper')
        ->where(['id' => $id])
        ->first();
    $newspaperData = json_decode($newspaperData['ads_paper'],true);
    
    $this->loadModel('Files');
    $contractor_file = $this->Files->find('all', ['conditions' => ['table_key' => $id]])
        ->toArray();

    // payorder data load
    $this->loadModel('SchemePayorders');
    $payorder = $this->SchemePayorders->find()
          ->where(['scheme_id' => $id])
          ->first();
    $this->set(compact('contractor_file', 'scheme_sub_types', 'nothiRegisters', 'scheme_types', 'scheme', 'projects', 'workTypes', 'workSubTypes', 'districts', 'upazilas', 'municipalities', 'financialYearEstimates', 'office_type', 'packages','payorder','newspaperData'));

    //  echo "<pre>";print_r($scheme);die();
    // $this->set('scheme', $scheme);

  }

  public function work_order_by_id($scheme_id) {
    $this->layout = 'ajax';
    $this->loadModel('Schemes');
//    $result = TableRegistry::get('Schemes')
//        ->find('all')
//        ->where(['Schemes.id' => $scheme_id, 'Schemes.status' => 1])
//        ->contain(['Projects'])->toArray();
    $result = $this->Schemes->find('all')
        ->select([
            'work_order_date' => 'Schemes.work_order_date',
            'work_name' => 'Schemes.name_en',
            'etender_no' => 'Schemes.etender_no',
            'estimation_sarok_no' => 'Schemes.allotment_no',
            'estimation_date' => 'Schemes.allotment_date',
            'estimation_taka' => 'Schemes.allotment_bill',
            'e_tender_no' => 'Schemes.etender_no',
            'e_tender_date' => 'Schemes.etender_date',
            'obtain_tender_no' => 'Schemes.number_of_tender',
            'customary_tender_no' => 'Schemes.habitual_number_of_tender',
            'performance_security' => 'Schemes.performance_security',
        ])->toArray();
pr($result);die;
    $this->set(compact('result'));
  }
  public function edit_scheme_progress($scheme_id) {
    $this->layout = 'ajax';
    $this->loadModel('SchemeProgresses');
    $this->loadModel('Schemes');
    $schemeProgress = $this->SchemeProgresses->newEntity();
    $id = $scheme_id;
    $query = TableRegistry::get('SchemeProgresses')
        ->find()
        ->select(['progress_value'])
        ->where(['scheme_id' => $scheme_id, 'status' => 1]);
    $previous_scheme_progresses = $query->first();

    $query = TableRegistry::get('SchemeProgressPlans')
        ->find()
        ->where(['scheme_id' => $scheme_id]);
    // ->order(['date' => 'DESC']);
    $previous_scheme_progress_plans = $query->toArray();

    $query = TableRegistry::get('scheme_progresses')
        ->find()
        ->where(['scheme_id' => $scheme_id]);
    $actually_scheme_progress = $query->toArray();

    // echo "<pre>";print_r($actually_scheme_progress);die();
    if ($this->request->is(['post', 'put'])) {
      $data = $this->request->data;
      $user = $this->Auth->user();
      $data['office_id'] = $user['office_id'];
      $data['created_by'] = $user['id'];
      $data['created_date'] = strtotime($data['created_date']);
      $scheme = TableRegistry::get('SchemeProgresses');
      $query = $scheme->query();
      $query->update()
          ->set(['status' => 0])
          ->where(['scheme_id' => $data['scheme_id']])
          ->execute();

      $schemeProgress = $this->SchemeProgresses->patchEntity($schemeProgress, $data);
      //  echo "<pre>";print_r($schemeProgress);die();
      if ($this->SchemeProgresses->save($schemeProgress)) {
        $result = 'The scheme progress has been saved';
        $this->response->body(json_encode($result));
        return $this->response;

      } else {
        $result = 'The scheme progress could not be saved. Please, try again.';
        $this->response->body(json_encode($result));
        return $this->response;

      }

    }
    $this->set(compact('schemeProgress', 'previous_scheme_progresses', 'id', 'previous_scheme_progress_plans', 'actually_scheme_progress'));

  }

  public function save_scheme_progress_plan() {

    $this->loadModel('SchemeProgressPlans');

    $result = NULL;

    if ($this->request->is(['post', 'put'])) {
      $post_data = $this->request->data;
      //  echo "<pre>";print_r($post_data);die();
      $scheme_id = $post_data['scheme_id'];
      foreach ($post_data['proggress_plan'] as $row) {
        $schemeProgressPlan = $this->SchemeProgressPlans->newEntity();
        $data['scheme_id'] = $scheme_id;
        $data['date'] = strtotime($row['date']);
        $data['progress'] = $row['progress'];
        $data['created_date'] = strtotime($row['date']);
        $schemeProgressPlan = $this->SchemeProgressPlans->patchEntity($schemeProgressPlan, $data);
        // echo "<pre>";print_r($schemeProgressPlan);die();

        if ($this->SchemeProgressPlans->save($schemeProgressPlan)) {
          $result = TRUE;

        } else {
          $result = FALSE;
        }
      }

      if ($result) {
        $result = 'The scheme progress has been saved';
        $this->response->body(json_encode($result));
        return $this->response;
      } else {
        $result = 'The scheme progress could not be saved. Please, try again.';
        $this->response->body(json_encode($result));
        return $this->response;
      }
      //echo "<pre>";print_r($data);die();
    }
  }

  public function edit_item_bbq($scheme_id) {
    $this->layout = 'ajax';
    $inputs = $this->request->data;
    $this->loadModel('SchemesItems');
    $this->loadModel('scheme_items_info');
    $this->loadModel('estimated_schemes_items');
    if ($this->request->is(['patch', 'post', 'put'])) {
      //  echo "<pre>";print_r($inputs);die();
      if (isset($inputs['item'])) {

        foreach ($inputs['item'] as $itm) {
          $item_info = TableRegistry::get('scheme_items_info')
              ->find()
              ->where(['item_display_code' => $itm['item_display_code']])
              ->first();

          //   echo "<pre>";print_r($item_info);die();
          if (!$item_info) {
            $itm_info = [];

            $itm_info['item_display_code'] = $itm['item_display_code'];
            $itm_info['description'] = $itm['description'];
            $itm_info['unit'] = $itm['unit'];
            $itm_info['status'] = 1;

            $scheme_items_info = $this->scheme_items_info->newEntity();
            $scheme_items_info = $this->scheme_items_info->patchEntity($scheme_items_info, $itm_info);
            $this->scheme_items_info->save($scheme_items_info);
          }
        }

        foreach ($inputs['item'] as $itm) {
          $itm['created_by'] = $this->Auth->user('id');
          $itm['created_date'] = time();
          $itm['scheme_id'] = $scheme_id;
          $scheme_itms = $this->SchemesItems->newEntity();
          $scheme_itms = $this->SchemesItems->patchEntity($scheme_itms, $itm);
          //  echo "<pre>";print_r($scheme_itms);die();
          if ($this->SchemesItems->save($scheme_itms)) {
            $this->set('success', 'The scheme has been saved');
          } else {
            $this->set('error', 'The scheme has not been saved. Try again with valid data');
          }
        }
      } else {
        $this->set('error', 'No Item found!!');
      }
    }
    //retrieve view data
    $itms = $this->SchemesItems->find()
        ->where(['scheme_id' => $scheme_id]);
    $estimated_itms = $this->estimated_schemes_items->find()
        ->where(['scheme_id' => $scheme_id]);
    $this->set('items', $itms);
    $this->set('estimated_itms', $estimated_itms);
    //    echo "<pre>";print_r($itms);die();
  }

  public function add_estimated_item_bbq($scheme_id) {
    $this->layout = 'ajax';
    $inputs = $this->request->data;
    //  echo "<pre>";print_r($inputs);die();
    $this->loadModel('estimated_schemes_items');
    $this->loadModel('scheme_items_info');
    if ($this->request->is(['patch', 'post', 'put'])) {
      //  echo "<pre>";print_r($inputs);die();
      if (isset($inputs['item'])) {

        foreach ($inputs['item'] as $itm) {
          $item_info = TableRegistry::get('scheme_items_info')
              ->find()
              ->where(['item_display_code' => $itm['item_display_code']])
              ->first();

          //   echo "<pre>";print_r($item_info);die();
          if (!$item_info) {
            $itm_info = [];

            $itm_info['item_display_code'] = $itm['item_display_code'];
            $itm_info['description'] = $itm['description'];
            $itm_info['unit'] = $itm['unit'];
            $itm_info['status'] = 1;

            $scheme_items_info = $this->scheme_items_info->newEntity();
            $scheme_items_info = $this->scheme_items_info->patchEntity($scheme_items_info, $itm_info);
            $this->scheme_items_info->save($scheme_items_info);
          }
        }

        foreach ($inputs['item'] as $itm) {
          $itm['created_by'] = $this->Auth->user('id');
          $itm['created_date'] = time();
          $itm['scheme_id'] = $scheme_id;
          $scheme_itms = $this->estimated_schemes_items->newEntity();
          $scheme_itms = $this->estimated_schemes_items->patchEntity($scheme_itms, $itm);
          //  echo "<pre>";print_r($scheme_itms);die();

          $val = $this->estimated_schemes_items->save($scheme_itms);

        }

        if ($val) {
          $this->response->body(TRUE);
          return $this->response;
        } else {
          // $this->set('error', 'The scheme has not been saved. Try again with valid data');
        }
      } else {
        $this->set('error', 'No Item found!!');
      }
    }
//        //retrieve view data
//        $itms = $this->SchemesItems->find()->where(['scheme_id' => $scheme_id]);
//        $this->set('items', $itms);
  }

  public function get_items_by_code() {
    if ($this->request->is(['patch', 'post', 'put'])) {
      $data = $this->request->data;

      $item_info = TableRegistry::get('scheme_items_info')
          ->find()
          ->where(['item_display_code' => $data['itm_val']])
          ->first();
      //  echo "<pre>";print_r($item_info);die();
    }
    $this->response->body(json_encode($item_info));
    return $this->response;
  }

  public function scheme_vehicle_manage($scheme_id) {
    $this->layout = 'ajax';

    $hired_vehicles = $this->get_hired_vehicles($scheme_id);

    $hire_charges = TableRegistry::get('hire_charges')
        ->find()
        ->where(['scheme_id' => $scheme_id]);
    $details = [];
    foreach ($hire_charges as $row) {
      $details[$row['id']]['info'] = $hire_charge_details = TableRegistry::get('hire_charge_details')
          ->find()
          ->select(['item_code' => 'schemes_items.item_display_code', 'description' => 'schemes_items.description', 'unit' => 'schemes_items.unit', 'rate' => 'schemes_items.rate', 'quantity_done' => 'hire_charge_details.quantity', 'item_total' => 'hire_charge_details.item_total'])
          ->where(['hire_charge_details.hire_charge_id' => $row['id']])
          ->leftJoin('schemes_items', 'schemes_items.item_display_code=hire_charge_details.item_code')
          ->where(['schemes_items.scheme_id' => $row['scheme_id']])
          ->toArray();
      $details[$row['id']]['total'] = $row['net_payable'];

    }

//echo "<pre>";print_r($details);die();
    $this->set('scheme_id', $scheme_id);
    $this->set('hired_vehicles', $hired_vehicles);
    $this->set('details', $details);
  }

//    public function add_vehicle_in_scheme($id = null)
//    {
//        $this->layout = 'ajax';
//        $user = $this->Auth->user();
//        $vehicle_hire = TableRegistry::get('vehicle_hire');
//        $vehicle_table = TableRegistry::get('vehicles');
//        $available_vehicles = $this->get_avaliable_vehicles($id);
//        //  echo "<pre>";print_r($available_vehicles);die();
//        $hired_vehicles = $this->get_hired_vehicles($id);
//        $vehicle_letters = TableRegistry::get('vehicle_hire_letter_registers');
//
//        if ($this->request->is('post')&& $id !="") {
//            $selected_vehicles = array();
//            $location = array();
//            if (isset($this->request->data['selected_vehicles'])) {
//                $selected_vehicles = $this->request->data['selected_vehicles'];
//                $location = $this->request->data['location'];
//            }
//            /*if(count($selected_vehicles)==0)
//            {
//                $this->Flash->error('No vehicle seleted');
//            }
//
//            */
//
//            /* echo "<pre>";
//             print_r($this->request->data);
//             echo "</pre>";
//             die;*/
//
//            if (count(array_intersect($selected_vehicles, $available_vehicles[0])) == count($selected_vehicles)) {
//                $time = time();
//                /*$query = $vehicle_hire->query();
//                $query->update()
//                    ->set($data)
//                    ->where(['letter_id' => $id])
//                    ->execute();
//                debug($query);*/
////                $query = $vehicle_hire->query();
////                $query->update('vehicle_hire SET revision_no=revision_no+1 ,updated_by=' . $user['id'] . ',updated_date=' . $time . ',status=0')
////                    ->where(['letter_id' => $id])
////                    ->execute();
//
//                foreach ($selected_vehicles as $sv) {
//                    $data = array();
//                    $data['letter_id'] = $id;
//                    $data['vehicle_id'] = $sv;
//                    $data['office_id'] = $user['office_id'];
//                    $data['revision_no'] = 1;
//                    $data['created_by'] = $user['id'];
//                    $data['created_date'] = $time;
//                    $data['status'] = 1;
//                    $query = $vehicle_hire->query();
//                    $query->insert(array_keys($data))
//                        ->values($data)
//                        ->execute();
//                }
//
//                foreach ($location as $key => $value) {
//                    $this->loadModel('Vehicles');
//                    $vehicle = $this->Vehicles->get($key);
//                    $arr['vehicle_location'] = $value;
//                    $arr['updated_by'] = $user['id'];
//                    $arr['updated_date'] = time();
//                    $vehicle = $this->Vehicles->patchEntity($vehicle, $arr);
//                    $this->Vehicles->save($vehicle);
//                }
//
//                $this->Flash->success(__('Vehicle Saved Successfully.'));
//                //  return $this->redirect(['action' => 'index']);
//            } else {
//                $this->Flash->error(__('Someone hired some vehicles.Try again.'));
//            }
//        }
//        //get vehicle info
//        $hired_vehicles = $this->get_hired_vehicles($id);
//        // get vehicle hire letter info
//        $query = $vehicle_letters->get($id);
//        $vehicle_hire_letter = $query->toArray();
//        //Message & Attachment ingo
//
//        $attachment_query = TableRegistry::get('vehicle_hire_letter_registers')->find();
//        //    $attachment_query->select(['applications.id','applications.temporary_id','applications.applicant_id','applications.applicant_name_bn','applications.phone','applications.email','applications.application_type_id','applications.start_date','applications.end_date','applications.status']);
//        $attachment_query->select(['files.file_path']);
//        $attachment_query->where(['vehicle_hire_letter_registers.id' => $id]);
//        $attachment_query->where(['files.table_name' => 'receive_file_registers']);
//        $attachment_query->leftJoin('files', 'files.table_key=vehicle_hire_letter_registers.resource_id');
//        $attachment = $attachment_query->first();
//
////echo "<pre>";print_r($attachment['files']);die();
//        $this->set('id', $id);
//        $this->set('vehicles', $available_vehicles[1]);
//        $this->set('hired_vehicles', $hired_vehicles[1]);
//        $this->set('vehicle_hire_letter', $vehicle_hire_letter);
//        $this->set('attachment', $attachment);
//        $this->set('location', $hired_vehicles[2]);
//    }
//
//    private function get_avaliable_vehicles($letter_id)
//    {
//        $user = $this->Auth->user();
//        $vids = array();
//        $vlists = array();
//        $vehicle_hire = TableRegistry::get('vehicle_hire');
//        $vehicle_table = TableRegistry::get('vehicles');
//        $sub_query = $vehicle_hire->find();
//        $sub_query->select(['vehicle_id' => 'vehicle_id'])
//            ->where(['status' => 1, 'office_id' => $user['office_id']]);
//        $vehicles = $vehicle_table->find();
//        $vehicles->select(['id' => 'id', 'title' => 'title']);
//        $vehicles->where(['id NOT IN' => $sub_query]);
//        $vehicles->where(['office_id' => $user['office_id']]);
//        foreach ($vehicles as $v) {
//            $vids[] = $v->id;
//            $vlists[] = array('id' => $v->id, 'title' => $v->title);
//        }
//        return array($vids, $vlists);
//    }

  function get_hired_vehicles($id) {
    $user = $this->Auth->user();
    $vehicles_status = TableRegistry::get('vehicles_status');
    $vehicles = $vehicles_status->find()
        ->select(['title' => 'vehicles.title', 'location' => 'vehicles_status.vehicle_location', 'remark' => 'vehicles_status.remark', 'assign_date' => 'vehicles_status.assign_date'])
        ->where(['vehicles_status.scheme_id' => $id])
        ->leftJoin('vehicles', 'vehicles.id=vehicles_status.vehicle_id')
        ->toArray();
    return $vehicles;
  }

//    public function update_vehicle_location()
//    {
//        $user = $this->Auth->user();
//
//        if ($this->request->is(['patch', 'post', 'put'])) {
//            $time= time();
//            $data = $this->request->data;
//          // echo "<pre>";print_r($data);die();
//            $vehicle_hire = TableRegistry::get('vehicle_hire');
//            $query = $vehicle_hire->query();
//            $query->update('vehicle_hire SET revision_no=revision_no+1 ,updated_by=' . $user['id'] . ',updated_date=' . $time . ',status=0')
//                ->where(['id' => $data['vehicle_hire_id']])
//                ->execute();
//
//            $vehicles = TableRegistry::get('vehicles');
//            $query = $vehicles->query();
//            $query->update('vehicles SET `updated_by`=' . $user['id'] . ',`updated_date`=' . $time . ', `vehicle_location`="'.$data['location'].'"')
//                ->where(['id' => $data['id']])
//                ->execute();
//
//            $this->response->body(json_encode([]));
//            return $this->response;
//        }
//    }

  public function edit_scheme_measurement($scheme_id) {
    $this->loadModel('Measurements');
    $this->layout = 'ajax';
    if ($this->request->is(['patch', 'post', 'put'])) {
      $user = $this->Auth->user();
      $time = time();
      $data = $this->request->data;
      //  echo "<pre>";print_r($data);die();
      foreach ($data['measurement'] as $measurement) {

        $measurement['measured-by'] = $data['measured-by'];
        $measurement['scheme_id'] = $scheme_id;
        $measurement['measurement_no'] = $data['measurement_no'];
        $measurement['measurement_date'] = strtotime($data['measurement_date']);

        $measurement['created_by'] = $user['id'];
        $measurement['created_date'] = $time;
        $measurement['status'] = 1;

        $measurements = $this->Measurements->newEntity();
        $measurements = $this->Measurements->patchEntity($measurements, $measurement);
        //   echo "<pre>";print_r($measurements);die();
//                if (){
//                    echo "ok";
//                }

        if ($this->Measurements->save($measurements)) {
          $this->set('success', 'The scheme has been saved');
        } else {
          $this->set('error', 'The scheme has not been saved. Try again with valid data');
        }
      }
      $this->response->body(json_encode([]));
      return $this->response;

    }
    $measurement_head = TableRegistry::get('Measurements')
        ->find()
        ->select(['measurement_no', 'measurement_date'])
        ->where(['scheme_id' => $scheme_id])
        ->distinct(['measurement_no']);
    //  echo "<pre>";print_r($measurement_head->toArray());die();

    $measurement_info = [];
    foreach ($measurement_head as $measurement_no) {
      $measurement_details = TableRegistry::get('Measurements')
          ->find()
          ->select(['measurement_date' => 'Measurements.measurement_date', 'measured_by' => 'Measurements.measured-by', 'quantity_of_work_done' => 'Measurements.quantity_of_work_done', 'item_display_code' => 'schemes_items.item_display_code', 'unit' => 'schemes_items.unit', 'quantity' => 'schemes_items.quantity', 'description' => 'schemes_items.description'])
          ->where(['Measurements.status' => 1, 'Measurements.measurement_no' => $measurement_no['measurement_no'], 'Measurements.scheme_id' => $scheme_id])
          ->leftJoin('schemes_items', 'schemes_items.id=Measurements.item_id');
      $measurement_info[$measurement_no['measurement_no'] . '-Date-' . date('d-M-Y', $measurement_no['measurement_date'])]['info'] = $measurement_details->toArray();
    }

    // echo "<pre>";print_r($measurement_info);die();

    $items = TableRegistry::get('SchemesItems')
        ->find()// ->select(['vehicle_id' => 'vehicle_id'])
        ->where(['status' => 1, 'scheme_id' => $scheme_id]);

    // echo "<pre>";print_r($items->toArray());die();
    //s   echo "<pre>";print_r($items->toArray());die();
    $this->set('items', $items);
    $this->set('measurement_info', $measurement_info);

  }

  //delete acheme item and bbq
  public function delete_item_bbq($id) {
    $this->layout = 'ajax';
    if ($this->request->is(['patch', 'post', 'put'])) {
      // echo "<pre>";print_r($id);die();
      $item_bbq = TableRegistry::get('schemes_items');
      $query = $item_bbq->query();
      $query->delete()
          ->where(['id' => $id])
          ->execute();
      if ($query) {
        $this->response->body(json_encode([]));
        return $this->response;
      }
    }

  }

  public function get_file_and_video($id = NULL) {
    $this->layout = 'ajax';

    $project_images = TableRegistry::get('project_images')
        ->find('all');
    $project_images->select(['users.name_bn', 'users.picture']);
    $project_images->autoFields(TRUE);

    $project_images->where(['project_images.scheme_id' => $id]);

    //  $project_images->where(['project_images.project_id'=>$input['project_id']]);
    $project_images->leftJoin('users', 'users.id=project_images.created_by');
    $project_images = $project_images->toArray();
    // echo "<pre>";print_r($project_images);die();
    $project_videos = TableRegistry::get('project_videos')
        ->find('all');
    $project_videos->select(['users.name_bn', 'users.picture']);
    $project_videos->autoFields(TRUE);
    $project_videos->where(['project_videos.scheme_id' => $id]);

    // $project_videos->where(['project_videos.project_id'=>$input['project_id']]);
    $project_videos->leftJoin('users', 'users.id=project_videos.created_by');
    $project_videos = $project_videos->toArray();

    $this->set(compact('project_images', 'project_videos'));

  }

  public function get_lab_bill_info($scheme_id) {
    //   echo "<pre>";print_r($scheme_id);die();
    $this->layout = 'ajax';
    $this->loadModel('LabBills');

    $labBills = $this->LabBills->find()
        ->where(['type' => 'scheme', 'reference_id' => $scheme_id])
        ->order(['created_date' => 'desc'])
        ->toArray();

    //  echo "<pre>";print_r($labBills);die();

    $this->set(compact('scheme_id', 'labBills'));

  }

  public function get_lab_grid_data($scheme_id) {
    //   echo "<pre>";print_r($scheme_id);die();
    $this->loadModel('LabLetterRegisters');

    $user = $this->Auth->user();
    $labLetterRegisters = $this->LabLetterRegisters->find('all', ['conditions' => ['scheme_id' => $scheme_id, 'LabLetterRegisters.status !=' => 99], 'order' => ['LabLetterRegisters.id' => 'DESC']])
        ->toArray();
    foreach ($labLetterRegisters as &$labLetterRegister) {
      $labLetterRegister['action'] = '<a class="icon-newspaper"  target="_blank" href="' . $this->request->webroot . 'LabLetterRegisters/view/' . $labLetterRegister['id'] . '" ><a>';
      $labLetterRegister['created_date'] = date('d/m/Y', $labLetterRegister['created_date']);
      $labLetterRegister['receive_date'] = date('d/m/Y', $labLetterRegister['receive_date']);
    }

    $this->response->body(json_encode($labLetterRegisters));
    return $this->response;

  }

  public function getLabBillDetails($bill_id = NULL, $type = NULL, $reference_id = NULL) {
    if ($this->request->is('ajax')) {
      $this->layout = 'ajax';
      $bill_id = $this->request->data('bill_id');
      $type = $this->request->data('type');
      $reference_id = $this->request->data('reference_id');
    } else {
      $this->view = 'get_lab_bill_detail';
    }

    $this->loadModel('LabBills');
    $labBills = $this->LabBills->find()
        ->hydrate(FALSE)
        ->where(['LabBills.id ' => $bill_id, 'LabBills.type' => $type, 'LabBills.reference_id' => $reference_id])
        ->contain(['LabBillDetails' => function ($q) {
          return $q->group(['LabBillDetails.lab_test_group_id'])
              ->contain(['LabActualTests'])
              ->autoFields(TRUE);
        }])//            ->group(['LabBillDetails.lab_bill_id'])
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
          $lab_bill_id_test = 0;
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
  // function for contractor_info
  public function contractor_info($id)
  {
    $this->layout = 'ajax';
    $this->loadModel('Contractors');
    $this->loadModel('LetterIssueRegisters');
    $this->loadModel('SchemeContractors');
    $assigned_contractors = $this->SchemeContractors->find('all', ['contain' => ['Contractors'], 'conditions' => ['scheme_id' => $id]])
        ->toArray();
    $assign_letters = $this->LetterIssueRegisters->find('all', ['conditions' => ['scheme_id' => $id]])->toArray();
    $this->set(compact('assigned_contractors','id','assign_letters'));
  }

  public function get_account_bill_details($id) {
    $this->layout = 'ajax';
    $this->loadModel('processed_ra_bills');
    $bill_info = $this->processed_ra_bills->find()
        ->where(['scheme_id ' => $id])// ->order(['id' => 'desc'])
        ->toArray();
    $this->set(compact('bill_info', 'id'));
  }

  public function get_ra_bill_applications($id) {
    $user = $this->Auth->user();
    $this->loadModel('MessageRegisters');
    /*$messages = $this->MessageRegisters->find('all', [
        'conditions' => ['MessageRegisters.sender_id' => $user['id'],'MessageRegisters.msg_type'=>'original'],
    ]);*/

    $messages = $this->MessageRegisters->find()
        ->autoFields(TRUE)
        ->Where(['MessageRegisters.msg_type' => 'RaBillApplication'])
        ->Where(['MessageRegisters.scheme_id' => $id])
        ->leftJoin('recipients', 'recipients.message_register_id=MessageRegisters.id')//->where(['recipients.user_id' => $user['id']])
        ->order(['MessageRegisters.created_date' => "DESC"])
        ->toArray();

    foreach ($messages as $message) {
      if ($message->thread_id) {
        $message['action'] = '<a target="_blank" class="icon-newspaper" href="' . $this->request->webroot . 'RaBillApplication/view/' . $message['thread_id'] . '" ><a>';
      } else {
        $message['action'] = '<a target="_blank" class="icon-newspaper" href="' . $this->request->webroot . 'RaBillApplication/view/' . $message['id'] . '" ><a>';
      }

      $message['created_date'] = date('d/m/Y', $message['created_date']);

    }
    $this->response->body(json_encode($messages));
    return $this->response;
  }

  //Letter assign for contractor
  public function newLetterAssign()
  {
    $user = $this->Auth->user();
    $today = time();
    $this->loadModel('LetterIssueRegisters');
    $letterIssueRegister = $this->LetterIssueRegisters->newEntity();
    $inputs = $this->request->data();
    $inputs['created_by'] = $user['id'];
    $inputs['created_date'] = $today;
    $inputs['number_of_pages'] = 1;
    $inputs['letter_nature'] = "SUBLETTER";
    $letterIssueRegister = $this->LetterIssueRegisters->patchEntity($letterIssueRegister, $inputs);
    if($this->LetterIssueRegisters->save($letterIssueRegister))
    {
      $response_text =  __('সফলভাবে পত্রজারী হয়েছে');
    }
    else
    {
      $response_text =  __('সমস্যা হয়েছে আবার চেষ্টা করুন');
    }
    $response = [
        'success'=>true,
        'msg'=>$response_text
    ];
    $this->response->body(json_encode($response));
    return $this->response;
  }

  // Contractor letter print
  public function contractorLetter($id){
    $this->loadModel('LetterIssueRegisters');
    $letter_data = $this->LetterIssueRegisters->get($id, [
      'contain' => ['Schemes']
    ]);
    $this->set('letter_data', $letter_data);
  }


  // payoder assign for scheme
  public function payorder(){
    $user = $this->Auth->user();
    $this->loadModel('SchemePayorders');
    $inputs = $this->request->data();
    $id = $inputs['payorder'];
    if($id){
      $payorders = $this->SchemePayorders->get($id);
    }else{
      $payorders = $this->SchemePayorders->newEntity();
    }
    $inputs['initial_date'] = strtotime($inputs['initial_date']);
    $inputs['expire_date'] = strtotime($inputs['expire_date']);
    $inputs['submit_date'] = strtotime($inputs['submit_date']);
    $inputs['status'] = 1;
    $inputs['created_by'] = $user['id'];
    $inputs['created_date'] = time();
    $payorders = $this->SchemePayorders->patchEntity($payorders, $inputs);
    if($this->SchemePayorders->save($payorders)){
      $response_text = __('সফলভাবে পে-অর্ডারটি গ্রহণ করা হলো');
    }
    else{
      $response_text = __('সমস্যা হয়েছে আবার চেষ্টা করুন');
    }
    $response = [
      'success' => true,
      'msg' => $response_text,
    ];
    $this->response->body(json_encode($response));
    return $this->response;
  }

}