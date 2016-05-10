<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * DevelopmentPartners Controller
 *
 * @property \App\Model\Table\DevelopmentPartnersTable $DevelopmentPartners
 */
class DevelopmentPartnersController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $developmentPartners = $this->DevelopmentPartners->find('all', [
            'conditions' =>['DevelopmentPartners.status !=' => 99],
            'contain' => ['CreatedUser', 'UpdatedUser']
        ]);
        $this->set('developmentPartners', $developmentPartners);
        $this->set('_serialize', ['developmentPartners']);
    }

    /**
     * View method
     *
     * @param string|null $id Development Partner id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $developmentPartner = $this->DevelopmentPartners->get($id, [
            'contain' => ['CreatedUser', 'UpdatedUser', 'Projects']
        ]);
        $this->set('developmentPartner', $developmentPartner);
        $this->set('_serialize', ['developmentPartner']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $developmentPartner = $this->DevelopmentPartners->newEntity();
        if ($this->request->is('post'))
        {
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            $developmentPartner = $this->DevelopmentPartners->patchEntity($developmentPartner, $data);
            if ($this->DevelopmentPartners->save($developmentPartner))
            {
                $this->Flash->success(__('The development partner has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The development partner could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('developmentPartner'));
        $this->set('_serialize', ['developmentPartner']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Development Partner id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $developmentPartner = $this->DevelopmentPartners->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $data=$this->request->data;
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['updated_by']=$user['id'];
            $data['updated_date']=time();
            $developmentPartner = $this->DevelopmentPartners->patchEntity($developmentPartner, $data);
            if ($this->DevelopmentPartners->save($developmentPartner))
            {
                $this->Flash->success(__('The development partner has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The development partner could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('developmentPartner'));
        $this->set('_serialize', ['developmentPartner']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Development Partner id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $developmentPartner = $this->DevelopmentPartners->get($id);

        $user=$this->Auth->user();
        $data=$this->request->data;
        $data['updated_by']=$user['id'];
        $data['updated_date']=time();
        $data['status']=99;
        $developmentPartner = $this->DevelopmentPartners->patchEntity($developmentPartner, $data);
        if ($this->DevelopmentPartners->save($developmentPartner))
        {
            $this->Flash->success(__('The development partner has been deleted.'));
        }
        else
        {
            $this->Flash->error(__('The development partner could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
