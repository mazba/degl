<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * SchemeTracking Controller
 *
 * @property \App\Model\Table\SchemeTrackingTable $SchemeTracking
 */
class SchemeTrackingController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->loadModel('Schemes');
        if($this->request->is('post')){

            $inputs = $this->request->data;
//            pr($inputs);die;
            $conditions = [
                'Schemes.status' => 1,
            ];
            $check = 0;
            // specific condition
            if($inputs['type'] == 1){
                $check = 1;
                $lastMonth =  date("m/d/Y", strtotime("last month"));
                $conditions['Schemes.proposed_start_date <='] = strtotime($lastMonth);
            }
            if($inputs['type'] == 2){
                $check = 2;
                $today =  date("m/d/Y", strtotime("today"));
                $conditions['scheme_payorders.expire_date <'] = strtotime($today);
            }

            if($inputs['type'] == 3){
                $check = 3;
                $today =  date("m/d/Y", strtotime("today"));
                $conditions['Schemes.expected_complete_date <='] = strtotime($today);
            }
            // global conditions
            if(!empty($inputs['project_id'])){
                $conditions['Schemes.project_id'] = $inputs['project_id'];
            }
            if(!empty($inputs['financial_year_estimate_id'])){
                $conditions['Schemes.financial_year_estimate_id'] = $inputs['financial_year_estimate_id'];
            }
            if(!empty($inputs['upazila_id'])){
                $conditions['Schemes.upazila_id'] = $inputs['upazila_id'];
            }
//            pr($conditions);die;
            // data select
            $proposedStartDates = $this->Schemes->find()->select([
                'financial_year' => 'financial_year_estimates.name',
                'scheme_name' => 'Schemes.name_en',
                'package_name' => 'packages.name_en',
                'projects_name' => 'projects.short_code',
                'districts_name' => 'districts.name_en',
                'upazilas_name' => 'upazilas.name_en',
                'scheme_code' => 'Schemes.scheme_code',
                'contractor_name' => 'contractors.contractor_title',
                'contract_amount' => 'Schemes.contract_amount',
                'contract_date' => 'Schemes.proposed_start_date',
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
                ->leftJoin('scheme_payorders', 'scheme_payorders.scheme_id = Schemes.id')
                ->leftJoin('contractors', 'contractors.id = scheme_contractors.contractor_id')
                ->leftJoin('financial_year_estimates', 'financial_year_estimates.id = Schemes.financial_year_estimate_id')
                ->where($conditions)
                ->order(['Schemes.id' => 'desc'])
                ->hydrate(false)
                ->toArray();
//            pr($proposedStartDates);die;
            $this->set(compact('proposedStartDates', 'check'));
        }
        $this->loadModel('Projects');
        $this->loadModel('FinancialYearEstimates');
        $this->loadModel('Upazilas');
        $projects = $this->Projects->find('list', ['conditions' => ['status !=' => 99]]);
        $fiscal = $this->FinancialYearEstimates->find('list', ['conditions' => ['status !=' => 99]]);
        $upazilas = $this->Upazilas->find('list', ['conditions' => ['district_id' => 33]]);
        $this->set(compact('projects', 'fiscal', 'upazilas'));
    }
}
