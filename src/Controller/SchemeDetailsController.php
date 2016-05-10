<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * SchemeDetails Controller
 *
 * @property \App\Model\Table\SchemeDetailsTable $SchemeDetails
 */
class SchemeDetailsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
//        $schemes = $this->SchemeDetails->Schemes->find('all', [
//            'conditions' =>['Schemes.status !=' => 99,'Schemes.status !=' => 4],
//            'contain' => ['Projects','Districts']
//        ]);

        $user=$this->Auth->user();
        if($user['user_group_id'] == 1)
        {
            $schemes = $this->SchemeDetails->Schemes->find('all', [
                'conditions' =>['Schemes.status !=' => 99],
                'contain' => ['Projects','Districts']
            ])
                ->toArray();
            foreach($schemes as &$scheme)
            {
                $scheme['district'] = $scheme->district['name_en'];
                $scheme['project'] = $scheme->project['name_en'];
            }
        }
        else
        {
            $schemes = $this->SchemeDetails->Schemes->find('all')
                ->autoFields(true)
                ->select(['projects.name_en','districts.name_en'])
                ->distinct(['Schemes.id'])
                ->innerJoin('project_offices', 'project_offices.project_id = Schemes.project_id')
                ->leftJoin('projects', 'projects.id = Schemes.project_id')
                ->leftJoin('districts', 'districts.id = Schemes.district_id')
                ->where(['project_offices.office_id'=>$user['office_id'],'Schemes.status !=' =>99])
                ->where(['Schemes.status !=' =>4])
                ->toArray();
            foreach($schemes as &$scheme)
            {
                $scheme['project'] = $scheme['projects']['name_en'];
                $scheme['district'] = $scheme['districts']['name_en'];
            }
        }

        $this->set('schemes', $schemes);
        $this->set('_serialize', ['schemes']);
    }

    public function view($id = null)
    {
        $scheme = $this->SchemeDetails->Schemes->get($id, [
            'contain' => ['CreatedUser', 'UpdatedUser','Projects','Districts', 'Upazilas', 'Municipalities', 'FinancialYearEstimates']
        ]);
        // CURRENT scheme details
        $scheme_details = $this->SchemeDetails->find('all',[
            'conditions'=>['scheme_id'=>$id,'status'=>1]
        ])->toArray();
        $item_code_wise_scheme_details = array();
        foreach($scheme_details as $scheme_detail)
        {
           $item_code_wise_scheme_details[$scheme_detail['item_code']]['item_id'] = $scheme_detail['item_id'];
           $item_code_wise_scheme_details[$scheme_detail['item_code']]['item_table'] = $scheme_detail['item_table'];
           $item_code_wise_scheme_details[$scheme_detail['item_code']]['item_code'] = $scheme_detail['item_code'];
           $item_code_wise_scheme_details[$scheme_detail['item_code']]['item_unit'] = $scheme_detail['item_unit'];
           $item_code_wise_scheme_details[$scheme_detail['item_code']]['rate'] = $scheme_detail['rate'];
           $item_code_wise_scheme_details[$scheme_detail['item_code']]['financial_year'] = $scheme_detail['financial_year'];
           $item_code_wise_scheme_details[$scheme_detail['item_code']]['rows'][]=$scheme_detail;
        }
        // REMARKS of the scheme
        $scheme_remarks = TableRegistry::get('scheme_remarks')
            ->find()
            ->where(['scheme_id'=>$id])
            ->toArray();
        // CONDUCTORS of scheme
        $scheme_conductors = TableRegistry::get('scheme_contractors')
            ->find()
            ->select(['contractors.contact_person_name','contractors.mobile','contractors.contractor_title','scheme_contractors.is_lead'])
            ->where(['scheme_id'=>$id])
            ->join([
                    'table' => 'contractors',
                    'type' => 'LEFT',
                    'conditions' => 'contractors.id = scheme_contractors.contractor_id',

            ])
            ->toArray();
        // REVISE history

        $revise_schemes = $this->SchemeDetails->find('all',[
            'conditions'=>['scheme_id'=>$id,'status'=>0]
        ])->toArray();
        $item_code_wise_revise_scheme =array();
        foreach($revise_schemes as $revise_scheme)
        {
           $item_code_wise_revise_scheme[$revise_scheme['item_code']][$revise_scheme['updated_date']][] = $revise_scheme;
        }

        // DAK file of the scheme
        $this->loadModel('ReceiveFileRegisters');
        $files = $this->ReceiveFileRegisters
                ->find()
                ->select(['ReceiveFileRegisters.id','ReceiveFileRegisters.sender_name','ReceiveFileRegisters.letter_no','files.file_path'])
                ->where(['scheme_id'=>$id])
                ->where(['files.table_name'=>'receive_file_registers'])
                ->join([
                    'table' => 'files',
                    'type' => 'INNER',
                    'conditions' => 'files.table_key = ReceiveFileRegisters.id',

                ])
                ->toArray();
        $dak_files = array();
        foreach($files as $file)
        {
            $dak_files[$file['id']]['sender_name'] = $file['sender_name'];
            $dak_files[$file['id']]['letter_no'] = $file['letter_no'];
            $dak_files[$file['id']]['file_paths'][] = $file['files']['file_path'];
        }
        $this->set(compact('scheme','item_code_wise_scheme_details','scheme_remarks','scheme_conductors','item_code_wise_revise_scheme','dak_files'));
        $this->set('_serialize', ['schemeDetail']);
    }

    public function edit($id = null)
    {
        $scheme = $this->SchemeDetails->Schemes->get($id);
        if(!($scheme['approved']) && ($scheme['status'] == 1))
        {
            $user=$this->Auth->user();
            if ($this->request->is(['patch', 'post', 'put']))
            {
                $inputs = $this->request->data;
               if($inputs)
               {
                   // delete old scheme data
                   $SchemeDetails = $this->SchemeDetails;
                   $query = $SchemeDetails->query();
                   $query->delete()
                       ->where(['scheme_id' => $id])
                       ->where(['item_code' => $inputs['item_code']])
                       ->execute();
                   // now save new scheme items
                   $data = array();
                   if(isset($inputs['item_element']))
                   {
                       $query = $this->SchemeDetails->query();
                       $field = ['details','deducation','comp_serial_no','component_location','item_quantity','rate','total','remarks',
                           'has_breakup','cl_length','cl_width','cl_height_depth','cl_area_volume','item_code','item_unit',
                           'financial_year','scheme_id','scheme_status','item_id','item_table','created_by','created_date','status'];
                       $query->insert($field);

                       foreach($inputs['item_element'] as $items)
                       {
                           $data = array();
                           $data = $items;
                           $data['item_quantity'] = (isset($items['item_quantity']) ? $items['item_quantity']: '');
                           $data['cl_length'] = (isset($items['cl_length']) ? $items['cl_length']: '');
                           $data['cl_width'] = (isset($items['cl_width']) ? $items['cl_width']: '');
                           $data['cl_height_depth'] = (isset($items['cl_height_depth']) ? $items['cl_height_depth']: '');
                           $data['cl_area_volume'] = (isset($items['cl_area_volume']) ? $items['cl_area_volume']: '');

                           $data['item_code'] = $inputs['item_code'];
                           $data['item_unit'] = $inputs['item_unit'];
                           $data['financial_year'] = $inputs['financial_year'];
                           $data['scheme_id'] = $id;
                           $data['scheme_status'] = 1;
                           $data['item_id'] = $inputs['item_id'];
                           $data['item_table'] = $inputs['item_table'];
                           $data['details'] = $inputs['item_description'];
                           $data['created_by'] = $user['id'];
                           $data['created_date'] = time();
                           $data['status'] = 1;
                           $query->values($data);
                       }
                       $query->execute();
                       $this->Flash->success(__('The scheme details has been Update/Saved.'));
                       //return $this->redirect(['action' => 'index']);
                   }
                   else
                   {
                       $this->Flash->success(__('The Scheme items removed'));
                       //return $this->redirect(['action' => 'index']);
                   }
               }
               else
               {
                   $this->Flash->error(__('No input supplied'));
               }

            }

            $scheme = $this->SchemeDetails->Schemes->get($id, [
                'contain' => ['Projects','Districts', 'Upazilas', 'Municipalities', 'FinancialYearEstimates']
            ]);

            $this->set(compact('scheme'));
        }
        else
        {
            $this->Flash->error(__('The scheme can not be edit.'));
            return $this->redirect(['action' => 'index']);
        }
    }

    public function approve($id = null)
    {
        if(!($this->get_access($this->user_roles,'edit')))
        {
            $this->Flash->error(__('You don\'t have access to the task'));
            return $this->redirect(['controller' => 'Dashboard','action' => 'index']);
        }
        $scheme = $this->SchemeDetails->Schemes->get($id);
        if($scheme['status'] == 1)
        {
            $this->loadModel('Schemes');//also update scheme items table
            $scheme = $this->Schemes->get($id);
            if($this->request->is(['patch', 'post', 'put']))
            {
                $user = $this->Auth->user();
                $data = $this->request->data;
                $data['proposed_start_date'] = strtotime($data['proposed_start_date']);
                $data['expected_complete_date'] = strtotime($data['expected_complete_date']);
                $data['tender_date'] = strtotime($data['tender_date']);
                $data['updated_by'] = $user['id'];
                $data['updated_date'] = time();
                $data['approved'] = 1;

                $scheme = $this->Schemes->patchEntity($scheme, $data);
                // save the remarks in the remarks table
                if($data['remarks'])
                {
                    $files_table = TableRegistry::get('scheme_remarks');
                    $remarks_data['scheme_id'] = $id;
                    $remarks_data['remarks'] = $data['remarks'];
                    $remarks_data['remarks_type'] = 'scheme_approve';
                    $remarks_data['user_id'] =  $user['id'];
                    $remarks_data['created_by'] =  $user['id'];
                    $remarks_data['created_date'] =  time();

                    $file_query = $files_table->query();
                    $file_query->insert(array_keys($remarks_data))
                        ->values($remarks_data)
                        ->execute();
                }

                if ($this->Schemes->save($scheme))
                {
                    $this->Flash->success(__('The scheme has been approved.'));
                }
                else
                {
                    $this->Flash->error(__('The scheme cannot be approved.'));
                }
                return $this->redirect(['action' => 'index']);
            }
            $this->set(compact('scheme'));
        }
    }

    public function assign($id = null)
    {
        if(!($this->get_access($this->user_roles,'edit')))
        {
            $this->Flash->error(__('You don\'t have access to the task'));
            return $this->redirect(['controller' => 'Dashboard','action' => 'index']);
        }
        $this->loadModel('Schemes');//also update scheme items table
        $scheme = $this->Schemes->get($id);
        $this->loadModel('Contractors');
        $contractors = $this->Contractors->find('all', ['fields' => ['id', 'contractor_title']]);

        if($scheme['approved'] == 1 && $scheme['assigned'] != 1)
        {
            if($this->request->is(['patch', 'post', 'put']))
            {
                $tender_documents = array();
                $tender_notices = array();
                $tender_contracts = array();

                $file_upload_complete = true;

                $base_upload_path = WWW_ROOT.'files/contractor';
                // upload tender_documents:::
                for($i=0; $i<sizeof($_FILES['tender_documents']['name']); $i++)
                {
                    $tmp_name = $_FILES['tender_documents']['tmp_name'][$i];
                    //Get the temp file path
                    if($tmp_name)
                    {

                        $name = time().'_'.str_replace(' ','_',$_FILES['tender_documents']['name'][$i]);
                        if(move_uploaded_file($tmp_name, $base_upload_path.'/'.$name))
                        {
                            $tender_documents[]['file_path']=$name;
                        }
                        else
                        {
                            $file_upload_complete=false;
                            break;
                        }
                    }
                }
                // upload tender notices:::
                for($i=0; $i<sizeof($_FILES['tender_notices']['name']); $i++)
                {
                    $tmp_name = $_FILES['tender_notices']['tmp_name'][$i];
                    //Get the temp file path
                    if($tmp_name)
                    {

                        $name = time().'_'.str_replace(' ','_',$_FILES['tender_notices']['name'][$i]);
                        if(move_uploaded_file($tmp_name, $base_upload_path.'/'.$name))
                        {
                            $tender_notices[]['file_path']=$name;
                        }
                        else
                        {
                            $file_upload_complete=false;
                            break;
                        }
                    }
                }
                // upload tender contracts:::
                for($i=0; $i<sizeof($_FILES['tender_contracts']['name']); $i++)
                {
                    $tmp_name = $_FILES['tender_contracts']['tmp_name'][$i];
                    //Get the temp file path
                    if($tmp_name)
                    {

                        $name = time().'_'.str_replace(' ','_',$_FILES['tender_contracts']['name'][$i]);
                        if(move_uploaded_file($tmp_name, $base_upload_path.'/'.$name))
                        {
                            $tender_contracts[]['file_path']=$name;
                        }
                        else
                        {
                            $file_upload_complete=false;
                            break;
                        }
                    }
                }

                // SAVE THE DATA
                if($file_upload_complete)
                {
                    $user = $this->Auth->user();
                    $data = $this->request->data;

                    // save data into scheme table
                    $scheme_data['actual_start_date'] = strtotime($data['actual_start_date']);
                    $scheme_data['assigned'] = 1;
                    $scheme_data['updated_by'] = $user['id'];
                    $scheme_data['updated_date'] = time();

                    $scheme = $this->Schemes->patchEntity($scheme, $scheme_data);

                    if($this->Schemes->save($scheme))
                    {
                        $scheme_contractors = TableRegistry::get('scheme_contractors');

                        $all_contractor = $data['contractors'];
                        $lead_contractor = $data['lead_contractor'];

                        //if lead contractor already assigned
                        if(!in_array($data['lead_contractor'],$all_contractor))
                        {
                            $all_contractor[] =  $lead_contractor;
                        }
                        //save scheme_contractor
                        foreach($all_contractor as $contractor)
                        {
                            $contractor_data['scheme_id'] = $id;
                            $contractor_data['contractor_id'] = $contractor;
                            $contractor_data['is_lead'] = ($contractor==$lead_contractor) ? 1 : '';

                            $file_query = $scheme_contractors->query();
                            $file_query->insert(array_keys($contractor_data))
                                ->values($contractor_data)
                                ->execute();
                        }

                        //:::::: save contractor files in files table ::::

                        $files_table = TableRegistry::get('files');
                        // save tender_documents
                        foreach($tender_documents as $file)
                        {
                            $file_data=array();
                            $file_data['file_path']=$file['file_path'];
                            $file_data['table_name']='scheme_tender_documents';
                            $file_data['table_key'] = $id;
                            $file_data['created_by']= $user['id'];
                            $file_data['created_date']= time();
                            $file_data['status']= 1;
                            $file_query = $files_table->query();
                            $file_query->insert(array_keys($file_data))
                                ->values($file_data)
                                ->execute();
                        }
                        // save tender_notices
                        foreach($tender_notices as $file)
                        {
                            $file_data=array();
                            $file_data['file_path']=$file['file_path'];
                            $file_data['table_name']='scheme_tender_notices';
                            $file_data['table_key'] = $id;
                            $file_data['created_by']= $user['id'];
                            $file_data['created_date']= time();
                            $file_data['status']= 1;
                            $file_query = $files_table->query();
                            $file_query->insert(array_keys($file_data))
                                ->values($file_data)
                                ->execute();
                        }
                        // save tender_contracts
                        foreach($tender_contracts as $file)
                        {
                            $file_data=array();
                            $file_data['file_path'] = $file['file_path'];
                            $file_data['table_name']='scheme_tender_contracts';
                            $file_data['table_key'] = $id;
                            $file_data['created_by']= $user['id'];
                            $file_data['created_date']= time();
                            $file_data['status']= 1;
                            $file_query = $files_table->query();
                            $file_query->insert(array_keys($file_data))
                                ->values($file_data)
                                ->execute();
                        }


                        //:::::: save remarks scheme remarks table ::::

                        $files_table = TableRegistry::get('scheme_remarks');
                        if($data['remarks'])
                        {
                            $remarks_data['scheme_id'] = $id;
                            $remarks_data['remarks'] = $data['remarks'];
                            $remarks_data['remarks_type'] = 'scheme_assign';
                            $remarks_data['user_id'] =  $user['id'];
                            $remarks_data['created_by'] =  $user['id'];
                            $remarks_data['created_date'] =  time();

                            $file_query = $files_table->query();
                            $file_query->insert(array_keys($remarks_data))
                                ->values($remarks_data)
                                ->execute();
                        }

                        $this->Flash->success(__('The scheme has been assigned.'));
                        return $this->redirect(['action' => 'index']);

                    }
                    else
                    {
                        $this->Flash->error(__('The scheme has can not assigned'));
                    }
                }
                else
                {
                    $this->Flash->error(__('File Upload Error. Please, try again.'));
                }
            }
            $this->set(compact('scheme','contractors','id'));
        }
        else
        {
            $this->Flash->error(__('The scheme is not approved.'));
            return $this->redirect(['action' => 'index']);
        }
    }

    public function revise($id = null)
    {
        if(!($this->get_access($this->user_roles,'edit')))
        {
            $this->Flash->error(__('You dont have access to the task'));
            return $this->redirect(['controller' => 'Dashboard','action' => 'index']);
        }
        $scheme = $this->SchemeDetails->Schemes->get($id, [
            'contain' => ['Districts', 'Upazilas', 'Municipalities']
        ]);

        if($scheme['approved'] == 1 && $scheme['assigned'] == 1 && $scheme['status'] != 4)
        {
            if($this->request->is(['patch', 'post', 'put']))
            {
                $user = $this->Auth->user();
                $inputs = $this->request->data;
//                echo '<pre>';
//                print_r($inputs);
//                echo '</pre>';
//                die;
                $time = time();
                //update new data
                $scheme_data = $inputs['scheme'];
                $scheme_data['proposed_start_date'] = strtotime($inputs['scheme']['proposed_start_date']);
                $scheme_data['tender_date'] = strtotime($inputs['scheme']['tender_date']);
                $scheme_data['expected_complete_date'] = strtotime($inputs['scheme']['expected_complete_date']);
                $scheme_data['actual_start_date'] = strtotime($inputs['scheme']['actual_start_date']);
                $scheme_data['actual_complete_date'] = strtotime($inputs['scheme']['actual_complete_date']);
                $scheme_data['updated_date'] = $time;
                $scheme_data['updated_by'] = $user['id'];
                $scheme = $this->SchemeDetails->Schemes->patchEntity($scheme, $scheme_data);

                if ($this->SchemeDetails->Schemes->save($scheme))
                {
                    if(isset($inputs['item_code']))
                    {
                        // find and status 0 to old scheme
                        $SchemeDetails = $this->SchemeDetails;
                        $data['updated_date'] = $time;
                        $data['updated_by'] = $user['id'];
                        $data['status'] = 0;
                        $query = $SchemeDetails->query();
                            $query->update();
                            $query->set($data);
                            $query->where(['item_code'=>$inputs['item_code'],'scheme_id'=>$id]);
                            $query->where(['status'=>1]);
                            $query->execute();
                        if(isset($inputs['item_element']))
                        {
                            // now save the new items
                            foreach($inputs['item_element'] as $item)
                            {
                                $data = array();
                                $data = $item;;
                                $data['scheme_id'] = $id;
                                $data['scheme_status'] = 1;
                                $data['item_id'] = $inputs['item_id'];
                                $data['item_unit'] = $inputs['item_unit'];
                                $data['financial_year'] = $inputs['financial_year'];
                                $data['item_code'] = $inputs['item_code'];
                                $data['item_table'] = $inputs['item_table'];
                                $data['details'] = $inputs['item_description'];
                                $data['created_by'] = $user['id'];
                                $data['created_date'] = $time;
                                $data['status'] = 1;
                                $query = $SchemeDetails->query();
                                $query->insert(array_keys($data));
                                $query->values($data);
                                $query->execute();
                            }
                        }
                    }
                }
                else
                {
                    $this->Flash->error(__('The Scheme cannot Revised.'));
                }
                $this->Flash->success(__('The scheme has been Revised.'));
                return $this->redirect(['action' => 'index']);
            }
            // Scheme Details for view
            $districts = $this->SchemeDetails->Schemes->Districts->find('all', ['fields' => ['id', 'name_en']]);
            $municipalities = $this->SchemeDetails->Schemes->Municipalities->find('all', ['fields' => ['id', 'name_en']])
                             ->where('district_id',$scheme['district_id']);
            $upazilas = $this->SchemeDetails->Schemes->Upazilas->find('all', ['fields' => ['id', 'name_en']])
                             ->where('district_id',$scheme['district_id']);

            $this->set(compact('scheme','id','districts','municipalities','upazilas'));
        }
        else
        {
            $this->Flash->error(__('The scheme is not approved/assigned.'));
            return $this->redirect(['action' => 'index']);
        }
    }

    public function ajax($task)
    {
        $this->layout='ajax';
        if($task=='get_item')
        {
            $this->view = 'get_item';
            $item_code = $this->request->data['item_code'];
            $scheme_id = $this->request->data['scheme_id'];
            $scheme = $this->SchemeDetails->Schemes->get($scheme_id);

            //get the old items
            $old_scheme_details = $this->SchemeDetails
                        ->find()
                        ->where(['scheme_id'=>$scheme_id])
                        ->where(['status'=>1])
                        ->toArray();
            $old_scheme_items = array();
            foreach($old_scheme_details as $item)
            {
                $old_scheme_items[$item['item_code']]['item_id'] = $item['item_id'];
                $old_scheme_items[$item['item_code']]['item_table'] = $item['item_table'];
                $old_scheme_items[$item['item_code']]['item_code'] = $item['item_code'];
                $old_scheme_items[$item['item_code']]['item_unit'] = $item['item_unit'];
                $old_scheme_items[$item['item_code']]['rate'] = $item['rate'];
                $old_scheme_items[$item['item_code']]['financial_year'] = $item['financial_year'];
                $old_scheme_items[$item['item_code']]['details'] = $item['details'];
                $old_scheme_items[$item['item_code']]['rows'][] = $item;
            }
            //find in the old item
            if(array_key_exists($item_code,$old_scheme_items))
            {
                $old_scheme_item = $old_scheme_items[$item_code];
                $flag = 'old_items';
                $this->set(compact('flag','old_scheme_item'));
            }
            else // if not found in the old items; search items
            {
                $item_unit='';
                $item_rate='';
                $item_id='';
                $financial_year_estimate_id='';
                $item_table='';

                //Check the additional_items::
                $additional_items = TableRegistry::get('additional_items');
                $query = $additional_items->find();
                $query->where(['item_display_code'=>$item_code]);
                $additional_item_table = $query->first();
                if($additional_item_table)
                {
                    $item_unit = $additional_item_table['unit'];
                    $item_rate = $additional_item_table['rate'];
                    $item_id = $additional_item_table['id'];
                    $description = $additional_item_table['description'];
                    $item_table = 'additional_items';
                    $financial_year_estimate_id = $scheme['financial_year_estimate_id'];
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
        }
        elseif($task=='get_upazila_municpaltiy_by_disctrict_id')
        {
            $district_id=$this->request->data['district_id'];
            $data['upazilas'] = $this->SchemeDetails->Schemes->Upazilas->find('all', ['fields' => ['id', 'name_en']])
                ->where(['district_id'=>$district_id]);
            $data['municipalities'] = $this->SchemeDetails->Schemes->Municipalities->find('all', ['fields' => ['id', 'name_en']])
                ->where(['district_id'=>$district_id]);

            $this->response->body(json_encode($data));
            return $this->response;
        }
    }
}
