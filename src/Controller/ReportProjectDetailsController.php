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
class ReportProjectDetailsController extends AppController
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
        //To-Do office_id may be required to check
        /* $user = $this->Auth->user();
         $projects_table = TableRegistry::get('projects');
         $query = $projects_table->find();
         $projects_info=$query->toArray();
         $projects=array();
         foreach($projects_info as $p)
         {
             $projects[$p->id]['id']=$p['id'];
             $projects[$p->id]['name_en']=$p['name_en'];
             $projects[$p->id]['total_scheme']=0;
             $projects[$p->id]['complete_scheme']=0;

         }

         $schemes_table = TableRegistry::get('schemes');
         $query = $schemes_table->find();
         $query->select([
             'count' => $query->func()->count('id'),
             'project_id'=>'project_id',
 //            'deactive'=>$query->func()->count('*')

         ]);
         $query->group(['project_id']);
         $schemes_counts=$query->toArray();
 //        pr($schemes_counts);die;
         foreach($schemes_counts as $s)
         {
             $projects[$s->project_id]['total_scheme']=$s->count;
         }
         $query = $schemes_table->find();
         $query->select(['count' => $query->func()->count('*'),'project_id'=>'project_id']);
         $query->group(['project_id']);
         $query->where(['status' => Configure::read('scheme_complete_status')]);
         $schemes_counts=$query->toArray();
         foreach($schemes_counts as $s)
         {
             $projects[$s->project_id]['complete_scheme']=$s->count;
         }
         $this->set(compact('projects'));*/

        $this->loadModel('Schemes');

        $query = $this->Schemes->find();
        $query = $query->select([
            'Schemes.project_id',
            'number_of_scheme' => $query->func()->count('Schemes.id')
        ]);
        $scheme_statuses =  $query->group(['Schemes.project_id'])->hydrate(false)->toArray();

        // find inactive data
        $inactive = $this->Schemes->find();
        $inactive = $inactive->select([
            'Schemes.project_id',
            'inactive_scheme' => $query->func()->count('Schemes.id')
        ])->where(['Schemes.scheme_progress_status' => 0]);
        $inactive_statuses =  $inactive->group(['Schemes.project_id'])->hydrate(false)->toArray();

        $this->loadModel('Projects');
        $projects = $this->Projects->find('list')->toArray();

        foreach($scheme_statuses as &$query){
            if($projects[$query['project_id']]){
                $query['title'] = $projects[$query['project_id']];
            }
        }
        foreach($scheme_statuses as &$scheme_statuse){
            foreach($inactive_statuses as $inactive_statuse){
                if($scheme_statuse['project_id'] == $inactive_statuse['project_id']){
                    $scheme_statuse['deactive'] = $inactive_statuse['inactive_scheme'];
                }
            }
        }
        $this->set(compact('scheme_statuses'));
    }
}
