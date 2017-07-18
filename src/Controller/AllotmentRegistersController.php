<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * AllotmentRegisters Controller
 *
 * @property \App\Model\Table\AllotmentRegistersTable $AllotmentRegisters
 */
class AllotmentRegistersController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $user = $this->Auth->user();
        $allotmentRegisters = $this->AllotmentRegisters->find('all', [
            'conditions' =>['AllotmentRegisters.status !=' => 99,'AllotmentRegisters.office_id'=>$user['office_id']],
            'contain' => ['Offices', 'Projects', 'Schemes', 'CreatedUser', 'UpdatedUser'],
            'order' => ['AllotmentRegisters.id' => 'desc']
        ]);
        $this->set('allotmentRegisters', $allotmentRegisters);
        $this->set('_serialize', ['allotmentRegisters']);
    }

    /**
     * View method
     *
     * @param string|null $id Allotment Register id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Auth->user();
        $allotmentRegister = $this->AllotmentRegisters->get($id, [
            'contain' => ['Offices', 'Projects', 'Schemes', 'CreatedUser', 'UpdatedUser']
        ]);
        $this->set('allotmentRegister', $allotmentRegister);
        $this->set('_serialize', ['allotmentRegister']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($action, $id, $letter_id=null)
    {
        $user = $this->Auth->user();
        $allotmentRegister = $this->AllotmentRegisters->newEntity();
        if ($this->request->is('post'))
        {
            $data = $this->request->data;
            $x = strtotime($data['allotment_date']);
            if ($x !== false) {
                $data['allotment_date'] = $x;
            } else {
                $data['allotment_date'] = 0;
            }
            // now check the allotment is from letter or purto bills
            if ($action == 'purto_bill') {
                $data['dr_cr'] = 'Credit';
                $data['purto_bill_id'] = $id;
            } elseif ($action == 'letter') {
                $data['dr_cr'] = 'Debit';
                $data['memo_no'] = $id;
            }
            $data['created_by'] = $user['id'];
            $data['office_id'] = $user['office_id'];
            $data['created_date'] = time();
            $allotmentRegister = $this->AllotmentRegisters->patchEntity($allotmentRegister, $data);
            if ($alr=$this->AllotmentRegisters->save($allotmentRegister)) {

                if (!empty($data['parent_id'])) {
                    $this->loadModel('nothi_assigns');
                    $nothi_data = array();
                    $nothi_data['nothi_register_id'] = $data['parent_id'];
                    $nothi_data['allotment_register_id'] = $alr['id'];
                    $new_nothi = $this->nothi_assigns->newEntity();
                    $nothi = $this->nothi_assigns->patchEntity($new_nothi, $nothi_data);
                    $this->nothi_assigns->save($nothi);
                }

                $this->loadModel('Projects');
                $project=$this->Projects->get($data['project_id']);
                $this->loadModel('TaskRegisters');
                $taskRegister=$this->TaskRegisters->newEntity();
                $task['task_name']="AllotmentRegister";
                $task['table_name']="allotment_registers";
                $task['table_row_id']=$alr['id'];
                $task['trigger_type']="Message";
                $task['trigger_id']=$letter_id;
                $task['display_text']= date('d-m-Y')." তারিখে ".$project['name_bn']." প্রকল্পে ".$data['allotment_amount']." বরাদ্ধ এছেসে";
                if($action == 'purto_bill')
                {
                    $task['trigger_type']="Task";
                    $task['trigger_id']=$id;
                    $task['display_text']= date('d-m-Y')." তারিখে ".$project['name_bn']." প্রকল্পে ".$data['allotment_amount']." বরাদ্ধ দেওয়া হয়েছে";
                }

                $task['status']=1;
                $task['created_date']=time();
                $task['created_by']=$user['id'];
                $taskRegister=$this->TaskRegisters->patchEntity($taskRegister,$task);
                $this->TaskRegisters->save($taskRegister);


                $this->Flash->success('The allotment register has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The allotment register could not be saved. Please, try again.');
            }
        }
        if ($action == 'purto_bill'){
//            $purto_bill = $this->AllotmentRegisters->PurtoBills->find('', [
//                'conditions' => ['PurtoBills.id' => $id],
//                'contain' => ['Schemes', 'Projects', 'FinancialYearEstimates']
//            ])->first();

            $this->loadModel('processed_ra_bills');
            $this->loadModel('proposed_ra_bills');
            $this->loadModel('Schemes');
          //  $this->loadModel('Schemes');
            $processed_ra_bill_info=$this->processed_ra_bills->get($id);
            $proposed_ra_bill=$this->proposed_ra_bills->get($processed_ra_bill_info->proposed_ra_bill_id);

            $scheme_info=$this->Schemes->find('all',[
                'conditions' => ['Schemes.id' =>$processed_ra_bill_info->scheme_id ],
               'contain' => [ 'Projects', 'FinancialYearEstimates']
            ])->first();
         //  echo "<pre>";print_r($scheme_info->financial_year_estimate);die();

            $this->set(compact('processed_ra_bill_info','scheme_info','proposed_ra_bill'));
        }

        elseif ($action == 'letter') {
            $projects = $this->AllotmentRegisters->Projects
                ->find('list')
                ->where(['Projects.status'=>1])
                ->where(['project_offices.office_id'=>$user['office_id']])
                ->innerJoin('project_offices','project_offices.project_id = Projects.id');
            $this->loadModel('FinancialYearEstimates');
            $financial_years = $this->FinancialYearEstimates->find('list')->where(['status'=>1]);
            $this->set(compact(['projects', 'financial_years']));

        }

        $this->loadModel('NothiRegisters');
        $nothiRegisters = $this->NothiRegisters->find('list', [
            'conditions' => ['status' => 1, 'parent_id' => 0],
        ])->toArray();
        $this->set(compact('allotmentRegister','nothiRegisters'));
        $this->set('_serialize', ['allotmentRegister']);
    }

    public function report()
    {
        $user = $this->Auth->user();
        $this->loadModel('FinancialYearEstimates');
        $this->loadModel('Offices');
        if ($this->request->is('post')) {
            $inputs = $this->request->data;
            $this->loadModel('AllotmentRegisters');
            $allotment_registers = $this->AllotmentRegisters->find()
                ->autoFields(true)
                ->select(['schemes.name_bn', 'projects.name_bn'])
                ->where(['AllotmentRegisters.financial_year_id' => $inputs['financial_year_id']])
                ->leftJoin('projects', 'projects.id=AllotmentRegisters.project_id')
                ->leftJoin('schemes', 'schemes.id=AllotmentRegisters.scheme_id')
                ->toArray();

            if ($allotment_registers) {
                $financial_year = $this->FinancialYearEstimates->get($inputs['financial_year_id']);
                $info['financial_year_name'] = $financial_year['name'];
                $this->set(compact(['allotment_registers', 'info']));
            }
        }

        $this->loadModel('Projects');
        $projects = $this->Projects->find('list')
            ->innerJoin('project_offices', 'project_offices.project_id = Projects.id')
            ->where(['project_offices.office_id' => $user['office_id']]);
        $arr = array();
        foreach ($projects as $key => $project) {
            $arr[$key] = substr($project, 0, 500) . '...';
            $arr[$key] = substr($arr[$key], 0, strrpos($arr[$key], ' ')) . ' ... ';
        }
        $projects = $arr;


        $financial_years = $this->FinancialYearEstimates->find('list');

        $this->set(compact(['projects', 'financial_years']));
    }
}
