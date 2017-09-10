<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ContinueProgressReport Controller
 *
 * @property \App\Model\Table\ContinueProgressReportTable $ContinueProgressReport
 */
class ContinueProgressReportController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {

        $this->loadModel('Schemes');
        $query = $this->Schemes->find();
        $fiscal_year = ['17', '18'];
        // find number of scheme
        $active_firsts = $query->select([
            'contract_amount' => 'Schemes.contract_amount',
            'cost' => 'processed_ra_bills.bill_amount',
            'financial_year_estimate_id' => 'Schemes.financial_year_estimate_id',
            'scheme_progress_status ' => 'Schemes.scheme_progress_status',
            'project_id' => 'Schemes.project_id',
            'project_name' => 'projects.name_en',
        ])
            ->leftJoin('projects', 'projects.id = Schemes.project_id')
            ->leftJoin('processed_ra_bills', 'processed_ra_bills.scheme_id = Schemes.id')
            ->where([
                'Schemes.financial_year_estimate_id IN' => $fiscal_year,
                'processed_ra_bills.financial_year_estimate_id IN' => $fiscal_year,
                'processed_ra_bills.status !=' => 99,
            ])
            ->hydrate(false)->toArray();
        $results=[];
        $projects=[];
        foreach($active_firsts as $active_first)
        {
            $projects[$active_first['project_id']]['project_id']=$active_first['project_id'];
            $projects[$active_first['project_id']]['project_name']=$active_first['project_name'];
            $results[$active_first['financial_year_estimate_id']]['project'][$active_first['project_id']]['project_id']=$active_first['project_id'];
            $results[$active_first['financial_year_estimate_id']]['project'][$active_first['project_id']]['project_name']=$active_first['project_name'];

            //   project contract value
            if(isset($results[$active_first['financial_year_estimate_id']]['project'][$active_first['project_id']]['project_value']))
            {
                $results[$active_first['financial_year_estimate_id']]['project'][$active_first['project_id']]['project_value']+=$active_first['cost'];
            }
            else
            {
                $results[$active_first['financial_year_estimate_id']]['project'][$active_first['project_id']]['project_value']=$active_first['cost'];
            }
            //   project cost
            if(isset($results[$active_first['financial_year_estimate_id']]['project'][$active_first['project_id']]['project_cost']))
            {
                $results[$active_first['financial_year_estimate_id']]['project'][$active_first['project_id']]['project_cost']+=$active_first['contract_amount'];
            }
            else
            {
                $results[$active_first['financial_year_estimate_id']]['project'][$active_first['project_id']]['project_cost']=$active_first['contract_amount'];
            }
            // total scheme
            if(isset($results[$active_first['financial_year_estimate_id']]['project'][$active_first['project_id']]['total_scheme']))
            {
                $results[$active_first['financial_year_estimate_id']]['project'][$active_first['project_id']]['total_scheme']+=1;
            }
            else
            {
                $results[$active_first['financial_year_estimate_id']]['project'][$active_first['project_id']]['total_scheme']=1;
            }

            // deactivated scheme
            if($active_first['scheme_progress_status']===0)
            {
                if(isset($results[$active_first['financial_year_estimate_id']]['project'][$active_first['project_id']]['de_active_scheme']))
                {
                    $results[$active_first['financial_year_estimate_id']]['project'][$active_first['project_id']]['de_active_scheme']+=1;
                }
                else
                {
                    $results[$active_first['financial_year_estimate_id']]['project'][$active_first['project_id']]['de_active_scheme']=1;
                }
            }
            // active scheme
            else
            {
                if(isset($results[$active_first['financial_year_estimate_id']]['project'][$active_first['project_id']]['active_scheme']))
                {
                    $results[$active_first['financial_year_estimate_id']]['project'][$active_first['project_id']]['active_scheme']+=1;
                }
                else
                {
                    $results[$active_first['financial_year_estimate_id']]['project'][$active_first['project_id']]['active_scheme']=1;
                }
            }
        }
        $this->set(compact('results','projects'));
    }
}
