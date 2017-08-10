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
                'processed_ra_bills.status !=' => 99,
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

            pr($data['contractor_id']);die;
            $previous_data = $this->QrImages->find('all')->where(['scheme_id' => $scheme['id']])->first();
            if(empty(trim($previous_data))){
                //qr code test
                $query = [
                    'size'=>'170x170',
                    'data'=>Router::url('/', true).'evidence/index/' . $scheme['id']
                ];
                $query = http_build_query($query);
                $qrData = file_get_contents("https://api.qrserver.com/v1/create-qr-code/?$query");
                $file = new File(WWW_ROOT.'img/qr_code/qr_'.$scheme['id'].'.jpg', true);
                $file->write($qrData);
                //end qr code
                $qrimagedata = $this->QrImages->newEntity();
                $inputs['scheme_id'] = $scheme['id'];
                $inputs['qr_image'] = 'qr_'.$scheme['id'].'.jpg';
                $qrimagedata = $this->QrImages->patchEntity($qrimagedata, $inputs);
                $this->QrImages->save($qrimagedata);
            }
            // Facial year
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
