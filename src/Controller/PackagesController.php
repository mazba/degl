<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Packages Controller
 *
 * @property \App\Model\Table\PackagesTable $Packages
 */
class PackagesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $user=$this->Auth->user();
        $packages = $this->Packages->find('all', [
            'conditions' =>['Packages.status !=' => 99],
            'contain' => ['CreatedUser', 'UpdatedUser']
        ]);
        $this->set('packages', $packages);
        $this->set('_serialize', ['packages']);
    }

    /**
     * View method
     *
     * @param string|null $id Package id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user=$this->Auth->user();
        $package = $this->Packages->get($id, [
            'contain' => ['CreatedUser', 'UpdatedUser']
        ]);
        $this->set('package', $package);
        $this->set('_serialize', ['package']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user=$this->Auth->user();
        $package = $this->Packages->newEntity();
        if ($this->request->is('post'))
        {

            $data=$this->request->data;
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            $package = $this->Packages->patchEntity($package, $data);
            if ($this->Packages->save($package))
            {
                $this->Flash->success('The package has been saved.');
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error('The package could not be saved. Please, try again.');
            }
        }
        $createdUser = $this->Packages->CreatedUser->find('list', ['limit' => 200]);
        $updatedUser = $this->Packages->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('package', 'createdUser', 'updatedUser'));
        $this->set('_serialize', ['package']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Package id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user=$this->Auth->user();
        $package = $this->Packages->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $data=$this->request->data;
            $data['updated_by']=$user['id'];
            $data['updated_date']=time();
            $package = $this->Packages->patchEntity($package, $data);
            if ($this->Packages->save($package))
            {
                $this->Flash->success('The package has been saved.');
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error('The package could not be saved. Please, try again.');
            }
        }
        $createdUser = $this->Packages->CreatedUser->find('list', ['limit' => 200]);
        $updatedUser = $this->Packages->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('package', 'createdUser', 'updatedUser'));
        $this->set('_serialize', ['package']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Package id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $package = $this->Packages->get($id);

        $user=$this->Auth->user();
        $data=$this->request->data;
        $data['updated_by']=$user['id'];
        $data['updated_date']=time();
        $data['status']=99;
        $package = $this->Packages->patchEntity($package, $data);
        if ($this->Packages->save($package))
        {
            $this->Flash->success('The package has been deleted.');
        }
        else
        {
            $this->Flash->error('The package could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
