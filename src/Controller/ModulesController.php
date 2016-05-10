<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Modules Controller
 *
 * @property \App\Model\Table\ModulesTable $Modules
 */
class ModulesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $modules = $this->Modules->find('all', [
            'conditions' =>['Modules.status !=' => 99],
            'contain' => ['Components', 'CreatedUser', 'UpdatedUser']
        ]);
        $this->set('modules', $modules);
        $this->set('_serialize', ['modules']);
    }

    /**
     * View method
     *
     * @param string|null $id Module id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $module = $this->Modules->get($id, [
            'contain' => ['Components', 'CreatedUser', 'UpdatedUser']
        ]);
        $this->set('module', $module);
        $this->set('_serialize', ['module']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $module = $this->Modules->newEntity();
        if ($this->request->is('post'))
        {
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            $module = $this->Modules->patchEntity($module, $data);
            if ($this->Modules->save($module))
            {
                $this->Flash->success(__('The module has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The module could not be saved. Please, try again.'));
            }
        }
        $components = $this->Modules->Components->find('list', ['limit' => 200]);
        $createdUser = $this->Modules->CreatedUser->find('list', ['limit' => 200]);
        $updatedUser = $this->Modules->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('module', 'components', 'createdUser', 'updatedUser'));
        $this->set('_serialize', ['module']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Module id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $module = $this->Modules->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $data=$this->request->data;
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['updated_by']=$user['id'];
            $data['updated_date']=time();
            $module = $this->Modules->patchEntity($module, $data);
            if ($this->Modules->save($module))
            {
                $this->Flash->success(__('The module has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The module could not be saved. Please, try again.'));
            }
        }
        $components = $this->Modules->Components->find('list', ['limit' => 200]);
        $createdUser = $this->Modules->CreatedUser->find('list', ['limit' => 200]);
        $updatedUser = $this->Modules->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('module', 'components', 'createdUser', 'updatedUser'));
        $this->set('_serialize', ['module']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Module id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $module = $this->Modules->get($id);

        $user=$this->Auth->user();
        $data=$this->request->data;
        $data['updated_by']=$user['id'];
        $data['updated_date']=time();
        $data['status']=99;
        $module = $this->Modules->patchEntity($module, $data);
        if ($this->Modules->save($module))
        {
            $this->Flash->success(__('The module has been deleted.'));
        }
        else
        {
            $this->Flash->error(__('The module could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
