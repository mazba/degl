<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * PurtoBills Controller
 *
 * @property \App\Model\Table\PurtoBillsTable $PurtoBills
 */
class PurtoBillsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {

    }

    /**
     * View method
     *
     * @param string|null $id Purto Bill id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Auth->user();
        $purtoBill = $this->PurtoBills->get($id, [
            'contain' => ['Offices', 'FinancialYearEstimates', 'Contractors', 'Projects', 'Schemes']
        ]);
        $this->set('purtoBill', $purtoBill);
        $this->set('_serialize', ['purtoBill']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($letter_id = null)
    {

        $user = $this->Auth->user();
        $purtoBill = $this->PurtoBills->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $project = $this->PurtoBills->Schemes->get($data['scheme_id']);
            $contractor = TableRegistry::get('scheme_contractors')->find()->where(['scheme_id' => $data['scheme_id'], 'is_lead' => 1])->first();
            $data['contractor_id'] = isset($contractor['contractor_id']) ? $contractor['contractor_id'] : '';
            $data['project_id'] = $project['project_id'];
            $data['office_id'] = $user['office_id'];
            $data['created_by'] = $user['id'];
            $data['created_date'] = time();
            $data['bill_date'] = time();
            $purtoBill = $this->PurtoBills->patchEntity($purtoBill, $data);
            if ($pb = $this->PurtoBills->save($purtoBill)) {
                $this->loadModel('Projects');
                $project = $this->Projects->get($project['project_id']);
                $this->loadModel('TaskRegisters');
                $taskRegister = $this->TaskRegisters->newEntity();
                $task['task_name'] = "PurtoBill";
                $task['table_name'] = "purto_bills";
                $task['table_row_id'] = $pb['id'];
                $task['trigger_type'] = "Message";
                $task['trigger_id'] = $letter_id;
                $task['display_text'] = date('d-m-Y') . " তারিখে " . $project['name_bn'] . " প্রকল্পে " . $data['gross_bill'] . " অনুমোদন করা  হয়েছে";
                $task['status'] = 1;
                $task['created_date'] = time();
                $task['created_by'] = $user['id'];
                $taskRegister = $this->TaskRegisters->patchEntity($taskRegister, $task);
                $this->TaskRegisters->save($taskRegister);

                if (!empty($data['parent_id'])) {
                    $this->loadModel('nothi_assigns');
                    $nothi_data = array();
                    $nothi_data['nothi_register_id'] = $data['parent_id'];
                    $nothi_data['purto_bill_id'] = $pb['id'];
                    $new_nothi = $this->nothi_assigns->newEntity();
                    $nothi = $this->nothi_assigns->patchEntity($new_nothi, $nothi_data);
                    $this->nothi_assigns->save($nothi);
                }

                $this->Flash->success('The purto bill has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The purto bill could not be saved. Please, try again.');
            }
        }
        $financialYearEstimates = $this->PurtoBills->FinancialYearEstimates->find('list');
        $schemes = $this->PurtoBills->Schemes->find('list');
        $this->loadModel('NothiRegisters');
        $nothiRegisters = $this->NothiRegisters->find('list', [
            'conditions' => ['status' => 1, 'parent_id' => 0],
        ])->toArray();
        $this->set(compact('purtoBill', 'offices', 'financialYearEstimates', 'schemes', 'nothiRegisters'));
        $this->set('_serialize', ['purtoBill']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Purto Bill id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Auth->user();
        $purtoBill = $this->PurtoBills->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->data;
            $data['updated_by'] = $user['id'];
            $data['updated_date'] = time();
            $purtoBill = $this->PurtoBills->patchEntity($purtoBill, $data);
            if ($this->PurtoBills->save($purtoBill)) {
                if (!empty($data['parent_id'])) {

                    $this->loadModel('nothi_assigns');
                    $nothi_file = $this->nothi_assigns->find()
                        ->where(['project_id' => $id])
                        ->first();

                    if (!empty($nothi_file)) {
                        $arr = array();
                        $arr['nothi_register_id'] = $data['parent_id'];
                        $nothi = $this->nothi_assigns->patchEntity($nothi_file, $arr);
                        $this->nothi_assigns->save($nothi);
                    } else {
                        $nothi_data = array();
                        $nothi_data['nothi_register_id'] = $data['parent_id'];
                        $nothi_data['purto_bill_id'] = $id;
                        $new_nothi = $this->nothi_assigns->newEntity();
                        $nothi = $this->nothi_assigns->patchEntity($new_nothi, $nothi_data);
                        $this->nothi_assigns->save($nothi);
                    }

                }
                $this->Flash->success('The purto bill has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The purto bill could not be saved. Please, try again.');
            }
        }
        $this->loadModel('NothiRegisters');
        $nothiRegisters = $this->NothiRegisters->find('list', [
            'conditions' => ['status' => 1, 'parent_id' => 0],
        ])->toArray();
        $this->loadModel('nothi_assigns');
        $nothi = $this->nothi_assigns->find()->select(['nothi_register_id'])->where(['purto_bill_id' => $id])->first();
        if (!empty($nothi)) {
            $selected_nothi = $this->NothiRegisters->find()->select(['nothi_no'])->where(['id' => $nothi['nothi_register_id']])->first();
            $this->set(compact('selected_nothi'));
        }
        $this->set(compact('purtoBill', 'nothiRegisters'));
        $this->set('_serialize', ['purtoBill']);
    }

    public function report()
    {
        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $this->view = 'report_grid';
            $inputs = $this->request->data();
            $user = $this->Auth->user();
            $purtoBills = $this->PurtoBills->find('all', [
                'conditions' => ['PurtoBills.status !=' => 99, 'PurtoBills.Office_id' => $user['office_id'], 'PurtoBills.project_id' => $inputs['project_id'], 'PurtoBills.financial_year_estimate_id' => $inputs['financial_id']],
                'contain' => ['Offices', 'FinancialYearEstimates', 'Contractors', 'Schemes', 'Projects']
            ])
                ->toArray();
            $this->set(compact('purtoBills'));
        } else {
            $financialYearEstimates = $this->PurtoBills->FinancialYearEstimates->find('list');
            $projects = $this->PurtoBills->Projects->find('list');
            $this->set(compact('financialYearEstimates', 'projects'));
        }
    }

    public function ajax($action = '')
    {
        if ($action == 'grid') {
            $user = $this->Auth->user();
            $purtoBills = $this->PurtoBills->find('all', [
                'conditions' => ['PurtoBills.status !=' => 99, 'PurtoBills.Office_id' => $user['office_id']],
                'contain' => ['Offices', 'FinancialYearEstimates', 'Contractors', 'Projects', 'Schemes'],
                'order' => ['PurtoBills.id' => 'desc']
            ]);
            $data = array();
            foreach ($purtoBills as $purtoBill) {
                $data[] = [
                    'scheme' => $purtoBill['scheme']['name_en'],
                    'project' => $purtoBill['project']['name_bn'],
                    'contractor' => $purtoBill['contractor']['contractor_title'],
                    'bill_type' => $purtoBill['bill_type'],
                    'gross_bill' => $purtoBill['gross_bill'],
                    'security' => $purtoBill['security'],
                    'vat' => $purtoBill['vat'],
                    'income_taxes' => $purtoBill['income_taxes'],
                    'roller_charge' => $purtoBill['roller_charge'],
                    'lab_fee' => $purtoBill['lab_fee'],
                    'fine' => $purtoBill['fine'],
                    'financial_year' => $purtoBill['financial_year_estimate']['name'],
                    'net_taka' => $purtoBill['net_taka'],
                    'actions' => '<a title="' . __('View') . '" class="icon-newspaper" href="' . $this->request->webroot . 'PurtoBills/view/' . $purtoBill['id'] . '" ><a> &nbsp' .
                        '<a title="' . __('Edit') . '" class="icon-pencil3 text-warning" href="' . $this->request->webroot . 'PurtoBills/edit/' . $purtoBill['id'] . '" ><a> &nbsp' .
                        '<a title="' . __('Allotments') . '" class="icon-paypal2 text-danger" href="' . $this->request->webroot . 'AllotmentRegisters/add/purto_bill/' . $purtoBill['id'] . '" ><a> &nbsp'
                ];

            }
            $this->response->body(json_encode($data));
            return $this->response;
        }
    }

    public function invoice_form($id = null)
    {
        $purtoBill = $this->PurtoBills->get($id, ['contain' => ['Schemes', 'Contractors']]);
        $this->set(compact('purtoBill'));
    }

    public function purto_bills_by_scheme($scheme_id)
    {
        if ($this->user_roles['index']) {
            $user = $this->Auth->user();
            $purtoBills = $this->PurtoBills->find('all', [
                'conditions' => ['PurtoBills.status !=' => 99,
                    'PurtoBills.Office_id' => $user['office_id'],
                    'PurtoBills.scheme_id' => $scheme_id],
                'contain' => ['Offices', 'FinancialYearEstimates', 'Contractors', 'Projects', 'Schemes'],
                'order' => ['PurtoBills.id' => 'desc']
            ])->toArray();
            $this->set(compact('purtoBills'));
            $this->view = 'report_grid';
        } else {
            $this->Flash->error('You dont have access to the task');
            return $this->redirect(['controller' => 'dashboard', 'action' => 'index']);
        }
    }
}
