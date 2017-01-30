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
            <td>Action</td>
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
                <input type="hidden" name="details[<?=$i?>][scheme_item_id]" value="<?=$scheme_detail['id']?>">
                <td><?php echo $scheme_detail['unit']; ?></td>
                <td><?php echo (isset($last_ra_bills_items[$scheme_detail['id']]) ? $scheme_detail['quantity_executed']-$last_ra_bills_items[$scheme_detail['id']] : $scheme_detail['quantity_executed']) ?></td>
                <td><?php echo $scheme_detail['quantity_executed']; ?></td>
                <td>                 <input type="hidden" name="details[<?=$i?>][serial_number]" value="<?=$i?>"><span class="label label-info"> Item <?php echo $i; ?> </span>
                <textarea name="details[<?=$i?>][short_description]" class="form-control" rows="3"><?php echo $scheme_detail['description']; ?></textarea></td>
                <td><?php echo $scheme_detail['rate']; ?></td>
                <td class="payable"><?php echo $scheme_detail['quantity_executed']*$scheme_detail['rate']; ?></td>
                <td id="<?=$scheme_detail['id']?>"> <button class="btn btn-danger" id="remove_item" data-item-id="<?=$scheme_detail['id']?>">X</button> </td>
            </tr>
            <?php
            $total += $scheme_detail['quantity_executed']*$scheme_detail['rate'];
        }
        ?>
    <tr>
        <td colspan="5"><?= __('Total Work done to Date') ?></td><td id="show_total"><?php //echo $total; ?></td>
        <td>&nbsp;</td>
    </tr>
    </tbody>
</table>

<div class="col-md-7">

</div>
<input type="hidden" id="ra_bill_no" name="ra_bill_no" value="<?php echo $ra_bill_no; ?>">
<input type="hidden" id="total_payable" name="" value="">
<!--<input type="hidden" id="latest_measurement_no" name="latest_measurement_no" value="--><?php //echo $last_measurement['measurement_no']; ?><!--">-->
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
            <input type="text" id="so_far_payable" class="form-control" name="total_payable" readonly>

<!--            <label class="form-control" id="so_far_payable"></label>-->
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
            <input type="text" id="bill_amount" class="form-control" name="this_bill_amount"  readonly required="required">
        </div>
    </div>
</div>
