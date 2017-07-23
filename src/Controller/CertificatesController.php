<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Filesystem\File;
use Cake\Network\Http\Client;
use Cake\ORM\TableRegistry;
use Cake\Routing\Route\Route;
use Cake\Routing\Router;

/**
 * Certificates Controller
 *
 * @property \App\Model\Table\CertificatesTable $Certificates
 */
class CertificatesController extends AppController
{
    /**
     * Index method
     *
     * @return void
     */
    public function index() {

    }

    /**
     *
     *
     */
    public function index_ajax($action = NULL)
    {
        $this->loadModel('Schemes');
        $schemes = $this->Schemes->find('all')//->autoFields(true)
        ->select(['financial_year' => 'financial_year_estimates.name', 'scheme_name' => 'Schemes.name_en', 'projects_name' => 'projects.short_code', 'districts_name' => 'districts.name_en', 'upazilas_name' => 'upazilas.name_en', 'contractor_name' => 'contractors.contractor_title', 'contract_amount' => 'Schemes.contract_amount', 'contract_date' => 'Schemes.contract_date', /*'scheme_progresses' => 'scheme_progresses.progress_value',*/
            'expected_complete_date' => 'Schemes.expected_complete_date', 'scheme_id' => 'Schemes.id', 'scheme_progresses' => '(SELECT `progress_value` FROM `scheme_progresses`  WHERE `scheme_id` = `Schemes`.`id` ORDER BY `id` DESC LIMIT 1)'])
            ->distinct(['Schemes.id'])
            ->innerJoin('project_offices', 'project_offices.project_id = Schemes.project_id')
            ->leftJoin('projects', 'projects.id = Schemes.project_id')
            ->leftJoin('districts', 'districts.id = Schemes.district_id')
            ->leftJoin('upazilas', 'upazilas.id = Schemes.upazila_id')
            ->leftJoin('scheme_progresses', 'scheme_progresses.scheme_id = Schemes.id')
            ->leftJoin('upazilas', 'upazilas.id = Schemes.upazila_id')
            ->leftJoin('scheme_contractors', 'scheme_contractors.scheme_id = Schemes.id')
            ->leftJoin('contractors', 'contractors.id = scheme_contractors.contractor_id')
            ->leftJoin('financial_year_estimates', 'financial_year_estimates.id = Schemes.financial_year_estimate_id')
            ->where(['Schemes.status' => 1])
            ->order(['Schemes.id' => 'desc'])
            ->toArray();
        $sl = 1;
        foreach ($schemes as &$scheme) {
            $scheme['sl'] = $sl;
            $scheme['contract_date'] = date('d/m/Y', $scheme['contract_date']);
            $scheme['expected_complete_date'] = date('d/m/Y', $scheme['expected_complete_date']);
            //$scheme['action'] = '<button title="' . __('Edit') . ' " data-scheme_id="' . $scheme['scheme_id'] . '" class="icon-newspaper text-danger edit" > </button>';
            $scheme['action'] =
                '<button title="' . __('কার্য সম্পাদন সনদ') . ' " data-scheme_id="' . $scheme['scheme_id'] . '" class="icon-newspaper text-danger letter" > </button>'.' '.
                '<button title="' . __('প্রত্যয়ন পত্র') . ' " data-scheme_id="' . $scheme['scheme_id'] . '" class="icon-user-plus text-danger report" > </button>'.' '.
                '<button title="' . __('আপলোড করুন') . ' " data-scheme_id="' . $scheme['scheme_id'] . '" class="icon-plus text-danger upload" > </button>';
            $sl++;
        }

        $this->response->body(json_encode($schemes));
        return $this->response;
    }

