<?php

?>

<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= $this->Html->link(__('স্কীম ওভারভিউ রিপোর্ট'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <h6 class="panel-title">
            <i class="icon-paragraph-right2"></i><?= __('স্কীম ওভারভিউ') ?>
        </h6>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="row">
                <?= $this->Form->create(null, ['id' => 'scheme-overview']) ?>
                <div class="col-sm-offset-2 col-sm-6" style="margin-top: 15px">
                    <?= $this->Form->input('project_id', ['options' => $projects, 'empty' => __('Select'), 'class'=> ' select-search custom']) ?>
                </div>

                <div class="col-sm-offset-2 col-sm-6" style="margin-top: 15px">
                    <?= $this->Form->input('scheme_id', ['options' => $schemes, 'empty' => __('Select')]) ?>
                </div>
                <div class="col-sm-offset-2 col-sm-6" style="margin-top: 15px">
                    <?=  $this->Form->input('financial_year_estimate_id', ['options' => $fiscal,'empty'=>__('Select')]); ?>
                </div>
                <div class="col-sm-offset-2 col-sm-6" style="margin-top: 15px">
                    <?= $this->Form->input('upazila_id', ['options' => $upazilas, 'empty' => __('Select')]); ?>
                </div>

                <div class="col-sm-offset-2 col-sm-6" style="margin-top: 15px">
                    <?= $this->Form->input('contractor_id', ['options' => $contractors, 'empty' => __('Select'), 'class'=> ' select-search custom']) ?>
                </div>
                <!--    end field setup-->
                <div class="col-sm-offset-5 col-sm-3" style="margin-top: 15px">
                    <?= $this->Form->submit(__('Generate Report'), ['class' => 'btn btn-warning']) ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>

        <div class="row">
            <?php if(isset($schemeOverviews)): ?>
                <?php if((!empty($schemeOverviews))): ?>
                    <div class="col-md-12">
                        <button style="margin-right: 5px; margin-bottom: 1em" class="btn btn-info pull-right" id="print_button" onclick="print_rpt()"><?= __('Print') ?></button>
                    </div>
                    <div id="PrintArea" style="margin-top: 10px; padding: 5px; margin-bottom: 10px">
                        <!--<div class="col-md-12">
                                <h3 class="text-center"><?/*= $proposedStartDates[0]['projects_name'] */?></h3>
                                <p class="text-center"><?/*= __('Date of Commencement Expired Report') */?></p>
                                <p class="text-center"><?php /*echo date('F Y', strtotime('today')); */?></p>
                            </div>-->
                        <div class="col-sm-12">
                            <table class="table table-bordered" style="border: 1px solid #eee; margin-bottom: 10px;">
                                <thead>
                                <tr>
                                    <th><?= __('SN') ?></th>
                                    <th><?= __('উপজেলা') ?></th>
                                    <th><?= __('অর্থবছর') ?></th>
                                    <th><?= __('প্রকল্পের নাম') ?></th>
                                    <th><?= __('স্কীমের নাম') ?></th>
                                    <th><?= __('প্যাকেজের নাম') ?></th>
                                    <th><?= __('ঠিকাদার') ?></th>
                                    <th><?= __('চুক্তিমূল্য') ?></th>
                                    <th><?= __('অগ্রগতি') ?></th>
                                    <th><?= __('চুক্তির শুরুর তারিখ') ?></th>
                                    <th><?= __('চুক্তির শেষের তারিখ') ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($schemeOverviews as $key => $schemeOverview):  ?>
                                    <tr>
                                        <td><?= $this->Number->format(++$key); ?></td>
                                        <td><?= $schemeOverview['upazilas_name'] ?></td>
                                        <td><?= $schemeOverview['financial_year'] ?></td>
                                        <td><?= $schemeOverview['projects_name'] ?></td>
                                        <td><?= $schemeOverview['scheme_name'] ?></td>
                                        <td><?= $schemeOverview['package_name'] ?></td>
                                        <td><?= $schemeOverview['contractor_name'] ?></td>
                                        <td><?= $this->Number->format($schemeOverview['contract_amount']) ?></td>
                                        <td><?= $schemeOverview['scheme_progresses'] ?></td>
                                        <td><?= date('d/m/Y', $schemeOverview['contract_date']) ?></td>
                                        <td><?= date('d/m/Y', $schemeOverview['expected_complete_date'])?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php else: ?>
                    <h3 class="text-center" style="margin-top: 1em"><?= __('কোন তথ্য পাওয়া যায় নাই') ?></h3>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<style>
    div#s2id_contractor-id {
        width: 452px !important;
    }
    div#s2id_project-id {
        width: 452px !important;
    }
    div#s2id_scheme-id {
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

    $(document).ready(function () {
        var display_date_format = "dd-M-yy";
        $(".hasdatepicker").datepicker({
            dateFormat: display_date_format,
            changeMonth: true,
            changeYear: true,
            yearRange: "-50:+10"
        });
    });
</script>

