<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * GuardDutyShifts Controller
 *
 * @property \App\Model\Table\GuardDutyShiftsTable $GuardDutyShifts
 */
class GuardDutyShiftsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $user=$this->Auth->user();
        $guardDutyShifts = $this->GuardDutyShifts->find('all', [
            'conditions' =>['GuardDutyShifts.status !=' => 99],
            'contain' => ['CreatedUser', 'UpdatedUser']
        ]);
        $this->set('guardDutyShifts', $guardDutyShifts);
        $this->set('_serialize', ['guardDutyShifts']);
    }

    /**
     * View method
     *
     * @param string|null $id Guard Duty Shift id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user=$this->Auth->user();
        $guardDutyShift = $this->GuardDutyShifts->get($id, [
            'contain' => ['CreatedUser', 'UpdatedUser']
        ]);
        $this->set('guardDutyShift', $guardDutyShift);
        $this->set('_serialize', ['guardDutyShift']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user=$this->Auth->user();
        $guardDutyShift = $this->GuardDutyShifts->newEntity();
        if ($this->request->is('post'))
        {

            $data=$this->request->data;
            $data['office_id']=$user['office_id'];
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            $guardDutyShift = $this->GuardDutyShifts->patchEntity($guardDutyShift, $data);
            if ($this->GuardDutyShifts->save($guardDutyShift))
            {
                $this->Flash->success(__('The guard duty shift has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The guard duty shift could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('guardDutyShift'));
        $this->set('_serialize', ['guardDutyShift']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Guard Duty Shift id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user=$this->Auth->user();
        $guardDutyShift = $this->GuardDutyShifts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $data=$this->request->data;
            $data['updated_by']=$user['id'];
            $data['updated_date']=time();
            $guardDutyShift = $this->GuardDutyShifts->patchEntity($guardDutyShift, $data);
            if ($this->GuardDutyShifts->save($guardDutyShift))
            {
                $this->Flash->success(__('The guard duty shift has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The guard duty shift could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('guardDutyShift'));
        $this->set('_serialize', ['guardDutyShift']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Guard Duty Shift id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $guardDutyShift = $this->GuardDutyShifts->get($id);

        $user=$this->Auth->user();
        $data=$this->request->data;
        $data['updated_by']=$user['id'];
        $data['updated_date']=time();
        $data['status']=99;
        $guardDutyShift = $this->GuardDutyShifts->patchEntity($guardDutyShift, $data);
        if ($this->GuardDutyShifts->save($guardDutyShift))
        {
            $this->Flash->success(__('The guard duty shift has been deleted.'));
        }
        else
        {
            $this->Flash->error(__('The guard duty shift could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
