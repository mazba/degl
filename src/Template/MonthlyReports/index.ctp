<?php
use Cake\Core\Configure;
if(isset($schemes)){
    $schemes = $schemes->toArray();
}
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">

<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Progress Report'), ['action' => 'index']) ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('Progress Report'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="panel-body">
    <div class="row">
        <?= $this->Form->create(null, ['id' => 'contractor-list']) ?>
        <div class="col-sm-offset-2 col-sm-6" style="margin-top: 15px">
            <?= $this->Form->input('project_id', ['required'=>'required','options' => $projects, 'empty' => __('Select')]) ?>
        </div>
        <!--    end field setup-->
        <div class="col-sm-offset-5 col-sm-3" style="margin-top: 15px">
            <?= $this->Form->submit(__('Progress Report'), ['class' => 'btn btn-warning']) ?>
        </div>
        <?= $this->Form->end() ?>
    </div>
    <!-- report    -->
    <div class="row">
        <div class="col-md-12">
            <?php if(isset($schemes)): ?>
                <?php if((!empty($schemes))): ?>

                    <div id="PrintArea" style="margin-top: 10px; padding: 5px; margin-bottom: 10px">
                        <button class="btn btn-info pull-right" id="print_button" onclick="print_rpt()"><?= __('Print') ?></button>
                        <h3 class="text-center"><?= $project['name_en'] ?><br>

                        </h3>
                        <div class="portlet box">
                            <div class="portlet-body">
                                <div class="table-scrollable">
                                    <table class="table table-bordered table-hover">

                                        <!--IRIDP-2-->
                                        <?php if($project['id'] == 20 || $project['id'] == 3): ?>
                                            <thead>
                                            <tr>
                                                <th>Sl. No.</th>
                                                <th>Upazila</th>
                                                <th>Package No.</th>
                                                <th>Name of scheme</th>
                                                <th>Road (km)</th>
                                                <th>Structure (m)</th>
                                                <th>Estimated Cost (Road)</th>
                                                <th>Estimated Cost (Structure)</th>
                                                <th>Estimated Cost (Total)</th>
                                                <th>Tender receiving date</th>
                                                <th>Name of Contractor</th>
                                                <th>Date of Contract</th>
                                                <th>Contract Amount</th>
                                                <th>Physical Progress (%)</th>
                                                <th>Actual Date completion</th>
                                                <th>Payment (tk.)</th>
                                                <th>Remarks</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $cost_road = 0;
                                            $cost_structure = 0;
                                            $cost_total = 0;
                                            $contract_amount = 0;
                                            $payment_road = 0;
                                            foreach($schemes as $key => $scheme):
                                                $cost_road += $scheme['cost_road'];
                                                $cost_structure += $scheme['cost_structure'];
                                                $cost_total += $scheme['cost_total'];
                                                $contract_amount+= $scheme['contract_amount'];
                                                $payment_road+= $scheme['payment_road'];
                                                ?>

                                                <tr class="custom-table-width">
                                                    <td><?= ++$key?></td>
                                                    <td><?= $scheme['upazila_name']?></td>
                                                    <td><?= $scheme['package_name']?></td>
                                                    <td><p style="width:350px;"><?= $scheme['scheme_name']?></p></td>
                                                    <td><?= $scheme['road_length']?></td>
                                                    <td><?= $scheme['structure_length']?></td>
                                                    <td><?= $scheme['cost_road']?></td>
                                                    <td><?= $scheme['cost_structure']?></td>
                                                    <td><?= $scheme['cost_total']?></td>
                                                    <td><?= date('d-m-Y', $scheme['tender_date'])?></td>
                                                    <td><?= $scheme['contractor_title']?></td>
                                                    <td><?= date('d-m-Y', $scheme['contract_date'])?></td>
                                                    <td><?= $scheme['contract_amount']?></td>
                                                    <td><?= $scheme['physical_progress']?></td>
                                                    <td><?= date('d-m-Y', $scheme['actual_complete_date'])?></td>
                                                    <td><?= $scheme['payment_road']?></td>
                                                    <th> <p contenteditable="true">&nbsp;</p></th>
                                                </tr>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td>Total</td>
                                                <td colspan="5"></td>
                                                <td><?= $cost_road?></td>
                                                <td><?= $cost_structure?></td>
                                                <td><?= $cost_total?></td>
                                                <td colspan="3"></td>
                                                <td><?= $contract_amount?></td>
                                                <td colspan="2"></td>
                                                <td><?=$payment_road?></td>
                                                <td></td>
                                            </tr>
                                            </tbody>

                                            <!--Landless mukti-->
                                        <?php elseif($project['id'] == 8): ?>
                                            <thead>
                                            <tr>
                                                <th >Sl. No.</th>
                                                <th >Upazila</th>
                                                <th >Package No.</th>
                                                <th >Name of scheme</th>
                                                <th >Name of Contractor</th>
                                                <th >Approved Estimated Cost </th>
                                                <th >Contract Amount</th>
                                                <th >Date of Contract</th>
                                                <th >Date of completion</th>
                                                <th >Actual Date completion</th>
                                                <th >Physical Progress (%)</th>
                                                <th >Payment (tk.)</th>
                                                <th >Remarks</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            <?php
                                            $estimated_cost =0;
                                            $contract_amount =0;
                                            $payment_road =0;
                                            foreach($schemes as $key => $scheme):
                                                $estimated_cost += $scheme['estimated_cost'];
                                                $contract_amount += $scheme['contract_amount'];
                                                $payment_road += $scheme['payment_road'];
                                                ?>
                                                <tr class="custom-table-width">
                                                    <td><?= ++$key?></td>
                                                    <td><?= $scheme['upazila_name']?></td>
                                                    <td><?= $scheme['package_name']?></td>
                                                    <td><p style="width:350px;"><?= $scheme['scheme_name']?></p></td>
                                                    <td><?= $scheme['contractor_title']?></td>
                                                    <td><?= $scheme['estimated_cost']?></td>
                                                    <td><?= $scheme['contract_amount']?></td>
                                                    <td><?= date('d-m-Y', $scheme['contract_date'])?></td>
                                                    <td><?= date('d-m-Y', $scheme['completion_date'])?></td>
                                                    <td><?= date('d-m-Y', $scheme['actual_complete_date'])?></td>
                                                    <td><?= $scheme['physical_progress']?></td>
                                                    <td><?= $scheme['payment_road']?></td>
                                                    <th><p contenteditable="true">&nbsp;</p></th>
                                                </tr>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td>Total</td>
                                                <td colspan="4"></td>
                                                <td><?= $estimated_cost?></td>
                                                <td><?= $contract_amount?></td>
                                                <td colspan="4"></td>
                                                <td><?=$payment_road?></td>
                                                <td></td>
                                            </tr>
                                            </tbody>

                                            <!--PEDP-3-->
                                        <?php elseif($project['id'] == 5): ?>
                                            <thead>
                                            <tr>
                                                <th >Sl. No.</th>
                                                <th >Package No.</th>
                                                <th >Name of scheme</th>
                                                <th >Approved Estimated Cost </th>
                                                <th >Tender Receiving Date</th>
                                                <th >NOA Date</th>
                                                <th >Contract Amount</th>
                                                <th >Name of Contractor</th>
                                                <th >Date of Contract</th>
                                                <th >Starting Date of Contract</th>
                                                <th >Date of Completion</th>
                                                <th >Physical Progress (%)</th>
                                                <th >Payment (tk.)</th>
                                                <th >Remarks</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            <?php $estimated_cost =0;
                                            $contract_amount =0;
                                            $payment_road =0;
                                            foreach($schemes as $key => $scheme):
                                                $estimated_cost += $scheme['estimated_cost'];
                                                $contract_amount += $scheme['contract_amount'];
                                                $payment_road += $scheme['payment_road'];
                                                ?>
                                                <tr class="custom-table-width">
                                                    <td><?= ++$key?></td>
                                                    <td><?= $scheme['package_name']?></td>
                                                    <td><p style="width:350px;"><?= $scheme['scheme_name']?></p></td>
                                                    <td><?= $scheme['estimated_cost']?></td>
                                                    <td><?= date('d-m-Y', $scheme['tender_date'])?></td>
                                                    <td><?= date('d-m-Y', $scheme['noa_date'])?></td>
                                                    <td><?= $scheme['contract_amount']?></td>
                                                    <td><?= $scheme['contractor_title']?></td>
                                                    <td><?= date('d-m-Y', $scheme['contract_date'])?></td>
                                                    <td><?= date('d-m-Y', $scheme['proposed_start_date'])?></td>
                                                    <td><?= date('d-m-Y', $scheme['completion_date'])?></td>
                                                    <td><?= $scheme['physical_progress']?></td>
                                                    <td><?= $scheme['payment_road']?></td>
                                                    <th><p contenteditable="true">&nbsp;</p></th>
                                                </tr>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td>Total</td>
                                                <td colspan="2"></td>
                                                <td><?= $estimated_cost ?></td>
                                                <td colspan="2"></td>
                                                <td><?= $contract_amount ?></td>
                                                <td colspan="5"></td>
                                                <td><?= $payment_road ?></td>
                                                <td></td>
                                            </tr>
                                            </tbody>


                                            <!--UPHCSDP-->

                                        <?php elseif($project['id'] == 17): ?>
                                            <thead>
                                            <tr>
                                                <th >Sl. No.</th>
                                                <th >Package No.</th>
                                                <th >Name of scheme</th>
                                                <th > Estimated Cost </th>
                                                <th >Name of Contractor</th>
                                                <th >Contract Amount</th>
                                                <th >Date of Contract</th>
                                                <th >Date of Completion</th>
                                                <th >Physical Progress (%)</th>
                                                <th >Payment (tk.)</th>
                                                <th >Remarks</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            <?php $estimated_cost =0;
                                            $contract_amount =0;
                                            $payment_road =0;
                                            foreach($schemes as $key => $scheme):
                                                $estimated_cost += $scheme['estimated_cost'];
                                                $contract_amount += $scheme['contract_amount'];
                                                $payment_road += $scheme['payment_road'];
                                                ?>
                                                <tr class="custom-table-width">
                                                    <td><?= ++$key?></td>
                                                    <td><?= $scheme['package_name']?></td>
                                                    <td><p style="width:350px;"><?= $scheme['scheme_name']?></p></td>
                                                    <td><?= $scheme['estimated_cost']?></td>
                                                    <td><?= $scheme['contractor_title']?></td>
                                                    <td><?= $scheme['contract_amount']?></td>
                                                    <td><?= date('d-m-Y', $scheme['contract_date'])?></td>
                                                    <td><?= date('d-m-Y', $scheme['completion_date'])?></td>
                                                    <td><?= $scheme['physical_progress']?></td>
                                                    <td><?= $scheme['payment_road']?></td>
                                                    <th><p contenteditable="true">&nbsp;</p></th>
                                                </tr>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td>Total</td>
                                                <td colspan="2"></td>
                                                <td><?= $estimated_cost ?></td>
                                                <td colspan="1"></td>
                                                <td><?= $contract_amount ?></td>
                                                <td colspan="3"></td>
                                                <td><?= $payment_road ?></td>
                                                <td></td>
                                            </tr>
                                            </tbody>

                                            <!--LBC-->

                                        <?php elseif($project['id'] == 6): ?>
                                            <thead>
                                            <tr>
                                                <th >Sl. No.</th>
                                                <th >Package No.</th>
                                                <th >Name of scheme</th>
                                                <th > Estimated Cost </th>
                                                <th >Name of Contractor</th>
                                                <th >Contract Amount</th>
                                                <th >Date of Contract</th>
                                                <th >Date of Completion</th>
                                                <th >Physical Progress (%)</th>
                                                <th >Payment (tk.)</th>
                                                <th >Remarks</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            <?php $estimated_cost =0;
                                            $contract_amount =0;
                                            $payment_road =0;
                                            foreach($schemes as $key => $scheme):
                                                $estimated_cost += $scheme['estimated_cost'];
                                                $contract_amount += $scheme['contract_amount'];
                                                $payment_road += $scheme['payment_road'];
                                                ?>
                                                <tr class="custom-table-width">
                                                    <td><?= ++$key?></td>
                                                    <td><?= $scheme['package_name']?></td>
                                                    <td><p style="width:350px;"><?= $scheme['scheme_name']?></p></td>
                                                    <td><?= $scheme['estimated_cost']?></td>
                                                    <td><?= $scheme['contractor_title']?></td>
                                                    <td><?= $scheme['contract_amount']?></td>
                                                    <td><?= date('d-m-Y', $scheme['contract_date'])?></td>
                                                    <td><?= date('d-m-Y', $scheme['completion_date'])?></td>
                                                    <td><?= $scheme['physical_progress']?></td>
                                                    <td><?= $scheme['payment_road']?></td>
                                                    <th><p contenteditable="true">&nbsp;</p></th>
                                                </tr>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td>Total</td>
                                                <td colspan="2"></td>
                                                <td><?= $estimated_cost ?></td>
                                                <td colspan="1"></td>
                                                <td><?= $contract_amount ?></td>
                                                <td colspan="3"></td>
                                                <td><?= $payment_road ?></td>
                                                <td></td>
                                            </tr>
                                            </tbody>

                                            <!--PSSWRDP-->

                                        <?php elseif($project['id'] == 16): ?>
                                            <thead>
                                            <tr>
                                                <th >Sl. No.</th>
                                                <th >Package No.</th>
                                                <th >Name of scheme</th>
                                                <th > Estimated Cost </th>
                                                <th >Name of Contractor</th>
                                                <th >Contract Amount</th>
                                                <th >Date of Contract</th>
                                                <th >Date of Completion</th>
                                                <th >Physical Progress (%)</th>
                                                <th >Payment (tk.)</th>
                                                <th >Remarks</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            <?php $estimated_cost =0;
                                            $contract_amount =0;
                                            $payment_road =0;
                                            foreach($schemes as $key => $scheme):
                                                $estimated_cost += $scheme['estimated_cost'];
                                                $contract_amount += $scheme['contract_amount'];
                                                $payment_road += $scheme['payment_road'];
                                                ?>
                                                <tr class="custom-table-width">
                                                    <td><?= ++$key?></td>
                                                    <td><?= $scheme['package_name']?></td>
                                                    <td><p style="width:350px;"><?= $scheme['scheme_name']?></p></td>
                                                    <td><?= $scheme['estimated_cost']?></td>
                                                    <td><?= $scheme['contractor_title']?></td>
                                                    <td><?= $scheme['contract_amount']?></td>
                                                    <td><?= date('d-m-Y', $scheme['contract_date'])?></td>
                                                    <td><?= date('d-m-Y', $scheme['completion_date'])?></td>
                                                    <td><?= $scheme['physical_progress']?></td>
                                                    <td><?= $scheme['payment_road']?></td>
                                                    <th><p contenteditable="true">&nbsp;</p></th>
                                                </tr>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td>Total</td>
                                                <td colspan="2"></td>
                                                <td><?= $estimated_cost ?></td>
                                                <td colspan="1"></td>
                                                <td><?= $contract_amount ?></td>
                                                <td colspan="3"></td>
                                                <td><?= $payment_road ?></td>
                                                <td></td>
                                            </tr>
                                            </tbody>

                                            <!--PTI-->

                                        <?php elseif($project['id'] == 18): ?>
                                            <thead>
                                            <tr>
                                                <th >Sl. No.</th>
                                                <th >Package No.</th>
                                                <th >Name of scheme</th>
                                                <th > Estimated Cost </th>
                                                <th >Name of Contractor</th>
                                                <th >Contract Amount</th>
                                                <th >Date of Contract</th>
                                                <th >Date of Completion</th>
                                                <th >Physical Progress (%)</th>
                                                <th >Payment (tk.)</th>
                                                <th >Remarks</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            <?php $estimated_cost =0;
                                            $contract_amount =0;
                                            $payment_road =0;
                                            foreach($schemes as $key => $scheme):
                                                $estimated_cost += $scheme['estimated_cost'];
                                                $contract_amount += $scheme['contract_amount'];
                                                $payment_road += $scheme['payment_road'];
                                                ?>
                                                <tr class="custom-table-width">
                                                    <td><?= ++$key?></td>
                                                    <td><?= $scheme['package_name']?></td>
                                                    <td><p style="width:350px;"><?= $scheme['scheme_name']?></p></td>
                                                    <td><?= $scheme['estimated_cost']?></td>
                                                    <td><?= $scheme['contractor_title']?></td>
                                                    <td><?= $scheme['contract_amount']?></td>
                                                    <td><?= date('d-m-Y', $scheme['contract_date'])?></td>
                                                    <td><?= date('d-m-Y', $scheme['completion_date'])?></td>
                                                    <td><?= $scheme['physical_progress']?></td>
                                                    <td><?= $scheme['payment_road']?></td>
                                                    <th><p contenteditable="true">&nbsp;</p></th>
                                                </tr>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td>Total</td>
                                                <td colspan="2"></td>
                                                <td><?= $estimated_cost ?></td>
                                                <td colspan="1"></td>
                                                <td><?= $contract_amount ?></td>
                                                <td colspan="3"></td>
                                                <td><?= $payment_road ?></td>
                                                <td></td>
                                            </tr>
                                            </tbody>

                                            <!--NATA-->

                                        <?php elseif($project['id'] == 22): ?>
                                            <thead>
                                            <tr>
                                                <th >Sl. No.</th>
                                                <th >Upzila</th>
                                                <th >Package No.</th>
                                                <th >Name of scheme</th>
                                                <th > Estimated Cost </th>
                                                <th >Name of Contractor</th>
                                                <th >Contract Amount</th>
                                                <th >Date of Contract</th>
                                                <th >Date of Completion</th>
                                                <th >Physical Progress (%)</th>
                                                <th >Payment (tk.)</th>
                                                <th >Remarks</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            <?php $estimated_cost =0;
                                            $contract_amount =0;
                                            $payment_road =0;
                                            foreach($schemes as $key => $scheme):
                                                $estimated_cost += $scheme['estimated_cost'];
                                                $contract_amount += $scheme['contract_amount'];
                                                $payment_road += $scheme['payment_road'];
                                                ?>
                                                <tr class="custom-table-width">
                                                    <td><?= ++$key?></td>
                                                    <td><?= $scheme['upazila_name']?></td>
                                                    <td><?= $scheme['package_name']?></td>
                                                    <td><p style="width:350px;"><?= $scheme['scheme_name']?></p></td>
                                                    <td><?= $scheme['estimated_cost']?></td>
                                                    <td><?= $scheme['contractor_title']?></td>
                                                    <td><?= $scheme['contract_amount']?></td>
                                                    <td><?= date('d-m-Y', $scheme['contract_date'])?></td>
                                                    <td><?= date('d-m-Y', $scheme['completion_date'])?></td>
                                                    <td><?= $scheme['physical_progress']?></td>
                                                    <td><?= $scheme['payment_road']?></td>
                                                    <th><p contenteditable="true">&nbsp;</p></th>
                                                </tr>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td>Total</td>
                                                <td colspan="3"></td>
                                                <td><?= $estimated_cost ?></td>
                                                <td colspan="1"></td>
                                                <td><?= $contract_amount ?></td>
                                                <td colspan="3"></td>
                                                <td><?= $payment_road ?></td>
                                                <td></td>
                                            </tr>
                                            </tbody>
                                            <!--Pmp-->

                                        <?php elseif($project['id'] == 13): ?>
                                            <thead>
                                            <tr>
                                                <th >Upazila name</th>
                                                <th >Package name</th>
                                                <th >Scheme name</th>
                                                <th > Estimated cost </th>
                                                <th >Contractor Name</th>
                                                <th >Contract amount</th>
                                                <th >Contract date</th>
                                                <th >Completion date</th>
                                                <th >Physical progress</th>
                                                <th >Payment road</th>
                                                <th >Remarks</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            <?php $estimated_cost =0;
                                            $contract_amount =0;
                                            $payment_road =0;
                                            foreach($schemes as $key => $scheme):
                                                $estimated_cost += $scheme['estimated_cost'];
                                                $contract_amount += $scheme['contract_amount'];
                                                $payment_road += $scheme['payment_road'];
                                                ?>
                                                <tr class="custom-table-width">
                                                    <td><?= ++$key?></td>
                                                    <td><?= $scheme['package_name']?></td>
                                                    <td><p style="width:350px;"><?= $scheme['scheme_name']?></p></td>
                                                    <td><?= $scheme['estimated_cost']?></td>
                                                    <td><?= $scheme['contractor_title']?></td>
                                                    <td><?= $scheme['contract_amount']?></td>
                                                    <td><?= date('d-m-Y', $scheme['contract_date'])?></td>
                                                    <td><?= date('d-m-Y', $scheme['completion_date'])?></td>
                                                    <td><?= $scheme['physical_progress']?></td>
                                                    <td><?= $scheme['payment_road']?></td>
                                                    <th><p contenteditable="true">&nbsp;</p></th>
                                                </tr>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td>Total</td>
                                                <td colspan="2"></td>
                                                <td><?= $estimated_cost ?></td>
                                                <td colspan="1"></td>
                                                <td><?= $contract_amount ?></td>
                                                <td colspan="3"></td>
                                                <td><?= $payment_road ?></td>
                                                <td></td>
                                            </tr>
                                            </tbody>
                                            <!--PEDP-3-->
                                        <?php elseif($project['id'] == 29): ?>
                                            <thead>
                                            <tr>
                                                <th >Sl. No.</th>
                                                <th >Package No.</th>
                                                <th >Name of scheme</th>
                                                <th >Approved Estimated Cost </th>
                                                <th >Tender Receiving Date</th>
                                                <th >NOA Date</th>
                                                <th >Contract Amount</th>
                                                <th >Name of Contractor</th>
                                                <th >Date of Contract</th>
                                                <th >Starting Date of Contract</th>
                                                <th >Date of Completion</th>
                                                <th >Physical Progress (%)</th>
                                                <th >Payment (tk.)</th>
                                                <th >Remarks</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            <?php $estimated_cost =0;
                                            $contract_amount =0;
                                            $payment_road =0;
                                            foreach($schemes as $key => $scheme):
                                                $estimated_cost += $scheme['estimated_cost'];
                                                $contract_amount += $scheme['contract_amount'];
                                                $payment_road += $scheme['payment_road'];
                                                ?>
                                                <tr class="custom-table-width">
                                                    <td><?= ++$key?></td>
                                                    <td><?= $scheme['package_name']?></td>
                                                    <td><p style="width:350px;"><?= $scheme['scheme_name']?></p></td>
                                                    <td><?= $scheme['estimated_cost']?></td>
                                                    <td><?= date('d-m-Y', $scheme['tender_date'])?></td>
                                                    <td><?= date('d-m-Y', $scheme['noa_date'])?></td>
                                                    <td><?= $scheme['contract_amount']?></td>
                                                    <td><?= $scheme['contractor_title']?></td>
                                                    <td><?= date('d-m-Y', $scheme['contract_date'])?></td>
                                                    <td><?= date('d-m-Y', $scheme['proposed_start_date'])?></td>
                                                    <td><?= date('d-m-Y', $scheme['completion_date'])?></td>
                                                    <td><?= $scheme['physical_progress']?></td>
                                                    <td><?= $scheme['payment_road']?></td>
                                                    <th><p contenteditable="true">&nbsp;</p></th>
                                                </tr>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td>Total</td>
                                                <td colspan="2"></td>
                                                <td><?= $estimated_cost ?></td>
                                                <td colspan="2"></td>
                                                <td><?= $contract_amount ?></td>
                                                <td colspan="5"></td>
                                                <td><?= $payment_road ?></td>
                                                <td></td>
                                            </tr>
                                            </tbody>
                                            <!--TULO-->
                                        <?php elseif($project['id'] == 26): ?>
                                            <thead>
                                            <tr>
                                                <th >Sl. No.</th>
                                                <th >Package No.</th>
                                                <th >Name of scheme</th>
                                                <th >Approved Estimated Cost </th>
                                                <th >Tender Receiving Date</th>
                                                <th >NOA Date</th>
                                                <th >Contract Amount</th>
                                                <th >Name of Contractor</th>
                                                <th >Date of Contract</th>
                                                <th >Starting Date of Contract</th>
                                                <th >Date of Completion</th>
                                                <th >Physical Progress (%)</th>
                                                <th >Payment (tk.)</th>
                                                <th >Remarks</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            <?php $estimated_cost =0;
                                            $contract_amount =0;
                                            $payment_road =0;
                                            foreach($schemes as $key => $scheme):
                                                $estimated_cost += $scheme['estimated_cost'];
                                                $contract_amount += $scheme['contract_amount'];
                                                $payment_road += $scheme['payment_road'];
                                                ?>
                                                <tr class="custom-table-width">
                                                    <td><?= ++$key?></td>
                                                    <td><?= $scheme['package_name']?></td>
                                                    <td><p style="width:350px;"><?= $scheme['scheme_name']?></p></td>
                                                    <td><?= $scheme['estimated_cost']?></td>
                                                    <td><?= date('d-m-Y', $scheme['tender_date'])?></td>
                                                    <td><?= date('d-m-Y', $scheme['noa_date'])?></td>
                                                    <td><?= $scheme['contract_amount']?></td>
                                                    <td><?= $scheme['contractor_title']?></td>
                                                    <td><?= date('d-m-Y', $scheme['contract_date'])?></td>
                                                    <td><?= date('d-m-Y', $scheme['proposed_start_date'])?></td>
                                                    <td><?= date('d-m-Y', $scheme['completion_date'])?></td>
                                                    <td><?= $scheme['physical_progress']?></td>
                                                    <td><?= $scheme['payment_road']?></td>
                                                    <th><p contenteditable="true">&nbsp;</p></th>
                                                </tr>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td>Total</td>
                                                <td colspan="2"></td>
                                                <td><?= $estimated_cost ?></td>
                                                <td colspan="2"></td>
                                                <td><?= $contract_amount ?></td>
                                                <td colspan="5"></td>
                                                <td><?= $payment_road ?></td>
                                                <td></td>
                                            </tr>
                                            </tbody>
                                            <!--Construction of   Muktijoddah  Memorials Project-->
                                        <?php elseif($project['id'] == 25): ?>
                                            <thead>
                                            <tr>
                                                <th >Sl. No.</th>
                                                <th >Package No.</th>
                                                <th >Name of scheme</th>
                                                <th >Approved Estimated Cost </th>
                                                <th >Tender Receiving Date</th>
                                                <th >NOA Date</th>
                                                <th >Contract Amount</th>
                                                <th >Name of Contractor</th>
                                                <th >Date of Contract</th>
                                                <th >Starting Date of Contract</th>
                                                <th >Date of Completion</th>
                                                <th >Physical Progress (%)</th>
                                                <th >Payment (tk.)</th>
                                                <th >Remarks</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            <?php $estimated_cost =0;
                                            $contract_amount =0;
                                            $payment_road =0;
                                            foreach($schemes as $key => $scheme):
                                                $estimated_cost += $scheme['estimated_cost'];
                                                $contract_amount += $scheme['contract_amount'];
                                                $payment_road += $scheme['payment_road'];
                                                ?>
                                                <tr class="custom-table-width">
                                                    <td><?= ++$key?></td>
                                                    <td><?= $scheme['package_name']?></td>
                                                    <td><p style="width:350px;"><?= $scheme['scheme_name']?></p></td>
                                                    <td><?= $scheme['estimated_cost']?></td>
                                                    <td><?= date('d-m-Y', $scheme['tender_date'])?></td>
                                                    <td><?= date('d-m-Y', $scheme['noa_date'])?></td>
                                                    <td><?= $scheme['contract_amount']?></td>
                                                    <td><?= $scheme['contractor_title']?></td>
                                                    <td><?= date('d-m-Y', $scheme['contract_date'])?></td>
                                                    <td><?= date('d-m-Y', $scheme['proposed_start_date'])?></td>
                                                    <td><?= date('d-m-Y', $scheme['completion_date'])?></td>
                                                    <td><?= $scheme['physical_progress']?></td>
                                                    <td><?= $scheme['payment_road']?></td>
                                                    <th><p contenteditable="true">&nbsp;</p></th>
                                                </tr>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td>Total</td>
                                                <td colspan="2"></td>
                                                <td><?= $estimated_cost ?></td>
                                                <td colspan="2"></td>
                                                <td><?= $contract_amount ?></td>
                                                <td colspan="5"></td>
                                                <td><?= $payment_road ?></td>
                                                <td></td>
                                            </tr>
                                            </tbody>

                                            <!--CRDP-->

                                        <?php elseif($project['id'] == 24): ?>
                                            <thead>
                                            <tr>
                                                <th >Sl. No.</th>
                                                <th >Package No.</th>
                                                <th >Name of scheme</th>
                                                <th > Estimated Cost </th>
                                                <th >Name of Contractor</th>
                                                <th >Contract Amount</th>
                                                <th >Date of Contract</th>
                                                <th >Date of Completion</th>
                                                <th >Physical Progress (%)</th>
                                                <th >Payment (tk.)</th>
                                                <th >Remarks</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            <?php $estimated_cost =0;
                                            $contract_amount =0;
                                            $payment_road =0;
                                            foreach($schemes as $key => $scheme):
                                                $estimated_cost += $scheme['estimated_cost'];
                                                $contract_amount += $scheme['contract_amount'];
                                                $payment_road += $scheme['payment_road'];
                                                ?>
                                                <tr class="custom-table-width">
                                                    <td><?= ++$key?></td>
                                                    <td><?= $scheme['package_name']?></td>
                                                    <td><p style="width:350px;"><?= $scheme['scheme_name']?></p></td>
                                                    <td><?= $scheme['estimated_cost']?></td>
                                                    <td><?= $scheme['contractor_title']?></td>
                                                    <td><?= $scheme['contract_amount']?></td>
                                                    <td><?= date('d-m-Y', $scheme['contract_date'])?></td>
                                                    <td><?= date('d-m-Y', $scheme['completion_date'])?></td>
                                                    <td><?= $scheme['physical_progress']?></td>
                                                    <td><?= $scheme['payment_road']?></td>
                                                    <th><p contenteditable="true">&nbsp;</p></th>
                                                </tr>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td>Total</td>
                                                <td colspan="2"></td>
                                                <td><?= $estimated_cost ?></td>
                                                <td colspan="1"></td>
                                                <td><?= $contract_amount ?></td>
                                                <td colspan="3"></td>
                                                <td><?= $payment_road ?></td>
                                                <td></td>
                                            </tr>
                                            </tbody>

                                            <!--BSA-->
                                        <?php elseif($project['id'] == 23): ?>
                                            <thead>
                                            <tr>
                                                <th >Sl. No.</th>
                                                <th >Package No.</th>
                                                <th >Name of scheme</th>
                                                <th >Approved Estimated Cost </th>
                                                <th >Tender Receiving Date</th>
                                                <th >NOA Date</th>
                                                <th >Contract Amount</th>
                                                <th >Name of Contractor</th>
                                                <th >Date of Contract</th>
                                                <th >Starting Date of Contract</th>
                                                <th >Date of Completion</th>
                                                <th >Physical Progress (%)</th>
                                                <th >Payment (tk.)</th>
                                                <th >Remarks</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            <?php $estimated_cost =0;
                                            $contract_amount =0;
                                            $payment_road =0;
                                            foreach($schemes as $key => $scheme):
                                                $estimated_cost += $scheme['estimated_cost'];
                                                $contract_amount += $scheme['contract_amount'];
                                                $payment_road += $scheme['payment_road'];
                                                ?>
                                                <tr class="custom-table-width">
                                                    <td><?= ++$key?></td>
                                                    <td><?= $scheme['package_name']?></td>
                                                    <td><p style="width:350px;"><?= $scheme['scheme_name']?></p></td>
                                                    <td><?= $scheme['estimated_cost']?></td>
                                                    <td><?= date('d-m-Y', $scheme['tender_date'])?></td>
                                                    <td><?= date('d-m-Y', $scheme['noa_date'])?></td>
                                                    <td><?= $scheme['contract_amount']?></td>
                                                    <td><?= $scheme['contractor_title']?></td>
                                                    <td><?= date('d-m-Y', $scheme['contract_date'])?></td>
                                                    <td><?= date('d-m-Y', $scheme['proposed_start_date'])?></td>
                                                    <td><?= date('d-m-Y', $scheme['completion_date'])?></td>
                                                    <td><?= $scheme['physical_progress']?></td>
                                                    <td><?= $scheme['payment_road']?></td>
                                                    <th><p contenteditable="true">&nbsp;</p></th>
                                                </tr>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td>Total</td>
                                                <td colspan="2"></td>
                                                <td><?= $estimated_cost ?></td>
                                                <td colspan="2"></td>
                                                <td><?= $contract_amount ?></td>
                                                <td colspan="5"></td>
                                                <td><?= $payment_road ?></td>
                                                <td></td>
                                            </tr>
                                            </tbody>
                                            <!--GOB Maintains-->
                                        <?php elseif($project['id'] == 15): ?>
                                            <thead>
                                            <tr>
                                                <th>Sl. No.</th>
                                                <th>Upazila</th>
                                                <th>Package No.</th>
                                                <th>Name of scheme</th>
                                                <th>Road (km)</th>
                                                <th>Structure (m)</th>
                                                <th>Estimated Cost (Road)</th>
                                                <th>Estimated Cost (Structure)</th>
                                                <th>Estimated Cost (Total)</th>
                                                <th>Tender receiving date</th>
                                                <th>Name of Contractor</th>
                                                <th>Date of Contract</th>
                                                <th>Contract Amount</th>
                                                <th>Physical Progress (%)</th>
                                                <th>Actual Date completion</th>
                                                <th>Payment (tk.)</th>
                                                <th>Remarks</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $cost_road = 0;
                                            $cost_structure = 0;
                                            $cost_total = 0;
                                            $contract_amount = 0;
                                            $payment_road = 0;
                                            foreach($schemes as $key => $scheme):
                                                $cost_road += $scheme['cost_road'];
                                                $cost_structure += $scheme['cost_structure'];
                                                $cost_total += $scheme['cost_total'];
                                                $contract_amount+= $scheme['contract_amount'];
                                                $payment_road+= $scheme['payment_road'];
                                                ?>

                                                <tr class="custom-table-width">
                                                    <td><?= ++$key?></td>
                                                    <td><?= $scheme['upazila_name']?></td>
                                                    <td><?= $scheme['package_name']?></td>
                                                    <td><p style="width:350px;"><?= $scheme['scheme_name']?></p></td>
                                                    <td><?= $scheme['road_length']?></td>
                                                    <td><?= $scheme['structure_length']?></td>
                                                    <td><?= $scheme['cost_road']?></td>
                                                    <td><?= $scheme['cost_structure']?></td>
                                                    <td><?= $scheme['cost_total']?></td>
                                                    <td><?= date('d-m-Y', $scheme['tender_date'])?></td>
                                                    <td><?= $scheme['contractor_title']?></td>
                                                    <td><?= date('d-m-Y', $scheme['contract_date'])?></td>
                                                    <td><?= $scheme['contract_amount']?></td>
                                                    <td><?= $scheme['physical_progress']?></td>
                                                    <td><?= date('d-m-Y', $scheme['actual_complete_date'])?></td>
                                                    <td><?= $scheme['payment_road']?></td>
                                                    <th> <p contenteditable="true">&nbsp;</p></th>
                                                </tr>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td>Total</td>
                                                <td colspan="5"></td>
                                                <td><?= $cost_road?></td>
                                                <td><?= $cost_structure?></td>
                                                <td><?= $cost_total?></td>
                                                <td colspan="3"></td>
                                                <td><?= $contract_amount?></td>
                                                <td colspan="2"></td>
                                                <td><?=$payment_road?></td>
                                                <td></td>
                                            </tr>
                                            </tbody>
                                            <!--safary-->
                                        <?php elseif($project['id'] == 30): ?>
                                            <thead>
                                            <tr>
                                                <th>Sl. No.</th>
                                                <th>Upazila</th>
                                                <th>Package No.</th>
                                                <th>Name of scheme</th>
                                                <th>Road (km)</th>
                                                <th>Structure (m)</th>
                                                <th>Estimated Cost (Road)</th>
                                                <th>Estimated Cost (Structure)</th>
                                                <th>Estimated Cost (Total)</th>
                                                <th>Tender receiving date</th>
                                                <th>Name of Contractor</th>
                                                <th>Date of Contract</th>
                                                <th>Contract Amount</th>
                                                <th>Physical Progress (%)</th>
                                                <th>Actual Date completion</th>
                                                <th>Payment (tk.)</th>
                                                <th>Remarks</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $cost_road = 0;
                                            $cost_structure = 0;
                                            $cost_total = 0;
                                            $contract_amount = 0;
                                            $payment_road = 0;
                                            foreach($schemes as $key => $scheme):
                                                $cost_road += $scheme['cost_road'];
                                                $cost_structure += $scheme['cost_structure'];
                                                $cost_total += $scheme['cost_total'];
                                                $contract_amount+= $scheme['contract_amount'];
                                                $payment_road+= $scheme['payment_road'];
                                                ?>

                                                <tr class="custom-table-width">
                                                    <td><?= ++$key?></td>
                                                    <td><?= $scheme['upazila_name']?></td>
                                                    <td><?= $scheme['package_name']?></td>
                                                    <td><p style="width:350px;"><?= $scheme['scheme_name']?></p></td>
                                                    <td><?= $scheme['road_length']?></td>
                                                    <td><?= $scheme['structure_length']?></td>
                                                    <td><?= $scheme['cost_road']?></td>
                                                    <td><?= $scheme['cost_structure']?></td>
                                                    <td><?= $scheme['cost_total']?></td>
                                                    <td><?= date('d-m-Y', $scheme['tender_date'])?></td>
                                                    <td><?= $scheme['contractor_title']?></td>
                                                    <td><?= date('d-m-Y', $scheme['contract_date'])?></td>
                                                    <td><?= $scheme['contract_amount']?></td>
                                                    <td><?= $scheme['physical_progress']?></td>
                                                    <td><?= date('d-m-Y', $scheme['actual_complete_date'])?></td>
                                                    <td><?= $scheme['payment_road']?></td>
                                                    <th> <p contenteditable="true">&nbsp;</p></th>
                                                </tr>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td>Total</td>
                                                <td colspan="5"></td>
                                                <td><?= $cost_road?></td>
                                                <td><?= $cost_structure?></td>
                                                <td><?= $cost_total?></td>
                                                <td colspan="3"></td>
                                                <td><?= $contract_amount?></td>
                                                <td colspan="2"></td>
                                                <td><?=$payment_road?></td>
                                                <td></td>
                                            </tr>
                                            </tbody>
                                        <?php else: ?>
                                            <h3 class="text-center">Data Not Found</h3>
                                        <?php endif; ?>

                                    </table>
                                </div>
                            </div>
                        </div>

                        <style>
                            .table-bordered th:nth-child(4) {
                                width: 500px;
                            }

                        </style>
                    </div>

                <?php else: ?>
                    <h4 class="text-center text-warning" style="margin-top: 1em"><?= __('No data found') ?></h4>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>




<script>
    function print_rpt()
    {

        URL = "<?php echo $this->request->webroot; ?>page/Print_a4_Eng.php?selLayer=PrintArea";
        day = new Date();
        id = day.getTime();
        eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=yes,scrollbars=yes ,location=0,statusbar=0 ,menubar=yes,resizable=1,width=880,height=600,left = 20,top = 50');");
    }
</script>