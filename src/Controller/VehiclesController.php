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
            $user = $this->Auth->user();
            //pr($user);die;
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
//        pr($vehicle);die;
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
                    'conditions' => ['Vehicles.status' => 1, 'Vehicles.office_id' => $user['office_id']]
                ])->toArray();
                //pr($vehicles);die;
            }
            foreach ($vehicles as &$vehicle) {
                if ($vehicle['type'] != 'vehicles') {

                    $vehicle['title'] = $vehicle['title'].' ('.$vehicle['equipment_id_no'].')';
                    $vehicle['serial_no'] = $vehicle['equipment_category'];
                    $vehicle['registration_no'] = $vehicle['equipment_brand'];
                    $vehicle['load_capacity'] = $vehicle['equipment_capacity'];
                }
                $vehicle['vehicle_status'] = $vehicle_status[$vehicle['vehicle_status']];
                $vehicle['action'] = '<a title="' . __('View') . '" class="icon-newspaper" href="' . $this->request->webroot . 'Vehicles/view/' . $vehicle['id'] . '" ></a> &nbsp' .
                    '<a title="' . __('Edit') . '" class="icon-pencil3 text-warning" href="' . $this->request->webroot . 'Vehicles/edit/' . $vehicle['id'] . '" ></a> &nbsp' .
                    '<a title="' . __('Delete') . '" class="icon-remove3 text-danger" onclick="return confirm(\'Are you sure to delete?\');" href="' . $this->request->webroot . 'Vehicles/delete/' . $vehicle['id'] . '" ></a> &nbsp' .
                    '<a title="' . __('Servicing Report') . '" class="icon-certificate text-info" href="' . $this->request->webroot . 'Vehicles/service_report/' . $vehicle['id'] . '" ></a> &nbsp' .
                    '<a title="' . __('Vehicle Driver Report') . '" class="icon-bus text-info" href="' . $this->request->webroot . 'Vehicles/driver_report/' . $vehicle['id'] . '" ></a>';
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
        $services = $this->VehicleServicings->find('all', [
            'contain'=>['VehicleServicingDetails'],
            'conditions' => ['VehicleServicings.vehicle_id' => $id]
        ]);


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

    /**
     * Vehicle list controller
     */
    public function vehicleList(){

        if($this->request->is(['post'])){
            $data = $this->request->data();
            $this->loadModel('VehicleServicings');
            $this->loadModel('FinancialYearEstimates');
            $user = $this->Auth->user();
            $query = TableRegistry::get('vehicles')->find();

            $conditions = [
                'vehicles.status !=' =>99,
                'vehicle_servicings.status !=' =>99,
            ];
            if(isset($data['financial_year_estimate_id']) && !empty($data['financial_year_estimate_id']))
            {
                $conditions['vehicle_servicings.financial_year_estimate_id'] = $data['financial_year_estimate_id'];
                $finalcialYear = $this->FinancialYearEstimates->find('all')->select(['name'])->where(['id' => $data['financial_year_estimate_id']])->first();
            }
                $vehicles = $query->select([
                    'id' => 'vehicles.id',
                    'title' => 'vehicles.title',
                    'type' => 'vehicles.type',
                    'registration_no' => 'vehicles.registration_no',
                    'equipment_engine_capacity' => 'vehicles.equipment_engine_capacity',
                    'country_of_origin' => 'vehicles.country_of_origin',
                    'equipment_source' => 'vehicles.equipment_source',
                    'vehicle_status' => 'vehicles.vehicle_status',
                ])
                    ->where(['vehicles.status !=' =>99])
                    ->hydrate(false)
                    ->toArray();

            $vehiclesCosts = TableRegistry::get('vehicles')->find()->select([
                    'vehicle_id' => 'vehicle_servicings.vehicle_id',
                    'serviceCost' => $query->func()->sum('vehicle_servicings.service_charge_approved')
                ])
                    ->leftJoin('vehicle_servicings', 'vehicle_servicings.vehicle_id = vehicles.id')
                    ->where($conditions)
                    ->group(['vehicle_servicings.vehicle_id'])
                    ->hydrate(false)
                    ->toArray();

            $results = array();
            foreach($vehicles as $key => $vehicle){
                $results[$key]['title'] = $vehicle['title'];
                $results[$key]['type'] = $vehicle['type'];
                $results[$key]['registration_no'] = $vehicle['registration_no'];
                $results[$key]['equipment_engine_capacity'] = $vehicle['equipment_engine_capacity'];
                $results[$key]['country_of_origin'] = $vehicle['country_of_origin'];
                $results[$key]['equipment_source'] = $vehicle['equipment_source'];
                $results[$key]['vehicle_status'] = $vehicle['vehicle_status'];

                foreach($vehiclesCosts as $vehiclesCost){
                    if($vehiclesCost['vehicle_id'] == $vehicle['id']){
                        $results[$key]['serviceCost'] = $vehiclesCost['serviceCost'];
                    }
                }
            }
                $this->set(compact('results','finalcialYear'));
            }
        $this->loadModel('FinancialYearEstimates');
        $finalcialYears = $this->FinancialYearEstimates->find('list')->where(['status !='=> 99])->toArray();
        $this->set(compact('finalcialYears'));
    }

    /**
     *  Revenue And Others Information
     */
    public function revenueOthers(){
        $this->loadModel('FinancialYearEstimates');
        if($this->request->is(['post'])) {

            $data = $this->request->data();
            $this->loadModel('vehicles');
            $mechanical_status = [];
            // active vt roller 3.5
            $vt_roller_three_five = $this->vehicles->find()->select([
                'vt_roller_three_five' => 'equipment_type'
            ])
                ->where([
                    'type' => 'equipments',
                    'equipment_type' => 'vt',
                    'equipment_engine_capacity' => '3.5',
                    'vehicle_status !=' => 'DAMAGE',
                    'status !=' => '99',
                ])->count();

            // active vt roller 7
            $vt_roller_seven = $this->vehicles->find()->select([
                'vt_roller_seven' => 'equipment_type'
            ])
                ->where([
                    'type' => 'equipments',
                    'equipment_type' => 'vt',
                    'equipment_engine_capacity' => '7',
                    'vehicle_status !=' => 'DAMAGE',
                    'status !=' => '99',
                ])->count();

            // active static roller 8-10
            $static_roller_eight_ten = $this->vehicles->find()->select([
                'static_roller_eight_ten' => 'equipment_type'
            ])
                ->where([
                    'type' => 'equipments',
                    'equipment_type' => 'static',
                    'equipment_engine_capacity' => '8-10',
                    'vehicle_status !=' => 'DAMAGE',
                    'status !=' => '99',
                ])->count();

            // active Tyre roller
            $tyre_roller = $this->vehicles->find()->select([
                'tyre_roller' => 'equipment_type'
            ])
                ->where([
                    'type' => 'equipments',
                    'equipment_type' => 'tyre',
                    'vehicle_status !=' => 'DAMAGE',
                    'status !=' => '99',
                ])->count();

            // deactivate Tyre roller
            $vt_roller_damage = $this->vehicles->find()->select([
                'vt_roller_damage' => 'equipment_type'
            ])
                ->where([
                    'type' => 'equipments',
                    'equipment_type' => 'vt',
                    'vehicle_status ' => 'DAMAGE',
                    'status !=' => '99',
                ])->count();

            $static_roller_damage = $this->vehicles->find()->select([
                'static_roller_damage' => 'equipment_type'
            ])
                ->where([
                    'type' => 'equipments',
                    'equipment_type' => 'static',
                    'vehicle_status' => 'DAMAGE',
                    'status !=' => '99',
                ])->count();

            // active vehicle zip
            $active_zip = $this->vehicles->find()->select([
                'active_zip' => 'vehicle_type'
            ])
                ->where([
                    'type' => 'vehicles',
                    'vehicle_type' => 'zip',
                    'vehicle_status !=' => 'DAMAGE',
                    'status !=' => '99',
                ])->count();

            // active vehicle pickup
            $active_pickup = $this->vehicles->find()->select([
                'active_pickup' => 'vehicle_type'
            ])
                ->where([
                    'type' => 'vehicles',
                    'vehicle_type' => 'pickup',
                    'vehicle_status !=' => 'DAMAGE',
                    'status !=' => '99',
                ])->count();

            // active Motor cycle
            $active_motorcycle = $this->vehicles->find()->select([
                'active_motorcycle' => 'vehicle_type'
            ])
                ->where([
                    'type' => 'vehicles',
                    'vehicle_type' => 'motorcycle',
                    'vehicle_status !=' => 'DAMAGE',
                    'status !=' => '99',
                ])->count();

            // active vehicle truck
            $active_truck = $this->vehicles->find()->select([
                'active_truck' => 'vehicle_type'
            ])
                ->where([
                    'type' => 'vehicles',
                    'vehicle_type' => 'truck',
                    'vehicle_status !=' => 'DAMAGE',
                    'status !=' => '99',
                ])->count();

            // active vehicle clunker
            $active_clunker = $this->vehicles->find()->select([
                'active_clunker' => 'vehicle_type'
            ])
                ->where([
                    'type' => 'vehicles',
                    'vehicle_type' => 'clunker',
                    'vehicle_status !=' => 'DAMAGE',
                    'status !=' => '99',
                ])->count();

            // deactivated vehicle clunker
            $deactivated_vehicle = $this->vehicles->find()->select([
                'deactivated_vehicle' => 'vehicle_type'
            ])
                ->where([
                    'type' => 'vehicles',
                    'vehicle_status ' => 'DAMAGE',
                    'status !=' => '99',
                ])->count();

            $mechanical_status = [
                'vt_roller_three_five' => $vt_roller_three_five,
                'vt_roller_seven' => $vt_roller_seven,
                'static_roller_eight_ten' => $static_roller_eight_ten,
                'tyre_roller' => $tyre_roller,
                'vt_roller_damage' => $vt_roller_damage,
                'static_roller_damage' => $static_roller_damage,
                'active_zip' => $active_zip,
                'active_pickup' => $active_pickup,
                'active_motorcycle' => $active_motorcycle,
                'active_truck' => $active_truck,
                'active_clunker' => $active_clunker,
                'deactivated_vehicle' => $deactivated_vehicle,
            ];

            // Financial year info
            $finalcialYearData = $this->FinancialYearEstimates->find('all')->select(['name'])->where(['id' => $data['financial_year_estimate_id']])->first();
            // hire charges
            /*$this->loadModel('HireCharges');
            $hireChargeQuery = $this->HireCharges->find('all');
            $hireChargeResult = $hireChargeQuery
                ->select(['total_amount' => $hireChargeQuery->func()->sum('total_amount')])
                ->where(['financial_year_id' => $data['financial_year_estimate_id'], 'status !=' =>99])
                ->group('financial_year_id')
                ->first();*/
            $this->loadModel('EquipmentRevenues');
            $income = $this->EquipmentRevenues->find()
                ->select(['month', 'income', 'expense','total_expense'])
                ->where([
                    'financial_year_estimate_id' => $data['financial_year_estimate_id'],
                    'month' => $data['month'],
                    'status' => 1
                ])
                ->first();

            // cost charges
            /*$this->loadModel('VehicleServicings');
            $vehicleCostQuery = $this->VehicleServicings->find('all');
            $vehicleCostResult = $vehicleCostQuery
                ->select(['service_charge' => $vehicleCostQuery->func()->sum('service_charge_approved')])
                ->where(['financial_year_estimate_id' => $data['financial_year_estimate_id'], 'status !=' =>99])
                ->group('financial_year_estimate_id')
                ->first();*/

            $this->set(compact('mechanical_status','finalcialYearData','income'));
        }
        $finalcialYears = $this->FinancialYearEstimates->find('list')->where(['status !='=> 99])->toArray();
        $this->set(compact('finalcialYears'));
    }
}
