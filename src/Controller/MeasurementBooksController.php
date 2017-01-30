<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Database\Schema\Table;
use Cake\ORM\TableRegistry;

/**
 * MeasurementBooks Controller
 *
 * @property \App\Model\Table\MeasurementBooksTable $MeasurementBooks
 */
class MeasurementBooksController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $user=$this->Auth->user();
        $measurementBooks = $this->MeasurementBooks->find('all', [
            'conditions' =>['MeasurementBooks.status !=' => 99],
            'contain' => ['Offices', 'Schemes', 'Contractors', 'CreatedUser', 'UpdatedUser']
        ]);
        $this->set('measurementBooks', $measurementBooks);
        $this->set('_serialize', ['measurementBooks']);
    }

    /**
     * View method
     *
     * @param string|null $id Measurement Book id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user=$this->Auth->user();
        $measurementBook = $this->MeasurementBooks->get($id, [
            'contain' => ['Offices', 'Schemes', 'Contractors', 'CreatedUser', 'UpdatedUser']
        ]);
        $this->set('measurementBook', $measurementBook);
        $this->set('_serialize', ['measurementBook']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user=$this->Auth->user();
        $measurementBook = $this->MeasurementBooks->newEntity();
        if ($this->request->is('post'))
        {

            $data=$this->request->data;

            $scheme_contractors_table=TableRegistry::get('scheme_contractors');
            $contractor=$scheme_contractors_table->find()->where(['scheme_id'=>$data['scheme_id'],'is_lead'=>1])->first();
            if(!$contractor)
            {
                $this->Flash->error(__('No lead Contarctor Found try to assign a contractor first.'));
            }
            else
            {
                $data['created_by']=$user['id'];
                $data['created_date']=time();
                $data['office_id']=$user['office_id'];
                $data['contractor_id']=$contractor->id;
                $x=strtotime($data['work_commencement_date']);
                if($x!==false)
                {
                    $data['work_commencement_date']=$x;
                }
                else
                {
                    $data['work_commencement_date']=0;
                }
                $x=strtotime($data['work_completion_date']);
                if($x!==false)
                {
                    $data['work_completion_date']=$x;
                }
                else
                {
                    $data['work_completion_date']=0;
                }
                $measurementBook = $this->MeasurementBooks->patchEntity($measurementBook, $data);
              //  echo "<pre>";print_r($measurementBook);die();
                if ($this->MeasurementBooks->save($measurementBook))
                {
                    $this->Flash->success(__('The measurement book has been saved.'));
                    return $this->redirect(['action' => 'index']);
                }
                else
                {
                    $this->Flash->error(__('The measurement book could not be saved. Please, try again.'));
                }
            }


        }
        $schemes = $this->MeasurementBooks->Schemes->find('list')
            ->innerJoin('project_offices', 'project_offices.project_id = Schemes.project_id')
            ->leftJoin('projects', 'projects.id = Schemes.project_id')
            ->where(['project_offices.office_id'=>$user['office_id']]);
        $this->set(compact('measurementBook', 'offices', 'schemes', 'contractors'));
        $this->set('_serialize', ['measurementBook']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Measurement Book id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user=$this->Auth->user();
        $measurementBook = $this->MeasurementBooks->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $data=$this->request->data;
            $data['updated_by']=$user['id'];
            $data['updated_date']=time();
            $x=strtotime($data['work_commencement_date']);
            if($x!==false)
            {
                $data['work_commencement_date']=$x;
            }
            else
            {
                $data['work_commencement_date']=0;
            }
            $x=strtotime($data['work_completion_date']);
            if($x!==false)
            {
                $data['work_completion_date']=$x;
            }
            else
            {
                $data['work_completion_date']=0;
            }
            $measurementBook = $this->MeasurementBooks->patchEntity($measurementBook, $data);
            if ($this->MeasurementBooks->save($measurementBook))
            {
                $this->Flash->success(__('The measurement book has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The measurement book could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('measurementBook'));
        $this->set('_serialize', ['measurementBook']);
    }

    /**
     * Measurement index
     *
     * @param Measurement book id
     */
    public function measurement_index($id = null)
    {
        $measurements = TableRegistry::get('measurements')
            ->find()
            ->select(['id','measurement_no'])
            ->where(['measurement_book_id'=>$id])
            ->hydrate(false)
            ->group(['measurement_no'])
            ->toArray();

        $this->set(compact('id','measurements'));
    }
    /**
     * Add new Measurement
     *
     * @param Measurement book id
     */
    public function add_measurement($id = null)
    {
        $user = $this->Auth->user();
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $input = $this->request->data;
            // measurement
            $measurement = TableRegistry::get('measurements')
                ->find()
                ->select(['measurement_no'])
                ->where(['measurement_book_id'=>$id])
                ->order(['measurement_no'=>'DESC'])
                ->first();
            // SAVE...
            $data['measurement_book_id'] = $id;
            $data['measurement_no'] = (isset($measurement['measurement_no']) ? $measurement['measurement_no']+1 : 1);
            $x=strtotime($input['measurement_date']);
            if($x!==false)
            {
                $data['measurement_date'] = $x;
            }
            else
            {
                $data['measurement_date']='';
            }
            $data['created_by'] = $user['id'];
            $data['created_date'] = $id;
            $data['status'] = 1;

            $measurements_table = TableRegistry::get('measurements');
            $query = $measurements_table->query();
            foreach($input['item'] as $item)
            {
                $data['scheme_details_id'] = $item['id'];
                $data['quantity_of_work_done'] = $item['quantity_of_work_done'];
                $query->insert(array_keys($data))
                    ->values($data);
            }
            $query->execute();

            $this->Flash->success('All Measurement Saved.');
            return $this->redirect(['action' => 'index']);
        }

        // measurement book
        $m_book = $this->MeasurementBooks->get($id, [
            'contain' => ['Schemes']
        ])->toArray();
        // measurement book wise scheme
        $this->loadModel('SchemeDetails');
        $scheme_details = $this->SchemeDetails->find('all')
            ->select(['id','item_code','comp_serial_no'])
            ->where(['scheme_id'=>$m_book['scheme']['id'],'status'=>1])
            ->hydrate(false)
            ->toArray();

        $this->set(compact('scheme_details','id'));
    }
    /**
     * Edit new Measurement
     *
     * @param Measurement book id, measurement no
     */
    public function edit_measurement($id = null,$measurement_no = null)// id measurement book id, measurement_no
    {
        $user = $this->Auth->user();
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $input = $this->request->data;
            if(isset($input['item']))
            {
                $measurements_table = TableRegistry::get('measurements');
                $query = $measurements_table->query();
                $query->delete()
                    ->where(['measurement_book_id'=>$id,'measurement_no' => $measurement_no])
                    ->execute();

                // NOW save measurement ........................
                $data['measurement_book_id'] = $id;
                $data['measurement_no'] = $measurement_no;
                $x=strtotime($input['measurement_date']);
                if($x!==false)
                {
                    $data['measurement_date'] = $x;
                }
                else
                {
                    $data['measurement_date']='';
                }
                $data['created_by'] = $user['id'];
                $data['created_date'] = $id;
                $data['status'] = 1;
                $query = array();
                $query = $measurements_table->query();
                foreach($input['item'] as $item)
                {
                    $data['scheme_details_id'] = $item['id'];
                    $data['quantity_of_work_done'] = $item['quantity_of_work_done'];
                    $query->insert(array_keys($data))
                        ->values($data);
                }
                $query->execute();
                $this->Flash->success('Measurement Update');
                return $this->redirect(['action' => 'measurement_index',$id]);
            }
            else
            {
                $this->Flash->error('Items Cannot be empty.');
                return $this->redirect(['action' => 'measurement_index',$id]);
            }
        }
        $old_measurements = TableRegistry::get('measurements')
            ->find()
            ->select(['measurements.quantity_of_work_done','measurements.scheme_details_id','measurements.measurement_date','scheme_details.id','scheme_details.item_code','scheme_details.item_id','scheme_details.financial_year','scheme_details.item_unit','scheme_details.total','scheme_details.rate','scheme_details.item_table','scheme_details.scheme_status','scheme_details.comp_serial_no','scheme_details.deducation','scheme_details.component_location','scheme_details.cl_length','scheme_details.cl_width','scheme_details.cl_height_depth','scheme_details.cl_area_volume','scheme_details.item_quantity','scheme_details.remarks','scheme_details.details'])
            ->where(['measurement_book_id'=>$id,'measurement_no'=>$measurement_no])
            ->leftJoin('scheme_details', 'scheme_details.id = measurements.scheme_details_id')
            ->hydrate(false)
            ->toArray();
        // if requested measurement not exits, redirect to index
        if(!$old_measurements)
        {
            $this->Flash->error('Measurement Not Exits.');
            return $this->redirect(['action' => 'index']);
        }
        // measurement book
        $m_book = $this->MeasurementBooks->get($id, [
            'contain' => ['Schemes']
        ])->toArray();
        // scheme Details
        $this->loadModel('SchemeDetails');
        $scheme_details = $this->SchemeDetails->find('all')
            ->select(['id','item_code','comp_serial_no'])
            ->where(['scheme_id'=>$m_book['scheme']['id'],'status'=>1])
            ->hydrate(false)
            ->toArray();
        $this->set(compact('id','measurement_no','old_measurements','scheme_details'));
    }

    /*public function delete($id = null)
    {

        $measurementBook = $this->MeasurementBooks->get($id);

        $user=$this->Auth->user();
        $data=$this->request->data;
        $data['updated_by']=$user['id'];
        $data['updated_date']=time();
        $data['status']=99;
        $measurementBook = $this->MeasurementBooks->patchEntity($measurementBook, $data);
        if ($this->MeasurementBooks->save($measurementBook))
        {
            $this->Flash->success('The measurement book has been deleted.');
        }
        else
        {
            $this->Flash->error('The measurement book could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }*/

    /**
     * get item details
     * @return item detail for ajax
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function get_item_details()
    {
        $this->layout='ajax';
        $input = $this->request->data;

        // Scheme Details INFO
        $this->loadModel('SchemeDetails');
        $scheme_details = $this->SchemeDetails->find()
            ->where(['id'=>$input['scheme_details_id']])
            ->hydrate(false)
            ->toArray();
        $scheme_details = (isset($scheme_details[0])? $scheme_details[0] : '');

        // Measurement INFO
        $measurement = TableRegistry::get('measurements')
            ->find()
            ->select(['quantity_of_work_done'])
            ->where(['measurement_book_id'=>$input['measurement_book_id'],'scheme_details_id'=>$input['scheme_details_id']])
            ->order(['measurement_no'=>'DESC'])
            ->first();
        $this->set(compact('scheme_details','measurement'));
    }

}
