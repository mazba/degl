<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Upazilas Controller
 *
 * @property \App\Model\Table\UpazilasTable $Upazilas
 */
class UpazilasController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $upazilas = $this->Upazilas->find('all', [
            'conditions' =>['Upazilas.status !=' => 99],
            'contain' => ['Divisions', 'Districts', 'CreatedUser', 'UpdatedUser']
        ]);
        $this->set('upazilas', $upazilas);
        $this->set('_serialize', ['upazilas']);
    }

    /**
     * View method
     *
     * @param string|null $id Upazila id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $upazila = $this->Upazilas->get($id, [
            'contain' => ['Divisions', 'Districts', 'CreatedUser', 'UpdatedUser']
        ]);
        $this->set('upazila', $upazila);
        $this->set('_serialize', ['upazila']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $upazila = $this->Upazilas->newEntity();
        if ($this->request->is('post'))
        {
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            $upazila = $this->Upazilas->patchEntity($upazila, $data);
            if ($this->Upazilas->save($upazila))
            {
                $this->Flash->success(__('The upazila has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The upazila could not be saved. Please, try again.'));
            }
        }
        $divisions = $this->Upazilas->Divisions->find('list', ['limit' => 200]);
        $districts = $this->Upazilas->Districts->find('list', ['limit' => 200]);
        $createdUser = $this->Upazilas->CreatedUser->find('list', ['limit' => 200]);
        $updatedUser = $this->Upazilas->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('upazila', 'divisions', 'districts', 'createdUser', 'updatedUser'));
        $this->set('_serialize', ['upazila']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Upazila id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $upazila = $this->Upazilas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $data=$this->request->data;
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['updated_by']=$user['id'];
            $data['updated_date']=time();
            $upazila = $this->Upazilas->patchEntity($upazila, $data);
            if ($this->Upazilas->save($upazila))
            {
                $this->Flash->success(__('The upazila has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The upazila could not be saved. Please, try again.'));
            }
        }
        $divisions = $this->Upazilas->Divisions->find('list', ['limit' => 200]);
        $districts = $this->Upazilas->Districts->find('list', ['limit' => 200]);
        $createdUser = $this->Upazilas->CreatedUser->find('list', ['limit' => 200]);
        $updatedUser = $this->Upazilas->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('upazila', 'divisions', 'districts', 'createdUser', 'updatedUser'));
        $this->set('_serialize', ['upazila']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Upazila id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $upazila = $this->Upazilas->get($id);

        $user=$this->Auth->user();
        $data=$this->request->data;
        $data['updated_by']=$user['id'];
        $data['updated_date']=time();
        $data['status']=99;
        $upazila = $this->Upazilas->patchEntity($upazila, $data);
        if ($this->Upazilas->save($upazila))
        {
            $this->Flash->success(__('The upazila has been deleted.'));
        }
        else
        {
            $this->Flash->error(__('The upazila could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
