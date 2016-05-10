<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * MyProfiles Controller
 *
 */
class MyProfilesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $user=$this->Auth->user();
        $user = $this->MyProfiles->find('all', [
            'conditions' =>['MyProfiles.id' => $user['id']],
            'contain' => ['Offices', 'Designations']
        ])
        ->first();
        $this->set('user', $user);
    }
    /**
     * Edit method
     *
     * @param string|null $id Task Management id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit()
    {
        $user_data = $this->Auth->user();
        $user = $this->MyProfiles->get($user_data['id'], [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $input = $this->request->data;
            $input['updated_by']=$user_data['id'];
            $input['updated_date']=time();
            $x=strtotime($input['birth_date']);
            if($x!==false)
            {
                $input['birth_date']=$x;
            }
            else
            {
                $input['birth_date']=0;
            }
            $user = $this->MyProfiles->patchEntity($user, $input);
            if ($this->MyProfiles->save($user))
            {
                $this->Flash->success(__('The Profile Have been Updated'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The Profile could not be Updated. Please, try again.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }
}
