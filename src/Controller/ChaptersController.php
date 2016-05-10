<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Chapters Controller
 *
 * @property \App\Model\Table\ChaptersTable $Chapters
 */
class ChaptersController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $chapters = $this->Chapters->find('all', [
            'conditions' =>['Chapters.status !=' => 99],
            'contain' => ['CreatedUser', 'UpdatedUser']
        ]);
        $this->set('chapters', $chapters);
        $this->set('_serialize', ['chapters']);
    }

    /**
     * View method
     *
     * @param string|null $id Chapter id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $chapter = $this->Chapters->get($id, [
            'contain' => ['CreatedUser', 'UpdatedUser']
        ]);
        $this->set('chapter', $chapter);
        $this->set('_serialize', ['chapter']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $chapter = $this->Chapters->newEntity();
        if ($this->request->is('post'))
        {
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            $chapter = $this->Chapters->patchEntity($chapter, $data);
            if ($this->Chapters->save($chapter))
            {
                $this->Flash->success('The chapter has been saved.');
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The chapter could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('chapter'));
        $this->set('_serialize', ['chapter']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Chapter id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $chapter = $this->Chapters->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $data=$this->request->data;
            $user=$this->Auth->user();
            $data=$this->request->data;
            $data['updated_by']=$user['id'];
            $data['updated_date']=time();
            $chapter = $this->Chapters->patchEntity($chapter, $data);
            if ($this->Chapters->save($chapter))
            {
                $this->Flash->success(__('The chapter has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The chapter could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('chapter'));
        $this->set('_serialize', ['chapter']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Chapter id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $chapter = $this->Chapters->get($id);

        $user=$this->Auth->user();
        $data=$this->request->data;
        $data['updated_by']=$user['id'];
        $data['updated_date']=time();
        $data['status']=99;
        $chapter = $this->Chapters->patchEntity($chapter, $data);
        if ($this->Chapters->save($chapter))
        {
            $this->Flash->success(__('The chapter has been deleted.'));
        }
        else
        {
            $this->Flash->error('The chapter could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
