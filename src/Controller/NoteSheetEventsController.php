<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * NoteSheetEvents Controller
 *
 * @property \App\Model\Table\NoteSheetEventsTable $NoteSheetEvents
 */
class NoteSheetEventsController extends AppController {

  /**
   * Index method
   *
   * @return void
   */
  public function index() {
    $user = $this->Auth->user();

    //  echo "<pre>";print_r($user);die();
    $noteSheetEvents = $this->NoteSheetEvents->find('all', ['conditions' => ['NoteSheetEvents.recipient_designation_id' => $user['designation_id'], 'NoteSheetEvents.office_id' => $user['office_id']], 'contain' => ['Schemes', 'NoteSheetEntries', 'Offices']]);
    $this->set('noteSheetEvents', $noteSheetEvents);
    $this->set('_serialize', ['noteSheetEvents']);
  }

  /**
   * View method
   *
   * @param string|null $id Note Sheet Event id.
   * @return void
   * @throws \Cake\Network\Exception\NotFoundException When record not found.
   */
  public function view($id = NULL) {
    $this->loadModel('note_sheet_entries');
    $this->loadModel('users');
    $this->loadModel('Schemes');

    $user = $this->Auth->user();
    // echo "<pre>";print_r($user);die();
    $note_sheet_entries = $this->note_sheet_entries->find("all", ['conditions' => ['scheme_id' => $id]]);
    $scheme_data = $this->Schemes->get($id);

    //  echo "<pre>";print_r($scheme_data->toArray());die();

    $val = [];
    foreach ($note_sheet_entries as $key => $row) {
      if (in_array($user['designation_id'], json_decode($row['view_scope']))) {
        $val[$key]['text'] = $row['text'];
        $val[$key]['id'] = $row['id'];
        $val[$key]['scheme_id'] = $row['scheme_id'];
        $val[$key]['attachments'] = json_decode($row['attachments'], TRUE);
        $val[$key]['access'] = json_decode($row['approval_sequence'], TRUE);

      }
    }

    foreach ($val as &$rows) {
      foreach ($rows['access'] as &$row) {
        if ($row['status'] == 'true') {
          //get user picture url by this id
          $img = $this->users->find("all", ['conditions' => ['users.designation_id' => $row['id'], 'users.office_id' => $user['office_id'], 'users.status' => 1], 'select' => ['signature'],'contain' => ['Designations']])
                             ->first();
         // pr($img);
          $row['picture'] = $img['signature'];
          $row['designation']=$img->designation->name_bn;
          //pr($row);
        }
        if ($row['id'] == $user['designation_id'] && $row['status'] == 'false') {
          $row['picture'] = 'not set';
        }
        //  echo "<pre>";print_r($row);die();
      }
    }

     //echo "<pre>";print_r($val);die();
    $this->set('val', $val);
    $this->set('user', $user);
    $this->set('scheme_data', $scheme_data);
    //  $this->set('noteSheetEvent', $noteSheetEvent);
    $this->set('_serialize', ['noteSheetEvent']);
  }

  public function approve_and_forward($id) {

    $user = $this->Auth->user();

    $this->loadModel('note_sheet_entries');
    $data = $this->note_sheet_entries->get($id);

    $approval_sequence = json_decode($data['approval_sequence'], TRUE);
    // echo "<pre>";print_r($approval_sequence);die();
    foreach ($approval_sequence as &$row) {
      if ($row['id'] == $user['designation_id']) {
        $row['status'] = 'true';
        $row['date'] = time();
        //   echo "<pre>";print_r($row);die();
      }
    }
    $final_approval_sequence = json_encode($approval_sequence);

    $counts = "true";
    foreach ($approval_sequence as &$row) {
      if ($row['status'] == 'false') {
        $counts = 'false';
      }
    }
    $recipient_designation_id = 0;
    if ($counts == "false") {

      foreach ($approval_sequence as &$row) {
        if ($row['id'] != $user['designation_id'] && $row['status'] == 'false') {
          $recipient_designation_id = $row['id'];
        }
        if ($recipient_designation_id) {
          break;
        }
      }
      $this->loadModel('note_sheet_events');

      $note_sheet_events = $this->note_sheet_events->newEntity();
      $event_data = [];
      $event_data['scheme_id'] = $data['scheme_id'];
      $event_data['note_sheet_entry_id'] = $data['id'];
      $event_data['office_id'] = $user['office_id'];
      $event_data['is_read'] = 0;
      $event_data['recipient_designation_id'] = $recipient_designation_id;

      $note_sheet_events = $this->note_sheet_events->patchEntity($note_sheet_events, $event_data);
//echo "<pre>";print_r($note_sheet_events);die();
      $this->note_sheet_events->save($note_sheet_events);

    }
    // echo "<pre>";print_r($send_user_designation_id);die();

    $note_sheet_entrie = TableRegistry::get('note_sheet_entries');

    if ($counts == "true") {
      $query = $note_sheet_entrie->query();
      $query->update()
            ->set(['approval_status' => 1])
            ->where(['id' => $id])
            ->execute();
    }
    $note_sheet_entries = TableRegistry::get('note_sheet_entries');

    $query = $note_sheet_entries->query();
    $result = $query->update()
                    ->set(['approval_sequence' => $final_approval_sequence])
                    ->where(['id' => $id])
                    ->execute();
    //  echo "<pre>";print_r(json_encode($approval_sequence));die();
    if ($result) {
      $this->Flash->success('The note sheet event has been approved.');
    } else {
      $this->Flash->error('The note sheet event could not be approved. Please, try again.');
    }
    return $this->redirect(['action' => 'index']);
  }

