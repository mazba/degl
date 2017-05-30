<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= $this->Html->link(__('Contractor Schemes'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <h6 class="panel-title">
            <i class="icon-paragraph-right2"></i><?= __('Scheme Assign') ?>
        </h6>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="row">
                <?= $this->Form->create(null, ['id' => 'contractor-report']) ?>
                <div class="col-sm-offset-2 col-sm-6" style="margin-top: 15px">
                    <?= $this->Form->input('contractor_id', ['required'=>'required','options' => $contractors, 'empty' => __('Select'), 'class'=> ' select-search custom']) ?>
                </div>
                <div class="col-sm-offset-2 col-sm-6" style="margin-top: 15px">
                    <?=  $this->Form->input('financial_year_estimate_id', ['options' => $financialYearEstimates,'empty'=>__('Select')]); ?>
                </div>

                <div class="col-sm-offset-2 col-sm-6" style="margin-top: 15px">
                    <?= $this->Form->input('upazila_id', ['options' => $upazilas, 'empty' => __('Select')]);
                    ?>
                </div>
                <!--    end field setup-->
                <div class="col-sm-offset-5 col-sm-3" style="margin-top: 15px">
                    <?= $this->Form->submit(__('Generate Report'), ['class' => 'btn btn-warning']) ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>

        <div class="row">
            <?php if (!empty($schemes)): ?>

                <div id="PrintArea" style="margin-top: 10px; padding: 5px; margin-bottom: 10px">
                    <button class="btn btn-info pull-right" id="print_button" onclick="print_rpt()"><?= __('Print') ?></button>
                    <h1 class="text-center"><?= $schemes[0]['contractors']['contractor_title'] ?> </h1>
                    <div id="report_table">
                        <table class="table table-bordered" style="border: 1px solid #eee; margin-bottom: 10px;">
                            <thead>
                            <tr>
                                <th rowspan="2"><?= __('SL') ?></th>
                                <th rowspan="2"><?= __('Scheme Name') ?></th>
                                <th rowspan="2"><?= __('Package Name') ?></th>
                                <th rowspan="2"><?= __('Contract Amount') ?></th>
                                <th rowspan="2"><?= __('Contract Date') ?></th>
                                <th rowspan="2"><?= __('Completion Date') ?></th>
                                <th rowspan="2"><?= __('Progress') ?></th>
                                <th rowspan="2"><?= __('Road Length') ?></th>
                                <th rowspan="2"><?= __('Structure Length') ?></th>
                                <th rowspan="2"><?= __('Building Quantity') ?></th>
                                <th colspan="3" class="text-center"><?= __('Payment') ?></th>
                            </tr>
                            <tr>
                                <th><?= __('Road') ?></th>
                                <th><?= __('Structure') ?></th>
                                <th><?= __('Building') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $total_amount = 0;
                            $total_progress = 0;
                            $total_road_length = 0;
                            $total_structure_length = 0;
                            $total_building = 0;
                            $total_road_payment = 0;
                            $total_structure_payment = 0;
                            $count=1;
                            foreach ($schemes as $scheme) {
                                $total_amount += $scheme['schemes']['contract_amount'];
                                $total_progress += $scheme['scheme_progresses']['progress_value'];
                                $total_road_length += $scheme['schemes']['road_length'];
                                $total_structure_length += $scheme['schemes']['structure_length'];
                                $total_building += $scheme['schemes']['building_quantity'];
                                $total_road_payment += $scheme['schemes']['payment_road'];
                                $total_structure_payment += $scheme['schemes']['payment_structure'];
                                ?>
                                <tr>
                                    <td><?= $count ?></td>
                                    <td><?= $scheme['schemes']['name_bn'] ?></td>
                                    <td><?= $scheme['packages']['name_bn'] ?></td>
                                    <td><?= $scheme['schemes']['contract_amount'] ?></td>
                                    <td><?= date('d-m-Y', $scheme['schemes']['contract_date']) ?></td>
                                    <td><?= date('d-m-Y', $scheme['schemes']['completion_date']) ?></td>
                                    <td><?= $scheme['scheme_progresses']['progress_value'] ?></td>
                                    <td><?= $scheme['schemes']['road_length'] ?></td>
                                    <td><?= $scheme['schemes']['structure_length'] ?></td>
                                    <td><?= $scheme['schemes']['building_quantity'] ?></td>
                                    <td><?= $scheme['schemes']['payment_road'] ?></td>
                                    <td><?= $scheme['schemes']['payment_structure'] ?></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <?php
                                $count++;
                            }
                            ?>
                            <tr>
                                <td></td>
                                <td><?= __('Total') ?></td>

                                <td>&nbsp;</td>
                                <td><?= $total_amount ?></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td></td>
                                <td><?= $total_road_length ?></td>
                                <td><?= $total_structure_length ?></td>
                                <td><?= $total_building ?></td>
                                <td><?= $total_road_payment ?></td>
                                <td><?= $total_structure_payment ?></td>
                                <td>&nbsp;</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            <?php else: ?>
                <h4 class="text-center text-warning"><?= __('No data found') ?></h4>
            <?php endif; ?>
        </div>
    </div>

    <style>
        div#s2id_contractor-id {
            width: 452px !important;
        }
        div#select2-drop {
            width: 451px !important;
        }
    </style>

    <script>
        function print_rpt(){
            URL="<?php echo $this->request->webroot; ?>page/Print_a4_Eng.php?selLayer=PrintArea";
            day = new Date();
            id = day.getTime();
            eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=yes,scrollbars=yes ,location=0,statusbar=0 ,menubar=yes,resizable=1,width=880,height=600,left = 20,top = 50');");
        }
    </script>

