<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

//use App\Controller\LabBillsController;

//App::import('Controller','LabBills');


/**
 * HireCharges Controller
 *
 * @property \App\Model\Table\HireChargesTable $HireCharges
 */
class HireChargesController extends AppController
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
     * View method
     *
     * @param string|null $id Hire Charge id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $user = $this->Auth->user();
        $office_id = $this->Auth->user('office_id');
        $hireCharge = $this->HireCharges->get($id, [
            'contain' => ['Schemes', 'Contractors', 'HireChargeDetails', 'FinancialYearEstimates','Offices']
        ]);
        //echo "<pre>";print_r($hireCharge);die();
        $this->loadModel('hire_charge_details');


        $hire_charge_details = $this->hire_charge_details->find()
            ->select(['item_code' => 'schemes_items.item_display_code', 'description' => 'schemes_items.description', 'unit' => 'schemes_items.unit', 'rate' => 'schemes_items.rate', 'quantity_done' => 'hire_charge_details.quantity','item_total' => 'hire_charge_details.item_total'])
            ->where(['hire_charge_details.hire_charge_id' => $id])
            ->leftJoin('schemes_items', 'schemes_items.item_display_code=hire_charge_details.item_code')
            ->where(['schemes_items.scheme_id' => $hireCharge->scheme_id])
            ->toArray();

    //   echo "<pre>";print_r($hire_charge_details);die();
        if ($this->request->is('post') ) {


            $inputs = $this->request->data;
            $arr = array();
            $arr['sender_id'] = $user['id'];
            $arr['subject'] = $inputs['subject'];
            $arr['message_text'] = $inputs['message'];
            $arr['resource_id'] = $id;
            $arr['msg_type'] = 'hireCharges';
            $arr['created_date'] = time();
            $arr['created_by'] = $user['id'];
            $arr['status'] = 1;
            $this->loadModel('MessageRegisters');
            $messageRegisters = $this->MessageRegisters->newEntity();
            $messageRegisters = $this->MessageRegisters->patchEntity($messageRegisters, $arr);
            if ($msg = $this->MessageRegisters->save($messageRegisters)){

                foreach ($inputs['user'] as $user_id) {

                    $this->loadModel('users');
                    $user_info = $this->users->get($user_id);
                    if($user_info->user_group_id ==7 ){

                        $lab_bills = TableRegistry::get('hire_charges');
                        $query = $lab_bills->query();
                        $query->update()
                            ->set(['is_sent_to_accounts' => 1])
                            ->where(['id' => $id])
                            ->execute();
                    }
                    //  echo "<pre>";print_r($user_info);die();

                    $recipient_data['message_register_id'] = $msg['id'];
                    $recipient_data['user_id'] = $user_id;
                    $recipient_data['created_date'] = time();
                    $recipient_data['created_by'] = $user['id'];
                    $recipient_data['status'] = 1;

                    $this->loadModel('Recipients');
                    $recipients = $this->Recipients->newEntity();
                    $recipients = $this->Recipients->patchEntity($recipients, $recipient_data);
                    $result= $this->Recipients->save($recipients);
                    // die();
                }
            }
            if($result){
                $this->Flash->success('Bill sent and save successfully.');
                return $this->redirect(['action' => 'index']);
            }else{
                $this->Flash->error('Bill can not save. Please try again');
                return $this->redirect(['action' => 'index']);
            }

        }

        $this->loadModel('Departments');

        $departments = $this->Departments->find()->hydrate(false)
            ->select(['designations.name_bn', 'users.id', 'users.name_bn', 'Departments.name_bn'])
            ->where(['Departments.office_id' => $office_id])
            ->leftJoin('users', 'users.department_id=Departments.id and users.status=1')
            ->leftJoin('designations', 'designations.id=users.designation_id')
            ->order(['Departments.order_no' => 'asc', 'designations.order_no' => 'asc']);

