<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;


/**
 * ProcessedRaBills Controller
 *
 * @property \App\Model\Table\ProcessedRaBillsTable $ProcessedRaBills
 */
class ProcessedRaBillsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $user=$this->Auth->user();
        $processedRaBills = $this->ProcessedRaBills->find('all', [
            'conditions' =>['ProcessedRaBills.status !=' => 99],
            'contain' => ['Schemes', 'CreatedUser', 'UpdatedUser']
        ]);
        $this->set('processedRaBills', $processedRaBills);
        $this->set('_serialize', ['processedRaBills']);
    }

    /**
     * View method
     *
     * @param string|null $id Processed Ra Bill id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user=$this->Auth->user();
        $processedRaBill = $this->ProcessedRaBills->get($id, [
            'contain' => ['Schemes', 'CreatedUser', 'UpdatedUser']
        ]);
        $this->set('processedRaBill', $processedRaBill);
        $this->set('_serialize', ['processedRaBill']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($id)
    {
        $user=$this->Auth->user();
        $this->loadModel('proposed_ra_bills');
        $this->loadModel('hire_charges');
        $this->loadModel('lab_bills');
        $this->loadModel('lab_actual_tests');

        $measurementInfo = $this->proposed_ra_bills->find()
            ->where(['id ' =>$id])
            ->where(['status !=' =>99])
            ->first();
        if(!$measurementInfo){
            $this->Flash->error('Sorry!!This bill is already created.');
            return $this->redirect(['action' => 'index']);
        }
        $hire_charge= $this->hire_charges->find()
            ->where(['scheme_id' => $measurementInfo['scheme_id']])
            ->where(['status !=' =>99])
            ->where(['is_sent_to_accounts =' =>1])
            ->order(['id' => 'DESC'])
            ->first();


        $lab_actual_tests= $this->lab_bills->find()
            ->where(['reference_id' =>  $measurementInfo['scheme_id']])
            ->order(['id' => 'DESC'])
            ->where(['status !=' =>99])
            ->where(['is_sent_to_accounts =' =>1])
            ->first();


        if ($this->request->is('post'))
        {
            $processedRaBill = $this->ProcessedRaBills->newEntity();

            $data=$this->request->data;
            $hire_charge = TableRegistry::get('hire_charges');
            $query = $hire_charge->query();
            $query->update()
                ->set(['status' => 99])
                ->where(['id' => $data['hire_charge_id']])
                ->execute();

            $lab_bill = TableRegistry::get('lab_bills');
            $query = $lab_bill->query();
            $query->update()
                ->set(['status' => 99])
                ->where(['id' => $data['lab_fee_id']])
                ->execute();

            $lab_bill = TableRegistry::get('proposed_ra_bills');
            $query = $lab_bill->query();
            $query->update()
                ->set(['status' => 99])
                ->where(['id' => $id])
                ->execute();

            $data['proposed_ra_bill_id']=$id;
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            $processedRaBill = $this->ProcessedRaBills->patchEntity($processedRaBill, $data);
            if ($this->ProcessedRaBills->save($processedRaBill))
            {
                $this->Flash->success('The processed ra bill has been saved.');
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error('The processed ra bill could not be saved. Please, try again.');
            }
        }
        $this->set(compact('measurementInfo', 'hire_charge', 'lab_actual_tests','id'));
        $this->set('_serialize', ['processedRaBill']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Processed Ra Bill id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user=$this->Auth->user();
        $processedRaBill = $this->ProcessedRaBills->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $data=$this->request->data;
            $data['updated_by']=$user['id'];
            $data['updated_date']=time();
            $processedRaBill = $this->ProcessedRaBills->patchEntity($processedRaBill, $data);
            if ($this->ProcessedRaBills->save($processedRaBill))
            {
                $this->Flash->success('The processed ra bill has been saved.');
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error('The processed ra bill could not be saved. Please, try again.');
            }
        }
        $schemes = $this->ProcessedRaBills->Schemes->find('list', ['limit' => 200]);
        $createdUser = $this->ProcessedRaBills->CreatedUser->find('list', ['limit' => 200]);
        $updatedUser = $this->ProcessedRaBills->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('processedRaBill', 'schemes', 'createdUser', 'updatedUser'));
        $this->set('_serialize', ['processedRaBill']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Processed Ra Bill id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $processedRaBill = $this->ProcessedRaBills->get($id);

        $user=$this->Auth->user();
        $data=$this->request->data;
        $data['updated_by']=$user['id'];
        $data['updated_date']=time();
        $data['status']=99;
        $processedRaBill = $this->ProcessedRaBills->patchEntity($processedRaBill, $data);
        if ($this->ProcessedRaBills->save($processedRaBill))
        {
            $this->Flash->success('The processed ra bill has been deleted.');
        }
        else
        {
            $this->Flash->error('The processed ra bill could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }

    public function invoice_form($id = null)
    {

        $purtoBill = $this->ProcessedRaBills->find('all')
            ->select([
                'id' => 'ProcessedRaBills.id',
                'scheme_id' => 'ProcessedRaBills.scheme_id',
                'bill_amount' => 'ProcessedRaBills.bill_amount',
                'security' => 'ProcessedRaBills.security',
                'income_tex' => 'ProcessedRaBills.income_tex',
                'vat' => 'ProcessedRaBills.vat',
                'hire_charge' => 'ProcessedRaBills.hire_charge',
                'fine' => 'ProcessedRaBills.fine',
                'lab_fee' => 'ProcessedRaBills.lab_fee',
                'net_payable' => 'ProcessedRaBills.net_payable',
                'cost_of_material' => 'ProcessedRaBills.cost_of_material',
                'etc_fee' => 'ProcessedRaBills.etc_fee',
                'bill_type' => 'ProcessedRaBills.processed_bill_type',
                'e_field' => 'ProcessedRaBills.e_field',
                'e_value' => 'ProcessedRaBills.e_value',
                'bill_type_check' => 'proposed_ra_bills.bill_type',
                'scheme_name' => 'schemes.name_en',
                'etender_no' => 'schemes.etender_no',
                'contract_amount' => 'schemes.contract_amount',
                'contractor_name' => 'contractors.contractor_title',
                'district' => 'districts.name_en',
                'upazila' => 'upazilas.name_en',
                'package' => 'packages.name_en',
                'do_commencement' => 'processed_reports.do_commencement',
                'do_completion' => 'processed_reports.do_completion',
                'edo_completion' => 'processed_reports.edo_completion',
                'ado_completion' => 'processed_reports.ado_completion',
            ])
            ->leftJoin('schemes', 'schemes.id = ProcessedRaBills.scheme_id')
            ->leftJoin('scheme_contractors', 'scheme_contractors.scheme_id = ProcessedRaBills.scheme_id')
            ->leftJoin('contractors', 'contractors.id = scheme_contractors.contractor_id')
            ->leftJoin('districts', 'districts.id = schemes.district_id')
            ->leftJoin('upazilas', 'upazilas.id = schemes.upazila_id')
            ->leftJoin('packages', 'packages.id = schemes.package_id')
            ->leftJoin('processed_reports', 'processed_reports.scheme_id = ProcessedRaBills.scheme_id')
            ->leftJoin('proposed_ra_bills', 'proposed_ra_bills.scheme_id = ProcessedRaBills.scheme_id')
            ->where(['ProcessedRaBills.id' => $id])
            ->hydrate(false)
            ->first();
//        pr($purtoBill);die;
/*        $purtoBill = $this->ProcessedRaBills->get($id, ['contain' => [
            'Schemes.SchemeContractors.Contractors',
            'Schemes',
            'Schemes.Districts',
            'Schemes.Upazilas',
            'Schemes.Packages',
            'Schemes.ProposedRaBills',
            'ProcessedReports'
        ]]);*/
        $this->set(compact('purtoBill'));
    }
}
