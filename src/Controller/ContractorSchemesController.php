<?php
namespace App\Controller;

use App\Controller\AppController;


class ContractorSchemesController extends AppController
{

    public function index()
    {
        $this->loadModel('Contractors');
        $contractors = $this->Contractors->find('all', ['fields' => ['id', 'contractor_title']])->toArray();

        $this->set(compact('contractors'));
    }

    public function get_schemes_by_contractor_id()
    {
        $contractor_id=$this->request->data['contractor_id'];

        $this->loadModel('SchemeContractors');

        $schemes=$this->SchemeContractors->find()
            ->autoFields(true)
            ->select(['contractors.contractor_title','packages.name_bn','schemes.name_bn','schemes.contract_amount','schemes.contract_date','schemes.completion_date','schemes.road_length','schemes.structure_length','schemes.building_quantity','schemes.building_quantity','schemes.payment_road','schemes.payment_structure','scheme_progresses.progress_value'])
            ->where(['SchemeContractors.contractor_id'=>$contractor_id,'SchemeContractors.status'=>1])
            ->leftJoin('contractors','contractors.id=SchemeContractors.contractor_id')
            ->leftJoin('schemes','schemes.id=SchemeContractors.scheme_id')
            ->leftJoin('packages','packages.id=schemes.package_id')
            ->leftJoin('scheme_progresses','scheme_progresses.scheme_id=schemes.id and scheme_progresses.status=1')
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
