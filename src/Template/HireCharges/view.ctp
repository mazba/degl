<?php
use Cake\Core\Configure;
use Cake\Routing\Router;
?>
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
            foreach($hire_charge_details as $item)
            {
               ?>
                <tr>
                    <td><?= $item['item_code'] ?></td>
                    <td><?= $item['description'] ?></td>
                    <td style="text-align: justify;"><?= $item['unit'] ?></td>
                    <td><?= $item['quantity_done'] ?></td>
                    <td><?= $item['item_total']/$item['quantity_done'] ?></td>
                    <td><?= $item['item_total'] ?></td>
                </tr>
                <?php
            }
        ?>
        </tbody>
        <tfoot>
            <tr>
                 <td colspan="1"></td>
                 <td colspan="4" style="text-align: right; font-weight: bold">So Far Payable </td>
                 <td colspan="1"><?= $hireCharge->total_amount; ?></td>
            </tr>

            <tr>
                 <td colspan="1"></td>
                 <td colspan="4" style="text-align: right; font-weight: bold">Fees paidd upto previous bill </td>
                 <td colspan="1"><?= $hireCharge->total_amount - $hireCharge->net_payable ; ?></td>
            </tr><tr>
                 <td colspan="1"></td>
                 <td colspan="4" style="text-align: right; font-weight: bold">This bill Amount </td>
                 <td colspan="1"><?= $hireCharge->net_payable; ?></td>
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


<div class="row">

    <div class="col-sm-6 col-sm-offset-3 ">
        <form class="form-horizontal" role="role" method="post" action="<?php echo Router::url('/',true); ?>HireCharges/view/<?php echo $id; ?>" enctype="multipart/form-data">

            <div class="form-group input select">
                <label for="user" class="col-sm-3 control-label text-right"><?= __('User') ?></label>
                <div class="col-sm-9 container_subject">
                    <select id="user" class="form-control multi-select" multiple="multiple" name="user[]" required>
                        <?php
                        $dept = "";
                        foreach ($departments as $department) { ?>
                        <?php if ($department['name_bn'] != $dept) { ?>
                        <optgroup label="<?= $department['name_bn'] ?>">
                            <?php $dept = $department['name_bn'];
                            } ?>
                            <?php if (isset($department['users']['name_bn'])) { ?>
                                <option
                                    value="<?= $department['users']['id'] ?>"><?= $department['users']['name_bn'] . " (" . $department['designations']['name_bn'] . ")" ?></option>
                            <?php }
                            } ?>
                    </select>
                </div>
            </div>
            <div style="margin-top: 15px"></div>
            <?= $this->Form->input('subject') ?>
            <div style="margin-top: 15px"></div>
            <?= $this->Form->input('message', ['type' => 'textarea']) ?>
            <div class="col-sm-12 form-actions text-center">
                <input type="submit" value="Send" class="btn btn-primary">
            </div>
            <?= $this->Form->end() ?>

    </div>
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

<script type="text/javascript">
    $(document).ready(function () {
        $(".multi-selects").select2();

    });
</script>