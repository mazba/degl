<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * FinancialYearEstimates Controller
 *
 * @property \App\Model\Table\FinancialYearEstimatesTable $FinancialYearEstimates
 */
class FinancialYearEstimatesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $financialYearEstimates = $this->FinancialYearEstimates->find('all', [
            'conditions' =>['FinancialYearEstimates.status !=' => 99],
            'contain' => ['CreatedUser', 'UpdatedUser']
        ]);
        $this->set('financialYearEstimates', $financialYearEstimates);
        $this->set('_serialize', ['financialYearEstimates']);
    }

    /**
     * View method
     *
     * @param string|null $id Financial Year Estimate id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $financialYearEstimate = $this->FinancialYearEstimates->get($id, [
            'contain' => ['CreatedUser', 'UpdatedUser']
        ]);
        $this->set('financialYearEstimate', $financialYearEstimate);
        $this->set('_serialize', ['financialYearEstimate']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $financialYearEstimate = $this->FinancialYearEstimates->newEntity();
        if ($this->request->is('post'))
        {
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            $financialYearEstimate = $this->FinancialYearEstimates->patchEntity($financialYearEstimate, $data);
            if ($this->FinancialYearEstimates->save($financialYearEstimate))
            {
                $this->Flash->success(__('The financial year estimate has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The financial year estimate could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('financialYearEstimate'));
        $this->set('_serialize', ['financialYearEstimate']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Financial Year Estimate id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $financialYearEstimate = $this->FinancialYearEstimates->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $data=$this->request->data;
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['updated_by']=$user['id'];
            $data['updated_date']=time();
            $financialYearEstimate = $this->FinancialYearEstimates->patchEntity($financialYearEstimate, $data);
            if ($this->FinancialYearEstimates->save($financialYearEstimate))
            {
                $this->Flash->success(__('The financial year estimate has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The financial year estimate could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('financialYearEstimate'));
        $this->set('_serialize', ['financialYearEstimate']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Financial Year Estimate id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $financialYearEstimate = $this->FinancialYearEstimates->get($id);

        $user=$this->Auth->user();
        $data=$this->request->data;
        $data['updated_by']=$user['id'];
        $data['updated_date']=time();
        $data['status']=99;
        $financialYearEstimate = $this->FinancialYearEstimates->patchEntity($financialYearEstimate, $data);
        if ($this->FinancialYearEstimates->save($financialYearEstimate))
        {
            $this->Flash->success(__('The financial year estimate has been deleted.'));
        }
        else
        {
            $this->Flash->error(__('The financial year estimate could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
