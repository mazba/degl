<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Carbon\Carbon;

/**
 * ReceiveFileRegisters Controller
 *
 * @property \App\Model\Table\ReceiveFileRegistersTable $ReceiveFileRegisters
 */
class ReceiveFileRegistersController extends AppController
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
     * @param string|null $id Receive File Register id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $receiveFileRegister = $this->ReceiveFileRegisters->get($id, [
            'contain' => ['Projects', 'Schemes']
        ]);
        $files_table = TableRegistry::get('files');
        $query = $files_table->find();
        $query->where(['table_name' => 'receive_file_registers', 'table_key' => $id]);
        $files = $query->toArray();
        $this->set('receiveFileRegister', $receiveFileRegister);
        $this->set('files', $files);
        $this->set('_serialize', ['receiveFileRegister']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Auth->user();
        $receiveFileRegister = $this->ReceiveFileRegisters->newEntity();
        if ($this->request->is('post')) {
            $inputs = $this->request->data;
            $files = array();
            $file_upload_complete = true;

            $base_upload_path = WWW_ROOT . 'files/receive_files';
            for ($i = 0; $i < sizeof($_FILES['attachments']['name']); $i++) {
                $tmp_name = $_FILES['attachments']['tmp_name'][$i];
                //Get the temp file path
                if ($tmp_name) {

                    $name = time() . '_' . str_replace(' ', '_', $_FILES['attachments']['name'][$i]);
                    if (move_uploaded_file($tmp_name, $base_upload_path . '/' . $name)) {
                        $files[]['file_path'] = $name;
                    } else {
                        $file_upload_complete = false;
                        break;
                    }
                }
            }

            if ($file_upload_complete) {
                $data = array();
                if (isset($inputs['subject'])) {
                    $data['subject'] = $inputs['subject'];
                }

                $data['receive_office'] = $user['office_id'];
                if (isset($inputs['office_name'])) {
                    $data['sender_office_name'] = $inputs['office_name'];
                }
                $data['letter_nature'] = "counter_receive";
                if (isset($inputs['sender_name'])) {
                    $data['sender_name'] = $inputs['sender_name'];
                }

                if (isset($inputs['address'])) {
                    $data['sender_address'] = $inputs['address'];
                }

                if (isset($inputs['letter_media'])) {
                    $data['letter_media'] = $inputs['letter_media'];
                }

                $data['receive_date'] = strtotime($inputs['receive_date']) ? strtotime($inputs['receive_date']) : 0;

                $data['letter_date'] = time();

                $data['receive_user'] = $user['id'];

                if (sizeof($files) > 0) {
                    $data['is_hardcopy_attached'] = 1;

                } else {
                    $data['is_hardcopy_attached'] = 0;
                }
                $data['sarok_no'] = $inputs['sarok_no'];
                $data['created_by'] = $user['id'];
                $data['created_date'] = time();
                $data['status'] = 1;
                $receiveFileRegister = $this->ReceiveFileRegisters->patchEntity($receiveFileRegister, $data);

                if ($status = $this->ReceiveFileRegisters->save($receiveFileRegister)) {
                    $files_table = TableRegistry::get('files');
                    foreach ($files as $file) {
                        $file_data = array();
                        $file_data['file_path'] = $file['file_path'];
                        $file_data['table_name'] = 'receive_file_registers';
                        $file_data['table_key'] = $status['id'];
                        $file_data['created_by'] = $user['id'];
                        $file_data['created_date'] = time();
                        $file_data['status'] = 1;
                        $file_query = $files_table->query();
                        $file_query->insert(array_keys($file_data))
                            ->values($file_data)
                            ->execute();
                    }
                    /*Insert data into message_register table*/

                    //$message_register_data['sender_id']=$user['id'];
                    if (isset($inputs['sender_name'])) {
                        $message_register_data['sender_name'] = $inputs['sender_name'];
                    }

                    if (isset($inputs['subject'])) {
                        $message_register_data['subject'] = $inputs['subject'];
                    }

                    if (isset($inputs['description'])) {
                        $message_register_data['message_text'] = $inputs['description'];
                    }

                    $message_register_data['resource_id'] = $status['id'];
                    $message_register_data['attachment_type'] = Configure::read('attachment_type.4');
                    $message_register_data['created_date'] = time();
                    $message_register_data['created_by'] = $user['id'];
                    $message_register_data['status'] = 1;

                    $this->loadModel('MessageRegisters');
                    $messageRegisters = $this->MessageRegisters->newEntity();

                    $messageRegisters = $this->MessageRegisters->patchEntity($messageRegisters, $message_register_data);
                    $msg = $this->MessageRegisters->save($messageRegisters);

                    /*Insert data into recipient table*/
                    $default_recipients = TableRegistry::get('DefaultRecipients');
                    $default_recipient = $default_recipients->find()->where(['status' => 1])->first();
                    $recipient_data['message_register_id'] = $msg['id'];
                    $recipient_data['user_id'] = $default_recipient['user_id'];
                    $recipient_data['status'] = 1;
                    $recipient_data['created_by'] = $user['id'];
                    $recipient_data['created_date'] = time();

                    $this->loadModel('Recipients');
                    $recipients = $this->Recipients->newEntity();
                    $recipients = $this->Recipients->patchEntity($recipients, $recipient_data);
                    $this->Recipients->save($recipients);


                    $this->Flash->success(__('The receive file register has been saved.'));
                    return $this->redirect(['action' => 'index']);


                } else {
                    $this->Flash->error(__('The receive file register could not be saved. Please, try again.'));
                }
            } else {
                $this->Flash->error(__('File Upload Error. Please, try again.'));
            }


        }
        /*if($user['user_group_id']==1)
        {
            $projects = $this->NothiRegisters->Projects->find('list');
            $schemes = $this->NothiRegisters->Schemes->find('list');
        }
        else*/
        {
            $projects = $this->ReceiveFileRegisters->Projects->find('list')
                ->innerJoin('project_offices', 'project_offices.project_id = Projects.id')
                ->where(['project_offices.office_id' => $user['office_id']]);

            $schemes = $this->ReceiveFileRegisters->Schemes->find('list')
                ->innerJoin('project_offices', 'project_offices.project_id = Schemes.project_id')
                ->leftJoin('projects', 'projects.id = Schemes.project_id')
                ->where(['project_offices.office_id' => $user['office_id']]);

        }
        //$projects = $this->ReceiveFileRegisters->Projects->find('list');
        //$schemes = $this->ReceiveFileRegisters->Schemes->find('list');
        $this->loadModel('Offices');
        $offices = $this->Offices->find('list');
        $this->loadModel('Users');
        $users = $this->Users->find('list', ['conditions' => ['Users.office_id' => $user['office_id']]]);

        $this->loadModel('DirectionSetups');
        $directionSetups = $this->DirectionSetups->find('all', ['fields' => ['DirectionSetups.urgent_type', 'DirectionSetups.id', 'DirectionSetups.title']]);

        $this->set(compact('receiveFileRegister', 'projects', 'schemes', 'offices', 'users', 'directionSetups'));
        $this->set('_serialize', ['receiveFileRegister']);


    }

    public function delete($id = null)
    {
        $this->loadModel('ReceiveFileRegisters');
        $dak_file = $this->ReceiveFileRegisters->get($id);
        $result = $this->ReceiveFileRegisters->delete($dak_file);

        $this->loadModel('MessageRegisters');

        $result2 = $this->MessageRegisters->deleteAll(['MessageRegisters.resource_id'=>$id]);

        $this->loadModel('Recipients');
        $result3 = $this->Recipients->deleteAll(['Recipients.message_register_id' => $id]);

        $this->loadModel('Files');
        $result4 = $this->Files->deleteAll(['Files.table_name' => 'receive_file_registers','Files.table_key'=>$id]);

        if ($result && $result2 && $result3 && $result4) {
            $this->Flash->success(__('The Dak file has been deleted.'));

        } else {
            $this->Flash->error(__('The Dak file could not deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    //Ajax
    public function ajax($action = null)
    {
        if ($action == 'get_grid_data') {
            $user = $this->Auth->user();
            if ($user['user_group_id'] == 1) {
                $receiveFileRegisters = $this->ReceiveFileRegisters->find('all', [
                    'conditions' => ['ReceiveFileRegisters.status !=' => 99], 'order' => ['ReceiveFileRegisters.id' => 'DESC']
                ])
                    ->toArray();
            } else {
                $receiveFileRegisters = $this->ReceiveFileRegisters->find('all', [
                    'conditions' => ['ReceiveFileRegisters.status !=' => 99, 'receive_office' => $user['office_id']], 'order' => ['ReceiveFileRegisters.id' => 'DESC']
                ])
                    ->toArray();
            }

            foreach ($receiveFileRegisters as &$receiveFileRegister) {
                $receiveFileRegister['action'] = '<a class="icon-newspaper" href="' . $this->request->webroot . 'ReceiveFileRegisters/view/' . $receiveFileRegister['id'] . '" ><a>';
                $receiveFileRegister['action'] = $receiveFileRegister['action'] . '&nbsp;<a class="icon-remove3" href="' . $this->request->webroot . 'ReceiveFileRegisters/delete/' . $receiveFileRegister['id'] . '" ><a>';
                $receiveFileRegister['receive_date'] = date('d/m/Y', $receiveFileRegister['receive_date']);
            }
            $this->response->body(json_encode($receiveFileRegisters));
            return $this->response;
        }

    }

    //    Print report
    public function print_it()
    {
        $user = $this->Auth->user();
        $this->layout = 'print';
        $this->view = 'print';
        $officeTable = TableRegistry::get('offices');
        if ($this->request->data('type') == 'by_date') {
            $start_date = strtotime($this->request->data('start_date') . '00:00:00 GMT');// TODO:check time issue
            $end_date = strtotime($this->request->data('end_date') . '23:59:59 GMT');// TODO:check time issue
            if ($user['user_group_id'] == 1) {
                $receiveFileRegisters = $this->ReceiveFileRegisters->find('all', [
                    'conditions' => [
                        'ReceiveFileRegisters.status !=' => 99,
                        'ReceiveFileRegisters.receive_date >=' => $start_date,
                        'ReceiveFileRegisters.receive_date <=' => $end_date,
                    ],
                ])
                    ->toArray();
            } else {
                $receiveFileRegisters = $this->ReceiveFileRegisters->find('all', [
                    'conditions' => [
                        'ReceiveFileRegisters.status !=' => 99,
                        'receive_office' => $user['office_id'],
                        'ReceiveFileRegisters.receive_date >=' => $start_date,
                        'ReceiveFileRegisters.receive_date <=' => $end_date,
                    ],
                ])
                    ->toArray();
            }
        } else {
            if ($user['user_group_id'] == 1) {
                $receiveFileRegisters = $this->ReceiveFileRegisters->find('all', [
                    'conditions' => [
                        'ReceiveFileRegisters.status !=' => 99,
                        'ReceiveFileRegisters.receive_date >=' => strtotime('00:00'),// TODO:check time issue
                        'ReceiveFileRegisters.receive_date <=' => strtotime('23:59'),// TODO:check time issue
                    ],
                ])
                    ->toArray();
            } else {
                $receiveFileRegisters = $this->ReceiveFileRegisters->find('all', [
                    'conditions' => [
                        'ReceiveFileRegisters.status !=' => 99,
                        'receive_office' => $user['office_id'],
                        'ReceiveFileRegisters.receive_date >=' => strtotime('00:00'),// TODO:check time issue
                        'ReceiveFileRegisters.receive_date <=' => strtotime('23:59'),// TODO:check time issue
                    ],
                ])
                    ->toArray();
            }
        }
        // Office Info
        $office = $officeTable->find()
            ->where(['id' => $user['office_id']])
            ->first();
        $this->set(compact('receiveFileRegisters', 'office'));
    }
}
