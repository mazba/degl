<?php
namespace App\Controller;

use App\Controller\AppController;


class ContractorSchemesController extends AppController
{

    public function index()
    {
        $this->loadModel('Contractors');
        $this->loadModel('FinancialYearEstimates');
        $this->loadModel('Upazilas');
        if ($this->request->is(['post'])) {
            $inputs = $this->request->data;
            $this->loadModel('Schemes');
            $this->loadModel('SchemeContractors');
            $schemes=$this->SchemeContractors->find()
                ->autoFields(true)
                ->select([
                    'contractors.contractor_title',
                    'packages.name_bn',
                    'schemes.name_bn',
                    'schemes.contract_amount',
                    'schemes.contract_date',
                    'schemes.completion_date',
                    'schemes.road_length',
                    'schemes.structure_length',
                    'schemes.building_quantity',
                    'schemes.financial_year_estimate_id',
                    'schemes.upazila_id',
                    'schemes.payment_road',
                    'schemes.payment_structure',
                    'scheme_progresses.progress_value'
                ])
                ->where(['SchemeContractors.status'=>1])
                ->innerJoin('contractors','contractors.id=SchemeContractors.contractor_id')
                ->leftJoin('schemes','schemes.id=SchemeContractors.scheme_id')
                ->innerJoin('packages','packages.id=schemes.package_id')
                ->innerJoin('scheme_progresses','scheme_progresses.scheme_id=schemes.id and scheme_progresses.status=1')
                ->order(['schemes.contract_date'=>'desc']);
            if (!empty($inputs['contractor_id'])) {
                $schemes->where(['SchemeContractors.contractor_id'=>$inputs['contractor_id']]);
            }
            if (!empty($inputs['financial_year_estimate_id'])) {
                $schemes->where(['schemes.financial_year_estimate_id' => $inputs['financial_year_estimate_id']]);
            }
            if (!empty($inputs['upazila_id'])) {
                $schemes->where(['schemes.upazila_id' => $inputs['upazila_id']]);
            }
            $schemes = $schemes->toArray();
            $this->set(compact('schemes'));
        }
        $contractors = $this->Contractors->find('list', ['fields' => ['id', 'contractor_title']])->toArray();
        $financialYearEstimates = $this->FinancialYearEstimates->find('list');
        $upazilas = $this->Upazilas->find('list', ['conditions' => ['district_id' => 33]]);
        $this->set(compact('contractors','financialYearEstimates','upazilas'));
    }

    public function get_schemes_by_contractor_id()
    {
        $contractor_id=$this->request->data['contractor_id'];

        $this->loadModel('SchemeContractors');
        $schemes=$this->SchemeContractors->find()
            ->autoFields(true)
            ->select(['contractors.contractor_title','packages.name_bn','schemes.name_bn','schemes.contract_amount','schemes.contract_date','schemes.completion_date','schemes.road_length','schemes.structure_length','schemes.building_quantity','schemes.building_quantity','schemes.payment_road','schemes.payment_structure','scheme_progresses.progress_value'])
            ->where(['SchemeContractors.contractor_id'=>$contractor_id,'SchemeContractors.status'=>1])
            ->innerJoin('contractors','contractors.id=SchemeContractors.contractor_id')
            ->innerJoin('schemes','schemes.id=SchemeContractors.scheme_id')
            ->innerJoin('packages','packages.id=schemes.package_id')
            ->innerJoin('scheme_progresses','scheme_progresses.scheme_id=schemes.id and scheme_progresses.status=1')
            ->order(['schemes.contract_date'=>'desc'])
            ->toArray()
        ;
        /* echo "<pre>";
         print_r($schemes);
         echo "</pre>";
         die;*/
        $this->set(compact('schemes'));
        $this->layout='ajax';

    }


}
