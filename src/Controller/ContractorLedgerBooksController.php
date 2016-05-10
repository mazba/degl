<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * ContractorLedgerBooks Controller
 *
 * @property \App\Model\Table\PurtoBillsTable $PurtoBills
 */
class ContractorLedgerBooksController extends AppController
{
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $user = $this->Auth->user();
        $this->loadModel('Contractors');
        $this->loadModel('FinancialYearEstimates');
        $financial_years = $this->FinancialYearEstimates->find('list');
        $contractors = $this->Contractors->find('list');
        $this->set('contractors', $contractors);
        $this->set('financial_years', $financial_years);
    }
    public function ajax($action = '')
    {
        $this->layout='ajax';
        if($action == 'load_ledger')
        {
            $this->view = 'report';
            $input = $this->request->data();
            $this->loadModel('AllotmentRegisters');
            $scheme_contractors = $this->AllotmentRegisters->find('all')
                ->select(['purto_bills.security','purto_bills.gross_bill','purto_bills.vat','purto_bills.income_taxes','purto_bills.roller_charge','purto_bills.lab_fee','purto_bills.net_taka'])
                ->select(['AllotmentRegisters.allotment_date','AllotmentRegisters.allotment_amount'])
                ->where(['AllotmentRegisters.financial_year_id'=>$input['financial_year_id']])
                ->where(['scheme_contractors.contractor_id'=>$input['contractor_id']])
                ->innerJoin('scheme_contractors','scheme_contractors.scheme_id = AllotmentRegisters.scheme_id')
                ->leftJoin('purto_bills','purto_bills.id = AllotmentRegisters.purto_bill_id')
                ->group(['AllotmentRegisters.id'])
                ->toArray();
//            echo '<pre>';
//            print_r($scheme_contractors);
//            echo '</pre>';
//            die;
            $this->set('scheme_contractors', $scheme_contractors);
        }
    }
}
