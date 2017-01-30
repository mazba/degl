<?php
namespace App\Controller;

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
        if ($user['office_id'] == 1) {
            $proposedRaBills = $this->ProposedRaBills->find('all', [
                //  'conditions' => ['ProposedRaBills.status !=' => 99],
                'contain' => ['Offices', 'Schemes']
            ]);
        } else {
            $proposedRaBills = $this->ProposedRaBills->find('all', [
                // 'conditions' => ['ProposedRaBills.status !=' => 99],
                'conditions' => ['ProposedRaBills.office_id =' => $user['office_id']],
                'contain' => ['Offices', 'Schemes']
            ]);
        }


        // approve bills
        $approve_ra_bills = TableRegistry::get('approve_ra_bills');
        $approve_bills = $approve_ra_bills->find('all')
            ->select(['proposed_ra_bills_id', 'approved_quantity'])
            ->hydrate(false)
            ->toArray();
        // Arrange approve bills
        $arranged_bills = array();
        foreach ($approve_bills as $bill) {
            if (isset($arranged_bills[$bill['proposed_ra_bills_id']])) {
                // $arranged_bills[$bill['proposed_ra_bills_id']] = $arranged_bills[$bill['proposed_ra_bills_id']] + $bill['approved_quantity'];
            } else {
                $arranged_bills[$bill['proposed_ra_bills_id']] = $bill['approved_quantity'];
            }
        }
//        echo '<pre>';
//        print_r($approve_bills);
//        print_r($proposedRaBills);
//        echo '</pre>';
//        die;
        $this->set(compact('proposedRaBills', 'arranged_bills'));
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
        $user = $this->Auth->user();
        $measurements_table = TableRegistry::get('measurements');

        $proposedRaBill = $this->ProposedRaBills->get($id);
        //  echo "<pre>";print_r($proposedRaBill->toArray());die();

        //find item latest measurement wise
        $sub_query = $measurements_table->find();
        $sub_query->select(['s_details_id' => 'scheme_id'])
            ->select(['max_measurement_no' => $sub_query->func()->max('measurement_no')])
            ->where(['scheme_id' => $proposedRaBill['scheme_id']])
            ->group(['scheme_id']);

        $latest_measurements = $measurements_table->find();
        $latest_measurements = $latest_measurements
            ->select(['id', 'item_id', 'scheme_id', 'measurement_no', 'quantity_of_work_done'])
            ->join([
                'table' => $sub_query,
                'alias' => 'max_measurement',
                'type' => 'INNER',
                'conditions' => 'max_measurement.s_details_id = measurements.scheme_id AND max_measurement.max_measurement_no = measurements.measurement_no'
            ])
            ->hydrate(false)
            ->toArray();
        $arrange_latest_measurements = array();
        foreach ($latest_measurements as $key => $latest_measurement) {
            $arrange_latest_measurements[$latest_measurement['item_id']] = $latest_measurement['quantity_of_work_done'];
        }

        $scheme_details = TableRegistry::get('ra_bill_details')->find('all')
          //  ->select(['id', 'description', 'rate', 'item_display_code', 'unit','quantity','rate'])

            ->select(['id' => 'schemes_items.id', 'description' => 'ra_bill_details.short_description', 'rate' => 'schemes_items.rate', 'item_display_code' => 'schemes_items.item_display_code', 'unit' => 'schemes_items.unit', 'quantity' => 'schemes_items.quantity'])
            ->where(['ra_bill_id' => $proposedRaBill['id']])
            ->leftJoin('schemes_items', 'schemes_items.id = ra_bill_details.scheme_item_id')
            ->hydrate(false)
            ->toArray();
