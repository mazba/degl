<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body" id="modal-bodys">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title"><i class="icon-table2"></i>Add new progress </h6>
        </div>
        <div class="panel-body">
            <?= $this->Form->create($schemeProgress,['action'=>'progress']); ?>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Last Progress</label>
                        <input type="hidden" name="scheme_id" value="<?= $id ?>">
                        <input type="text" class="form-control" id="" value="<?php echo $previous_scheme_progresses ['progress_value'] ? $previous_scheme_progresses ['progress_value'] : 0 ?>" readonly="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">New Progress</label>
                        <input type="number" class="form-control" id="" placeholder="" name="progress_value" max="100" min="0" required="">
                    </div>
                </div>
                <div class="col-md-5 col-md-offset-1">

                    <div class="form-group">
                        <label for="exampleInputEmail1">Date</label>
                        <input type="text" class="form-control hasdatepicker" name="created_date" required="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Remarks</label>
                        <textarea class="form-control" rows="2" name="remarks"></textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <?= $this->Form->submit('Submit', ['class' => 'btn btn-primary']); ?>
                </div>
            <?= $this->Form->end(); ?>
        </div>
    </div>
</div>
<div class="modal-footer">
    <div id="footer"></div>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
<script>
$(document).ready(function () {
    var display_date_format = "dd-M-yy";

    $(".hasdatepicker").datepicker({
        dateFormat: display_date_format,
        changeMonth: true,
        changeYear: true,
        yearRange: "-50:+10"
    });
});
</script>