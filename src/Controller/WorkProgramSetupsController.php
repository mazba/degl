<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * WorkProgramSetups Controller
 *
 * @property \App\Model\Table\WorkProgramSetupsTable $WorkProgramSetups
 */
class WorkProgramSetupsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $user=$this->Auth->user();
        $schemes = $this->WorkProgramSetups->Schemes->find('list')
            ->innerJoin('project_offices', 'project_offices.project_id = Schemes.project_id')
            ->leftJoin('projects', 'projects.id = Schemes.project_id')
            ->where(['project_offices.office_id'=>$user['office_id']]);
        $this->set('schemes', $schemes);
        $this->set('_serialize', ['workProgramSetups']);
    }

    /**
     * View method
     *
     * @param string|null $id Work Program Setup id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user=$this->Auth->user();
        $workProgramSetups = $this->WorkProgramSetups->find('all', [
            'conditions' => ['scheme_id'=>$id]
        ]);
        $this->set('workProgramSetups', $workProgramSetups);
        $this->set('_serialize', ['workProgramSetups']);
    }
    /**
     * Edit method
     *
     * @param string|null $id Work Program Setup id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user=$this->Auth->user();
        if ($this->request->is(['patch', 'post', 'put']))
        {
            // first delete all old data
            $this->WorkProgramSetups->deleteAll(['scheme_id'=>$id]);
            // then insert
            $workProgramSetup = $this->WorkProgramSetups->newEntity();
            $inputs=$this->request->data('data');
            $data = array();
            foreach($inputs as $scheme_details_id=>$input)
            {
                if(!empty($input['start_date']) || !empty($input['end_date']))
                {
                    $input['scheme_details_id']=$scheme_details_id;
                    $input['scheme_id']=$id;
                    $input['start_date']=strtotime($input['start_date']);
                    $input['end_date']=strtotime($input['end_date']);
                    $input['created_by']=$user['id'];
                    $input['created_date']=time();
                    $data[]=$input;
                }
            }
            $patched  = $this->WorkProgramSetups->newEntities($data);
            foreach($patched as $entity)
            {
                $this->WorkProgramSetups->save($entity);
            }
            $this->Flash->success(__('The work program setup has been saved.'));
            return $this->redirect(['action' => 'index']);
        }
        $old_data = $this->WorkProgramSetups->find('all',['conditions'=>['scheme_id'=>$id]]);
        $old_work_data = array();
        foreach($old_data as $data)
        {
            $old_work_data[$data['scheme_details_id']]['start_date'] = $data['start_date'];
            $old_work_data[$data['scheme_details_id']]['end_date'] = $data['end_date'];
            $old_work_data[$data['scheme_details_id']]['remarks'] = $data['remarks'];
        }
        $scheme_details = TableRegistry::get('scheme_details');
        $scheme_details = $scheme_details->find('all')
                ->where(['scheme_details.scheme_id'=>$id,'scheme_details.status'=>1]);
        $this->set(compact('scheme_details','old_work_data'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Work Program Setup id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $workProgramSetup = $this->WorkProgramSetups->get($id);

        $user=$this->Auth->user();
        $data=$this->request->data;
        $data['updated_by']=$user['id'];
        $data['updated_date']=time();
        $data['status']=99;
        $workProgramSetup = $this->WorkProgramSetups->patchEntity($workProgramSetup, $data);
        if ($this->WorkProgramSetups->save($workProgramSetup))
        {
            $this->Flash->success(__('The work program setup has been deleted.'));
        }
        else
        {
            $this->Flash->error(__('The work program setup could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