//echo "<pre>";print_r($scheme_details);die();

        foreach ($scheme_details as &$scheme_detail) {

            $sub_query = $measurements_table->find();
            $sub_query->select(['max_quantity_executed' => $sub_query->func()->max('quantity_of_work_done')])
                ->where(['scheme_id' =>  $proposedRaBill['scheme_id'], 'item_id' => $scheme_detail['id'], 'measurement_no <=' => $proposedRaBill['measurement_no']]);
            $sub_query = $sub_query->first();
            $scheme_detail['quantity_executed'] = $sub_query['max_quantity_executed'] ? $sub_query['max_quantity_executed'] : 0;

        }


        $ra_bills_table = TableRegistry::get('proposed_ra_bills');
        $last_ra_bills = $ra_bills_table->find()
            ->select(['measurement_no', 'ra_bill_no'])
            ->where(['scheme_id' => $proposedRaBill['scheme_id']])
            ->order(['id' => 'DESC'])
            ->first();
        // set Current RA Bills No
        $ra_bill_no = $proposedRaBill['measurement_no'];

        $scheme_items_table = TableRegistry::get('schemes_items');
        $scheme_detailss = $scheme_items_table->find('all')
            ->select(['id', 'description', 'rate', 'item_display_code', 'unit'])
            ->where(['scheme_id' => $proposedRaBill['scheme_id'], 'status' => 1])
            ->hydrate(false)
            ->toArray();

        //  find the last measurement last ra bill wise
        if ($last_ra_bills)// FOR Quantity Excess or Supplied Sin Last R-A Bill
        {
            $last_measurement_ra_bill_wise = [];
            foreach ($scheme_detailss as &$scheme_detail) {
                $sub_query = $measurements_table->find();
                $sub_query->select(['item_id', 'quantity_of_work_done' => $sub_query->func()->max('quantity_of_work_done')])
                    ->where(['scheme_id' => $proposedRaBill['scheme_id'], 'item_id' => $scheme_detail['id'], 'measurement_no <' => $proposedRaBill['measurement_no']]);
                $last_measurement_ra_bill_wise[] = $sub_query->first();
            }

            // arrange the last RA bills measurement
            $last_ra_bills_items = [];
            foreach ($last_measurement_ra_bill_wise as $item) {
                $last_ra_bills_items[$item['item_id']] = $item['quantity_of_work_done'];
            }
        //    echo "<pre>";print_r($last_ra_bills_items);die();
        }
        //  previous RA Approve bills.....
        $ra_bills_table = TableRegistry::get('proposed_ra_bills');
        $approve_ra_bills = $ra_bills_table->find('all')
//                    ->select(['approve_ra_bills.approved_quantity'])
//                    ->innerJoin('approve_ra_bills', 'approve_ra_bills.proposed_ra_bills_id = proposed_ra_bills.id')
            ->where(['proposed_ra_bills.scheme_id' => $proposedRaBill['scheme_id'],'proposed_ra_bills.ra_bill_no <'=>$proposedRaBill['ra_bill_no']])
            ->hydrate(true)
            ->toArray();
        $up_to_date_approved = 0;
        foreach ($approve_ra_bills as $approve_ra_bill) {
            $up_to_date_approved += $approve_ra_bill['approve_bill_amount'];
        }



        $this->set(compact('up_to_date_approved', 'proposedRaBill', 'scheme_details', 'last_measurement', 'last_ra_bills_items', 'up_to_date_approved', 'ra_bill_no'));

    }
