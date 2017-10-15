<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * SchemeOverview Controller
 *
 * @property \App\Model\Table\SchemeOverviewTable $SchemeOverview
 */
class SchemeOverviewController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
//        pr('success');die;
        $this->loadModel('Contractors');
        $this->loadModel('Projects');
        $this->loadModel('FinancialYearEstimates');
        $this->loadModel('Upazilas');
        $this->loadModel('Upazilas');
        $this->loadModel('Schemes');
        if($this->request->is('post')){
            $user= $this->Auth->user();
            $inputs = $this->request->data;
            $conditions = [
                'Schemes.status' => 1,
                'project_offices.office_id' => $user['office_id']
            ];
            if(isset($inputs['project_id']) && !empty($inputs['project_id'])){
                $conditions['Schemes.project_id'] = $inputs['project_id'];
            }
            if(isset($inputs['scheme_id']) && !empty($inputs['scheme_id'])){
                $conditions['Schemes.id'] = $inputs['scheme_id'];
            }
            if(isset($inputs['financial_year_estimate_id']) && !empty($inputs['financial_year_estimate_id'])){
                $conditions['Schemes.financial_year_estimate_id'] = $inputs['financial_year_estimate_id'];
            }
            if(isset($inputs['upazila_id']) && !empty($inputs['upazila_id'])){
                $conditions['Schemes.upazila_id'] = $inputs['upazila_id'];
            }
            if(isset($inputs['contractor_id']) && !empty($inputs['contractor_id'])){
                $conditions['contractors.id'] = $inputs['contractor_id'];
            }
            $schemeOverviews = $this->Schemes->find('all')
            ->select([
                'financial_year' => 'financial_year_estimates.name',
                'scheme_name' => 'Schemes.name_en',
                'package_name' => 'packages.name_en',
                'projects_name' => 'projects.short_code',
                'districts_name' => 'districts.name_en',
                'upazilas_name' => 'upazilas.name_en',
                'scheme_code' => 'Schemes.scheme_code',
                'contractor_name' => 'contractors.contractor_title',
                'contract_amount' => 'Schemes.contract_amount',
                'contract_date' => 'Schemes.proposed_start_date', /*'scheme_progresses' => 'scheme_progresses.progress_value',*/
                'palasiding_length' => 'Schemes.palasiding_length',
                'expected_complete_date' => 'Schemes.expected_complete_date',
                'scheme_id' => 'Schemes.id',
                'scheme_progresses' => '(SELECT `progress_value` FROM `scheme_progresses`  WHERE `scheme_id` = `Schemes`.`id` ORDER BY `id` DESC LIMIT 1)'
            ])
                ->distinct(['Schemes.id'])
                ->innerJoin('project_offices', 'project_offices.project_id = Schemes.project_id')
                ->leftJoin('projects', 'projects.id = Schemes.project_id')
                ->leftJoin('districts', 'districts.id = Schemes.district_id')
                ->leftJoin('upazilas', 'upazilas.id = Schemes.upazila_id')
                ->leftJoin('scheme_progresses', 'scheme_progresses.scheme_id = Schemes.id')
                ->leftJoin('upazilas', 'upazilas.id = Schemes.upazila_id')
                ->leftJoin('packages', 'packages.id = Schemes.package_id')
                ->leftJoin('scheme_contractors', 'scheme_contractors.scheme_id = Schemes.id')
                ->leftJoin('contractors', 'contractors.id = scheme_contractors.contractor_id')
                ->leftJoin('financial_year_estimates', 'financial_year_estimates.id = Schemes.financial_year_estimate_id')
                ->where($conditions)
                ->order(['Schemes.id' => 'desc'])
                ->toArray();
            $this->set(compact('schemeOverviews'));
        }
        $projects = $this->Projects->find('list', ['conditions' => ['status !=' => 99]]);
        $fiscal = $this->FinancialYearEstimates->find('list', ['conditions' => ['status !=' => 99]]);
        $upazilas = $this->Upazilas->find('list', ['conditions' => ['district_id' => 33]]);
        $contractors = $this->Contractors->find('list', ['fields' => ['id', 'contractor_title'], 'conditions' => ['status' => 1]])->toArray();
        $schemes = $this->Schemes->find('list', ['conditions' => ['status' => 1]])->toArray();
        $this->set(compact('projects', 'fiscal', 'upazilas','contractors','schemes'));
    }


}
