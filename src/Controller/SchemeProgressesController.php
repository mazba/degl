<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * SchemeProgresses Controller
 *
 * @property \App\Model\Table\SchemeProgressesTable $SchemeProgresses
 */
class SchemeProgressesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $user = $this->Auth->user();
        $query = $this->SchemeProgresses->find('all');
        $sub_query = $query->select(['id'=>$query->func()->max('id')])
                ->where(['SchemeProgresses.office_id'=>$user['office_id']])
                ->group(['SchemeProgresses.scheme_id']);
        $schemeProgresses = $this->SchemeProgresses->find('all')
                ->autoFields(true)
                ->select(['schemes.name_en'])
                ->where(['SchemeProgresses.id IN'=>$sub_query])
                ->leftJoin('schemes','schemes.id = SchemeProgresses.scheme_id');

        $this->set('schemeProgresses', $schemeProgresses);
        $this->set('_serialize', ['schemeProgresses']);
    }

    /**
     * View method
     *
     * @param string|null $id Scheme Progress id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user=$this->Auth->user();
        $schemeProgress = $this->SchemeProgresses->find('all', [
            'conditions'=>['SchemeProgresses.scheme_id'=>$id],
            'contain' => ['Schemes','CreatedUser']
        ])
        ->toArray();
//echo '<pre>';
//print_r($schemeProgress);
//echo '</pre>';
//die;
        $this->set('schemeProgresses', $schemeProgress);
        $this->set('_serialize', ['schemeProgress']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user=$this->Auth->user();
        $schemeProgress = $this->SchemeProgresses->newEntity();
        if ($this->request->is('post'))
        {

            $data=$this->request->data;
            $data['office_id']=$user['office_id'];
            $data['created_by']=$user['id'];
            $data['created_date']=time();
            $scheme=TableRegistry::get('SchemeProgresses');
            $query=$scheme->query();
            $query->update()
                ->set(['status'=>0])
                ->where(['scheme_id'=>$data['scheme_id']])
                ->execute();

            $schemeProgress = $this->SchemeProgresses->patchEntity($schemeProgress, $data);
            if ($this->SchemeProgresses->save($schemeProgress))
            {
                $this->Flash->success(__('The scheme progress has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            else
            {
                $this->Flash->error(__('The scheme progress could not be saved. Please, try again.'));
            }
        }
        $schemes = $this->SchemeProgresses->Schemes->find('list')
            ->innerJoin('project_offices', 'project_offices.project_id = Schemes.project_id')
            ->leftJoin('projects', 'projects.id = Schemes.project_id')
            ->where(['project_offices.office_id'=>$user['office_id']]);
        $this->set(compact('schemeProgress', 'schemes'));
        $this->set('_serialize', ['schemeProgress']);
    }


}
