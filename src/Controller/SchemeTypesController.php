<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * SchemeTypes Controller
 *
 * @property \App\Model\Table\SchemeTypesTable $SchemeTypes
 */
class SchemeTypesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $user=$this->Auth->user();
        $schemeTypes = $this->SchemeTypes->find('all', [
            'conditions' =>['SchemeTypes.status !=' => 99],
            'contain' => ['CreatedUser', 'UpdatedUser']
        ]);
        $this->set('schemeTypes', $schemeTypes);
        $this->set('_serialize', ['schemeTypes']);
    }

    /**
     * View method
     *
     * @param string|null $id Scheme Type id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user=$this->Auth->user();
        $schemeType = $this->SchemeTypes->get($id, [
            'contain' => ['CreatedUser', 'UpdatedUser']
        ]);
        $this->set('schemeType', $schemeType);
        $this->set('_serialize', ['schemeType']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user=$this->Auth->user();
        $schemeType = $this->SchemeTypes->newEntity();
        if ($this->request->is('post'))
        {

            $data=$this->request->data;
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            $schemeType = $this->SchemeTypes->patchEntity($schemeType, $data);
            if ($this->SchemeTypes->save($schemeType))
            {
                $this->Flash->success('The scheme type has been saved.');
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error('The scheme type could not be saved. Please, try again.');
            }
        }
        $createdUser = $this->SchemeTypes->CreatedUser->find('list', ['limit' => 200]);
        $updatedUser = $this->SchemeTypes->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('schemeType', 'createdUser', 'updatedUser'));
        $this->set('_serialize', ['schemeType']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Scheme Type id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user=$this->Auth->user();
        $schemeType = $this->SchemeTypes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $data=$this->request->data;
            $data['updated_by']=$user['id'];
            $data['updated_date']=time();
            $schemeType = $this->SchemeTypes->patchEntity($schemeType, $data);
            if ($this->SchemeTypes->save($schemeType))
            {
                $this->Flash->success('The scheme type has been saved.');
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error('The scheme type could not be saved. Please, try again.');
            }
        }
        $createdUser = $this->SchemeTypes->CreatedUser->find('list', ['limit' => 200]);
        $updatedUser = $this->SchemeTypes->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('schemeType', 'createdUser', 'updatedUser'));
        $this->set('_serialize', ['schemeType']);
    }
}
