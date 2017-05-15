<?php


namespace App\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class MyFilesController extends AppController
{
    public function index()
    {

    }

    /**
     * @param null $id
     */
    public function view($id = null)
    {
        $user = $this->Auth->user();
        $this->loadModel('MessageRegisters');
        $read['is_read'] = 1;


        $my_file = $this->MessageRegisters->get($id, ['contain' => ['Users', 'Users.Designations', 'Projects', 'Recipients', 'Schemes']]);
        $file_read = $this->MessageRegisters->patchEntity($my_file, $read);
        $this->MessageRegisters->save($file_read);

        if (empty($my_file['resource_id'])) {
            $my_file['resource_id'] = $my_file['thread_id'];
        }

        $query = TableRegistry::get('Files');
        $attach = $query
            ->find()
            ->where(['table_key' => $my_file['resource_id'], 'table_name' => 'receive_file_registers'])
            ->toArray();
        $query = TableRegistry::get('Files');
        $attach2 = $query
            ->find()
            ->where(['table_key' => $my_file['id'], 'table_name' => 'message_registers'])
            ->toArray();
        foreach($attach2 as $dd)
            $attach[] = $dd;
        if ($my_file->msg_type == "reply") {

            $query = TableRegistry::get('Files');
            $reply_attach = $query
                ->find()
                ->where(['table_key' => $id, 'table_name' => 'message_registers']);
            $this->set(compact('reply_attach'));
        }

        /********************History*****************************/
        $this->loadModel('MessageRegisters');
        $history = $this->MessageRegisters->find('all')
            ->select(['recipients.user_id', 'users.id', 'users.name_en', 'designations.name_en'])
            ->autoFields(true)
            ->where(['MessageRegisters.reference_msg_id' => $my_file->id])
            ->orWhere(['MessageRegisters.id' => $my_file->id])
            ->leftJoin('recipients', 'recipients.message_register_id=MessageRegisters.id')
            ->leftJoin('users', 'users.id=MessageRegisters.sender_id')
            ->leftJoin('designations', 'designations.id=users.designation_id')
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


        $office_id = $this->Auth->user('office_id');
        $this->loadModel('Departments');

        $departments = $this->Departments->find()->hydrate(false)
            ->select(['designations.name_bn', 'users.id', 'users.name_bn', 'Departments.name_bn'])
            ->where(['Departments.office_id' => $office_id])
            ->leftJoin('users', 'users.department_id=Departments.id and users.status=1')
            ->leftJoin('designations', 'designations.id=users.designation_id')
            ->order(['Departments.order_no' => 'asc', 'designations.order_no' => 'asc']);

        $this->loadModel('DirectionSetups');
        $directions = $this->DirectionSetups->find('all');

        if ($my_file->reference_msg_id && $my_file->msg_type == "reply") {
            $reply_msg = $my_file;
            $my_file = $this->MessageRegisters->get($my_file->reference_msg_id, ['contain' => ['Projects', 'Recipients']]);
            $this->set(compact('reply_msg'));
        } elseif ($my_file->reference_msg_id && $my_file->msg_type == "forward") {
            $forward_msg = $my_file;
            $my_file = $this->MessageRegisters->get($my_file->reference_msg_id, ['contain' => ['Projects', 'Recipients']]);
            $this->set(compact('forward_msg'));
        } elseif ($my_file->reference_msg_id) {
            $my_file = $this->MessageRegisters->get($my_file->reference_msg_id, ['contain' => ['Projects', 'Recipients']]);
            $this->set(compact('reply_msg'));
        }

        if ($my_file->thread_id) {
            $this->loadModel('ReceiveFileRegisters');
            $receiveFileRegister = $this->ReceiveFileRegisters->find()
                ->autoFields(true)
                ->select(['nothi_assigns.nothi_register_id'])
                ->where(['ReceiveFileRegisters.id' => $my_file->thread_id])
                ->leftJoin('nothi_assigns', 'nothi_assigns.receive_file_register_id=ReceiveFileRegisters.id')
                ->first();
        } else {
            $this->loadModel('ReceiveFileRegisters');
            $receiveFileRegister = $this->ReceiveFileRegisters->find()
                ->autoFields(true)
                ->select(['nothi_assigns.nothi_register_id'])
                ->where(['ReceiveFileRegisters.id' => $my_file->resource_id])
                ->leftJoin('nothi_assigns', 'nothi_assigns.receive_file_register_id=ReceiveFileRegisters.id')
                ->first();
        }
        //  Conditions for modal
        $receiveFileRegisterId = $receiveFileRegister->id;
        $this->loadModel('LetterIssueRegisters');
        $letterIssueData = $this->LetterIssueRegisters->find()
            ->where(['receive_file_register_id' => $receiveFileRegisterId ])
            ->hydrate(false)
            ->first();
        // Approval check
        $this->loadModel('LetterApprovals');
        $letterApproval = $this->LetterApprovals->find()
            ->select('id')
            ->where(['receive_file_register_id' => $receiveFileRegisterId, 'user_id' => $user['id']])
            ->first();
        $signatures = $this->LetterApprovals->find()
            ->where(['receive_file_register_id' => $receiveFileRegisterId])
            ->contain('users')
            ->hydrate(false)
            ->toArray();
        $this->set(compact('my_file', 'attach', 'departments', 'directions', 'history', 'receiveFileRegister','receiveFileRegisterId','letterIssueData','letterApproval','signatures'));
    }

