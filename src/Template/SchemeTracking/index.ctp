<?php
//pr($proposedStartDates);die;
$type = [
    1 => 'প্রস্তাবিত কাজ শুরুর তারিখ',
    2 => 'পারফরমেন্স সিকিউরিটি মেয়াদ',
    3 => 'কাজ শেষের তারিখ',
]
?>

<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= $this->Html->link(__('স্কীম ট্র্যাকিং রিপোর্ট'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <h6 class="panel-title">
            <i class="icon-paragraph-right2"></i><?= __('স্কীম ট্র্যাকিং') ?>
        </h6>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="row">
                <?= $this->Form->create(null, ['id' => 'contractor-report']) ?>
                <div class="col-sm-offset-2 col-sm-6" style="margin-top: 15px">
                    <?= $this->Form->input('type', ['required'=>'required','options' => $type, 'empty' => __('Select')]) ?>
                </div>
                <div class="col-sm-offset-2 col-sm-6" style="margin-top: 15px">
                    <?= $this->Form->input('project_id', ['required'=>'required','options' => $projects, 'empty' => __('Select')]) ?>
                </div>
                <div class="col-sm-offset-2 col-sm-6" style="margin-top: 15px">
                    <?=  $this->Form->input('financial_year_estimate_id', ['options' => $fiscal,'empty'=>__('Select')]); ?>
                </div>

                <div class="col-sm-offset-2 col-sm-6" style="margin-top: 15px">
                    <?= $this->Form->input('upazila_id', ['options' => $upazilas, 'empty' => __('Select')]); ?>
                </div>
                <!--    end field setup-->
                <div class="col-sm-offset-5 col-sm-3" style="margin-top: 15px">
                    <?= $this->Form->submit(__('Generate Report'), ['class' => 'btn btn-warning']) ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>

        <div class="row">
            <?php if(isset($proposedStartDates)): ?>
                <?php if((!empty($proposedStartDates))): ?>
                    <div class="col-md-12">
                        <button style="margin-right: 5px; margin-bottom: 1em" class="btn btn-info pull-right" id="print_button" onclick="print_rpt()"><?= __('Print') ?></button>
                    </div>
                    <div id="PrintArea" style="margin-top: 10px; padding: 5px; margin-bottom: 10px">
                        <div class="col-md-12">
                            <h3 class="text-center">স্কীমের অগ্রগতি প্রতিবেদন</h3>
                        </div>
                        <div class="col-sm-12">
                            <table class="table table-bordered" style="border: 1px solid #eee; margin-bottom: 10px;">
                                <thead>
                                <tr>
                                    <th><?= __('id') ?></th>
                                    <th><?= __('উপজেলা') ?></th>
                                    <th><?= __('অর্থবছর') ?></th>
                                    <th><?= __('স্কীমের নাম') ?></th>
                                    <th><?= __('প্যাকেজের নাম') ?></th>
                                    <th><?= __('ঠিকাদার') ?></th>
                                    <th><?= __('চুক্তিমূল্য') ?></th>
<!--                                    <th>--><?//= __('চুক্তিমূল্য') ?><!--</th>-->
                                </tr>
                                </thead>
                                <tbody>
                                <?php $sn=0; foreach ($proposedStartDates as $key => $proposedStartDate):  ?>
                                    <?php if(($proposedStartDate['scheme_progresses'] == 0.00) || ($proposedStartDate['scheme_progresses'] == '')): ?>
                                        <tr>
                                            <td><?= $this->Number->format(++$sn); ?></td>
                                            <td><?= $proposedStartDate['upazilas_name'] ?></td>
                                            <td><?= $proposedStartDate['financial_year'] ?></td>
                                            <td><?= $proposedStartDate['scheme_name'] ?></td>
                                            <td><?= $proposedStartDate['package_name'] ?></td>
                                            <td><?= $proposedStartDate['contractor_name'] ?></td>
                                            <td><?= $proposedStartDate['contract_amount'] ?></td>
<!--                                            <td>--><?//= $proposedStartDate['scheme_progresses'] ?><!--</td>-->
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
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

