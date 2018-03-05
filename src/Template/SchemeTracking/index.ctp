<?php
$month = [  '01' => 'January','02' => 'February','03' => 'March','04' => 'April','05' => 'May','06' => 'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December'];
//Date of Commencement Expired +++ প্রত্যাশিত শুরুর তারিখ
//Performance Guaranty Expired +++ performance security
//Date of Time Line Expired ++++ প্রত্যাশিত সমাপ্তির তারিখ
$type = [
    1 => 'Work not started within 30 days of Contract',
    2 => 'Performance Guaranty Expired',
    3 => 'Date of Time Line Expired',
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
                    <?= $this->Form->input('type', ['required'=>'required','options' => $type, 'empty' => __('Select'), 'class' => 'form-control condition-type']) ?>
                </div>
                <div class="col-sm-offset-2 col-sm-6" style="margin-top: 15px">
                    <?= $this->Form->input('project_id', ['options' => $projects, 'empty' => __('Select')]) ?>
                </div>
                <div class="col-sm-offset-2 col-sm-6" style="margin-top: 15px">
                    <?=  $this->Form->input('financial_year_estimate_id', ['options' => $fiscal,'empty'=>__('Select')]); ?>
                </div>
                <div class="col-sm-offset-2 col-sm-6" style="margin-top: 15px">
                    <?=  $this->Form->input('month_id', ['label' => 'মাস', 'options' => $month,'empty'=>__('Select')]); ?>
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

                        <?php if($check == 1):?>
                            <div class="col-md-12">
                                <h3 class="text-center"><?= $proposedStartDates[0]['projects_name'] ?></h3>
                                <p class="text-center"><?= __('Date of Commencement Expired Report') ?></p>
                                <p class="text-center"><?php echo date('F Y', strtotime('today')); ?></p>
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
                                        <!--                                    <th>--><?//= __('অগ্রগতি') ?><!--</th>-->
                                        <th><?= __('কাজ শুরুর তারিখ') ?></th>
                                        <th><?= __('কাজ শেষের তারিখ') ?></th>
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
                                                <td><?= date('d/m/Y', $proposedStartDate['contract_date']) ?></td>
                                                <td><?= date('d/m/Y', $proposedStartDate['expected_complete_date'])?></td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>

                        <?php if($check == 2): ?>
                            <div class="col-md-12">
                                <h3 class="text-center"><?= $proposedStartDates[0]['projects_name'] ?></h3>
                                <p class="text-center"><?= __('Performance Guaranty Expired Report') ?></p>
                                <p class="text-center"><?php echo date('F Y', strtotime('today')); ?></p>
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
                                        <th><?= __('অগ্রগতি') ?></th>
                                        <th><?= __('কাজ শুরুর তারিখ') ?></th>
                                        <th><?= __('কাজ শেষের তারিখ') ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $sn=0; foreach ($proposedStartDates as $key => $proposedStartDate):  ?>

                                            <tr>
                                                <td><?= $this->Number->format(++$sn); ?></td>
                                                <td><?= $proposedStartDate['upazilas_name'] ?></td>
                                                <td><?= $proposedStartDate['financial_year'] ?></td>
                                                <td><?= $proposedStartDate['scheme_name'] ?></td>
                                                <td><?= $proposedStartDate['package_name'] ?></td>
                                                <td><?= $proposedStartDate['contractor_name'] ?></td>
                                                <td><?= $proposedStartDate['contract_amount'] ?></td>
                                                <td><?= $proposedStartDate['scheme_progresses'] ?></td>
                                                <td><?= date('d/m/Y', $proposedStartDate['contract_date']) ?></td>
                                                <td><?= date('d/m/Y', $proposedStartDate['expected_complete_date'])?></td>
                                            </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>

                        <?php if($check == 3): ?>
                            <div class="col-md-12">
                                <h3 class="text-center"><?= $proposedStartDates[0]['projects_name'] ?></h3>
                                <p class="text-center"><?= __('Date of Time Line Expired Report') ?></p>
                                <p class="text-center"><?php echo date('F Y', strtotime('today')); ?></p>
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
                                        <th><?= __('অগ্রগতি') ?></th>
                                        <th><?= __('কাজ শুরুর তারিখ') ?></th>
                                        <th><?= __('কাজ শেষের তারিখ') ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $sn=0; foreach ($proposedStartDates as $key => $proposedStartDate):  ?>

                                        <tr>
                                            <td><?= $this->Number->format(++$sn); ?></td>
                                            <td><?= $proposedStartDate['upazilas_name'] ?></td>
                                            <td><?= $proposedStartDate['financial_year'] ?></td>
                                            <td><?= $proposedStartDate['scheme_name'] ?></td>
                                            <td><?= $proposedStartDate['package_name'] ?></td>
                                            <td><?= $proposedStartDate['contractor_name'] ?></td>
                                            <td><?= $proposedStartDate['contract_amount'] ?></td>
                                            <td><?= $proposedStartDate['scheme_progresses'] ?></td>
                                            <td><?= date('d/m/Y', $proposedStartDate['contract_date']) ?></td>
                                            <td><?= date('d/m/Y', $proposedStartDate['expected_complete_date'])?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
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

        $('.condition-type').on('change', function () {
            var current_status = $(this).find(':selected').val();
            if(current_status == 1){
                $('#month-id').closest('.form-group').hide();
            }else{
                $('#month-id').closest('.form-group').show();
            }
        });
    });
</script>

