<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * TreePlants Controller
 *
 * @property \App\Model\Table\TreePlantsTable $TreePlants
 */
class TreePlantsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $user=$this->Auth->user();
        $treePlants = $this->TreePlants->find('all', [
            'conditions' =>['TreePlants.status !=' => 99],
            'contain' => ['FinancialYearEstimates', 'CreatedUser', 'UpdatedUser']
        ]);
        $this->set('treePlants', $treePlants);
        $this->set('_serialize', ['treePlants']);
    }

    /**
     * View method
     *
     * @param string|null $id Tree Plant id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user=$this->Auth->user();
        $treePlant = $this->TreePlants->get($id, [
            'contain' => ['FinancialYearEstimates', 'CreatedUser', 'UpdatedUser']
        ]);
        $this->set('treePlant', $treePlant);
        $this->set('_serialize', ['treePlant']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user=$this->Auth->user();
        $treePlant = $this->TreePlants->newEntity();
        if ($this->request->is('post'))
        {

            $data=$this->request->data;
            $data['target_total_plant']=$data['target_bonoz']+$data['target_vesoz']+$data['target_foloz'];
            $data['progress_total_plant']=$data['progress_bonoz']+$data['progress_vesoz']+$data['progress_foloz'];
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            $treePlant = $this->TreePlants->patchEntity($treePlant, $data);
            if ($this->TreePlants->save($treePlant))
            {
                $this->Flash->success('The tree plant has been saved.');
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error('The tree plant could not be saved. Please, try again.');
            }
        }
        $FinancialYearEstimates = $this->TreePlants->FinancialYearEstimates->find('list', ['limit' => 200]);
        $createdUser = $this->TreePlants->CreatedUser->find('list', ['limit' => 200]);
        $updatedUser = $this->TreePlants->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('treePlant', 'FinancialYearEstimates', 'createdUser', 'updatedUser'));
        $this->set('_serialize', ['treePlant']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Tree Plant id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user=$this->Auth->user();
        $treePlant = $this->TreePlants->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $data=$this->request->data;
            $data['target_total_plant']=$data['target_bonoz']+$data['target_vesoz']+$data['target_foloz'];
            $data['progress_total_plant']=$data['progress_bonoz']+$data['progress_vesoz']+$data['progress_foloz'];
            $data['alive_total_plant']=$data['alive_bonoz']+$data['alive_vesoz']+$data['alive_foloz'];
            $data['updated_by']=$user['id'];
            $data['updated_date']=time();
            $treePlant = $this->TreePlants->patchEntity($treePlant, $data);
            if ($this->TreePlants->save($treePlant))
            {
                $this->Flash->success('The tree plant has been saved.');
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error('The tree plant could not be saved. Please, try again.');
            }
        }
        $FinancialYearEstimates = $this->TreePlants->FinancialYearEstimates->find('list', ['limit' => 200]);
        $createdUser = $this->TreePlants->CreatedUser->find('list', ['limit' => 200]);
        $updatedUser = $this->TreePlants->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('treePlant', 'FinancialYearEstimates', 'createdUser', 'updatedUser'));
        $this->set('_serialize', ['treePlant']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Tree Plant id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $treePlant = $this->TreePlants->get($id);

        $user=$this->Auth->user();
        $data=$this->request->data;
        $data['updated_by']=$user['id'];
        $data['updated_date']=time();
        $data['status']=99;
        $treePlant = $this->TreePlants->patchEntity($treePlant, $data);
        if ($this->TreePlants->save($treePlant))
        {
            $this->Flash->success('The tree plant has been deleted.');
        }
        else
        {
            $this->Flash->error('The tree plant could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }

    public function report()
    {


        $FinancialYearEstimates = $this->TreePlants->FinancialYearEstimates->find('list', ['limit' => 200]);
        $this->set(compact('FinancialYearEstimates'));
    }

    public function get_list()
    {
        $this->layout="ajax";
        $this->view="report_list";
        $id=$this->request->data['financial_year_id'];
        $treePlants = $this->TreePlants->find('all', [
        'conditions' => ['TreePlants.status !='=>99,'TreePlants.financial_year_estimate_id'=>$id],'contain'=>['FinancialYearEstimates']
    ])->toArray();

        $this->set(compact('treePlants'));
        $this->set('_serialize', ['treePlants']);
    }
}
