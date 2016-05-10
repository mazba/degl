<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * PurtoBills Controller
 *
 * @property \App\Model\Table\PurtoBillsTable $PurtoBills
 */
class CashbooksController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->loadModel('Projects');
        $projects = $this->Projects->find('list');
        $this->set('projects', $projects);
    }
    public function ajax($action = '')
    {
        $this->layout='ajax';
        if($action == 'get_cashbook_by_month')
        {
            $this->view = 'cashbook_report';
            $user = $this->Auth->user();
            $month = $this->request->data(['month']);
            $year = $this->request->data(['year']);
            $project_id = $this->request->data(['project']);

            $start_date = $year.'-'.$month.'-'.'01';

            $end_date = strtotime(date("Y-m-t", strtotime($start_date)));
            $start_date = strtotime($year.'-'.$month.'-'.'01');
            $this->loadModel('allotment_registers');
            $allotments = $this->allotment_registers->find('all',
                [
                    'conditions'=>[
                        'allotment_registers.allotment_date >='=>$start_date,
                        'allotment_registers.allotment_date <='=>$end_date,
                        'allotment_registers.project_id'=>$project_id
                    ],
                    'contain'=>['Projects', 'Schemes']
                ]);
            $this->set('allotments', $allotments);
        }
    }
}
