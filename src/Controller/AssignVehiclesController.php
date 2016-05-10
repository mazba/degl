<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * AssignVehicles Controller
 *
 * @property \App\Model\Table\AssignVehiclesTable $AssignVehicles
 */
class AssignVehiclesController extends AppController
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
     * @param string|null $id Assign Vehicle id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $assignVehicle = $this->AssignVehicles->get($id, [
            'contain' => ['Offices', 'Vehicles', 'Employees', 'CreatedUser', 'UpdatedUser']
        ]);
        $this->set('assignVehicle', $assignVehicle);
        $this->set('_serialize', ['assignVehicle']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $assignVehicle = $this->AssignVehicles->newEntity();
        $user=$this->Auth->user();
        if ($this->request->is('post'))
        {
            $data=$this->request->data;
            $exists = $this->AssignVehicles->exists(['office_id' => $data['office_id'],'employee_id'=>$data['employee_id'],'status' => 1]);
            if($exists)
            {
                $this->Flash->error(__('This Driver already assigned with a vehicle.Please free him first.'));
            }
            else
            {

                $data['created_by']=$user['id'];
                $data['created_date']=time();
                $x=strtotime($data['assign_date']);
                if($x!==false)
                {
                    $data['assign_date']=$x;
                }
                else
                {
                    $data['assign_date']='';
                }
                /*$x=strtotime($data['end_date']);
                if($x!==false)
                {
                    $data['end_date']=$x;
                }
                else
                {
                    $data['end_date']='';
                }*/
                $assignVehicle = $this->AssignVehicles->patchEntity($assignVehicle, $data);
                if ($this->AssignVehicles->save($assignVehicle))
                {
                    $this->Flash->success(__('The assign vehicle has been saved.'));
                    return $this->redirect(['action' => 'index']);
                }
                else
                {
                    $this->Flash->error(__('The assign vehicle could not be saved. Please, try again.'));
                }
            }


        }
        $offices = $this->AssignVehicles->Offices->find('list', ['conditions' =>['id' => $user['office_id']]]);
        $vehicles = $this->AssignVehicles->Vehicles->find('list', ['conditions' =>['office_id' => $user['office_id']]]);
        $employees = $this->AssignVehicles->Employees->find('list')
            ->innerJoin('designations', 'designations.id = Employees.designation_id')
            ->where(['designations.office_id'=>$user['office_id'],'Employees.office_id'=>$user['office_id'],'designations.name_en'=>'Driver']);
        $this->set(compact('assignVehicle', 'offices', 'vehicles', 'employees'));
        $this->set('_serialize', ['assignVehicle']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Assign Vehicle id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $assignVehicle = $this->AssignVehicles->get($id, [
            'contain' => []
        ]);
        $user=$this->Auth->user();
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $data=$this->request->data;

            $data=$this->request->data;
            $data['updated_by']=$user['id'];
            $data['updated_date']=time();
            $data['status']=0;
            $x=strtotime($data['end_date']);
            if($x!==false)
            {
                $data['end_date']=$x;
            }
            else
            {
                $data['end_date']='';
            }
            $assignVehicle = $this->AssignVehicles->patchEntity($assignVehicle, $data);
            if ($this->AssignVehicles->save($assignVehicle))
            {
                $this->Flash->success('This driver has been removed.');
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error('Saving Error. Please, try again.');
            }
        }
        $offices = $this->AssignVehicles->Offices->find('list', ['conditions' =>['id' => $user['office_id']]]);
        $vehicles = $this->AssignVehicles->Vehicles->find('list', ['conditions' =>['office_id' => $user['office_id']]]);
        $employees = $this->AssignVehicles->Employees->find('list', ['conditions' =>['office_id' => $user['office_id']]]);
        $this->set(compact('assignVehicle', 'offices', 'vehicles', 'employees'));
        $this->set('_serialize', ['assignVehicle']);
    }

    //Ajax
    public function ajax($action = null)
    {
        if($action == 'get_grid_data' && $this->user_roles['index'])
        {
            $user=$this->Auth->user();
            if($user['user_group_id']==1)
            {
                $assignVehicles = $this->AssignVehicles->find('all', [
                    'conditions' =>['AssignVehicles.status' => 1],
                    'contain' => [ 'Vehicles', 'Employees']
                ])->toArray();
            }
            else
            {
                $assignVehicles = $this->AssignVehicles->find('all', [
                    'conditions' =>['AssignVehicles.status' => 1,'AssignVehicles.office_id'=>$user['office_id']],
                    'contain' => ['Vehicles', 'Employees']
                ])->toArray();
            }
            foreach($assignVehicles as &$assignVehicle)
            {
                $assignVehicle['assign_date'] = date('d/m/Y',$assignVehicle['assign_date']);
                $assignVehicle['end_date'] = $assignVehicle['end_date'] ? date('d/m/Y',$assignVehicle['end_date']) : '';
                $assignVehicle['registration_no'] = $assignVehicle['vehicle']['registration_no'];
                $assignVehicle['vehicle'] = $assignVehicle['vehicle']['title'];
                $assignVehicle['employee'] = $assignVehicle['employee']['name_en'];
                $assignVehicle['action'] = '<a title="'.__('View').'" class="icon-newspaper" href="'.$this->request->webroot.'AssignVehicles/view/'.$assignVehicle['id'].'" ><a> &nbsp'.'<a title="'.__('Edit').'" class="icon-pencil3 text-danger" href="'.$this->request->webroot.'AssignVehicles/edit/'.$assignVehicle['id'].'" ><a>';
            }
            $this->response->body(json_encode($assignVehicles));
            return $this->response;
        }
        else
        {
            return $this->redirect(['controller'=>'Dashboard','action'=>'index']);
        }

    }
}
