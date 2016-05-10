<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * AdditionalItems Controller
 *
 * @property \App\Model\Table\AdditionalItemsTable $AdditionalItems
 */
class AdditionalItemsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $additionalItems = $this->AdditionalItems->find('all', [
            'conditions' =>['AdditionalItems.status !=' => 99],
            'contain' => ['CreatedUser', 'UpdatedUser']
        ]);
        $this->set('additionalItems', $additionalItems);
        $this->set('_serialize', ['additionalItems']);
    }

    /**
     * View method
     *
     * @param string|null $id Additional Item id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $additionalItem = $this->AdditionalItems->get($id, [
            'contain' => ['CreatedUser', 'UpdatedUser']
        ]);
        $this->set('additionalItem', $additionalItem);
        $this->set('_serialize', ['additionalItem']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $additionalItem = $this->AdditionalItems->newEntity();
        if ($this->request->is('post'))
        {
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            $additionalItem = $this->AdditionalItems->patchEntity($additionalItem, $data);
            if ($this->AdditionalItems->save($additionalItem))
            {
                $this->Flash->success(__('The additional item has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The additional item could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('additionalItem'));
        $this->set('_serialize', ['additionalItem']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Additional Item id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $additionalItem = $this->AdditionalItems->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $data=$this->request->data;
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['updated_by']=$user['id'];
            $data['updated_date']=time();
            $additionalItem = $this->AdditionalItems->patchEntity($additionalItem, $data);
            if ($this->AdditionalItems->save($additionalItem))
            {
                $this->Flash->success(__('The additional item has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The additional item could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('additionalItem'));
        $this->set('_serialize', ['additionalItem']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Additional Item id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $additionalItem = $this->AdditionalItems->get($id);

        $user=$this->Auth->user();
        $data=$this->request->data;
        $data['updated_by']=$user['id'];
        $data['updated_date']=time();
        $data['status']=99;
        $additionalItem = $this->AdditionalItems->patchEntity($additionalItem, $data);
        if ($this->AdditionalItems->save($additionalItem))
        {
            $this->Flash->success(__('The additional item has been deleted.'));
        }
        else
        {
            $this->Flash->error(__('The additional item could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
