<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Components Controller
 *
 * @property \App\Model\Table\ComponentsTable $Components
 */
class ComponentsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $components = $this->Components->find('all', [
            'conditions' =>['Components.status !=' => 99],
            'contain' => ['CreatedUser', 'UpdatedUser']
        ]);
        $this->set('components', $components);
        $this->set('_serialize', ['components']);
    }

    /**
     * View method
     *
     * @param string|null $id Component id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $component = $this->Components->get($id, [
            'contain' => ['CreatedUser', 'UpdatedUser']
        ]);
        $this->set('component', $component);
        $this->set('_serialize', ['component']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $component = $this->Components->newEntity();
        if ($this->request->is('post'))
        {
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            $component = $this->Components->patchEntity($component, $data);
            if ($this->Components->save($component))
            {
                $this->Flash->success(__('The component has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The component could not be saved. Please, try again.'));
            }
        }
        $createdUser = $this->Components->CreatedUser->find('list', ['limit' => 200]);
        $updatedUser = $this->Components->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('component', 'createdUser', 'updatedUser'));
        $this->set('_serialize', ['component']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Component id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $component = $this->Components->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $data=$this->request->data;
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['updated_by']=$user['id'];
            $data['updated_date']=time();
            $component = $this->Components->patchEntity($component, $data);
            if ($this->Components->save($component))
            {
                $this->Flash->success(__('The component has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The component could not be saved. Please, try again.'));
            }
        }
        $createdUser = $this->Components->CreatedUser->find('list', ['limit' => 200]);
        $updatedUser = $this->Components->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('component', 'createdUser', 'updatedUser'));
        $this->set('_serialize', ['component']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Component id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $component = $this->Components->get($id);

        $user=$this->Auth->user();
        $data=$this->request->data;
        $data['updated_by']=$user['id'];
        $data['updated_date']=time();
        $data['status']=99;
        $component = $this->Components->patchEntity($component, $data);
        if ($this->Components->save($component))
        {
            $this->Flash->success(__('The component has been deleted.'));
        }
        else
        {
            $this->Flash->error(__('The component could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
