<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * EntryDefinitions Controller
 *
 * @property \App\Model\Table\EntryDefinitionsTable $EntryDefinitions
 */
class EntryDefinitionsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $user = $this->Auth->user();
        $entryDefinitions = $this->EntryDefinitions->find('all', [
            'conditions' => ['EntryDefinitions.status !=' => 99],
            'contain' => ['CreatedUser', 'UpdatedUser']
        ]);
        $this->set('entryDefinitions', $entryDefinitions);
        $this->set('_serialize', ['entryDefinitions']);
    }

    /**
     * View method
     *
     * @param string|null $id Entry Definition id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Auth->user();
        $entryDefinition = $this->EntryDefinitions->get($id, [
            'contain' => ['CreatedUser', 'UpdatedUser']
        ]);
        $view_scope = [];
        $this->loadModel('designations');

        if ($entryDefinition['view_scope']) {
            foreach (json_decode($entryDefinition['view_scope']) as $key => $row) {
                $query = $this->designations->get($row);
                $view_scope[] = $query->name_en;
            }
        }
        $attachments = [];
        $this->loadModel('resource_list');
//echo "<pre>";print_r(json_decode($entryDefinition['attachments']));die();
        if ($entryDefinition['attachments']) {
            foreach (json_decode($entryDefinition['attachments']) as $key => $row) {
                $query = $this->resource_list->get($row->attachment_id);
                $attachments[] = $query->name;
            }
        }
        $creation_permission = [];

        if ($entryDefinition['creation_permission']) {
            foreach (json_decode($entryDefinition['creation_permission']) as $row) {
                $query = $this->designations->get($row);
                $creation_permission[] = $query->name_en;
            }
        }
        $approval_sequence = [];

        if ($entryDefinition['approval_sequence']) {
            foreach (json_decode($entryDefinition['approval_sequence']) as $row) {
                $query = $this->designations->get($row);
                $approval_sequence[] = $query->name_en;
            }
        }
        $preconditions = [];
        if ($entryDefinition['preconditions']) {
            foreach (json_decode($entryDefinition['preconditions']) as $row) {
                $query = $this->EntryDefinitions->get($row);
                $preconditions[] = $query->name;
            }
        }


        //   echo "<pre>";print_r(json_decode($entryDefinition['view_scope']));die();
        $this->set(compact('view_scope','attachments','creation_permission','approval_sequence','preconditions'));

        $this->set('entryDefinition', $entryDefinition);
        $this->set('_serialize', ['entryDefinition']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Auth->user();
        $entryDefinition = $this->EntryDefinitions->newEntity();
        if ($this->request->is('post')) {

            $data = $this->request->data;
         //   echo "<pre>";print_r($data);die();
            $approval_sequence=[];
            foreach($data['approval_sequence'] as $row){

                $approval_sequence[]=$row['approval_id'];

            }
            $data['view_scope'] = json_encode($data['view_scope']);
            $data['attachments'] = json_encode($data['attachments']);
            $data['creation_permission'] = json_encode($data['creation_permission']);
            $data['approval_sequence'] = json_encode($approval_sequence);


            if(isset($data['preconditions'])){
                $data['preconditions'] = json_encode($data['preconditions']);

            }
            $data['created_by'] = $user['id'];
            $data['created_date'] = time();
            $data['status'] = 1;
            $entryDefinition = $this->EntryDefinitions->patchEntity($entryDefinition, $data);
            // echo "<pre>";print_r($entryDefinition);die();
            if ($this->EntryDefinitions->save($entryDefinition)) {
                $this->Flash->success('The entry definition has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The entry definition could not be saved. Please, try again.');
            }
        }

//        $this->loadModel('Departments');
//        $departments = $this->Departments->find('all', ['contain' => ['Users', 'Users.Designations'], 'conditions' => ['Departments.office_id' => $user['office_id']]]);
        $this->loadModel('designations');
        $departments = $this->designations->find('all', ['conditions' => ['office_id' => $user['office_id']]]);
        // echo "<pre>";print_r($departments->toArray());die();
        $this->loadModel('ResourceList');

        $resourceList = $this->ResourceList->find('all')->toArray();
        $preconditions = $this->EntryDefinitions->find('all')->toArray();

        //   echo "<pre>";print_r($preconditions);die();
        $this->set(compact('entryDefinition', 'departments', 'resourceList', 'preconditions'));
        $this->set('_serialize', ['entryDefinition']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Entry Definition id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Auth->user();
        $entryDefinition = $this->EntryDefinitions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->data;
            $data['updated_by'] = $user['id'];
            $data['updated_date'] = time();
            $entryDefinition = $this->EntryDefinitions->patchEntity($entryDefinition, $data);
            if ($this->EntryDefinitions->save($entryDefinition)) {
                $this->Flash->success('The entry definition has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The entry definition could not be saved. Please, try again.');
            }
        }
        $createdUser = $this->EntryDefinitions->CreatedUser->find('list', ['limit' => 200]);
        $updatedUser = $this->EntryDefinitions->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('entryDefinition', 'createdUser', 'updatedUser'));
        $this->set('_serialize', ['entryDefinition']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Entry Definition id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $entryDefinition = $this->EntryDefinitions->get($id);

        $user = $this->Auth->user();
        $data = $this->request->data;
        $data['updated_by'] = $user['id'];
        $data['updated_date'] = time();
        $data['status'] = 99;
        $entryDefinition = $this->EntryDefinitions->patchEntity($entryDefinition, $data);
        if ($this->EntryDefinitions->save($entryDefinition)) {
            $this->Flash->success('The entry definition has been deleted.');
        } else {
            $this->Flash->error('The entry definition could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
