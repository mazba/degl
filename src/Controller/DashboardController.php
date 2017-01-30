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

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class DashboardController extends AppController
{

    /**
     * Displays a view
     *
     * @return void|\Cake\Network\Response
     * @throws \Cake\Network\Exception\NotFoundException When the view file could not
     *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
     */
    private $my_task_controllers = array();
    private $my_tasks = array();

    public function index()
    {
        $user = $this->Auth->user();
        if ($user) {
            $this->get_tasks();
            /*$this->loadModel('TaskManagement');
            $taskManagements = $this->TaskManagement->find('all', [
                'conditions' =>[
                    'TaskManagement.user_id ' => $user['id'],
                    'TaskManagement.status' => '1'
                ],
                'order'=>[
                    'TaskManagement.id'=>'DESC'
                ]
            ])
            ->toArray();
            $this->set('taskManagements', $taskManagements);
            $this->set('my_files', $this->get_my_files());*/
            if ($user['user_group_id'] == Configure::read('user_groups')['superadmin']) {
                $this->view = 'supper_dashboard';
                $this->set('recieve_file_info', $this->get_recieve_file_info());
                $this->set('issue_file_info', $this->get_issue_file_info());
                $this->set('vehicle_info', $this->get_vehicle_info());
                // $this->set('lab_test_info', $this->get_lab_test_info());
                $this->set('contractors_info', $this->get_contractor_info());
                $this->set('all_users_info', $this->get_all_users_info());
                $this->set('nothi_info', $this->get_nothi_info());
                $this->set('count_scheme_info', $this->count_scheme_info());
                $this->set('scheme_info_progress', $this->get_scheme_progress_info());
//                $this->set('scheme_progress_info', $this->scheme_progress_info());

            } elseif ($user['user_group_id'] == Configure::read('user_groups')['admin']) {

             //   echo "<pre>";print_r($this->get_my_task_info());die();
                $this->view = 'supper_dashboard';
                $this->set('details_file_info', $this->get_recieve_file_info());
                $this->set('details_task_info', $this->get_my_task_info());
              //  $this->set('issue_file_info', $this->get_issue_file_info());
                $this->set('vehicle_info', $this->get_vehicle_info());
                //$this->set('lab_test_info', $this->get_lab_test_info());
                $this->set('contractors_info', $this->get_contractor_info());
                $this->set('all_users_info', $this->get_all_users_info());
                $this->set('nothi_info', $this->get_nothi_info());
                $this->set('count_scheme_info', $this->count_scheme_info());
                $this->set('scheme_info_progress', $this->get_scheme_progress_info());
//                $this->set('scheme_progress_info', $this->scheme_progress_info());
            } elseif ($user['user_group_id'] == Configure::read('user_groups')['staff']) {
                $this->view = 'staff_dashboard';
            } elseif ($user['user_group_id'] == Configure::read('user_groups')['lab']) {
                $this->view = 'lab_dashboard';
            } elseif ($user['user_group_id'] == Configure::read('user_groups')['vehicles']) {
                $this->view = 'vehicles_dashboard';
            } elseif ($user['user_group_id'] == Configure::read('user_groups')['counter']) {
                $this->view = 'counter_dashboard';
            } elseif ($user['user_group_id'] == Configure::read('user_groups')['accounts']) {
                $this->view = 'account_dashboard';
                $this->set('allotment_receive_info', $this->get_allotment_receive_info());
                $this->set('bill_paid_info', $this->get_bill_paid_info());
                $this->set('bill_approve_info', $this->get_bill_approve_info());
            } else {
                $this->view = "general_dashboard";
            }
        }
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                $this->Flash->success(__('Your Have succesfully loged in'));
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Your username or password is incorrect.'));
        }
        $this->layout = 'login';
    }

    public function logout()
    {
        $this->Flash->success(__('You are now logged out'));
        return $this->redirect($this->Auth->logout());
    }

    public function ajax($task)
    {
        $this->layout = 'ajax';
        if ($task == 'get_zone_by_division_id') {
            $this->loadModel('Zones');
            $this->view = 'get_zone_by_division_id';
            $zones = $this->Zones->find('list',
                [
                    'conditions' => [
                        'status !=' => 99,
                        'division_id' => $this->request->data['division_id']
                    ]
                ]
            );
            $this->set(compact('zones'));
        } elseif ($task == 'get_district_by_division_zone_id') {
            $this->loadModel('Districts');
            $this->view = 'get_district_by_division_zone_id';
            $districts = $this->Districts->find('list',
                [
                    'conditions' => [
                        'status !=' => 99,
                        'division_id' => $this->request->data['division_id'],
                        'zone_id' => $this->request->data['zone_id']
                    ]
                ]
            );
            $this->set(compact('districts'));
        } elseif ($task == 'get_upazila_by_division_district_id') {
            $this->loadModel('Upazilas');
            $this->view = 'get_upazila_by_division_district_id';
            $upazilas = $this->Upazilas->find('list',
                [
                    'conditions' => [
                        'status !=' => 99,
                        'division_id' => $this->request->data['division_id'],
                        'district_id' => $this->request->data['district_id']
                    ]
                ]
            );
            $this->set(compact('upazilas'));
        } elseif ($task == 'get_designation_by_office_id') {
            //office_id
            $this->loadModel('Designations');
            $this->view = 'get_designation_by_office_id';
            $designations = $this->Designations->find('list',
                [
                    'conditions' => [
                        'status !=' => 99,
                        'office_id' => $this->request->data['office_id']

                    ]
                ]
            );
            $this->set(compact('designations'));
        }


    }

    private function get_tasks()
    {
        $user = $this->Auth->user();
        if ($user) {
            $this->loadModel('UserGroupRoles');
            $tasks = $this->UserGroupRoles->find('all', [
                'conditions' => [
                    'UserGroupRoles.status' => 1,
                    'UserGroupRoles.task_index' => 1,
                    'UserGroupRoles.user_group_id' => $user['user_group_id']
                ],
                'contain' => ['Tasks']
            ])->toArray();
            $this->my_tasks = $tasks;
            foreach ($tasks as $task) {
                $this->my_task_controllers[] = $task['task']['controller'];
            }
        }
    }

    private function get_recieve_file_info()
    {
//        if (in_array('ReceiveFileRegisters', $this->my_task_controllers)||1) {
//            $user = $this->Auth->user();
//            $info['total_today'] = 0;
//
//            $receive_file_table = TableRegistry::get('receive_file_registers');
//            $query = $receive_file_table->find();
//            $query->select(['count' => $query->func()->count('*')]);
//            if ($user['user_group_id'] != 1) {
//                $query->where(['receive_office' => $user['office_id']]);
//            }
//            $info['total'] = $query->first()->toArray()['count'];
//
//
//
//            $time_from = strtotime(date('d-M-Y', time()));
//            $query = $receive_file_table->find();
//            $query->select(['count' => $query->func()->count('*')]);
//            if ($user['user_group_id'] != 1) {
//                $query->where(['receive_office' => $user['office_id']]);
//            }
//
//            $query->where(['created_date >=' => $time_from]);
//            $info['total_today'] = $query->first()->toArray()['count'];
//
//            return $info;
//        } else {
//            return null;
//        }

        $time_from = strtotime(date('d-M-Y', time()));
        $user = $this->Auth->user();
        $user_id = $this->Auth->user('id');
        $this->loadModel('MessageRegisters');

//        $querys = $this->MessageRegisters->find();
//        $querys->autoFields(true);
//        $querys->select(['count' => $querys->func()->count('*')]);
//        $querys->where(['MessageRegisters.attachment_type' => Configure::read('attachment_type.4')]);
//        $querys->leftJoin('recipients', 'recipients.message_register_id=MessageRegisters.id');
//
//        if ($user['user_group_id'] != 1) {
//            $querys->where(['recipients.user_id' => $user_id]);
//        }
//        $info['total'] = $querys->first()->toArray()['count'];


        $querys = $this->MessageRegisters->find();
        $querys->autoFields(true);
        $querys->select(['count' => $querys->func()->count('*')]);
        $querys->where(['MessageRegisters.attachment_type' => Configure::read('attachment_type.4')]);
        $querys->leftJoin('recipients', 'recipients.message_register_id=MessageRegisters.id');
        $querys->where(['recipients.created_date >=' => $time_from]);
        if ($user['user_group_id'] != 1) {
            $querys->where(['recipients.user_id' => $user_id]);
        }
        $info['todays_total'] = $querys->first()->toArray()['count'];


        $querys = $this->MessageRegisters->find();
        $querys->autoFields(true);
        $querys->select(['count' => $querys->func()->count('*')]);
        $querys->where(['MessageRegisters.attachment_type' => Configure::read('attachment_type.4')]);
        $querys->where(['MessageRegisters.is_read' =>0]);
        $querys->leftJoin('recipients', 'recipients.message_register_id=MessageRegisters.id');
        $querys->where(['recipients.created_date >=' => $time_from]);
        if ($user['user_group_id'] != 1) {
            $querys->where(['recipients.user_id' => $user_id]);
        }
        $info['todays_unread'] = $querys->first()->toArray()['count'];

        $querys = $this->MessageRegisters->find();
        $querys->autoFields(true);
        $querys->select(['count' => $querys->func()->count('*')]);
        $querys->where(['MessageRegisters.attachment_type' => Configure::read('attachment_type.4')]);
        $querys->where(['MessageRegisters.is_forward' =>1]);
        $querys->leftJoin('recipients', 'recipients.message_register_id=MessageRegisters.id');
        $querys->where(['recipients.created_date >=' => $time_from]);
        if ($user['user_group_id'] != 1) {
            $querys->where(['recipients.user_id' => $user_id]);
        }
        $info['todays_forward'] = $querys->first()->toArray()['count'];


        return $info;

    }

    private function get_my_task_info()
    {
        $time_from = strtotime(date('d-M-Y', time()));
        $user = $this->Auth->user();
        $user_id = $this->Auth->user('id');
        $this->loadModel('TaskManagement');

        $querys = $this->TaskManagement->find();
        $querys->autoFields(true);
        $querys->select(['count' => $querys->func()->count('*')]);
     //   $querys->where(['TaskManagement.status' => 1]);
     //   $querys->where(['TaskManagement.created_date >=' => $time_from]);
        if ($user['user_group_id'] != 1) {
            $querys->where(['TaskManagement.user_id' => $user_id]);
        }
        $info['total'] = $querys->first()->toArray()['count'];


        $querys = $this->TaskManagement->find();
        $querys->autoFields(true);
        $querys->select(['count' => $querys->func()->count('*')]);
        $querys->where(['TaskManagement.status' =>1]);
      //  $querys->where(['TaskManagement.updated_date >=' => $time_from]);
        if ($user['user_group_id'] != 1) {
            $querys->where(['TaskManagement.user_id' => $user_id]);
        }
        $info['total_active'] = $querys->first()->toArray()['count'];

        return $info;

    }

    private function get_issue_file_info()
    {
        if (in_array('LetterIssueRegisters', $this->my_task_controllers)) {
            $user = $this->Auth->user();
            $info['total_today'] = 0;
            $receive_file_table = TableRegistry::get('letter_issue_registers');
            /*$query = $receive_file_table->find();
            $query->select(['count' => $query->func()->count('*')]);
            $query->where(['sender_office'=>$user['office_id']]);
            $info['total']=$query->first()->toArray()['count'];*/
            $time_from = strtotime(date('d-M-Y', time()));
            $query = $receive_file_table->find();
            $query->select(['count' => $query->func()->count('*')]);
            if ($user['user_group_id'] != 1) {
                $query->where(['sender_office' => $user['office_id']]);
            }

            $query->where(['created_date >=' => $time_from]);

            $info['total_today'] = $query->first()->toArray()['count'];

            return $info;
        } else {
            return null;
        }
    }

    private function get_vehicle_info()
    {
        if (in_array('Vehicles', $this->my_task_controllers)) {
            $user = $this->Auth->user();
            $vehicles_table = TableRegistry::get('vehicles');
            $query = $vehicles_table->find();
            $query->select(['count' => $query->func()->count('*')]);
            if ($user['user_group_id'] != 1) {
                $query->where(['office_id' => $user['office_id']]);
            }

            $info['total'] = $query->first()->toArray()['count'];
            return $info;
        } else {
            return null;
        }
    }

    /*private function get_lab_test_info()
    {
        if (in_array('AddLabTestRegisters', $this->my_task_controllers)) {
            $user = $this->Auth->user();
            $info['total_today'] = 0;
            $lab_test_table = TableRegistry::get('lab_test');
            $time_from = strtotime(date('d-M-Y', time()));
            $query = $lab_test_table->find();
            $query->select(['count' => $query->func()->count('*')]);
            /*if($user['user_group_id']!=1)
            {
                $query->where(['receive_office'=>$user['office_id']]);
            }*/
    //To-Do join office_id

    /*$query->where(['created_date >=' => $time_from]);
    $info['total_today'] = $query->first()->toArray()['count'];

    return $info;
} else {
    return null;
}
}*/

    private function get_contractor_info()
    {
        if (in_array('Contractors', $this->my_task_controllers)) {
            $user = $this->Auth->user();
            $contractors_table = TableRegistry::get('contractors');
            $query = $contractors_table->find();
            $query->select(['count' => $query->func()->count('*')]);
            $info['total'] = $query->first()->toArray()['count'];
            return $info;
        } else {
            return null;
        }
    }

    private function get_all_users_info()
    {
        if (in_array('Users', $this->my_task_controllers)) {
            $user = $this->Auth->user();
            $users_table = TableRegistry::get('users');
            $query = $users_table->find();
            $query->select(['count' => $query->func()->count('*')]);
            if ($user['user_group_id'] != 1) {
                $query->where(['office_id' => $user['office_id']]);
            }
            $info['total'] = $query->first()->toArray()['count'];
            return $info;
        } else {
            return null;
        }
    }

    private function get_nothi_info()
    {
        if (in_array('NothiRegisters', $this->my_task_controllers)) {
            $user = $this->Auth->user();
            $nothi_table = TableRegistry::get('nothi_registers');
            $query = $nothi_table->find();
            $query->select(['count' => $query->func()->count('*')]);
            if ($user['user_group_id'] != 1) {
                $query->where(['office_id' => $user['office_id']]);
            }
            $info['total'] = $query->first()->toArray()['count'];
            return $info;
        } else {
            return null;
        }
    }

    private function count_scheme_info()
    {
        if (in_array('Schemes', $this->my_task_controllers)) {
            $user = $this->Auth->user();
            $schemes_table = TableRegistry::get('schemes');
            $query = $schemes_table->find();
            $query->select(['count' => $query->func()->count('*')]);
            if ($user['user_group_id'] != 1) {
                //$query->where(['office_id'=>$user['office_id']]);
                //To-Do join office_id

            }
            $query->where(['status !=' => Configure::read('scheme_complete_status')]);
            $info['total'] = $query->first()->toArray()['count'];
            return $info;
        } else {
            return null;
        }
    }

    /*private function get_my_files()
    {
        $user_id=$this->Auth->user('id');
        $this->loadModel('Recipients');
        $querys = $this->Recipients->find('all')
            ->select(['designations.name_en','users.name_en','message_registers.sender_name','message_registers.sender_designation','message_registers.subject','message_registers.id','message_registers.is_out_side','Recipients.created_date'])
            ->leftJoin('message_registers','message_registers.id = Recipients.message_register_id')
            ->leftJoin('users','users.id = message_registers.sender_id')
            ->leftJoin('designations','designations.id = users.designation_id')
            ->where([
                'Recipients.user_id'=>$user_id,
                'message_registers.is_read !='=>1
            ]);
        return $querys;
    }*/
    private function get_scheme_progress_info()
    {
        $user = $this->Auth->user();
        $this->loadModel('SchemeProgresses');
        $schemeProgresses = $this->SchemeProgresses->find('all')
            ->where(['SchemeProgresses.office_id' => $user['office_id']])
            ->where(['SchemeProgresses.status' => 1, 'SchemeProgresses.progress_value >=' => 50]);
        return $schemeProgresses->count();
    }

