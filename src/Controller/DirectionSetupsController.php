<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * DirectionSetups Controller
 *
 * @property \App\Model\Table\DirectionSetupsTable $DirectionSetups
 */
class DirectionSetupsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $user=$this->Auth->user();
        $directionSetups = $this->DirectionSetups->find('all', [
            'conditions' =>['DirectionSetups.status !=' => 99],
            'contain' => ['CreatedUser']
        ]);
        $this->set('directionSetups', $directionSetups);
        $this->set('_serialize', ['directionSetups']);
    }

    /**
     * View method
     *
     * @param string|null $id Direction Setup id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user=$this->Auth->user();
        $directionSetup = $this->DirectionSetups->get($id, [
            'contain' => ['CreatedUser', 'UpdatedUser']
        ]);
        $this->set('directionSetup', $directionSetup);
        $this->set('_serialize', ['directionSetup']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user=$this->Auth->user();
        $directionSetup = $this->DirectionSetups->newEntity();
        if ($this->request->is('post'))
        {

            $data=$this->request->data;
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            $directionSetup = $this->DirectionSetups->patchEntity($directionSetup, $data);
            if ($this->DirectionSetups->save($directionSetup))
            {
                $this->Flash->success(__('The direction setup has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The direction setup could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('directionSetup', 'createdUser'));
        $this->set('_serialize', ['directionSetup']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Direction Setup id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user=$this->Auth->user();
        $directionSetup = $this->DirectionSetups->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $data=$this->request->data;
            $data['updated_by']=$user['id'];
            $data['updated_date']=time();
            $directionSetup = $this->DirectionSetups->patchEntity($directionSetup, $data);
            if ($this->DirectionSetups->save($directionSetup))
            {
                $this->Flash->success(__('The direction setup has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The direction setup could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('directionSetup', 'createdUser'));
        $this->set('_serialize', ['directionSetup']);
    }
}
