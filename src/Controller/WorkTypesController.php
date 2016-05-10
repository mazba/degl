<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * WorkTypes Controller
 *
 * @property \App\Model\Table\WorkTypesTable $WorkTypes
 */
class WorkTypesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $workTypes = $this->WorkTypes->find('all', [
            'conditions' =>['WorkTypes.status !=' => 99],
            'contain' => ['CreatedUser', 'UpdatedUser']
        ]);
        $this->set('workTypes', $workTypes);
        $this->set('_serialize', ['workTypes']);
    }

    /**
     * View method
     *
     * @param string|null $id Work Type id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $workType = $this->WorkTypes->get($id, [
            'contain' => ['CreatedUser', 'UpdatedUser', 'WorkSubTypes']
        ]);
        $this->set('workType', $workType);
        $this->set('_serialize', ['workType']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $workType = $this->WorkTypes->newEntity();
        if ($this->request->is('post'))
        {
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            $workType = $this->WorkTypes->patchEntity($workType, $data);
            if ($this->WorkTypes->save($workType))
            {
                $this->Flash->success(__('The work type has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The work type could not be saved. Please, try again.'));
            }
        }

        $this->set(compact('workType'));
        $this->set('_serialize', ['workType']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Work Type id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $workType = $this->WorkTypes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $data=$this->request->data;
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['updated_by']=$user['id'];
            $data['updated_date']=time();
            $workType = $this->WorkTypes->patchEntity($workType, $data);
            if ($this->WorkTypes->save($workType))
            {
                $this->Flash->success(__('The work type has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The work type could not be saved. Please, try again.'));
            }
        }

        $this->set(compact('workType'));
        $this->set('_serialize', ['workType']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Work Type id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $workType = $this->WorkTypes->get($id);

        $user=$this->Auth->user();
        $data=$this->request->data;
        $data['updated_by']=$user['id'];
        $data['updated_date']=time();
        $data['status']=99;
        $workType = $this->WorkTypes->patchEntity($workType, $data);
        if ($this->WorkTypes->save($workType))
        {
            $this->Flash->success(__('The work type has been deleted.'));
        }
        else
        {
            $this->Flash->error(__('The work type could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
