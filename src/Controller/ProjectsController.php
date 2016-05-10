<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Projects Controller
 *
 * @property \App\Model\Table\ProjectsTable $Projects
 */
class ProjectsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $projects = $this->Projects->find('all', [
            'conditions' =>['Projects.status' => 1],
            'contain' => ['DevelopmentPartners', 'CreatedUser', 'UpdatedUser']
        ]);
        $this->set('projects', $projects);
        $this->set('_serialize', ['projects']);
    }

    /**
     * View method
     *
     * @param string|null $id Project id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $project = $this->Projects->get($id, [
            'contain' => ['DevelopmentPartners', 'CreatedUser', 'UpdatedUser', 'ReceiveFileRegisters','Sector']
        ]);
        $this->set('project', $project);
        $this->set('_serialize', ['project']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $project = $this->Projects->newEntity();
        if ($this->request->is('post'))
        {
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['start_date']=strtotime($data['start_date']);
            $data['expected_completion_date']=strtotime($data['expected_completion_date']);
            $data['completion_date']=strtotime($data['expected_completion_date']);
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            $project = $this->Projects->patchEntity($project, $data);
            if ($project=$this->Projects->save($project))
            {
                if (!empty($data['parent_id'])) {
                    $this->loadModel('nothi_assigns');
                    $nothi_data = array();
                    $nothi_data['nothi_register_id'] = $data['parent_id'];
                    $nothi_data['project_id'] = $project['id'];
                    $new_nothi = $this->nothi_assigns->newEntity();
                    $nothi = $this->nothi_assigns->patchEntity($new_nothi, $nothi_data);
                    $this->nothi_assigns->save($nothi);
                }
                $this->Flash->success(__('The project has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The project could not be saved. Please, try again.'));
            }
        }
        $this->loadModel('Sectors');
        $sectors=$this->Sectors->find('list',['conditions' => ['status !=' =>99]]);
        $developmentPartners = $this->Projects->DevelopmentPartners->find('list', ['conditions' => ['status !=' =>99]]);
        $this->loadModel('NothiRegisters');
        $nothiRegisters = $this->NothiRegisters->find('list', [
            'conditions' => ['status' => 1, 'parent_id' => 0],
        ])->toArray();
        $this->set(compact('project', 'developmentPartners','sectors','nothiRegisters'));
        $this->set('_serialize', ['project']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Project id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $project = $this->Projects->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $user=$this->Auth->user();
            $data=$this->request->data;

            $data['start_date']=strtotime($data['start_date']);
            if($data['expected_completion_date'])
            {
                $data['completion_date']=$data['expected_completion_date']=strtotime($data['expected_completion_date']);
            }
            if($data['extended_completion_date'])
            {
                $data['completion_date']=$data['extended_completion_date']=strtotime($data['extended_completion_date']);
            }
            if($data['actual_completion_date'])
            {
                $data['completion_date']=$data['actual_completion_date']=strtotime($data['actual_completion_date']);
            }

            $data['updated_by']=$user['id'];
            $data['updated_date']=time();
            $project = $this->Projects->patchEntity($project, $data);
            if ($this->Projects->save($project))
            {
                if (!empty($data['parent_id'])) {

                    $this->loadModel('nothi_assigns');
                    $nothi_file = $this->nothi_assigns->find()
                        ->where(['project_id' => $id])
                        ->first();

                    if (!empty($nothi_file)) {
                        $arr = array();
                        $arr['nothi_register_id'] = $data['parent_id'];
                        $nothi = $this->nothi_assigns->patchEntity($nothi_file, $arr);
                        $this->nothi_assigns->save($nothi);
                    } else {
                        $nothi_data = array();
                        $nothi_data['nothi_register_id'] = $data['parent_id'];
                        $nothi_data['project_id'] = $id;
                        $new_nothi = $this->nothi_assigns->newEntity();
                        $nothi = $this->nothi_assigns->patchEntity($new_nothi, $nothi_data);
                        $this->nothi_assigns->save($nothi);
                    }

                }
                $this->Flash->success(__('The project has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The project could not be saved. Please, try again.'));
            }
        }
        $this->loadModel('Sectors');
        $sectors=$this->Sectors->find('list',['conditions' => ['status !=' =>99]]);
        $developmentPartners = $this->Projects->DevelopmentPartners->find('list', ['conditions' => ['status !=' =>99]]);
        $this->loadModel('NothiRegisters');
        $nothiRegisters = $this->NothiRegisters->find('list', [
            'conditions' => ['status' => 1, 'parent_id' => 0],
        ])->toArray();
        $this->loadModel('nothi_assigns');
        $nothi = $this->nothi_assigns->find()->select(['nothi_register_id'])->where(['project_id' => $id])->first();
        if (!empty($nothi)) {
            $selected_nothi=$this->NothiRegisters->find()->select(['nothi_no'])->where(['id'=>$nothi['nothi_register_id']])->first();
            $this->set(compact('selected_nothi'));
        }
        $this->set(compact('project', 'developmentPartners','sectors','nothiRegisters'));
        $this->set('_serialize', ['project']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Project id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $project = $this->Projects->get($id);

        $user=$this->Auth->user();
        $data=$this->request->data;
        $data['updated_by']=$user['id'];
        $data['updated_date']=time();
        $data['status']=99;
        $project = $this->Projects->patchEntity($project, $data);
        if ($this->Projects->save($project))
        {
            $this->Flash->success(__('The project has been deleted.'));
        }
        else
        {
            $this->Flash->error(__('The project could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

//    mazba

    /**
     * Edit method
     *
     * @param string|null $id Project id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function change_status($id = null)
    {
        $project = $this->Projects->get($id);
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['completion_date'] = strtotime($data['completion_date']);
            $data['actual_completion_date'] = $data['completion_date'];
            $data['updated_by']=$user['id'];
            $data['updated_date']=time();
            $project = $this->Projects->patchEntity($project, $data);
            if ($this->Projects->save($project))
            {
                $this->Flash->success(__('The project Status has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The project Status could not be saved. Please, try again.'));
            }
        }
        $this->set(compact(['project']));
        $this->set('_serialize', ['project']);
    }

}