//    public function scheme_progress_info()
//    {
//        $user = $this->Auth->user();
//        $this->loadModel('SchemeProgresses');
//        $query = $this->SchemeProgresses->find('all');
//        $sub_query = $query->select(['id' => $query->func()->max('id')])
//            ->where(['SchemeProgresses.office_id' => $user['office_id']])
//            ->group(['SchemeProgresses.scheme_id']);
//        $schemeProgresses = $this->SchemeProgresses->find('all')
//            ->autoFields(true)
//            ->select(['schemes.name_en'])
//            ->where(['SchemeProgresses.id IN' => $sub_query])
//            ->order(['SchemeProgresses.id'=>'DESC'])
//            ->leftJoin('schemes', 'schemes.id = SchemeProgresses.scheme_id');
//        $scheme = array();
//        foreach ($schemeProgresses as $schemeProgress) {
//            $arr['title'] = $schemeProgress['schemes']['name_en'];
//
//            $string = strip_tags($schemeProgress['schemes']['name_en']);
//
//            if (strlen($string) > 60) {
//                // truncate string
//                $stringCut = substr($string, 0, 60);
//                $string = substr($stringCut, 0, strrpos($stringCut, ' ')) . '...';
//                $arr['title'] .= $string;
//            }
//
//            if ($schemeProgress["progress_value"] > 50) {
//                $progress = " progress-bar-success";
//            } else {
//                $progress = " progress-bar-danger";
//            }
//            $arr['progress'] = "<div class='progress block-inner' style='margin: 0 10px;'><div class='progress-bar" . $progress . "' role='progressbar' aria-valuenow='" . $schemeProgress['progress_value'] . "' aria-valuemin='0' aria-valuemax='100' style='width:" . $schemeProgress['progress_value'] . "%'>" . $schemeProgress['progress_value'] . "</div></div>";
//            $arr['action'] = "<a href='" . $this->request->webroot . 'scheme_progresses/view/' . $schemeProgress['id'] . "'><i class='icon-newspaper'></i></a>";
//            $scheme[] = $arr;
//        }
//
//        $this->response->body(json_encode($scheme));
//        return $this->response;
//    }
    public function get_scheme_info()
    {
        $user = $this->Auth->user();
        $this->loadModel('Schemes');
        $scheme_tbl = $this->Schemes->find('all')
            ->select(['schemes.id', 'schemes.name_en', 'schemes.name_bn', 'schemes.scheme_code'])
            ->select(['scheme_progresses.progress_value'])
            ->group('Schemes.id')
            ->where([
                'project_offices.office_id' => $user['office_id'],
                'Schemes.status !=' => Configure::read('scheme_complete_status')])
            ->innerJoin('project_offices', 'project_offices.project_id = Schemes.project_id')
            ->leftJoin('scheme_progresses', 'scheme_progresses.scheme_id = Schemes.id AND scheme_progresses.status = 1');
        $schemes = [];
        foreach ($scheme_tbl as $scheme) {
            if ($scheme['scheme_progresses']["progress_value"] > 50) {
                $progress = " progress-bar-success";
            } else {
                $progress = " progress-bar-danger";
            }
            $arr['title'] = $scheme['schemes']['name_bn'];
            $arr['scheme_code'] = $scheme['schemes']['scheme_code'];
            $arr['progress'] = "<div class='progress block-inner' style='margin: 0 10px;'><div class='progress-bar" . $progress . "' role='progressbar' aria-valuenow='" . $scheme['progress_value']["progress_value"] . "' aria-valuemin='0' aria-valuemax='100' style='width:" . $scheme['scheme_progresses']["progress_value"] . "%'>" . $scheme['scheme_progresses']["progress_value"] . "</div></div>";
            $arr['letter'] = "<a href='" . $this->request->webroot . 'my_files/letters_by_scheme/' . $scheme['schemes']['id'] . "'><i class='icon-list2'></i></a>";
            $arr['lab'] = "<a href='" . $this->request->webroot . 'lab_bills/lab_bill_by_scheme/' . $scheme['schemes']['id'] . "'><i class='icon-lab'></i></a>";
            $arr['vehicle'] = "<a href='" . $this->request->webroot . 'hire_charges/hire_charge_by_scheme/' . $scheme['schemes']['id'] . "'><i class='icon-car'></i></a>";
            $arr['accounts'] = "<a href='" . $this->request->webroot . 'purto_bills/purto_bills_by_scheme/' . $scheme['schemes']['id'] . "'><i class='icon-lastfm2'></i></a>";
            $arr['multimedia'] = "<a href='" . $this->request->webroot . 'schemes/view/' . $scheme['schemes']['id'] . "'><i class='icon-instagram'></i></a>";
            $schemes[] = $arr;
        }

        $this->response->body(json_encode($schemes));
        return $this->response;
    }

    public function get_allotment_receive_info()
    {
        $user = $this->Auth->user();
        $this->loadModel('AllotmentRegisters');
        $allotment_receives = $this->AllotmentRegisters->find();
        $result = $allotment_receives->select(['total_allotment_received' => $allotment_receives->func()->count('AllotmentRegisters.id'), 'total_received' => $allotment_receives->func()->sum('AllotmentRegisters.allotment_amount')])
            ->where(['AllotmentRegisters.dr_cr' => 'Credit'])
            ->toArray();

        return $result;
    }

    public function get_bill_paid_info()
    {
        $user = $this->Auth->user();
        $this->loadModel('AllotmentRegisters');
        $allotment_receives = $this->AllotmentRegisters->find();
        $result = $allotment_receives->select(['total_bill_count' => $allotment_receives->func()->count('AllotmentRegisters.id'), 'total_bill_paid' => $allotment_receives->func()->sum('AllotmentRegisters.allotment_amount')])
            ->where(['AllotmentRegisters.dr_cr' => 'Debit'])
            ->toArray();

        return $result;
    }

    public function get_bill_approve_info()
    {
        $user = $this->Auth->user();
        $this->loadModel('PurtoBills');
        $purtoBills = $this->PurtoBills->find();
        $result = $purtoBills->select(['total_bill_approve' => $purtoBills->func()->count('PurtoBills.id')])
            ->where(['PurtoBills.created_date >' => mktime(0, 0, 0), 'PurtoBills.created_date <' => mktime(24, 0, 0)])
            ->toArray();
        return $result;
    }
}
