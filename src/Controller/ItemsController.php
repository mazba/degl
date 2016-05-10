<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Items Controller
 *
 * @property \App\Model\Table\ItemsTable $Items
 */
class ItemsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $items = $this->Items->find('all', [
            'conditions' =>['Items.status !=' => 99],
            'contain' => ['Chapters', 'CreatedUser', 'UpdatedUser']
        ]);
        $this->set('items', $items);
        $this->set('_serialize', ['items']);
    }

    /**
     * View method
     *
     * @param string|null $id Item id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $item = $this->Items->get($id, [
            'contain' => ['Chapters', 'CreatedUser', 'UpdatedUser']
        ]);
        $this->set('item', $item);
        $this->set('_serialize', ['item']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $item = $this->Items->newEntity();
        if ($this->request->is('post'))
        {
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            $item = $this->Items->patchEntity($item, $data);
            if ($this->Items->save($item))
            {
                $this->Flash->success(__('The item has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The item could not be saved. Please, try again.'));
            }
        }
        $chapters = $this->Items->Chapters->find('list', ['conditions' => ['status !=' =>99]]);
        $this->set(compact('item', 'chapters'));
        $this->set('_serialize', ['item']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Item id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $item = $this->Items->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $data=$this->request->data;
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['updated_by']=$user['id'];
            $data['updated_date']=time();
            $item = $this->Items->patchEntity($item, $data);
            if ($this->Items->save($item))
            {
                $this->Flash->success(__('The item has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The item could not be saved. Please, try again.'));
            }
        }
        $chapters = $this->Items->Chapters->find('list', ['conditions' => ['status !=' =>99]]);
        $this->set(compact('item', 'chapters'));
        $this->set('_serialize', ['item']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Item id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $item = $this->Items->get($id);

        $user=$this->Auth->user();
        $data=$this->request->data;
        $data['updated_by']=$user['id'];
        $data['updated_date']=time();
        $data['status']=99;
        $item = $this->Items->patchEntity($item, $data);
        if ($this->Items->save($item))
        {
            $this->Flash->success(__('The item has been deleted.'));
        }
        else
        {
            $this->Flash->error(__('The item could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
