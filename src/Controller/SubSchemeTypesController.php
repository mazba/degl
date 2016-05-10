<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * SubSchemeTypes Controller
 *
 * @property \App\Model\Table\SubSchemeTypesTable $SubSchemeTypes
 */
class SubSchemeTypesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $user=$this->Auth->user();
        $subSchemeTypes = $this->SubSchemeTypes->find('all', [
            'conditions' =>['SubSchemeTypes.status !=' => 99],
            'contain' => ['SchemeTypes', 'CreatedUser', 'UpdatedUser']
        ]);
        $this->set('subSchemeTypes', $subSchemeTypes);
        $this->set('_serialize', ['subSchemeTypes']);
    }

    /**
     * View method
     *
     * @param string|null $id Sub Scheme Type id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user=$this->Auth->user();
        $subSchemeType = $this->SubSchemeTypes->get($id, [
            'contain' => ['SchemeTypes', 'CreatedUser', 'UpdatedUser']
        ]);
        $this->set('subSchemeType', $subSchemeType);
        $this->set('_serialize', ['subSchemeType']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user=$this->Auth->user();
        $subSchemeType = $this->SubSchemeTypes->newEntity();
        if ($this->request->is('post'))
        {

            $data=$this->request->data;
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            $subSchemeType = $this->SubSchemeTypes->patchEntity($subSchemeType, $data);
            if ($this->SubSchemeTypes->save($subSchemeType))
            {
                $this->Flash->success('The sub scheme type has been saved.');
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error('The sub scheme type could not be saved. Please, try again.');
            }
        }
        $schemeTypes = $this->SubSchemeTypes->SchemeTypes->find('list', ['limit' => 200]);
        $createdUser = $this->SubSchemeTypes->CreatedUser->find('list', ['limit' => 200]);
        $updatedUser = $this->SubSchemeTypes->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('subSchemeType', 'schemeTypes', 'createdUser', 'updatedUser'));
        $this->set('_serialize', ['subSchemeType']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Sub Scheme Type id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user=$this->Auth->user();
        $subSchemeType = $this->SubSchemeTypes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $data=$this->request->data;
            $data['updated_by']=$user['id'];
            $data['updated_date']=time();
            $subSchemeType = $this->SubSchemeTypes->patchEntity($subSchemeType, $data);
            if ($this->SubSchemeTypes->save($subSchemeType))
            {
                $this->Flash->success('The sub scheme type has been saved.');
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error('The sub scheme type could not be saved. Please, try again.');
            }
        }
        $schemeTypes = $this->SubSchemeTypes->SchemeTypes->find('list', ['limit' => 200]);
        $createdUser = $this->SubSchemeTypes->CreatedUser->find('list', ['limit' => 200]);
        $updatedUser = $this->SubSchemeTypes->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('subSchemeType', 'schemeTypes', 'createdUser', 'updatedUser'));
        $this->set('_serialize', ['subSchemeType']);
    }
}
