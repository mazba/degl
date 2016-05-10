<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * SchemeProgressReports Controller
 *
 */
class LabBillReportsController extends AppController
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

            $this->loadModel('LabBills');
            $labBills = $this->LabBills->find();
            $labBills->select(['schemes.name_en', 'total_amount' => $labBills->func()->max('LabBills.total_amount'), 'LabBills.created_date']);
            $labBills->where(['LabBills.type' =>'scheme','LabBills.created_date >=' => $form_date, 'LabBills.created_date <=' => $to_date,]);
            $labBills->leftJoin('schemes', 'schemes.id=LabBills.reference_id and LabBills.type="scheme"');
            $labBills->group(['LabBills.reference_id']);
            $labBills->toArray();

            $this->set(compact(['labBills']));
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
