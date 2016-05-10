<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

/**
 * IssueCompletionCertificate Controller
 *
 * @property \App\Model\Table\IssueCompletionCertificateTable $IssueCompletionCertificate
 */
class AtaGlanceLgedController extends AppController
{
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {

        $user = $this->Auth->user();

        $this->loadModel('SchemeProgresses');
        $this->loadModel('Schemes');
        $this->loadModel('FinancialYearEstimates');
        $current_month = date('m');
        if($current_month>6)
        {
            $current_financial_year = date('Y').'-'.date('Y', strtotime('+1 year'));
            $pre_financial_year = date('Y', strtotime('-1 year')).'-'.date('Y');
        }
        else
        {
            $current_financial_year = date('Y', strtotime('-1 year')).'-'.date('Y');
            $pre_financial_year = date('Y', strtotime('-2 year')).'-'.date('Y', strtotime('-1 year'));
        }

        $current_financial_year = $this->FinancialYearEstimates->find()
            ->select(['id','name'])
            ->where(['name'=>$current_financial_year])
            ->first();
        $pre_financial_year = $this->FinancialYearEstimates->find()
            ->select(['id','name'])
            ->where(['name'=>$pre_financial_year])
            ->first();
        if($current_financial_year && $pre_financial_year)
        {
            //get all schemes
            $current_schemes = $this->SchemeProgresses->find('all',[
                'contain'=>['Schemes'],
                'conditions'=>['Schemes.financial_year_estimate_id'=>$current_financial_year['id'],
                    'SchemeProgresses.status'=>1,
                    'SchemeProgresses.office_id'=>$user['office_id']
                ]
            ]);
            $pre_schemes = $this->SchemeProgresses->find('all',[
                'contain'=>['Schemes'],
                'conditions'=>['Schemes.financial_year_estimate_id'=>$pre_financial_year['id'],
                    'SchemeProgresses.status'=>1,
                    'SchemeProgresses.office_id'=>$user['office_id']
                ]
            ]);

            $scheme_type_road = Configure::read('scheme_type.road');
            $scheme_type_bridge = Configure::read('scheme_type.bridge_id');
            $sub_s_type_concrete_road = Configure::read('sub_scheme_type.concrete_road_id');
            $work_type_maintenance = Configure::read('work_type.maintenance_id');
            $current_bridge = $this->Schemes
                ->find()
                ->where(['Schemes.financial_year_estimate_id'=>$current_financial_year['id']])
                ->where(['Schemes.scheme_type_id'=>$scheme_type_bridge])
                ->count();
            // current financial year
            $current_financial_year_data = [
                'concrete_road' => 0,
                'concrete_road_contract_amount' => 0,
                'maintenance_road' => 0,
                'maintenance_road_contract_amount' => 0,
                'bridge' => $current_bridge,
            ];
            foreach($current_schemes as $current_scheme)
            {
                // concrete road
                if($current_scheme['scheme']['sub_scheme_type_id'] == $sub_s_type_concrete_road)
                {
                    $current_financial_year_data['concrete_road'] += $current_scheme['scheme']['length']*$current_scheme['progress_value']/100;
                    $current_financial_year_data['concrete_road_contract_amount'] += $current_scheme['scheme']['contract_amount'];
                }
                //maintenance
                if($current_scheme['scheme']['work_type_id'] == $work_type_maintenance && $current_scheme['scheme']['scheme_type_id'] == $scheme_type_road)
                {
                    $current_financial_year_data['maintenance_road'] += $current_scheme['scheme']['length']*$current_scheme['progress_value']/100;;
                    $current_financial_year_data['maintenance_road_contract_amount'] += $current_scheme['scheme']['contract_amount'];
                }
//                //bridge
//                if($current_scheme['scheme']['scheme_type_id'] == $scheme_type_bridge)
//                {
//                    ++;
//                }
            }
            $pre_bridge = $this->Schemes
                ->find()
                ->where(['Schemes.financial_year_estimate_id'=>$pre_financial_year['id']])
                ->where(['Schemes.scheme_type_id'=>$scheme_type_bridge])
                ->count();
            // previous financial year
            $pre_financial_year_data = [
                'concrete_road' => 0,
                'concrete_road_contract_amount' => 0,
                'maintenance_road' => 0,
                'maintenance_road_contract_amount' => 0,
                'bridge' => $pre_bridge,
            ];

            foreach($pre_schemes as $pre_scheme)
            {
                // concrete road
                if($pre_scheme['scheme']['sub_scheme_type_id'] == $sub_s_type_concrete_road)
                {
                    $pre_financial_year_data['concrete_road'] += $pre_scheme['scheme']['length']*$pre_scheme['progress_value']/100;
                    $pre_financial_year_data['concrete_road_contract_amount'] += $pre_scheme['scheme']['contract_amount'];
                }

                //maintenance
                if($pre_scheme['scheme']['work_type_id'] == $work_type_maintenance && $pre_scheme['scheme']['scheme_type_id'] == $scheme_type_road)
                {
                    $pre_financial_year_data['maintenance_road'] += $pre_scheme['scheme']['length']*$pre_scheme['progress_value']/100;
                    $pre_financial_year_data['maintenance_road_contract_amount'] += $pre_scheme['scheme']['contract_amount'];
                }
                //bridge
//                if($pre_scheme['scheme']['scheme_type_id'] == $scheme_type_bridge)
//                {
//                    $pre_financial_year_data['bridge']++;
//                }
            }
            // get projects
            $projects = TableRegistry::get('project_offices')
                ->find('all')
                ->select(['projects.short_code'])
                ->select(['projects.id'])
                ->group(['project_offices.project_id'])
                ->where(['project_offices.office_id'=>$user['office_id']])
                ->where(['projects.status'=>1])
                ->leftJoin('projects','projects.id = project_offices.project_id');
        $this->set(compact('projects','pre_financial_year','current_financial_year','pre_financial_year_data','current_financial_year_data'));
        }
    }
}
