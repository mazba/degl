<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('অগ্রগতি প্রতিবেদন') ?></li>
    </ul>
</div>

<div class="row">
    <div class="col-md-12">
        <button style="margin-right: 5px; margin-bottom: 1em" class="btn btn-info pull-right" id="print_button" onclick="print_rpt()"><?= __('Print') ?></button>
    </div>
    <div id="PrintArea" style="margin-top: 10px; padding: 5px; margin-bottom: 10px">
        <div class="col-md-12">
            <h3 class="text-center"><?= __('গাজীপুর জেলার প্রকল্প ভিত্তিক চলমান কাজের সংক্ষিপ্ত অগ্রগতি প্রতিবেদন') ?></h3>
        </div>
        <div class="col-sm-12">
            <table class="table table-bordered" style="border: 1px solid #eee; margin-bottom: 10px;">
                <thead>
                <tr>
                    <th rowspan="2"><?= __('ক্রমিক নং') ?></th>
                    <th rowspan="2"><?= __('প্রকল্পের নাম') ?></th>
                    <th colspan="4" style="text-align: center"><?= __('২০১৫-১৬ অর্থ বছর পর্যন্ত') ?></th>
                    <th colspan="6" style="text-align: center"><?= __('অর্থ বছর ২০১৬-২০১৭') ?></th>
                    <th rowspan="2"><?= __('ক্রম পুঞ্জিত অগ্রগতি') ?></th>
                    <th rowspan="2"><?= __('মোট সমাপ্তকৃত স্কীম সংখ্যা') ?></th>
                    <th rowspan="2"><?= __('মন্তব্য') ?></th>
                </tr>
                <tr>
                    <th><?= __('গৃহীত মোট স্কীম সংখ্যা') ?></th>
                    <th><?= __('গৃহীত স্কীমের মোট চুক্তিমূল্য') ?></th>
                    <th><?= __('ব্যায়িত মোট অর্থ') ?></th>
                    <th><?= __('অসমাপ্ত স্কীম সংখ্যা') ?></th>
                    <th><?= __('গৃহীত মোট স্কীম সংখ্যা') ?></th>
                    <th><?= __('গৃহীত স্কীমের মোট চুক্তিমূল্য') ?></th>
                    <th><?= __('মোট স্কীম সংখ্যা') ?></th>
                    <th><?= __('মোট চুক্তি মূল্য') ?></th>
                    <th><?= __('ব্যয়িত অর্থ') ?></th>
                    <th><?= __('গড় অগ্রগতি') ?></th>
                </tr>
                <tr>
                    <th><?= __('১') ?></th>
                    <th><?= __('২') ?></th>
                    <th><?= __('৩') ?></th>
                    <th><?= __('৪') ?></th>
                    <th><?= __('৫') ?></th>
                    <th><?= __('৬') ?></th>
                    <th><?= __('৭') ?></th>
                    <th><?= __('৮') ?></th>
                    <th><?= __('৯') ?></th>
                    <th><?= __('১০') ?></th>
                    <th><?= __('১১') ?></th>
                    <th><?= __('১২') ?></th>
                    <th><?= __('১৩') ?></th>
                    <th><?= __('১৪') ?></th>
                    <th><?= __('১৫') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $sl=0;
                foreach($projects as $project)
                {
                    ++$sl;
                    $variable3 = isset($results[17]['project'][$project['project_id']]['total_scheme'])?$results[17]['project'][$project['project_id']]['total_scheme']:'0';
                    $variable4 = isset($results[17]['project'][$project['project_id']]['project_value'])?$results[17]['project'][$project['project_id']]['project_value']:'0';
                    $variable5 = isset($results[17]['project'][$project['project_id']]['project_cost'])?$results[17]['project'][$project['project_id']]['project_cost']:'0';
                    $variable6 = isset($results[17]['project'][$project['project_id']]['active_scheme'])?$results[17]['project'][$project['project_id']]['active_scheme']:'0';
                    $deactive1 = isset($results[17]['project'][$project['project_id']]['de_active_scheme'])?$results[17]['project'][$project['project_id']]['de_active_scheme']:'0';
                    $variable7 = isset($results[18]['project'][$project['project_id']]['total_scheme'])?$results[18]['project'][$project['project_id']]['total_scheme']:'0';
                    $variable8 = isset($results[18]['project'][$project['project_id']]['project_value'])?$results[18]['project'][$project['project_id']]['project_value']:'0';
                    $variable9 = ($variable6+$variable7);
                    $variable10 = (($variable4-$variable5)+$variable8);
                    $variable11 = isset($results[18]['project'][$project['project_id']]['project_value'])?$results[18]['project'][$project['project_id']]['project_cost']:'0';;
                    $variable12 = 0;
                    $variable13 = $variable5+$variable11 !=0?(($variable5+$variable11)/($variable4+$variable8))*100:0;
                    $deactive2 = isset($results[18]['project'][$project['project_id']]['de_active_scheme'])?$results[18]['project'][$project['project_id']]['de_active_scheme']:'0';
                    $variable14 = $deactive1+$deactive2;
                    $variable15 = '<p contenteditable="true">এখানে লিখুন</p>';
                    ?>
                    <tr>
                        <td><?php echo $sl?></td>
                        <td><?php echo $project['project_name'] ?></td>
                        <td>
                            <?php
                            echo $variable3;
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $variable4;
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $variable5;
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $variable6;
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $variable7;
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $variable8;
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $variable9;
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $variable10;
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $variable11;
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $variable12;
                            ?>
                        </td>
                        <td>
                            <?php
                            echo intval($variable13).'%';
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $variable14;
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $variable15;
                            ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<style>
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
        font-family: 'SutonnyOMJ' !important;
        text-align: left !important;;
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