//
//    /**
//     * Add method
//     *
//     * @return void Redirects on successful add, renders view otherwise.
//     */
    public function add()
    {
        $user = $this->Auth->user();
        $proposedRaBill = $this->ProposedRaBills->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->data;
            //echo "<pre>";print_r($data);die();
            $data['office_id'] = $user['office_id'];
            $data['created_by'] = $user['id'];
            $data['created_date'] = time();
            $proposedRaBill = $this->ProposedRaBills->patchEntity($proposedRaBill, $data);
            // echo "<pre>";print_r($proposedRaBill);die();
            $ra_bill_id = $this->ProposedRaBills->save($proposedRaBill);


            foreach ($data['details'] as $row) {
                $this->loadModel('RaBillDetails');
                $ra_bill_detail = $this->RaBillDetails->newEntity();
                $value['ra_bill_id'] = $ra_bill_id['id'];
                $value['scheme_item_id'] = $row['scheme_item_id'];
                $value['short_description'] = $row['short_description'];
                $value['serial_number'] = $row['serial_number'];

                $ra_bill_detail = $this->RaBillDetails->patchEntity($ra_bill_detail, $value);
                //   echo "<pre>";print_r($ra_bill_detail);die();
                $i = $this->RaBillDetails->save($ra_bill_detail);

            }

            if (isset($data['user'])) {
                $arr = array();
                $arr['sender_id'] = $user['id'];
                $arr['subject'] = $data['subject'];
                $arr['message_text'] = $data['message'];
                $arr['resource_id'] = $ra_bill_id['id'];
                $arr['msg_type'] = 'raBill';
                $arr['created_date'] = time();
                $arr['created_by'] = $user['id'];
                $arr['status'] = 1;
                $this->loadModel('MessageRegisters');
                $messageRegisters = $this->MessageRegisters->newEntity();
                $messageRegisters = $this->MessageRegisters->patchEntity($messageRegisters, $arr);
                $msg = $this->MessageRegisters->save($messageRegisters);


                foreach ($data['user'] as $user_id) {
                    $recipient_data['message_register_id'] = $msg['id'];
                    $recipient_data['user_id'] = $user_id;
                    $recipient_data['created_date'] = time();
                    $recipient_data['created_by'] = $user['id'];
                    $recipient_data['status'] = 1;

                    $this->loadModel('Recipients');
                    $recipients = $this->Recipients->newEntity();
                    $recipients = $this->Recipients->patchEntity($recipients, $recipient_data);
                    $this->Recipients->save($recipients);
                }
            }
            // echo "<pre>";print_r($i);die();
            if ($i) {
                $this->Flash->success(__('The proposed ra bill has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The proposed ra bill could not be saved. Please, try again.'));
            }
        }
        $this->loadModel('Departments');
        $departments = $this->Departments->find('all', ['contain' => ['Users', 'Users.Designations'], 'conditions' => ['Departments.office_id' => $user['office_id']]]);

        $schemes = $this->ProposedRaBills->Schemes->find('list')
            ->innerJoin('project_offices', 'project_offices.project_id = Schemes.project_id')
            ->leftJoin('projects', 'projects.id = Schemes.project_id')
            ->where(['project_offices.office_id' => $user['office_id']]);
        // $measurementBooks = $this->ProposedRaBills->MeasurementBooks->find('list');
        $this->set(compact('proposedRaBill', 'schemes', 'measurementBooks', 'departments'));
        $this->set('_serialize', ['proposedRaBill']);
    }