  /**
   * Add method
   *
   * @return void Redirects on successful add, renders view otherwise.
   */
  public function add() {
    $user = $this->Auth->user();
    $noteSheetEvent = $this->NoteSheetEvents->newEntity();
    if ($this->request->is('post')) {

      $data = $this->request->data;
      $data['created_by'] = $user['id'];
      $data['created_date'] = time();
      $noteSheetEvent = $this->NoteSheetEvents->patchEntity($noteSheetEvent, $data);
      if ($this->NoteSheetEvents->save($noteSheetEvent)) {
        $this->Flash->success('The note sheet event has been saved.');
        return $this->redirect(['action' => 'index']);
      } else {
        $this->Flash->error('The note sheet event could not be saved. Please, try again.');
      }
    }
    $schemes = $this->NoteSheetEvents->Schemes->find('list', ['limit' => 200]);
    $noteSheetEntries = $this->NoteSheetEvents->NoteSheetEntries->find('list', ['limit' => 200]);
    $offices = $this->NoteSheetEvents->Offices->find('list', ['limit' => 200]);
    $this->set(compact('noteSheetEvent', 'schemes', 'noteSheetEntries', 'offices'));
    $this->set('_serialize', ['noteSheetEvent']);
  }

  /**
   * Edit method
   *
   * @param string|null $id Note Sheet Event id.
   * @return void Redirects on successful edit, renders view otherwise.
   * @throws \Cake\Network\Exception\NotFoundException When record not found.
   */
  public function edit($id = NULL) {
    $user = $this->Auth->user();
    $noteSheetEvent = $this->NoteSheetEvents->get($id, ['contain' => []]);
    if ($this->request->is(['patch', 'post', 'put'])) {
      $data = $this->request->data;
      $data['updated_by'] = $user['id'];
      $data['updated_date'] = time();
      $noteSheetEvent = $this->NoteSheetEvents->patchEntity($noteSheetEvent, $data);
      if ($this->NoteSheetEvents->save($noteSheetEvent)) {
        $this->Flash->success('The note sheet event has been saved.');
        return $this->redirect(['action' => 'index']);
      } else {
        $this->Flash->error('The note sheet event could not be saved. Please, try again.');
      }
    }
    $schemes = $this->NoteSheetEvents->Schemes->find('list', ['limit' => 200]);
    $noteSheetEntries = $this->NoteSheetEvents->NoteSheetEntries->find('list', ['limit' => 200]);
    $offices = $this->NoteSheetEvents->Offices->find('list', ['limit' => 200]);
    $this->set(compact('noteSheetEvent', 'schemes', 'noteSheetEntries', 'offices'));
    $this->set('_serialize', ['noteSheetEvent']);
  }

  /**
   * Delete method
   *
   * @param string|null $id Note Sheet Event id.
   * @return void Redirects to index.
   * @throws \Cake\Network\Exception\NotFoundException When record not found.
   */
  public function delete($id = NULL) {

    $noteSheetEvent = $this->NoteSheetEvents->get($id);

    $user = $this->Auth->user();
    $data = $this->request->data;
    $data['updated_by'] = $user['id'];
    $data['updated_date'] = time();
    $data['status'] = 99;
    $noteSheetEvent = $this->NoteSheetEvents->patchEntity($noteSheetEvent, $data);
    if ($this->NoteSheetEvents->save($noteSheetEvent)) {
      $this->Flash->success('The note sheet event has been deleted.');
    } else {
      $this->Flash->error('The note sheet event could not be deleted. Please, try again.');
    }
    return $this->redirect(['action' => 'index']);
  }
}
