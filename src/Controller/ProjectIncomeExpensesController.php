<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * ProjectIncomeExpensesController
 *
 * @property \App\Model\Table\PurtoBillsTable $PurtoBills
 */
class ProjectIncomeExpensesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->loadModel('FinancialYearEstimates');
        $financialYearEstimates = $this->FinancialYearEstimates->find('list')->toArray();
        $this->set('financialYearEstimates', $financialYearEstimates);
    }
    public function ajax($action = '')
    {
        $this->layout='ajax';
        if($action == 'get_report')
        {
            $this->view = 'report';
            $user = $this->Auth->user();
            $financial_yr_id = $this->request->data(['financial_yr_id']);
            $financial_yr_text = $this->request->data(['financial_yr_text']);
            $this->loadModel('AllotmentRegisters');
            $allotments = $this->AllotmentRegisters->find('all',[
                'contain'=>['Projects'],
                'conditions'=>['financial_year_id'=>$financial_yr_id]
            ]);
            $data = [];
            foreach($allotments as $allotment)
            {
                $data[$allotment['project_id']]['name'] = $allotment['project']['name_bn'];
                if($allotment['dr_cr'] == 'Credit')
                {
                    $data[$allotment['project_id']]['Credit'] = isset($data[$allotment['project_id']]['Credit']) ? $data[$allotment['project_id']]['Credit']+$allotment['allotment_amount'] : $allotment['allotment_amount'];
                }
                else
                {
                    $data[$allotment['project_id']]['Debit'] = isset($data[$allotment['project_id']]['Debit']) ? $data[$allotment['project_id']]['Debit']+$allotment['allotment_amount'] : $allotment['allotment_amount'];
                }
            }
            $this->set('data', $data);
            $this->set('financial_yr_text', $financial_yr_text);
        }
    }
}
