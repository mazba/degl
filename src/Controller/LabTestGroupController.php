<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * LabTestGroup Controller
 *
 * @property \App\Model\Table\LabTestGroupTable $LabTestGroup
 */
class LabTestGroupController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $user=$this->Auth->user();
        $labTestGroup = $this->LabTestGroup->find('all', [
            'conditions' =>['LabTestGroup.status !=' => 99],
            'contain' => ['CreatedUser', 'UpdatedUser']
        ]);
        $this->set('labTestGroup', $labTestGroup);
        $this->set('_serialize', ['labTestGroup']);
    }

    /**
     * View method
     *
     * @param string|null $id Lab Test Group id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user=$this->Auth->user();
        $labTestGroup = $this->LabTestGroup->get($id, [
            'contain' => ['CreatedUser', 'UpdatedUser']
        ]);
        $this->set('labTestGroup', $labTestGroup);
        $this->set('_serialize', ['labTestGroup']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user=$this->Auth->user();
        $labTestGroup = $this->LabTestGroup->newEntity();
        if ($this->request->is('post'))
        {

            $data=$this->request->data;
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            $labTestGroup = $this->LabTestGroup->patchEntity($labTestGroup, $data);
            if ($this->LabTestGroup->save($labTestGroup))
            {
                $this->Flash->success('The lab test group has been saved.');
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error('The lab test group could not be saved. Please, try again.');
            }
        }
        $createdUser = $this->LabTestGroup->CreatedUser->find('list', ['limit' => 200]);
        $updatedUser = $this->LabTestGroup->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('labTestGroup', 'createdUser', 'updatedUser'));
        $this->set('_serialize', ['labTestGroup']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Lab Test Group id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user=$this->Auth->user();
        $labTestGroup = $this->LabTestGroup->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $data=$this->request->data;
            $data['updated_by']=$user['id'];
            $data['updated_date']=time();
            $labTestGroup = $this->LabTestGroup->patchEntity($labTestGroup, $data);
            if ($this->LabTestGroup->save($labTestGroup))
            {
                $this->Flash->success('The lab test group has been saved.');
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error('The lab test group could not be saved. Please, try again.');
            }
        }
        $createdUser = $this->LabTestGroup->CreatedUser->find('list', ['limit' => 200]);
        $updatedUser = $this->LabTestGroup->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('labTestGroup', 'createdUser', 'updatedUser'));
        $this->set('_serialize', ['labTestGroup']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Lab Test Group id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $labTestGroup = $this->LabTestGroup->get($id);

        $user=$this->Auth->user();
        $data=$this->request->data;
        $data['updated_by']=$user['id'];
        $data['updated_date']=time();
        $data['status']=99;
        $labTestGroup = $this->LabTestGroup->patchEntity($labTestGroup, $data);
        if ($this->LabTestGroup->save($labTestGroup))
        {
            $this->Flash->success('The lab test group has been deleted.');
        }
        else
        {
            $this->Flash->error('The lab test group could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
