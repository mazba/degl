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
<?php if (isset($labBills)) { ?>
    <div class="row">
        <div class="col-sm-12">
            <button class="btn btn-xs btn-warning icon-print2" style="float: right;margin-bottom: 10px" onclick="print_rpt()">&nbsp;Print</button>
        </div>
        <div id="PrintArea" class="col-sm-12" style="overflow: scroll">
            <table class="table table-bordered">
                <tr>
                    <th><?= __('SL No') ?></th>
                    <th><?= __('Scheme Name/ID No') ?></th>
                    <th><?= __('Date') ?></th>
                    <th><?= __('Total Amount') ?></th>
                </tr>
                <?php $i = 1;$total=0;
                foreach ($labBills as $labBill) { ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $labBill['schemes']['name_en'] ?></td>
                        <td><?= date('d-m-Y',$labBill['created_date']) ?></td>
                        <td><?= $labBill['total_amount'] ?></td>
                        <?php $total +=$labBill['total_amount'] ?>
                    </tr>
                <?php } ?>
                <tr style="border: 0px solid">

                    <td style="border: 0px solid" colspan="3" class="text-right">TOTAL</td>
                    <td><?= $total ?></td>
                </tr>
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