//        echo '<pre>';
//        print_r($hireCharge);
//        echo '</pre>';
//        die;
        $this->set('hireCharge', $hireCharge);
        $this->set('_serialize', ['hireCharge']);
        $this->set('id',$id);
        $this->set('departments',$departments);
        $this->set('hire_charge_details',$hire_charge_details);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $hireCharge = $this->HireCharges->newEntity();
        $user = $this->Auth->user();
        if ($this->request->is('post'))
        {
            $inputs = $this->request->data;
//            echo '<pre>';
//            print_r($inputs);
//            echo '</pre>';
//            die;
            if(!isset($inputs['items']))
            {
                $this->Flash->error(__('Items can not be null'));
                return $this->redirect(['action' => 'add']);
            }

            if($inputs['net_payable']<=0)
            {
                $this->Flash->error(__('No update there!! '));
                return $this->redirect(['action' => 'add']);
            }
            $hireChargeData['scheme_id'] = $inputs['scheme_id'];
            $hireChargeData['office_id'] = $user['office_id'];
            $hireChargeData['financial_year_id'] = $inputs['financial_year_id'];
            $hireChargeData['total_amount'] = $inputs['total_amount'];
            $hireChargeData['status'] = 1;
            $hireChargeData['net_payable'] = $inputs['net_payable'];
            $hireChargeData['created_by'] = $this->Auth->user(['id']);
            $hireChargeData['created_date'] = time();
            //find lead contractor
            $lead_contractor =  TableRegistry::get('scheme_contractors')->find()->where(['scheme_id'=>$inputs['scheme_id'],'is_lead'=>1])->first();
            $hireChargeData['contractor_id'] = $lead_contractor ? $lead_contractor['contractor_id'] : '';
            $hireCharge = $this->HireCharges->patchEntity($hireCharge, $hireChargeData);
            $hireCharge = $this->HireCharges->save($hireCharge);

            if (!empty($inputs['parent_id'])) {
                $this->loadModel('nothi_assigns');
                $nothi_data = array();
                $nothi_data['nothi_register_id'] = $inputs['parent_id'];
                $nothi_data['hire_charge_id'] = $hireCharge['id'];
                //echo "<pre>";print_r($nothi_data);die();
                $new_nothi = $this->nothi_assigns->newEntity();
               // echo "<pre>";print_r($new_nothi);die();
                $nothi = $this->nothi_assigns->patchEntity($new_nothi, $nothi_data);
              //  echo "<pre>";print_r($nothi);die();
                $this->nothi_assigns->save($nothi);
            }

            if ($hireCharge)
            {
                foreach($inputs['items'] as $item)
                {
                    unset($item['rate']);
                    unset($item['description']);
                    unset($item['item_unit']);

                    $item['hire_charge_id'] = $hireCharge['id'];
                    $item['created_by'] = $this->Auth->user(['id']);
                    $item['created_date'] = time();

                    $hireChargeDetailsData[] = $item;
                }
                $hireChargeDetails = TableRegistry::get('hire_charge_details');
                $hireChargeDetails = $hireChargeDetails->query();
                $hireChargeDetails->insert(array_keys($hireChargeDetailsData[0]));
                foreach($hireChargeDetailsData as $data)
                {
                    $hireChargeDetails->values($data);
                }
                $hireChargeDetails->execute();




                if(isset($inputs['user']))
                {
                    $arr = array();
                    $arr['sender_id'] = $user['id'];
                    $arr['subject'] = $inputs['subject'];
                    $arr['message_text'] = $inputs['message'];
                    $arr['resource_id']=$hireCharge['id'];
                    $arr['msg_type']='hireCharges';
                    $arr['created_date'] = time();
                    $arr['created_by'] = $user['id'];
                    $arr['status'] = 1;
                    $this->loadModel('MessageRegisters');
                    $messageRegisters = $this->MessageRegisters->newEntity();
                    $messageRegisters = $this->MessageRegisters->patchEntity($messageRegisters, $arr);
                    $msg=$this->MessageRegisters->save($messageRegisters);
                    foreach($inputs['user'] as $user_id){
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
                $this->Flash->success('The hire charge has been saved.');
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error('The hire charge could not be saved. Please, try again.');
            }
        }
        $this->loadModel('Departments');
        $departments = $this->Departments->find('all', ['contain' => ['Users', 'Users.Designations'], 'conditions' => ['Departments.office_id' => $user['office_id']]]);
        $schemes = $this->HireCharges->Schemes->find('list',['condition'=>['status'=>1]]);
        $FinancialYearEstimates = $this->HireCharges->FinancialYearEstimates->find('list',['condition'=>['status'=>1]]);

        $this->loadModel('NothiRegisters');
        $nothiRegisters = $this->NothiRegisters->find('list', [
            'conditions' => ['status' => 1, 'parent_id' => 0],
        ])->toArray();
        $this->set(compact('hireCharge', 'schemes','FinancialYearEstimates','departments','nothiRegisters'));
        $this->set('_serialize', ['hireCharge']);
    }
    public function ajax($action = '')
    {
        $this->layout='ajax';
        if($action=='get_item')
        {
            $this->view = 'get_item';
            $item_code = $this->request->data['item_code'];
            $scheme_id = $this->request->data['scheme_id'];
            $financial_year_id = $this->request->data['financial_year_id'];
            $scheme = $this->HireCharges->Schemes->get($scheme_id);

            $item_unit='';
            $item_rate='';
            $item_id='';
            $financial_year_estimate_id='';
            $item_table='';

            //Check the additional_items::
            $additional_items = TableRegistry::get('schemes_items');
            $query = $additional_items->find();
            $query->where(['item_display_code'=>$item_code,'scheme_id'=>$scheme_id]);
            $additional_item_table = $query->first();
          //  echo "<pre>";print_r($additional_item_table);die();
            if($additional_item_table)
            {
                $item_unit = $additional_item_table['unit'];
                $item_rate = $additional_item_table['rate'];
                $item_id = $additional_item_table['id'];
                $description = $additional_item_table['description'];
               // $item_table = 'additional_items';
                $financial_year_estimate_id = $financial_year_id;
            }
            //Check the item_rates::
            else
            {
                $item_rates = TableRegistry::get('item_rates');
                $query = $item_rates->find();
                $query->where(['id'=>$item_code]);
                $query->where(['pic_flag'=>$scheme['pic_flag']]);
                $query->order('financial_year_rate_id desc');
                $item_rates_table = $query->first();

                $financial_year_estimate_id = $item_rates_table['financial_year_rate_id'];
                $item_rate = $item_rates_table['rate'];

                //if item_code found in the items_rate table
                if($item_rates_table)
                {
                    $items = TableRegistry::get('items');
                    $query = $items->find();
                    $query->where(['item_display_code'=>$item_rates_table['id']]);
                    $items_table = $query->first();
                    // check item_code found in the items
                    if($items_table)
                    {
                        $item_unit = $items_table['unit'];
                        $item_id = $items_table['id'];
                        $description = $items_table['description'];
                        $item_table = 'items';
                    }
                    // check item_code found in the minor_items
                    else
                    {
                        $minor_items = TableRegistry::get('minor_items');
                        $query = $minor_items->find();
                        $query->where(['item_display_code'=>$item_rates_table['id']]);
                        $minor_items_table = $query->first();
                        if($minor_items_table)
                        {
                            $item_unit = $minor_items_table['unit'];
                            $item_id = $minor_items_table['minor_item_id'];
                            $description = $minor_items_table['description'];
                            $item_table = 'minor_items';
                        }
                        else
                        {
                            $sub_minor_items = TableRegistry::get('sub_minor_items');
                            $query = $sub_minor_items->find();
                            $query->where(['item_display_code'=>$item_rates_table['id']]);
                            $sub_minor_item_table = $query->first();
                            if($sub_minor_item_table)
                            {
                                $item_unit = $sub_minor_item_table['unit'];
                                $item_id = $sub_minor_item_table['sub_minor_item_id'];
                                $description = $sub_minor_item_table['description'];
                                $item_table = 'sub_minor_items';
                            }
                        }
                    }
                }
                else
                {
                    $item_unit = '';
                    $financial_year_estimate_id = '';
                    $item_id = '';
                    $description = '';
                    $item_table = '';
                }
            }
            //if all data found, assign them
            if($item_id)
            {
                $data['item_unit'] = $item_unit;
                $data['item_rate'] = $item_rate;
                $data['item_id'] = $item_id;
                $data['description'] = $description;
                $data['item_table'] = $item_table;
                $data['financial_year'] = $financial_year_estimate_id;

                $data['item_code']=$item_code;
                $flag = 'new_item';
            }
            else
            {
                $flag = false;
            }
            $this->set(compact('flag','data'));
        }
        elseif($action == 'get_scheme_wise_items')
        {
            $this->view = 'get_old_item';
            $last_hire_charge=TableRegistry::get('measurements')->find()
                ->where(['scheme_id'=>$this->request->data(['scheme_id'])])
                ->order(['id'=>'DESC'])
                ->first();


            $data=TableRegistry::get('measurements')->find()
                ->select(['quantity'=>'measurements.quantity_of_work_done',
                    'item_code'=>'schemes_items.item_display_code',
                    'description'=>'schemes_items.description',
                    'item_unit'=>'schemes_items.unit',
                    'rate'=>'schemes_items.rate'
                  ])

                ->where(['measurements.scheme_id'=>$this->request->data(['scheme_id']),'measurements.measurement_no'=>$last_hire_charge['measurement_no']])
                ->leftJoin('schemes_items', 'schemes_items.id=measurements.item_id');

            $last_hire_charge_details= $data->toArray();
               //->autoFields(true);

          //  echo "<pre>";print_r($last_hire_charge_details->toArray());die();

            $last_hire_charge = $this->HireCharges->find('all')
                ->where(['scheme_id'=>$this->request->data(['scheme_id'])])
                ->order(['id'=>'DESC'])
                ->first();
//            if($last_hire_charge)
//            {
//                $hire_charge_items = $this->HireCharges->HireChargeDetails->find('all')
//                    ->where(['hire_charge_id'=>$last_hire_charge['id']]);
//            }
          $this->set(compact('hire_charge_items','last_hire_charge_details','last_hire_charge'));
        }
        elseif($action == 'grid')
        {
            $hire_charges = $this->HireCharges->find('all')->contain(['Schemes','FinancialYearEstimates'])->toArray();
            $data = array();
            foreach($hire_charges as $hire_charge)
            {
                $data[] = ['id'=>$hire_charge['id'],
                'total_amount'=>$hire_charge['total_amount'],
                'financial_year_estimate'=>$hire_charge['financial_year_estimate']['name'],
                'scheme'=>$hire_charge['scheme']['name_en'],
                'actions'=>'<a title="'.__('View').'" class="icon-newspaper" href="'.$this->request->webroot.'HireCharges/view/'.$hire_charge['id'].'" ></a>'
                ];
            }
            $this->response->body(json_encode($data));
            return $this->response;
        }
    }
    public  function hire_charge_by_scheme($scheme_id){
        if($this->user_roles['index'])
        {
        $hireCharge = $this->HireCharges->find('all', [
            'conditions'=>['scheme_id'=>$scheme_id],
            'order'=>['id'=>'DESC']
        ])->first();
            if($hireCharge)
            {
                return $this->redirect(
                    ['controller' => 'hire_charges', 'action' =>'view',$hireCharge['id']]
                );
            }
            else
            {
                $this->Flash->success('No Hire charge has been Found');
                return $this->redirect(['controller' => 'dashboard','action' => 'index']);
            }
        }
        else
        {
            $this->Flash->error('You dont have access to the task');
            return $this->redirect(['controller'=>'dashboard','action' => 'index']);
        }
    }

}
