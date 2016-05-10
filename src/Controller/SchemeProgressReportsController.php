<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * SchemeProgressReports Controller
 *
 */
class SchemeProgressReportsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $user = $this->Auth->user();

        if ($this->request->is('post')) {
            $form_date = strtotime($this->request->data['form_date']);
            $to_date = strtotime($this->request->data['to_date']);

            $this->loadModel('Schemes');
            $schemes = $this->Schemes->find();
            $schemes->autoFields(true);
            $schemes->select(['contractors.contractor_title', 'progress_value' => $schemes->func()->max('scheme_progresses.progress_value'), 'upazilas.name_en']);
            $schemes->where(['Schemes.status' => 1, 'Schemes.actual_start_date >=' => $form_date, 'Schemes.actual_start_date <=' => $to_date,]);
            $schemes->leftJoin('upazilas', 'upazilas.id=Schemes.upazila_id');
            $schemes->leftJoin('scheme_progresses', 'scheme_progresses.scheme_id=Schemes.id');
            $schemes->leftJoin('scheme_contractors', 'scheme_contractors.scheme_id=Schemes.id');
            $schemes->leftJoin('contractors', 'contractors.id=scheme_contractors.scheme_id');
            $schemes->group(['Schemes.id']);
            $schemes->toArray();

            $this->set(compact(['schemes']));
        }


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

    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

    }


}
