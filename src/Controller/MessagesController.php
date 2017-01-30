<?php


namespace App\Controller;

use App\Controller\AppController;
use App\Model\Table\RecipientsTable;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Psy\Presenter\ExceptionPresenter;

class MessagesController extends AppController
{
    public function index()
    {

    }

    public function view($id = null)
    {
        if ($id == null) {
            $this->Flash->error(__("Message not found."));
            return $this->redirect(['action' => 'index']);
        }
        $user = $this->Auth->user();
        $this->loadModel('MessageRegisters');

        $messages = $this->MessageRegisters->find()
            ->autoFields(true)
            ->where(['MessageRegisters.id' => $id])
            ->contain(['Users', 'Users.Designations', 'Recipients', 'Recipients.Users', 'Recipients.Users.Designations', 'Projects', 'Schemes'])
            ->first();


        if ($messages['recipients'][0]['user_id'] == $user['id']) {
            $message = $this->MessageRegisters->get($id);
            $data_msg['is_read'] = 1;
            $message = $this->MessageRegisters->patchEntity($message, $data_msg);
            $this->MessageRegisters->save($message);
        }


        if ($this->request->is('post')) {
            $inputs = $this->request->data;
            /*echo "<pre>";
            print_r($inputs);
            echo "</pre>";
            die;*/
            $files = array();
            $file_upload_complete = true;
            $has_file = false;
            if ($_FILES['attachments']['name']) {
                $base_upload_path = WWW_ROOT . 'files/receive_files';
                for ($i = 0; $i < sizeof($_FILES['attachments']['name']); $i++) {
                    $tmp_name = $_FILES['attachments']['tmp_name'][$i];
                    //Get the temp file path
                    if ($tmp_name) {

                        $name = time() . '_' . str_replace(' ', '_', $_FILES['attachments']['name'][$i]);
                        if (move_uploaded_file($tmp_name, $base_upload_path . '/' . $name)) {
                            $files[]['file_path'] = $name;
                            $has_file = true;

                        } else {
                            $file_upload_complete = false;
                            break;
                        }
                    }
                }
            }


            $data = array();
            $data['sender_id'] = $user['id'];
            if (isset($inputs['subject'])) {
                $data['subject'] = $inputs['subject'];
            } else {
                $data['subject'] = "Re: " . $messages['subject'];
            }
            $data['message_text'] = strip_tags($inputs['message_text'], '<br>,<b>,<i>,<h1>,<h2>,<h3>,<h4>,<h5>,<h6>,<u>');
            $data['reference_msg_id'] = $id;
            $data['msg_type'] = $inputs['tag'];
            $data['attachment_type'] = Configure::read('attachment_type.0');

            $data['created_date'] = time();
            $data['created_by'] = $user['id'];
            if ($messages['thread_id']) {
                $data['thread_id'] = $messages['thread_id'];
            } else {
                $data['thread_id'] = $id;
            }

            if ($has_file) {
                $data['is_attached'] = 1;
            }

            $data['status'] = 1;

            if (isset($inputs['reply_deadline'])) {
                $data['reply_deadline'] = strtotime($inputs['reply_deadline']);
            }

            $this->loadModel('MessageRegisters');
            $messageRegisters = $this->MessageRegisters->newEntity();

            $messageRegisters = $this->MessageRegisters->patchEntity($messageRegisters, $data);

            if ($msg = $this->MessageRegisters->save($messageRegisters)) {
                if ($has_file) {
                    $files_table = TableRegistry::get('files');
                    $message_register_table = TableRegistry::get('message_registers');
                    foreach ($files as $file) {
                        $file_data = array();
                        $file_data['file_path'] = $file['file_path'];
                        $file_data['table_name'] = 'message_registers';
                        $file_data['table_key'] = $msg['id'];
                        $file_data['created_by'] = $user['id'];
                        $file_data['created_date'] = time();
                        $file_data['status'] = 1;
                        $file_query = $files_table->query();
                        $file_query->insert(array_keys($file_data))
                            ->values($file_data)
                            ->execute();
                    }
                }


                /*Insert data into recipient table*/
                if ($inputs['tag'] == 'forward') {

                    if (isset($inputs['reply_deadline'])) {
                        $task_data = array();
                        $task_data['user_id'] = $user['id'];
                        $task_data['type'] = "Other";
                        $task_data['title'] = $inputs['subject'];
                        $task_data['start_date_time'] = strtotime($inputs['reply_deadline']);
                        $task_data['end_date_time'] = strtotime($inputs['reply_deadline']);

                        $task_data['priority'] = "Normal";


                        $task_data['status'] = 1;
                        $task_data['created_date'] = time();
                        $task_data['created_by'] = $user['id'];


                        $this->loadModel('TaskManagement');
                        $tasks = $this->TaskManagement->newEntity();
                        $tasks = $this->TaskManagement->patchEntity($tasks, $task_data);
                        $ref = $this->TaskManagement->save($tasks);

                        $task_data['reference_msg_id'] = $ref['id'];

                        foreach ($inputs['user'] as $user_id) {
                            $task_data['user_id'] = $user_id;
                            $tasks = $this->TaskManagement->newEntity();
                            $tasks = $this->TaskManagement->patchEntity($tasks, $task_data);
                            $this->TaskManagement->save($tasks);
                        }


                        $recipient_data['message_register_id'] = $msg['id'];
                        $recipient_data['user_id'] = $user_id;
                        $recipient_data['created_date'] = time();
                        $recipient_data['created_by'] = $user['id'];
                        $recipient_data['status'] = 1;

                        $this->loadModel('Recipients');
                        $recipients = $this->Recipients->newEntity();
                        $recipients = $this->Recipients->patchEntity($recipients, $recipient_data);
                        $this->Recipients->save($recipients);
                    }
                }

                if ($inputs['tag'] == 'reply') {
                    $recipient_data['message_register_id'] = $msg['id'];
                    $recipient_data['user_id'] = $messages->sender_id;
                    $recipient_data['created_date'] = time();
                    $recipient_data['created_by'] = $user['id'];
                    $recipient_data['status'] = 1;

                    $this->loadModel('Recipients');
                    $recipients = $this->Recipients->newEntity();
                    $recipients = $this->Recipients->patchEntity($recipients, $recipient_data);
                    $this->Recipients->save($recipients);
                }

                if ($has_file && $inputs['tag'] == 'reply') {
                    if ($messages->thread_id) {
                        $msg_data['resource_id'] = $messages->thread_id;
                    } else {
                        $msg_data['resource_id'] = $msg['id'];
                    }

                }
                $this->Flash->success(__('Message sent successfully.'));
                return $this->redirect(['action' => 'index']);


            } else {
                $this->Flash->error(__('Message could not sent. Please, try again.'));
            }
        }

        $attachments = TableRegistry::get('files');
        $attachments = $attachments->find()
            ->where(['files.table_name' => 'message_registers', 'files.table_key' => $messages->id])
            ->toArray();

        $reply = $this->MessageRegisters->find()
            ->autoFields(true)
            ->select(['users.name_en', 'designations.name_en'])
            ->where(['MessageRegisters.thread_id' => $id, 'MessageRegisters.msg_type' => 'reply'])
            ->leftJoin('users', 'users.id=MessageRegisters.sender_id')
            ->leftJoin('designations', 'designations.id=users.designation_id')
            ->order(['MessageRegisters.created_date' => 'DESC']);

        foreach ($reply as $value) {
            if ($value->is_attached) {
                $arr = array();
                $attachment = TableRegistry::get('files');
                $attachment = $attachment->find()
                    ->where(['files.table_name' => 'message_registers', 'files.table_key' => $value->id])
                    ->toArray();
                $i = 0;
                foreach ($attachment as $data) {
                    $arr[$i]['file_path'] = $data['file_path'];
                    $i++;
                }
                $value['files'] = $arr;

            }
        }
        $reply = $reply->toArray();


        $this->loadModel('Departments');
        $departments = $this->Departments->find('all', ['contain' => ['Users', 'Users.Designations'], 'conditions' => ['Departments.office_id' => $user['office_id']]]);
        $this->set(compact('departments', 'messages', 'attachments', 'reply'));
    }

