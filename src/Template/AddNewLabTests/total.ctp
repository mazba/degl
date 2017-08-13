<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Lab Letter Registers'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Lab Letter Register') ?> </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-7 col-md-offset-2 fix">
        <div class="form-body">
            <?= $this->Form->create(null, ['id' => 'wallet-report' ,'role' => 'form']) ?>
            <div class="col-md-5">
                <?php
                echo $this->Form->input('date_from',['label' => __('তারিখ হইতে'),'required'=>'required','class' =>'form-control hasdatepicker','placeholder'=>'তারিখ নির্বাচন করুন']);
                ?>
            </div>
            <div class="col-md-5">
                <?php
                echo $this->Form->input('date_to',['label' => __('তারিখ পর্যন্ত'),'required'=>'required','class' =>'form-control hasdatepicker','placeholder'=>'তারিখ নির্বাচন করুন']);
                ?>
            </div>
            <div class="col-md-2">
                <?= $this->Form->button(__('অনুসন্ধান'), ['class' => 'btn green']) ?>
            </div>
            <?= $this->Form->end(); ?>
        </div>
    </div>
</div>
<?php if(isset($results)): ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-sm-12">
                <button style="float: right" onclick="print_rpt()">Print</button>
            </div>
            <div id="result">
                <div class="col-sm-12 text-center" style="font-size: 16px;margin-bottom: 10px">
                    <span>Local Government Engineering Department</span><br>
                    <span>Office of the Executive Engineer</span><br>
                    <span>Gazipur</span><br>
                </div>
                <?php if(!empty($results)): ?>
                    <div class="col-sm-12">
                        <table class="table table-bordered">
                            <tr>
                                <th><?= __('Sl. No.') ?></th>
                                <th><?= __('Name of Test') ?></th>
                                <th><?= __('N0. of Test') ?></th>
                                <th><?= __('Rate of Fee/Test') ?></th>
                                <th><?= __('Total Amount') ?></th>
                            </tr>
                            <?php $i = 1;
                            $total = 0;
                            $test = 0;
                            foreach ($results as $result): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $result['group_name'].' / '.$result['lab_test_short_name']?></td>
                                    <td><?= $result['number_of_test'] ?></td>
                                    <td><?= $result['rate'] ?></td>
                                    <td><?= ($result['rate'] * $result['number_of_test']) ?></td>
                                </tr>
                                <?php $test += $result['number_of_test']; ?>
                                <?php $total += ($result['rate'] * $result['number_of_test']) ?>
                            <?php endforeach; ?>
                                <tr>
                                    <td colspan="2"></td>
                                    <td >Total: <?= $test ?> </td>
                                    <td></td>
                                    <td>Total: <?= $total ?></td>
                                </tr>
                        </table>
                    </div>
                <?php else: ?>
                    <h3 style="text-align: center"><?= __('কোন তথ্য পাওয়া যায় নাই') ?></h3>
                <?php endif; ?>
                <style>
                    .scheme_info {
                        float: left;
                    }

                    .date {
                        float: right
                    }

                    .balance {
                        width: 85%
                    }

                    .sign {
                        float: left;
                        width: 25%
                    }
                </style>
            </div>
        </div>
    </div>
    <script>
        function print_rpt() {
            URL = "<?php echo $this->request->webroot; ?>page/Print_a4_Eng.php?selLayer=result";
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
<?php endif; ?>

<style>
    .fix{
        overflow: hidden;
    }
</style>
