<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Table\FinancialYearEstimatesTable;
use Cake\Core\Configure;

class DevelopmentSummaryController extends AppController
{
    public function index()
    {
        $this->loadModel('FinancialYearEstimates');
        $financialYearEstimates = $this->FinancialYearEstimates->find('list', ['limit' => 200]);
        $this->set(compact('financialYearEstimates'));
    }

    public function project_list()
    {
        $this->layout = 'ajax';
        $user = $this->Auth->user();
        $financial_year = $this->request->data['financial_year_id'];
        $start_date = strtotime('01-07-' . substr($financial_year, 0, 4));
        $end_date = strtotime('30-06-' . substr($financial_year, 5, 7));
        $this->loadModel('Projects');
        $projects = $this->Projects->find()
            ->hydrate(false)
            ->select(['Projects.id', 'Projects.name_bn'])
            ->where(['Projects.completion_date >=' => $start_date, 'Projects.start_date <=' => $start_date, 'Projects.status' => 1])
            ->toArray();

        foreach ($projects as & $project) {
            $this->loadModel('Schemes');

            //New Scheme

            $new_schemes = $this->Schemes->find()->hydrate(false);
            $new_schemes->select(['id', 'road_length','structure_length', 'scheme_type_id', 'contract_amount']);
            $new_schemes->where(['Schemes.project_id' => $project['id'], 'Schemes.proposed_start_date >=' => $start_date, 'Schemes.proposed_start_date <=' => $end_date]);
            $new_schemes = $new_schemes->toArray();
            if (!empty($new_schemes[0]['id'])) {
                $contract_amount = $road_length = $bridge_length = 0;
                foreach ($new_schemes as $scheme) {
                    if ($scheme['road_length']) {
                        $road_length += $scheme['road_length'];
                    } elseif ($scheme['structure_length']) {
                        $bridge_length += $scheme['structure_length'];
                    }

                    $contract_amount += $scheme['contract_amount'];
                }
                $project['new_scheme'] = count($new_schemes);
                $project['contract_amount'] = $contract_amount;
                $project['road_length'] = $road_length;
                $project['bridge_length'] = $bridge_length;

            }

            //Carried Scheme

            $carried_schemes = $this->Schemes->find()->hydrate(false);
            $carried_schemes->select(['id','road_length','structure_length', 'scheme_type_id', 'contract_amount']);
            $carried_schemes->where(['Schemes.project_id' => $project['id'], 'Schemes.proposed_start_date <' => $start_date, 'Schemes.completion_date >=' => $start_date]);
            $carried_schemes = $carried_schemes->toArray();

            if (!empty($carried_schemes[0]['id'])) {

                $contract_amount = $road_length = $bridge_length = 0;
                foreach ($carried_schemes as $scheme) {
                    if ($scheme['road_length']) {
                        $road_length += $scheme['road_length'];
                    } elseif ($scheme['structure_length']) {
                        $bridge_length += $scheme['structure_length'];
                    }

                    $contract_amount += $scheme['contract_amount'];
                }
                $project['carried_scheme'] = count($carried_schemes);
                $project['carried_contract_amount'] = $contract_amount;
                $project['carried_road_length'] = $road_length;
                $project['carried_bridge_length'] = $bridge_length;

            }

            //Scheme Types

            $scheme_types = $this->Schemes->find()->hydrate(false)
                ->select(['type' => 'scheme_types.title'])->distinct(['scheme_types.title'])
                ->where(['Schemes.project_id' => $project['id'], 'Schemes.completion_date >=' => $start_date, 'Schemes.proposed_start_date <' => $start_date])
                ->orWhere(['Schemes.project_id' => $project['id'], 'Schemes.proposed_start_date >=' => $start_date, 'Schemes.proposed_start_date <=' => $end_date])
                ->leftJoin('scheme_types', 'scheme_types.id=Schemes.scheme_type_id')
                ->toArray();
            $scheme_type = "";
            foreach ($scheme_types as $type) {
                $scheme_type .= $type['type'] . "/";
            }
            $project['scheme_type'] = preg_replace('{/$}', '', $scheme_type);

            // Total Completed Scheme

            $total_scheme = $this->Schemes->find()->hydrate(false);
            $total_scheme->select(['total' => $total_scheme->func()->count('id')]);
            $total_scheme->where(['Schemes.project_id' => $project['id'], 'Schemes.completion_date >=' => $start_date, 'Schemes.completion_date <=' => $end_date, 'Schemes.status' => 4]);
            $total_scheme = $total_scheme->toArray();

            $project['total_complete_scheme'] = $total_scheme[0]['total'];

            //Scheme progress

            $scheme_progress = $this->Schemes->find()->hydrate(false);
            $scheme_progress->select(['total_progress' => $scheme_progress->func()->avg('scheme_progresses.progress_value')]);
            $scheme_progress->where(['Schemes.project_id' => $project['id'], 'Schemes.completion_date >=' => $start_date, 'Schemes.proposed_start_date <' => $start_date]);
            $scheme_progress->orWhere(['Schemes.project_id' => $project['id'], 'Schemes.proposed_start_date >=' => $start_date, 'Schemes.proposed_start_date <=' => $end_date]);
            $scheme_progress->leftJoin('scheme_progresses','scheme_progresses.scheme_id=Schemes.id and scheme_progresses.status=1');
            $scheme_progress->group('Schemes.project_id');
            $scheme_progress = $scheme_progress->toArray();

            $project['avg_scheme_progress']=$scheme_progress[0]['total_progress'];

            //Paid Bills

            $new_schemes = $this->Schemes->find()->hydrate(false);
            $new_schemes->select(['total'=>$new_schemes->func()->sum('allotment_registers.allotment_amount')]);
            $new_schemes->where(['Schemes.project_id' => $project['id'], 'Schemes.completion_date >=' => $start_date, 'Schemes.proposed_start_date <' => $start_date]); //carried over
            $new_schemes->orWhere(['Schemes.project_id' => $project['id'], 'Schemes.proposed_start_date >=' => $start_date, 'Schemes.proposed_start_date <=' => $end_date]); // new scheme
            $new_schemes->leftJoin('allotment_registers','allotment_registers.scheme_id=Schemes.id and allotment_registers.dr_cr="Credit" and allotment_registers.created_date <='.$end_date);
            $new_schemes->group(['Schemes.project_id']);
            $new_schemes = $new_schemes->toArray();

            $project['total_paid_amount']=$new_schemes[0]['total'];
            $project['financial_year']=$financial_year;
            $project['expire_month']='জুন/' . substr($financial_year, 5, 7).'পর্যন্ত ।';

        }
        //die;
        /*echo "<pre>";
        print_r($projects);
        echo "</pre>";
        die;*/


        $this->set(compact('projects'));
    }
}

