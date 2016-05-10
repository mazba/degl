<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Contractors Controller
 *
 * @property \App\Model\Table\ContractorsTable $Contractors
 */
class ContractorsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $contractors = $this->Contractors->find('all', [
            'conditions' =>['Contractors.status !=' => 99],
        ]);
        $this->set('contractors', $contractors);
        $this->set('_serialize', ['contractors']);
    }

    /**
     * View method
     *
     * @param string|null $id Contractor id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $contractor = $this->Contractors->get($id, [
            'contain' => ['CreatedUser', 'UpdatedUser']
        ]);
        $this->set('contractor', $contractor);
        $this->set('_serialize', ['contractor']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $contractor = $this->Contractors->newEntity();
        if ($this->request->is('post'))
        {
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            $contractor = $this->Contractors->patchEntity($contractor, $data);
            if ($this->Contractors->save($contractor))
            {
                $this->Flash->success(__('The contractor has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The contractor could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('contractor'));
        $this->set('_serialize', ['contractor']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Contractor id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $contractor = $this->Contractors->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $data=$this->request->data;
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['updated_by']=$user['id'];
            $data['updated_date']=time();
            $contractor = $this->Contractors->patchEntity($contractor, $data);
            if ($this->Contractors->save($contractor))
            {
                $this->Flash->success(__('The contractor has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The contractor could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('contractor'));
        $this->set('_serialize', ['contractor']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Contractor id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $contractor = $this->Contractors->get($id);

        $user=$this->Auth->user();
        $data=$this->request->data;
        $data['updated_by']=$user['id'];
        $data['updated_date']=time();
        $data['status']=99;
        $contractor = $this->Contractors->patchEntity($contractor, $data);
        if ($this->Contractors->save($contractor))
        {
            $this->Flash->success(__('The contractor has been deleted.'));
        }
        else
        {
            $this->Flash->error(__('The contractor could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
