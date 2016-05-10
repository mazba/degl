<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * DefaultRecipients Controller
 *
 * @property \App\Model\Table\DefaultRecipientsTable $DefaultRecipients
 */
class DefaultRecipientsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users']
        ];
        $this->set('defaultRecipients', $this->paginate($this->DefaultRecipients));
        $this->set('_serialize', ['defaultRecipients']);
    }

    /**
     * View method
     *
     * @param string|null $id Default Recipient id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $defaultRecipient = $this->DefaultRecipients->get($id, [
            'contain' => ['Users']
        ]);
        $this->set('defaultRecipients', $defaultRecipient);
        $this->set('_serialize', ['defaultRecipient']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $users = $this->DefaultRecipients->Users->find('all',['contain'=>['Designations'],'conditions'=>['Users.office_id'=>$this->Auth->user('office_id')]]);
        $defaultRecipient = $this->DefaultRecipients->newEntity();
        if ($this->request->is('post')) {
            $this->DefaultRecipients->updateAll(['status'=>0],['id !='=>0]);
            $user_id=$this->request->data['user_id'];
            $data=array();
            foreach($users as $user)
            {
                if($user->id==$user_id)
                {
                    $data['user_id']=$user->id;
                    $data['name_en']=$user->name_en;
                    $data['office_id']=$user->office_id;
                    $data['designation']=$user->designation->name_en;
                    $data['created_by']=$this->Auth->user('id');
                    $data['created_date']=time();
                    $data['status']=1;
                }
            }
            $defaultRecipient = $this->DefaultRecipients->patchEntity($defaultRecipient, $data);
            if ($this->DefaultRecipients->save($defaultRecipient)) {
                $this->Flash->success(__('The default recipient has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The default recipient could not be saved. Please, try again.'));
            }
        }


        $this->set(compact('defaultRecipient', 'users'));
        $this->set('_serialize', ['defaultRecipient']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Default Recipient id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $defaultRecipient = $this->DefaultRecipients->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $defaultRecipient = $this->DefaultRecipients->patchEntity($defaultRecipient, $this->request->data);
            if ($this->DefaultRecipients->save($defaultRecipient)) {
                $this->Flash->success(__('The default recipient has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The default recipient could not be saved. Please, try again.'));
            }
        }
        $users = $this->DefaultRecipients->Users->find('list', ['limit' => 200]);
        $this->set(compact('defaultRecipient', 'users'));
        $this->set('_serialize', ['defaultRecipient']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Default Recipient id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $defaultRecipient = $this->DefaultRecipients->get($id);
        if ($this->DefaultRecipients->delete($defaultRecipient)) {
            $this->Flash->success(__('The default recipient has been deleted.'));
        } else {
            $this->Flash->error(__('The default recipient could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