//    /**
//     * Approve method
//     *
//     * @param string|null $id Proposed Ra Bill id.
//     */
//    public function approve($id = null)
//    {
//        $user = $this->Auth->user();
//
//        $ra_bills = $this->ProposedRaBills->find()
//            ->select(['schemes.name_en','contractors.contractor_title','ProposedRaBills.bill_amount'])
//            ->leftJoin('schemes', 'schemes.id = ProposedRaBills.scheme_id')
//            ->innerJoin('scheme_contractors', 'scheme_contractors.scheme_id = ProposedRaBills.scheme_id')
//            ->innerJoin('contractors', 'contractors.id = scheme_contractors.contractor_id')
//            ->where(['ProposedRaBills.id'=>$id])
//            ->where(['scheme_contractors.is_lead'=>1])
//            ->first()
//            ;
//        // approve bills
//        $approve_ra_bills = TableRegistry::get('approve_ra_bills');
//        $approve_bills = $approve_ra_bills->find('all')
//            ->select(['approved_quantity'])
//            ->where(['proposed_ra_bills_id'=>$id])
//            ->hydrate(false)
//            ->toArray();
//        // Arrange approve bills
//        $old_bills = 0;
//        foreach($approve_bills as $bill)
//        {
//            $old_bills+=$bill['approved_quantity'];
//        }
//        // Approve RA bills data save
//        if ($this->request->is(['patch', 'post', 'put']))
//        {
//            $data = $this->request->data;
//            if(($old_bills+$data['approved_quantity']) <= $ra_bills['bill_amount'])
//            {
//                $data['proposed_ra_bills_id'] = $id;
//                $approve_ra_bills = TableRegistry::get('approve_ra_bills');
//                $query = $approve_ra_bills->query();
//                $query->insert(array_keys($data))
//                    ->values($data)
//                    ->execute();
//                $this->Flash->success(__('The RA bill has been Approved.'));
//                return $this->redirect(['action' => 'index']);
//            }
//            else
//            {
//                $this->Flash->error(__('The Approved amount larger than the Bill Amount'));
//            }
//        }
//        $this->set(compact('id','ra_bills'));
//    }
//
//
//    /**
//     * Edit method
//     *
//     * @param string|null $id Proposed Ra Bill id.
//     * @return void Redirects on successful edit, renders view otherwise.
//     * @throws \Cake\Network\Exception\NotFoundException When record not found.
//     */
////    public function edit($id = null)
////    {
////        $user=$this->Auth->user();
////        $proposedRaBill = $this->ProposedRaBills->get($id, [
////            'contain' => []
////        ]);
////        if ($this->request->is(['patch', 'post', 'put']))
////        {
////            $data=$this->request->data;
////            $data['updated_by']=$user['id'];
////            $data['updated_date']=time();
////            $proposedRaBill = $this->ProposedRaBills->patchEntity($proposedRaBill, $data);
////            if ($this->ProposedRaBills->save($proposedRaBill))
////            {
////                $this->Flash->success('The proposed ra bill has been saved.');
////                return $this->redirect(['action' => 'index']);
////            }
////            else
////            {
////                $this->Flash->error('The proposed ra bill could not be saved. Please, try again.');
////            }
////        }
////        $offices = $this->ProposedRaBills->Offices->find('list', ['limit' => 200]);
////        $schemes = $this->ProposedRaBills->Schemes->find('list', ['limit' => 200]);
////        $measurementBooks = $this->ProposedRaBills->MeasurementBooks->find('list', ['limit' => 200]);
////        $createdUser = $this->ProposedRaBills->CreatedUser->find('list', ['limit' => 200]);
////        $updatedUser = $this->ProposedRaBills->UpdatedUser->find('list', ['limit' => 200]);
////        $this->set(compact('proposedRaBill', 'offices', 'schemes', 'measurementBooks', 'createdUser', 'updatedUser'));
////        $this->set('_serialize', ['proposedRaBill']);
////    }
//
//    /**
//     * Delete method
//     *
//     * @param string|null $id Proposed Ra Bill id.
//     * @return void Redirects to index.
//     * @throws \Cake\Network\Exception\NotFoundException When record not found.
//     */
////    public function delete($id = null)
////    {
////
////        $proposedRaBill = $this->ProposedRaBills->get($id);
////
////        $user=$this->Auth->user();
////        $data=$this->request->data;
////        $data['updated_by']=$user['id'];
////        $data['updated_date']=time();
////        $data['status']=99;
////        $proposedRaBill = $this->ProposedRaBills->patchEntity($proposedRaBill, $data);
////        if ($this->ProposedRaBills->save($proposedRaBill))
////        {
////            $this->Flash->success('The proposed ra bill has been deleted.');
////        }
////        else
////        {
////            $this->Flash->error('The proposed ra bill could not be deleted. Please, try again.');
////        }
////        return $this->redirect(['action' => 'index']);
////    }
//
    public function ajax($task = null)
    {
        $user = $this->Auth->user();
        if ($task == 'get_measurement_books') {

            // get measurement id
            $scheme_id = $this->request->data['scheme_id'];
            $Measurements = $this->loadModel('Measurements');
            $ProposedRaBills = $this->loadModel('ProposedRaBills');


            $subquery = $ProposedRaBills->find()
                ->select(['measurement_no'])
                ->where(['scheme_id' => $scheme_id])
                ->toArray();
            $q = [];
            foreach ($subquery as $row) {
                $q = $row['measurement_no'];
            }
            //echo "<pre>";print_r($q);die();
            $data = $Measurements->find('list', ['keyField' => 'measurement_no', 'keyValue' => 'measurement_no'])
                ->distinct(['measurement_no'])
                ->where(['scheme_id' => $scheme_id]);
            if ($q) {
                $data->where(['measurement_no >' => $q])
                    ->toArray();
            } else {
                $data->toArray();
            }


            $this->response->body(json_encode($data));
            return $this->response;
        } elseif ($task == 'get_items') {
            $this->layout = 'ajax';
            $this->view = 'ra_bills';
            $input = $this->request->data;

            // Latest Measurement
            $measurements_table = TableRegistry::get('measurements');
            $last_measurement = true;


            if ($last_measurement) {
                //find item latest measurement wise
                $sub_query = $measurements_table->find();
                $sub_query->select(['s_details_id' => 'scheme_id'])
                    ->select(['max_measurement_no' => $sub_query->func()->max('measurement_no')])
                    ->where(['scheme_id' => $input['scheme_id']])
                    ->group(['scheme_id']);

                $latest_measurements = $measurements_table->find();
                $latest_measurements = $latest_measurements
                    ->select(['id', 'item_id', 'scheme_id', 'measurement_no', 'quantity_of_work_done'])
                    ->join([
                        'table' => $sub_query,
                        'alias' => 'max_measurement',
                        'type' => 'INNER',
                        'conditions' => 'max_measurement.s_details_id = measurements.scheme_id AND max_measurement.max_measurement_no = measurements.measurement_no'
                    ])
                    ->hydrate(false)
                    ->toArray();
                $arrange_latest_measurements = array();
                foreach ($latest_measurements as $key => $latest_measurement) {
                    $arrange_latest_measurements[$latest_measurement['item_id']] = $latest_measurement['quantity_of_work_done'];
                }


                //find scheme_items_details by antu (end of life)
                $scheme_items_table = TableRegistry::get('schemes_items');
                $scheme_details = $scheme_items_table->find('all')
                    ->select(['id', 'description', 'rate', 'item_display_code', 'unit'])
                    ->where(['scheme_id' => $input['scheme_id'], 'status' => 1])
                    ->hydrate(false)
                    ->toArray();

                foreach ($scheme_details as &$scheme_detail) {
                    $sub_query = $measurements_table->find();
                    $sub_query->select(['max_quantity_executed' => $sub_query->func()->max('quantity_of_work_done')])
                        ->where(['scheme_id' => $input['scheme_id'], 'item_id' => $scheme_detail['id'], 'measurement_no <=' => $input['measurement_no']]);
                    $sub_query = $sub_query->first();
                    $scheme_detail['quantity_executed'] = $sub_query['max_quantity_executed'] ? $sub_query['max_quantity_executed'] : 0;
                }

                // find the last RA bills ;
                $ra_bills_table = TableRegistry::get('proposed_ra_bills');
                $last_ra_bills = $ra_bills_table->find()
                    ->select(['measurement_no', 'ra_bill_no'])
                    ->where(['scheme_id' => $input['scheme_id']])
                    ->order(['id' => 'DESC'])
                    ->first();
                // set Current RA Bills No
                $ra_bill_no = (isset($last_ra_bills['ra_bill_no']) ? $last_ra_bills['ra_bill_no'] + 1 : 1);

                //  find the last measurement last ra bill wise
                if ($last_ra_bills)// FOR Quantity Excess or Supplied Sin Last R-A Bill
                {
                    $last_measurement_ra_bill_wise = [];
                    foreach ($scheme_details as &$scheme_detail) {
                        $sub_query = $measurements_table->find();
                        $sub_query->select(['item_id', 'quantity_of_work_done' => $sub_query->func()->max('quantity_of_work_done')])
                            ->where(['scheme_id' => $input['scheme_id'], 'item_id' => $scheme_detail['id'], 'measurement_no <=' => $last_ra_bills['measurement_no']]);
                        $last_measurement_ra_bill_wise[] = $sub_query->first();
                    }

                    // arrange the last RA bills measurement
                    $last_ra_bills_items = [];
                    foreach ($last_measurement_ra_bill_wise as $item) {
                        $last_ra_bills_items[$item['item_id']] = $item['quantity_of_work_done'];
                    }
                }


                //  previous RA Approve bills.....
                $ra_bills_table = TableRegistry::get('proposed_ra_bills');
                $approve_ra_bills = $ra_bills_table->find('all')
                    ->where(['proposed_ra_bills.scheme_id' => $input['scheme_id']])
                    ->hydrate(true)
                    ->toArray();
                $up_to_date_approved = 0;
                foreach ($approve_ra_bills as $approve_ra_bill) {
                    $up_to_date_approved += $approve_ra_bill['approve_bill_amount'];
                }
                //   echo "<pre>";print_r($up_to_date_approved);die();
            }


            $this->set(compact('scheme_details', 'last_measurement', 'last_ra_bills_items', 'up_to_date_approved', 'ra_bill_no'));
        }

        elseif ($task == 'get_final_items') {
            $this->layout = 'ajax';
            $this->view = 'final_ra_bills';
            $input = $this->request->data;

            // Latest Measurement
            $measurements_table = TableRegistry::get('measurements');
            $last_measurement = true;


            if ($last_measurement) {
                //find item latest measurement wise
                $sub_query = $measurements_table->find();
                $sub_query->select(['s_details_id' => 'scheme_id'])
                    ->select(['max_measurement_no' => $sub_query->func()->max('measurement_no')])
                    ->where(['scheme_id' => $input['scheme_id']])
                    ->group(['scheme_id']);

                $latest_measurements = $measurements_table->find();
                $latest_measurements = $latest_measurements
                    ->select(['id', 'item_id', 'scheme_id', 'measurement_no', 'quantity_of_work_done'])
                    ->join([
                        'table' => $sub_query,
                        'alias' => 'max_measurement',
                        'type' => 'INNER',
                        'conditions' => 'max_measurement.s_details_id = measurements.scheme_id AND max_measurement.max_measurement_no = measurements.measurement_no'
                    ])
                    ->hydrate(false)
                    ->toArray();
                $arrange_latest_measurements = array();
                foreach ($latest_measurements as $key => $latest_measurement) {
                    $arrange_latest_measurements[$latest_measurement['item_id']] = $latest_measurement['quantity_of_work_done'];
                }


                //find scheme_items_details by antu (end of life)
                $scheme_items_table = TableRegistry::get('schemes_items');
                $scheme_details = $scheme_items_table->find('all')
                    ->select(['id', 'description', 'rate', 'item_display_code', 'unit','quantity','rate'])
                    ->where(['scheme_id' => $input['scheme_id'], 'status' => 1])
                    ->hydrate(false)
                    ->toArray();

                foreach ($scheme_details as &$scheme_detail) {
                    $sub_query = $measurements_table->find();
                    $sub_query->select(['max_quantity_executed' => $sub_query->func()->max('quantity_of_work_done')])
                        ->where(['scheme_id' => $input['scheme_id'], 'item_id' => $scheme_detail['id'], 'measurement_no <=' => $input['measurement_no']]);
                    $sub_query = $sub_query->first();
                    $scheme_detail['quantity_executed'] = $sub_query['max_quantity_executed'] ? $sub_query['max_quantity_executed'] : 0;
                }

                // find the last RA bills ;
                $ra_bills_table = TableRegistry::get('proposed_ra_bills');
                $last_ra_bills = $ra_bills_table->find()
                    ->select(['measurement_no', 'ra_bill_no'])
                    ->where(['scheme_id' => $input['scheme_id']])
                    ->order(['id' => 'DESC'])
                    ->first();
                // set Current RA Bills No
                $ra_bill_no = (isset($last_ra_bills['ra_bill_no']) ? $last_ra_bills['ra_bill_no'] + 1 : 1);

                //  find the last measurement last ra bill wise
                if ($last_ra_bills)// FOR Quantity Excess or Supplied Sin Last R-A Bill
                {
                    $last_measurement_ra_bill_wise = [];
                    foreach ($scheme_details as &$scheme_detail) {
                        $sub_query = $measurements_table->find();
                        $sub_query->select(['item_id', 'quantity_of_work_done' => $sub_query->func()->max('quantity_of_work_done')])
                            ->where(['scheme_id' => $input['scheme_id'], 'item_id' => $scheme_detail['id'], 'measurement_no <=' => $last_ra_bills['measurement_no']]);
                        $last_measurement_ra_bill_wise[] = $sub_query->first();
                    }

                    // arrange the last RA bills measurement
                    $last_ra_bills_items = [];
                    foreach ($last_measurement_ra_bill_wise as $item) {
                        $last_ra_bills_items[$item['item_id']] = $item['quantity_of_work_done'];
                    }
                }


                //  previous RA Approve bills.....
                $ra_bills_table = TableRegistry::get('proposed_ra_bills');
                $approve_ra_bills = $ra_bills_table->find('all')
                    ->where(['proposed_ra_bills.scheme_id' => $input['scheme_id']])
                    ->hydrate(true)
                    ->toArray();
                $up_to_date_approved = 0;
                foreach ($approve_ra_bills as $approve_ra_bill) {
                    $up_to_date_approved += $approve_ra_bill['approve_bill_amount'];
                }
                //   echo "<pre>";print_r($up_to_date_approved);die();
            }


            $this->set(compact('scheme_details', 'last_measurement', 'last_ra_bills_items', 'up_to_date_approved', 'ra_bill_no'));
        }
    }

//    public function generate_ra_bill($id){
//        echo $id;
//        die();
//    }
}
