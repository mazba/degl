<?php
namespace App\Controller;

use App\Controller\AppController;


/**
 * Offices Controller
 *
 * @property \App\Model\Table\OfficesTable $Offices
 */
class OfficesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $offices = $this->Offices->find('all', [
            'conditions' =>['Offices.status !=' => 99],
            'contain' => ['Divisions', 'Zones', 'Districts', 'Upazilas', 'CreatedUser', 'UpdatedUser']
        ]);
        $this->set('offices', $offices);
        $this->set('_serialize', ['offices']);
    }

    /**
     * View method
     *
     * @param string|null $id Office id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $office = $this->Offices->get($id, [
            'contain' => ['Divisions', 'Zones', 'Districts', 'Upazilas', 'CreatedUser', 'UpdatedUser']
        ]);
        $this->set('office', $office);
        $this->set('_serialize', ['office']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $office = $this->Offices->newEntity();
        if ($this->request->is('post'))
        {
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            $office = $this->Offices->patchEntity($office, $data);
            if ($this->Offices->save($office))
            {
                $this->Flash->success(__('The office has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The office could not be saved. Please, try again.'));
            }
        }
        $divisions = $this->Offices->Divisions->find('list');
        //$zones = $this->Offices->Zones->find('list', ['limit' => 200]);
        //$districts = $this->Offices->Districts->find('list', ['limit' => 200]);
        //$upazilas = $this->Offices->Upazilas->find('list', ['limit' => 200]);
        //$createdUser = $this->Offices->CreatedUser->find('list', ['limit' => 200]);
        //$updatedUser = $this->Offices->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('office', 'divisions', 'zones', 'districts', 'upazilas', 'createdUser', 'updatedUser'));
        $this->set('_serialize', ['office']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Office id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $office = $this->Offices->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $data=$this->request->data;
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['updated_by']=$user['id'];
            $data['updated_date']=time();
            $office = $this->Offices->patchEntity($office, $data);
            if ($this->Offices->save($office))
            {
                $this->Flash->success(__('The office has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The office could not be saved. Please, try again.'));
            }
        }
        $divisions = $this->Offices->Divisions->find('list');
        $zones=[];
        $districts=[];
        $upazilas=[];
        if($office->division_id)
        {
            $zones = $this->Offices->Zones->find('list', ['conditions' =>['status !=' => 99,'division_id' => $office->division_id]]);
            if($office->zone_id)
            {
                $districts = $this->Offices->Districts->find('list', ['conditions' =>['status !=' => 99,'division_id' => $office->division_id,'zone_id' => $office->zone_id]]);
                if($office->district_id)
                {
                    $upazilas = $this->Offices->Upazilas->find('list', ['conditions' =>['status !=' => 99,'division_id' => $office->division_id,'district_id' => $office->district_id]]);

                }
            }
        }

        //$zones = $this->Offices->Zones->find('list', ['limit' => 200]);
        //$districts = $this->Offices->Districts->find('list', ['limit' => 200]);
        //$upazilas = $this->Offices->Upazilas->find('list', ['limit' => 200]);
        $createdUser = $this->Offices->CreatedUser->find('list', ['limit' => 200]);
        $updatedUser = $this->Offices->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('office', 'divisions', 'zones', 'districts', 'upazilas', 'createdUser', 'updatedUser'));
        $this->set('_serialize', ['office']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Office id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $office = $this->Offices->get($id);

        $user=$this->Auth->user();
        $data=$this->request->data;
        $data['updated_by']=$user['id'];
        $data['updated_date']=time();
        $data['status']=99;
        $office = $this->Offices->patchEntity($office, $data);
        if ($this->Offices->save($office))
        {
            $this->Flash->success(__('The office has been deleted.'));
        }
        else
        {
            $this->Flash->error(__('The office could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

}
