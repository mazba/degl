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
                'contain' => ['Offices', 'Schemes'],
                'order' => ['ProposedRaBills.id' => 'DESC']
            ]);
        } else {
            $proposedRaBills = $this->ProposedRaBills->find('all', [
                // 'conditions' => ['ProposedRaBills.status !=' => 99],
                'conditions' => ['ProposedRaBills.office_id =' => $user['office_id']],
                'contain' => ['Offices', 'Schemes']
            ]);
        }

        $proposedRaBills = $proposedRaBills->toArray();
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
            } else {
                $arranged_bills[$bill['proposed_ra_bills_id']] = $bill['approved_quantity'];
            }
        }
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
        $this->loadModel('Measurements');
        $proposedRaBill = $this->ProposedRaBills->get($id);
        $bill_type = $proposedRaBill['bill_type'];
        if($bill_type == 2){
            $bill_type = 'Final';
        }
        else{
            $bill_type = null;
        }
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

//        $scheme_details = TableRegistry::get('ra_bill_details')->find('all')
//            //  ->select(['id', 'description', 'rate', 'item_display_code', 'unit','quantity','rate'])
//
//            ->select(['id' => 'schemes_items.id', 'description' => 'ra_bill_details.short_description', 'rate' => 'schemes_items.rate', 'item_display_code' => 'schemes_items.item_display_code', 'unit' => 'schemes_items.unit', 'quantity' => 'schemes_items.quantity'])
//            ->where(['ra_bill_id' => $proposedRaBill['id']])
//            ->leftJoin('schemes_items', 'schemes_items.id = ra_bill_details.scheme_item_id')
//            ->hydrate(false)
//            ->toArray();
////echo "<pre>";print_r($scheme_details);die();
//
//        foreach ($scheme_details as &$scheme_detail) {
//
//            $sub_query = $measurements_table->find();
//            $sub_query->select(['max_quantity_executed' => $sub_query->func()->max('quantity_of_work_done')])
//                ->where(['scheme_id' =>  $proposedRaBill['scheme_id'], 'item_id' => $scheme_detail['id'], 'measurement_no <=' => $proposedRaBill['measurement_no']]);
//            $sub_query = $sub_query->first();
//            $scheme_detail['quantity_executed'] = $sub_query['max_quantity_executed'] ? $sub_query['max_quantity_executed'] : 0;
//
//        }
// select scheme measurements
        $measurements_data =   $this->Measurements->find()
            ->select(['id', 'item_id', 'scheme_id', 'measurement_no', 'quantity_of_work_done'])
            ->where(['scheme_id' => $proposedRaBill['scheme_id']])
