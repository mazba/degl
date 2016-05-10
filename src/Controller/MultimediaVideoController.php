<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class MultimediaVideoController extends AppController
{

    /**
     * Displays a view
     *
     * @return void|\Cake\Network\Response
     * @throws \Cake\Network\Exception\NotFoundException When the view file could not
     *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
     */
    public function index()
    {
        $user = $this->Auth->user();
        $multimedia = TableRegistry::get('multimedia');
        $schemes = $multimedia->find('all')
            ->select(['multimedia.scheme_id','schemes.name_en'])
            ->leftJoin('schemes', 'schemes.id = multimedia.scheme_id')
            ->where(['multimedia.office_id'=>$user['office_id'],'multimedia.type'=>'video'])
            ->toArray();
        $arrange_schemes = array();
        foreach($schemes as $scheme)
        {
            if($scheme['scheme_id'])
            {
                $arrange_schemes[$scheme['scheme_id']][] = $scheme['schemes']['name_en'];
            }
            else
            {
                $arrange_schemes[0][] = 'Others';
            }
        }
        $this->set('arrange_schemes', $arrange_schemes);

    }
    public function view($id = null)
    {
        $user = $this->Auth->user();
        $multimedia = TableRegistry::get('multimedia');
        $videos = $multimedia->find('all')
            ->where(['multimedia.office_id'=>$user['office_id'],'multimedia.type'=>'video'])
            ->where(['multimedia.scheme_id'=>$id])
            ->toArray();
        $this->set('videos', $videos);
    }
    public function add()
    {
        $user = $this->Auth->user();
        if ($this->request->is(['patch', 'post', 'put']))
        {
            $inputs = $this->request->data;
            $files=array();
            $file_upload_complete=true;
            $file_type_valid=true;

            //check file type
            for($i=0; $i<sizeof($_FILES['files']['name']); $i++)
            {
                if(!substr($_FILES["files"]["type"][$i],0,5) == 'video')
                {
                    $file_type_valid = false;
                    $this->Flash->error(__('File types is not valid. Please Upload a Video file'));
                    break;
                }
            }
            if($file_type_valid)
            {
                $base_upload_path = WWW_ROOT.'files/multimedia_videos';
                for($i=0; $i<sizeof($_FILES['files']['name']); $i++)
                {
                    $tmp_name = $_FILES['files']['tmp_name'][$i];
                    //Get the temp file path
                    if($tmp_name)
                    {
                        $name = time().'_'.str_replace(' ','_',$_FILES['files']['name'][$i]);
                        if(move_uploaded_file($tmp_name, $base_upload_path.'/'.$name))
                        {
                            $files[]['file_path']=$name;
                        }
                        else
                        {
                            $file_upload_complete=false;
                            break;
                        }
                    }
                }
                if($file_upload_complete)
                {
                    $time = time();
                    $user = $this->Auth->user();
                    $multimedia = TableRegistry::get('multimedia');
                    $data['title'] = $inputs['title'];
                    $data['office_id'] = $user['office_id'];
                    $data['location'] = $inputs['location'];
                    $data['remarks'] = $inputs['remarks'];
                    $data['date'] = strtotime($inputs['video_capture_date']);
                    $data['type'] = 'video';
                    $data['created_by'] = $user['id'];
                    $data['created_date'] = $time;
                    $data['status'] = 1;
                    $data['scheme_id'] = ($inputs['scheme_id'] ? $inputs['scheme_id'] : 0); // if scheme_id is not supplied save 0;
                    foreach($files as $file)
                    {
                        $data['file_link']=$file['file_path'];
                        $file_query = $multimedia->query();
                        $file_query->insert(array_keys($data))
                            ->values($data)
                            ->execute();
                    }
                    $this->Flash->success('The Multimedia Video has been saved.');
                    return $this->redirect(['action' => 'index']);
                }
                else
                {
                    $this->Flash->error('The Multimedia video could not be saved. Please, try again.');
                }
            }
        }
        $this->loadModel('Schemes');
        $schemes = $this->Schemes->find('list')
            ->select(['Schemes.id'])
            ->innerJoin('project_offices', 'project_offices.project_id = Schemes.project_id')
            ->distinct(['Schemes.id'])
            ->leftJoin('projects', 'projects.id = Schemes.project_id')
            ->where(['project_offices.office_id'=>$user['office_id']])
            ->toArray();
        $this->set('schemes', $schemes);

    }
}
