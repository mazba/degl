<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * FineAdjustments Controller
 *
 * @property \App\Model\Table\FineAdjustmentsTable $FineAdjustments
 */
class FineAdjustmentsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $user=$this->Auth->user();
        $fineAdjustments = $this->FineAdjustments->find('all', [
            'conditions' =>['FineAdjustments.status !=' => 99],
            'contain' => ['Schemes', 'CreatedUser', 'UpdatedUser']
        ]);
        $this->set('fineAdjustments', $fineAdjustments);
        $this->set('_serialize', ['fineAdjustments']);
    }

    /**
     * View method
     *
     * @param string|null $id Fine Adjustment id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user=$this->Auth->user();
        $fineAdjustment = $this->FineAdjustments->get($id, [
            'contain' => ['Schemes', 'CreatedUser', 'UpdatedUser']
        ]);
        $this->set('fineAdjustment', $fineAdjustment);
        $this->set('_serialize', ['fineAdjustment']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user=$this->Auth->user();
        $fineAdjustment = $this->FineAdjustments->newEntity();
        if ($this->request->is('post'))
        {

            $data=$this->request->data;
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            $fineAdjustment = $this->FineAdjustments->patchEntity($fineAdjustment, $data);
            if ($this->FineAdjustments->save($fineAdjustment))
            {
                $this->Flash->success('The fine adjustment has been saved.');
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error('The fine adjustment could not be saved. Please, try again.');
            }
        }
        $schemes = $this->FineAdjustments->Schemes->find('list');

        $this->set(compact('fineAdjustment', 'schemes'));
        $this->set('_serialize', ['fineAdjustment']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Fine Adjustment id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user=$this->Auth->user();
        $fineAdjustment = $this->FineAdjustments->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $data=$this->request->data;
            $data['updated_by']=$user['id'];
            $data['updated_date']=time();
            $fineAdjustment = $this->FineAdjustments->patchEntity($fineAdjustment, $data);
            if ($this->FineAdjustments->save($fineAdjustment))
            {
                $this->Flash->success('The fine adjustment has been saved.');
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error('The fine adjustment could not be saved. Please, try again.');
            }
        }
        $schemes = $this->FineAdjustments->Schemes->find('list');

        $this->set(compact('fineAdjustment', 'schemes'));
        $this->set('_serialize', ['fineAdjustment']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Fine Adjustment id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $fineAdjustment = $this->FineAdjustments->get($id);

        $user=$this->Auth->user();
        $data=$this->request->data;
        $data['updated_by']=$user['id'];
        $data['updated_date']=time();
        $data['status']=99;
        $fineAdjustment = $this->FineAdjustments->patchEntity($fineAdjustment, $data);
        if ($this->FineAdjustments->save($fineAdjustment))
        {
            $this->Flash->success('The fine adjustment has been deleted.');
        }
        else
        {
            $this->Flash->error('The fine adjustment could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
