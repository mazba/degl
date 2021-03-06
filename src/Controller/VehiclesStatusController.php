<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

/**
 * VehiclesStatus Controller
 *
 * @property \App\Model\Table\VehiclesStatusTable $VehiclesStatus
 */
class VehiclesStatusController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {

    }

    public function ajax($action = null)
    {
        if ($action == 'get_grid_data' && $this->user_roles['index']) {
            Configure::load('config_vehicles', 'default');
            $vehicle_status = Configure::read('vehicle_status');
            $user = $this->Auth->user();
            if ($user['user_group_id'] == 1 && false) {
                $vehicles = TableRegistry::get('vehicles')
                    ->find()
                    ->select(['vehicles.title','vehicles_status.id','employees.name_en'])
                    ->leftJoin('assign_vehicles', 'assign_vehicles.vehicle_id = vehicles.id AND assign_vehicles.status = 1')
                    ->leftJoin('employees', 'employees.id = assign_vehicles.employee_id');
            } else {
                $vehicle_status = Configure::read('vehicle_status');
                $query = TableRegistry::get('vehicles')->find();
                $this->loadModel('VehicleServicings');
                $vehicles = $query->select([
                    'vehicles.id',
                    'vehicles.title',
                    'vehicles.daily_cost_ratio',
                    'vehicles.vehicle_status',
                    'serviceCost' => $query->func()->sum('vehicle_servicings.service_charge'),
                    'vehicles_status.vehicle_location',
                    'vehicles_status.assign_date',
                    'employees.name_en','schemes.name_en'
                ])
                    ->hydrate(false)
                    ->where(['vehicles.office_id' => $user['office_id'], 'vehicles.status' => 1 ])
                    ->leftJoin('vehicles_status', 'vehicles_status.vehicle_id = vehicles.id AND vehicles_status.status = 1')
                    ->leftJoin('vehicle_servicings', 'vehicle_servicings.vehicle_id = vehicles.id')
                    ->leftJoin('employees', 'employees.id = vehicles_status.employee_id')
                    ->leftJoin('schemes', 'schemes.id = vehicles_status.scheme_id')
                    ->order(['vehicles.id'=>'ASC'])
                    ->group(['vehicles.id'])
                    ->toArray();
            }

            foreach ($vehicles as &$vehicle) {
                $vehicle['vehicle_location'] = $vehicle['vehicles_status']['vehicle_location'];
                $vehicle['assign_date'] = $vehicle['vehicles_status']['assign_date']?date('d/m/Y',$vehicle['vehicles_status']['assign_date']):'';
                $vehicle['schemes'] = $vehicle['schemes']['name_en'];
                $vehicle['employee'] = $vehicle['employees']['name_en'];
                $vehicle['vehicle_status'] = $vehicle_status[$vehicle['vehicle_status']];
                $vehicle['action'] = '<a title="' . __('View') . '" class="icon-newspaper" href="' . $this->request->webroot . 'VehiclesStatus/view/' . $vehicle['id'] . '" ><a> &nbsp' .
                    '<a title="' . __('ADD') . '" class="icon-user-plus" href="' . $this->request->webroot . 'VehiclesStatus/add/' . $vehicle['id'] . '" ><a> &nbsp' .
                    '<a title="' . __('Edit') . '" class="icon-pencil3 text-danger" href="' . $this->request->webroot . 'VehiclesStatus/edit/' . $vehicle['id'] . '" ><a> &nbsp'.
                    '<a title="' . __('Report') . '" class="icon-certificate text-info" href="' . $this->request->webroot . 'VehiclesStatus/report/' . $vehicle['id'] . '" ><a>';

            }
            $this->response->body(json_encode(array_values($vehicles)));
            return $this->response;
        } else {
            return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
        }

    }

    /**
     * View method
     *
     * @param string|null $id Vehicles Status id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $vehiclesStatus = TableRegistry::get('vehicles')->get($id, [
            'contain' => ['VehiclesStatus'=>['Employees','Schemes']]
        ]);
//        echo "<pre>";print_r($vehiclesStatus);die();
        $this->set('vehiclesStatus', $vehiclesStatus);
        $this->set('_serialize', ['vehiclesStatus']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($id)
    {

        $vehiclesStatus = $this->VehiclesStatus->find('all', [
            'conditions' => ['VehiclesStatus.status ' => 1,'VehiclesStatus.vehicle_id ' => $id],
            'contain' => 'Schemes',
            'order' => ['VehiclesStatus.id' => 'DESC'],
        ])
        ->first();
        if(!empty($vehiclesStatus['scheme']['name_en'])){
            $scheme_name = $vehiclesStatus['scheme']['name_en'];
        }else{
            $scheme_name = 'এখন ও কোনো স্কিম এসাইন করা হয় নাই';
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $vehiclesStatus = $this->VehiclesStatus->newEntity();
            $data = $this->request->data;
//            pr($data);die;
            $data['vehicle_id'] = $id;
            $data['status'] = 1;
            $data['assign_date'] = strtotime($data['assign_date']);

            $vehicle = TableRegistry::get('VehiclesStatus');
            $query = $vehicle->query();
            $query->update()
                ->set(['end_date' => $data['assign_date']])
                ->where(['vehicle_id' => $id, 'status' => 1])
                ->execute();

            $query->update()
                ->set(['status' => 0])
                ->where(['vehicle_id' => $id])
                ->execute();

            $vehiclesStatus = $this->VehiclesStatus->patchEntity($vehiclesStatus, $data);
            if ($this->VehiclesStatus->save($vehiclesStatus)) {
                $this->Flash->success('The vehicles status has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The vehicles status could not be saved. Please, try again.');
            }
        }
        $employees = $this->VehiclesStatus->Employees->find('list',['conditions' => ['status' => 1]]);

        $this->loadModel('AssignVehicles');
        $this->set(compact('vehiclesStatus', 'employees','scheme_name'));
        $this->set('_serialize', ['vehiclesStatus']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Vehicles Status id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        //pr($id);die;
        $vehiclesStatus = $this->VehiclesStatus->find('all', [
            'conditions' => [
                'VehiclesStatus.vehicle_id' => $id,
                'VehiclesStatus.status' => 1],
        ])->first();
        if ($this->request->is(['patch', 'post', 'put'])) {

            $data = $this->request->data;
            $data['end_date']=strtotime( $data['end_date']);

            //pr($data);die;
            $vehicle = TableRegistry::get('VehiclesStatus');
            $query = $vehicle->query();
            $query->update()
                ->set(['vehicle_location'=>$data['vehicle_location'],'remark'=>$data['remark'],'end_date'=>$data['end_date'],'status' => 0])
                ->where(['id' => $data['id']])
                ->execute();
                //pr($query);die;
            //echo "<pre>";print_r($data);die();
//            $vehiclesStatus = $this->VehiclesStatus->patchEntity($vehiclesStatus, $data);
//          echo "<pre>";print_r($vehiclesStatus);die();
            if ($query) {
                $this->Flash->success('The vehicles status has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The vehicles status could not be saved. Please, try again.');
            }
        }
//        $vehicles = $this->VehiclesStatus->Vehicles->find('list', ['limit' => 200]);
//        $employees = $this->VehiclesStatus->Employees->find('list', ['limit' => 200]);
//        $schemes = $this->VehiclesStatus->Schemes->find('list', ['limit' => 200]);
        $this->set(compact('vehiclesStatus'));
        $this->set('_serialize', ['vehiclesStatus']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Vehicles Status id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $vehiclesStatus = $this->VehiclesStatus->get($id);
        if ($this->VehiclesStatus->delete($vehiclesStatus)) {
            $this->Flash->success('The vehicles status has been deleted.');
        } else {
            $this->Flash->error('The vehicles status could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Vehicles Status id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function report($id = null)
    {
        // Default info about vehicles
        $user = $this->Auth->user();
        $this->loadModel('Vehicles');
        $vehicle = $this->Vehicles->get($id, [
            'contain' => []
        ]);

        // Vehicle Details Report
        $vehicle_status = Configure::read('vehicle_status');
        $this->loadModel('VehiclesStatus');
        $vehicleDetails = $this->VehiclesStatus->find()
            ->where(['VehiclesStatus.vehicle_id' => $id])
            ->contain(['Vehicles','Employees','Schemes'])
            ->hydrate(false)
            ->toArray();
        $this->set(compact('vehicle','vehicleDetails'));
    }
}