//                    ->order(['item_id' => 'ASC'])
            ->hydrate(false)
            ->toArray();
        $i = 0;
        foreach($measurements_data as $datum){
            $measurements[$datum['item_id']]['item'][$i]['id'] = $datum['id'];
            $measurements[$datum['item_id']]['item'][$i]['item_id'] = $datum['item_id'];
            $measurements[$datum['item_id']]['item'][$i]['measurement_no'] = $datum['measurement_no'];
            $measurements[$datum['item_id']]['item'][$i]['quantity_of_work_done'] = $datum['quantity_of_work_done'];
            $i +=1;
        }
        $this->loadModel('Schemes');
        $others_info = $this->Schemes->find()
            ->where(['Schemes.id' => $proposedRaBill['scheme_id']])
            ->contain(['Packages', 'SchemeContractors.Contractors','Districts','Upazilas'])
            ->first();
        //find scheme_items_details
        $scheme_items_table = TableRegistry::get('schemes_items');
        $scheme_details = $scheme_items_table->find('all')
            ->select(['id', 'description', 'rate', 'item_display_code', 'unit','quantity','rate'])
            ->where(['scheme_id' => $proposedRaBill['scheme_id'], 'status' => 1])
            ->hydrate(false)
            ->toArray();
        // scheme item and measurement bind by loop
        foreach($scheme_details as $scheme_detail){
            foreach($measurements as $key => &$measurement){
                if($key == $scheme_detail['id']){
                    $measurement['description'] = $scheme_detail['description'];
                    $measurement['rate'] = $scheme_detail['rate'];
                    $measurement['item_display_code'] = $scheme_detail['item_display_code'];
                    $measurement['unit'] = $scheme_detail['unit'];
                    $measurement['quantity'] = $scheme_detail['quantity'];
                }
            }
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
        $this->set(compact('up_to_date_approved', 'proposedRaBill', 'scheme_details', 'last_measurement', 'last_ra_bills_items', 'up_to_date_approved', 'ra_bill_no','measurements','bill_type','others_info'));

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
        if ($this->request->is('post')) {
            $data = $this->request->data;
//            pr($data['previous_value']);die;
            $data['office_id'] = $user['office_id'];
            $data['created_by'] = $user['id'];
            $data['created_date'] = time();
            $proposedRaBill = $this->ProposedRaBills->patchEntity($proposedRaBill, $data);
            $ra_bill_id = $this->ProposedRaBills->save($proposedRaBill);
            // process report data
            $this->loadModel('ProcessedReports');
            if(!empty(trim($data['previous_value']))){
                $ProcessedReport = $this->ProcessedReports->get($data['previous_value']);
            }else{
                $ProcessedReport = $this->ProcessedReports->newEntity();
            }
            $inputs['processed_ra_bill_id'] = $ra_bill_id['id'];
            $inputs['scheme_id'] = $data['scheme_id'];
            $inputs['do_commencement'] = strtotime($data['do_commencement']);
            $inputs['do_completion'] = strtotime($data['do_completion']);
            $inputs['edo_completion'] = strtotime($data['edo_completion']);
            $inputs['ado_completion'] = strtotime($data['ado_completion']);
            $inputs['status'] = 1;
            $ProcessedReport = $this->ProcessedReports->patchEntity($ProcessedReport, $inputs);
            $ProcessedReport = $this->ProcessedReports->save($ProcessedReport);

            foreach ($data['details'] as $row) {
                $this->loadModel('RaBillDetails');
                $ra_bill_detail = $this->RaBillDetails->newEntity();
                $value['ra_bill_id'] = $ra_bill_id['id'];
                $value['scheme_item_id'] = $row['scheme_item_id'];
                $value['short_description'] = $row['short_description'];
                $value['serial_number'] = $row['serial_number'];

                $ra_bill_detail = $this->RaBillDetails->patchEntity($ra_bill_detail, $value);
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
        $this->set(compact('proposedRaBill', 'schemes', 'measurementBooks', 'departments'));
        $this->set('_serialize', ['proposedRaBill']);
    }

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
        }


        elseif ($task == 'get_items') {
            $this->layout = 'ajax';
            $this->view = 'final_ra_bills';
            $input = $this->request->data;
            // Latest Measurement
            $measurements_table = TableRegistry::get('measurements');
            $last_measurement = true;

            $this->loadModel('ProcessedReports');
            $processReport = $this->ProcessedReports->find()
                ->where(['scheme_id' => $input['scheme_id']])
                ->first();
//            pr($processReport);die;
            if ($last_measurement) {
                $this->loadModel('Measurements');
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

                // select scheme measurements
                $measurements_data =   $this->Measurements->find()
                    ->select(['id', 'item_id', 'scheme_id', 'measurement_no', 'quantity_of_work_done'])
                    ->where(['scheme_id' => $input['scheme_id']])
//                    ->order(['item_id' => 'ASC'])
                    ->hydrate(false)
                    ->toArray();
                $i = 0;
                foreach($measurements_data as $datum){
                    $measurements[$datum['item_id']]['item'][$i]['id'] = $datum['id'];
                    $measurements[$datum['item_id']]['item'][$i]['item_id'] = $datum['item_id'];
                    $measurements[$datum['item_id']]['item'][$i]['measurement_no'] = $datum['measurement_no'];
                    $measurements[$datum['item_id']]['item'][$i]['quantity_of_work_done'] = $datum['quantity_of_work_done'];
                    $i +=1;
                }

                //find scheme_items_details
                $scheme_items_table = TableRegistry::get('schemes_items');
                $scheme_details = $scheme_items_table->find('all')
                    ->select(['id', 'description', 'rate', 'item_display_code', 'unit','quantity','rate'])
                    ->where(['scheme_id' => $input['scheme_id'], 'status' => 1])
                    ->hydrate(false)
                    ->toArray();
                // scheme item and measurement bind by loop
                foreach($scheme_details as $scheme_detail){
                    foreach($measurements as $key => &$measurement){
                        if($key == $scheme_detail['id']){
                            $measurement['description'] = $scheme_detail['description'];
                            $measurement['rate'] = $scheme_detail['rate'];
                            $measurement['item_display_code'] = $scheme_detail['item_display_code'];
                            $measurement['unit'] = $scheme_detail['unit'];
                            $measurement['quantity'] = $scheme_detail['quantity'];
                        }
                    }
                }
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
            $scheme_id = $input['scheme_id'];
            $bil_type = null;
            $this->set(compact('scheme_details', 'last_measurement', 'last_ra_bills_items', 'up_to_date_approved', 'ra_bill_no','measurements','bil_type','scheme_id','processReport'));
        }

        elseif ($task == 'get_final_items') {
            $this->layout = 'ajax';
            $this->view = 'final_ra_bills';
            $input = $this->request->data;

            // Latest Measurement
            $measurements_table = TableRegistry::get('measurements');
            $last_measurement = true;

            // process report
            $this->loadModel('ProcessedReports');
            $processReport = $this->ProcessedReports->find()
                ->where(['scheme_id' => $input['scheme_id']])
                ->first();

            if ($last_measurement) {
                $this->loadModel('Measurements');
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

                // select scheme measurements
                $measurements_data =   $this->Measurements->find()
                    ->select(['id', 'item_id', 'scheme_id', 'measurement_no', 'quantity_of_work_done'])
                    ->where(['scheme_id' => $input['scheme_id']])
//                    ->order(['item_id' => 'ASC'])
                    ->hydrate(false)
                    ->toArray();
                $i = 0;
                foreach($measurements_data as $datum){
                    $measurements[$datum['item_id']]['item'][$i]['id'] = $datum['id'];
                    $measurements[$datum['item_id']]['item'][$i]['item_id'] = $datum['item_id'];
                    $measurements[$datum['item_id']]['item'][$i]['measurement_no'] = $datum['measurement_no'];
                    $measurements[$datum['item_id']]['item'][$i]['quantity_of_work_done'] = $datum['quantity_of_work_done'];
                    $i +=1;
                }

                //find scheme_items_details
                $scheme_items_table = TableRegistry::get('schemes_items');
                $scheme_details = $scheme_items_table->find('all')
                    ->select(['id', 'description', 'rate', 'item_display_code', 'unit','quantity','rate'])
                    ->where(['scheme_id' => $input['scheme_id'], 'status' => 1])
                    ->hydrate(false)
                    ->toArray();
                // scheme item and measurement bind by loop
                foreach($scheme_details as $scheme_detail){
                    foreach($measurements as $key => &$measurement){
                        if($key == $scheme_detail['id']){
                            $measurement['description'] = $scheme_detail['description'];
                            $measurement['rate'] = $scheme_detail['rate'];
                            $measurement['item_display_code'] = $scheme_detail['item_display_code'];
                            $measurement['unit'] = $scheme_detail['unit'];
                            $measurement['quantity'] = $scheme_detail['quantity'];
                        }
                    }
                }

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
            $scheme_id = $input['scheme_id'];
            $bil_type = 'Final';
            $this->set(compact('scheme_details', 'last_measurement', 'last_ra_bills_items', 'up_to_date_approved', 'ra_bill_no','measurements','bil_type','scheme_id','processReport'));
        }
    }
}
