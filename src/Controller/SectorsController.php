<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Sectors Controller
 *
 * @property \App\Model\Table\SectorsTable $Sectors
 */
class SectorsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $user=$this->Auth->user();
        $sectors = $this->Sectors->find('all', [
            'conditions' =>['Sectors.status !=' => 99],
            'contain' => ['CreatedUser', 'UpdatedUser']
        ]);
        $this->set('sectors', $sectors);
        $this->set('_serialize', ['sectors']);
    }

    /**
     * View method
     *
     * @param string|null $id Sector id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user=$this->Auth->user();
        $sector = $this->Sectors->get($id, [
            'contain' => ['CreatedUser', 'UpdatedUser']
        ]);
        $this->set('sector', $sector);
        $this->set('_serialize', ['sector']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user=$this->Auth->user();
        $sector = $this->Sectors->newEntity();
        if ($this->request->is('post'))
        {

            $data=$this->request->data;
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            $sector = $this->Sectors->patchEntity($sector, $data);
            if ($this->Sectors->save($sector))
            {
                $this->Flash->success('The sector has been saved.');
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error('The sector could not be saved. Please, try again.');
            }
        }
        $createdUser = $this->Sectors->CreatedUser->find('list', ['limit' => 200]);
        $updatedUser = $this->Sectors->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('sector', 'createdUser', 'updatedUser'));
        $this->set('_serialize', ['sector']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Sector id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user=$this->Auth->user();
        $sector = $this->Sectors->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $data=$this->request->data;
            $data['updated_by']=$user['id'];
            $data['updated_date']=time();
            $sector = $this->Sectors->patchEntity($sector, $data);
            if ($this->Sectors->save($sector))
            {
                $this->Flash->success('The sector has been saved.');
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error('The sector could not be saved. Please, try again.');
            }
        }
        $createdUser = $this->Sectors->CreatedUser->find('list', ['limit' => 200]);
        $updatedUser = $this->Sectors->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('sector', 'createdUser', 'updatedUser'));
        $this->set('_serialize', ['sector']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Sector id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $sector = $this->Sectors->get($id);

        $user=$this->Auth->user();
        $data=$this->request->data;
        $data['updated_by']=$user['id'];
        $data['updated_date']=time();
        $data['status']=99;
        $sector = $this->Sectors->patchEntity($sector, $data);
        if ($this->Sectors->save($sector))
        {
            $this->Flash->success('The sector has been deleted.');
        }
        else
        {
            $this->Flash->error('The sector could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
