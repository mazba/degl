<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Employees Controller
 *
 * @property \App\Model\Table\EmployeesTable $Employees
 */
class EmployeesController extends AppController
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
            $employees = $this->Employees->find('all', [
                'conditions' =>['Employees.status !=' => 99],
                'contain' => ['Offices', 'Designations', 'CreatedUser', 'UpdatedUser']
            ]);
        }
        else
        {
            $employees = $this->Employees->find('all', [
                'conditions' =>['Employees.status !=' => 99,'Employees.office_id'=>$user['office_id']],
                'contain' => ['Offices', 'Designations', 'CreatedUser', 'UpdatedUser']
            ]);
        }

        $this->set('employees', $employees);
        $this->set('_serialize', ['employees']);
    }

    /**
     * View method
     *
     * @param string|null $id Employee id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $employee = $this->Employees->get($id, [
            'contain' => ['Offices', 'Designations', 'CreatedUser', 'UpdatedUser', 'AssignVehicles']
        ]);
        $this->set('employee', $employee);
        $this->set('_serialize', ['employee']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user=$this->Auth->user();
        $employee = $this->Employees->newEntity();
        if ($this->request->is('post'))
        {

            $data=$this->request->data;
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            $x=strtotime($data['birth_date']);
            if($x!==false)
            {
                $data['birth_date']=$x;
            }
            else
            {
                $data['birth_date']='';
            }
            $x=strtotime($data['joining_date']);
            if($x!==false)
            {
                $data['joining_date']=$x;
            }
            else
            {
                $data['joining_date']='';
            }
            $employee = $this->Employees->patchEntity($employee, $data);
            if ($this->Employees->save($employee))
            {
                $this->Flash->success(__('The employee has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The employee could not be saved. Please, try again.'));
            }
        }
        $offices = $this->Employees->Offices->find('list', ['conditions' =>['id' => $user['office_id']]]);
        $designations = $this->Employees->Designations->find('list', ['conditions' =>['office_id' => $user['office_id']]]);

        $this->set(compact('employee', 'offices', 'designations'));
        $this->set('_serialize', ['employee']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Employee id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $employee = $this->Employees->get($id, [
            'contain' => []
        ]);
        $user=$this->Auth->user();
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $data=$this->request->data;

            $data=$this->request->data;
            $data['updated_by']=$user['id'];
            $data['updated_date']=time();
            $x=strtotime($data['birth_date']);
            if($x!==false)
            {
                $data['birth_date']=$x;
            }
            else
            {
                $data['birth_date']='';
            }
            $x=strtotime($data['joining_date']);
            if($x!==false)
            {
                $data['joining_date']=$x;
            }
            else
            {
                $data['joining_date']='';
            }
            $employee = $this->Employees->patchEntity($employee, $data);
            if ($this->Employees->save($employee))
            {
                $this->Flash->success(__('The employee has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The employee could not be saved. Please, try again.'));
            }
        }
        $offices = $this->Employees->Offices->find('list', ['conditions' =>['id' => $user['office_id']]]);
        $designations = $this->Employees->Designations->find('list', ['conditions' =>['office_id' => $user['office_id']]]);
        $this->set(compact('employee', 'offices', 'designations'));
        $this->set('_serialize', ['employee']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Employee id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $employee = $this->Employees->get($id);

        $user=$this->Auth->user();
        $data=$this->request->data;
        $data['updated_by']=$user['id'];
        $data['updated_date']=time();
        $data['status']=99;
        $employee = $this->Employees->patchEntity($employee, $data);
        if ($this->Employees->save($employee))
        {
            $this->Flash->success('The employee has been deleted.');
        }
        else
        {
            $this->Flash->error('The employee could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
