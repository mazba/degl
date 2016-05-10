<?php
if (sizeof($nothiRegisters) > 0):
    echo $this->Form->input('nothi_register_id', ['label' => 'Sub Nothi', 'options' => $nothiRegisters, 'empty' => __('Select')]);
else:
    ?>
    <div class="form-group input select">
        <label class="col-sm-3 control-label text-right"><?= __('Sub Nothi') ?></label>

        <div class="col-sm-9 ">
            <select id="nothi-register-id" class="form-control" name="nothi_register_id">
                <option value=""><?= __('Select') ?></option>
            </select>
        </div>
    </div>
    <?php
endif
?>

