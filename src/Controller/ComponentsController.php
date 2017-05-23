<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Components Controller
 *
 * @property \App\Model\Table\ComponentsTable $Components
 */
class ComponentsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $components = $this->Components->find('all', [
            'conditions' =>['Components.status !=' => 99],
            'contain' => ['CreatedUser', 'UpdatedUser']
        ]);
        $this->set('components', $components);
        $this->set('_serialize', ['components']);
    }

    /**
     * View method
     *
     * @param string|null $id Component id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $component = $this->Components->get($id, [
            'contain' => ['CreatedUser', 'UpdatedUser']
        ]);
        $this->set('component', $component);
        $this->set('_serialize', ['component']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $component = $this->Components->newEntity();
        if ($this->request->is('post'))
        {
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            $component = $this->Components->patchEntity($component, $data);
            if ($this->Components->save($component))
            {
                $this->Flash->success(__('The component has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The component could not be saved. Please, try again.'));
            }
        }
        $createdUser = $this->Components->CreatedUser->find('list', ['limit' => 200]);
        $updatedUser = $this->Components->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('component', 'createdUser', 'updatedUser'));
        $this->set('_serialize', ['component']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Component id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $component = $this->Components->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $data=$this->request->data;
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['updated_by']=$user['id'];
            $data['updated_date']=time();
            $component = $this->Components->patchEntity($component, $data);
            if ($this->Components->save($component))
            {
                $this->Flash->success(__('The component has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The component could not be saved. Please, try again.'));
            }
        }
        $createdUser = $this->Components->CreatedUser->find('list', ['limit' => 200]);
        $updatedUser = $this->Components->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('component', 'createdUser', 'updatedUser'));
        $this->set('_serialize', ['component']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Component id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $component = $this->Components->get($id);

        $user=$this->Auth->user();
        $data=$this->request->data;
        $data['updated_by']=$user['id'];
        $data['updated_date']=time();
        $data['status']=99;
        $component = $this->Components->patchEntity($component, $data);
        if ($this->Components->save($component))
        {
            $this->Flash->success(__('The component has been deleted.'));
        }
        else
        {
            $this->Flash->error(__('The component could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function get_grid_data()
    {
        $user = $this->Auth->user();
        $this->loadModel('Schemes');
        $schemes = $this->Schemes->find('all')//->autoFields(true)
        ->select(['financial_year' => 'financial_year_estimates.name', 'scheme_name' => 'Schemes.name_en', 'projects_name' => 'projects.short_code', 'districts_name' => 'districts.name_en', 'upazilas_name' => 'upazilas.name_en', 'contractor_name' => 'contractors.contractor_title', 'contract_amount' => 'Schemes.contract_amount', 'contract_date' => 'Schemes.contract_date', /*'scheme_progresses' => 'scheme_progresses.progress_value',*/
            'expected_complete_date' => 'Schemes.expected_complete_date', 'scheme_id' => 'Schemes.id', 'scheme_progresses' => '(SELECT `progress_value` FROM `scheme_progresses`  WHERE `scheme_id` = `Schemes`.`id` ORDER BY `id` DESC LIMIT 1)'])
            ->distinct(['Schemes.id'])
            ->innerJoin('project_offices', 'project_offices.project_id = Schemes.project_id')
            ->leftJoin('projects', 'projects.id = Schemes.project_id')
            ->leftJoin('districts', 'districts.id = Schemes.district_id')
            ->leftJoin('upazilas', 'upazilas.id = Schemes.upazila_id')
            ->leftJoin('scheme_progresses', 'scheme_progresses.scheme_id = Schemes.id')
            ->leftJoin('upazilas', 'upazilas.id = Schemes.upazila_id')
            ->leftJoin('scheme_contractors', 'scheme_contractors.scheme_id = Schemes.id')
            ->leftJoin('contractors', 'contractors.id = scheme_contractors.contractor_id')
            ->leftJoin('financial_year_estimates', 'financial_year_estimates.id = Schemes.financial_year_estimate_id')
            ->where(['Schemes.status' => 1, 'project_offices.office_id' => $user['office_id']])
            ->order(['Schemes.id' => 'desc'])
            ->toArray();
        $sl = 1;
//        pr($this->request->params['pass'][0]);die;
        foreach ($schemes as &$scheme) {
            $scheme['sl'] = $sl;
            $scheme['contract_date'] = date('d/m/Y', $scheme['contract_date']);
            $scheme['expected_complete_date'] = date('d/m/Y', $scheme['expected_complete_date']);
            //$scheme['action'] = '<button title="' . __('Edit') . ' " data-scheme_id="' . $scheme['scheme_id'] . '" class="icon-newspaper text-danger edit" > </button>';
            $scheme['action'] =
                    '<a class="" title="Scheme Nothi" href="' . $this->request->webroot . 'VehiclesStatus/add/'.$this->request->params['pass'][0].'/'. $scheme['scheme_id'] . '" ><i class="icon-redo"></i><a>';
            $sl++;
        }
//        pr($schemes);die;
        $this->response->body(json_encode($schemes));
        return $this->response;
    }
}
