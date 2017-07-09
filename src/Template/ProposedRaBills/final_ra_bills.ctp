<?php
use Cake\Core\Configure;
//pr($processReport);die;

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
    <?php $i =0; $bill_amount = 0; foreach($measurements as $key => $measurement_data):  ?>
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
                <?php $bill_amount += $current * $measurement_data['rate']; ?>
            </tr>
        <?php endforeach; ?>
    <?php endforeach; ?>
    <tr>
        <td colspan="11"><?= __('Total Work done to Date') ?></td><td id=""><?php echo  $bill_amount; ?></td>
    </tr>
    </tbody>
</table>
<input type="hidden" name="abc" id="total_payable" value="<?php echo $bill_amount ?>">
<div class="col-md-7">
    <div class="col-sm-12">
        <div class="form-group input text">
            <label for="date_of_commencement:"
                   class="col-sm-4 control-label text-right"><?= __('Date of commencement:') ?></label>
            <div class="col-sm-8 container_etender_date">
                <input type="hidden" name="previous_value" value="<?= $processReport['id']?> ">
                <input type="text" name="do_commencement"   value="<?= $processReport['do_commencement']?date('Y-m-d', $processReport['do_commencement']):''?>" id="do_commencement" maxlength="11" class="form-control hasdatepicker">
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group input text">
            <label for="do_completion"
                   class="col-sm-4 control-label text-right"><?= __('Date of Cmpletion:') ?></label>
            <div class="col-sm-8 container_etender_date">
                <input type="text" name="do_completion"   value="<?= $processReport['do_completion']?date('Y-m-d', $processReport['do_completion']):''?>" id="do_completion" maxlength="11" class="form-control hasdatepicker">
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group input text">
            <label for="edo_completion"
                   class="col-sm-4 control-label text-right"><?= __('Extended Date Of Completion:') ?></label>
            <div class="col-sm-8 container_etender_date">
                <input type="text" name="edo_completion"   value="<?= $processReport['edo_completion']?date('Y-m-d', $processReport['edo_completion']):'' ?>" id="edo_completion" maxlength="11" class="form-control hasdatepicker">
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group input text">
            <label for="ado_completion:"
                   class="col-sm-4 control-label text-right"><?= __('Actual Date of Completion:') ?></label>
            <div class="col-sm-8 container_etender_date">
                <input type="text" name="ado_completion"   value="<?= $processReport['ado_completion']?date('Y-m-d', $processReport['ado_completion']):'' ?>" id="ado_completion" maxlength="11" class="form-control hasdatepicker">
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="ra_bill_no" name="ra_bill_no" value="<?php echo $ra_bill_no; ?>">
<!--<input type="hidden" id="total_payable" name="" value="">-->
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
<script>

    $(document).ready(function () {
        var display_date_format = "yy-mm-dd";
        $(".hasdatepicker").datepicker({
            dateFormat: display_date_format,
            changeMonth: true,
            changeYear: true,
        });
    });
</script>