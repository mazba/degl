<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * UpazilaMeasure Controller
 *
 * @property \App\Model\Table\UpazilaMeasureTable $UpazilaMeasure
 */
class UpazilaMeasureController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        if ($this->request->is('ajax')) {
            $this->loadModel('Schemes');
            $user = $this->Auth->user();
            $schemes = $this->Schemes->find('all')//->autoFields(true)
            ->select([
                'financial_year' => 'financial_year_estimates.name',
                'scheme_name' => 'Schemes.name_en',
                'package_name' => 'packages.name_en',
                'projects_name' => 'projects.short_code',
                'districts_name' => 'districts.name_en',
                'upazilas_name' => 'upazilas.name_en',
                'scheme_code' => 'Schemes.scheme_code',
                'contractor_name' => 'contractors.contractor_title',
                'contract_amount' => 'Schemes.contract_amount',
                'contract_date' => 'Schemes.proposed_start_date', /*'scheme_progresses' => 'scheme_progresses.progress_value',*/
                'palasiding_length' => 'Schemes.palasiding_length',
                'expected_complete_date' => 'Schemes.expected_complete_date',
                'scheme_id' => 'Schemes.id',
                'scheme_progresses' => '(SELECT `progress_value` FROM `scheme_progresses`  WHERE `scheme_id` = `Schemes`.`id` ORDER BY `id` DESC LIMIT 1)'
            ])
                ->distinct(['Schemes.id'])
                ->innerJoin('project_offices', 'project_offices.project_id = Schemes.project_id')
                ->leftJoin('projects', 'projects.id = Schemes.project_id')
                ->leftJoin('districts', 'districts.id = Schemes.district_id')
                ->leftJoin('upazilas', 'upazilas.id = Schemes.upazila_id')
                ->leftJoin('scheme_progresses', 'scheme_progresses.scheme_id = Schemes.id')
                ->leftJoin('upazilas', 'upazilas.id = Schemes.upazila_id')
                ->leftJoin('packages', 'packages.id = Schemes.package_id')
                ->leftJoin('scheme_contractors', 'scheme_contractors.scheme_id = Schemes.id')
                ->leftJoin('contractors', 'contractors.id = scheme_contractors.contractor_id')
                ->leftJoin('financial_year_estimates', 'financial_year_estimates.id = Schemes.financial_year_estimate_id')
                ->where(['Schemes.status' => 1, 'project_offices.office_id' => $user['office_id']])
                ->order(['Schemes.id' => 'desc'])
                ->toArray();
            $sl = 1;
            foreach ($schemes as &$scheme) {
                $scheme['sl'] = $sl;
                $scheme['contract_date'] = date('d/m/Y', $scheme['contract_date']);
                $scheme['expected_complete_date'] = date('d/m/Y', $scheme['expected_complete_date']);
                //$scheme['action'] = '<button title="' . __('Edit') . ' " data-scheme_id="' . $scheme['scheme_id'] . '" class="icon-newspaper text-danger edit" > </button>';
                $scheme['action'] =
                    '<button title="' . __('Scheme Measure') . ' " data-scheme_id="' . $scheme['scheme_id'] . '" class="icon-loop5 text-success measurement" > </button>';
                $sl++;
            }
            $this->response->body(json_encode($schemes));
            return $this->response;
        }
    }

    // measure
    public function measurement($scheme_id = null)
    {
        $this->loadModel('Measurements');
        $this->layout = 'ajax';
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Auth->user();
            $time = time();
            $data = $this->request->data;
            foreach ($data['measurement'] as $measurement) {
                $measurement['measured-by'] = $data['measured-by'];
                $measurement['scheme_id'] = $data['scheme_id'];
                $measurement['measurement_no'] = $data['measurement_no'];
                $measurement['measurement_date'] = strtotime($data['measurement_date']);

                $measurement['created_by'] = $user['id'];
                $measurement['created_date'] = $time;
                $measurement['status'] = 1;

                $measurements = $this->Measurements->newEntity();
                $measurements = $this->Measurements->patchEntity($measurements, $measurement);

                $this->Measurements->save($measurements);
            }
            $this->Flash->success('Measure has been successfully added');
            return $this->redirect(['action' => 'index']);
        }
        $measurement_head = TableRegistry::get('Measurements')
            ->find()
            ->select(['measurement_no', 'measurement_date'])
            ->where(['scheme_id' => $scheme_id])
            ->distinct(['measurement_no']);

        $measurement_info = [];
        foreach ($measurement_head as $measurement_no) {
            $measurement_details = TableRegistry::get('Measurements')
                ->find()
                ->select(['measurement_date' => 'Measurements.measurement_date', 'measured_by' => 'Measurements.measured-by', 'quantity_of_work_done' => 'Measurements.quantity_of_work_done', 'item_display_code' => 'schemes_items.item_display_code', 'unit' => 'schemes_items.unit', 'quantity' => 'schemes_items.quantity', 'description' => 'schemes_items.description'])
                ->where(['Measurements.status' => 1, 'Measurements.measurement_no' => $measurement_no['measurement_no'], 'Measurements.scheme_id' => $scheme_id])
                ->leftJoin('schemes_items', 'schemes_items.id=Measurements.item_id');
            $measurement_info[$measurement_no['measurement_no'] . '-Date-' . date('d-M-Y', $measurement_no['measurement_date'])]['info'] = $measurement_details->toArray();
        }

        // echo "<pre>";print_r($measurement_info);die();

        $items = TableRegistry::get('SchemesItems')
            ->find()
            ->where(['status' => 1, 'scheme_id' => $scheme_id]);

        $id = $scheme_id;
        $measurements = $this->Measurements->newEntity();
        $this->set(compact('items', 'measurement_info', 'measurements', 'id'));
    }
}
