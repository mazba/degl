<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Tasks Controller
 *
 * @property \App\Model\Table\TasksTable $Tasks
 */
class TasksController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $tasks = $this->Tasks->find('all', [
            'conditions' =>['Tasks.status !=' => 99],
            'contain' => ['Components', 'Modules', 'CreatedUser', 'UpdatedUser']
        ]);
        $this->set('tasks', $tasks);
        $this->set('_serialize', ['tasks']);
    }

    /**
     * View method
     *
     * @param string|null $id Task id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $task = $this->Tasks->get($id, [
            'contain' => ['Components', 'Modules', 'CreatedUser', 'UpdatedUser']
        ]);
        $this->set('task', $task);
        $this->set('_serialize', ['task']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $components = $this->Tasks->Components->find('list');
        $modules = array();
        $task = $this->Tasks->newEntity();
        if ($this->request->is('post'))
        {
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            $task = $this->Tasks->patchEntity($task, $data);
            if ($this->Tasks->save($task))
            {
                $this->Flash->success(__('The task has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $modules = $this->Tasks->Modules->find('list',
                    [
                        'conditions' =>[
                            'status !=' => 99,
                            'component_id'=>$this->request->data['component_id']
                        ]
                    ]
                );
                $this->Flash->error(__('The task could not be saved. Please, try again.'));
            }
        }

        $createdUser = $this->Tasks->CreatedUser->find('list', ['limit' => 200]);
        $updatedUser = $this->Tasks->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('task', 'components', 'modules', 'createdUser', 'updatedUser'));
        $this->set('_serialize', ['task']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Task id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $components = $this->Tasks->Components->find('list');
        $task = $this->Tasks->get($id, [
            'contain' => []
        ]);
        $task = $this->Tasks->get($id, [
            'contain' => []
        ]);
        $modules = $this->Tasks->Modules->find('list',
            [
                'conditions' =>[
                    'status !=' => 99,
                    'component_id'=>$task->component_id
                ]
            ]
        );
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $data=$this->request->data;
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['updated_by']=$user['id'];
            $data['updated_date']=time();
            $task = $this->Tasks->patchEntity($task, $data);
            if ($this->Tasks->save($task))
            {
                $this->Flash->success(__('The task has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The task could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('task', 'components', 'modules'));
        $this->set('_serialize', ['task']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Task id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $task = $this->Tasks->get($id);

        $user=$this->Auth->user();
        $data=$this->request->data;
        $data['updated_by']=$user['id'];
        $data['updated_date']=time();
        $data['status']=99;
        $task = $this->Tasks->patchEntity($task, $data);
        if ($this->Tasks->save($task))
        {
            $this->Flash->success(__('The task has been deleted.'));
        }
        else
        {
            $this->Flash->error(__('The task could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    public function ajax($task)
    {
        $this->layout='ajax';
        if($task=='get_modules_by_componentId')
        {
            $this->view = 'get_modules_by_componentId';

            $modules = $this->Tasks->Modules->find('list',
                [
                    'conditions' =>[
                        'status !=' => 99,
                        'component_id'=>$this->request->data['component_id']
                    ]
                ]
            );
            $this->set(compact('modules'));
            //$this -> render('get_modules_by_componentId');
        }


    }
}
