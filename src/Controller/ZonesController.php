<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Zones Controller
 *
 * @property \App\Model\Table\ZonesTable $Zones
 */
class ZonesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $zones = $this->Zones->find('all', [
            'conditions' =>['Zones.status !=' => 99],
            'contain' => ['Divisions', 'CreatedUser', 'UpdatedUser']
        ]);
        $this->set('zones', $zones);
        $this->set('_serialize', ['zones']);
    }

    /**
     * View method
     *
     * @param string|null $id Zone id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $zone = $this->Zones->get($id, [
            'contain' => ['Divisions', 'CreatedUser', 'UpdatedUser', 'Districts', 'ItemRates', 'Offices']
        ]);
        $this->set('zone', $zone);
        $this->set('_serialize', ['zone']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $zone = $this->Zones->newEntity();
        if ($this->request->is('post'))
        {
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            $zone = $this->Zones->patchEntity($zone, $data);
            if ($this->Zones->save($zone))
            {
                $this->Flash->success(__('The zone has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The zone could not be saved. Please, try again.'));
            }
        }
        $divisions = $this->Zones->Divisions->find('list', ['limit' => 200]);
        $createdUser = $this->Zones->CreatedUser->find('list', ['limit' => 200]);
        $updatedUser = $this->Zones->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('zone', 'divisions', 'createdUser', 'updatedUser'));
        $this->set('_serialize', ['zone']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Zone id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $zone = $this->Zones->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $data=$this->request->data;
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['updated_by']=$user['id'];
            $data['updated_date']=time();
            $zone = $this->Zones->patchEntity($zone, $data);
            if ($this->Zones->save($zone))
            {
                $this->Flash->success(__('The zone has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The zone could not be saved. Please, try again.'));
            }
        }
        $divisions = $this->Zones->Divisions->find('list', ['limit' => 200]);
        $createdUser = $this->Zones->CreatedUser->find('list', ['limit' => 200]);
        $updatedUser = $this->Zones->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('zone', 'divisions', 'createdUser', 'updatedUser'));
        $this->set('_serialize', ['zone']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Zone id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $zone = $this->Zones->get($id);

        $user=$this->Auth->user();
        $data=$this->request->data;
        $data['updated_by']=$user['id'];
        $data['updated_date']=time();
        $data['status']=99;
        $zone = $this->Zones->patchEntity($zone, $data);
        if ($this->Zones->save($zone))
        {
            $this->Flash->success(__('The zone has been deleted.'));
        }
        else
        {
            $this->Flash->error(__('The zone could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
