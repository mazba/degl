<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * PurtoBills Controller
 *
 * @property \App\Model\Table\PurtoBillsTable $PurtoBills
 */
class InvestigationReportController extends AppController
{
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $user = $this->Auth->user();
        $this->loadModel('Projects');
        $projects = $this->Projects->find('list')
            ->innerJoin('project_offices', 'project_offices.project_id = Projects.id')
            ->where(['project_offices.office_id' => $user['office_id']]);
        $this->set('projects', $projects);
    }
    public function ajax($action = '')
    {
        $this->layout='ajax';
        if($action == 'get_scheme_by_project')
        {
            $project = $this->request->data();
            $this->loadModel('Schemes');
            $data = $this->Schemes->find('list')->where(['project_id'=>$project['project_id']]);
            $this->response->body(json_encode($data));
            return $this->response;
        }
        elseif($action == 'load_investigation_report')
        {
            $this->view = 'report';
            $input = $this->request->data();
            $project_images = TableRegistry::get('project_images')->find('all');
            $project_images->select(['users.name_bn','users.picture']);
            $project_images->autoFields(true);
            if($input['scheme_id'])
            {
                $project_images->where(['project_images.scheme_id'=>$input['scheme_id']]);
            }
            $project_images->where(['project_images.project_id'=>$input['project_id']]);
            $project_images->leftJoin('users','users.id=project_images.created_by');

            $project_videos = TableRegistry::get('project_videos')->find('all');
            $project_videos->select(['users.name_bn','users.picture']);
            $project_videos->autoFields(true);
            if($input['scheme_id'])
            {
                $project_videos->where(['project_videos.scheme_id'=>$input['scheme_id']]);
            }
            $project_videos->where(['project_videos.project_id'=>$input['project_id']]);
            $project_videos->leftJoin('users','users.id=project_videos.created_by');

            $this->set('project_images', $project_images);
            $this->set('project_videos', $project_videos);
        }
    }
}
