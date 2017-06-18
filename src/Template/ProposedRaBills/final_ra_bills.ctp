<?php
use Cake\Core\Configure;
//pr($measurements);die;

?>
<div class="form-group input col-md-12 pull-right" id="measurement_book_wrp" style="padding-right: 1.5em; text-align: right">
    <p><?= __('RA Bills No: ') ?><?= $ra_bill_no?><span>&nbsp;<?= $bil_type?$bil_type:'' ?></span></p>
</div>
<table class="table table-bordered show-grid">
    <thead>
    <tr style="background: #eea236; color: #fff; font-weight: bold;text-align: center;">
        <td><?= 'Items' ?></td>
        <td><?= __('Quantity as per Contract') ?></td>
        <td><?= __('Previous R/A Bill Quantity') ?></td>
        <td><?= __('Total Bill Quantity (Quantity Executed or Supplied since last Certificate)') ?></td>
        <td><?= __('This Bill Quantity (Quantity Executed or Supplied upto date as per MB)') ?></td>
        <td><?= 'Unit' ?></td>
        <td><?= __('Description of Works(item)') ?></td>
        <td><?= 'Rate' ?></td>
        <td><?= __('Amount as per contract (Tk)') ?></td>
        <td><?= __('Previous R/A Bill Amount (Tk)') ?></td>
        <td><?= __('Total Bill/Upto date Bill/Amount (Tk)') ?></td>
        <td><?= __('This Bill (Since Last Certificate Amount (Tk.))') ?></td>
    </tr>
    </thead>
    <tbody>
    <?php $i =0; foreach($measurements as $key => $measurement_data):  ?>
        <input type="hidden" name="details[<?=$i?>][scheme_item_id]" value="<?=$key?>">
        <input type="hidden" name="details[<?=$i?>][serial_number]" value="<?=$i?>">
        <input type="hidden" name="details[<?=$i?>][short_description]" value="<?= $measurement_data['description']?>">
        <?php
        $item_count=count($measurement_data['item']);
        $current_index=0;
        ?>
        <?php $k= 0; foreach($measurement_data['item'] as $key => $measurement):  ?>
            <?php
            ++$k;
            $current_index++;
            if($k == 1){
                $previous = '0';
            }else{
                $previous = $temp;
            }
            $temp = $measurement['quantity_of_work_done'];
            if($item_count!=$current_index)
                continue;
            ?>
            <tr>
                <td><?= ++$i ?></td>
                <td><?= $measurement_data['quantity']; ?></td>
                <td><?= $previous ?></td>
                <td><?= $total = $measurement['quantity_of_work_done']?></td>
                <td><?= $current = $total - $previous; ?></td>
                <td><?= $measurement_data['unit']?></td>
                <td><?= substr($measurement_data['description'], 0, 80).'...';?></td>
                <td><?= number_format( $measurement_data['rate'], 2, '.', '')?></td>
                <td><?= number_format( $measurement_data['quantity']*$measurement_data['rate'], 2, '.', '') ?></td>
                <td><?= number_format( $previous * $measurement_data['rate'], 2, '.', '')?></td>
                <td><?= number_format( $total * $measurement_data['rate'], 2, '.', '')?></td>
                <td><?= number_format( $current * $measurement_data['rate'], 2, '.', '')?></td>
            </tr>

        <?php endforeach; ?>
    <?php endforeach; ?>
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
        <label class="col-sm-4 control-label text-right"><?= __('Total bill amount') ?></label>
        <div class="col-sm-5 pull-right">
            <input type="text" id="so_far_payable" class="form-control" name="total_payable" readonly>

            <!--            <label class="form-control" id="so_far_payable"></label>-->
        </div>
    </div>
    <div class="form-group input" id="up_to_date_approved_wrp" style="display: none;">
        <label class="col-sm-4 control-label text-right"><?= __('Deduction previous bill amount') ?></label>
        <div class="col-sm-5 pull-right">
            <label class="form-control" id="up_to_date_approved"><?php echo $up_to_date_approved; ?></label>
        </div>
    </div>
    <div class="form-group input" id="bill_amount_wrp" style="display: none;">
        <label class="col-sm-4 control-label text-right"><?= __('This bill amount') ?></label>
        <div class="col-sm-5 pull-right">
            <input type="text" id="bill_amount" class="form-control" name="this_bill_amount"  readonly required="required">
        </div>
    </div>
</div>
