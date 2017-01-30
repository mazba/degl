<!--
############################
this view is used in two method
    * report()-> ajax
    * purto_bill_by_scheme
############################
-->
<div id="PrintArea" style="margin-top: 10px; border: 1px solid #eea236; padding: 5px; margin-bottom: 10px">
<button class="btn btn-info pull-right" id="print_button" onclick="print_rpt()"><?= __('Print') ?></button>
<h1 class="text-center"><?= __('Purto Bill Registers') ?> </h1>
<h6 style="padding: 10px 0">
    <span class="pull-left"><?= __('Project Name') ?> : <?= isset($purtoBills[0]['project']['name_bn']) ?  $purtoBills[0]['project']['name_bn'] : ''; ?></span>
    <span class="pull-right"><?= __('Financial Year') ?> : <?= isset($purtoBills[0]['financial_year_estimate']['name']) ?  $purtoBills[0]['financial_year_estimate']['name'] : ''; ?></span>
</h6>
<table class="table table-bordered" style="border: 1px solid #eee; margin-bottom: 10px">
    <thead>
    <tr>
        <th><?= _('Bill No/Date') ?></th>
        <th><?= _('Scheme Name') ?></th>
        <th><?= _('Contractors') ?></th>
        <th><?= _('Bill Type') ?></th>
        <th><?= _('Gross Bill') ?></th>
        <th><?= _('Security') ?></th>
        <th><?= _('Vat') ?></th>
        <th><?= _('Income Taxes') ?></th>
        <th><?= _('Roller Charge') ?></th>
        <th><?= _('Lab Fee') ?></th>
        <th><?= _('Fine') ?></th>
        <th><?= _('Net Taka') ?></th>
        <th><?= _('Signature') ?></th>
    </tr>
    </thead>
    <tbody>
    <?php
        foreach($purtoBills as $purtoBill)
        {
            ?>
                <tr>
                    <td><?= $purtoBill['id'].'/'.$this->system->display_date($purtoBill['bill_date']) ?></td>
                    <td><?= $purtoBill['scheme']['name_bn']; ?></td>
                    <td><?= isset($purtoBill['contractor']) ? $purtoBill['contractor']['contractor_title'] : '' ; ?></td>
                    <td><?= $purtoBill['bill_type'] ?></td>
                    <td><?= $purtoBill['gross_bill'] ?></td>
                    <td><?= $purtoBill['security'] ?></td>
                    <td><?= $purtoBill['vat'] ?></td>
                    <td><?= $purtoBill['income_taxes'] ?></td>
                    <td><?= $purtoBill['roller_charge'] ?></td>
                    <td><?= $purtoBill['lab_fee'] ?></td>
                    <td><?= $purtoBill['fine'] ?></td>
                    <td><?= $purtoBill['net_taka'] ?></td>
                    <td></td>
                </tr>
            <?php
        }
    ?>
    </tbody>
</table>
</div>