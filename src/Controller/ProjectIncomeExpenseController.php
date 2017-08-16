<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ProjectIncomeExpense Controller
 *
 * @property \App\Model\Table\ProjectIncomeExpenseTable $ProjectIncomeExpense
 */
class ProjectIncomeExpenseController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->loadModel('ProjectIncomeExpenses');
        $this->loadModel('Projects');
        $user = $this->Auth->user();
        if($this->request->is(['patch', 'post', 'put'])){
            $data = $this->request->data();
            $results = $this->ProjectIncomeExpenses->find()->where([
                'ProjectIncomeExpenses.month' => $data['month'],
                'ProjectIncomeExpenses.year' => $data['year'],
            ])
                ->contain('Projects')
                ->hydrate(false)->toArray();
            $this->set(compact('results'));
        }
    }
    /*
     * add function
     */
    public function add()
    {
        $this->loadModel('ProjectIncomeExpenses');
        $this->loadModel('Projects');
        $user = $this->Auth->user();
        if($this->request->is(['patch', 'post', 'put'])){
            $projects = [];
            $data = $this->request->data();
            for($i=0; $i <count($data['project_id']); $i++){
                $projects[$i]['project_id'] = $data['project_id'][$i];
                $projects[$i]['receive_money'] = $data['receive_money'][$i];
                $projects[$i]['expense_money'] = $data['expense_money'][$i];
                $projects[$i]['unpaid_money'] = $data['unpaid_money'][$i];
                $projects[$i]['month'] = $data['month'];
                $projects[$i]['year'] = $data['year'];
                $projects[$i]['status'] = 1;
                $projects[$i]['created_by'] = $user['id'];
            }
            $projects_data = $this->ProjectIncomeExpenses->newEntities($projects);

            foreach($projects_data as $entity):
                $this->ProjectIncomeExpenses->save($entity);
            endforeach;
            $this->Flash->success(__('প্রকল্পের প্রাপ্ত অর্থ ও ব্যয় সংরক্ষিত হয়েছে'));
            return $this->redirect(['action' => 'index']);
        }
        $income = $this->ProjectIncomeExpenses->newEntity();
        $projects = $this->Projects->find('list')->where(['Projects.status' => 1])->toArray();
        $this->set(compact('projects', 'income'));
    }

}
