<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * AssignVehicles Controller
 *
 * @property \App\Model\Table\AssignVehiclesTable $AssignVehicles
 */
class MechanicalBillTrackersController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {

    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $MechanicalBillTrackers = $this->MechanicalBillTrackers->newEntity();
        $user=$this->Auth->user();
        if ($this->request->is('post'))
        {
            $data = $this->request->data();
            $data['office_id']=$user['office_id'];
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            $MechanicalBillTrackers = $this->MechanicalBillTrackers->patchEntity($MechanicalBillTrackers, $data);
            if ($this->MechanicalBillTrackers->save($MechanicalBillTrackers))
            {
                $this->Flash->success(__('Data Saved'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('Data Can\'t Save'));
            }
        }
        $schemes = $this->MechanicalBillTrackers->Schemes->find('list')
            ->where(['project_offices.office_id'=>$user['office_id']])
            ->leftJoin('project_offices','project_offices.project_id = Schemes.project_id');
        $this->set(compact('schemes','MechanicalBillTrackers'));
        $this->set('_serialize', ['MechanicalBillTrackers']);
    }
    //    ajax
    public function ajax($action = null)
    {
        if($action == 'get_grid_data' && $this->user_roles['index'])
        {
            $user = $this->Auth->user();
            if($user['user_group_id']==1)
            {
                $mechanical_bills = $this->MechanicalBillTrackers->find('all')
                    ->select([
                        'MechanicalBillTrackers.ra_bill_no',
                        'MechanicalBillTrackers.deduction',
                        'schemes.name_en',
                        'offices.name_en',
                        'contractors.contractor_title',
                    ])
                    ->where(['scheme_contractors.is_lead'=>1])
                    ->leftJoin('schemes','schemes.id = MechanicalBillTrackers.scheme_id')
                    ->leftJoin('offices','offices.id = MechanicalBillTrackers.office_id')
                    ->leftJoin('scheme_contractors','scheme_contractors.scheme_id = MechanicalBillTrackers.scheme_id')
                    ->leftJoin('contractors','contractors.id = scheme_contractors.contractor_id')
                    ->toArray();
            }
            else
            {
                $mechanical_bills = $this->MechanicalBillTrackers->find('all')
                    ->select([
                        'MechanicalBillTrackers.id',
                        'MechanicalBillTrackers.ra_bill_no',
                        'MechanicalBillTrackers.deduction',
                        'schemes.name_en',
                        'offices.name_en',
                        'contractors.contractor_title',
                    ])
                    ->where(['scheme_contractors.is_lead'=>1,'MechanicalBillTrackers.office_id'=>$user['office_id']])
                    ->leftJoin('schemes','schemes.id = MechanicalBillTrackers.scheme_id')
                    ->leftJoin('offices','offices.id = MechanicalBillTrackers.office_id')
                    ->leftJoin('scheme_contractors','scheme_contractors.scheme_id = MechanicalBillTrackers.scheme_id')
                    ->leftJoin('contractors','contractors.id = scheme_contractors.contractor_id')
                    ->toArray();
            }
            foreach($mechanical_bills as &$mechanical_bill)
            {
                $mechanical_bill['schemes']=$mechanical_bill['schemes']['name_en'];
                $mechanical_bill['offices']=$mechanical_bill['offices']['name_en'];
                $mechanical_bill['contractors']=$mechanical_bill['contractors']['contractor_title'];
            }
            $this->response->body(json_encode($mechanical_bills));
            return $this->response;
        }
        else
        {
            return $this->redirect(['controller'=>'Dashboard','action'=>'index']);
        }
    }
    //    Print report
    public function print_it()
    {
        $user = $this->Auth->user();
        $this->layout='print';
        $this->view='print';
        if ($this->request->data('type') == 'by_date')
        {
            //$start_date = strtotime($this->request->data('start_date'). '00:00:00 GMT');// TODO:check time issue
            $end_date = strtotime($this->request->data('end_date'). '23:59:59 GMT');// TODO:check time issue

            $mechanical_bills = $this->MechanicalBillTrackers->find('all')
                ->select([
                    'MechanicalBillTrackers.id',
                    'MechanicalBillTrackers.deduction',
                    'schemes.id',
                    'schemes.name_en',
                    'contractors.contractor_title',
                ])
                ->where(
                    [
                        'scheme_contractors.is_lead'=>1,
                        'MechanicalBillTrackers.created_date <='=>$end_date,
                        'MechanicalBillTrackers.office_id'=>$user['office_id']
                    ])
                ->leftJoin('schemes','schemes.id = MechanicalBillTrackers.scheme_id')
                ->leftJoin('offices','offices.id = MechanicalBillTrackers.office_id')
                ->leftJoin('scheme_contractors','scheme_contractors.scheme_id = MechanicalBillTrackers.scheme_id')
                ->leftJoin('contractors','contractors.id = scheme_contractors.contractor_id')
                ->toArray();
        }
        else
        {
            $mechanical_bills = $this->MechanicalBillTrackers->find('all')
                ->select([
                    'MechanicalBillTrackers.id',
                    'MechanicalBillTrackers.deduction',
                    'schemes.id',
                    'schemes.name_en',
                    'contractors.contractor_title',
                ])
                ->where(
                    [
                        'scheme_contractors.is_lead'=>1,
                        'MechanicalBillTrackers.created_date <='=>strtotime('23:59'),
                        'MechanicalBillTrackers.office_id'=>$user['office_id']
                    ])
                ->leftJoin('schemes','schemes.id = MechanicalBillTrackers.scheme_id')
                ->leftJoin('offices','offices.id = MechanicalBillTrackers.office_id')
                ->leftJoin('scheme_contractors','scheme_contractors.scheme_id = MechanicalBillTrackers.scheme_id')
                ->leftJoin('contractors','contractors.id = scheme_contractors.contractor_id')
                ->toArray();
        }
        // OFFICE
        $officeTable = TableRegistry::get('offices');
        $office = $officeTable->find()
            ->where(['id'=>$user['office_id']])
            ->first();
        $this->set(compact('mechanical_bills','office'));
    }

}
