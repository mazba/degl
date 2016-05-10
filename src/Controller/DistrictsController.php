<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Districts Controller
 *
 * @property \App\Model\Table\DistrictsTable $Districts
 */
class DistrictsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $districts = $this->Districts->find('all', [
            'conditions' =>['Districts.status !=' => 99],
            'contain' => ['Divisions', 'Zones', 'CreatedUser', 'UpdatedUser']
        ]);
        $this->set('districts', $districts);
        $this->set('_serialize', ['districts']);
    }

    /**
     * View method
     *
     * @param string|null $id District id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $district = $this->Districts->get($id, [
            'contain' => ['Divisions', 'Zones', 'CreatedUser', 'UpdatedUser', 'Municipality', 'Offices', 'Upazila']
        ]);
        $this->set('district', $district);
        $this->set('_serialize', ['district']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $district = $this->Districts->newEntity();
        if ($this->request->is('post'))
        {
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            $district = $this->Districts->patchEntity($district, $data);
            if ($this->Districts->save($district))
            {
                $this->Flash->success(__('The district has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The district could not be saved. Please, try again.'));
            }
        }
        $divisions = $this->Districts->Divisions->find('list', ['limit' => 200]);
        $zones = $this->Districts->Zones->find('list', ['limit' => 200]);
        $createdUser = $this->Districts->CreatedUser->find('list', ['limit' => 200]);
        $updatedUser = $this->Districts->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('district', 'divisions', 'zones', 'createdUser', 'updatedUser'));
        $this->set('_serialize', ['district']);
    }

    /**
     * Edit method
     *
     * @param string|null $id District id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $district = $this->Districts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $data=$this->request->data;
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['updated_by']=$user['id'];
            $data['updated_date']=time();
            $district = $this->Districts->patchEntity($district, $data);
            if ($this->Districts->save($district))
            {
                $this->Flash->success(__('The district has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The district could not be saved. Please, try again.'));
            }
        }
        $divisions = $this->Districts->Divisions->find('list', ['limit' => 200]);
        $zones = $this->Districts->Zones->find('list', ['limit' => 200]);
        $createdUser = $this->Districts->CreatedUser->find('list', ['limit' => 200]);
        $updatedUser = $this->Districts->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('district', 'divisions', 'zones', 'createdUser', 'updatedUser'));
        $this->set('_serialize', ['district']);
    }

    /**
     * Delete method
     *
     * @param string|null $id District id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $district = $this->Districts->get($id);

        $user=$this->Auth->user();
        $data=$this->request->data;
        $data['updated_by']=$user['id'];
        $data['updated_date']=time();
        $data['status']=99;
        $district = $this->Districts->patchEntity($district, $data);
        if ($this->Districts->save($district))
        {
            $this->Flash->success(__('The district has been deleted.'));
        }
        else
        {
            $this->Flash->error(__('The district could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
