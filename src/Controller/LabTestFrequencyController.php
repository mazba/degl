<?php
namespace App\Controller;

/**
 * LabTestFrequency Controller
 *
 * @property \App\Model\Table\LabTestFrequencyTable $LabTestFrequency
 */
class LabTestFrequencyController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $user = $this->Auth->user();
        $labTestFrequency = $this->LabTestFrequency->find('all', [
            'conditions' => ['LabTestFrequency.status !=' => 99],
            'contain' => ['LabTestLists','LabTestGroup'],
            'order' => ['LabTestFrequency.id' => 'desc']
        ]);
        $this->set('labTestFrequency', $labTestFrequency);
        $this->set('_serialize', ['labTestFrequency']);
    }

    /**
     * View method
     *
     * @param string|null $id Lab Test Frequency id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Auth->user();
        $labTestFrequency = $this->LabTestFrequency->get($id, [
            'contain' => ['LabTestLists',]
        ]);
        $this->set('labTestFrequency', $labTestFrequency);
        $this->set('_serialize', ['labTestFrequency']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Auth->user();
        $labTestFrequency = $this->LabTestFrequency->newEntity();
        if ($this->request->is('post')) {

            $data = $this->request->data;
            $data['created_by'] = $user['id'];
            $data['created_date'] = time();
            $labTestFrequency = $this->LabTestFrequency->patchEntity($labTestFrequency, $data);
            if ($this->LabTestFrequency->save($labTestFrequency)) {
                $this->Flash->success('The lab test frequency has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The lab test frequency could not be saved. Please, try again.');
            }
        }
        $labTestGroups = $this->LabTestFrequency->LabTestGroup->find('list', ['limit' => 200]);
        $this->set(compact('labTestFrequency', 'labTestGroups'));
        $this->set('_serialize', ['labTestFrequency']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Lab Test Frequency id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Auth->user();
        $labTestFrequency = $this->LabTestFrequency->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->data;
            $data['updated_by'] = $user['id'];
            $data['updated_date'] = time();
            $labTestFrequency = $this->LabTestFrequency->patchEntity($labTestFrequency, $data);
            if ($this->LabTestFrequency->save($labTestFrequency)) {
                $this->Flash->success('The lab test frequency has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The lab test frequency could not be saved. Please, try again.');
            }
        }
        $labTestGroups = $this->LabTestFrequency->LabTestGroup->find('list', ['limit' => 200]);
        $labTestLists = $this->LabTestFrequency->LabTestLists->find('list', ['limit' => 200,'conditions'=>['id'=>$labTestFrequency->lab_test_list_id]]);
        $this->set(compact('labTestFrequency', 'labTestGroups', 'labTestLists'));
        $this->set('_serialize', ['labTestFrequency']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Lab Test Frequency id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $labTestFrequency = $this->LabTestFrequency->get($id);

        $user = $this->Auth->user();
        $data = $this->request->data;
        $data['updated_by'] = $user['id'];
        $data['updated_date'] = time();
        $data['status'] = 99;
        $labTestFrequency = $this->LabTestFrequency->patchEntity($labTestFrequency, $data);
        if ($this->LabTestFrequency->save($labTestFrequency)) {
            $this->Flash->success('The lab test frequency has been deleted.');
        } else {
            $this->Flash->error('The lab test frequency could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
