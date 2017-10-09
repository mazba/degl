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
        <?php if(isset($schemes)): ?>
            <?php if((!empty($schemes))): ?>

                <div id="PrintArea" style="margin-top: 10px; padding: 5px; margin-bottom: 10px">
                    <button class="btn btn-info pull-right" id="print_button" onclick="print_rpt()"><?= __('Print') ?></button>
                    <h3 class="text-center"><?= $project['name_en'] ?><br>

                    </h3>
                    <div id="report_table">
                        <table width="100%" class="table table-bordered" style="border: 1px solid #eee; margin-bottom: 10px;">

                            <!--IRIDP-2-->
                            <?php if($project['id'] == 20 || $project['id'] == 3): ?>
                                <thead>
                                <tr>
                                    <th width="1%">Sl. No.</th>
                                    <th width="5%">Upazila</th>
                                    <th width="5%">Package No.</th>
                                    <th width="15%">Name of scheme</th>
                                    <th width="5%">Road (km)</th>
                                    <th width="5%">Structure (m)</th>
                                    <th width="5%">Estimated Cost (Road)</th>
                                    <th width="5%">Estimated Cost (Structure)</th>
                                    <th width="5%">Estimated Cost (Total)</th>
                                    <th width="5%">Tender receiving date</th>
                                    <th width="5%">Name of Contractor</th>
                                    <th width="5%">Date of Contract</th>
                                    <th width="5%">Contract Amount</th>
                                    <th width="5%">Physical Progress (%)</th>
                                    <th width="5%">Actual Date completion</th>
                                    <th width="5%">Payment (tk.)</th>
                                    <th width="5%">Remarks</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($schemes as $key => $scheme): ?>
                                    <tr class="custom-table-width">
                                        <td><?= ++$key?></td>
                                        <td><?= $scheme['upazila_name']?></td>
                                        <td><?= $scheme['package_name']?></td>
                                        <td><?= $scheme['scheme_name']?></td>
                                        <td><?= $scheme['road_length']?></td>
                                        <td><?= $scheme['structure_length']?></td>
                                        <td><?= $scheme['structure_length']?></td>
                                        <td><?= $scheme['cost_road']?></td>
                                        <td><?= $scheme['cost_structure']?></td>
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
                                </tbody>

                            <!--Landless mukti-->
                            <?php elseif($project['id'] == 8): ?>
                                <thead>
                                <tr>
                                    <th width="1%">Sl. No.</th>
                                    <th width="5%">Upazila</th>
                                    <th width="5%">Package No.</th>
                                    <th width="15%">Name of scheme</th>
                                    <th width="5%">Name of Contractor</th>
                                    <th width="5%">Approved Estimated Cost </th>
                                    <th width="5%">Contract Amount</th>
                                    <th width="5%">Date of Contract</th>
                                    <th width="5%">Date of completion</th>
                                    <th width="5%">Actual Date completion</th>
                                    <th width="5%">Physical Progress (%)</th>
                                    <th width="5%">Payment (tk.)</th>
                                    <th width="5%">Remarks</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($schemes as $key => $scheme): ?>
                                    <tr class="custom-table-width">
                                        <td><?= ++$key?></td>
                                        <td><?= $scheme['upazila_name']?></td>
                                        <td><?= $scheme['package_name']?></td>
                                        <td><?= $scheme['scheme_name']?></td>
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
                                </tbody>
                            <!--PEDP-3-->

                            <?php elseif($project['id'] == 5): ?>
                                <thead>
                                <tr>
                                    <th width="1%">Sl. No.</th>
                                    <th width="5%">Package No.</th>
                                    <th width="15%">Name of scheme</th>
                                    <th width="5%">Approved Estimated Cost </th>
                                    <th width="5%">Tender Receiving Date</th>
                                    <th width="5%">NOA Date</th>
                                    <th width="5%">Contract Amount</th>
                                    <th width="5%">Name of Contractor</th>
                                    <th width="5%">Date of Contract</th>
                                    <th width="5%">Starting Date of Contract</th>
                                    <th width="5%">Date of Completion</th>
                                    <th width="5%">Physical Progress (%)</th>
                                    <th width="5%">Payment (tk.)</th>
                                    <th width="5%">Remarks</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php foreach($schemes as $key => $scheme): ?>
                                    <tr class="custom-table-width">
                                        <td><?= ++$key?></td>
                                        <td><?= $scheme['package_name']?></td>
                                        <td><?= $scheme['scheme_name']?></td>
                                        <td><?= $scheme['estimated_cost']?></td>
                                        <td><?= date('d-m-Y', $scheme['tender_date'])?></td>
                                        <td><?= date('d-m-Y', $scheme['noa_date'])?></td>
                                        <td><?= $scheme['contract_amount']?></td>
                                        <td><?= $scheme['contractor_title']?></td>
                                        <td><?= $scheme['contract_amount']?></td>
                                        <td><?= date('d-m-Y', $scheme['contract_date'])?></td>
                                        <td><?= date('d-m-Y', $scheme['proposed_start_date'])?></td>
                                        <td><?= date('d-m-Y', $scheme['completion_date'])?></td>
                                        <td><?= $scheme['physical_progress']?></td>
                                        <td><?= $scheme['payment_road']?></td>
                                        <th><p contenteditable="true">&nbsp;</p></th>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>

                            <!--NATA-->

                            <?php elseif($project['id'] == 22): ?>
                                <thead>
                                <tr>
                                    <th width="1%">Sl. No.</th>
                                    <th width="5%">Upzila</th>
                                    <th width="5%">Package No.</th>
                                    <th width="15%">Name of scheme</th>
                                    <th width="5%"> Estimated Cost </th>
                                    <th width="5%">Name of Contractor</th>
                                    <th width="5%">Contract Amount</th>
                                    <th width="5%">Date of Contract</th>
                                    <th width="5%">Date of Completion</th>
                                    <th width="5%">Physical Progress (%)</th>
                                    <th width="5%">Payment (tk.)</th>
                                    <th width="5%">Remarks</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php foreach($schemes as $key => $scheme): ?>
                                    <tr class="custom-table-width">
                                        <td><?= ++$key?></td>
                                        <td><?= $scheme['upazila_name']?></td>
                                        <td><?= $scheme['package_name']?></td>
                                        <td><?= $scheme['scheme_name']?></td>
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
                                </tbody>
                                <?php else: ?>
                                <h3 class="text-center">Data Not Found</h3>
                            <?php endif; ?>

                        </table>
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

<script>
    function print_rpt()
    {

        URL = "<?php echo $this->request->webroot; ?>page/Print_a4_Eng.php?selLayer=PrintArea";
        day = new Date();
        id = day.getTime();
        eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=yes,scrollbars=yes ,location=0,statusbar=0 ,menubar=yes,resizable=1,width=880,height=600,left = 20,top = 50');");
    }
</script>