    public function edit($id = null)
    {

        $user = $this->Auth->user();
        $this->loadModel('ReceiveFileRegisters');
        $receiveFileRegister = $this->ReceiveFileRegisters->find()
            ->autoFields(true)
            ->select(['nothi_registers.nothi_no', 'nothi_assigns.nothi_register_id', 'message_registers.id', 'message_registers.message_text', 'message_registers.attachment_type'])
            ->where(['ReceiveFileRegisters.id' => $id])
            ->leftJoin('message_registers', 'message_registers.resource_id=ReceiveFileRegisters.id')
            ->leftJoin('nothi_assigns', 'nothi_assigns.receive_file_register_id=ReceiveFileRegisters.id')
            ->leftJoin('nothi_registers', 'nothi_registers.id=nothi_assigns.nothi_register_id')
            ->first();
//pr($receiveFileRegister);die;
        if ($this->request->is(['post', 'put', 'patch'])) {
            $inputs = $this->request->data();

            $data = array();

            if (!empty($inputs['parent_id'])) {
                $this->loadModel('nothi_assigns');

                $nothi_file = $this->nothi_assigns->find()
                    ->where(['receive_file_register_id' => $id])
                    ->first();

                if (!empty($nothi_file)) {
                    $arr = array();
                    $arr['nothi_register_id'] = $inputs['parent_id'];
                    $nothi = $this->nothi_assigns->patchEntity($nothi_file, $arr);
                    $this->nothi_assigns->save($nothi);
                } else {
                    $nothi_data = array();
                    $nothi_data['nothi_register_id'] = $inputs['parent_id'];
                    $nothi_data['receive_file_register_id'] = $id;
                    $new_nothi = $this->nothi_assigns->newEntity();
                    $nothi = $this->nothi_assigns->patchEntity($new_nothi, $nothi_data);
                    $this->nothi_assigns->save($nothi);
                }

            }

            if (isset($inputs['sender_name'])) {
                $data['sender_name'] = $inputs['sender_name'];
            }

            if (isset($inputs['sender_address'])) {
                $data['sender_address'] = $inputs['sender_address'];
            }

            if (isset($inputs['sender_office_name'])) {
                $data['sender_office_name'] = $inputs['sender_office_name'];
            }

            if (isset($inputs['subject'])) {
                $data['subject'] = $inputs['subject'];
            }
            if (isset($inputs['sarok_no'])) {
                $data['sarok_no'] = $inputs['sarok_no'];
            }

            if (isset($inputs['project_id'])) {
                $data['project_id'] = $inputs['project_id'];
            }

            if (isset($inputs['scheme_id'])) {
                $data['scheme_id'] = $inputs['scheme_id'];
            }
            if (isset($inputs['is_guard_file'])) {
                $data['is_guard_file'] = $inputs['is_guard_file'];
            }
            if (isset($inputs['is_resolution'])) {
                $data['is_resolution'] = $inputs['is_resolution'];
            }
            if (isset($inputs['letter_description'])) {
                $data['letter_description'] = $inputs['letter_description'];
            }
            $update_receive_file_registers = TableRegistry::get('ReceiveFileRegisters');
            $update_receive_file_register = $update_receive_file_registers->get($id);
            $update_receive_file_registers->patchEntity($update_receive_file_register, $data);
            $update_receive_file_registers->save($update_receive_file_register);

            $attachment = TableRegistry::get('MessageRegisters');
            $attachment = $attachment->find()->where(['MessageRegisters.resource_id' => $id])->first();

            $msg = array();
            if (isset($inputs['work_description'])) {
                $msg['work_description'] = $inputs['work_description'];
            }
            if (isset($inputs['project_id'])) {
                $msg['project_id'] = $inputs['project_id'];
            }
            if (isset($inputs['scheme_id'])) {
                $msg['scheme_id'] = $inputs['scheme_id'];
            }
            if (isset($inputs['description'])) {
                $msg['message_text'] = $inputs['description'];
            }

            $update_message_registers = TableRegistry::get('MessageRegisters');
            $update_message_register = $update_message_registers->get($attachment['id']);

//            $update_message_register->work_description ='dfsf';
            $update_message_registers->patchEntity($update_message_register, $msg);
            /* echo '<pre>';
             print_r(update_message_registers);
             echo '</pre>';
             die;*/
            $update_message_registers->save($update_message_register);

            $this->loadModel('history_receive_file_registers');
            $dak_file = $this->history_receive_file_registers->find()
                ->where(['receive_file_register_id' => $id])
                ->count();

            if ($dak_file > 0 || $receiveFileRegister->is_guard || $receiveFileRegister->is_resolution || $receiveFileRegister['nothi_assigns']['nothi_register_id'] || $receiveFileRegister->project_id || $receiveFileRegister->scheme_id || $receiveFileRegister->sarok_no) {
                $history['user_id'] = $user['id'];
                $history['sarok_no'] = $receiveFileRegister->sarok_no;
                $history['project_id'] = $receiveFileRegister->project_id;
                $history['scheme_id'] = $receiveFileRegister->scheme_id;
                $history['is_guard'] = $receiveFileRegister->is_guard;
                $history['is_resolution'] = $receiveFileRegister->is_resolution;
                $history['receive_file_register_id'] = $receiveFileRegister->id;
                $history['created_date'] = time();
                $history['nothi_register_id'] = $receiveFileRegister['nothi_assigns']['nothi_register_id'];

                $file_history = $this->history_receive_file_registers->newEntity();
                $file_history = $this->history_receive_file_registers->patchEntity($file_history, $history);
                $this->history_receive_file_registers->save($file_history);

            }

            // Forward file

            if (isset($inputs['name'])) {

                $this->loadModel('Users');
                $dept = $this->Users->find()
                    ->select(['departments.keyword', 'Users.department_id'])
                    ->distinct(['Users.department_id'])
                    ->where(['Users.id IN' => $inputs['name']])
                    ->leftJoin('departments', 'departments.id=Users.department_id');


                /*Insert Data into Vehicle Hire Letter Register table*/

                foreach ($dept as $value) {

                    if ($value['departments']['keyword'] == Configure::read('departments.MECHANICAL') && $receiveFileRegister['message_registers']['attachment_type'] == Configure::read('attachment_type.4')) {
                        $vehicle['subject'] = $inputs['subject'];
                        $vehicle['receive_office'] = $user['office_id'];
                        $vehicle['resource_id'] = $receiveFileRegister->id;
                        $vehicle['receive_date'] = time();
                        if (isset($inputs['sarok_no'])) {
                            $vehicle['sarok_no'] = $inputs['sarok_no'];
                        }

                        if (isset($inputs['scheme_id'])) {
                            $vehicle['scheme_id'] = $inputs['scheme_id'];
                        }
                        $vehicle['receive_from'] = $receiveFileRegister['sender_name'];


                        if (isset($inputs['work_description'])) {
                            $vehicle['work_description'] = $inputs['work_description'];
                        }

                        $vehicle['created_by'] = $user['id'];
                        $vehicle['created_date'] = time();
                        $vehicle['status'] = 1;

                        $this->loadModel('VehicleHireLetterRegisters');
                        $vehicle_registers = $this->VehicleHireLetterRegisters->newEntity();

                        $vehicle_registers = $this->VehicleHireLetterRegisters->patchEntity($vehicle_registers, $vehicle);
                        $this->VehicleHireLetterRegisters->save($vehicle_registers);

                    }

                    /*Insert Data into Lab Letter Register table*/

                    if ($value['departments']['keyword'] == Configure::read('departments.LAB') && $receiveFileRegister['message_registers']['attachment_type'] == Configure::read('attachment_type.4')) {
                        $lab['subject'] = $inputs['subject'];
                        $lab['office_id'] = $user['office_id'];
                        $lab['resource_id'] = $receiveFileRegister->id;
                        $lab['receive_from'] = $inputs['sender_name'];
                        $lab['receive_date'] = time();
                        if (isset($inputs['scheme_id'])) {
                            $lab['scheme_id'] = $inputs['scheme_id'];
                        }
                        $lab['received_from'] = $receiveFileRegister['sender_name'];
                        $lab['letter_date'] = $receiveFileRegister['receive_date'];


                        if (isset($inputs['work_description'])) {
                            $lab['work_description'] = $inputs['work_description'];
                        }

                        $lab['created_by'] = $user['id'];
                        $lab['created_date'] = time();
                        $lab['status'] = 1;

                        $this->loadModel('LabLetterRegisters');
                        $lab_registers = $this->LabLetterRegisters->newEntity();

                        $lab_registers = $this->LabLetterRegisters->patchEntity($lab_registers, $lab);
                        $this->LabLetterRegisters->save($lab_registers);

                    }
                }

                if (isset($inputs['individual_msg'])) {
                    $arr['sender_id'] = $user['id'];
                    $arr['subject'] = $inputs['subject'];
                    $arr['msg_type'] = "individual";
                    $arr['created_by'] = $user['id'];
                    $arr['created_date'] = time();
                    $arr['status'] = 1;

                    foreach ($inputs['individual_msg'] as $key => $value) {
                        $arr['message_text'] = $value;
                        $this->loadModel('MessageRegisters');
                        $messageRegisters = $this->MessageRegisters->newEntity();
                        $messageRegisters = $this->MessageRegisters->patchEntity($messageRegisters, $arr);
                        $msg = $this->MessageRegisters->save($messageRegisters);
                        $rec['message_register_id'] = $msg['id'];
                        $rec['user_id'] = $key;
                        $rec['created_date'] = time();
                        $rec['created_by'] = $user['id'];
                        $rec['status'] = 1;

                        $this->loadModel('Recipients');
                        $recipients = $this->Recipients->newEntity();
                        $recipients = $this->Recipients->patchEntity($recipients, $rec);
                        $this->Recipients->save($recipients);
                    }
                }
                /*Insert Data into Message Register table*/

                $data = array();
                $data['sender_id'] = $user['id'];
                if (isset($inputs['subject'])) {
                    $data['subject'] = $inputs['subject'];
                }
                if (isset($inputs['description'])) {
                    $data['message_text'] = $inputs['description'];
                }
                $data['reference_msg_id'] = $receiveFileRegister['message_registers']['id'];
                if (isset($inputs['read_only'])) {
                    $data['msg_flow_control'] = $inputs['read_only'];
                }

                $data['msg_type'] = "forward";
                $data['is_attached'] = 0;
                $data['attachment_type'] = Configure::read('attachment_type.4');

                $data['created_date'] = time();
                $data['created_by'] = $user['id'];
                if (isset($inputs['direction'])) {
                    $data['msg_direction'] = json_encode($inputs['direction']);
                }

                $data['is_out_side'] = 0;
                $data['thread_id'] = $id;
                $data['status'] = 1;

                if (isset($inputs['reply_deadline'])) {
                    $data['reply_deadline'] = strtotime($inputs['reply_deadline']);
                }

                $this->loadModel('MessageRegisters');
                $messageRegisters = $this->MessageRegisters->newEntity();

                $messageRegisters = $this->MessageRegisters->patchEntity($messageRegisters, $data);

                if ($msg = $this->MessageRegisters->save($messageRegisters)) {


                    if (isset($inputs['reply_deadline'])) {
                        $task_data = array();
                        $task_data['user_id'] = $user['id'];
                        $task_data['type'] = "Other";
                        $task_data['title'] = $inputs['subject'];
                        $task_data['description'] = $inputs['description'];
                        $task_data['start_date_time'] = strtotime($inputs['reply_deadline']);
                        $task_data['end_date_time'] = strtotime($inputs['reply_deadline']);

                        $task_data['priority'] = "Normal";

                        if (isset($inputs['direction'])) {
                            foreach ($inputs['direction'] as $direction) {
                                if ($direction == 7) {
                                    $task_data['priority'] = "Medium";
                                } elseif ($direction == 8) {
                                    $task_data['priority'] = "High";
                                }
                            }
                        }
                        $task_data['status'] = 1;
                        $task_data['created_date'] = time();
                        $task_data['created_by'] = $user['id'];

                        $this->loadModel('TaskManagement');
                        $tasks = $this->TaskManagement->newEntity();
                        $tasks = $this->TaskManagement->patchEntity($tasks, $task_data);
                        $ref = $this->TaskManagement->save($tasks);

                        $task_data['reference_msg_id'] = $ref['id'];

                        foreach ($inputs['name'] as $user_id) {
                            $task_data['user_id'] = $user_id;
                            $tasks = $this->TaskManagement->newEntity();
                            $tasks = $this->TaskManagement->patchEntity($tasks, $task_data);
                            $this->TaskManagement->save($tasks);

                        }
                    }

                    foreach ($inputs['name'] as $user_id) {
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

                $this->Flash->success(__('File update & forward successfully.'));
            } else {
                $this->Flash->success(__('File update successfully.'));
            }
            return $this->redirect(['action' => 'index']);


        }

        $files = TableRegistry::get('files');

        $files = $files->find()
            ->where(['files.table_key' => $receiveFileRegister['id'], 'files.table_name' => 'receive_file_registers'])
            ->toArray();

        $this->loadModel('Projects');
        $projects = $this->Projects->find('list')
            ->innerJoin('project_offices', 'project_offices.project_id = Projects.id')
            ->where(['project_offices.office_id' => $user['office_id']]);
        $arr = array();
        foreach ($projects as $key => $project) {
            $arr[$key] = substr($project, 0, 100) . '...';
            $arr[$key] = substr($arr[$key], 0, strrpos($arr[$key], ' ')) . ' ... ';
        }
        $projects = $arr;
        $this->loadModel('Schemes');
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

        $this->loadModel('NothiRegisters');
        $nothiRegisters = $this->NothiRegisters->find('list')
            ->select(['id', 'nothi_no'])
            ->where(['parent_id' => 0, 'status' => 1])
            ->toArray();

        $office_id = $this->Auth->user('office_id');
        $this->loadModel('Departments');
//        $departments = $this->Departments->find('all', ['contain' => ['Users' => ['conditions' => ['Users.status' => 1]], 'Users.Designations'], 'conditions' => ['Departments.office_id' => $office_id]]);
        $departments = $this->Departments->find()->hydrate(false)
            ->select(['designations.name_bn', 'users.id', 'users.name_bn', 'Departments.name_bn'])
            ->where(['Departments.office_id' => $office_id])
            ->leftJoin('users', 'users.department_id=Departments.id and users.status=1')
            ->leftJoin('designations', 'designations.id=users.designation_id')
            ->order(['Departments.order_no' => 'asc', 'designations.order_no' => 'asc']);
        $this->loadModel('DirectionSetups');
        $directions = $this->DirectionSetups->find('all');
        $this->set(compact('receiveFileRegister', 'projects', 'schemes', 'files', 'nothiRegisters', 'departments', 'directions'));
    }

    public function ajax($action = null)
    {
        if ($action == 'get_grid_data') {
            $user_id = $this->Auth->user('id');
            $this->loadModel('MessageRegisters');

            $querys = $this->MessageRegisters->find()
                ->autoFields(true)
                ->select(['designations.name_en', 'users.name_en'])
                ->where(['MessageRegisters.attachment_type' => Configure::read('attachment_type.4')])
                ->leftJoin('recipients', 'recipients.message_register_id=MessageRegisters.id')
                ->where(['recipients.user_id' => $user_id])
                ->leftJoin('users', 'users.id=MessageRegisters.sender_id')
                ->leftJoin('designations', 'designations.id=users.designation_id')
                ->order(['MessageRegisters.created_date' => 'DESC']);


            $my_files = array();
            foreach ($querys as $query) {

                $arr['action'] = '<a class="icon-newspaper" href="' . $this->request->webroot . 'MyFiles/view/' . $query['id'] . '" ><a>';
                if ($query['resource_id']) {
                    $arr['action'] = $arr['action'] . '&nbsp;<a class="icon-pencil3" href="' . $this->request->webroot . 'MyFiles/edit/' . $query['resource_id'] . '" ><a>';

                } else {
                    $arr['action'] = $arr['action'] . '&nbsp;<a class="icon-pencil3" href="' . $this->request->webroot . 'MyFiles/edit/' . $query['thread_id'] . '" ><a>';
                }
                $arr['action'] = $arr['action'] . '&nbsp;<a class="icon-arrow-right12" href="' . $this->request->webroot . 'Tracks/index/' . $query['id'] . '" ><a>';
                if ($query['is_forward'] == 1) {
                    $arr['action'] = $arr['action'] . '&nbsp;<span class="label label-warning">Fw</span>';
                } else if ($query['is_read'] == 1) {
                    $arr['action'] = $arr['action'] . '&nbsp;<span class="label label-success">R</span>';
                } else {
                    $arr['action'] = $arr['action'] . '&nbsp;<span class="label label-danger">N</span>';
                }


                $arr['subject'] = $query['subject'];
                $arr['created_date'] = date('d/m/Y', $query['created_date']);
                $arr['sender_name'] = (($query['is_out_side'] == 1) ? $query['sender_name'] : $query['users']['name_en']);
                $arr['sender_designation'] = (($query['is_out_side'] == 1) ? $query['sender_designation'] : $query['designations']['name_en']);
                $my_files[] = $arr;
            }


            $this->response->body(json_encode($my_files));
            return $this->response;
        }


    }

    public function forward($id = null)
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->user();
            $this->loadModel('MessageRegisters');
            $my_file = $this->MessageRegisters->get($id);

            $forward['is_forward'] = 1;
            $file_forward = $this->MessageRegisters->patchEntity($my_file, $forward);
            $this->MessageRegisters->save($file_forward);

            $inputs = $this->request->data;
            $this->loadModel('Users');
            $dept = $this->Users->find()
                ->select(['departments.keyword', 'Users.department_id'])
                ->distinct(['Users.department_id'])
                ->where(['Users.id IN' => $inputs['name']])
                ->leftJoin('departments', 'departments.id=Users.department_id');


            /*Insert Data into Vehicle Hire Letter Register table*/

            foreach ($dept as $value) {

                if ($value['departments']['keyword'] == Configure::read('departments.MECHANICAL') && $my_file['attachment_type'] == Configure::read('attachment_type.4')) {
                    $vehicle['subject'] = $inputs['subject'];
                    $vehicle['receive_office'] = $user['office_id'];
                    $vehicle['resource_id'] = $my_file->resource_id;
                    $vehicle['receive_date'] = time();
                    if (!empty($my_file['scheme_id'])) {
                        $vehicle['scheme_id'] = $my_file['scheme_id'];
                    }
                    $vehicle['receive_from'] = $my_file['sender_name'];


                    if (!empty($my_file['work_description'])) {
                        $vehicle['work_description'] = $my_file['work_description'];
                    }

                    $vehicle['created_by'] = $user['id'];
                    $vehicle['created_date'] = time();
                    $vehicle['status'] = 1;

                    $this->loadModel('VehicleHireLetterRegisters');
                    $vehicle_registers = $this->VehicleHireLetterRegisters->newEntity();

                    $vehicle_registers = $this->VehicleHireLetterRegisters->patchEntity($vehicle_registers, $vehicle);
                    $this->VehicleHireLetterRegisters->save($vehicle_registers);

                }

                /*Insert Data into Lab Letter Register table*/

                if ($value['departments']['keyword'] == Configure::read('departments.LAB') && $my_file['attachment_type'] == Configure::read('attachment_type.4')) {
                    $lab['subject'] = $inputs['subject'];
                    $lab['office_id'] = $user['office_id'];
                    $lab['resource_id'] = $my_file->resource_id;
                    $lab['receive_date'] = time();
                    if (!empty($my_file['scheme_id'])) {
                        $lab['scheme_id'] = $my_file['scheme_id'];
                    }
                    $lab['received_from'] = $my_file['sender_name'];
                    $lab['letter_date'] = $my_file->created_date;

                    if (!empty($my_file['work_description'])) {
                        $lab['work_description'] = $my_file['work_description'];
                    }

                    $lab['created_by'] = $user['id'];
                    $lab['created_date'] = time();
                    $lab['status'] = 1;

                    $this->loadModel('LabLetterRegisters');
                    $lab_registers = $this->LabLetterRegisters->newEntity();

                    $lab_registers = $this->LabLetterRegisters->patchEntity($lab_registers, $lab);
                    $this->LabLetterRegisters->save($lab_registers);

                }
            }

            if (isset($inputs['individual_msg'])) {
                $arr['sender_id'] = $user['id'];
                $arr['subject'] = $inputs['subject'];
                $arr['msg_type'] = "individual";
                $arr['created_by'] = $user['id'];
                $arr['created_date'] = time();
                $arr['status'] = 1;

                foreach ($inputs['individual_msg'] as $key => $value) {
                    $arr['message_text'] = $value;
                    $this->loadModel('MessageRegisters');
                    $messageRegisters = $this->MessageRegisters->newEntity();
                    $messageRegisters = $this->MessageRegisters->patchEntity($messageRegisters, $arr);
                    $msg = $this->MessageRegisters->save($messageRegisters);
                    $rec['message_register_id'] = $msg['id'];
                    $rec['user_id'] = $key;
                    $rec['created_date'] = time();
                    $rec['created_by'] = $user['id'];
                    $rec['status'] = 1;

                    $this->loadModel('Recipients');
                    $recipients = $this->Recipients->newEntity();
                    $recipients = $this->Recipients->patchEntity($recipients, $rec);
                    $this->Recipients->save($recipients);
                }
            }
            /*Insert Data into Message Register table*/

            $data = array();
            $data['sender_id'] = $user['id'];
            if (isset($inputs['subject'])) {
                $data['subject'] = $inputs['subject'];
            } else {
                $data['subject'] = "Re: " . $my_file->subject;
            }
            $data['message_text'] = strip_tags($inputs['message_text'], '<br>,<b>,<i>,<h1>,<h2>,<h3>,<h4>,<h5>,<h6>,<u>');
            $data['reference_msg_id'] = $id;
            if (isset($inputs['read_only'])) {
                $data['msg_flow_control'] = $inputs['read_only'];
            }

            $data['msg_type'] = "forward";

            if (!empty($my_file['project_id'])) {
                $data['description'] = $my_file['project']['name_en'];
            }

            if (!empty($my_file['scheme_id'])) {
                $data['description'] = $my_file['scheme']['name_en'];
            }

            if (!empty($my_file['work_description'])) {
                $data['description'] = $my_file['work_description'];
            }

            $data['is_attached'] = (isset($this->request->data['attachments'][0]) && !empty($this->request->data['attachments'][0])) ? 1 : 0;


            $data['attachment_type'] = Configure::read('attachment_type.4');

            $data['created_date'] = time();
            $data['created_by'] = $user['id'];
            if (isset($inputs['direction'])) {
                $data['msg_direction'] = json_encode($inputs['direction']);
            }

            $data['is_out_side'] = 0;
            if ($my_file['thread_id']) {
                $data['thread_id'] = $my_file['thread_id'];
            } else {
                $data['thread_id'] = $my_file['resource_id'];
            }

            $data['status'] = 1;

            if (isset($inputs['reply_deadline'])) {
                $data['reply_deadline'] = strtotime($inputs['reply_deadline']);
            }

            $this->loadModel('MessageRegisters');
            $messageRegisters = $this->MessageRegisters->newEntity();

            $messageRegisters = $this->MessageRegisters->patchEntity($messageRegisters, $data);

            if ($msg = $this->MessageRegisters->save($messageRegisters)) {
                /*
                 * added by mazba 24-07-16
                 * requirement: omi vai!
                 */
                $files = array();
                $file_upload_complete = true;
                $has_file = false;

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
                /* end the last requiremt */

                if (isset($inputs['reply_deadline'])) {
                    $task_data = array();
                    $task_data['user_id'] = $user['id'];
                    $task_data['type'] = "Other";
                    $task_data['title'] = $inputs['subject'];
                    if (!empty($my_file['project_id'])) {
                        $task_data['description'] = $my_file['project']['name_en'];
                    }

                    if (!empty($my_file['scheme_id'])) {
                        $task_data['description'] = $my_file['scheme']['name_en'];
                    }

                    if (!empty($my_file['work_description'])) {
                        $task_data['description'] = $my_file['work_description'];
                    }

                    $task_data['start_date_time'] = strtotime($inputs['reply_deadline']);
                    $task_data['end_date_time'] = strtotime($inputs['reply_deadline']);

                    $task_data['priority'] = "Normal";

                    if (isset($inputs['direction'])) {
                        foreach ($inputs['direction'] as $direction) {
                            if ($direction == 7) {
                                $task_data['priority'] = "Medium";
                            } elseif ($direction == 8) {
                                $task_data['priority'] = "High";
                            }
                        }
                    }
                    $task_data['status'] = 1;
                    $task_data['created_date'] = time();
                    $task_data['created_by'] = $user['id'];

                    $this->loadModel('TaskManagement');
                    $tasks = $this->TaskManagement->newEntity();
                    $tasks = $this->TaskManagement->patchEntity($tasks, $task_data);
                    $ref = $this->TaskManagement->save($tasks);

                    $task_data['reference_msg_id'] = $ref['id'];

                    foreach ($inputs['name'] as $user_id) {
                        $task_data['user_id'] = $user_id;
                        $tasks = $this->TaskManagement->newEntity();
                        $tasks = $this->TaskManagement->patchEntity($tasks, $task_data);
                        $this->TaskManagement->save($tasks);

                    }
                }

                foreach ($inputs['name'] as $user_id) {
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


                $this->Flash->success(__('Message sent successfully.'));
                return $this->redirect(['action' => 'index']);


            } else {
                $this->Flash->error(__('Message could not sent. Please, try again.'));
            }


        }
    }

    public function reply($id = null)
    {
        if ($this->request->is('post')) {
            $inputs = $this->request->data;
            $user = $this->Auth->user();
            $this->loadModel('MessageRegisters');
            $my_file = $this->MessageRegisters->get($id);

            $files = array();
            $file_upload_complete = true;
            $has_file = false;

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

            /*Insert Data into Message Register table*/

            $data = array();
            $data['sender_id'] = $user['id'];
            if (isset($inputs['subject'])) {
                $data['subject'] = $inputs['subject'];
            } else {
                $data['subject'] = "Re: " . $my_file->subject;
            }
            $data['message_text'] = strip_tags($inputs['message_text'], '<br>,<b>,<i>,<h1>,<h2>,<h3>,<h4>,<h5>,<h6>,<u>');
            $data['reference_msg_id'] = $id;
            $data['msg_type'] = "reply";
            if (!empty($my_file['project_id'])) {
                $data['description'] = $my_file['project']['name_en'];
            }
            if (!empty($my_file['scheme_id'])) {
                $data['description'] = $my_file['scheme']['name_en'];
            }
            if (!empty($my_file['work_description'])) {
                $data['description'] = $my_file['work_description'];
            }
            if ($has_file) {
                $data['is_attached'] = 1;
            }
            $data['attachment_type'] = Configure::read('attachment_type.4');
            $data['created_date'] = time();
            $data['created_by'] = $user['id'];
            $data['is_out_side'] = 0;
            if ($my_file['thread_id']) {
                $data['thread_id'] = $my_file['thread_id'];
            } else {
                $data['thread_id'] = $my_file['id'];
            }
            $data['status'] = 1;
            $this->loadModel('MessageRegisters');
            $messageRegisters = $this->MessageRegisters->newEntity();

            $messageRegisters = $this->MessageRegisters->patchEntity($messageRegisters, $data);

            if ($msg = $this->MessageRegisters->save($messageRegisters)) {

                /*Insert Data into Files table*/

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

                $recipient_data['message_register_id'] = $msg['id'];
                $recipient_data['user_id'] = $inputs['user_id'];
                $recipient_data['created_date'] = time();
                $recipient_data['created_by'] = $user['id'];
                $recipient_data['status'] = 1;

                $this->loadModel('Recipients');
                $recipients = $this->Recipients->newEntity();
                $recipients = $this->Recipients->patchEntity($recipients, $recipient_data);
                $this->Recipients->save($recipients);


                $this->Flash->success(__('Message sent successfully.'));
                return $this->redirect(['action' => 'index']);


            } else {
                $this->Flash->error(__('Message could not sent. Please, try again.'));
            }
        }
    }
//      mazba
//      20-12-15
    public function letters_by_scheme($scheme_id)
    {
        $this->set(compact('scheme_id'));
        if ($this->request->is('ajax')) {
            $user_id = $this->Auth->user('id');
            $this->loadModel('MessageRegisters');
            $querys = $this->MessageRegisters->find()
                ->autoFields(true)
                ->select(['designations.name_en', 'users.name_en'])
                ->where(['MessageRegisters.attachment_type' => Configure::read('attachment_type.4')])
                ->leftJoin('recipients', 'recipients.message_register_id=MessageRegisters.id')
                ->where(['MessageRegisters.scheme_id' => $scheme_id])
                ->leftJoin('users', 'users.id=MessageRegisters.sender_id')
                ->leftJoin('designations', 'designations.id=users.designation_id')
                ->order(['MessageRegisters.created_date' => 'DESC']);


            $my_files = array();
            foreach ($querys as $query) {

                $arr['action'] = '<a class="icon-newspaper" href="' . $this->request->webroot . 'MyFiles/view/' . $query['id'] . '" ><a>';
                if ($query['resource_id']) {
                    $arr['action'] = $arr['action'] . '&nbsp;<a class="icon-pencil3" href="' . $this->request->webroot . 'MyFiles/edit/' . $query['resource_id'] . '" ><a>';

                } else {
                    $arr['action'] = $arr['action'] . '&nbsp;<a class="icon-pencil3" href="' . $this->request->webroot . 'MyFiles/edit/' . $query['thread_id'] . '" ><a>';
                }
                $arr['action'] = $arr['action'] . '&nbsp;<a class="icon-arrow-right12" href="' . $this->request->webroot . 'Tracks/index/' . $query['id'] . '" ><a>';
                if ($query['is_forward'] == 1) {
                    $arr['action'] = $arr['action'] . '&nbsp;<span class="label label-warning">Fw</span>';
                } else if ($query['is_read'] == 1) {
                    $arr['action'] = $arr['action'] . '&nbsp;<span class="label label-success">R</span>';
                } else {
                    $arr['action'] = $arr['action'] . '&nbsp;<span class="label label-danger">N</span>';
                }


                $arr['subject'] = $query['subject'];
                $arr['created_date'] = date('d/m/Y', $query['created_date']);
                $arr['sender_name'] = (($query['is_out_side'] == 1) ? $query['sender_name'] : $query['users']['name_en']);
                $arr['sender_designation'] = (($query['is_out_side'] == 1) ? $query['sender_designation'] : $query['designations']['name_en']);
                $my_files[] = $arr;
            }

            $this->response->body(json_encode($my_files));
            return $this->response;
        }

    }


    public function download_file($path)
    {
        $path = WWW_ROOT . 'files' . DS . 'receive_files' . DS . $path;
        $this->response->file(
            $path,
            ['download' => true]
        );
        return $this->response;
    }

    public function getSubNothi()
    {
        $this->loadModel('NothiRegisters');
        $nothiRegisters = $this->NothiRegisters->find('list', ['conditions' => ['parent_id' => $this->request->data('nothi_id'), 'status !=' => 99]])->toArray();
        $this->set(compact('nothiRegisters'));
        $this->layout = 'ajax';
    }

    public function newLetterAssign()
    {
        $user = $this->Auth->user();
        $today = time();
        $this->loadModel('LetterIssueRegisters');
        $inputs = $this->request->data();
        $id = $inputs['row_id'];
        if($id){
            $letterIssueRegister = $this->LetterIssueRegisters->get($id);
        }
        else{
            $letterIssueRegister = $this->LetterIssueRegisters->newEntity();
        }
        $inputs['created_by'] = $user['id'];
        $inputs['created_date'] = $today;
        $inputs['number_of_pages'] = 1;
        $inputs['letter_nature'] = "SUBLETTER";
        $letterIssueRegister = $this->LetterIssueRegisters->patchEntity($letterIssueRegister, $inputs);
        if($inputs['subject'] != ''){
            if($this->LetterIssueRegisters->save($letterIssueRegister))
            {
                $response_text =  __('সফলভাবে পত্রজারী হয়েছে');
            }
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

    public function approveLetter()
    {
        $user = $this->Auth->user();
        $time = time();
        $this->loadModel('LetterApprovals');
        $letterApproval = $this->LetterApprovals->newEntity();
        $inputs = $this->request->data();
        $inputs['user_id'] = $user['id'];
        $inputs['created_date'] = $time;
        $letterApproval = $this->LetterApprovals->patchEntity($letterApproval, $inputs);
        if($this->LetterApprovals->save($letterApproval)){
            $response_text = __('Success');
        }
        else
        {
            $response_text = __('Fail');
        }
        $response = [
            'success'=>true,
            'msg'=>$response_text
        ];
        $this->response->body(json_encode($response));
        return $this->response;
    }


}