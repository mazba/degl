<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Municipalities Controller
 *
 * @property \App\Model\Table\MunicipalitiesTable $Municipalities
 */
class MunicipalitiesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $municipalities = $this->Municipalities->find('all', [
            'conditions' =>['Municipalities.status !=' => 99],
            'contain' => ['Districts', 'CreatedUser', 'UpdatedUser']
        ]);
        $this->set('municipalities', $municipalities);
        $this->set('_serialize', ['municipalities']);
    }

    /**
     * View method
     *
     * @param string|null $id Municipality id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $municipality = $this->Municipalities->get($id, [
            'contain' => ['Districts', 'CreatedUser', 'UpdatedUser', 'Schemes']
        ]);
        $this->set('municipality', $municipality);
        $this->set('_serialize', ['municipality']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $municipality = $this->Municipalities->newEntity();
        if ($this->request->is('post'))
        {
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            $municipality = $this->Municipalities->patchEntity($municipality, $data);
            if ($this->Municipalities->save($municipality))
            {
                $this->Flash->success(__('The municipality has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The municipality could not be saved. Please, try again.'));
            }
        }
        $districts = $this->Municipalities->Districts->find('list', ['limit' => 200]);
        $createdUser = $this->Municipalities->CreatedUser->find('list', ['limit' => 200]);
        $updatedUser = $this->Municipalities->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('municipality', 'districts', 'createdUser', 'updatedUser'));
        $this->set('_serialize', ['municipality']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Municipality id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $municipality = $this->Municipalities->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $data=$this->request->data;
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['updated_by']=$user['id'];
            $data['updated_date']=time();
            $municipality = $this->Municipalities->patchEntity($municipality, $data);
            if ($this->Municipalities->save($municipality))
            {
                $this->Flash->success(__('The municipality has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The municipality could not be saved. Please, try again.'));
            }
        }
        $districts = $this->Municipalities->Districts->find('list', ['limit' => 200]);
        $createdUser = $this->Municipalities->CreatedUser->find('list', ['limit' => 200]);
        $updatedUser = $this->Municipalities->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('municipality', 'districts', 'createdUser', 'updatedUser'));
        $this->set('_serialize', ['municipality']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Municipality id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $municipality = $this->Municipalities->get($id);

        $user=$this->Auth->user();
        $data=$this->request->data;
        $data['updated_by']=$user['id'];
        $data['updated_date']=time();
        $data['status']=99;
        $municipality = $this->Municipalities->patchEntity($municipality, $data);
        if ($this->Municipalities->save($municipality))
        {
            $this->Flash->success(__('The municipality has been deleted.'));
        }
        else
        {
            $this->Flash->error(__('The municipality could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
