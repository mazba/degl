<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * PreviousBills Controller
 *
 * @property \App\Model\Table\PreviousBillsTable $PreviousBills
 */
class PreviousBillsController extends AppController
{
    /**
     * index method
     */
    public function index(){

    }

    public function index_ajax($action = null){
        $query = TableRegistry::get('processed_ra_bills')->find();
        $data = $query
            ->select([
                'bill_id' => 'processed_ra_bills.id',
                'scheme_name' => 'schemes.name_en',
                'financial_year_estimates' => 'financial_year_estimates.name',
                'contractor_name' => 'contractors.contractor_title',
                'bill_amount' => 'processed_ra_bills.bill_amount',
                'income_tex' => 'processed_ra_bills.income_tex',
                'vat' => 'processed_ra_bills.vat',
            ])
            ->leftJoin('schemes', 'schemes.id = processed_ra_bills.scheme_id')
            ->leftJoin('scheme_contractors', 'scheme_contractors.scheme_id = schemes.id')
            ->leftJoin('contractors', 'contractors.id = scheme_contractors.contractor_id')
            ->leftJoin('financial_year_estimates', 'financial_year_estimates.id = processed_ra_bills.financial_year_estimate_id')
            ->where(['processed_ra_bills.status !=' => 99, 'scheme_contractors.is_lead' => 1 ])
            ->hydrate(false)
            ->order(['processed_ra_bills.id' => 'desc'])
            ->toArray();
        $sl = 1;
        foreach ($data as &$datum) {
            $datum['sl'] = $sl;
            $datum['action'] =
                '<button title="' . __('বাতিল করুন') . ' " data-bill_id="' . $datum['bill_id'] . '" class="icon-minus text-danger delete" onclick = "return confirm(\' Are you sure want to Delete ? \')"> </button>';
            $sl++;
        }
        $this->response->body(json_encode($data));
        return $this->response;
    }
    /**
     * add method
     *
     * @return void
     */
    public function add()
    {
        $user= $this->Auth->user();
        $this->loadModel('ProcessedRaBills');
        if ($this->request->is('post')) {
            $processedRaBill = $this->ProcessedRaBills->newEntity();
            $data=$this->request->data;

            // contractor id search
            $query = TableRegistry::get('schemes')->find();
            $contractor_id = $query
                ->select([
                    'contractor_id' => 'contractors.id',
                ])
                ->leftJoin('scheme_contractors', 'scheme_contractors.scheme_id = schemes.id')
                ->leftJoin('contractors', 'contractors.id = scheme_contractors.contractor_id')
                ->where(['schemes.id' => $data['scheme_id'], 'scheme_contractors.is_lead' => 1 ])
                ->first();
            $data['contractor_id'] = $contractor_id->contractor_id;
            $data['proposed_ra_bill_id']= 999999;
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            $processedRaBill = $this->ProcessedRaBills->patchEntity($processedRaBill, $data);
            if ($this->ProcessedRaBills->save($processedRaBill))
            {
                $this->Flash->success('The adjusted processed ra bill has been saved.');
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error('The adjusted processed ra bill could not be saved. Please, try again.');
            }
        }
        $this->loadModel('ProposedRaBills');
        $schemes = $this->ProposedRaBills->Schemes->find('list')
            ->innerJoin('project_offices', 'project_offices.project_id = Schemes.project_id')
            ->leftJoin('projects', 'projects.id = Schemes.project_id')
            ->where(['project_offices.office_id' => $user['office_id']]);

        $this->loadModel('FinancialYearEstimates');
        $financial_year_estimate_id = $this->FinancialYearEstimates->find('list')->where(['status !=' => 99]);
        $this->set(compact('financial_year_estimate_id','schemes'));
    }

    /*
     * delete
     */
    public function delete($id){
        $this->loadModel('ProcessedRaBills');
        $processBill = $this->ProcessedRaBills->get($id);
        $user=$this->Auth->user();
        $data=$this->request->data;
        $data['status']=99;
        $processBill = $this->ProcessedRaBills->patchEntity($processBill, $data);
        if ($this->ProcessedRaBills->save($processBill))
        {
            $this->Flash->success('The previous bill has been deleted.');
        }
        else
        {
            $this->Flash->error('The previous bill could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }

}
