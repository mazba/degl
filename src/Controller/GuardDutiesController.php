<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * GuardDuties Controller
 *
 * @property \App\Model\Table\GuardDutiesTable $GuardDuties
 */
class GuardDutiesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $user=$this->Auth->user();
        $guardDuties = $this->GuardDuties->find('all', [
            'conditions' =>['GuardDuties.status !=' => 99],
            'contain' => ['Offices', 'Employees', 'GuardDutyShifts', 'CreatedUser', 'UpdatedUser']
        ]);
        $this->set('guardDuties', $guardDuties);
        $this->set('_serialize', ['guardDuties']);
    }

    /**
     * View method
     *
     * @param string|null $id Guard Duty id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user=$this->Auth->user();
        $guardDuty = $this->GuardDuties->get($id, [
            'contain' => ['Offices', 'Employees', 'GuardDutyShifts', 'CreatedUser', 'UpdatedUser']
        ]);
        $this->set('guardDuty', $guardDuty);
        $this->set('_serialize', ['guardDuty']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user=$this->Auth->user();
        $guardDuty = $this->GuardDuties->newEntity();
        if ($this->request->is('post'))
        {

            $data=$this->request->data;
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            $x=strtotime($data['duty_date']);
            if($x!==false)
            {
                $data['duty_date']=$x;
            }

            $guardDuty = $this->GuardDuties->patchEntity($guardDuty, $data);
            if ($this->GuardDuties->save($guardDuty))
            {
                $this->Flash->success(__('The guard duty has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The guard duty could not be saved. Please, try again.'));
            }
        }
        if($user['user_group_id'] == 1)
        {
            $offices = $this->GuardDuties->Offices->find('list');
            $employees = $this->GuardDuties->Employees->find('list', ['conditions' => ['Designations.name_en'=>'Guard']
                ,'contain'=>['Designations']]);
            $guardDutyShifts = $this->GuardDuties->GuardDutyShifts->find('list');
        }
        else
        {
            $offices = $this->GuardDuties->Offices->find('list', ['conditions' => ['id'=>$user['office_id']]]);
            $employees = $this->GuardDuties->Employees->find('list', ['conditions' => ['Employees.office_id'=>$user['office_id'],'Designations.name_en'=>'Guard']
            ,'contain'=>['Designations']]);
            $guardDutyShifts = $this->GuardDuties->GuardDutyShifts->find('list', ['conditions' => ['office_id'=>$user['office_id']]]);
        }
        $this->set(compact('guardDuty', 'offices', 'employees', 'guardDutyShifts'));
        $this->set('_serialize', ['guardDuty']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Guard Duty id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user=$this->Auth->user();
        $guardDuty = $this->GuardDuties->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $data=$this->request->data;
            $data['updated_by']=$user['id'];
            $data['updated_date']=time();
            $x=strtotime($data['duty_date']);
            if($x!==false)
            {
                $data['duty_date']=$x;
            }
            $guardDuty = $this->GuardDuties->patchEntity($guardDuty, $data);
            if ($this->GuardDuties->save($guardDuty))
            {
                $this->Flash->success(__('The guard duty has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The guard duty could not be saved. Please, try again.'));
            }
        }
        if($user['user_group_id'] == 1)
        {
            $offices = $this->GuardDuties->Offices->find('list');
            $employees = $this->GuardDuties->Employees->find('list', ['conditions' => ['Designations.name_en'=>'Guard']
                ,'contain'=>['Designations']]);
            $guardDutyShifts = $this->GuardDuties->GuardDutyShifts->find('list');
        }
        else
        {
            $offices = $this->GuardDuties->Offices->find('list', ['conditions' => ['id'=>$user['office_id']]]);
            $employees = $this->GuardDuties->Employees->find('list', ['conditions' => ['Employees.office_id'=>$user['office_id'],'Designations.name_en'=>'Guard']
                ,'contain'=>['Designations']]);
            $guardDutyShifts = $this->GuardDuties->GuardDutyShifts->find('list', ['conditions' => ['office_id'=>$user['office_id']]]);
        }
        $this->set(compact('guardDuty', 'offices', 'employees', 'guardDutyShifts'));
        $this->set('_serialize', ['guardDuty']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Guard Duty id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $guardDuty = $this->GuardDuties->get($id);

        $user=$this->Auth->user();
        $data=$this->request->data;
        $data['updated_by']=$user['id'];
        $data['updated_date']=time();
        $data['status']=99;
        $guardDuty = $this->GuardDuties->patchEntity($guardDuty, $data);
        if ($this->GuardDuties->save($guardDuty))
        {
            $this->Flash->success(__('The guard duty has been deleted.'));
        }
        else
        {
            $this->Flash->error(__('The guard duty could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
