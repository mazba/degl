<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * LetterIssueRegisters Controller
 *
 * @property \App\Model\Table\LetterIssueRegistersTable $LetterIssueRegisters
 */
class LetterIssueRegistersController extends AppController {

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
     * @param string|null $id Letter Issue Register id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = NULL) {
        $letterIssueRegister = $this->LetterIssueRegisters->get($id, ['contain' => ['Projects', 'Schemes', 'CreatedUser', 'UpdatedUser', 'NothiRegisters']]);
        $files_table = TableRegistry::get('files');
        $query = $files_table->find();
        $query->where(['table_name' => 'letter_issue_registers', 'table_key' => $id]);
        $files = $query->toArray();
        $this->set('files', $files);
        $this->set('letterIssueRegister', $letterIssueRegister);
        $this->set('_serialize', ['letterIssueRegister']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $letterIssueRegister = $this->LetterIssueRegisters->newEntity();
        $user = $this->Auth->user();
        if ($this->request->is('post')) {

            $inputs = $this->request->data;
            /*$files = array();
            $file_upload_complete = TRUE;
            $base_upload_path = WWW_ROOT . 'files/issue_files';
            for ($i = 0; $i < sizeof($_FILES['attachments']['name']); $i++) {
                $tmp_name = $_FILES['attachments']['tmp_name'][$i];
                //Get the temp file path
                if ($tmp_name) {

                    $name = time() . '_' . str_replace(' ', '_', $_FILES['attachments']['name'][$i]);
                    if (move_uploaded_file($tmp_name, $base_upload_path . '/' . $name)) {
                        $files[]['file_path'] = $name;
                    } else {
                        $file_upload_complete = FALSE;
                        break;
                    }
                }
            }*/


            $data = array();
//                $data['letter_no']=$inputs['letter_no'];
            $data['sarok_no'] = $inputs['sarok_no'];
            $data['subject'] = $inputs['subject'];
            $data['sender_office'] = $user['office_id'];
            $data['sender_department'] = $inputs['sender_department'];
            $data['receiver_name'] = $inputs['receiver_name'];
            $data['receiver_designation'] = $inputs['receiver_designation'];
            $data['letter_summery'] = $inputs['letter_summery'];
            $x = strtotime($inputs['issue_date']);
            if ($x !== FALSE) {
                $data['issue_date'] = $x;
            } else {
                $data['issue_date'] = '';
            }
            $data['letter_nature'] = $inputs['letter_nature'];
            $data['remarks'] = $inputs['remarks'];
            $data['is_urgent'] = $inputs['is_urgent'];
            $data['is_answer_required'] = $inputs['is_answer_required'];
            $x = strtotime($inputs['answer_date']);
            if ($x !== FALSE) {
                $data['answer_date'] = $x;
            } else {
                $data['answer_date'] = '';
            }

            $data['project_id'] = $inputs['project_id'];
            $data['scheme_id'] = $inputs['scheme_id'];
            $data['is_hardcopy_attached'] = 0;
            $data['number_of_pages'] = $inputs['number_of_pages'];
            $data['created_by'] = $user['id'];
            $time = time();
            $data['created_date'] = $time;
            $data['status'] = 1;
            if (isset($inputs['is_guard_file'])) {
                $data['is_guard_file'] = $inputs['is_guard_file'];
            }
            if (isset($inputs['is_resolution'])) {
                $data['is_resolution'] = $inputs['is_resolution'];
            }
            if (isset($inputs['nothi_register_id'])) {
                $data['nothi_register_id'] = $inputs['nothi_register_id'];
            }
            $data['description'] = $inputs['description'];
            $data['nothi_register_id'] = $inputs['parent_id'];
            $letterIssueRegister = $this->LetterIssueRegisters->patchEntity($letterIssueRegister, $data);
            if ($status = $this->LetterIssueRegisters->save($letterIssueRegister)) {
                $this->Flash->success(__('Letter has been issued.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Letter cannot be issued. Please, try again.'));
            }

        }

        $projects = $this->LetterIssueRegisters->Projects->find('list')
            ->innerJoin('project_offices', 'project_offices.project_id = Projects.id')
            ->where(['project_offices.office_id' => $user['office_id']]);

        $schemes = $this->LetterIssueRegisters->Schemes->find('list')
            ->innerJoin('project_offices', 'project_offices.project_id = Schemes.project_id')
            ->leftJoin('projects', 'projects.id = Schemes.project_id')
            ->where(['project_offices.office_id' => $user['office_id']]);

        $this->loadModel('Offices');
        $offices = $this->Offices->find('list');
        $this->loadModel('NothiRegisters');
        $nothiRegisters = $this->NothiRegisters->find('list')
            ->select(['id', 'nothi_no'])
            ->where(['parent_id' => 0, 'status' => 1])
            ->toArray();

        $this->set(compact('letterIssueRegister', 'nothiRegisters', 'projects', 'schemes', 'offices', 'nothi'));
        $this->set('_serialize', ['letterIssueRegister']);
    }

    public function edit($id = NULL) {
        $letterIssueRegister = $this->LetterIssueRegisters->get($id);
        $user = $this->Auth->user();
        if ($this->request->is(['put', 'post'])) {

            $inputs = $this->request->data;
            $data = array();
//                $data['letter_no']=$inputs['letter_no'];
            $data['sarok_no'] = $inputs['sarok_no'];
            $data['subject'] = $inputs['subject'];
            $data['sender_office'] = $user['office_id'];
            $data['sender_department'] = $inputs['sender_department'];
            $data['receiver_name'] = $inputs['receiver_name'];
            $data['receiver_designation'] = $inputs['receiver_designation'];
            $x = strtotime($inputs['issue_date']);
            if ($x !== FALSE) {
                $data['issue_date'] = $x;
            } else {
                $data['issue_date'] = '';
            }
            $data['letter_nature'] = $inputs['letter_nature'];
            $data['remarks'] = $inputs['remarks'];
            $data['is_urgent'] = $inputs['is_urgent'];
            $data['is_answer_required'] = $inputs['is_answer_required'];
            $x = strtotime($inputs['answer_date']);
            if ($x !== FALSE) {
                $data['answer_date'] = $x;
            } else {
                $data['answer_date'] = '';
            }
            $data['project_id'] = $inputs['project_id'];
            $data['scheme_id'] = $inputs['scheme_id'];

            $data['is_hardcopy_attached'] = 0;

            $data['number_of_pages'] = $inputs['number_of_pages'];
            $data['created_by'] = $user['id'];
            $time = time();
            $data['created_date'] = $time;
            $data['status'] = 1;
            if (isset($inputs['is_guard_file'])) {
                $data['is_guard_file'] = $inputs['is_guard_file'];
            }
            if (isset($inputs['is_resolution'])) {
                $data['is_resolution'] = $inputs['is_resolution'];
            }
            if (isset($inputs['nothi_register_id'])) {
                $data['nothi_register_id'] = $inputs['nothi_register_id'];
            }
            $data['description'] = $inputs['description'];

            $letterIssueRegister = $this->LetterIssueRegisters->patchEntity($letterIssueRegister, $data);

            if ($status = $this->LetterIssueRegisters->save($letterIssueRegister)) {
                $this->Flash->success(__('Letter has been issued.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Letter cannot be issued. Please, try again.'));
            }

        }

        $projects = $this->LetterIssueRegisters->Projects->find('list')
            ->innerJoin('project_offices', 'project_offices.project_id = Projects.id')
            ->where(['project_offices.office_id' => $user['office_id']]);

        $schemes = $this->LetterIssueRegisters->Schemes->find('list')
            ->innerJoin('project_offices', 'project_offices.project_id = Schemes.project_id')
            ->leftJoin('projects', 'projects.id = Schemes.project_id')
            ->where(['project_offices.office_id' => $user['office_id']]);

        $this->loadModel('Offices');
        $offices = $this->Offices->find('list');
        $this->loadModel('NothiRegisters');
        $nothi = $this->NothiRegisters->find('list');

        $this->set(compact('letterIssueRegister', 'nothiRegisters', 'projects', 'schemes', 'offices', 'nothi'));
        $this->set('_serialize', ['letterIssueRegister']);
    }

    //Ajax
    public function ajax($action = NULL) {
        if ($action == 'get_grid_data') {
            $user = $this->Auth->user();
            if ($user['user_group_id'] == 1) {
                $letterIssueRegisters = $this->LetterIssueRegisters->find('all', ['conditions' => ['LetterIssueRegisters.status !=' => 99], 'order' => ['id' => 'DESC']])
                    ->toArray();
            } else {
                $letterIssueRegisters = $this->LetterIssueRegisters->find('all', ['conditions' => ['LetterIssueRegisters.status !=' => 99, 'sender_office' => $user['office_id']], 'order' => ['id' => 'DESC' ]])
                    ->toArray();
            }
            foreach ($letterIssueRegisters as &$letterIssueRegister) {
                $letterIssueRegister['action'] = '<a class="icon-newspaper" href="' . $this->request->webroot . 'LetterIssueRegisters/view/' . $letterIssueRegister['id'] . '" ><a>';
                $letterIssueRegister['action'] = $letterIssueRegister['action'] . '&nbsp;<a class="icon-pencil3" href="' . $this->request->webroot . 'LetterIssueRegisters/edit/' . $letterIssueRegister['id'] . '" ><a>';
                if (!empty($letterIssueRegister['scheme_id'])) {
                    $letterIssueRegister['action'] = $letterIssueRegister['action'] . '&nbsp;<a title="Detail Note Sheet Event" class="icon-book" href="' . $this->request->webroot . 'note_sheet_events/view/' . $letterIssueRegister['scheme_id'] . '" ><a>';
                }

                $letterIssueRegister['issue_date'] = date('d/m/Y', $letterIssueRegister['issue_date']);
            }

            $this->response->body(json_encode($letterIssueRegisters));
            return $this->response;
        }

    }

    //    Print report
    public function print_it() {
        $user = $this->Auth->user();
        $this->layout = 'print';
        $this->view = 'print';
        $officeTable = TableRegistry::get('offices');
        if ($this->request->data('type') == 'by_date') {
            $start_date = strtotime($this->request->data('start_date') . '00:00:00 GMT');// TODO:check time issue
            $end_date = strtotime($this->request->data('end_date') . '23:59:59 GMT');// TODO:check time issue
            if ($user['user_group_id'] == 1) {
                $letterIssueRegisters = $this->LetterIssueRegisters->find('all', ['conditions' => ['LetterIssueRegisters.status !=' => 99, 'LetterIssueRegisters.issue_date >=' => $start_date, 'LetterIssueRegisters.issue_date <=' => $end_date,],])
                    ->toArray();
            } else {
                $letterIssueRegisters = $this->LetterIssueRegisters->find('all', ['conditions' => ['LetterIssueRegisters.status !=' => 99, 'sender_office' => $user['office_id'], 'LetterIssueRegisters.issue_date >=' => $start_date, 'LetterIssueRegisters.issue_date <=' => $end_date,],])
                    ->toArray();
            }
        } else {
            if ($user['user_group_id'] == 1) {
                $letterIssueRegisters = $this->LetterIssueRegisters->find('all', ['conditions' => ['LetterIssueRegisters.status !=' => 99, 'LetterIssueRegisters.issue_date >=' => strtotime('00:00'),// TODO:check time issue
                    'LetterIssueRegisters.issue_date <=' => strtotime('23:59'),// TODO:check time issue
                ],])
                    ->toArray();
            } else {
                $letterIssueRegisters = $this->LetterIssueRegisters->find('all', ['conditions' => ['LetterIssueRegisters.status !=' => 99, 'sender_office' => $user['office_id'], 'LetterIssueRegisters.issue_date >=' => strtotime('00:00'),// TODO:check time issue
                    'LetterIssueRegisters.issue_date <=' => strtotime('23:59'),// TODO:check time issue
                ],])
                    ->toArray();
            }
        }
        // Office Info
        $office = $officeTable->find()
            ->where(['id' => $user['office_id']])
            ->first();
        $this->set(compact('letterIssueRegisters', 'office'));
    }

    public function getSubNothi() {
        $this->loadModel('NothiRegisters');
        $nothiRegisters = $this->NothiRegisters->find('list', ['conditions' => ['parent_id' => $this->request->data('parent_id'), 'status !=' => 99]])
            ->toArray();
        $this->response->body(json_encode($nothiRegisters));
        return $this->response;
    }
}
