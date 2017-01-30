<?php
namespace App\Controller;

use Cake\ORM\TableRegistry;

/**
 * UserGroupRoles Controller
 *
 * @property \App\Model\Table\UserGroupRolesTable $UserGroupRoles
 */
class VehicleHireController extends AppController
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
     * @param string|null $id User Group Role id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */

    public function edit($id = null)
    {
        $user = $this->Auth->user();
        $vehicle_hire = TableRegistry::get('vehicle_hire');
        $vehicle_table = TableRegistry::get('vehicles');
        $available_vehicles = $this->get_avaliable_vehicles($id);
        $hired_vehicles = $this->get_hired_vehicles($id);
        $vehicle_letters = TableRegistry::get('vehicle_hire_letter_registers');

        if ($this->request->is('post')) {
            $selected_vehicles = array();
            $location = array();
            if (isset($this->request->data['selected_vehicles'])) {
                $selected_vehicles = $this->request->data['selected_vehicles'];
                $location = $this->request->data['location'];
            }
            /*if(count($selected_vehicles)==0)
            {
                $this->Flash->error('No vehicle seleted');
            }

            */

            /* echo "<pre>";
             print_r($this->request->data);
             echo "</pre>";
             die;*/

            if (count(array_intersect($selected_vehicles, $available_vehicles[0])) == count($selected_vehicles)) {
                $time = time();
                /*$query = $vehicle_hire->query();
                $query->update()
                    ->set($data)
                    ->where(['letter_id' => $id])
                    ->execute();
                debug($query);*/
                $query = $vehicle_hire->query();
                $query->update('vehicle_hire SET revision_no=revision_no+1 ,updated_by=' . $user['id'] . ',updated_date=' . $time . ',status=0')
                    ->where(['letter_id' => $id])
                    ->execute();

                foreach ($selected_vehicles as $sv) {
                    $data = array();
                    $data['letter_id'] = $id;
                    $data['vehicle_id'] = $sv;
                    $data['office_id'] = $user['office_id'];
                    $data['revision_no'] = 1;
                    $data['created_by'] = $user['id'];
                    $data['created_date'] = $time;
                    $data['status'] = 1;
                    $query = $vehicle_hire->query();
                    $query->insert(array_keys($data))
                        ->values($data)
                        ->execute();
                }

                foreach ($location as $key => $value) {
                    $this->loadModel('Vehicles');
                    $vehicle = $this->Vehicles->get($key);
                    $arr['vehicle_location'] = $value;
                    $arr['updated_by'] = $user['id'];
                    $arr['updated_date'] = time();
                    $vehicle = $this->Vehicles->patchEntity($vehicle, $arr);
                    $this->Vehicles->save($vehicle);
                }

                $this->Flash->success(__('Vehicle Saved Successfully.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Someone hired some vehicles.Try again.'));
            }
        }
        //get vehicle info
        $hired_vehicles = $this->get_hired_vehicles($id);
        // get vehicle hire letter info
        $query = $vehicle_letters->get($id);
        $vehicle_hire_letter = $query->toArray();
        //Message & Attachment ingo

        $attachment_query = TableRegistry::get('vehicle_hire_letter_registers')->find();
        //    $attachment_query->select(['applications.id','applications.temporary_id','applications.applicant_id','applications.applicant_name_bn','applications.phone','applications.email','applications.application_type_id','applications.start_date','applications.end_date','applications.status']);
        $attachment_query->select(['files.file_path']);
        $attachment_query->where(['vehicle_hire_letter_registers.id' => $id]);
        $attachment_query->where(['files.table_name' => 'receive_file_registers']);
        $attachment_query->leftJoin('files', 'files.table_key=vehicle_hire_letter_registers.resource_id');
        $attachment = $attachment_query->first();

//echo "<pre>";print_r($attachment['files']);die();
        $this->set('id', $id);
        $this->set('vehicles', $available_vehicles[1]);
        $this->set('hired_vehicles', $hired_vehicles[1]);
        $this->set('vehicle_hire_letter', $vehicle_hire_letter);
        $this->set('attachment', $attachment);
        $this->set('location', $hired_vehicles[2]);

    }