    public function add()
    {
        $user = $this->Auth->user();

        if ($this->request->is('post')) {

            $inputs = $this->request->data;
            //print_r($inputs);
            //die;

            $files = array();
            $file_upload_complete = true;
            $has_file = false;


            if ($_FILES['attachments']['name']) {
                echo "hi";
                $base_upload_path = WWW_ROOT . 'files/receive_files';
                for ($i = 0; $i < sizeof($_FILES['attachments']['name']); $i++) {
                    $tmp_name = $_FILES['attachments']['tmp_name'][$i];
                    //Get the temp file path
                    if ($tmp_name) {

                        $name = time() . '_' . str_replace(' ', '_', $_FILES['attachments']['name'][$i]);
                        if (move_uploaded_file($tmp_name, $base_upload_path . '/' . $name)) {
                            $files[]['file_path'] = $name;
                            $has_file = true;

                        } else {
                            $file_upload_complete = false;
                            break;
                        }
                    }
                }
            }

            $data = array();
            $data['sender_id'] = $user['id'];
            $data['subject'] = $inputs['subject'];
            $data['msg_type'] = "original";
            $data['attachment_type'] = Configure::read('attachment_type.0');
            if (isset($inputs['project_id'])) {
                $data['project_id'] = $inputs['project_id'];
            }

            if (isset($inputs['scheme_id'])) {
                $data['scheme_id'] = $inputs['scheme_id'];
            }

            if (isset($inputs['work_description'])) {
                $data['work_description'] = $inputs['work_description'];
            }
            $data['message_text'] = strip_tags($inputs['message_text'], '<br>,<b>,<i>,<h1>,<h2>,<h3>,<h4>,<h5>,<h6>,<u>');
            $data['created_date'] = time();
            $data['created_by'] = $user['id'];
            $data['status'] = 1;
            if (isset($inputs['reply_deadline'])) {
                $data['reply_deadline'] = $inputs['reply_deadline'];
            }

            if ($has_file) {
                $data['is_attached'] = 1;
            }

            $this->loadModel('MessageRegisters');


            $error = true;
            foreach ($inputs['user'] as $user_id) {
                $messageRegisters = $this->MessageRegisters->newEntity();
                $messageRegisters = $this->MessageRegisters->patchEntity($messageRegisters, $data);
                $msg = $this->MessageRegisters->save($messageRegisters);
                if ($has_file) {
                    $files_table = TableRegistry::get('files');
                    foreach ($files as $file) {
                        $file_data = array();
                        $file_data['file_path'] = $file['file_path'];
                        $file_data['table_name'] = 'message_registers';
                        $file_data['table_key'] = $msg['id'];
                        $file_data['created_by'] = $user['id'];
                        $file_data['created_date'] = time();
                        $file_data['status'] = 1;
                        $file_query = $files_table->query();
                        $file_query->insert(array_keys($file_data))
                            ->values($file_data)
                            ->execute();
                    }
                }

                if (isset($inputs['reply_deadline'])) {
                    $task_data = array();
                    $task_data['user_id'] = $user['id'];
                    $task_data['type'] = "Other";
                    $task_data['title'] = $inputs['subject'];
                    $task_data['description'] = strip_tags($inputs['message_text'], '<br>,<b>,<i>,<h1>,<h2>,<h3>,<h4>,<h5>,<h6>,<u>');
                    $task_data['start_date_time'] = strtotime($inputs['reply_deadline']);
                    $task_data['end_date_time'] = strtotime($inputs['reply_deadline']);
                    $task_data['priority'] = "Normal";
                    $task_data['status'] = 1;
                    $task_data['created_date'] = time();
                    $task_data['created_by'] = $user['id'];

                    $this->loadModel('TaskManagement');
                    $tasks = $this->TaskManagement->newEntity();
                    $tasks = $this->TaskManagement->patchEntity($tasks, $task_data);
                    $ref = $this->TaskManagement->save($tasks);

                    $task_data['reference_msg_id'] = $ref['id'];


                    $task_data['user_id'] = $user_id;
                    $tasks = $this->TaskManagement->newEntity();
                    $tasks = $this->TaskManagement->patchEntity($tasks, $task_data);
                    $this->TaskManagement->save($tasks);


                }
                /*Insert data into recipient table*/


                $recipient_data['message_register_id'] = $msg['id'];
                $recipient_data['user_id'] = $user_id;
                $recipient_data['created_date'] = time();
                $recipient_data['created_by'] = $user['id'];
                $recipient_data['status'] = 1;

                $this->loadModel('Recipients');
                $recipients = $this->Recipients->newEntity();
                $recipients = $this->Recipients->patchEntity($recipients, $recipient_data);
                $this->Recipients->save($recipients);

                $error = false;

            }

            if ($error) {
                $this->Flash->success('Message could not sent. Please, try again.');
            } else {
                $this->Flash->success('Message sent successfully.');
                return $this->redirect(['action' => 'sent']);
            }
        }
        $this->loadModel('Departments');
        $departments = $this->Departments->find('all', ['contain' => ['Users', 'Users.Designations'], 'conditions' => ['Departments.office_id' => $user['office_id']]]);
        $this->loadModel('Projects');
        $projects = $this->Projects->find('list')
            ->innerJoin('project_offices', 'project_offices.project_id = Projects.id')
            ->where(['project_offices.office_id' => $user['office_id']]);
        $this->loadModel('Schemes');
        $arr = array();
        foreach ($projects as $key => $project) {
            $arr[$key] = substr($project, 0, 100) . '...';
            $arr[$key] = substr($arr[$key], 0, strrpos($arr[$key], ' ')) . ' ... ';
        }
        $projects = $arr;
        $schemes = $this->Schemes->find('list')
            ->innerJoin('project_offices', 'project_offices.project_id = Schemes.project_id')
            ->leftJoin('projects', 'projects.id = Schemes.project_id')
            ->where(['project_offices.office_id' => $user['office_id']]);
        $arr = array();
        foreach ($schemes as $key => $scheme) {
            $arr[$key] = substr($scheme, 0, 100);
            $arr[$key] = substr($arr[$key], 0, strrpos($arr[$key], ' ')) . ' ... ';

        }
        $schemes = $arr;

        $this->set(compact('departments', 'projects', 'schemes'));
    }

