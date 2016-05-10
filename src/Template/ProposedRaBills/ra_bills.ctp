<?php
use Cake\Core\Configure;
?>
<div class="form-group input col-md-4 pull-right" id="measurement_book_wrp">
    <label class="col-sm-4 control-label text-right"><?= __('RA Bills No') ?></label>
    <div class="col-sm-6">
        <label class="form-control"><?php echo $ra_bill_no; ?></label>
    </div>
</div>
<table class="table table-bordered show-grid">
    <thead>
        <tr style="background: #eea236; color: #fff; font-weight: bold;text-align: center;">
            <td><?= __('Unit') ?></td>
            <td style="width: 150px;"><?= __('Quantity Excess or Supplied Sin Last R-A Bill') ?></td>
            <td style="width: 150px;"><?= __('Quantity Executed or Supplied up to date per MB') ?></td>
            <td><?= __('Items') ?></td>
            <td><?= __('Rate in Taka') ?></td>
            <td><?= __('Payable') ?></td>
        </tr>
    </thead>
    <tbody>
        <?php
        $total = 0;
        $i =0;
        foreach($scheme_details as $scheme_detail)
        {
            $i++;
            ?>
            <tr>
                <td><?php echo $scheme_detail['item_unit']; ?></td>
                <td><?php echo (isset($last_ra_bills_items[$scheme_detail['id']]) ? $scheme_detail['quantity_executed']-$last_ra_bills_items[$scheme_detail['id']] : '') ?></td>
                <td><?php echo $scheme_detail['quantity_executed']; ?></td>
                <td><span class="label label-info"> Item <?php echo $i; ?> </span> <?php echo ($scheme_detail['details'] ? substr($scheme_detail['details'], 0, 80).'..' : ''); ?></td>
                <td><?php echo $scheme_detail['rate']; ?></td>
                <td><?php echo $scheme_detail['quantity_executed']*$scheme_detail['rate']; ?></td>
            </tr>
            <?php
            $total += $scheme_detail['quantity_executed']*$scheme_detail['rate'];
        }
        ?>
    <tr><td colspan="5"><?= __('Total Work done to Date') ?></td><td><?php echo $total; ?></td></tr>
    </tbody>
</table>

<div class="col-md-7">

</div>
<input type="hidden" id="ra_bill_no" name="ra_bill_no" value="<?php echo $ra_bill_no; ?>">
<input type="hidden" id="total_payable" name="total_payable" value="<?php echo $total; ?>">
<input type="hidden" id="latest_measurement_no" name="latest_measurement_no" value="<?php echo $last_measurement['measurement_no']; ?>">
<div class="col-md-5">
    <div class="form-group input" id="above_or_less_wrp">
        <label class="col-sm-4 control-label text-right"><?= __('Above or Less') ?></label>
        <div class="col-sm-5 pull-right">
            <select required="required" name="above_or_less" id="above_or_less" class="form-control" type="text">
                <option value=""><?= __('Select') ?></option>
                <option value="ABOVE"><?= __('Above') ?></option>
                <option value="LESS"><?= __('Less') ?></option>
            </select>
        </div>
    </div>
    <div class="form-group input" id="percentage_wrp" style="display: none;">
        <label class="col-sm-4 control-label text-right"><?= __('Percentage') ?></label>
        <div class="col-sm-5 pull-right">
            <input type="text" id="percentage" class="form-control" name="percentage" required="required">
        </div>
    </div>
    <div class="form-group input" id="percentage_vale_wrp" style="display: none;">
        <label class="col-sm-4 control-label text-right"><?= __('Percentage Value') ?></label>
        <div class="col-sm-5 pull-right">
            <input type="text" id="percentage_vale" class="form-control" name="" readonly>
        </div>
    </div>
    <div class="form-group input" id="so_far_payable_wrp" style="display: none;">
        <label class="col-sm-4 control-label text-right"><?= __('So Far Payable') ?></label>
        <div class="col-sm-5 pull-right">
            <label class="form-control" id="so_far_payable"></label>
        </div>
    </div>
    <div class="form-group input" id="up_to_date_approved_wrp" style="display: none;">
        <label class="col-sm-4 control-label text-right"><?= __('Upto date Approved') ?></label>
        <div class="col-sm-5 pull-right">
            <label class="form-control" id="up_to_date_approved"><?php echo $up_to_date_approved; ?></label>
        </div>
    </div>
    <div class="form-group input" id="bill_amount_wrp" style="display: none;">
        <label class="col-sm-4 control-label text-right"><?= __('Bill Amount') ?></label>
        <div class="col-sm-5 pull-right">
            <input type="text" id="bill_amount" class="form-control" name="bill_amount" value="" readonly required="required">
        </div>
    </div>
</div>
<div class="col-sm-12 form-actions text-right">
    <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
</div>