<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Hire Charge'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Hire Charge') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Hire Charge'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1) {
            ?>
            <li><?= $this->Html->link(__('New Hire Charge'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <li class="active"><?=
            $this->Html->link(__('Details Hire Charge'), ['action' => 'view', $hireCharge->id
            ]) ?>
        </li>
    </ul>
</div>
<div class="panel panel-default" id="PrintArea">
    <button class="btn btn-right-icon btn-info" id="print_button" onclick="print_rpt()" type="button" style="float: right; margin: 4px"><i class="icon-print"></i> <?= __('Print') ?></button>
    <h1 style="text-align: center;margin-bottom: 40px;margin-top: 10px; text-decoration: underline"><?= __('Quantity Hire Charge of Equipment') ?></h1>
    <ul style="list-style: none">
        <li><b><?= __('Name of Contractor : ') ?> </b><?= isset($hireCharge->contractor->contractor_title) ? $hireCharge->contractor->contractor_title : '' ?></li>
        <li><b><?= __('Name of Work : ') ?> </b><?= $hireCharge->scheme->name_en ?></li>
        <li><b><?= __('Financial Year : ') ?> </b><?= $hireCharge->financial_year_estimate->name ?></li>
    </ul>
    <table class="table table-bordered" style="margin:10px 0; border: 1px solid #eee">
        <thead>
             <tr style="background: #f5f5f5">
                 <th><?= __('Item Code'); ?></th>
                 <th><?= __('Item of Work'); ?></th>
                 <th><?= __('Unit'); ?></th>
                 <th><?= __('Total Quantity of Work Done'); ?></th>
                 <th><?= __('Rate of Charge per unit quantities(Tk.)'); ?></th>
                 <th><?= __('Total Amount(Tk.)'); ?></th>
             </tr>
             <tr style="background: #fffff7">
                 <th><?= __(1); ?></th>
                 <th><?= __(2); ?></th>
                 <th><?= __(3); ?></th>
                 <th><?= __(4); ?></th>
                 <th><?= __(5); ?></th>
                 <th><?= __(6); ?></th>
             </tr>
        </thead>
        <tbody>
        <?php
            foreach($hireCharge->hire_charge_details as $item)
            {
               ?>
                <tr>
                    <td><?= $item['item_code'] ?></td>
                    <td><?= $item['description'] ?></td>
                    <td style="text-align: justify;"><?= $item['description'] ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td><?= $item['rate'] ?></td>
                    <td><?= $item['item_total'] ?></td>
                </tr>
                <?php
            }
        ?>
        </tbody>
        <tfoot>
            <tr>
                 <td colspan="1"></td>
                 <td colspan="4" style="text-align: right; font-weight: bold">Total Amount= </td>
                 <td colspan="1"><?= $hireCharge->total_amount; ?></td>
            </tr>
        </tfoot>
    </table>
    <b><span style="margin-left:100px; margin-right: 500px">Taka in word: (</span><span> ....)</span></b>

    <table class="table" style="margin-top: 100px;margin-left: 35px">
        <tr>
            <td>Mchanical Foreman<br><?= $hireCharge->office->name_en ?></td>
            <td>Assistant Engineer<br><?= $hireCharge->office->name_en ?></td>
            <td>Sr. Assistant Engineer<br><?= $hireCharge->office->name_en ?></td>
            <td>Executive Engineer<br><?= $hireCharge->office->name_en ?></td>
        </tr>
    </table>

</div>
<style>
    @media print {
       #print_button{
           display: none;
       }
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