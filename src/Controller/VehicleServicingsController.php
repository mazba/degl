<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * VehicleServicings Controller
 *
 * @property \App\Model\Table\VehicleServicingsTable $VehicleServicings
 */
class VehicleServicingsController extends AppController
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
     * @param string|null $id Vehicle Servicing id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $vehicleServicing = $this->VehicleServicings->get($id, [
            'contain' => ['Offices', 'Vehicles','VehicleServicingDetails'],
        ]);
       // echo "<pre>";print_r($vehicleServicing);die();
        $this->set('vehicleServicing', $vehicleServicing);
        $this->set('_serialize', ['vehicleServicing']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        $user = $this->Auth->user();
        $vehicleServicing = $this->VehicleServicings->newEntity();
        if ($this->request->is('post')) {
//            echo "<pre>";
//             print_r($this->request->data);
//             echo "</pre>";
//             die;
            $time = time();

            $data = $this->request->data;
            $parts = $data['parts'];
            unset($data['parts']);
            $vehicle_location = $data['vehicle_location'];
            $vehicle_place_of_user = $data['vehicle_place_of_user'];
            unset($data['vehicle_location']);
            unset($data['vehicle_place_of_user']);

            $data['office_id'] = $user['office_id'];
            $data['created_by'] = $user['id'];
            $data['created_date'] = $time;

            $x = strtotime($data['breakdown_date']);
            if ($x !== false) {
                $data['breakdown_date'] = $x;
            } else {
                $data['breakdown_date'] = '';
            }
            $x = strtotime($data['servicing_start_date']);
            if ($x !== false) {
                $data['servicing_start_date'] = $x;
            } else {
                $data['servicing_start_date'] = '';
            }
            $x = strtotime($data['servicing_end_date']);
            if ($x !== false) {
                $data['servicing_end_date'] = $x;
            } else {
                $data['servicing_end_date'] = '';
            }

            /*$x=strtotime($data['servicing_end_date']);
            if($x!==false)
            {
                $data['servicing_end_date']=$x;
            }
            else
            {
                $data['servicing_end_date']='';
            }*/
            $vehicleServicing = $this->VehicleServicings->patchEntity($vehicleServicing, $data);
            if ($this->VehicleServicings->save($vehicleServicing)) {
                $this->loadModel('VehicleServicingDetails');
                foreach ($parts as $part) {
                    $vehicleSericingDetail = $this->VehicleServicingDetails->newEntity();
                    $vehicleSericingDetail->vehicle_servicing_id = $vehicleServicing->id;
                    $vehicleSericingDetail->name = $part['name'];
                    $vehicleSericingDetail->quantity = $part['quantity'];
                    $vehicleSericingDetail->rate = $part['rate'];
                    $vehicleSericingDetail->total = $part['total'];
                    $vehicleSericingDetail->created_date = $time;
                    $vehicleSericingDetail->created_by = $user['id'];
                    $this->VehicleServicingDetails->save($vehicleSericingDetail);
                }


                $vehiclestable = TableRegistry::get('vehicles');
                $vdata = array();
                $vdata['updated_by'] = $user['id'];
                $vdata['updated_date'] = $time;
                $vdata['vehicle_status'] = 'SERVICING';
                $vdata['vehicle_location'] = $vehicle_location;
                $vdata['vehicle_place_of_user'] = $vehicle_place_of_user;
                $query = $vehiclestable->query();
                $query->update()
                    ->set($vdata)
                    ->where(['id' => $data['vehicle_id']])
                    ->execute();
                $this->Flash->success(__('The vehicle servicing has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The vehicle servicing could not be saved. Please, try again.'));
            }
        }

        $vehicles = $this->VehicleServicings->Vehicles->find()
            ->select(['id', 'title', 'registration_no', 'type', 'equipment_id_no', 'equipment_category'])
            ->where(['office_id' => $user['office_id']])
            ->where(['status' => 1])
            ->where('(vehicle_status ="READY" OR vehicle_status ="IN_USE")');

        $this->set(compact('vehicleServicing', 'offices', 'vehicles'));
        $this->set('_serialize', ['vehicleServicing']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Vehicle Servicing id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Auth->user();
        $vehicleServicing = $this->VehicleServicings->get($id, [
            'contain' => ['Vehicles']
        ]);

        $vehicleServicing['vehicle_location']=$vehicleServicing['vehicle']['vehicle_location'];
        $vehicleServicing['vehicle_place_of_user']=$vehicleServicing['vehicle']['vehicle_place_of_user'];

       // echo "<pre>";print_r($vehicleServicing);die();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $time = time();
            $data = $this->request->data;
            $data['updated_by'] = $user['id'];
            $data['updated_date'] = $time;
            $data['status'] = 0;
            $x = strtotime($data['servicing_end_date']);
            if ($x !== false) {
                $data['servicing_end_date'] = $x;
            } else {
                $data['servicing_end_date'] = '';
            }
            $vehicleServicing = $this->VehicleServicings->patchEntity($vehicleServicing, $data);
            if ($this->VehicleServicings->save($vehicleServicing)) {
                $vehiclestable = TableRegistry::get('vehicles');
                $vdata = array();
                $vdata['updated_by'] = $user['id'];
                $vdata['updated_date'] = $time;
                $vdata['vehicle_status'] = 'READY';
                $query = $vehiclestable->query();
                $query->update()
                    ->set($vdata)
                    ->where(['id' => $vehicleServicing->vehicle_id])
                    ->execute();
                $this->Flash->success(__('The vehicle servicing has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The vehicle servicing could not be saved. Please, try again.'));
            }
        }

        $vehicles = $this->VehicleServicings->Vehicles->find()
            ->select(['id', 'title', 'registration_no', 'type', 'equipment_id_no', 'equipment_category'])
            ->where(['office_id' => $user['office_id']])
            ->where(['status' => 1])
            ->where('(vehicle_status ="READY" OR vehicle_status ="IN_USE")');

        $this->set(compact('vehicleServicing', 'offices', 'vehicles'));
        $this->set('_serialize', ['vehicleServicing']);
    }

    //Ajax
    public function ajax($action = null)
    {
        if ($action == 'get_grid_data' && $this->user_roles['index']) {
            $user = $this->Auth->user();
            if ($user['user_group_id'] == 1) {
                $vehicleServicings = $this->VehicleServicings->find('all', [
                    'conditions' => ['VehicleServicings.status' => 1],
                    'contain' => ['Offices', 'Vehicles'],
                    'order' => ['VehicleServicings.id' => 'ASC']

                ])->toArray();
            } else {
                $vehicleServicings = $this->VehicleServicings->find('all', [
                    'conditions' => ['VehicleServicings.status' => 1, 'VehicleServicings.office_id' => $user['office_id']],
                    'contain' => ['Offices', 'Vehicles'],
                    'order' => ['VehicleServicings.id' => 'ASC']
                ])->toArray();
            }
            foreach ($vehicleServicings as &$vehicleServicing) {
                $vehicleServicing['vehicle'] = $vehicleServicing['vehicle']['title'];
                $vehicleServicing['breakdown_date'] = date('d/m/y', $vehicleServicing['breakdown_date']);
                $vehicleServicing['servicing_start_date'] = date('d/m/y', $vehicleServicing['servicing_start_date']);
                $vehicleServicing['office'] = $vehicleServicing['office']['name_en'];
                $vehicleServicing['action'] = '<a title="' . __('View') . '" class="icon-newspaper" href="' . $this->request->webroot . 'VehicleServicings/view/' . $vehicleServicing['id'] . '" ><a> &nbsp' . '<a title="' . __('Edit') . '" class="icon-pencil3 text-danger" href="' . $this->request->webroot . 'VehicleServicings/edit/' . $vehicleServicing['id'] . '" ><a>';
            }
            $this->response->body(json_encode($vehicleServicings));
            return $this->response;
        } else {
            return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
        }

    }
}
