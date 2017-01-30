<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;


/**
 * Assets Controller
 *
 * @property \App\Model\Table\AssetsTable $Assets
 */
class AssetsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $user=$this->Auth->user();
        $assets = $this->Assets->find('all', [
            'conditions' =>['Assets.status !=' => 99],
            'contain' => ['CreatedUser', 'UpdatedUser']
        ]);
        $this->set('assets', $assets);
        $this->set('_serialize', ['assets']);
    }

    /**
     * View method
     *
     * @param string|null $id Asset id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user=$this->Auth->user();
        $asset = $this->Assets->get($id, [
            'contain' => ['CreatedUser', 'UpdatedUser']
        ]);
        $this->set('asset', $asset);
        $this->set('_serialize', ['asset']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user=$this->Auth->user();
        $asset = $this->Assets->newEntity();
        if ($this->request->is('post'))
        {

            $data=$this->request->data;
        //    echo "<pre>";print_r($data);die();

            $nothi_assigndata['nothi_register_id']=$data['parent_id'];
            unset($data['parent_id']);
            $data['status']=1;
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            $asset = $this->Assets->patchEntity($asset, $data);


           // echo "<pre>";print_r($asset_id->id);die();
            if (  $asset_id=$this->Assets->save($asset))
            {

                $NothiAssignsTable = TableRegistry::get('NothiAssigns');
                $nothiassign = $NothiAssignsTable->newEntity();

                $nothiassign->nothi_register_id =  $nothi_assigndata['nothi_register_id'];
                $nothiassign->asset_id =$asset_id->id;

                if ($NothiAssignsTable->save($nothiassign)) {
                    $this->Flash->success(__('The asset has been saved.'));
                    return $this->redirect(['action' => 'index']);

                }else{
                    $this->Flash->error(__('The asset could not be saved. Please, try again.'));
                }

            }
            else
            {
                $this->Flash->error('The asset could not be saved. Please, try again.');
            }
        }

        $this->loadModel('NothiRegisters');
        $nothiRegisters = $this->NothiRegisters->find('list', [
            'conditions' => ['status' => 1, 'office_id' => $user['office_id'], 'parent_id' => 0],
        ])->toArray();
        //echo "<pre>";print_r($nothiRegisters);die();
        $createdUser = $this->Assets->CreatedUser->find('list', ['limit' => 200]);
        $updatedUser = $this->Assets->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('asset', 'createdUser', 'updatedUser','nothiRegisters'));
        $this->set('_serialize', ['asset']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Asset id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user=$this->Auth->user();
        $asset = $this->Assets->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $data=$this->request->data;
            $data['updated_by']=$user['id'];
            $data['updated_date']=time();
            $asset = $this->Assets->patchEntity($asset, $data);
            if ($this->Assets->save($asset))
            {
                $this->Flash->success('The asset has been saved.');
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error('The asset could not be saved. Please, try again.');
            }
        }
        $createdUser = $this->Assets->CreatedUser->find('list', ['limit' => 200]);
        $updatedUser = $this->Assets->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('asset', 'createdUser', 'updatedUser'));
        $this->set('_serialize', ['asset']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Asset id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $asset = $this->Assets->get($id);

        $user=$this->Auth->user();
        $data=$this->request->data;
        $data['updated_by']=$user['id'];
        $data['updated_date']=time();
        $data['status']=99;
        $asset = $this->Assets->patchEntity($asset, $data);
        if ($this->Assets->save($asset))
        {
            $this->Flash->success('The asset has been deleted.');
        }
        else
        {
            $this->Flash->error('The asset could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
