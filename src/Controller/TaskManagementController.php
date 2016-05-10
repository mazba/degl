<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * TaskManagement Controller
 *
 * @property \App\Model\Table\TaskManagementTable $TaskManagement
 */
class TaskManagementController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $user = $this->Auth->user();
        $taskManagement = $this->TaskManagement->find('all', [
            'conditions' => ['TaskManagement.user_id ' => $user['id'], 'status' => 1],
            'order' => ['TaskManagement.id' => 'DESC']
        ]);
        $this->set('taskManagement', $taskManagement);
        $this->set('_serialize', ['taskManagement']);
    }

    /**
     * View method
     *
     * @param string|null $id Task Management id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $taskManagement = $this->TaskManagement->get($id, [
            'contain' => ['Users', 'CreatedUser', 'UpdatedUser']
        ]);
        $this->set('taskManagement', $taskManagement);
        $this->set('_serialize', ['taskManagement']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $taskManagement = $this->TaskManagement->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Auth->user();
            $data = $this->request->data;
            $time = time();
            $data['user_id'] = $user['id'];
            $x = strtotime($data['start_date_time']);
            if ($x !== false) {
                $data['start_date_time'] = $x;
            } else {
                $data['start_date_time'] = '';
            }
            $x = strtotime($data['end_date_time']);
            if ($x !== false) {
                $data['end_date_time'] = $x;
            } else {
                $data['end_date_time'] = '';
            }
            $x = strtotime($data['reminder_date']);
            if ($x !== false) {
                $data['reminder_date'] = $x;
            } else {
                $data['reminder_date'] = '';
            }
            $data['created_by'] = $user['id'];
            $data['created_date'] = $time;

            $taskManagement = $this->TaskManagement->patchEntity($taskManagement, $data);
            if ($this->TaskManagement->save($taskManagement)) {
                $this->Flash->success(__('The task management has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The task management could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('taskManagement'));
        $this->set('_serialize', ['taskManagement']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Task Management id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $taskManagement = $this->TaskManagement->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->data;
            $user = $this->Auth->user();
            $x = strtotime($data['start_date_time']);
            if ($x !== false) {
                $data['start_date_time'] = $x;
            } else {
                $data['start_date_time'] = '';
            }
            $x = strtotime($data['end_date_time']);
            if ($x !== false) {
                $data['end_date_time'] = $x;
            } else {
                $data['end_date_time'] = '';
            }
            $x = strtotime($data['reminder_date']);
            if ($x !== false) {
                $data['reminder_date'] = $x;
            } else {
                $data['reminder_date'] = '';
            }

            $data['updated_by'] = $user['id'];
            $data['updated_date'] = time();
            $data['reminder_by_sms'] = (isset($data['reminder_by_sms']) ? 1 : 0);

            $taskManagement = $this->TaskManagement->patchEntity($taskManagement, $data);
            if ($this->TaskManagement->save($taskManagement)) {
                $this->Flash->success(__('The task management has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The task management could not be saved. Please, try again.'));
            }
        }

        $this->set(compact('taskManagement'));
        $this->set('_serialize', ['taskManagement']);
    }

    public function complete($id = null)
    {
        $user = $this->Auth->user();
        //check the user have the task
        $task = $this->TaskManagement->find('all', [
            'contain' => [],
            'conditions' => ['user_id' => $user['id'], 'id' => $id]
        ])
            ->first();
        if ($task) {
            // do complete
            $data['updated_by'] = $user['id'];
            $data['updated_date'] = time();
            $data['status'] = 0;
            $taskManagement = $this->TaskManagement->patchEntity($task, $data);
            if ($this->TaskManagement->save($taskManagement)) {
                $this->Flash->success(__('The task management has been saved.'));
                return $this->redirect($this->referer());
            } else {
                $this->Flash->error(__('The task management could not be saved. Please, try again.'));
            }
        } else {
            // do waring
            $this->Flash->error(__('Wrong task complete request'));
            return $this->redirect($this->referer());
        }
        $this->autoRender=false;
    }

    public function ajax($action = null)
    {
        if ($action == 'get_grid_data') {
            $user_id = $this->Auth->user('id');
            $querys = $this->TaskManagement->find('all', [
                'conditions' => ['TaskManagement.user_id ' => $user_id, 'status' => 1],
                'order' => ['TaskManagement.id' => 'DESC']
            ]);


            $my_tasks = array();
            foreach ($querys as $query) {

                $arr['action'] = '<a href="' . $this->request->webroot . 'TaskManagement/complete/' . $query['id'] . '" ><i class="icon-checkmark3"></i></a>';
                $arr['id'] = $query['id'];
                $arr['title'] = $query['title'];
                $arr['media_type'] = $query['media_type'];
                if ($query['priority'] == 'High') {
                   $arr['priority']='<span class="label label-danger">'.__("High").'</span>';
                } elseif ($query['priority'] == 'Medium') {
                    $arr['priority']='<span class="label label-warning">'.__("Medium").'</span>';
                } else {
                    $arr['priority']='<span class="label label-info">'.__("Normal").'</span>';
                }

                    $time_now = time();
                    $start_time = $query['start_date_time'];
                    $diff = '';
                    if ($start_time > $time_now) {
                        $datetime1 = new \DateTime();
                        $datetime2 = new \DateTime(date('d-m-Y H:i:s', $start_time));
                        $interval = $datetime1->diff($datetime2);

                        if ($interval->m) {
                            $diff .= $interval->m . ' Months ';
                        }
                        if ($interval->d) {
                            $diff .= $interval->d . ' Days ';
                        }
                        if ($interval->h) {
                            $diff .= $interval->h . ' Hours ';
                        }
                        if ($interval->i) {
                            $diff .= $interval->i . ' Minutes';
                        }
                        $arr['diff'] = '<i class="icon-clock"></i><strong class="text-danger"> '.$diff.'</strong>';

                    } else {
                        $arr['diff'] = "<span class='label label-danger'>". __('Pending') ."</span>";
                    }
                    $arr['venue'] = $query['venue'];
                    $arr['created_date'] = date('d/m/Y',$query['created_date']);
                    $my_tasks[] = $arr;
                }


                $this->response->body(json_encode($my_tasks));
                return $this->response;
            }


        }

    }
