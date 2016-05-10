<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * WorkSubTypes Controller
 *
 * @property \App\Model\Table\WorkSubTypesTable $WorkSubTypes
 */
class WorkSubTypesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $workSubTypes = $this->WorkSubTypes->find('all', [
            'conditions' =>['WorkSubTypes.status !=' => 99],
            'contain' => ['WorkTypes', 'CreatedUser', 'UpdatedUser']
        ]);
        $this->set('workSubTypes', $workSubTypes);
        $this->set('_serialize', ['workSubTypes']);
    }

    /**
     * View method
     *
     * @param string|null $id Work Sub Type id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $workSubType = $this->WorkSubTypes->get($id, [
            'contain' => ['WorkTypes', 'CreatedUser', 'UpdatedUser']
        ]);
        $this->set('workSubType', $workSubType);
        $this->set('_serialize', ['workSubType']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $workSubType = $this->WorkSubTypes->newEntity();
        if ($this->request->is('post'))
        {
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            $workSubType = $this->WorkSubTypes->patchEntity($workSubType, $data);
            if ($this->WorkSubTypes->save($workSubType))
            {
                $this->Flash->success(__('The work sub type has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The work sub type could not be saved. Please, try again.'));
            }
        }
        $workTypes = $this->WorkSubTypes->WorkTypes->find('list', ['conditions' => ['status !=' =>99]]);
        $this->set(compact('workSubType', 'workTypes'));
        $this->set('_serialize', ['workSubType']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Work Sub Type id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $workSubType = $this->WorkSubTypes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $data=$this->request->data;
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['updated_by']=$user['id'];
            $data['updated_date']=time();
            $workSubType = $this->WorkSubTypes->patchEntity($workSubType, $data);
            if ($this->WorkSubTypes->save($workSubType))
            {
                $this->Flash->success(__('The work sub type has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The work sub type could not be saved. Please, try again.'));
            }
        }
        $workTypes = $this->WorkSubTypes->WorkTypes->find('list', ['conditions' => ['status !=' =>99]]);
        $this->set(compact('workSubType', 'workTypes'));
        $this->set('_serialize', ['workSubType']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Work Sub Type id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $workSubType = $this->WorkSubTypes->get($id);

        $user=$this->Auth->user();
        $data=$this->request->data;
        $data['updated_by']=$user['id'];
        $data['updated_date']=time();
        $data['status']=99;
        $workSubType = $this->WorkSubTypes->patchEntity($workSubType, $data);
        if ($this->WorkSubTypes->save($workSubType))
        {
            $this->Flash->success(__('The work sub type has been deleted.'));
        }
        else
        {
            $this->Flash->error(__('The work sub type could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
