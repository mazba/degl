<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * UserGroupRoles Controller
 *
 * @property \App\Model\Table\UserGroupRolesTable $UserGroupRoles
 */
class UserGroupRolesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {


        $user_group_roles = TableRegistry::get('user_group_roles');
        $user_groups = TableRegistry::get('user_groups');

        $sub_query = $user_group_roles->find();

        $sub_query->select(['user_group_id'=>'user_group_id','total_task'=>$sub_query->func()->count('DISTINCT task_id'),'total_component'=>$sub_query->func()->count('DISTINCT component_id'),'total_module'=>$sub_query->func()->count('DISTINCT module_id')])
            ->select(['last_created_date'=>$sub_query->func()->max('created_date')])
            ->select(['last_updated_date'=>$sub_query->func()->max('updated_date')])
            ->where(['task_index'=>1])
            ->where(['task_index'=>1])
            ->group(['user_group_id']);



        $query = $user_groups->find();
        $query->select(['ugr.total_component','ugr.total_module','ugr.total_task','ugr.last_created_date','ugr.last_updated_date','id','name_bn']);
        $query->join([
            'table' => $sub_query,
            'alias' => 'ugr',
            'type' => 'LEFT',
            'conditions' => 'ugr.user_group_id = user_groups.id',
        ]);
        $this->set('userGroupRoles', $query);
        $this->set('_serialize', ['userGroupRoles']);
    }

    /**
     * View method
     *
     * @param string|null $id User Group Role id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */

    public function edit($id = null)
    {
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $user=$this->Auth->user();
            $tasks=$this->request->data['tasks'];
            $time=time();
            $user_group_roles = TableRegistry::get('user_group_roles');
            foreach($tasks as $task)
            {

                $data=array();

                if(isset($task['index'])&& ($task['index']==1))
                {
                    $data['task_index']=1;
                }
                else
                {
                    $data['task_index']=0;
                }
                if(isset($task['view'])&& ($task['view']==1))
                {
                    $data['task_view']=1;
                }
                else
                {
                    $data['task_view']=0;
                }
                if(isset($task['add'])&& ($task['add']==1))
                {
                    $data['task_add']=1;
                }
                else
                {
                    $data['task_add']=0;
                }
                if(isset($task['edit'])&& ($task['edit']==1))
                {
                    $data['task_edit']=1;
                }
                else
                {
                    $data['task_edit']=0;
                }
                if(isset($task['delete'])&& ($task['delete']==1))
                {
                    $data['task_delete']=1;
                }
                else
                {
                    $data['task_delete']=0;
                }
                if(isset($task['report'])&& ($task['report']==1))
                {
                    $data['task_report']=1;
                }
                else
                {
                    $data['task_report']=0;
                }
                if(isset($task['print'])&& ($task['print']==1))
                {
                    $data['task_print']=1;
                }
                else
                {
                    $data['task_print']=0;
                }
                if(($data['task_view'])||($data['task_add'])||($data['task_edit'])||($data['task_delete'])||($data['task_report'])||($data['task_print']))
                {
                    $data['task_index']=1;
                }
                if($task['ugr_id']>0)
                {
                    $data['updated_by']=$user['id'];
                    $data['updated_date']=$time;
                    $query = $user_group_roles->query();
                    $query->update()
                        ->set($data)
                        ->where(['id' => $task['ugr_id']])
                        ->execute();
                }
                else
                {
                    $data['user_group_id']=$id;
                    $data['component_id']=$task['component_id'];
                    $data['module_id']=$task['module_id'];
                    $data['task_id']=$task['task_id'];
                    $data['created_by']=$user['id'];
                    $data['created_date']=$time;
                    $query = $user_group_roles->query();
                    $query->insert(array_keys($data))
                        ->values($data)
                        ->execute();
                }


            }
            $this->Flash->success(__('User Roles Saved Successfully.'));
            return $this->redirect(['action' => 'index']);

        }
        $this->set('id', $id);
        $this->set('role_status', $this->get_role_status($id));
        $this->set('access_tasks', $this->get_my_tasks($id));
        $this->set('_serialize', ['userGroupRole']);
    }
    private function get_role_status($user_group_id)
    {
        $user_group_roles = TableRegistry::get('user_group_roles');
        $query = $user_group_roles->find();
        $query->where(['user_group_id'=>$user_group_id]);

        $roles=array();
        $roles['index']=array();
        $roles['view']=array();
        $roles['add']=array();
        $roles['edit']=array();
        $roles['delete']=array();
        $roles['report']=array();
        $roles['print']=array();
        $roles['ugr_id']=array();
        foreach($query as $result)
        {
            $roles['ugr_id'][$result['task_id']]=$result['id'];
            if($result['task_index'])
            {
                $roles['index'][]=$result['task_id'];
            }
            if($result['task_view'])
            {
                $roles['view'][]=$result['task_id'];
            }
            if($result['task_add'])
            {
                $roles['add'][]=$result['task_id'];
            }
            if($result['task_edit'])
            {
                $roles['edit'][]=$result['task_id'];
            }
            if($result['task_delete'])
            {
                $roles['delete'][]=$result['task_id'];
            }
            if($result['task_report'])
            {
                $roles['report'][]=$result['task_id'];
            }
            if($result['task_print'])
            {
                $roles['print'][]=$result['task_id'];
            }

        }
        return $roles;
    }
    private function get_my_tasks($user_group_id)
    {
        $user=$this->Auth->user();
        if($user['user_group_id']==1)
        {
            $this->loadModel('Tasks');
            $tasks = $this->Tasks->find('all', [
                'conditions' =>['Tasks.status !=' => 99],
                'contain' => ['Components', 'Modules']
            ]);

            if($user_group_id==1)
            {
                $tasks = $this->Tasks->find('all', [
                    'conditions' =>['Tasks.status !=' => 99,'Tasks.controller !='=>'UserGroupRoles'],
                    'contain' => ['Components', 'Modules']
                ]);
            }
            else
            {
                $tasks = $this->Tasks->find('all', [
                    'conditions' =>['Tasks.status !=' => 99],
                    'contain' => ['Components', 'Modules']
                ]);
            }

            $results=array();
            foreach($tasks as $task)
            {

                $result=array();
                $result['component_id']=$task->component_id;
                $result['module_id']=$task->module_id;
                $result['task_id']=$task->id;
                $result['task_name']=$task->name_en;
                $result['component_name']=$task->component->name_en;
                $result['module_name']=$task->module->name_en;
                $result['index']=1;
                $result['view']=1;
                $result['add']=1;
                $result['edit']=1;
                $result['delete']=1;
                $result['report']=1;
                $result['print']=1;
                $results[]=$result;
            }
            return $results;
        }
        else
        {
            $user_group_roles = TableRegistry::get('user_group_roles');


            $query = $user_group_roles->find();

            $query->select(['component_id'=>'user_group_roles.component_id','module_id'=>'user_group_roles.module_id','task_id'=>'user_group_roles.task_id']);
            $query->select(['task_index'=>'task_index','task_view'=>'task_view','task_add'=>'task_add','task_edit'=>'task_edit']);
            $query->select(['task_delete'=>'task_delete','task_report'=>'task_report','task_print'=>'task_print']);
            $query->select(['component_name'=>'c.name_en']);
            $query->select(['module_name'=>'m.name_en']);
            $query->select(['task_name'=>'task.name_en']);
            $query->join([
                'c' => [
                    'table' => 'components',
                    'type' => 'INNER',
                    'conditions' => 'c.id = user_group_roles.component_id',
                ],
                'm' => [
                    'table' => 'modules',
                    'type' => 'INNER',
                    'conditions' => 'm.id = user_group_roles.module_id',
                ],
                'task' => [
                    'table' => 'tasks',
                    'type' => 'INNER',
                    'conditions' => 'task.id = user_group_roles.task_id',
                ]
            ]);
            $query->where(['user_group_roles.user_group_id'=>$user['user_group_id']]);
            $query->where(['task_index'=>1]);
            if(($user['user_group_id']==$user_group_id)||($user_group_id==1))
            {
                $query->where(['task.controller !='=>'UserGroupRoles']);
            }
            $results=array();
            foreach($query as $q)
            {
                $result=array();
                $result['component_id']=$q['component_id'];
                $result['module_id']=$q['module_id'];
                $result['task_id']=$q['task_id'];
                $result['component_name']=$q['component_name'];
                $result['module_name']=$q['module_name'];
                $result['task_name']=$q['task_name'];
                $result['index']=$q['task_index'];
                $result['view']=$q['task_view'];
                $result['add']=$q['task_add'];
                $result['edit']=$q['task_edit'];
                $result['delete']=$q['task_delete'];
                $result['report']=$q['task_report'];
                $result['print']=$q['task_print'];
                $results[]=$result;
            }

            return $results;
        }
    }


}
