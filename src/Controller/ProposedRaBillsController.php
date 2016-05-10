<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
/**
 * ProposedRaBills Controller
 *
 * @property \App\Model\Table\ProposedRaBillsTable $ProposedRaBills
 */
class ProposedRaBillsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $user = $this->Auth->user();
        $proposedRaBills = $this->ProposedRaBills->find('all', [
            'conditions' =>['ProposedRaBills.status !=' => 99],
            'contain' => ['Offices', 'Schemes', 'MeasurementBooks', 'CreatedUser', 'UpdatedUser']
        ]);
        // approve bills
        $approve_ra_bills = TableRegistry::get('approve_ra_bills');
        $approve_bills = $approve_ra_bills->find('all')
                               ->select(['proposed_ra_bills_id','approved_quantity'])
                               ->hydrate(false)
                               ->toArray();
        // Arrange approve bills
        $arranged_bills = array();
        foreach($approve_bills as $bill)
        {
            if(isset($arranged_bills[$bill['proposed_ra_bills_id']]))
            {
                $arranged_bills[$bill['proposed_ra_bills_id']] = $arranged_bills[$bill['proposed_ra_bills_id']] + $bill['approved_quantity'];
            }
            else
            {
                $arranged_bills[$bill['proposed_ra_bills_id']] = $bill['approved_quantity'];
            }
        }
