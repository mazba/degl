<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * UserGroups Controller
 *
 * @property \App\Model\Table\UserGroupsTable $UserGroups
 */
class UserGroupsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $userGroups = $this->UserGroups->find('all', [
            'conditions' =>['UserGroups.status !=' => 99],
            'contain' => ['CreatedUser', 'UpdatedUser']
        ]);
        $this->set('userGroups', $userGroups);
        $this->set('_serialize', ['userGroups']);
    }

    /**
     * View method
     *
     * @param string|null $id User Group id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $userGroup = $this->UserGroups->get($id, [
            'contain' => ['CreatedUser', 'UpdatedUser', 'Users']
        ]);
        $this->set('userGroup', $userGroup);
        $this->set('_serialize', ['userGroup']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $userGroup = $this->UserGroups->newEntity();
        if ($this->request->is('post'))
        {
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            $userGroup = $this->UserGroups->patchEntity($userGroup, $data);
            if ($this->UserGroups->save($userGroup))
            {
                $this->Flash->success(__('The user group has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The user group could not be saved. Please, try again.'));
            }
        }
        $createdUser = $this->UserGroups->CreatedUser->find('list', ['limit' => 200]);
        $updatedUser = $this->UserGroups->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('userGroup', 'createdUser', 'updatedUser'));
        $this->set('_serialize', ['userGroup']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User Group id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $userGroup = $this->UserGroups->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $data=$this->request->data;
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['updated_by']=$user['id'];
            $data['updated_date']=time();
            $userGroup = $this->UserGroups->patchEntity($userGroup, $data);
            if ($this->UserGroups->save($userGroup))
            {
                $this->Flash->success(__('The user group has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The user group could not be saved. Please, try again.'));
            }
        }
        $createdUser = $this->UserGroups->CreatedUser->find('list', ['limit' => 200]);
        $updatedUser = $this->UserGroups->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('userGroup', 'createdUser', 'updatedUser'));
        $this->set('_serialize', ['userGroup']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User Group id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $userGroup = $this->UserGroups->get($id);

        $user=$this->Auth->user();
        $data=$this->request->data;
        $data['updated_by']=$user['id'];
        $data['updated_date']=time();
        $data['status']=99;
        $userGroup = $this->UserGroups->patchEntity($userGroup, $data);
        if ($this->UserGroups->save($userGroup))
        {
            $this->Flash->success(__('The user group has been deleted.'));
        }
        else
        {
            $this->Flash->error(__('The user group could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
