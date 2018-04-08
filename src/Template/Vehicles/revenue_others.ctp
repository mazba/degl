<?php

$month = [1 => 'January',2 => 'February',3 => 'March',4 => 'April',5 => 'May',6 => 'June',7=>'July',8=>'August',9=>'September',10=>'October',11=>'November',12=>'December'];

?>

    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
            <li class="active"><?= __('Revenue And Others') ?></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-8">
            <?= $this->Form->create(null, ['class' => 'form-horizontal', 'role' => 'form']); ?>
            <?php echo $this->Form->input('financial_year_estimate_id', ['options' => $finalcialYears, 'empty' => 'Select', 'required' => 'required']); ?>
            <?php echo $this->Form->input('month', ['label' => 'মাস', 'options' => $month, 'empty' => 'Select', 'required' => 'required']); ?>
            <div class="text-center">
                <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
            </div>
            <?= $this->Form->end() ?>
        </div>
        <div class="col-md-4">
            <div class="pull-right">
                <a class="vehicle-list" target="_blank" href="<?= $this->Url->build(['controller' => 'AssignVehicles', 'action' => 'revenueList'])?>"><?= __('আয় ব্যয় সংরক্ষণ') ?></a>
            </div>
        </div>
    </div>

<?php if(isset($mechanical_status)): ?>
    <!-- Report -->
    <div class="col-sm-12">
        <button style="float: right;margin-top: 5px" onclick="print_rpt()">Print</button>
    </div>
    <div id="PrintArea">
        <div class="col-sm-12">
            <h4 class="text-center"><u>নির্বাহী প্রকৌশলীর দপ্তর এলজিইডি, গাজীপুর এর নির্মাণ যন্ত্রপাতির আয়-ব্যয় ও অন্যান্য তথ্য - অর্থ বৎসর : <?php
                    if(isset($finalcialYearData)){
                        echo $this->Common->EngToBanglaNum($finalcialYearData['name']);
                    }else{
                        echo '....';
                    }
                    ?> ইং
                    <?php
                    if(isset($income['month'])){
                        echo $this->Common->eng_to_bn_month_full($month[$income['month']]);echo ' মাসের';
                    }else{
                        echo '....';
                    }
                    ?>
                </u></h4>
            <h4><u>রাজস্ব আয় ও অন্যান্য তথ্য</u></h4>
        </div>
        <div class="panel-body">
            <div class="row">
                <div style="display: block" class="col-sm-12">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th rowspan="2" style="vertical-align: top" class="text-center"><?= 'ক্রমিক নং' ?></th>
                            <th colspan="3"  style="vertical-align: top" class="text-center"><?= 'মোট সচল রোলার এর সংখ্যা' ?></th>
                            <th colspan="2"  style="vertical-align: top;" class="third-width text-center"><?= 'মোট অচল রোলার এর সংখ্যা' ?></th>
                            <th rowspan="2"  style="vertical-align: top" class="text-center"><?= 'সচল যানবাহনের (জিপ, পিকআপ, ট্রাক,মোটরসাইকেল) সংখ্যা' ?></th>
                            <th rowspan="2"  style="vertical-align: top" class="text-center"><?= 'অচল যানবাহনের (জিপ, পিকআপ, ট্রাক,মোটরসাইকেল) সংখ্যা' ?></th>
                            <th rowspan="2"  style="vertical-align: top; width: 160px !important;" class="text-center"> পূর্তকাজের মোট ব্যয় (লক্ষ টাকায়) (ব্রীজ, কালভার্ট, সড়ক, হাট-বাজার)</th>
                            <th rowspan="2"  style="vertical-align: top" class="text-center"><?= 'নির্মাণ যন্ত্রপাতি থেকে আয় (লক্ষ টাকায়)' ?></th>
                            <th rowspan="2"  style="vertical-align: top" class="text-center"><?= 'মন্তব্য' ?></th>
                        </tr>
                        <tr>
                            <th style="vertical-align: top; width: 86px !important;" class="text-center">ভিটি রোলার</th>
                            <th style="vertical-align: top"  class="text-center">স্ট্যাটিক রোলার</th>
                            <th style="vertical-align: top; width: 80px !important;"  class="text-center">টায়ার রোলার</th>
                            <th style="vertical-align: top"  class="text-center">ভিটি রোলার</th>
                            <th style="vertical-align: top"  class="text-center">স্ট্যাটিক রোলার</th>
                        </tr>
                        </thead>
                        <tbody class="test_list">
                        <tr>
                            <td class="text-center"><?= '১' ?></td>
                            <td class="text-center"><?php echo '৩.৫ টন- '.$this->Common->EngToBanglaNum($mechanical_status['vt_roller_three_five']).'টি'.'</br>';
                                echo '৭ টন- '.$this->Common->EngToBanglaNum($mechanical_status['vt_roller_seven']).'টি'
                                ?></td>
                            <td class="text-center"><?= '৮-১০ টন- '.$this->Common->EngToBanglaNum($mechanical_status['static_roller_eight_ten']).'টি' ?></td>
                            <td class="text-center"><?= 'টায়ার রোলার- '.$this->Common->EngToBanglaNum($mechanical_status['tyre_roller']).'টি' ?></td>
                            <td class="text-center"><?= $this->Common->EngToBanglaNum($mechanical_status['vt_roller_damage']).'টি' ?></td>
                            <td class="text-center"><?= $this->Common->EngToBanglaNum($mechanical_status['static_roller_damage']).'টি' ?></td>
                            <td class="text-center"><?= 'জীপ- '.$this->Common->EngToBanglaNum($mechanical_status['active_zip']).'টি,'.
                                ' পিক-আপ- '.$this->Common->EngToBanglaNum($mechanical_status['active_pickup']).'টি,'.
                                ' সেলুনকার- '.$this->Common->EngToBanglaNum($mechanical_status['active_clunker']).'টি,'.
                                ' মোটরসাইকেল- '.$this->Common->EngToBanglaNum($mechanical_status['active_motorcycle']).'টি,'.
                                ' ট্রাক- '.$this->Common->EngToBanglaNum($mechanical_status['active_truck']).'টি';
                                ?></td>
                            <td class="text-center"><?= $this->Common->EngToBanglaNum($mechanical_status['deactivated_vehicle']).'টি' ?></td>
                            <td class="text-center"><?php ?><?= $income['income']?$this->Number->format($income['income']):0 ?></td>
                            <td class="text-center"><?php ?><?= $income['expense']?$this->Number->format($income['expense']):0 ?></td>
                            <td class="text-center"><?php ?></td>
                        </tr>
                        </tbody>
                    </table>
                    <br/><br/><br/><br/>

                    <table style="width:100%;  font-size: 15px; margin-bottom: -15px; margin-top: 15px ; margin-left: 15px"  align="center" >
                        <tr>
                            <td width="25%" align="center">মেকানিক্যাল ফোরম্যান<br/>
                                এলজিইডি, গাজীপুর    </td>
                            <td width="25%" align="center">
                                সহকারী প্রকৌশলী <br/>
                                এলজিইডি, গাজীপুর
                            </td>
                            <td width="25%" align="center">
                                সিনিয়র সহকারী প্রকৌশলী <br/>
                                এলজিইডি, গাজীপুর
                            </td>
                            <td width="25%" align="center">

                                নির্বাহী প্রকৌশলী <br/>
                                এলজিইডি, গাজীপুর
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <style>
            td:last-child {width: 80px !important; }
            th{
                font-weight: normal !important;
            }
            .third-width { width: 244px; !important;}

            body{
                font-family: 'SutonnyOMJ' !important;

            }
            .tablesorter {
                font-family: 'SutonnyOMJ' !important;;
            }

            table tr thead th {

                font-family: 'SutonnyOMJ' !important;;
            }

            table tr td {
                font-family: 'SutonnyOMJ' !important;;
            }
        </style>

    </div>

    <script>
        function print_rpt() {
            URL = "<?php echo $this->request->webroot; ?>page/Print_a4_Eng.php?selLayer=PrintArea";
            day = new Date();
            id = day.getTime();
            eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=yes,scrollbars=yes ,location=0,statusbar=0 ,menubar=yes,resizable=1,width=880,height=600,left = 20,top = 50');");
        }
    </script>
<?php endif; ?>

<style>
    .vehicle-list {
        font-weight: bold;
        background: mediumseagreen;
        padding: 10px 12px;
        color: #fff;
        border-radius: 3px;
    }
    .vehicle-list:hover{
        color: #fff !important;
    }
</style>
