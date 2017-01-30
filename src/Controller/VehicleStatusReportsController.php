<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

/**
 * VehicleStatusReports Controller
 *
 * @property \App\Model\Table\VehiclesTable $Vehicles
 */
class VehicleStatusReportsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {

    }

    //Ajax
    public function ajax($action = null)
    {
        if ($action == 'get_grid_data' && $this->user_roles['index'] ) {
            Configure::load('config_vehicles', 'default');
            $vehicle_status = Configure::read('vehicle_status');
            $user = $this->Auth->user();
            if ($user['user_group_id'] == 1) {
                $vehicles = TableRegistry::get('vehicles')
                    ->find()
                    ->select(['vehicles.title', 'vehicles.type', 'vehicles.registration_no', 'vehicles.vehicle_location', 'vehicles.serial_no', 'vehicles.vehicle_status', 'employees.name_en'])
                    ->leftJoin('assign_vehicles', 'assign_vehicles.vehicle_id = vehicles.id AND assign_vehicles.status = 1')
                    ->leftJoin('employees', 'employees.id = assign_vehicles.employee_id');
            } else {
                $query = TableRegistry::get('vehicles')->find();
                $vehicles = $query->select(['vehicles.id', 'vehicles.type', 'vehicles.registration_no', 'vehicles.title', 'vehicles.vehicle_location', 'vehicles.serial_no', 'vehicles.vehicle_status', 'employees.name_en'])
                    ->hydrate(false)
                    ->where(['vehicles.office_id' => $user['office_id']])
                    ->leftJoin('assign_vehicles', 'assign_vehicles.vehicle_id = vehicles.id AND assign_vehicles.status = 1')
                    ->leftJoin('employees', 'employees.id = assign_vehicles.employee_id')
                    ->toArray();
            }
            $assign_vehicles = [];
            foreach ($vehicles as $vehicle) {

                if (isset($assign_vehicles[$vehicle['id']])) {
                    $assign_vehicles[$vehicle['id']]['employees'] .=' , '. $vehicle['employees']['name_en'];
                    $assign_vehicles[$vehicle['id']]['vehicle_status'] = $vehicle_status[$vehicle['vehicle_status']];

                } else {
                    $assign_vehicles[$vehicle['id']] = $vehicle;
                    $assign_vehicles[$vehicle['id']]['employees'] = $assign_vehicles[$vehicle['id']]['employees']['name_en'];
                    $assign_vehicles[$vehicle['id']]['vehicle_status'] = $vehicle_status[$vehicle['vehicle_status']];

                }
//                $assign_vehicles['employees'] =  $vehicle['employees']['name_en'];

            }

//   echo "<pre>";
//            print_r(json_encode(array_values($assign_vehicles)));
//            echo 'bla';
//            print_r($vehicles);
//            die();

            $this->response->body(json_encode(array_values($assign_vehicles)));
            return $this->response;
        } else {
            return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
        }

    }

    //    Print report
    public function print_it()
    {
        $this->layout = 'print';
        $this->view = 'print';
        $officeTable = TableRegistry::get('offices');
        $user = $this->Auth->user();
        if ($user['user_group_id'] == 1) {
            $vehicles = TableRegistry::get('vehicles')
                ->find()
                ->select(['vehicles.title', 'vehicles.load_capacity', 'vehicles.serial_no', 'vehicles.vehicle_status', 'vehicles.vehicle_location', 'employees.name_en', 'employees.mobile'])
                ->leftJoin('assign_vehicles', 'assign_vehicles.vehicle_id = vehicles.id')
                ->leftJoin('employees', 'employees.id = assign_vehicles.employee_id');
        } else {
            $query = TableRegistry::get('vehicles')->find();
            $vehicles = $query->select(['vehicles.id', 'vehicles.title', 'vehicles.load_capacity', 'vehicles.serial_no', 'vehicles.vehicle_status', 'vehicles.vehicle_location', 'employees.name_en', 'employees.mobile'])
                ->where(['vehicles.office_id' => $user['office_id']])
                ->leftJoin('assign_vehicles', 'assign_vehicles.vehicle_id = vehicles.id')
                ->leftJoin('employees', 'employees.id = assign_vehicles.employee_id')
                ->toArray();
        }
        // Office Info
        $office = $officeTable->find()
            ->where(['id' => $user['office_id']])
            ->first();
        $this->set(compact('vehicles', 'office'));
    }

    public function get_name_by_vehicle_id($id)
    {

    }
}
