<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * NoteSheetEntries Controller
 *
 * @property \App\Model\Table\NoteSheetEntriesTable $NoteSheetEntries
 */
class NoteSheetEntriesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $user = $this->Auth->user();
        $noteSheetEntries = $this->NoteSheetEntries->find('all', [
            'conditions' => ['NoteSheetEntries.status !=' => 99],
            'contain' => ['Schemes']
        ]);
        $this->set('noteSheetEntries', $noteSheetEntries);
        $this->set('_serialize', ['noteSheetEntries']);
    }

    /**
     * View method
     *
     * @param string|null $id Note Sheet Entry id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Auth->user();
        $noteSheetEntry = $this->NoteSheetEntries->get($id, [
            'contain' => ['Schemes']
        ]);
//        echo "<pre>";
//        print_r(json_decode($noteSheetEntry['approval_sequence']));
//        die();
        $this->set('noteSheetEntry', $noteSheetEntry);
        $this->set('_serialize', ['noteSheetEntry']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Auth->user();
      //  echo "<pre>";print_r($user);die();
        $noteSheetEntry = $this->NoteSheetEntries->newEntity();
        if ($this->request->is('post')) {
            $this->loadModel('entry_definitions');
            $this->loadModel('note_sheet_events');


            $data = $this->request->data;
             //echo "<pre>";print_r($data);die();
            if(isset($data['attachments'])){
                $data['attachments'] = json_encode($data['attachments']);

            }
           // $data['approval_sequence'] = json_encode($data['approval_sequence']);
            // echo "<pre>";print_r($data);die();
            $data['approval_status'] = 0;
            $data['created_by'] = $user['id'];
            $data['created_date'] = time();
            $entry_definition = $this->entry_definitions->get($data['entry_definition_id']);
            $approval_sequence=[];
            foreach(json_decode($entry_definition['approval_sequence']) as $key=>$row){
                if($key==0 && $row==$user['designation_id']){

                        $approval_sequence[$key]['id']=$row;
                        $approval_sequence[$key]['status']='true';
                        $approval_sequence[$key]['date']=time();
                }
                else{
                    $approval_sequence[$key]['id']=$row;
                    $approval_sequence[$key]['status']='false';
                    $approval_sequence[$key]['date']=time();
                }
            }

            $data['approval_sequence']=json_encode($approval_sequence);
            $data['view_scope']=$entry_definition['view_scope'];

          //  echo "<pre>";print_r( $data);die();
            $send_to = null;
            foreach (json_decode($entry_definition['approval_sequence']) as $row) {
                if ($row != $user['designation_id']) {
                    $send_to = $row;
                }
                if (!empty($send_to))
                    break;
            }

            $noteSheetEntry = $this->NoteSheetEntries->patchEntity($noteSheetEntry, $data);
           // echo "<pre>";print_r($noteSheetEntry);die();
            $noteSheetEntry_id = $this->NoteSheetEntries->save($noteSheetEntry);
            if ($noteSheetEntry_id) {
                $note_sheet_events = $this->note_sheet_events->newEntity();
                $event_data = [];
                $event_data['scheme_id'] = $data['scheme_id'];
                $event_data['note_sheet_entry_id'] = $noteSheetEntry_id['id'];
                $event_data['office_id'] = $user['office_id'];
                $event_data['is_read'] = 0;
                $event_data['recipient_designation_id'] = $send_to;

                $note_sheet_events = $this->note_sheet_events->patchEntity($note_sheet_events, $event_data);
//echo "<pre>";print_r($note_sheet_events);die();
                if ($this->note_sheet_events->save($note_sheet_events)) {
                    $this->Flash->success('The note sheet entry has been saved.');
                    return $this->redirect(['controller' => ' NoteSheetEntries', 'action' => 'index']);
                } else {
                    $this->Flash->error('The note sheet entry could not be saved. Please, try again.');

                }

            } else {
                $this->Flash->error('The note sheet entry could not be saved. Please, try again.');
            }
        }
        $schemes = $this->NoteSheetEntries->Schemes->find('list');
        $this->loadModel('entry_definitions');
        $entry_definitions = $this->entry_definitions->find('list', ['conditions' => ['status ='=>1]]);

//echo "<pre>";print_r($entry_definitions->toArray());die();
        $this->set(compact('noteSheetEntry', 'schemes', 'entry_definitions'));
        $this->set('_serialize', ['noteSheetEntry']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Note Sheet Entry id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Auth->user();
        $noteSheetEntry = $this->NoteSheetEntries->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->data;
            $data['updated_by'] = $user['id'];
            $data['updated_date'] = time();
            $noteSheetEntry = $this->NoteSheetEntries->patchEntity($noteSheetEntry, $data);
            if ($this->NoteSheetEntries->save($noteSheetEntry)) {
                $this->Flash->success('The note sheet entry has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The note sheet entry could not be saved. Please, try again.');
            }
        }
        $schemes = $this->NoteSheetEntries->Schemes->find('list', ['limit' => 200]);
        $this->set(compact('noteSheetEntry', 'schemes'));
        $this->set('_serialize', ['noteSheetEntry']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Note Sheet Entry id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $noteSheetEntry = $this->NoteSheetEntries->get($id);

        $user = $this->Auth->user();
        $data = $this->request->data;
        $data['updated_by'] = $user['id'];
        $data['updated_date'] = time();
        $data['status'] = 99;
        $noteSheetEntry = $this->NoteSheetEntries->patchEntity($noteSheetEntry, $data);
        if ($this->NoteSheetEntries->save($noteSheetEntry)) {
            $this->Flash->success('The note sheet entry has been deleted.');
        } else {
            $this->Flash->error('The note sheet entry could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }

    public function get_note_sheets(){
        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->layout = 'ajax';
            $data = $this->request->data;
            $user = $this->Auth->user();

            $result = $this->NoteSheetEntries->find('all', ['conditions' => ['scheme_id' => $data['scheme_id']]]);
            $val=[];
            foreach($result as $key=>$row){
                if(in_array($user['designation_id'],json_decode($row['view_scope'])) ){
                    $val[$key]['text'] = $row['text'];
                    $val[$key]['id'] = $row['id'];
                    $val[$key]['scheme_id'] = $row['scheme_id'];

                    $val[$key]['access']=json_decode($row['approval_sequence'],true);
                    $val[$key]['attachments'] = json_decode($row['attachments'],true);
                }
            }
            $this->loadModel('users');

            foreach($val as &$rows){
                foreach($rows['access'] as &$row){
                    if($row['status']=='true'){
                        //get user picture url by this id


                        $img=$this->users->find("all", [
                            'conditions' => ['designation_id'=> $row['id'],'office_id'=>$user['office_id'],'status'=> 1],
                            'select'=>['signature']

                        ])->first();
                        $row['picture']=$img['signature'];
                    }
//                    if($row['id']== $user['designation_id'] && $row['status']=='false'){
//                        $row['picture']='not set';
//                    }
                    //  echo "<pre>";print_r($row);die();
                }
            }

           // echo "<pre>";print_r($val);die();
            $this->set(compact('result','val'));

        }
    }


    public function get_note_sheet_entry_form()
    {
        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->loadModel('entry_definitions');
            $this->loadModel('hire_charges');
            $this->loadModel('lab_bills');
            $this->loadModel('vehicle_hire_letter_registers');
            $this->loadModel('lab_letter_registers');
            $this->loadModel('MessageRegisters');


            $this->layout = 'ajax';
            $data = $this->request->data;
            $user = $this->Auth->user();

            $entry_definition = $this->entry_definitions->get($data['entry_definition_id']);
            $creation_permission = json_decode($entry_definition['creation_permission']);
            if (!in_array($user['designation_id'], $creation_permission)) {
                $error = "You don't have permission for create this";
            } else {
                $attachments = json_decode($entry_definition['attachments'], true);
            }

            $preconditions =true;
            $count=[];
            if ($entry_definition['preconditions']) {
                foreach (json_decode($entry_definition['preconditions']) as $key=>$row) {
                    // $preconditions[]=$row;
                    $result = $this->NoteSheetEntries->find('all', ['conditions' => ['scheme_id' => $data['scheme_id'], 'entry_definition_id' => $row]])->first();
                        if($result){
                            $count[]=$key;
                        }

                }
            }
            if(count(json_decode($entry_definition['preconditions']))!= count($count)){
                $preconditions=false;
            }


            $entry_serial_no = $this->NoteSheetEntries->find('all', ['conditions' => ['scheme_id' => $data['scheme_id']]])
                ->order(['id' => 'desc']);
            $entry_serial_no = $entry_serial_no->first();

            $hire_charges = $this->hire_charges->find('all', ['conditions' => ['scheme_id' => $data['scheme_id']]]);
            $hire_charge_letters = $this->vehicle_hire_letter_registers->find('all', ['conditions' => ['scheme_id' => $data['scheme_id']]]);
            $lab_letters = $this->lab_letter_registers->find('all', ['conditions' => ['scheme_id' => $data['scheme_id']]]);
            $lab_bills = $this->lab_bills->find('all', ['conditions' => ['reference_id' => $data['scheme_id']]]);

            $messages = $this->MessageRegisters->find()
                ->autoFields(true)
                ->where(['MessageRegisters.msg_type' => 'RaBillApplication'])
                ->leftJoin('recipients', 'recipients.message_register_id=MessageRegisters.id')
                ->where(['recipients.user_id' => $user['id']])
                ->order(['MessageRegisters.created_date' => "DESC"])
                ->toArray();
           // echo "<pre>";print_r($messages);die();

            $this->set(compact('error','preconditions','messages', 'attachments', 'hire_charges', 'hire_charge_letters', 'lab_letters', 'lab_bills', 'entry_serial_no'));

        }
    }
}
