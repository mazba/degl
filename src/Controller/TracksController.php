<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11/9/2015
 * Time: 5:24 PM
 */

namespace App\Controller;


class TracksController extends AppController
{
    public function index($id = null)
    {
        $user_id = $this->Auth->user('id');
        $this->loadModel('MessageRegisters');
        $my_file = $this->MessageRegisters->find()
            ->autoFields(true)
            ->select(['recipient_name' => 'users.name_bn', 'recipient_designation' => 'designations.name_bn', 'recipient_id' => 'recipients.user_id'])
            ->where(['MessageRegisters.id' => $id])
            ->leftJoin('recipients', 'recipients.message_register_id=MessageRegisters.id and recipients.user_id='.$user_id)
            ->leftJoin('users', 'users.id=recipients.user_id')
            ->leftJoin('designations', 'designations.id=users.designation_id')
            ->first()
            ->toArray();



        if ($my_file['sender_id']) {
            $this->loadModel('Users');
            $user = $this->Users->find()
                ->select(['sender_designation' => 'designations.name_bn', 'sender_name' => 'Users.name_bn'])
                ->where(['Users.id' => $my_file['sender_id']])
                ->leftJoin('designations', 'designations.id=Users.designation_id')
                ->first()
                ->toArray();

            $my_file['sender_name'] = $user['sender_name'];
            $my_file['sender_designation'] = $user['sender_designation'];
        }

        $this->set(compact(['my_file']));
    }

    public function getDownMessage()
    {
        $inputs = $this->request->data;
        $history = array();
        $tasks = array();
        $this->loadModel('MessageRegisters');
        $history = $this->MessageRegisters->find()
            ->select(['recipient_name' => 'users.name_bn', 'recipient_designation' => 'designations.name_bn', 'recipients.user_id', 'MessageRegisters.sender_id', 'MessageRegisters.id', 'MessageRegisters.subject', 'MessageRegisters.message_text', 'MessageRegisters.created_date'])
            ->where(['MessageRegisters.reference_msg_id' => $inputs['id'], 'MessageRegisters.created_by' => $inputs['user']])
            ->leftJoin('recipients', 'recipients.message_register_id=MessageRegisters.id')
            ->leftJoin('users', 'users.id=recipients.user_id')
            ->leftJoin('designations', 'designations.id=users.designation_id')
            ->toArray();

        foreach ($history as & $value) {
            $uid = $value['sender_id'];
            $this->loadModel('Users');
            $users = $this->Users->find()
                ->select(['designations.name_bn', 'Users.name_bn'])
                ->where(['Users.id' => $uid])
                ->leftJoin('designations', 'designations.id=Users.designation_id')
                ->first()
                ->toArray();
            $value['sender_name'] = $users['name_bn'] . " (" . $users['designations']['name_bn'] . ")";
            $value['created_date'] = date('d-m-Y', $value['created_date']);

        }


        $this->loadModel('TaskRegisters');
        $tasks = $this->TaskRegisters->find()
            ->autoFields(true)
            ->where(['TaskRegisters.trigger_type' => 'Message', 'TaskRegisters.trigger_id' => $inputs['id'], 'TaskRegisters.created_by' => $inputs['user']])
            ->toArray();

        $data['history'] = $history;
        $data['tasks'] = $tasks;

        $this->response->body(json_encode($data));
        return $this->response;
    }


    // Get Down task

    public function getDownTask()
    {
        $inputs = $this->request->data;

        $this->loadModel('TaskRegisters');
        $tasks = $this->TaskRegisters->find()
            ->autoFields(true)
            ->where(['TaskRegisters.trigger_type' => 'Task', 'TaskRegisters.trigger_id' => $inputs['id']])
            ->toArray();

        $this->response->body(json_encode($tasks));
        return $this->response;
    }


}