    public function sent()
    {

    }

    public function ajax($action = null)
    {
        if ($action == 'get_grid_data') {
            $user = $this->Auth->user();
            $this->loadModel('MessageRegisters');
            /*$messages = $this->MessageRegisters->find('all', [
                'conditions' => ['MessageRegisters.sender_id' => $user['id'],'MessageRegisters.msg_type'=>'original'],
            ]);*/

            $messages = $this->MessageRegisters->find()
                ->autoFields(true)
                ->where(['MessageRegisters.attachment_type' => Configure::read('attachment_type.0'), 'MessageRegisters.msg_type' => 'forward'])
                ->orWhere(['MessageRegisters.attachment_type' => Configure::read('attachment_type.0'), 'MessageRegisters.msg_type' => 'reply'])
                ->orWhere(['MessageRegisters.attachment_type' => Configure::read('attachment_type.0'), 'MessageRegisters.msg_type' => 'original'])
                ->orWhere(['MessageRegisters.msg_type' => 'individual'])
                ->orWhere(['MessageRegisters.msg_type' => 'labBill'])
                ->orWhere(['MessageRegisters.msg_type' => 'hireCharges'])
                ->orWhere(['MessageRegisters.msg_type' => 'raBill'])
                ->orWhere(['MessageRegisters.msg_type' => 'Approve_raBill'])
                ->leftJoin('recipients', 'recipients.message_register_id=MessageRegisters.id')
                ->where(['recipients.user_id' => $user['id']])
                ->order(['MessageRegisters.created_date' => "DESC"])
                ->toArray();


            foreach ($messages as $message) {
                if ($message->thread_id) {
                    $message['action'] = '<a class="icon-newspaper" href="' . $this->request->webroot . 'Messages/view/' . $message['thread_id'] . '" ><a>';
                } else {
                    $message['action'] = '<a class="icon-newspaper" href="' . $this->request->webroot . 'Messages/view/' . $message['id'] . '" ><a>';
                }

                $message['created_date'] = date('d/m/Y', $message['created_date']);
                if ($user['id'] == $message['sender_id']) {
                    $message['msg_type'] = "Sent";
                } else {
                    $message['msg_type'] = "Received";
                }
            }
            $this->response->body(json_encode($messages));
            return $this->response;
        }

        if ($action == 'sent') {
            $user = $this->Auth->user();
            $this->loadModel('MessageRegisters');
            $messages = $this->MessageRegisters->find()
                ->where(['MessageRegisters.sender_id' => $user['id'], 'MessageRegisters.msg_type' => 'original', 'MessageRegisters.attachment_type' => Configure::read('attachment_type.0')])
                ->orWhere(['MessageRegisters.sender_id' => $user['id'], 'MessageRegisters.msg_type' => 'reply', 'MessageRegisters.attachment_type' => Configure::read('attachment_type.0')])
                ->order(['MessageRegisters.created_date' => 'DESC']);


            foreach ($messages as $message) {
                $message['action'] = '<a class="icon-newspaper" href="' . $this->request->webroot . 'Messages/view/' . $message['id'] . '" ><a>';
                $message['created_date'] = date('d/m/Y', $message['created_date']);
                if ($user['id'] == $message['sender_id']) {
                    $message['msg_type'] = "Sent";
                } else {
                    $message['msg_type'] = "Received";
                }
            }
            $this->response->body(json_encode($messages));
            return $this->response;
        }

        if ($action == "get_users") {
            $this->loadModel('Users');
            $users = $this->Users->find('all', ['contain' => ['Designations'], 'conditions' => ['Users.department_id' => $this->request->data('department')]]);
            $data = array();
            $i = 0;
            foreach ($users as $user) {
                $data[$i]['id'] = $user->id;
                $data[$i]['name'] = $user->name_en . " (" . $user->designation->name_en . ")";
                $i++;
            }

            $this->response->body(json_encode($data));
            return $this->response;


        }

    }
}