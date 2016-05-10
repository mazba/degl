<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Inspections Controller
 *
 * @property \App\Model\Table\InspectionsTable $Inspections
 */
class InspectionsController extends AppController
{
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $user = $this->Auth->user();
        $inspections = $this->Inspections->find('all', [
            'conditions' => ['Inspections.status !=' => 99],
            'contain' => ['FinancialYearEstimates', 'InspectedTeams'],
            'order'=>['Inspections.created_date'=>'DESC']
        ]);
        $this->set('inspections', $inspections);
        $this->set('_serialize', ['inspections']);
    }

    /**
     * View method
     *
     * @param string|null $id Inspection id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Auth->user();
        $inspection = $this->Inspections->get($id, [
            'contain' => ['FinancialYearEstimates', 'InspectedTeams', 'CreatedUser', 'UpdatedUser']
        ]);
        $this->set('inspection', $inspection);
        $this->set('_serialize', ['inspection']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Auth->user();
        $inspection = $this->Inspections->newEntity();
        if ($this->request->is('post')) {

            $inputs = $this->request->data;
            $data = array();
            if (!$inputs['inspected_team_id']) {
                $this->loadModel('InspectedTeams');
                $data['name_en'] = $inputs['team_name_en'];
                $data['name_bn'] = $inputs['team_name_bn'];
                $data['status'] = 1;
                $data['created_by'] = $user['id'];
                $data['created_date'] = time();
                $team = $this->InspectedTeams->newEntity();
                $team = $this->InspectedTeams->patchEntity($team, $data);
                $inspectedTeams = $this->InspectedTeams->save($team);
                unset($data);
            }
            $data['financial_year_estimate_id'] = $inputs['financial_year_estimate_id'];
            if(!$inputs['inspected_team_id']){
                $data['inspected_team_id'] = $inspectedTeams['id'];
            }else
            {
                $data['inspected_team_id'] = $inputs['inspected_team_id'];
            }

            $data['status'] = 1;
            $data['created_by'] = $user['id'];
            $data['created_date'] = time();

            $inspection = $this->Inspections->patchEntity($inspection, $data);
            if ($inspection = $this->Inspections->save($inspection)) {
                unset($data);
                $this->loadModel('InspectedSchemes');
                foreach ($inputs['scheme_id'] as $key => $value) {
                    $data['inspection_id'] = $inspection['id'];
                    $data['scheme_id'] = $value;
                    $data['status1'] = $inputs['status1'][$key];
                    $data['status2'] = $inputs['status1'][$key];
                    $data['created_by'] = $user['id'];
                    $data['created_date'] = time();
                    $inspectedScheme = $this->InspectedSchemes->newEntity();
                    $inspectedScheme = $this->InspectedSchemes->patchEntity($inspectedScheme, $data);
                    $inspectedScheme = $this->InspectedSchemes->save($inspectedScheme);
                }

                $this->Flash->success('The inspection has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The inspection could not be saved. Please, try again.');
            }
        }
        $financialYearEstimates = $this->Inspections->FinancialYearEstimates->find('list', ['limit' => 200]);
        $inspectedTeams = $this->Inspections->InspectedTeams->find('list', ['limit' => 200]);
        $this->loadModel('Projects');
        $projects = $this->Projects->find('list', ['limit' => 200]);
        $this->set(compact('inspection', 'financialYearEstimates', 'inspectedTeams', 'projects'));
        $this->set('_serialize', ['inspection']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Inspection id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Auth->user();
        $inspection = $this->Inspections->get($id, [
            'contain' => ['FinancialYearEstimates', 'InspectedTeams']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $inputs = $this->request->data;

            $data['remarks'] = $inputs['remarks'];
            $data['status'] = $inputs['status'];
            $data['updated_by'] = $user['id'];
            $data['updated_date'] = time();
            $inspection = $this->Inspections->patchEntity($inspection, $data);
            if ($this->Inspections->save($inspection)) {
                unset($data);
                $this->loadModel('InspectedSchemes');

                foreach ($inputs['status2'] as $key => $value) {
                    $scheme = $this->InspectedSchemes->get($key);
                    $data['status2'] = $value;
                    $scheme = $this->InspectedSchemes->patchEntity($scheme, $data);
                    $scheme = $this->InspectedSchemes->save($scheme);
                }

                $this->Flash->success('The inspection has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The inspection could not be saved. Please, try again.');
            }
        }
        $financialYearEstimates = $this->Inspections->FinancialYearEstimates->find('list', ['limit' => 200]);
        $this->loadModel('InspectedSchemes');
        $schemes = $this->InspectedSchemes->find()
            ->select(['scheme_id' => 'schemes.id', 'name' => 'schemes.name_bn', 'status1' => 'InspectedSchemes.status1', 'status2' => 'InspectedSchemes.status2', 'id' => 'InspectedSchemes.id'])
            ->where(['InspectedSchemes.inspection_id' => $id])
            ->leftJoin('schemes', 'schemes.id=InspectedSchemes.scheme_id')
            ->toArray();
        $this->set(compact('inspection', 'financialYearEstimates', 'schemes'));
        $this->set('_serialize', ['inspection']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Inspection id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $inspection = $this->Inspections->get($id);

        $user = $this->Auth->user();
        $data = $this->request->data;
        $data['updated_by'] = $user['id'];
        $data['updated_date'] = time();
        $data['status'] = 99;
        $inspection = $this->Inspections->patchEntity($inspection, $data);
        if ($this->Inspections->save($inspection)) {
            $this->Flash->success('The inspection has been deleted.');
        } else {
            $this->Flash->error('The inspection could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }

    /*
     * Get Scheme List by project id
     */

    public function get_scheme_list()
    {
        $this->layout = "ajax";
        $project_id = $this->request->data['project_id'];
        $this->loadModel('Schemes');
        $schemes = $this->Schemes->find('list', ['conditions' => ['Schemes.project_id' => $project_id, 'Schemes.status' => 1]]);
        $this->set(compact('schemes'));

    }

    public function report()
    {
        $financialYearEstimates = $this->Inspections->FinancialYearEstimates->find('list', ['limit' => 200]);
        $this->set(compact('financialYearEstimates'));
    }

    public function inspection_list()
    {
        $id = $this->request->data['financial_year_id'];
        $inspections = $this->Inspections->find();
        $inspections->autoFields(true);
        $inspections->select(['team_name' => 'inspected_teams.name_bn', 'financial_year' => 'financial_year_estimates.name', 'total_inspection' => $inspections->func()->count('inspected_schemes.id'), 'total_faulty' => $inspections->func()->sum('inspected_schemes.status1'), 'total_correction' => $inspections->func()->sum('inspected_schemes.status2')]);
        $inspections->where(['Inspections.financial_year_estimate_id' => $id]);
        $inspections->rightJoin('inspected_schemes', 'inspected_schemes.inspection_id=Inspections.id');
        $inspections->rightJoin('financial_year_estimates', 'financial_year_estimates.id=Inspections.financial_year_estimate_id');
        $inspections->rightJoin('inspected_teams', 'inspected_teams.id=Inspections.inspected_team_id');
        $inspections->group(['Inspections.inspected_team_id']);
        $inspections->toArray();
        $this->set('inspections', $inspections->toArray());
        $this->layout = 'ajax';

    }
}