//    public function view($id = null)
//    {
//        $user=$this->Auth->user();
//        $vehicle_hire = TableRegistry::get('vehicle_hire');
//        $vehicle_table = TableRegistry::get('vehicles');
//        $hired_vehicles=$this->get_hired_vehicles($id);
//        $this->set('id', $id);
//        $this->set('vehicles', $hired_vehicles[1]);
//    }
    private function get_avaliable_vehicles($letter_id)
    {
        $user = $this->Auth->user();
        $vids = array();
        $vlists = array();
        $vehicle_hire = TableRegistry::get('vehicle_hire');
        $vehicle_table = TableRegistry::get('vehicles');
        $sub_query = $vehicle_hire->find();
        $sub_query->select(['vehicle_id' => 'vehicle_id'])
            ->where(['status' => 1, 'office_id' => $user['office_id'], 'letter_id !=' => $letter_id]);
        $vehicles = $vehicle_table->find();
        $vehicles->select(['id' => 'id', 'title' => 'title']);
        $vehicles->where(['id NOT IN' => $sub_query]);
        $vehicles->where(['office_id' => $user['office_id']]);
        foreach ($vehicles as $v) {
            $vids[] = $v->id;
            $vlists[] = array('id' => $v->id, 'title' => $v->title);
        }
        return array($vids, $vlists);
    }

    function get_hired_vehicles($letter_id)
    {
        $user = $this->Auth->user();
        $vids = array();
        $vlists = array();
        $vlocation = array();
        $vehicle_hire = TableRegistry::get('vehicle_hire');
        $vehicle_table = TableRegistry::get('vehicles');
        $sub_query = $vehicle_hire->find();
        $sub_query->select(['vehicle_id' => 'vehicle_id'])
            ->where(['status' => 1, 'office_id' => $user['office_id'], 'letter_id' => $letter_id]);
        $vehicles = $vehicle_table->find();
        $vehicles->select(['id' => 'id', 'title' => 'title', 'location' => 'vehicle_location']);
        $vehicles->where(['id IN' => $sub_query]);
        $vehicles->where(['office_id' => $user['office_id']]);
        foreach ($vehicles as $v) {
            $vids[] = $v->id;
            $vlists[] = array('id' => $v->id, 'title' => $v->title, 'location' => $v->location);
            $vlocation[] = $v->location;
        }


        return array($vids, $vlists, $vlocation);
    }

    //Ajax
    public function ajax($action = null,$scheme_id=null)
    {
        if ($action == 'get_grid_data' && $this->user_roles['index']) {
            $user = $this->Auth->user();
            $vehicle_hire = TableRegistry::get('vehicle_hire');
            $vehicle_letters = TableRegistry::get('vehicle_hire_letter_registers');

            $sub_query = $vehicle_hire->find();

            $sub_query->select(['letter_id' => 'letter_id', 'total_vehicles' => $sub_query->func()->count('DISTINCT vehicle_id')])
                ->where(['status' => 1, 'revision_no' => 1, 'office_id' => $user['office_id']])
                ->group(['letter_id'])
                ->order(['id' => 'DESC']);

            $query = $vehicle_letters->find();
            $query->select(['vh.total_vehicles', 'id', 'sarok_no', 'subject', 'schemes.name_en'])
                ->order(['vehicle_hire_letter_registers.id' => 'DESC']);
            $query->join(['vh' => [
                'table' => $sub_query,
                'type' => 'LEFT',
                'conditions' => 'vh.letter_id = vehicle_hire_letter_registers.id',
            ], 'schemes' => [
                'table' => 'schemes',
                'type' => 'LEFT',
                'conditions' => 'vehicle_hire_letter_registers.scheme_id = schemes.id',
            ]]);
            $query->where(['receive_office' => $user['office_id']]);

            $vehicle_hires = $query->toArray();
            foreach ($vehicle_hires as &$vehicle_hire) {
                $vehicle_hire['total_vehicles'] = $vehicle_hire['vh']['total_vehicles'];
                $vehicle_hire['schemes'] = !empty($vehicle_hire['schemes']['name_en']) ? $vehicle_hire['schemes']['name_en'] : 'Others';
                //  $vehicle_hire['action']= '<a title="'.__('View').'" class="icon-newspaper" href="'.$this->request->webroot.'VehicleHire/view/'.$vehicle_hire['id'].'" ><a> &nbsp'.'<a title="'.__('Edit').'" class="icon-pencil3 text-danger" href="'.$this->request->webroot.'VehicleHire/edit/'.$vehicle_hire['id'].'" ><a>';
                $vehicle_hire['action'] = '<a title="' . __('Edit') . '" class="icon-pencil3 text-danger" href="' . $this->request->webroot . 'VehicleHire/edit/' . $vehicle_hire['id'] . '" ><a>';
            }
            $this->response->body(json_encode($vehicle_hires));
            return $this->response;
        }
        elseif ($action == 'get_grid_data_by_scheme_id' ) {

           // echo "<pre>";print_r($scheme_id);die();
            $user = $this->Auth->user();
            $vehicle_hire = TableRegistry::get('vehicle_hire');
            $vehicle_letters = TableRegistry::get('vehicle_hire_letter_registers');

            $sub_query = $vehicle_hire->find();

            $sub_query->select(['letter_id' => 'letter_id', 'total_vehicles' => $sub_query->func()->count('DISTINCT vehicle_id')])
                //->where(['status' => 1, 'revision_no' => 1, 'office_id' => $user['office_id']])
                ->where(['status' => 1, 'revision_no' => 1])
                ->group(['letter_id'])
                ->order(['id' => 'DESC']);

            $query = $vehicle_letters->find();
            $query->select(['vh.total_vehicles', 'id', 'sarok_no', 'subject', 'schemes.name_en'])
                ->order(['vehicle_hire_letter_registers.id' => 'DESC']);
            $query->join(['vh' => [
                'table' => $sub_query,
                'type' => 'LEFT',
                'conditions' => 'vh.letter_id = vehicle_hire_letter_registers.id',
            ], 'schemes' => [
                'table' => 'schemes',
                'type' => 'LEFT',
                'conditions' => 'vehicle_hire_letter_registers.scheme_id = schemes.id',
            ]]);
           // $query->where(['receive_office' => $user['office_id'],'scheme_id'=>$scheme_id]);
            $query->where(['scheme_id'=>$scheme_id]);

            $vehicle_hires = $query->toArray();
            foreach ($vehicle_hires as &$vehicle_hire) {
                $vehicle_hire['total_vehicles'] = $vehicle_hire['vh']['total_vehicles'];
                $vehicle_hire['schemes'] = !empty($vehicle_hire['schemes']['name_en']) ? $vehicle_hire['schemes']['name_en'] : 'Others';
                 $vehicle_hire['action']= '<a title="'.__('View').'" class="icon-newspaper" target="_blank" href="'.$this->request->webroot.'VehicleHireLetterRegisters/view/'.$vehicle_hire['id'].'" ><a>';
             //   $vehicle_hire['action'] = '<button title="' . __('View') . '" type="button"  class="icon-pencil3 text-danger vehicle_hire_letter" data-letter-id=" '. $vehicle_hire['id'].' " ></button>';
            }
            $this->response->body(json_encode($vehicle_hires));
            return $this->response;
        } else {
            return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
        }

    }
}