//        echo '<pre>';
//        print_r($approve_bills);
//        print_r($proposedRaBills);
//        echo '</pre>';
//        die;
        $this->set(compact('proposedRaBills','arranged_bills'));
        $this->set('_serialize', ['proposedRaBills']);
    }

    /**
     * View method
     *
     * @param string|null $id Proposed Ra Bill id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user=$this->Auth->user();
        $proposedRaBill = $this->ProposedRaBills->get($id, [
            'contain' => ['Offices', 'Schemes', 'MeasurementBooks', 'CreatedUser', 'UpdatedUser']
        ]);
        $approve_ra_table = TableRegistry::get('approve_ra_bills');
        $approve_ra_bills = $approve_ra_table->find()
            ->where(['proposed_ra_bills_id'=>$id])
            ->toArray();
        $this->set('proposedRaBill', $proposedRaBill);
        $this->set('approve_ra_bills', $approve_ra_bills);
        $this->set('_serialize', ['proposedRaBill']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Auth->user();
        $proposedRaBill = $this->ProposedRaBills->newEntity();
        if ($this->request->is('post'))
        {
            $data = $this->request->data;
            $data['office_id'] = $user['office_id'];
            $data['created_by'] = $user['id'];
            $data['created_date'] = time();
            $proposedRaBill = $this->ProposedRaBills->patchEntity($proposedRaBill, $data);
            if ($this->ProposedRaBills->save($proposedRaBill))
            {
                $this->Flash->success(__('The proposed ra bill has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The proposed ra bill could not be saved. Please, try again.'));
            }
        }
        $schemes = $this->ProposedRaBills->Schemes->find('list')
            ->innerJoin('project_offices', 'project_offices.project_id = Schemes.project_id')
            ->leftJoin('projects', 'projects.id = Schemes.project_id')
            ->where(['project_offices.office_id'=>$user['office_id']]);
        $measurementBooks = $this->ProposedRaBills->MeasurementBooks->find('list');
        $this->set(compact('proposedRaBill', 'schemes', 'measurementBooks'));
        $this->set('_serialize', ['proposedRaBill']);
    }
    /**
     * Approve method
     *
     * @param string|null $id Proposed Ra Bill id.
     */
    public function approve($id = null)
    {
        $user = $this->Auth->user();

        $ra_bills = $this->ProposedRaBills->find()
            ->select(['schemes.name_en','contractors.contractor_title','ProposedRaBills.bill_amount'])
            ->leftJoin('schemes', 'schemes.id = ProposedRaBills.scheme_id')
            ->innerJoin('scheme_contractors', 'scheme_contractors.scheme_id = ProposedRaBills.scheme_id')
            ->innerJoin('contractors', 'contractors.id = scheme_contractors.contractor_id')
            ->where(['ProposedRaBills.id'=>$id])
            ->where(['scheme_contractors.is_lead'=>1])
            ->first()
            ;
        // approve bills
        $approve_ra_bills = TableRegistry::get('approve_ra_bills');
        $approve_bills = $approve_ra_bills->find('all')
            ->select(['approved_quantity'])
            ->where(['proposed_ra_bills_id'=>$id])
            ->hydrate(false)
            ->toArray();
        // Arrange approve bills
        $old_bills = 0;
        foreach($approve_bills as $bill)
        {
            $old_bills+=$bill['approved_quantity'];
        }
        // Approve RA bills data save
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $data = $this->request->data;
            if(($old_bills+$data['approved_quantity']) <= $ra_bills['bill_amount'])
            {
                $data['proposed_ra_bills_id'] = $id;
                $approve_ra_bills = TableRegistry::get('approve_ra_bills');
                $query = $approve_ra_bills->query();
                $query->insert(array_keys($data))
                    ->values($data)
                    ->execute();
                $this->Flash->success(__('The RA bill has been Approved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The Approved amount larger than the Bill Amount'));
            }
        }
        $this->set(compact('id','ra_bills'));
    }


    /**
     * Edit method
     *
     * @param string|null $id Proposed Ra Bill id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
//    public function edit($id = null)
//    {
//        $user=$this->Auth->user();
//        $proposedRaBill = $this->ProposedRaBills->get($id, [
//            'contain' => []
//        ]);
//        if ($this->request->is(['patch', 'post', 'put']))
//        {
//            $data=$this->request->data;
//            $data['updated_by']=$user['id'];
//            $data['updated_date']=time();
//            $proposedRaBill = $this->ProposedRaBills->patchEntity($proposedRaBill, $data);
//            if ($this->ProposedRaBills->save($proposedRaBill))
//            {
//                $this->Flash->success('The proposed ra bill has been saved.');
//                return $this->redirect(['action' => 'index']);
//            }
//            else
//            {
//                $this->Flash->error('The proposed ra bill could not be saved. Please, try again.');
//            }
//        }
//        $offices = $this->ProposedRaBills->Offices->find('list', ['limit' => 200]);
//        $schemes = $this->ProposedRaBills->Schemes->find('list', ['limit' => 200]);
//        $measurementBooks = $this->ProposedRaBills->MeasurementBooks->find('list', ['limit' => 200]);
//        $createdUser = $this->ProposedRaBills->CreatedUser->find('list', ['limit' => 200]);
//        $updatedUser = $this->ProposedRaBills->UpdatedUser->find('list', ['limit' => 200]);
//        $this->set(compact('proposedRaBill', 'offices', 'schemes', 'measurementBooks', 'createdUser', 'updatedUser'));
//        $this->set('_serialize', ['proposedRaBill']);
//    }

    /**
     * Delete method
     *
     * @param string|null $id Proposed Ra Bill id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
//    public function delete($id = null)
//    {
//
//        $proposedRaBill = $this->ProposedRaBills->get($id);
//
//        $user=$this->Auth->user();
//        $data=$this->request->data;
//        $data['updated_by']=$user['id'];
//        $data['updated_date']=time();
//        $data['status']=99;
//        $proposedRaBill = $this->ProposedRaBills->patchEntity($proposedRaBill, $data);
//        if ($this->ProposedRaBills->save($proposedRaBill))
//        {
//            $this->Flash->success('The proposed ra bill has been deleted.');
//        }
//        else
//        {
//            $this->Flash->error('The proposed ra bill could not be deleted. Please, try again.');
//        }
//        return $this->redirect(['action' => 'index']);
//    }

        public function ajax($task = null)
        {
            $user = $this->Auth->user();
            if($task == 'get_measurement_books')
            {
                // get measurement id
                $scheme_id = $this->request->data['scheme_id'];
                $MeasurementBooks = $this->loadModel('MeasurementBooks');
                $data = $MeasurementBooks->find('all')
                    ->select(['id','book_no'])
                    ->where(['scheme_id'=>$scheme_id,'office_id'=>$user['office_id']])
                    ->hydrate(false)
                    ->toArray();
                $this->response->body(json_encode($data));
                return $this->response;
            }
            elseif($task == 'get_items')
            {
                $this->layout='ajax';
                $this->view = 'ra_bills';
                $input = $this->request->data;
                // Latest Measurement
                $measurements_table = TableRegistry::get('measurements');
                $last_measurement = $measurements_table->find()
                                ->select(['measurement_no'])
                                ->where(['measurement_book_id'=>$input['measurement_book_id']])
                                ->order(['measurement_no'=>'DESC'])
                                ->first()
                                ->toArray();


                if($last_measurement)
                {
                    //find item latest measurement wise
                    $sub_query = $measurements_table->find();
                    $sub_query->select(['s_details_id'=>'scheme_details_id'])
                        ->select(['max_measurement_no'=>$sub_query->func()->max('measurement_no')])
                        ->where(['measurement_book_id'=>$input['measurement_book_id']])
                        ->group(['scheme_details_id']);

                    $latest_measurements = $measurements_table->find();
                    $latest_measurements = $latest_measurements
                        ->select(['id','scheme_details_id','measurement_no','quantity_of_work_done'])
                        ->join([
                            'table' => $sub_query,
                            'alias' => 'max_measurement',
                            'type' => 'INNER',
                            'conditions' => 'max_measurement.s_details_id = measurements.scheme_details_id AND max_measurement.max_measurement_no = measurements.measurement_no'
                        ])
                        ->hydrate(false)
                        ->toArray();

                    $arrange_latest_measurements = array();
                    foreach($latest_measurements as $latest_measurement)
                    {
                        $arrange_latest_measurements[$latest_measurement['scheme_details_id']] = $latest_measurement['quantity_of_work_done'];
                    }

                    //find scheme_details items
                    $scheme_details_table = TableRegistry::get('scheme_details');
                    $scheme_details = $scheme_details_table->find('all')
                        ->select(['id','details','rate','item_code','item_unit'])
                        ->where(['scheme_id'=>$input['scheme_id'],'status'=>1])
                        ->hydrate(false)
                        ->toArray();
                    foreach($scheme_details as &$scheme_detail)
                    {
                        if(array_key_exists($scheme_detail['id'],$arrange_latest_measurements))
                        {
                            $scheme_detail['quantity_executed'] = $arrange_latest_measurements[$scheme_detail['id']];
                        }
                        else
                        {
                            $scheme_detail['quantity_executed'] = 0;
                        }
                    }
                    // find the last RA bills ;
                    $ra_bills_table = TableRegistry::get('proposed_ra_bills');
                    $last_ra_bills = $ra_bills_table->find()
                        ->select(['latest_measurement_no','ra_bill_no'])
                        ->where(['scheme_id'=>$input['scheme_id']])
                        ->order(['id'=>'DESC'])
                        ->first();
                    // set Current RA Bills No
                    $ra_bill_no = (isset($last_ra_bills['ra_bill_no']) ? $last_ra_bills['ra_bill_no']+1 : 1);

                    // find the last measurement last ra bill wise
                    if($last_ra_bills)// FOR Quantity Excess or Supplied Sin Last R-A Bill
                    {
                        $measurements_table = TableRegistry::get('measurements');
                        $last_measurement_ra_bill_wise = $measurements_table->find()
                            ->select(['scheme_details_id','quantity_of_work_done'])
                            ->where(['measurement_book_id'=>$input['measurement_book_id'],'measurement_no'=>$last_ra_bills['latest_measurement_no']])
                            ->order(['id'=>'DESC'])
                            ->hydrate(false)
                            ->toArray();
                        // arrange the last RA bills measurement
                        foreach($last_measurement_ra_bill_wise as $item)
                        {
                            $last_ra_bills_items[$item['scheme_details_id']] = $item['quantity_of_work_done'];
                        }
                    }
                    // previous RA Approve bills.....
                    $ra_bills_table = TableRegistry::get('proposed_ra_bills');
                    $approve_ra_bills = $ra_bills_table->find('all')
                        ->select(['approve_ra_bills.approved_quantity'])
                        ->innerJoin('approve_ra_bills', 'approve_ra_bills.proposed_ra_bills_id = proposed_ra_bills.id')
                        ->where(['proposed_ra_bills.scheme_id'=>$input['scheme_id']])
                        ->hydrate(false)
                        ->toArray();
                    $up_to_date_approved = 0;
                    foreach($approve_ra_bills as $approve_ra_bill)
                    {
                        $up_to_date_approved += $approve_ra_bill['approve_ra_bills']['approved_quantity'];
                    }
                }
                $this->set(compact('scheme_details','last_measurement','last_ra_bills_items','up_to_date_approved','ra_bill_no'));
            }
        }
}
