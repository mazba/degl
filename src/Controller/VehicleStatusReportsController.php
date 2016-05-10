<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
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
        if($action == 'get_grid_data' && $this->user_roles['index'])
        {
            Configure::load('config_vehicles', 'default');
            $vehicle_status = Configure::read('vehicle_status');
            $user = $this->Auth->user();
            $user=$this->Auth->user();
            if($user['user_group_id']==1)
            {
                $vehicles = TableRegistry::get('vehicles')
                    ->find()
                    ->select(['vehicles.title','vehicles.load_capacity','vehicles.vehicle_location','vehicles.serial_no','vehicles.vehicle_status','employees.name_en'])

                    ->leftJoin('assign_vehicles','assign_vehicles.vehicle_id = vehicles.id')
                    ->leftJoin('employees','employees.id = assign_vehicles.employee_id');
            }
            else
            {
                $query = TableRegistry::get('vehicles')->find();
                $vehicles = $query->select(['message_registers.work_description','schemes.name_bn','vehicles.id','vehicles.title','vehicles.load_capacity','vehicles.vehicle_location','vehicles.serial_no','vehicles.vehicle_status','employees.name_en'])
                    ->hydrate(false)
                    ->where(['vehicles.office_id'=>$user['office_id']])
                    ->leftJoin('assign_vehicles','assign_vehicles.vehicle_id = vehicles.id')
                    ->leftJoin('employees','employees.id = assign_vehicles.employee_id')
                    ->leftJoin('vehicle_hire','vehicle_hire.vehicle_id = vehicles.id')
                    ->leftJoin('vehicle_hire_letter_registers','vehicle_hire_letter_registers.id = vehicle_hire.letter_id')
                    ->leftJoin('receive_file_registers','receive_file_registers.id = vehicle_hire_letter_registers.resource_id')
                    ->leftJoin('schemes','schemes.id = receive_file_registers.scheme_id')
                    ->leftJoin('message_registers','message_registers.resource_id = receive_file_registers.id')
                    ->toArray();
            }

            foreach($vehicles as &$vehicle)
            {
                if(!empty($vehicle['message_registers']['work_description'])){
                    $vehicle['work_description']= $vehicle['message_registers']['work_description'];
                }elseif(!empty($vehicle['schemes']['name_bn'])){
                    $vehicle['work_description']= $vehicle['schemes']['name_bn'];
                }else{
                    $vehicle['work_description']= '';
                }
                $vehicle['work_description']= $vehicle['message_registers']['work_description'];
                $vehicle['employees'] =  $vehicle['employees']['name_en'];
                $vehicle['vehicle_status'] =$vehicle_status[$vehicle['vehicle_status']];
            }
            $this->response->body(json_encode($vehicles));
            return $this->response;
        }
        else
        {
            return $this->redirect(['controller'=>'Dashboard','action'=>'index']);
        }

    }
    //    Print report
    public function print_it()
    {
        $this->layout='print';
        $this->view='print';
        $officeTable = TableRegistry::get('offices');
        $user=$this->Auth->user();
        if($user['user_group_id']==1)
        {
            $vehicles = TableRegistry::get('vehicles')
                ->find()
                ->select(['vehicles.title','vehicles.load_capacity','vehicles.serial_no','vehicles.vehicle_status','vehicles.vehicle_location','employees.name_en','employees.mobile'])
                ->leftJoin('assign_vehicles','assign_vehicles.vehicle_id = vehicles.id')
                ->leftJoin('employees','employees.id = assign_vehicles.employee_id');
        }
        else
        {
            $query = TableRegistry::get('vehicles')->find();
            $vehicles = $query->select(['vehicles.id','vehicles.title','vehicles.load_capacity','vehicles.serial_no','vehicles.vehicle_status','vehicles.vehicle_location','employees.name_en','employees.mobile'])
                ->where(['vehicles.office_id'=>$user['office_id']])
                ->leftJoin('assign_vehicles','assign_vehicles.vehicle_id = vehicles.id')
                ->leftJoin('employees','employees.id = assign_vehicles.employee_id')
                ->toArray();
        }
        // Office Info
        $office = $officeTable->find()
            ->where(['id'=>$user['office_id']])
            ->first();
        $this->set(compact('vehicles','office'));
    }
}
