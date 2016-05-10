<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Core\Configure;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * @return void
     */
    public $helpers = ['System'];
    public $user_roles = array();

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'username',
                        'password' => 'password'
                    ],
                    'passwordHasher' => [
                        'className' => 'Md5',
                    ]
                ]
            ],
            'loginAction' => [
                'controller' => 'Dashboard',
                'action' => 'login'
            ]
        ]);

        // Allow the display action so our pages controller
        // continues to work.
        //$this->Auth->allow(['display']);
        $user = $this->Auth->user();
        if ($user) {
            $this->loadModel('UserGroupRoles');
            $tasks = $this->UserGroupRoles->find('all', [
                'conditions' => [
                    'UserGroupRoles.status' => 1,
                    'UserGroupRoles.task_index' => 1,
                    'UserGroupRoles.user_group_id' => $user['user_group_id'],
                    'Tasks.position_left' => 1,
                    'Tasks.status' => 1
                ],
                'contain' => ['Modules', 'Tasks']
            ])->toArray();
            $menus = array();
            foreach ($tasks as $task) {
                if ($task->task['controller'] == $this->request->params['controller']) {
                    $this->set('active_module', $task->task['module_id']);
                    $this->set('active_task', $task->task['id']);
                }
                $menus[$task['module']['id']][] = $task;
            }
            $user_roles = $this->get_user_roles($user, $this->request->params['controller']);
            $this->user_roles = $user_roles;
            if (!($this->get_access($user_roles, $this->request->params['action']))) {
                $this->Flash->error('You dont have access to the task');
                return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
            }
            $this->loadModel('Offices');
            $user_office = $this->Offices->find()->select(['name_en','name_bn'])->where(['id'=>$user['office_id']])->first();
            $this->loadModel('UserGroups');
            $role=$this->UserGroups->find()
                ->select(['UserGroups.name_en','UserGroups.name_bn'])
                ->where(['UserGroups.id'=>$user['user_group_id']])
                ->first()
                ->toArray();

            $user_roles['role_name']=$role['name_en'];

            $this->set('user_office', $user_office);
            $this->set('user_roles', $user_roles);
            $this->set('user_info', $user);

            $this->set('menus', $menus);
            $this->set('message', $this->get_message());
        }

    }

    public function get_user_roles($user, $controller)
    {
        $roles = array();
        $roles['index'] = 0;
        $roles['view'] = 0;
        $roles['add'] = 0;
        $roles['edit'] = 0;
        $roles['delete'] = 0;
        $roles['report'] = 0;
        $roles['print_it'] = 0;//TODO:: ask to Shaiful vai, and user group role assign report=print ###
        if ($controller == 'Dashboard') {
            $roles['index'] = 1;
            $roles['view'] = 1;
            $roles['add'] = 1;
            $roles['edit'] = 1;
            $roles['delete'] = 1;
            $roles['report'] = 1;
            $roles['print_it'] = 1;//TODO:: ask to Shaiful vai, and user group role assign report=print ###
        } elseif ($user['user_group_id'] == 1) {
            $roles['index'] = 1;
            $roles['view'] = 1;
            $roles['add'] = 1;
            $roles['edit'] = 1;
            $roles['delete'] = 1;
            $roles['report'] = 1;
            $roles['print_it'] = 1;//TODO:: ask to Shaiful vai, and user group role assign report=print ###
        } else {
            $this->loadModel('UserGroupRoles');
            $access = $this->UserGroupRoles->find()
                ->where([

                    'UserGroupRoles.status' => 1,
                    'UserGroupRoles.user_group_id' => $user['user_group_id'],
                    'Tasks.controller' => $controller
                ])
                ->contain(['Tasks'])
                ->first();
            if ($access) {
                $roles['index'] = $access->task_index;
                $roles['view'] = $access->task_view;
                $roles['add'] = $access->task_add;
                $roles['edit'] = $access->task_edit;
                $roles['delete'] = $access->task_delete;
                $roles['report'] = $access->task_report;
                $roles['print_it'] = $access->task_print;//TODO:: ask to Shaiful vai, and user group role assign report=print ###
            }
        }
        return $roles;
    }

    public function get_access($roles, $action)
    {
        if (isset($roles[$action]) && ($roles[$action] == 0)) {
            return false;
        } else {
            return true;
        }

    }

    public function get_message()
    {
        $user = $this->Auth->user();

        $this->loadModel('MessageRegisters');
        $messages = $this->MessageRegisters->find();
        $result = $messages->select(['total' => $messages->func()->count(['MessageRegisters.id'])])
            ->where(['MessageRegisters.attachment_type' => Configure::read('attachment_type.0'), 'MessageRegisters.msg_type' => 'forward'])
            ->orWhere(['MessageRegisters.attachment_type' => Configure::read('attachment_type.0'), 'MessageRegisters.msg_type' => 'reply'])
            ->orWhere(['MessageRegisters.attachment_type' => Configure::read('attachment_type.0'), 'MessageRegisters.msg_type' => 'original'])
            ->orWhere(['MessageRegisters.msg_type' => 'individual'])
            ->orWhere(['MessageRegisters.msg_type' => 'labBill'])
            ->orWhere(['MessageRegisters.msg_type' => 'hireCharges'])
            ->where(['MessageRegisters.is_read' => 0])
            ->leftJoin('recipients', 'recipients.message_register_id=MessageRegisters.id')
            ->where(['recipients.user_id' => $user['id']])
            ->toArray();

        return $result[0];

    }

}
