<?php


namespace App\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class MonthlyReportsController extends AppController
{


    public function index()
    {
        $this->loadModel('Schemes');
        if($this->request->is('post')){
            $inputs = $this->request->data;
            $schemes = $this->Schemes->find()
                ->hydrate(FALSE);

            //IRIDP-2  GDP 2
            if($inputs['project_id'] == 20 || $inputs['project_id'] == 3){
                $scheme_select_fields = [
                    'upazila_name' => 'upazilas.name_bn',
                    'package_name' => 'packages.name_bn',
                    'scheme_name' => 'Schemes.name_bn',
                    'road_length' => 'Schemes.road_length',
                    'structure_length' => 'Schemes.structure_length',
                    'cost_road' => 'Schemes.estimated_road',
                    'cost_structure' => 'Schemes.estimated_structure',
                    'cost_total' => 'Schemes.estimated_cost',
                    'tender_date' => 'Schemes.tender_date',
                    'contractor_title' => 'contractors.contractor_title',
                    'contract_date' => 'Schemes.contract_date',
                    'contract_amount' => 'Schemes.contract_amount',
                    'physical_progress' => '(SELECT `progress_value` FROM `scheme_progresses`  WHERE `scheme_id` = `Schemes`.`id` ORDER BY `id` DESC LIMIT 1)',
                    'actual_complete_date' => 'Schemes.actual_complete_date',
                    'payment_road' => 'Schemes.payment_road',
                ];
            }
           //Landless mukti
            elseif($inputs['project_id'] == 8){
                $scheme_select_fields = [
                    'upazila_name' => 'upazilas.name_bn',
                    'package_name' => 'packages.name_bn',
                    'scheme_name' => 'Schemes.name_bn',
                    'contractor_title' => 'contractors.contractor_title',
                    'estimated_cost' => 'Schemes.estimated_cost',
                    'contract_amount' => 'Schemes.contract_amount',
                    'contract_date' => 'Schemes.contract_date',
                    'completion_date' => 'Schemes.completion_date',
                    'actual_complete_date' => 'Schemes.actual_complete_date',
                    'physical_progress' => '(SELECT `progress_value` FROM `scheme_progresses`  WHERE `scheme_id` = `Schemes`.`id` ORDER BY `id` DESC LIMIT 1)',
                    'payment_road' => 'Schemes.payment_road',
                ];
            }

            //Ups
            elseif($inputs['project_id'] == 17){
                $scheme_select_fields = [
                    'upazila_name' => 'upazilas.name_bn',
                    'package_name' => 'packages.name_bn',
                    'scheme_name' => 'Schemes.name_bn',
                    'contractor_title' => 'contractors.contractor_title',
                    'estimated_cost' => 'Schemes.estimated_cost',
                    'contract_amount' => 'Schemes.contract_amount',
                    'contract_date' => 'Schemes.contract_date',
                    'completion_date' => 'Schemes.completion_date',
                    'actual_complete_date' => 'Schemes.actual_complete_date',
                    'physical_progress' => '(SELECT `progress_value` FROM `scheme_progresses`  WHERE `scheme_id` = `Schemes`.`id` ORDER BY `id` DESC LIMIT 1)',
                    'payment_road' => 'Schemes.payment_road',
                ];
            }

            //Pti
            elseif($inputs['project_id'] == 18){
                $scheme_select_fields = [
                    'upazila_name' => 'upazilas.name_bn',
                    'package_name' => 'packages.name_bn',
                    'scheme_name' => 'Schemes.name_bn',
                    'contractor_title' => 'contractors.contractor_title',
                    'estimated_cost' => 'Schemes.estimated_cost',
                    'contract_amount' => 'Schemes.contract_amount',
                    'contract_date' => 'Schemes.contract_date',
                    'completion_date' => 'Schemes.completion_date',
                    'actual_complete_date' => 'Schemes.actual_complete_date',
                    'physical_progress' => '(SELECT `progress_value` FROM `scheme_progresses`  WHERE `scheme_id` = `Schemes`.`id` ORDER BY `id` DESC LIMIT 1)',
                    'payment_road' => 'Schemes.payment_road',
                ];
            }

            //PEDP-3
            elseif($inputs['project_id'] == 5){
                $scheme_select_fields = [
                    //'upazila_name' => 'upazilas.name_bn',
                    'package_name' => 'packages.name_bn',
                    'scheme_name' => 'Schemes.name_bn',
                    'estimated_cost' => 'Schemes.estimated_cost',
                    'tender_date' => 'Schemes.tender_date',
                    'noa_date' => 'Schemes.noa_date',
                    'contract_amount' => 'Schemes.contract_amount',
                    'contractor_title' => 'contractors.contractor_title',
                    'contract_date' => 'Schemes.contract_date',
                    'proposed_start_date' => 'Schemes.proposed_start_date',
                    'completion_date' => 'Schemes.completion_date',
                    'physical_progress' => '(SELECT `progress_value` FROM `scheme_progresses`  WHERE `scheme_id` = `Schemes`.`id` ORDER BY `id` DESC LIMIT 1)',
                    'payment_road' => 'Schemes.payment_road',

                ];
            }

            //NATA

            //PEDP-3
            elseif($inputs['project_id'] == 22){
                $scheme_select_fields = [
                    'upazila_name' => 'upazilas.name_bn',
                    'package_name' => 'packages.name_bn',
                    'scheme_name' => 'Schemes.name_bn',
                    'estimated_cost' => 'Schemes.estimated_cost',
                    'contractor_title' => 'contractors.contractor_title',
                    'contract_amount' => 'Schemes.contract_amount',
                    'contract_date' => 'Schemes.contract_date',
                    'completion_date' => 'Schemes.completion_date',
                    'physical_progress' => '(SELECT `progress_value` FROM `scheme_progresses`  WHERE `scheme_id` = `Schemes`.`id` ORDER BY `id` DESC LIMIT 1)',
                    'payment_road' => 'Schemes.payment_road',

                ];
            }
            else{
                $scheme_select_fields = [];
            }


            $schemes->select($scheme_select_fields);
            $schemes->where(['Schemes.project_id' => $inputs['project_id'], 'Schemes.status' => 1]);
            $schemes->leftJoin('packages', 'packages.id=Schemes.package_id');
            $schemes->leftJoin('districts', 'districts.id=Schemes.district_id');
            $schemes->leftJoin('upazilas', 'upazilas.id=Schemes.upazila_id');
            $schemes->leftJoin('scheme_contractors', 'scheme_contractors.scheme_id=Schemes.id and is_lead=1');
            $schemes->leftJoin('contractors', 'contractors.id=scheme_contractors.contractor_id');
            $schemes->leftJoin('scheme_progresses', 'scheme_progresses.scheme_id=Schemes.id');
            $schemes->leftJoin('financial_year_estimates', 'financial_year_estimates.id=Schemes.financial_year_estimate_id');
            $schemes->group(['Schemes.id']);
            $schemes->order(['Schemes.upazila_id']);
            $this->loadModel('Projects');
            $project = $this->Projects->get($inputs['project_id']);
            $this->set(compact('schemes', 'project'));
        }
        $this->loadModel('Projects');
        $projects = $this->Projects->find('list');
        $this->set(compact('projects'));
    }

}