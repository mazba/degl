<?php if (!empty($inspections[0]['team_name'])) { ?>
    <div class="col-sm-12">
        <button class="btn btn-xs btn-warning icon-print2" style="float: right;margin-bottom: 10px"
                onclick="print_rpt()">&nbsp;<?= __('Print') ?>
        </button>
    </div>
    <div id="PrintArea" class="col-md-12" style="margin-bottom: 40px">

        <h4 class="text-center"
            style="margin-bottom: 45px"><?= __($inspections[0]['financial_year'] . ' অর্থবছরে গাজীপুর জেলার পরিদর্শন সংক্রন্ত তথ্য '); ?></h4>

        <table class="table table-bordered text-center">
            <tr>
                <td rowspan="2"><?= __('ক্রমিক নং') ?></td>
                <td rowspan="2"><?= __('মন্ত্রণালয়ে পরিদর্শন টীম/সদর দপ্তর পরিদর্শন টীম/আঞ্চলিক তত্ত্বাবধায়ক প্রকৌশলী (পৃথকভাবে)') ?></td>
                <td rowspan="2"><?= __('পরিদর্শনকৃত স্কীমের সংখ্যা') ?></td>
                <td rowspan="2"><?= __('ত্রুটিপূর্ণ স্কীমের সংখ্যা') ?></td>
                <td rowspan="2"><?= __('ত্রুটি সংশোধন করা হয়েছে এমন স্কীম সংখ্যা') ?></td>
                <td colspan="2"><?= __('যে সকল স্কীমের ত্রুটি অদ্যাবধি সংশোধন করা হয়নি') ?></td>
                <td rowspan="2"><?= __('গৃহীত ব্যবস্থা') ?></td>
            </tr>
            <tr >
                <td><?= __('স্কীমের সংখ্যা') ?></td>
                <td><?= __('ত্রুটির ধরণ') ?></td>
            </tr>


            <?php $i=1; foreach ($inspections as $inspection) { ?>
                <tr>
                    <td><?= $this->Number->format($i++) ?></td>
                    <td><?= $inspection['team_name'] ?></td>
                    <td><?= $inspection['total_inspection'] ?></td>
                    <td><?= $inspection['total_inspection']-$inspection['total_faulty'] ?></td>
                    <td><?= $inspection['total_correction'] ?></td>
                    <td><?= $inspection['total_inspection'] -$inspection['total_correction'] ?></td>
                    <td></td>
                    <td><?= $inspection['remarks'] ?></td>



                </tr>
            <?php } ?>


        </table>


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