<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= $this->Html->link(__('Schemes Progress Reports'), ['action' => 'index']) ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('Scheme Progress Reports'), ['action' => 'index']) ?></li>
    </ul>
</div>

<div class="row">
    <?= $this->Form->create(null, ['role' => 'form']) ?>
    <div class="col-sm-5">
        <?= $this->Form->input('form_date', ['type' => 'text', 'class' => 'form-control hasdatepicker']) ?>
    </div>
    <div class="col-sm-5">
        <?= $this->Form->input('to_date', ['type' => 'text', 'class' => 'form-control hasdatepicker']) ?>
    </div>
    <div class="col-sm-2">
        <button type="submit" class="btn btn-info"><?= __('Find') ?></button>
    </div>
    <?= $this->Form->end(); ?>
</div>
<div style="clear: both;margin: 40px 0px"></div>
<?php if (isset($schemes)) { ?>
    <div class="row">
        <div class="col-sm-12">
            <button class="btn btn-xs btn-warning icon-print2" style="float: right;margin-bottom: 10px" onclick="print_rpt()">&nbsp;Print</button>
        </div>
        <div id="PrintArea" class="col-sm-12" style="overflow: scroll">
            <table class="table table-bordered">
                <tr>
                    <th><?= __('ক্রমিক নং') ?></th>
                    <th><?= __('নির্বাচনী এলাকা') ?></th>
                    <th><?= __('উপজেলার নাম') ?></th>
                    <th><?= __('প্যাকেজ নং') ?></th>
                    <th><?= __('স্কীমের নাম/আইডিনং') ?></th>
                    <th><?= __('সড়কের দৈর্ঘ্য (কিঃমিঃ)') ?></th>
                    <th><?= __('ব্রীজ/কালভার্টের দৈর্ঘ্য (মিঃ)') ?></th>
                    <th><?= __('বরাদ্দ (লক্ষ টাকা)') ?></th>
                    <th><?= __('বরাদ্দের তারিখ') ?></th>
                    <th><?= __('প্রাক্কলিত মূল্য (লক্ষ টাকা)') ?></th>
                    <th><?= __('অনুমদোনের তারিখ') ?></th>
                    <th><?= __('ঠিকাদারের নাম') ?></th>
                    <th><?= __('চুক্তি মূল্য (লক্ষ টাকা)') ?></th>
                    <th><?= __('কাজ শুরুর তারিখ') ?></th>
                    <th><?= __('কাজ সমাপ্তির তারিখ') ?></th>
                    <th><?= __('অগ্রগতি (%)') ?></th>
                    <th><?= __('ব্যয় (লক্ষ টাকা)') ?></th>
                    <th><?= __('বিভাগীয় মালামাল') ?></th>
                    <th><?= __('মন্তব্য') ?></th>
                </tr>
                <?php $i = 1;
                foreach ($schemes as $scheme) { ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td></td>
                        <td><?= $scheme['upazilas']['name_en'] ?></td>
                        <td></td>
                        <td><?= $scheme['name_bn'] ?></td>
                        <td><?= $scheme['length_km'] ?></td>
                        <td><?= $scheme['length_meter'] ?></td>
                        <td><?= $scheme['allotment_bill'] ?></td>
                        <td><?= date('d-m-Y',$scheme['allotment_date']) ?></td>
                        <td><?= $scheme['eve_approval_bill'] ?></td>
                        <td><?= date('d-m-Y',$scheme['eve_approval_date']) ?></td>
                        <td><?= $scheme['contractors']['contractor_title'] ?></td>
                        <td><?= $scheme['contract_amount'] ?></td>
                        <td><?= date('d-m-Y',$scheme['actual_start_date']) ?></td>
                        <td><?php if($scheme['actual_complete_date']){ echo date('d-m-Y',$scheme['actual_complete_date']);} ?></td>
                        <td><?php if($scheme['progress_value']){ echo $scheme['progress_value']."%";}  ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>

<?php } ?>

<script>
    function print_rpt() {
        URL = "<?php echo $this->request->webroot; ?>page/Print_a4_Eng.php?selLayer=PrintArea";
        day = new Date();
        id = day.getTime();
        eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=yes,scrollbars=yes ,location=0,statusbar=0 ,menubar=yes,resizable=1,width=880,height=600,left = 20,top = 50');");
    }
</script>
