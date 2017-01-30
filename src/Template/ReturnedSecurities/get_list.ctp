

<div class="form-group input number ">
    <label class="col-sm-3 control-label text-right" for="returned-amount">Total Security Money Returnable</label>
    <div class="col-sm-9 container_returned_amount">
        <input class="form-control" readonly value="<?= $securities[0]['security_total']?>">
    </div>
</div>

<div class="form-group input number ">
    <label class="col-sm-3 control-label text-right" for="returned-amount">So Far Returned</label>
    <div class="col-sm-9 container_returned_amount">
        <input class="form-control" readonly value="<?=$returnedSecurities[0]['returned_total']?>">
    </div>
</div>

<div class="form-group input number ">
    <label class="col-sm-3 control-label text-right" for="returned-amount">So Far Adjusted</label>
    <div class="col-sm-9 container_returned_amount">
        <input class="form-control" readonly value="<?= $fine_adjustments[0]['fine_adjustments']?>">
    </div>
</div>

<div class="form-group input number required">
    <label class="col-sm-3 control-label text-right" for="returned-amount">Returned Amount</label>
    <div class="col-sm-9 container_returned_amount">
        <input required="required" value="<?php echo $securities[0]['security_total']-($returnedSecurities[0]['returned_total']+$fine_adjustments[0]['fine_adjustments'])?>" step="any" id="returned-amount" class="form-control" name="returned_amount" type="number">
    </div>
</div>