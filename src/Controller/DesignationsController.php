<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Designations Controller
 *
 * @property \App\Model\Table\DesignationsTable $Designations
 */
class DesignationsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $user=$this->Auth->user();
        if($user['user_group_id']==1)
        {
            $designations = $this->Designations->find('all', [
                'conditions' =>['Designations.status !=' => 99],
                'contain' => ['Offices', 'CreatedUser', 'UpdatedUser','ParentDesignation'],
                'order' => ['Designations.order_no'=>'asc']
            ]);
        }
        else
        {
            $designations = $this->Designations->find('all', [
                'conditions' =>['Designations.status !=' => 99,'Designations.office_id'=>$user['office_id']],
                'contain' => ['Offices', 'CreatedUser', 'UpdatedUser','ParentDesignation'],
                'order' => ['Designations.order_no'=>'asc']
            ]);
        }

        $this->set('designations', $designations);
        $this->set('_serialize', ['designations']);
    }

    /**
     * View method
     *
     * @param string|null $id Designation id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $designation = $this->Designations->get($id, [
            'contain' => ['Offices', 'CreatedUser', 'UpdatedUser', 'Users']
        ]);
        $this->set('designation', $designation);
        $this->set('_serialize', ['designation']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $designation = $this->Designations->newEntity();
        $user=$this->Auth->user();
        if ($this->request->is('post'))
        {
            $data=$this->request->data;
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            if(!$data['designationParentid'])
            {
                $data['designationParentid']=0;
            }
            $designation = $this->Designations->patchEntity($designation, $data);
            if ($this->Designations->save($designation))
            {
                $this->Flash->success(__('The designation has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The designation could not be saved. Please, try again.'));
            }
        }
        if($user['user_group_id']==1)
        {
            $offices = $this->Designations->Offices->find('list');
            $parent_designations=$this->Designations->find('list',[
                'conditions' =>['designationParentid' => 0],
            ]);
        }
        else
        {
            $offices = $this->Designations->Offices->find('list', [
                'conditions' =>['Offices.id'=>$user['office_id']],

            ]);
            $parent_designations=$this->Designations->find('list',[
                'conditions' =>['designationParentid' => 0,'Designations.office_id'=>$user['office_id']]
            ]);
        }


        $this->set(compact('designation', 'offices','parent_designations'));
        $this->set('_serialize', ['designation']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Designation id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $designation = $this->Designations->get($id, [
            'contain' => []
        ]);
        $user=$this->Auth->user();
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $data=$this->request->data;

            $data=$this->request->data;
            $data['updated_by']=$user['id'];
            $data['updated_date']=time();
            if(!$data['designationParentid'])
            {
                $data['designationParentid']=0;
            }
            $designation = $this->Designations->patchEntity($designation, $data);
            if ($this->Designations->save($designation))
            {
                $this->Flash->success(__('The designation has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The designation could not be saved. Please, try again.'));
            }
        }
        if($user['user_group_id']==1)
        {
            $offices = $this->Designations->Offices->find('list');
            $parent_designations=$this->Designations->find('list',[
                'conditions' =>['designationParentid' => 0],
            ]);
        }
        else
        {
            $offices = $this->Designations->Offices->find('list', [
                'conditions' =>['Offices.id'=>$user['office_id']],

            ]);
            $parent_designations=$this->Designations->find('list',[
                'conditions' =>['designationParentid' => 0,'Designations.office_id'=>$user['office_id']]
            ]);
        }
        $this->set(compact('designation', 'offices','parent_designations'));
        $this->set('_serialize', ['designation']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Designation id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $designation = $this->Designations->get($id);

        $user=$this->Auth->user();
        $data=$this->request->data;
        $data['updated_by']=$user['id'];
        $data['updated_date']=time();
        $data['status']=99;
        $designation = $this->Designations->patchEntity($designation, $data);
        if ($this->Designations->save($designation))
        {
            $this->Flash->success(__('The designation has been deleted.'));
        }
        else
        {
            $this->Flash->error(__('The designation could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
