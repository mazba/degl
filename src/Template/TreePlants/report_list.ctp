<?php if(!empty($treePlants)){ ?>
    <div class="col-sm-12">
        <button class="btn btn-xs btn-warning icon-print2" style="float: right;margin-bottom: 10px" onclick="print_rpt()">&nbsp;<?= __('Print') ?></button>
    </div>
<div id="PrintArea" class="col-md-12" style="margin-bottom: 40px">

    <h4 class="text-center" style="margin-bottom: 45px"><?= __($treePlants[0]['financial_year_estimate']
            ['name'] . ' অর্থবছরে এলজিইডির আওতায় গাজীপুর জেলার বৃক্ষরোপণ সংক্রাস্ত তথ্যাদি'); ?></h4>

    <table class="table table-bordered text-center">
        <tr>
            <td colspan="5"><?= __($treePlants[0]['financial_year_estimate']
                    ['name'] . ' অর্থবছরে চারা রোপণের লক্ষমাত্রা ') ?></td>
            <td colspan="7"><?= __($treePlants[0]['financial_year_estimate']
                    ['name'] . ' অর্থবছরে চারা রোপণের অগ্রগতি ') ?></td>
            <td colspan="4"><?= __($treePlants[0]['financial_year_estimate']
                    ['name'] . ' অর্থবছরে পরিচর্যার পর জীবিত গাছের সংখ্যা ') ?></td>
        </tr>
        <tr>
            <td><?= __('বনজ (সংখ্যা)') ?></td>
            <td><?= __('ভেষজ (সংখ্যা)') ?></td>
            <td><?= __('ফলজ (সংখ্যা)') ?></td>
            <td><?= __('Total Plant') ?></td>
            <td><?= __('Target Total Cost') ?></td>
            <td><?= __('বনজ (সংখ্যা)') ?></td>
            <td><?= __('ভেষজ (সংখ্যা)') ?></td>
            <td><?= __('ফলজ (সংখ্যা)') ?></td>
            <td><?= __('Total Plant') ?></td>
            <td><?= __('Road Length (km)') ?></td>
            <td><?= __('Institution No.') ?></td>
            <td><?= __('Cost') ?></td>
            <td><?= __('বনজ (সংখ্যা)') ?></td>
            <td><?= __('ভেষজ (সংখ্যা)') ?></td>
            <td><?= __('ফলজ (সংখ্যা)') ?></td>
            <td><?= __('Total Alive Plant') ?></td>
        </tr>

        <?php foreach ($treePlants as $treePlant) { ?>
            <tr>
                <td><?= $this->Number->format($treePlant->target_bonoz) ?></td>
                <td><?= $this->Number->format($treePlant->target_vesoz) ?></td>
                <td><?= $this->Number->format($treePlant->target_foloz) ?></td>
                <td><?= $this->Number->format($treePlant->target_total_plant) ?></td>
                <td><?= $this->Number->format($treePlant->total_plant_cost) ?></td>
                <td><?= $this->Number->format($treePlant->progress_bonoz) ?></td>
                <td><?= $this->Number->format($treePlant->progress_vesoz) ?></td>
                <td><?= $this->Number->format($treePlant->progress_foloz) ?></td>
                <td><?= $this->Number->format($treePlant->progress_total_plant) ?></td>
                <td><?= $this->Number->format($treePlant->road_length) ?></td>
                <td><?= $this->Number->format($treePlant->number_of_institution) ?></td>
                <td><?= $this->Number->format($treePlant->total_cost) ?></td>
                <td><?= $this->Number->format($treePlant->alive_bonoz) ?></td>
                <td><?= $this->Number->format($treePlant->alive_vesoz) ?></td>
                <td><?= $this->Number->format($treePlant->alive_foloz) ?></td>
                <td><?= $this->Number->format($treePlant->alive_total_plant) ?></td>

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