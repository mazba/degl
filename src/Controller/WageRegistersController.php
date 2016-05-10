<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * WageRegisters Controller
 *
 * @property \App\Model\Table\WageRegistersTable $WageRegisters
 */
class WageRegistersController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $user=$this->Auth->user();

        $employees_table = TableRegistry::get('employees');
        $wage_register_table = TableRegistry::get('wage_registers');

        $sub_query = $wage_register_table->find();

        $sub_query->select(['employee_id'=>'employee_id','total_billing_days'=>$sub_query->func()->sum('billing_days'),'total_wage'=>$sub_query->func()->sum('total_wage')]);
        $sub_query->group(['employee_id']);

        $query = $employees_table->find();
        $query->select(['wr.total_billing_days','wr.total_wage','id','name_en']);
        $query->join([
            'table' => $sub_query,
            'alias' => 'wr',
            'type' => 'LEFT',
            'conditions' => 'wr.employee_id = employees.id',
        ]);
        $query->where(['Employees.status !=' => 99,'type'=>'MASTER']);
        if($user['user_group_id']!=1)
        {
            $query->where(['employees.office_id'=>$user['office_id']]);

        }
        $this->set('employees', $query);
    }

    /**
     * View method
     *
     * @param string|null $id Wage Register id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user=$this->Auth->user();
        $employee = $this->WageRegisters->Employees->get($id, [
            'contain' => []
        ]);
        $wage_register_table = TableRegistry::get('wage_registers');
        $query = $wage_register_table->find();
        $query->where(['employee_id'=>$id]);
        $query->select(['id','year'=>'wm.year','month'=>'wm.month','billing_days'=>'billing_days','daily_wage_rate'=>'daily_wage_rate','total_wage'=>'total_wage','bill_no'=>'bill_no','bill_pay_date'=>'bill_pay_date']);
        $query->join([
            'table' => 'wage_months',
            'alias' => 'wm',
            'type' => 'INNER',
            'conditions' => 'wage_registers.id = wm.wage_register_id',
        ]);

        $query->hydrate(false);
        $results=$query->toArray();
        $wage_details=array();
        foreach($results as $result)
        {
            $wage_details[$result['id']]['billing_days']=$result['billing_days'];
            $wage_details[$result['id']]['daily_wage_rate']=$result['daily_wage_rate'];
            $wage_details[$result['id']]['total_wage']=$result['total_wage'];
            $wage_details[$result['id']]['bill_no']=$result['bill_no'];
            $wage_details[$result['id']]['bill_pay_date']=$result['bill_pay_date'];
            $wage_details[$result['id']]['months'][]=date("M/y",strtotime($result['year'].'-'.$result['month'].'-01'));
        }

        $this->set(compact('employee','wage_details'));
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    /*public function add()
    {
        $user=$this->Auth->user();
        $wageRegister = $this->WageRegisters->newEntity();
        if ($this->request->is('post'))
        {

            $data=$this->request->data;
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            $wageRegister = $this->WageRegisters->patchEntity($wageRegister, $data);
            if ($this->WageRegisters->save($wageRegister))
            {
                $this->Flash->success('The wage register has been saved.');
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error('The wage register could not be saved. Please, try again.');
            }
        }
        $offices = $this->WageRegisters->Offices->find('list', ['limit' => 200]);
        $employees = $this->WageRegisters->Employees->find('list', ['limit' => 200]);
        $createdUser = $this->WageRegisters->CreatedUser->find('list', ['limit' => 200]);
        $updatedUser = $this->WageRegisters->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('wageRegister', 'offices', 'employees', 'createdUser', 'updatedUser'));
        $this->set('_serialize', ['wageRegister']);
    }*/

    /**
     * Edit method
     *
     * @param string|null $id Wage Register id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user=$this->Auth->user();
        $employee = $this->WageRegisters->Employees->get($id, [
            'contain' => []
        ]);
        $this->set(compact('employee'));
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $inputs=$this->request->data;
            if(empty($inputs['months']))
            {
                $this->Flash->error(__('You did not select any months.'));
                return;
            }
            else
            {
                $wage_months_table = TableRegistry::get('wage_months');
                $query = $wage_months_table->find();
                $query->where(['year_month  IN' => $inputs['months']]);
                $query->join([
                    'table' => 'wage_registers',
                    'alias' => 'wr',
                    'type' => 'LEFT',
                    'conditions' => 'wr.id = wage_months.wage_register_id',
                ]);
                $query->where(['wr.employee_id' => $id]);
                $query->first();
                $exists=$query->toArray();
                if($exists)
                {
                    $this->Flash->error(__('You already Paid wages for some of months.'));
                    return;
                }


            }
            $time=time();
            $data['office_id']=$user['office_id'];
            $data['employee_id']=$id;
            $data['billing_days']=$inputs['billing_days'];
            $data['daily_wage_rate']=$inputs['daily_wage_rate'];
            $data['total_wage']=$inputs['billing_days']*$inputs['daily_wage_rate'];
            $data['bill_no']=$inputs['bill_no'];

            $x=strtotime($inputs['bill_pay_date']);
            if($x!==false)
            {
                $data['bill_pay_date']=$x;
            }
            else
            {
                $this->Flash->error(__('Please set billing date.'));
                return;
            }
            $data['created_by']=$user['id'];
            $data['created_date']=$time;

            $wageRegister = $this->WageRegisters->newEntity();
            $wageRegister = $this->WageRegisters->patchEntity($wageRegister, $data);
            if ($status=$this->WageRegisters->save($wageRegister))
            {
                $wage_months_table = TableRegistry::get('wage_months');
                foreach($inputs['months'] as $year_month)
                {
                    $data=array();
                    $data['wage_register_id']=$status->id;
                    $y_m=explode('_',$year_month);
                    $data['month']=$y_m[1];
                    $data['year']=$y_m[0];
                    $data['year_month']=$year_month;
                    $data['created_by']=$user['id'];
                    $data['created_date']=$time;
                    $wage_months_query = $wage_months_table->query();
                    $wage_months_query->insert(array_keys($data))
                        ->values($data)
                        ->execute();
                }
                $this->Flash->success(__('The wage has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error('The wage register could not be saved. Please, try again.');
            }
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Wage Register id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    /*public function delete($id = null)
    {

        $wageRegister = $this->WageRegisters->get($id);

        $user=$this->Auth->user();
        $data=$this->request->data;
        $data['updated_by']=$user['id'];
        $data['updated_date']=time();
        $data['status']=99;
        $wageRegister = $this->WageRegisters->patchEntity($wageRegister, $data);
        if ($this->WageRegisters->save($wageRegister))
        {
            $this->Flash->success('The wage register has been deleted.');
        }
        else
        {
            $this->Flash->error('The wage register could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }*/
}
