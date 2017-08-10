<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Filesystem\File;
use Cake\Network\Http\Client;
use Cake\ORM\TableRegistry;
use Cake\Routing\Route\Route;
use Cake\Routing\Router;

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
            $this->loadModel('ContractorQrImages');
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
            $previous_data = $this->ContractorQrImages->find('all')->where(['contractor_id' => $data['contractor_id']])->first();
            if(empty(trim($previous_data))){
                //qr code test
                $query = [
                    'size'=>'170x170',
                    'data'=>Router::url('/', true).'contractorqr/index/' . $data['contractor_id']
                ];
                $query = http_build_query($query);
                $qrData = file_get_contents("https://api.qrserver.com/v1/create-qr-code/?$query");
                $file = new File(WWW_ROOT.'img/qr_contractor/qr_'.$data['contractor_id'].'.jpg', true);
                $file->write($qrData);
                //end qr code
                $qrimagedata = $this->ContractorQrImages->newEntity();
                $inputs['contractor_id'] = $data['contractor_id'];
                $inputs['qr_image'] = 'qr_'.$data['contractor_id'].'.jpg';
                $qrimagedata = $this->ContractorQrImages->patchEntity($qrimagedata, $inputs);
                $this->ContractorQrImages->save($qrimagedata);
            }
            $qr_image = $this->ContractorQrImages->find()->select(['qr_image','contractor_id'])->where(['contractor_id' => $data['contractor_id']])->first();

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
            $this->set(compact('processRaBills', 'finalYears','qr_image'));
        }
        $this->loadModel('Contractors');
        $this->loadModel('FinancialYearEstimates');
        $contractors = $this->Contractors->find('list')->hydrate(false)->toArray();
        $finalcialYears = $this->FinancialYearEstimates->find('list')->where(['status !='=> 99])->toArray();
        $this->set(compact('finalcialYears','contractors'));
    }

    /*
     * upload
     */
    public function upload(){
        $this->loadModel('ContractorDocuments');
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->data;
            $previous = $this->ContractorDocuments->find('all')->select(['id'])->where(['contractor_id' => $data['contractor_id']])->first();
            if($previous['id']){
                $document = $this->ContractorDocuments->get($previous['id']);
            }else{
                $document = $this->ContractorDocuments->newEntity();
            }
            $document = $this->ContractorDocuments->patchEntity($document, $data);
            if ($this->ContractorDocuments->save($document)) {
                $this->Flash->success(__('The document has been uploaded.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The document could not be uploaded. Please, try again.'));
            }
        }
    }
}
