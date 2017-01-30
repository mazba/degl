<?php if (!empty($projects)) { ?>
<div class="row">
    <div class="col-sm-12">
        <button class="btn btn-xs btn-warning icon-print2" style="float: right;margin-bottom: 10px"
                onclick="print_rpt()">&nbsp;<?= __('Print') ?>
        </button>
    </div>
    <div id="PrintArea" class="col-sm-12" style="margin: 40px 0;overflow: scroll">
        <h4 class="text-center"><?= $projects[0]['financial_year'] ?> ইং অর্থ বৎসরের নির্বাহী প্রকৌশলী, এলজিইডি, গাজীপুর
            জেলার বাস্তাবায়ধীন বিভিন্ন কর্মকান্ডের সার সংক্ষেপ ।</h4>
        <span class="text-left">জেলাঃ গাজীপুর ।</span> <span
            style="float: right">মাসের নামঃ <?= $projects[0]['expire_month'] ?></span>
        <table class="table table-bordered text-center" style="margin-top: 10px">
            <tr>
                <td rowspan="3">ক্রমিক নং</td>
                <td rowspan="3">প্রকল্পের নাম</td>
                <td rowspan="3">চলতি অর্থ বৎসরের সম্ভাব্য বরাদ্দ (লক্ষ টাকা)</td>
                <td rowspan="3">স্কীমের ধরণ</td>
                <td colspan="4">চলতি অর্থ বৎসরের স্কীমের সংখ্যা (টি)</td>
                <td colspan="6">ভৌত পরিমান</td>
                <td rowspan="3">চলমান স্বীমের মোট চুব্তি মূল্য (লক্ষ টাকা)</td>
                <td rowspan="3">পরিশোধিত বিলের পরিমান (লক্ষ টাকা)</td>
                <td rowspan="3">চলমান স্কীমের গড় অগ্রগতি (%)</td>
                <td rowspan="3">মন্তব্য</td>
            </tr>
            <tr>
                <td rowspan="2">Carried over স্কীমের সংখ্যা (টি)</td>
                <td rowspan="2">নতুন স্কীমের সংখ্যা (টি)</td>
                <td rowspan="2">মোট স্কীমের সংখ্যা (টি)</td>
                <td rowspan="2">সমাপ্ত স্কীমের সংখ্যা (টি)</td>
                <td colspan="3">রাস্তার দৈর্ঘ</td>
                <td colspan="3">ব্রীজ/কালভার্ট দৈর্ঘ</td>
            </tr>
            <tr>
                <td>Carried over (কিঃমিঃ)</td>
                <td>নতুন (কিঃমিঃ)</td>
                <td>মোট (কিঃমিঃ)</td>
                <td>Carried over (মিঃ)</td>
                <td>নতুন (মিঃ)</td>
                <td>মোট (মিঃ)</td>
            </tr>
            <?php $i = 1;
            foreach ($projects as $project) { ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= $project['name_bn'] ?></td>
                    <td>&nbsp;</td>
                    <td><?= $project['scheme_type'] ?></td>
                    <td><?php if (isset($project['carried_scheme'])) {
                            echo $project['carried_scheme'];
                        } ?></td>
                    <td><?php if (isset($project['new_scheme'])) {
                            echo $project['new_scheme'];
                        } ?></td>
                    <td><?php if (!isset($project['carried_scheme'])) {
                            $project['carried_scheme'] = 0;
                        }
                        if (!isset($project['new_scheme'])) {
                            $project['new_scheme'] = 0;
                        }
                        echo $project['new_scheme'] + $project['carried_scheme'] ?></td>
                    <td><?= $project['total_complete_scheme'] ?></td>
                    <td><?php if (isset($project['carried_road_length'])) {
                            echo $project['carried_road_length'];
                        } ?></td>
                    <td><?php if (isset($project['road_length'])) {
                            echo $project['road_length'];
                        } ?></td>
                    <td><?php if (empty($project['carried_road_length'])) {
                            $project['carried_road_length'] = 0;
                        }
                        if (empty($project['road_length'])) {
                            $project['road_length'] = 0;
                        }
                        echo $project['carried_road_length'] + $project['road_length'] ?></td>
                    <td><?php if (isset($project['carried_bridge_length'])) {
                            echo $project['carried_bridge_length'];
                        } ?></td>
                    <td><?php if (isset($project['bridge_length'])) {
                            echo $project['bridge_length'];
                        } ?></td>
                    <td><?php if (empty($project['carried_bridge_length'])) {
                            $project['carried_bridge_length'] = 0;
                        }
                        if (empty($project['bridge_length'])) {
                            $project['bridge_length'] = 0;
                        }
                        echo $project['carried_bridge_length'] + $project['bridge_length'] ?></td>

                    <td><?php if (empty($project['contract_amount'])) {
                            $project['contract_amount'] = 0;
                        }
                        if (!isset($project['carried_contract_amount'])) {
                            $project['carried_contract_amount'] = 0;
                        }
                        echo $project['carried_contract_amount'] + $project['contract_amount']; ?></td>
                    <td><?= $project['total_paid_amount'] ?></td>
                    <td><?= $project['avg_scheme_progress'] ?></td>
                    <td>&nbsp;</td>
                </tr>
            <?php } ?>
            <tr>
                <td>&nbsp;</td>
                <td>সর্বমোট=</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><?= $carried=array_sum(array_column($projects,'carried_scheme')); ?></td>
                <td><?= $new=array_sum(array_column($projects,'new_scheme')); ?></td>
                <td><?= $carried+$new; ?></td>
                <td><?= $new=array_sum(array_column($projects,'total_complete_scheme')); ?></td>
                <td><?= $carried_road=$new=array_sum(array_column($projects,'carried_road_length')); ?></td>
                <td><?= $new_road=array_sum(array_column($projects,'road_length')); ?></td>
                <td><?= $new_road+$carried_road; ?></td>
                <td><?= $carried_bridge=array_sum(array_column($projects,'carried_bridge_length')); ?></td>
                <td><?= $new_bridge=array_sum(array_column($projects,'bridge_length')); ?></td>
                <td><?= $new_bridge+$carried_bridge?></td>
                <td><?= array_sum(array_column($projects,'contract_amount'))+ array_sum(array_column($projects,'carried_contract_amount')); ?></td>
                <td><?= array_sum(array_column($projects,'total_paid_amount')) ?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>

        </table>

        <table class="table sign text-center" style="margin-top: 80px">
            <tr>
                <td>উচ্চমান সহকারী <br> এলজিইডি, গাজীপুর</td>
                <td>হিসাব রক্ষক <br> এলজিইডি, গাজীপুর</td>
                <td>উপ-সহকারী প্রকৌশলী <br> এলজিইডি, গাজীপুর</td>
                <td>সহকারী প্রকৌশলী <br> এলজিইডি, গাজীপুর</td>
                <td>সিনিয়র সহকারী প্রকৌশলী <br> এলজিইডি, গাজীপুর</td>
                <td>নির্বাহী প্রকৌশলী <br> এলজিইডি, গাজীপুর</td>
            </tr>

        </table>
        <style>
            .table.sign td {
                border: 0px solid !important;
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
    <?php } ?>
</div>


