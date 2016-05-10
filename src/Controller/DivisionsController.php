<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Divisions Controller
 *
 * @property \App\Model\Table\DivisionsTable $Divisions
 */
class DivisionsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $divisions = $this->Divisions->find('all', [
            'conditions' =>['Divisions.status !=' => 99],
            'contain' => ['CreatedUser', 'UpdatedUser']
        ]);
        $this->set('divisions', $divisions);
        $this->set('_serialize', ['divisions']);
    }

    /**
     * View method
     *
     * @param string|null $id Division id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $division = $this->Divisions->get($id, [
            'contain' => ['CreatedUser', 'UpdatedUser', 'Districts', 'Offices', 'Upazila', 'Zones']
        ]);
        $this->set('division', $division);
        $this->set('_serialize', ['division']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $division = $this->Divisions->newEntity();
        if ($this->request->is('post'))
        {
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            $division = $this->Divisions->patchEntity($division, $data);
            if ($this->Divisions->save($division))
            {
                $this->Flash->success(__('The division has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The division could not be saved. Please, try again.'));
            }
        }
        $createdUser = $this->Divisions->CreatedUser->find('list', ['limit' => 200]);
        $updatedUser = $this->Divisions->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('division', 'createdUser', 'updatedUser'));
        $this->set('_serialize', ['division']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Division id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $division = $this->Divisions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $data=$this->request->data;
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['updated_by']=$user['id'];
            $data['updated_date']=time();
            $division = $this->Divisions->patchEntity($division, $data);
            if ($this->Divisions->save($division))
            {
                $this->Flash->success(__('The division has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The division could not be saved. Please, try again.'));
            }
        }
        $createdUser = $this->Divisions->CreatedUser->find('list', ['limit' => 200]);
        $updatedUser = $this->Divisions->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('division', 'createdUser', 'updatedUser'));
        $this->set('_serialize', ['division']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Division id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $division = $this->Divisions->get($id);

        $user=$this->Auth->user();
        $data=$this->request->data;
        $data['updated_by']=$user['id'];
        $data['updated_date']=time();
        $data['status']=99;
        $division = $this->Divisions->patchEntity($division, $data);
        if ($this->Divisions->save($division))
        {
            $this->Flash->success(__('The division has been deleted.'));
        }
        else
        {
            $this->Flash->error(__('The division could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
