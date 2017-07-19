<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * ConstructorLetters Controller
 *
 * @property \App\Model\Table\ConstructorLettersTable $ConstructorLetters
 */
class ConstructorLettersController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        if($this->request->is(['post'])){
            $data = $this->request->data();
            $query = TableRegistry::get('processed_ra_bills')->find();
            $conditions = [
                'processed_ra_bills.contractor_id' => $data['contractor_id'],
            ];
            if(isset($data['financial_year_estimate_id']) && !empty($data['financial_year_estimate_id']))
            {
                $conditions['processed_ra_bills.financial_year_estimate_id'] = $data['financial_year_estimate_id'];

            }
            $processRaBills = $query->select([
                'contractor_title' => 'contractors.contractor_title',
                'contractor_person_name' => 'contractors.contact_person_name',
                'contractor_address' => 'contractors.contractor_address',
                'contractor_tin_no' => 'contractors.tin_no',
                'bill_amount' => 'processed_ra_bills.bill_amount',
                'vat' => 'processed_ra_bills.vat',
                'income_tex' => 'processed_ra_bills.income_tex',
                'fiscal_year' => 'financial_year_estimates.name',
            ])
                ->leftJoin('contractors', 'contractors.id = processed_ra_bills.contractor_id')
                ->leftJoin('financial_year_estimates', 'financial_year_estimates.id = processed_ra_bills.financial_year_estimate_id')
                ->where($conditions)
                ->order(['financial_year_estimates.id' => 'ASC'])
                ->hydrate(false)
                ->toArray();

            $rules = [
                'processed_ra_bills.contractor_id' => $data['contractor_id']
            ];
            if(isset($data['financial_year_estimate_id']) && !empty($data['financial_year_estimate_id']))
            {
                $rules['processed_ra_bills.financial_year_estimate_id'] = $data['financial_year_estimate_id'];
            }
            $finalYears = TableRegistry::get('processed_ra_bills')->find()->select([
                'fiscal_year' => 'financial_year_estimates.name',
            ])
                ->leftJoin('financial_year_estimates', 'financial_year_estimates.id = processed_ra_bills.financial_year_estimate_id')
                ->where($rules)
                ->group(['financial_year_estimates.name'])
                ->hydrate(false)
                ->toArray();
            $this->set(compact('processRaBills', 'finalYears'));
        }
        $this->loadModel('Contractors');
        $this->loadModel('FinancialYearEstimates');
        $contractors = $this->Contractors->find('list')->hydrate(false)->toArray();
        $finalcialYears = $this->FinancialYearEstimates->find('list')->where(['status !='=> 99])->toArray();
        $this->set(compact('finalcialYears','contractors'));
    }


}
