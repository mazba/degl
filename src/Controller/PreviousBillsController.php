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
     * Index method
     *
     * @return void
     */
    public function index()
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

}
