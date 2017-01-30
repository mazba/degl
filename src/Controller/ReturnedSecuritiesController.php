<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ReturnedSecurities Controller
 *
 * @property \App\Model\Table\ReturnedSecuritiesTable $ReturnedSecurities
 */
class ReturnedSecuritiesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $user = $this->Auth->user();
        $returnedSecurities = $this->ReturnedSecurities->find('all', [
         //   'conditions' => ['ReturnedSecurities.status !=' => 99],
            'contain' => ['Schemes']
        ]);
        $this->set('returnedSecurities', $returnedSecurities);
        $this->set('_serialize', ['returnedSecurities']);
    }

    /**
     * View method
     *
     * @param string|null $id Returned Security id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Auth->user();
        $returnedSecurity = $this->ReturnedSecurities->get($id, [
            'contain' => ['Schemes', 'CreatedUser', 'UpdatedUser']
        ]);
        $this->set('returnedSecurity', $returnedSecurity);
        $this->set('_serialize', ['returnedSecurity']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Auth->user();
        $returnedSecurity = $this->ReturnedSecurities->newEntity();
        if ($this->request->is('post')) {

            $data = $this->request->data;
            $data['created_by'] = $user['id'];
            $data['created_date'] = time();
            $returnedSecurity = $this->ReturnedSecurities->patchEntity($returnedSecurity, $data);
            if ($this->ReturnedSecurities->save($returnedSecurity)) {
                $this->Flash->success('The returned security has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The returned security could not be saved. Please, try again.');
            }
        }
        $schemes = $this->ReturnedSecurities->Schemes->find('list');

        $this->set(compact('returnedSecurity', 'schemes'));
        $this->set('_serialize', ['returnedSecurity']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Returned Security id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Auth->user();
        $returnedSecurity = $this->ReturnedSecurities->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->data;
            $data['updated_by'] = $user['id'];
            $data['updated_date'] = time();
            $returnedSecurity = $this->ReturnedSecurities->patchEntity($returnedSecurity, $data);
            if ($this->ReturnedSecurities->save($returnedSecurity)) {
                $this->Flash->success('The returned security has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The returned security could not be saved. Please, try again.');
            }
        }
        $schemes = $this->ReturnedSecurities->Schemes->find('list', ['limit' => 200]);
        $createdUser = $this->ReturnedSecurities->CreatedUser->find('list', ['limit' => 200]);
        $updatedUser = $this->ReturnedSecurities->UpdatedUser->find('list', ['limit' => 200]);
        $this->set(compact('returnedSecurity', 'schemes', 'createdUser', 'updatedUser'));
        $this->set('_serialize', ['returnedSecurity']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Returned Security id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $returnedSecurity = $this->ReturnedSecurities->get($id);

        $user = $this->Auth->user();
        $data = $this->request->data;
        $data['updated_by'] = $user['id'];
        $data['updated_date'] = time();
        $data['status'] = 99;
        $returnedSecurity = $this->ReturnedSecurities->patchEntity($returnedSecurity, $data);
        if ($this->ReturnedSecurities->save($returnedSecurity)) {
            $this->Flash->success('The returned security has been deleted.');
        } else {
            $this->Flash->error('The returned security could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }

    public function getList()
    {
        $this->layout = 'ajax';

        $this->loadModel('processed_ra_bills');
        $this->loadModel('fine_adjustments');

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->data;
            //  echo "<pre>";print_r($data);die();


            $securities = $this->processed_ra_bills->find('all', [
                'conditions' => ['processed_ra_bills.scheme_id =' => $data['id']]
            ]);
            $securities->select(['security_total' => $securities->func()->sum('processed_ra_bills.security')]);
            $securities = $securities->toArray();

//            echo "<pre>";
//            print_r($returnedSecurities[0]['security_total']);
//            die();

            $returnedSecurities = $this->ReturnedSecurities->find('all', [
                'conditions' => ['ReturnedSecurities.scheme_id =' => $data['id']]
            ]);
            $returnedSecurities->select(['returned_total' => $returnedSecurities->func()->sum('ReturnedSecurities.returned_amount')]);
            $returnedSecurities = $returnedSecurities->toArray();


            $fine_adjustments = $this->fine_adjustments->find('all', [
                'conditions' => ['fine_adjustments.scheme_id =' => $data['id']]
            ]);
            $fine_adjustments->select(['fine_adjustments' => $fine_adjustments->func()->sum('fine_adjustments.adjusted_amount')]);
            $fine_adjustments = $fine_adjustments->toArray();

            //echo "<pre>";print_r($fine_adjustments);die();

            $this->set(compact('returnedSecurities','securities','fine_adjustments'));
        }
    }
}
