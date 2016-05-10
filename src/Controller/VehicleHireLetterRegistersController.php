<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
/**
 * VehicleHireLetterRegisters Controller
 *
 * @property \App\Model\Table\VehicleHireLetterRegistersTable $VehicleHireLetterRegisters
 */
class VehicleHireLetterRegistersController extends AppController
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
     * @param string|null $id Vehicle Hire Letter Register id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user=$this->Auth->user();
        $vehicleHireLetterRegister = $this->VehicleHireLetterRegisters->get($id, [
            'contain' => ['Schemes', 'CreatedUser', 'UpdatedUser']
        ]);
        $files_table = TableRegistry::get('files');
        $query = $files_table->find();
        $query->where(['table_name'=>'receive_file_registers','table_key'=>$vehicleHireLetterRegister->resource_id]);
        $files=$query->toArray();
        $this->set('vehicleHireLetterRegister', $vehicleHireLetterRegister);
        $this->set('files', $files);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user=$this->Auth->user();
        $vehicleHireLetterRegister = $this->VehicleHireLetterRegisters->newEntity();
        if ($this->request->is('post'))
        {

            $inputs = $this->request->data;
            $files=array();
            $file_upload_complete=true;

            $base_upload_path=WWW_ROOT.'files/vehicle_files';
            for($i=0; $i<sizeof($_FILES['attachments']['name']); $i++)
            {
                $tmp_name = $_FILES['attachments']['tmp_name'][$i];
                //Get the temp file path
                if($tmp_name)
                {

                    $name = time().'_'.str_replace(' ','_',$_FILES['attachments']['name'][$i]);
                    if(move_uploaded_file($tmp_name, $base_upload_path.'/'.$name))
                    {
                        $files[]['file_path']=$name;
                    }
                    else
                    {
                        $file_upload_complete=false;
                        break;
                    }
                }
            }

            if($file_upload_complete)
            {
                $time=time();
                $data=array();
//                $data['letter_no']=$inputs['letter_no'];
                $data['sarok_no']=$inputs['sarok_no'];
                $data['subject']=$inputs['subject'];
                $data['sender_office']=$inputs['sender_office'];
                $data['receive_office']=$user['office_id'];
                $x=strtotime($inputs['receive_date']);
                if($x!==false)
                {
                    $data['receive_date']=$x;
                }
                else
                {
                    $data['receive_date']='';
                }
                $data['scheme_id'] = $inputs['scheme_id'];
//                $data['client_name']=$inputs['client_name'];
//                $data['client_phone']=$inputs['client_phone'];
//                $data['client_email']=$inputs['client_email'];
//                $data['client_fax']=$inputs['client_fax'];
                $data['work_description']=$inputs['work_description'];
                $data['receive_from']=$inputs['receive_from'];
                $data['remarks']=$inputs['remarks'];
                $data['created_by'] = $user['id'];
                $data['created_date'] = $time;
                $data['status'] = 1;

                $vehicleHireLetterRegister = $this->VehicleHireLetterRegisters->patchEntity($vehicleHireLetterRegister, $data);

                if ($status=$this->VehicleHireLetterRegisters->save($vehicleHireLetterRegister))
                {
                    $files_table = TableRegistry::get('files');
                    foreach($files as $file)
                    {
                        $file_data=array();
                        $file_data['file_path']=$file['file_path'];
                        $file_data['table_name']='vehicle_hire_letter_registers';
                        $file_data['table_key']=$status['id'];
                        $file_data['created_by']= $user['id'];
                        $file_data['created_date']= $time;
                        $file_data['status']= 1;
                        $file_query = $files_table->query();
                        $file_query->insert(array_keys($file_data))
                            ->values($file_data)
                            ->execute();
                    }
                    $this->Flash->success(__('Letter has been saved.'));
                    return $this->redirect(['action' => 'index']);
                }
                else
                {
                    $this->Flash->error(__('Saving failed. Please, try again.'));
                }
            }
            else
            {
                $this->Flash->error(__('File Upload Error. Please, try again.'));
            }
        }
        $schemes = $this->VehicleHireLetterRegisters->Schemes->find('list')
            ->innerJoin('project_offices', 'project_offices.project_id = Schemes.project_id')
            ->leftJoin('projects', 'projects.id = Schemes.project_id')
            ->where(['project_offices.office_id'=>$user['office_id']]);
        $offices = $this->VehicleHireLetterRegisters->Offices->find('list');
        $this->set(compact('vehicleHireLetterRegister', 'schemes','offices'));
        $this->set('_serialize', ['vehicleHireLetterRegister']);
    }

    //Ajax
    public function ajax($action = null)
    {
        if($action == 'get_grid_data' && $this->user_roles['index'])
        {
            $user = $this->Auth->user();
            $vehicleHireLetterRegisters = $this->VehicleHireLetterRegisters->find('all', [
                'conditions' =>['VehicleHireLetterRegisters.status !=' => 99],'order'=>['VehicleHireLetterRegisters.created_date'=>'desc']
            ])->toArray();
            foreach($vehicleHireLetterRegisters as &$vehicleHireLetterRegister)
            {
                $vehicleHireLetterRegister['receive_date']= date('d/m/Y',$vehicleHireLetterRegister['receive_date']);
                $vehicleHireLetterRegister['action']= '<a title="'.__('View').'" class="icon-newspaper" href="'.$this->request->webroot.'VehicleHireLetterRegisters/view/'.$vehicleHireLetterRegister['id'].'" ><a>';
            }
//            echo '<pre>';
//            print_r($vehicleHireLetterRegisters);
//            echo '</pre>';
//            die;
            $this->response->body(json_encode($vehicleHireLetterRegisters));
            return $this->response;
        }
        else
        {
            return $this->redirect(['controller'=>'Dashboard','action'=>'index']);
        }

    }
}
