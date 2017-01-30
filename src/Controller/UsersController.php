<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Security;
use Cake\Utility\Text;
use Cake\Routing\Router;
use Cake\Network\Email\Email;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow('forgot_password');
        $this->Auth->allow('reset');
    }
    public function index()
    {
        $user=$this->Auth->user();
        if($user['user_group_id']==1)
        {
            $users = $this->Users->find('all', [
                'conditions' =>['Users.status !=' => 99],
                'contain' => ['Offices', 'Designations', 'UserGroups', 'CreatedUser', 'UpdatedUser']
            ]);
        }
        else
        {
            $users = $this->Users->find('all', [
                'conditions' =>['Users.status !=' => 99,'Users.user_group_id !=' => 1],
                'contain' => ['Offices', 'Designations', 'UserGroups', 'CreatedUser', 'UpdatedUser']
            ]);
        }
        $this->set('users', $users);
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Offices', 'Designations', 'UserGroups', 'CreatedUser', 'UpdatedUser','Departments']
        ]);
        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $created_user=$this->Auth->user();
        $user = $this->Users->newEntity();
        if ($this->request->is('post'))
        {

            $data=$this->request->data;
            $data['created_by']=$created_user['id'];
            $data['created_date']=time();
            $x=strtotime($data['birth_date']);
            if($x!==false)
            {
                $data['birth_date']=$x;
            }
            else
            {
                $data['birth_date']=0;
            }

            $files = array();
            $file_upload_complete = true;
            $has_file = false;


            if ($_FILES['signature']) {

//echo "<pre>";print_r($_FILES['signature']);die();
                $base_upload_path = WWW_ROOT . 'img/signature';

                    $tmp_name = $_FILES['signature']['tmp_name'];
                    //Get the temp file path
                    if ($tmp_name) {

                        $name = time() . '_' . str_replace(' ', '_', $_FILES['signature']['name']);
                        if (move_uploaded_file($tmp_name, $base_upload_path . '/' . $name)) {
                            $data['signature'] = $name;
                            $has_file = true;

                        } else {
                            $file_upload_complete = false;
                           // break;
                        }
                    }

            }
            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user))
            {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        if($created_user['user_group_id']==1)
        {
            $offices = $this->Users->Offices->find('list');
            $userGroups = $this->Users->UserGroups->find('list');
            //$designations = $this->Users->Designations->find('list');
            $departments=$this->Users->Departments->find('list');
            $designations=[];
        }
        else
        {
         //   $offices = $this->Users->Offices->find('list', ['conditions' => ['id ='=>$created_user['office_id']]]);
            $offices = $this->Users->Offices->find('list');
            $userGroups = $this->Users->UserGroups->find('list', ['conditions' => ['id !='=>1]]);
            $designations = $this->Users->Designations->find('list', ['conditions' => ['office_id ='=>$created_user['office_id']]]);
            $departments=$this->Users->Departments->find('list', ['conditions' => ['Departments.office_id ='=>$created_user['office_id']]]);
        }
        $this->set(compact('user', 'offices', 'designations', 'userGroups','departments'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        $created_user=$this->Auth->user();
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $data=$this->request->data;
            $data=$this->request->data;
            $data['updated_by']=$created_user['id'];
            $data['updated_date']=time();
            $x=strtotime($data['birth_date']);
            if($x!==false)
            {
                $data['birth_date']=$x;
            }
            else
            {
                $data['birth_date']=0;
            }

            $files = array();
            $file_upload_complete = true;
            $has_file = false;


            if ($_FILES['signature']) {

                $base_upload_path = WWW_ROOT . 'img/signature';

                $tmp_name = $_FILES['signature']['tmp_name'];
                //Get the temp file path
                if ($tmp_name) {

                    $name = time() . '_' . str_replace(' ', '_', $_FILES['signature']['name']);
                    if (move_uploaded_file($tmp_name, $base_upload_path . '/' . $name)) {
                        $data['signature'] = $name;
                        $has_file = true;

                    } else {
                        $file_upload_complete = false;
                        // break;
                    }
                }

            }else{
                $data['signature']=$user['signature'];
            }
            $user = $this->Users->patchEntity($user, $data);
			
            if ($this->Users->save($user))
            {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        if($created_user['user_group_id']==1)
        {
            $offices = $this->Users->Offices->find('list');
            $userGroups = $this->Users->UserGroups->find('list');
            $departments=$this->Users->Departments->find('list');
            $designations = $this->Users->Designations->find('list', ['conditions' => ['office_id ='=>$user['office_id']]]);
        }
        else
        {
          //  $offices = $this->Users->Offices->find('list', ['conditions' => ['id ='=>$created_user['office_id']]]);
            $offices = $this->Users->Offices->find('list');

            $userGroups = $this->Users->UserGroups->find('list', ['conditions' => ['id !='=>1]]);
            $designations = $this->Users->Designations->find('list', ['conditions' => ['office_id ='=>$created_user['office_id']]]);
            $departments=$this->Users->Departments->find('list', ['conditions' => ['Departments.office_id ='=>$created_user['office_id']]]);

        }
        $this->set(compact('user', 'offices', 'designations', 'userGroups','departments'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $user = $this->Users->get($id);

        $created_user=$this->Auth->user();
        $data=$this->request->data;
        $data['updated_by']=$created_user['id'];
        $data['updated_date']=time();
        $data['status']=99;
        $user = $this->Users->patchEntity($user, $data);
        if ($this->Users->save($user))
        {
            $this->Flash->success(__('The user has been deleted.'));
        }
        else
        {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    /*
     * Forgot password by Mazba
     *
     */
    public function forgot_password()
    {
        $this->layout = 'login';
        if($this->request->is(['patch', 'post', 'put']))
        {
            //$this->User->recursive=-1;
            $input = $this->request->data;
            if(!empty($input))
            {
                if(empty($input['email']))
                {
                    $this->Flash->error(__('Email is Required'));
                }
                else
                {
                    $email = $input['email'];
                    $mobile = $input['mobile'];
                    $user = $this->Users->find('all',['conditions'=>['Users.email'=>$email,'Users.mobile'=>$mobile]])->first();
                    // check the mobile no also!
                    if($user)
                    {
                        //debug($fu);
                        if($user['status'] == 1)
                        {
                            $key = Security::hash(Text::uuid(),'sha512',true);
                            $hash=sha1($user['username'].rand(0,100));
                            $url = Router::url( ['controller'=>'forgotpwd','action'=>'rst'], true ).'/'.$key.'#'.$hash;
                            $ms=$url;
                            $ms=wordwrap($ms,1000);
                            $data['tokenhash']=$key;
//                            $user = $this->Users->get($user['id']);
                            $user = $this->Users->patchEntity($user, $data);
                            if($this->Users->save($user)){
                                //============Email================//
                                $subject = 'www.lgedgazipur.gov.bd | Password Reset';
                                $msg = 'Someone requested that the password be reset for the following account: www.lgedgazipur.gov.bd.
If this was a mistake, just ignore this email and nothing will happen.
To reset your password, visit the following address: '.$ms;
                                /* SMTP Options */
                                $email = new Email('default');
                                $email->from(['info@lgedgazipur.gov.bd' => 'www.lgedgazipur.gov.bd'])
                                    ->to('mazba.cse@gmail.com')
                                    ->subject($subject)
                                    ->send(wordwrap($msg));
                                $this->Flash->success(__('Check Your Email To Reset your password'));
                                return $this->redirect('/');

                                //============EndEmail=============//
                            }
                            else
                            {
                                $this->Flash->error(__('Error Generating Reset link'));
                            }
                        }
                        else
                        {
                            $this->Flash->error(__('This Account is not Active yet.Check Your mail to activate it'));
                        }
                    }
                    else
                    {
                        $this->Flash->error(__('Email or Mobile no. does Not Exist'));
                    }
                }
            }

        }

    }
    public function reset($token=null)
    {
    $this->layout="login";
    //$this->User->recursive=-1;
    if(!empty($token))
    {
        $user = $this->Users->find('all',['conditions'=>['Users.tokenhash'=>$token]])->first();
        if($user)
        {
            if($this->request->is(['patch', 'post', 'put']))
            {
                $new_hash = sha1($user['username'].rand(0,100));//created token
                $data['tokenhash'] = $new_hash;
                $data['password'] = $this->request->data('pass');
                $error_validation = $this->validation($this->request->data);
                if(!$error_validation)
                {
//                    $user = $this->Users->get($u['id']);
                    $user = $this->Users->patchEntity($user,$data);
                    if($this->Users->save($user))
                    {
                        $this->Flash->success(__('Password Has been Updated. Please enter new password and login.'));
                        $this->redirect('/');
                    }
                    else
                    {
                        $this->Flash->error(__('Please Retry'));
                    }
                }
                else
                {
                    $this->set('errors',$error_validation);
                }
            }
        }
        else
        {
            $this->Flash->error(__('Token Corrupted,,Please Retry.the reset link work only for once.'));
            $this->redirect('/');
        }
    }
    else{
        $this->redirect('/');
    }
}
    private  function validation($input)
    {
        $errors = [];
        if($input['pass'] != $input['c_pass'])
        {
            $errors[] = __('Password And Confirm Password are not same.');
        }
        if(strlen($input['pass'])<5 || strlen($input['c_pass'])<5)
        {
            $errors[] = __('Short passwords are easy to guess. Try one with at least 5 characters.');
        }
        return $errors ? $errors : false;
    }
}
