<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * FinancialYearRates Controller
 *
 * @property \App\Model\Table\FinancialYearRatesTable $FinancialYearRates
 */
class FinancialYearRatesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $financialYearRates = $this->FinancialYearRates->find('all', [
            'conditions' =>['FinancialYearRates.status !=' => 99],
            'contain' => ['FinancialYearEstimates', 'CreatedUser', 'UpdatedUser']
        ]);
        $this->set('financialYearRates', $financialYearRates);
        $this->set('_serialize', ['financialYearRates']);
    }

    /**
     * View method
     *
     * @param string|null $id Financial Year Rate id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $financialYearRate = $this->FinancialYearRates->get($id, [
            'contain' => ['FinancialYearEstimates', 'CreatedUser', 'UpdatedUser', 'ItemRates', 'Schemes']
        ]);
        $this->set('financialYearRate', $financialYearRate);
        $this->set('_serialize', ['financialYearRate']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $financialYearRate = $this->FinancialYearRates->newEntity();
        if ($this->request->is('post'))
        {
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            $financialYearRate = $this->FinancialYearRates->patchEntity($financialYearRate, $data);
            if ($this->FinancialYearRates->save($financialYearRate))
            {
                $this->Flash->success('The financial year rate has been saved.');
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error('The financial year rate could not be saved. Please, try again.');
            }
        }
        $financialYearEstimates = $this->FinancialYearRates->FinancialYearEstimates->find('list', ['limit' => 200]);
        $createdUser = $this->FinancialYearRates->CreatedUser->find('list', ['limit' => 200]);
        $updatedUser = $this->FinancialYearRates->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('financialYearRate', 'financialYearEstimates', 'createdUser', 'updatedUser'));
        $this->set('_serialize', ['financialYearRate']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Financial Year Rate id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $financialYearRate = $this->FinancialYearRates->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $data=$this->request->data;
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['updated_by']=$user['id'];
            $data['updated_date']=time();
            $financialYearRate = $this->FinancialYearRates->patchEntity($financialYearRate, $data);
            if ($this->FinancialYearRates->save($financialYearRate))
            {
                $this->Flash->success(__('The financial year rate has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The financial year rate could not be saved. Please, try again.'));
            }
        }
        $financialYearEstimates = $this->FinancialYearRates->FinancialYearEstimates->find('list', ['limit' => 200]);
        $createdUser = $this->FinancialYearRates->CreatedUser->find('list', ['limit' => 200]);
        $updatedUser = $this->FinancialYearRates->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('financialYearRate', 'financialYearEstimates', 'createdUser', 'updatedUser'));
        $this->set('_serialize', ['financialYearRate']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Financial Year Rate id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $financialYearRate = $this->FinancialYearRates->get($id);

        $user=$this->Auth->user();
        $data=$this->request->data;
        $data['updated_by']=$user['id'];
        $data['updated_date']=time();
        $data['status']=99;
        $financialYearRate = $this->FinancialYearRates->patchEntity($financialYearRate, $data);
        if ($this->FinancialYearRates->save($financialYearRate))
        {
            $this->Flash->success(__('The financial year rate has been deleted.'));
        }
        else
        {
            $this->Flash->error(__('The financial year rate could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
