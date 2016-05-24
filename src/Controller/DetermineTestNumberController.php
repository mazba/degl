<?php
namespace App\Controller;

use Cake\Core\Configure;

/**
 * DetermineTestNumber Controller
 *
 * @property \App\Model\Table\DetermineTestNumberTable $DetermineTestNumber
 */
class DetermineTestNumberController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {

        $this->loadModel('LabTestGroup');
        $this->loadModel('LabTestLists');
        $labTestGroups = $this->LabTestGroup->find('list', ['limit' => 200]);
        $this->set(compact('labTestGroups', 'labTestLists'));
    }

    public function getTestNumber()
    {
        $inputs = $this->request->data;
        $this->loadModel('LabTestFrequency');
        $labTestFrequency = $this->LabTestFrequency->find('all', ['conditions' => ['lab_test_group_id' => $inputs['lab_test_group_id'], 'lab_test_list_id' => $inputs['lab_test_list_id'], 'unit_type' => $inputs['unit_type']]])->first();

        $arr = [];
        if ($labTestFrequency) {
            if ($inputs['work_done_quantity'] <= $labTestFrequency->per_unit) {
                $arr['test_needed'] = $labTestFrequency->test_no;
                $arr['test_no_type'] = $labTestFrequency->test_no_type ? $labTestFrequency->test_no_type : 0;
            } else {
                $test_needed = round($inputs['work_done_quantity'] / $labTestFrequency->per_unit);


                $whole = (int) $test_needed;  // 5
                $frac  = $test_needed - (int) $test_needed;  // .7
                if($frac>.2){
                 $test=   $whole+1;
                }else{
                    $test= $whole;
                }
                $arr['test_needed'] = $test;
                $arr['test_no_type'] = $labTestFrequency->test_no_type ? $labTestFrequency->test_no_type : 0;
            }

        }

        $this->response->body(json_encode($arr));
        return $this->response;
    }

    public function getTestList()
    {
        $this->loadModel('LabTestLists');
        $labTestLists = $this->LabTestLists->find('list', ['conditions' => ['lab_test_group_id' => $this->request->data['group_id']]]);

        $this->response->body(json_encode($labTestLists));
        return $this->response;
    }

    public function getTestUnitType()
    {
        $inputs = $this->request->data;
        $this->loadModel('LabTestFrequency');
        $labTestFrequency = $this->LabTestFrequency->find('all', ['conditions' => ['lab_test_group_id' => $inputs['group_id'], 'lab_test_list_id' => $inputs['test_id']]])->first();

        $arr['id'] = $labTestFrequency->unit_type;
        $arr['unit_type'] = Configure::read('test_frequency_unit_type')[$labTestFrequency->unit_type];
        $this->response->body(json_encode($arr));
        return $this->response;
    }

}