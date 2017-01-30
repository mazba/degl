<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ProjectOffices Controller
 *
 * @property \App\Model\Table\ProjectOfficesTable $ProjectOffices
 */
class ProjectOfficesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {

        $this->loadModel('Projects');
        $projects = $this->Projects->find('all', [
            'conditions' =>['Projects.status !=' => 99]
        ]);
        $this->set('projects', $projects);

    }

    /**
     * View method
     *
     * @param string|null $id Project Office id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($project_id = null)
    {

        $this->loadModel('Projects');
        $project = $this->Projects->get($project_id, [
            'contain' => []
        ]);
        $assigned_offices = $this->ProjectOffices->find('all', [
            'contain' => ['Projects', 'Offices', 'FinancialYearEstimates'],
            'conditions' =>['ProjectOffices.project_id' => $project_id]
        ])->toArray();
        $this->set(compact('assigned_offices', 'project_id','project'));
        $this->set('_serialize', ['projectOffice']);
    }
    /**
     * Edit method
     *
     * @param string|null $id Project Office id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($project_id = null)
    {

        $projectOffice = $this->ProjectOffices->newEntity();
        $user=$this->Auth->user();

        if ($this->request->is('post'))
        {
            $data=$this->request->data;

            $exists = $this->ProjectOffices->exists(['project_id' => $project_id, 'office_id' => $data['office_id'],'financial_year_estimate_id'=>$data['financial_year_estimate_id']]);
            if($exists)
            {
                $this->Flash->error(__('The project & office allready saved for this financial year'));
            }
            else
            {
                $data['created_by']=$user['id'];
                $data['created_date']=time();
                $projectOffice = $this->ProjectOffices->patchEntity($projectOffice, $data);
                if ($this->ProjectOffices->save($projectOffice))
                {
                    $this->Flash->success(__('The project added to the office.'));
                    return $this->redirect(['action' => 'index']);
                }
                else
                {
                    $this->Flash->error(__('The project office could not be saved. Please, try again.'));
                }

            }


        }
        $assigned_offices=$this->ProjectOffices->find('all', [
            'contain' => ['Offices', 'FinancialYearEstimates'],
            'conditions' =>['ProjectOffices.project_id' => $project_id]

        ])->toArray();
        $this->loadModel('Projects');
        $project = $this->Projects->get($project_id, [
            'contain' => []
        ]);
        if($user['user_group_id'] == 1)
        {
            $offices = $this->ProjectOffices->Offices->find('list');
        }
        else
        {
           // $offices = $this->ProjectOffices->Offices->find('list', ['conditions' => ['id'=>$user['office_id']]]);
            $offices = $this->ProjectOffices->Offices->find('list');
        }
        $financialYearEstimates = $this->ProjectOffices->FinancialYearEstimates->find('list');
        $this->set(compact('projectOffice', 'project_id', 'offices', 'financialYearEstimates','assigned_offices','project'));
        $this->set('_serialize', ['projectOffice']);
    }

}