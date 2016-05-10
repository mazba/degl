<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * SalaryRevenues Controller
 *
 * @property \App\Model\Table\SalaryRevenuesTable $SalaryRevenues
 */
class SalaryRevenuesController extends AppController
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
        $salary_revenues_table = TableRegistry::get('salary_revenues');

        $sub_query = $salary_revenues_table->find();

        $sub_query->select(['employee_id'=>'employee_id','net_salary'=>$sub_query->func()->sum('net_salary')]);
        $sub_query->group(['employee_id']);

        $query = $employees_table->find();
        $query->select(['sr.net_salary','id','name_en']);
        $query->join([
            'table' => $sub_query,
            'alias' => 'sr',
            'type' => 'LEFT',
            'conditions' => 'sr.employee_id = employees.id',
        ]);
        $query->where(['Employees.status !=' => 99,'type'=>'REVENUE']);
        if($user['user_group_id']!=1)
        {
            $query->where(['employees.office_id'=>$user['office_id']]);

        }
        $this->set('employees', $query);
    }

    /**
     * View method
     *
     * @param string|null $id Salary Revenue id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user=$this->Auth->user();
        $employee = $this->SalaryRevenues->Employees->get($id, [
            'contain' => []
        ]);
        $query = $this->SalaryRevenues->find();
        $query->where(['employee_id'=>$id]);
        $query->hydrate(false);
        $salary_details=$query->toArray();

        $this->set(compact('employee','salary_details'));


    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    /*public function add()
    {
        $user=$this->Auth->user();
        $salaryRevenue = $this->SalaryRevenues->newEntity();
        if ($this->request->is('post'))
        {

            $data=$this->request->data;
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            $salaryRevenue = $this->SalaryRevenues->patchEntity($salaryRevenue, $data);
            if ($this->SalaryRevenues->save($salaryRevenue))
            {
                $this->Flash->success('The salary revenue has been saved.');
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error('The salary revenue could not be saved. Please, try again.');
            }
        }
        $offices = $this->SalaryRevenues->Offices->find('list', ['limit' => 200]);
        $employees = $this->SalaryRevenues->Employees->find('list', ['limit' => 200]);
        $createdUser = $this->SalaryRevenues->CreatedUser->find('list', ['limit' => 200]);
        $updatedUser = $this->SalaryRevenues->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('salaryRevenue', 'offices', 'employees', 'createdUser', 'updatedUser'));
        $this->set('_serialize', ['salaryRevenue']);
    }*/

    /**
     * Edit method
     *
     * @param string|null $id Salary Revenue id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user=$this->Auth->user();
        $employee = $this->SalaryRevenues->Employees->get($id, [
            'contain' => []
        ]);
        $this->set(compact('employee'));
        $salaryRevenue = $this->SalaryRevenues->newEntity();
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $inputs=$this->request->data;
            $time=time();
            $data['office_id']=$user['office_id'];
            $data['employee_id']=$id;

            $query = $this->SalaryRevenues->find();
            $query->where(['year_month' => $inputs['month']]);
            $query->where(['employee_id' => $id]);
            $query->first();
            $exists=$query->toArray();
            if($exists)
            {
                $this->Flash->error(__('You already Paid salary  for this month.'));
                return;
            }

            $y_m=explode('_',$inputs['month']);
            $data['year']=$y_m[0];
            $data['month']=$y_m[1];
            $data['year_month']=$inputs['month'];
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
            $total_cut=0;
            $total_salary=0;
            $val=floatval($inputs['basic']);
            if($val)
            {
                $data['basic']=$val;
                $total_salary+=$val;
            }
            else
            {
                $data['basic']='';
            }
            $val=floatval($inputs['house_rent']);
            if($val)
            {
                $data['house_rent']=$val;
                $total_salary+=$val;
            }
            else
            {
                $data['house_rent']='';
            }
            $val=floatval($inputs['medical']);
            echo $val." medical";
            if($val)
            {
                $data['medical']=$val;
                $total_salary+=$val;
            }
            else
            {
                $data['medical']='';
            }
            $val=floatval($inputs['transport']);
            if($val)
            {
                $data['transport']=$val;
                $total_salary+=$val;
            }
            else
            {
                $data['transport']='';
            }
            $val=floatval($inputs['festival']);
            if($val)
            {
                $data['festival']=$val;
                $total_salary+=$val;
            }
            else
            {
                $data['festival']='';
            }
            $val=floatval($inputs['tiffin']);
            if($val)
            {
                $data['tiffin']=$val;
                $total_salary+=$val;
            }
            else
            {
                $data['tiffin']='';
            }
            $val=floatval($inputs['recreation']);
            if($val)
            {
                $data['recreation']=$val;
                $total_salary+=$val;
            }
            else
            {
                $data['recreation']='';
            }
            $val=floatval($inputs['laundry']);
            if($val)
            {
                $data['laundry']=$val;
                $total_salary+=$val;
            }
            else
            {
                $data['laundry']='';
            }
            $val=floatval($inputs['overtime']);
            if($val)
            {
                $data['overtime']=$val;
                $total_salary+=$val;
            }
            else
            {
                $data['overtime']='';
            }
            $val=floatval($inputs['domestic_aid']);
            if($val)
            {
                $data['domestic_aid']=$val;
                $total_salary+=$val;
            }
            else
            {
                $data['domestic_aid']='';
            }
            $val=floatval($inputs['travel']);
            if($val)
            {
                $data['travel']=$val;
                $total_salary+=$val;
            }
            else
            {
                $data['travel']='';
            }
            $val=floatval($inputs['pahari']);
            if($val)
            {
                $data['pahari']=$val;
                $total_salary+=$val;
            }
            else
            {
                $data['pahari']='';
            }
            $val=floatval($inputs['preshon']);
            if($val)
            {
                $data['preshon']=$val;
                $total_salary+=$val;
            }
            else
            {
                $data['preshon']='';
            }
            $val=floatval($inputs['appayon']);
            if($val)
            {
                $data['appayon']=$val;
                $total_salary+=$val;
            }
            else
            {
                $data['appayon']='';
            }
            $val=floatval($inputs['education_aid']);
            if($val)
            {
                $data['education_aid']=$val;
                $total_salary+=$val;
            }
            else
            {
                $data['education_aid']='';
            }
            $val=floatval($inputs['welfare_cut']);
            if($val)
            {
                $data['welfare_cut']=$val;
                $total_cut+=$val;
            }
            else
            {
                $data['welfare_cut']='';
            }
            $val=floatval($inputs['other_cut']);
            if($val)
            {
                $data['other_cut']=$val;
                $total_cut+=$val;
            }
            else
            {
                $data['other_cut']='';
            }
            $data['total_cut']=$total_cut;
            $data['total_salary']=$total_salary;
            $data['net_salary']=$total_salary-$total_cut;
            $data['remarks']=$inputs['remarks'];
            $data['created_by']=$user['id'];
            $data['created_date']=$time;
            $salaryRevenue = $this->SalaryRevenues->patchEntity($salaryRevenue, $data);
            if ($this->SalaryRevenues->save($salaryRevenue))
            {
                $this->Flash->success(__('The salary revenue has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The salary revenue could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('salaryRevenue'));

    }

    /**
     * Delete method
     *
     * @param string|null $id Salary Revenue id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $salaryRevenue = $this->SalaryRevenues->get($id);

        $user=$this->Auth->user();
        $data=$this->request->data;
        $data['updated_by']=$user['id'];
        $data['updated_date']=time();
        $data['status']=99;
        $salaryRevenue = $this->SalaryRevenues->patchEntity($salaryRevenue, $data);
        if ($this->SalaryRevenues->save($salaryRevenue))
        {
            $this->Flash->success(__('The salary revenue has been deleted.'));
        }
        else
        {
            $this->Flash->error(__('The salary revenue could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
