<select name="module_id" class="form-control">
    <option value=""><?= __('Select') ?></option>
    <?php
    foreach($modules as $id=>$module)
    {
        ?>
        <option value="<?php echo $id?>"><?php echo $module?></option>
        <?php
    }
    ?>
</select>