    /*
     * karjo sompadon form
     */
    public function letter(){
        $this->layout = 'ajax';
        $user = $this->Auth->user();
        $this->loadModel('Schemes');
        $this->loadModel('QrImages');
        $scheme = $this->request->data();

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
        $query = TableRegistry::get('schemes')->find();
        $result = $query
            ->select([
                'scheme_name' => 'schemes.name_en',
                'scheme_code' => 'schemes.scheme_code',
                'contract_amount' => 'schemes.contract_amount',
                'noa_date' => 'schemes.noa_date',
                'district' => 'districts.name_en',
                'upazila' => 'upazilas.name_en',
                'fiscal_year' => 'financial_year_estimates.name',
                'contractor_title' => 'contractors.contractor_title',
                'contractor_phone' => 'contractors.contractor_phone',
                'contractor_person_name' => 'contractors.contact_person_name',
                'contractor_address' => 'contractors.contractor_address',
                'contractor_tin_no' => 'contractors.tin_no',
                'trade_licence_no' => 'contractors.trade_licence_no',
                'qr_image' => 'qr_images.qr_image',
                'serve_amount' => $query->func()->sum('processed_ra_bills.bill_amount'),
                'original_commencemen' => 'processed_reports.do_commencement',
                'original_completion' => 'processed_reports.do_completion',
                'actual_commencemen' => 'processed_reports.edo_completion',
                'actual_completion' => 'processed_reports.ado_completion',
            ])
            ->leftJoin('districts', 'districts.id = schemes.district_id')
            ->leftJoin('upazilas', 'upazilas.id = schemes.upazila_id')
            ->leftJoin('processed_ra_bills', 'processed_ra_bills.scheme_id = schemes.id')
            ->leftJoin('scheme_contractors', 'scheme_contractors.scheme_id = schemes.id')
            ->leftJoin('contractors', 'contractors.id = scheme_contractors.contractor_id')
            ->leftJoin('contractors', 'contractors.id = scheme_contractors.contractor_id')
            ->leftJoin('financial_year_estimates', 'financial_year_estimates.id = schemes.financial_year_estimate_id')
            ->leftJoin('qr_images', 'qr_images.scheme_id = schemes.id')
            ->leftJoin('processed_reports', 'processed_reports.scheme_id = schemes.id')
            ->where(['schemes.id' => $scheme['id'], 'scheme_contractors.is_lead' => 1 ])
            ->first();
        $this->set(compact('result'));
    }

    /*
     * protoyon potro
     */
    public function certificate(){
        $this->layout = 'ajax';
        $user = $this->Auth->user();
        $scheme = $this->request->data();
        $query = TableRegistry::get('processed_ra_bills')->find();
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
            ->leftJoin('scheme_contractors', 'scheme_contractors.scheme_id = processed_ra_bills.scheme_id')
            ->leftJoin('contractors', 'contractors.id = scheme_contractors.contractor_id')
            ->leftJoin('financial_year_estimates', 'financial_year_estimates.id = processed_ra_bills.financial_year_estimate_id')
            ->where(['processed_ra_bills.scheme_id' => $scheme['id'], 'scheme_contractors.is_lead' => 1])
            ->hydrate(false)
            ->toArray();

        $query = TableRegistry::get('processed_ra_bills')->find();
        if(!empty($processRaBills)){
            $finalYears = $query->select([
                'fiscal_year' => 'financial_year_estimates.name',
            ])
                ->leftJoin('financial_year_estimates', 'financial_year_estimates.id = processed_ra_bills.financial_year_estimate_id')
                ->where(['processed_ra_bills.scheme_id' => $scheme['id']])
                ->group(['financial_year_estimates.name'])
                ->hydrate(false)
                ->toArray();
        }else{
            $query = TableRegistry::get('schemes')->find();
            $processRaBills_two = $query
                ->select([
                    'contractor_title' => 'contractors.contractor_title',
                    'contractor_person_name' => 'contractors.contact_person_name',
                    'contractor_address' => 'contractors.contractor_address',
                    'contractor_tin_no' => 'contractors.tin_no',
                ])
                ->leftJoin('scheme_contractors', 'scheme_contractors.scheme_id = schemes.id')
                ->leftJoin('contractors', 'contractors.id = scheme_contractors.contractor_id')
                ->where(['schemes.id' => $scheme['id'], 'scheme_contractors.is_lead' => 1 ])
                ->first();

            $this->loadModel('FinancialYearEstimates');
            $finalYears = $this->FinancialYearEstimates->find('list')->where(['status !=' => 99])->order(['id' => 'DESC'])->first();
        }
        $this->set(compact('processRaBills','finalYears','processRaBills_two'));
    }

    /*
     * Upload function
     */
    public function upload($id){
        $this->layout = 'ajax';
        $user = $this->Auth->user();
        $this->loadModel('Documents');
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->data;
            $previous = $this->Documents->find('all')->select(['id'])->where(['scheme_id' => $id])->first();
            if($previous['id']){
                $document = $this->Documents->get($previous['id']);
            }else{
                $document = $this->Documents->newEntity();
            }
            $data['scheme_id'] = $id;
            $document = $this->Documents->patchEntity($document, $data);
            if ($this->Documents->save($document)) {
                $this->Flash->success(__('The document has been uploaded.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The document could not be uploaded. Please, try again.'));
            }
        }
        $file = $this->Documents->find('all')->where(['scheme_id' => $id])->first();
//        pr($file);die;
        $this->set(compact('document','file'));
    }
}
