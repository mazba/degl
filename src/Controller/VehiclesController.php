<?php
namespace App\Controller;

use Cake\Core\Configure;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Vehicles Controller
 *
 * @property \App\Model\Table\VehiclesTable $Vehicles
 */
class VehiclesController extends AppController
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
     * @param string|null $id Vehicle id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $vehicle = $this->Vehicles->get($id, [
            'contain' => ['Offices', 'CreatedUser', 'UpdatedUser']
        ]);
        $this->set('vehicle', $vehicle);
        $this->set('_serialize', ['vehicle']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $vehicle = $this->Vehicles->newEntity();
        if ($this->request->is('post')) {

            $user = $this->Auth->user();
            $data = $this->request->data;
//            if($data['type'] == 'vehicles')
//            {
//
//            }
            $data['office_id'] = $user['office_id'];
            $data['created_by'] = $user['id'];
            $data['created_date'] = time();
            if ($data['procurement_date']) {
                $x = strtotime($data['procurement_date']);
                if ($x !== false) {
                    $data['procurement_date'] = $x;
                } else {
                    $data['procurement_date'] = '';
                }
            }
            $vehicle = $this->Vehicles->patchEntity($vehicle, $data);
            if ($this->Vehicles->save($vehicle)) {
                $this->Flash->success(__('The vehicle has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The vehicle could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('vehicle'));
        $this->set('_serialize', ['vehicle']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Vehicle id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $vehicle = $this->Vehicles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Auth->user();
            $data = $this->request->data;
            $data['updated_by'] = $user['id'];
            $data['updated_date'] = time();
            if ($data['procurement_date']) {
                $x = strtotime($data['procurement_date']);
                if ($x !== false) {
                    $data['procurement_date'] = $x;
                } else {
                    $data['procurement_date'] = '';
                }
            }

            $vehicle = $this->Vehicles->patchEntity($vehicle, $data);
            if ($this->Vehicles->save($vehicle)) {
                $this->Flash->success(__('The vehicle has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The vehicle could not be saved. Please, try again.'));
            }
        }

        $this->set(compact('vehicle'));
        $this->set('_serialize', ['vehicle']);
    }

    //Ajax
    public function ajax($action = null)
    {
        if ($action == 'get_grid_data' && $this->user_roles['index']) {
            Configure::load('config_vehicles', 'default');
            $vehicle_status = Configure::read('vehicle_status');
            $user = $this->Auth->user();
            if ($user['user_group_id'] == 1) {
                $vehicles = $this->Vehicles->find('all', [
                    'conditions' => ['Vehicles.status !=' => 99]
                ])->toArray();
            } else {
                $vehicles = $this->Vehicles->find('all', [
                    'conditions' => ['Vehicles.status !=' => 99, 'Vehicles.office_id' => $user['office_id']]
                ])->toArray();
            }
            foreach ($vehicles as &$vehicle) {
                if ($vehicle['type'] != 'vehicles') {
                    $vehicle['title'] = $vehicle['equipment_id_no'];
                    $vehicle['serial_no'] = $vehicle['equipment_category'];
                    $vehicle['registration_no'] = $vehicle['equipment_brand'];
                    $vehicle['load_capacity'] = $vehicle['equipment_capacity'];
                }
                $vehicle['vehicle_status'] = $vehicle_status[$vehicle['vehicle_status']];
                $vehicle['action'] = '<a title="' . __('View') . '" class="icon-newspaper" href="' . $this->request->webroot . 'Vehicles/view/' . $vehicle['id'] . '" ></a> &nbsp' . '<a title="' . __('Edit') . '" class="icon-pencil3 text-warning" href="' . $this->request->webroot . 'Vehicles/edit/' . $vehicle['id'] . '" ></a> &nbsp' . '<a title="' . __('Delete') . '" class="icon-remove3 text-danger" onclick="return confirm(\'Are you sure to delete?\');" href="' . $this->request->webroot . 'Vehicles/delete/' . $vehicle['id'] . '" ></a> &nbsp' . '<a title="' . __('Servicing Report') . '" class="icon-certificate text-info" href="' . $this->request->webroot . 'Vehicles/service_report/' . $vehicle['id'] . '" ></a> &nbsp' . '<a title="' . __('Vehicle Driver Report') . '" class="icon-bus text-info" href="' . $this->request->webroot . 'Vehicles/driver_report/' . $vehicle['id'] . '" ></a>';
            }
            $this->response->body(json_encode($vehicles));
            return $this->response;
        } else {
            return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
        }

    }


    public function service_report($id = null)
    {
        $vehicle = $this->Vehicles->get($id, [
            'contain' => ['Offices', 'CreatedUser', 'UpdatedUser']
        ]);
        $this->loadModel('VehicleServicings');
        $services = $this->VehicleServicings->find('all', ['contain'=>['VehicleServicingDetails'],'conditions' => ['VehicleServicings.vehicle_id' => $id]]);


        $this->set(compact('vehicle', 'services'));
        $this->set('_serialize', ['vehicle']);
    }

    public function driver_report($id = null)
    {
        $vehicle = $this->Vehicles->get($id, [
            'contain' => ['Offices', 'CreatedUser', 'UpdatedUser']
        ]);
        $this->loadModel('AssignVehicles');
        $drivers = $this->AssignVehicles->find('all', ['contain' => ['Employees'], 'conditions' => ['AssignVehicles.vehicle_id' => $id]]);


        $this->set(compact(['vehicle', 'drivers']));
        $this->set('_serialize', ['vehicle']);
    }

    public function delete($id = null)
    {
        if ($id) {
            $vehicle = $this->Vehicles->get($id);
            $vehicle->status = 99;
            if ($this->Vehicles->save($vehicle)) {
                $this->Flash->success(__('The vehicle has been deleted.'));
            } else {
                $this->Flash->success(__('The vehicle could not be deleted. Please, try again.'));
            }
        } else {
            $this->Flash->success(__('The vehicle does not exists.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
