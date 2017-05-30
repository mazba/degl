<?php
/**
 * Created by Rana ranabd36@gmail.com.
 * Date: 12/17/2015
 * Time: 2:22 PM
 */

namespace App\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class GeneralReportsController extends AppController {


  public function index() {

    if ($this->request->is(['post'])) {
      $inputs = $this->request->data;
      $field_config = Configure::read('general_report_fields');
      $arraged_items = [];
//      pr($inputs);die;
      foreach($inputs['selected_items_values_in_order'] as &$item)
        $arraged_items[$field_config[$item]] = $item;
      $inputs['field'] = $arraged_items;
//      pr($inputs);die;
      $inputs['progress'] = str_replace('%', '', $inputs['progress']);
      $inputs['progress'] = explode('-', $inputs['progress']);
      $user = $this->Auth->user();
      $start_date = $inputs['form_date'] ? strtotime($inputs['form_date'] . " 00:00:00") : NULL;
      $end_date = $inputs['to_date'] ? strtotime($inputs['to_date'] . ' 23.59.59') : NULL;

      $physical_progress = FALSE;
      $total_fund_receive = FALSE;
      $this->loadModel('Schemes');
      $scheme_select_fields = [];
      $scheme_sort_by = [];
      $fund_receive = [];
      $fund_spend = [];
      $summery = [];

      $current_month = date('m');
      if ($current_month > 6) {
        $receive_start_date = strtotime("01-07-" . date('Y', $end_date));
        $receive_end_date = strtotime("30-06-" . date('Y', $end_date) . " + 1 year");
      } else {
        $receive_start_date = strtotime("01-07-" . date('Y', $end_date) . " - 1 year");
        $receive_end_date = strtotime("30-06-" . date('Y', $end_date));
      }

      if (isset($inputs['field']['District'])) {
        $scheme_select_fields = array_merge($scheme_select_fields, ['district_name' => 'districts.name_bn']);
      }
      if (isset($inputs['field']['Upazila'])) {
        $scheme_select_fields = array_merge($scheme_select_fields, ['upazila_name' => 'upazilas.name_bn']);
        array_push($scheme_select_fields, 'Schemes.upazila_id');
      }
      if (isset($inputs['field']['Package No.'])) {
        $scheme_select_fields = array_merge($scheme_select_fields, ['package_name' => 'packages.name_bn']);
      }
      if (isset($inputs['field']['Category Name'])) {
        array_push($scheme_select_fields, 'Schemes.category_name');
      }
      if (isset($inputs['field']['Financial Year'])) {
        $scheme_select_fields = array_merge($scheme_select_fields, ['financial_year' => 'financial_year_estimates.name']);
      }
      if (isset($inputs['field']['Scheme Name'])) {
        array_push($scheme_select_fields, 'Schemes.name_bn');
      }
      if (isset($inputs['field']['Contractor Name'])) {
        $scheme_select_fields = array_merge($scheme_select_fields, ['contractor_name' => 'contractors.contractor_title']);
      }
      if (isset($inputs['field']['Contract Date'])) {
        array_push($scheme_select_fields, 'Schemes.contract_date');
      }
      if (isset($inputs['field']['Contract Amount'])) {
        array_push($scheme_select_fields, 'Schemes.contract_amount');
      }
      if (isset($inputs['field']['Approval Estimated Cost'])) {
        array_push($scheme_select_fields, 'Schemes.eve_approval_bill');
      }
      if (isset($inputs['field']['Completion Date'])) {
        array_push($scheme_select_fields, 'Schemes.completion_date');
      }
      if (isset($inputs['field']['Actual Completion Date'])) {
        array_push($scheme_select_fields, 'Schemes.actual_complete_date');
      }
      if (isset($inputs['field']['Physical Progress'])) {
        $physical_progress = TRUE;
      }
      if (isset($inputs['field']['Road Length'])) {
        array_push($scheme_select_fields, 'Schemes.road_length');
      }
      if (isset($inputs['field']['Structure Length'])) {
        array_push($scheme_select_fields, 'Schemes.structure_length');
      }
      if (isset($inputs['field']['Building'])) {
        array_push($scheme_select_fields, 'Schemes.building_quantity');
      }
      if (isset($inputs['field']['Estimated Cost'])) {
        array_push($scheme_select_fields, 'Schemes.estimated_cost');
      }
      if (isset($inputs['field']['Estimated Cost (Road)'])) {
        array_push($scheme_select_fields, 'Schemes.estimated_road');
      }
      if (isset($inputs['field']['Estimated Cost (Structure)'])) {
        array_push($scheme_select_fields, 'Schemes.estimated_structure');
      }
      if (isset($inputs['field']['Tender Received Date'])) {
        array_push($scheme_select_fields, 'Schemes.tender_date');
      }
      if (isset($inputs['field']['Work Order Date'])) {
        array_push($scheme_select_fields, 'Schemes.work_order_date');
      }
      if (isset($inputs['field']['Work Completion Date'])) {
        array_push($scheme_select_fields, 'Schemes.actual_complete_date');
      }
      if (isset($inputs['field']['Payment (Road)'])) {
        array_push($scheme_select_fields, 'Schemes.payment_road');
      }
      if (isset($inputs['field']['Payment (Structure)'])) {
        array_push($scheme_select_fields, 'Schemes.payment_structure');
      }
      if (isset($inputs['field']['Allotted Amount'])) {
        array_push($scheme_select_fields, 'Schemes.allotment_bill');
      }
      if (isset($inputs['field']['Allotted Date'])) {
        array_push($scheme_select_fields, 'Schemes.allotment_date');
      }
      if (isset($inputs['field']['Approved Date'])) {
        array_push($scheme_select_fields, 'Schemes.eve_approval_date');
      }
      if (isset($inputs['field']['Work Start Date'])) {
        array_push($scheme_select_fields, 'Schemes.actual_start_date');
      }
      if (isset($inputs['field']['Expenditure'])) {
        array_push($scheme_select_fields, 'Schemes.expenditure');
      }
      if (isset($inputs['field']['Divisional goods'])) {
        array_push($scheme_select_fields, 'Schemes.div_goods');
      }
       if (isset($inputs['field']['Work Remarks'])) {
        array_push($scheme_select_fields, 'Schemes.work_remarks');
      }

      //Fund Receive

      if (isset($inputs['field']['Total Fund Received'])) {
        $this->loadModel('AllotmentRegisters');
        $total_fund_receive = $this->AllotmentRegisters->find()
                                                       ->hydrate(FALSE);
        $total_fund_receive->select(['total_fund_receive' => $total_fund_receive->func()
                                                                                ->sum('allotment_amount')]);

        if (!empty($inputs['project_id'])) {
          $total_fund_receive->where(['AllotmentRegisters.project_id' => $inputs['project_id'], 'AllotmentRegisters.dr_cr' => "Debit"]);
        }
        $total_fund_receive = $total_fund_receive->toArray();
      }
      if (isset($inputs['field']['Fund Received This Year'])) {
        $this->loadModel('AllotmentRegisters');
        $fund_received_this_year = $this->AllotmentRegisters->find()
                                                            ->hydrate(FALSE);
        $fund_received_this_year->select(['fund_received_this_year' => $fund_received_this_year->func()
                                                                                               ->sum('allotment_amount')]);
        if (!empty($inputs['project_id'])) {
          $fund_received_this_year->where(['AllotmentRegisters.project_id' => $inputs['project_id'], 'AllotmentRegisters.dr_cr' => "Debit", 'AllotmentRegisters.allotment_date >=' => $receive_start_date, 'AllotmentRegisters.allotment_date <=' => $receive_end_date]);
        }
        $fund_received_this_year = $fund_received_this_year->toArray();
      }

      foreach ($inputs['sort_by'] as $key => $value) {
        if (!empty($value)) {
          $scheme_sort_by = array_merge($scheme_sort_by, [$value => $inputs['order_by'][$key]]);
        }
      }

      /*echo "<pre>";
      print_r($summery->toArray());
      echo "</pre>";
      die;*/

      $schemes = $this->Schemes->find()
                               ->hydrate(FALSE);
      $schemes->select($scheme_select_fields);
      if ($physical_progress) {
        // $schemes->select(['physical_progress' => $schemes->func()->max('scheme_progresses.progress_value')]);
        $schemes->select([/*'physical_progress' => 'scheme_progresses.progress_value',*/'physical_progress' => '(SELECT `progress_value` FROM `scheme_progresses`  WHERE `scheme_id` = `Schemes`.`id` ORDER BY `id` DESC LIMIT 1)']);

      }

      if (isset($inputs['field']['Total Fund Spend'])) {
        $schemes->select(['total_fund_spend' => $schemes->func()
                                                        ->sum('allotment_registers.allotment_amount')]);
        $schemes->leftJoin('allotment_registers', 'allotment_registers.scheme_id=Schemes.id and allotment_registers.dr_cr="Credit"');
      }

      if (isset($inputs['field']['Fund Spend This Year'])) {
        $schemes->select(['fund_spend_this_year' => $schemes->func()
                                                            ->sum('allotment_registers.allotment_amount')]);
        $schemes->leftJoin('allotment_registers', 'allotment_registers.scheme_id=Schemes.id and allotment_registers.dr_cr="Credit" and allotment_registers.allotment_date >=' . $receive_start_date, 'allotment_registers.allotment_date <=' . $receive_end_date);
      }
      if (isset($inputs['field']['Fund Spend This Month'])) {
        $receive_start_date = strtotime('01-' . date('m-Y'));
        $receive_end_date = strtotime(date('t-m-Y'));
        $schemes->select(['fund_spend_this_month' => $schemes->func()
                                                             ->sum('allotment_registers.allotment_amount')]);
        $schemes->leftJoin('allotment_registers', 'allotment_registers.scheme_id=Schemes.id and allotment_registers.dr_cr="Credit" and allotment_registers.allotment_date >=' . $receive_start_date, 'allotment_registers.allotment_date <=' . $receive_end_date);
      }

      if (!empty($inputs['project_id'])) {
        $schemes->where(['Schemes.project_id' => $inputs['project_id'], 'Schemes.status' => 1]);
      }
      if (!empty($inputs['category_name'])) {
        $schemes->where(['Schemes.category_name' => $inputs['category_name']]);
      }

      if (!empty($inputs['financial_year_estimate_id'])) {
        $schemes->where(['Schemes.financial_year_estimate_id' => $inputs['financial_year_estimate_id']]);
      }

      if (!empty($inputs['upazila_id'])) {
        $schemes->where(['Schemes.upazila_id' => $inputs['upazila_id']]);
      }
      if (!empty($start_date)) {
        $schemes->where(['Schemes.contract_date >=' => $start_date]);
      }
      if (!empty($end_date)) {
        $schemes->where(['Schemes.contract_date <=' => $end_date]);
      }
      if (!empty($inputs['progress'])) {
        if (intval($inputs['progress'][0]) == 0) {
          $schemes->where('( (scheme_progresses.progress_value >=' . trim($inputs['progress'][0]) . ' AND ' . 'scheme_progresses.progress_value <=' . trim($inputs['progress'][1]) . ') OR scheme_progresses.progress_value IS NULL)');
        } else {
          $schemes->where(['scheme_progresses.progress_value >=' => trim($inputs['progress'][0])]);
          $schemes->where(['scheme_progresses.progress_value <=' => trim($inputs['progress'][1]), 'scheme_progresses.status' => 1]);
        }
      }

      $schemes->leftJoin('packages', 'packages.id=Schemes.package_id');
      $schemes->leftJoin('districts', 'districts.id=Schemes.district_id');
      $schemes->leftJoin('upazilas', 'upazilas.id=Schemes.upazila_id');
      $schemes->leftJoin('scheme_contractors', 'scheme_contractors.scheme_id=Schemes.id and is_lead=1');
      $schemes->leftJoin('contractors', 'contractors.id=scheme_contractors.contractor_id');
      $schemes->leftJoin('scheme_progresses', 'scheme_progresses.scheme_id=Schemes.id');
      $schemes->leftJoin('financial_year_estimates', 'financial_year_estimates.id=Schemes.financial_year_estimate_id');

      //$schemes->order('scheme_progresses.id DESC');
      $schemes->group(['Schemes.id']);
      if (!empty($scheme_sort_by)) {
        $schemes->order($scheme_sort_by);
      }
      //echo "<pre>",print_r($schemes,1),"</pre>";
      $schemes = $schemes->toArray();
      //echo "<pre>",print_r($schemes,1),"</pre>";
      $fields = array_flip($inputs['field']);

      foreach ($schemes as & $scheme) {
        if (!empty($scheme['contract_date'])) {
          $scheme['contract_date'] = date('d-m-Y', $scheme['contract_date']);
        }
        if (!empty($scheme['completion_date'])) {
          $scheme['completion_date'] = date('d-m-Y', $scheme['completion_date']);
        }
        if (!empty($scheme['actual_complete_date'])) {
          $scheme['actual_complete_date'] = date('d-m-Y', $scheme['actual_complete_date']);
        }
        if (!empty($scheme['tender_date'])) {
          $scheme['tender_date'] = date('d-m-Y', $scheme['tender_date']);
        }
        if (!empty($scheme['work_order_date'])) {
          $scheme['work_order_date'] = date('d-m-Y', $scheme['work_order_date']);
        }
        if (!empty($scheme['expected_complete_date'])) {
          $scheme['expected_complete_date'] = date('d-m-Y', $scheme['expected_complete_date']);
        }
        if (!empty($scheme['allotment_date'])) {
          $scheme['allotment_date'] = date('d-m-Y', $scheme['allotment_date']);
        }
        if (!empty($scheme['eve_approval_date'])) {
          $scheme['eve_approval_date'] = date('d-m-Y', $scheme['eve_approval_date']);
        }
        if (!empty($scheme['actual_start_date'])) {
          $scheme['actual_start_date'] = date('d-m-Y', $scheme['actual_start_date']);
        }
        if (isset($inputs['summery'])) {
          if ($scheme['category_name'] == "Category-1") {
            if (isset($summery[$scheme['upazila_name']]['category_1'])) {
              $summery[$scheme['upazila_name']]['category_1'] += 1;
            } else {
              $summery[$scheme['upazila_name']]['category_1'] = 1;
            }
          } else {
            if ($scheme['category_name'] == "Category-2") {
              if (isset($summery[$scheme['upazila_name']]['category_2'])) {
                $summery[$scheme['upazila_name']]['category_2'] += 1;
              } else {
                $summery[$scheme['upazila_name']]['category_2'] = 1;
              }
            } else {
              if ($scheme['category_name'] == "Category-3") {
                if (isset($summery[$scheme['upazila_name']]['category_3'])) {
                  $summery[$scheme['upazila_name']]['category_3'] += 1;
                } else {
                  $summery[$scheme['upazila_name']]['category_3'] = 1;
                }
              } else {
                if ($scheme['category_name'] == "Category-4") {
                  if (isset($summery[$scheme['upazila_name']]['category_4'])) {
                    $summery[$scheme['upazila_name']]['category_4'] += 1;
                  } else {
                    $summery[$scheme['upazila_name']]['category_4'] = 1;
                  }
                }
              }
            }
          }
        }

      }

      /* echo "<pre>";
//            print_r($summery);
        print_r($fields);
       echo "</pre>";
       die;*/

      if (isset($inputs['summery'])) {
        $this->set(compact('summery'));
      }
      $this->loadModel('Projects');
      $project = $this->Projects->get($inputs['project_id']);

      $this->set(compact('schemes', 'fields', 'project'));
    }

    $this->loadModel('Projects');
    $this->loadModel('FinancialYearEstimates');
    $this->loadModel('Upazilas');

    $projects = $this->Projects->find('list');
    $financialYearEstimates = $this->FinancialYearEstimates->find('list');
    $upazilas = $this->Upazilas->find('list', ['conditions' => ['district_id' => 33]]);

    $this->set(compact('projects', 'upazilas', 'financialYearEstimates', 'total_fund_receive', 'fund_received_this_year'));
  }
}