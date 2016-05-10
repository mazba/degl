<?php
if(isset($hire_charge_items))
{
    foreach($hire_charge_items as $data)
    {

        ?>
        <tr data-item-code="<?= $data['item_code']; ?>">
            <td><?= $data['item_code']; ?></td>
            <td><?= $data['description']; ?></td>
            <td><?= $data['item_unit']; ?></td>
            <td><input type="text" class="form-control quantity calculate" name="items[<?= $data['item_code']; ?>][quantity]" value="<?= $data['quantity']; ?>"></td>
            <td><input type="text" class="form-control rate calculate" name="items[<?= $data['item_code']; ?>][rate]" value="<?= $data['rate']; ?>"></td>
            <td><input type="text" class="form-control total" name="items[<?= $data['item_code']; ?>][item_total]" value="<?= $data['item_total']; ?>"></td>
            <td><button class="btn btn-icon btn-danger button_remove_item" type="button"><i class="icon-close"></i></button></td>
            <input type="hidden" value="<?= $data['item_code']; ?>" name="items[<?= $data['item_code']; ?>][item_code]">
            <input type="hidden" value="<?= $data['description']; ?>" name="items[<?= $data['item_code']; ?>][description]">
            <input type="hidden" value="<?= $data['item_unit']; ?>" name="items[<?= $data['item_code']; ?>][item_unit]">
        </tr>
    <?php
    }
    ?>
    <input id="old_bill" type="hidden" value="<?= $last_hire_charge['total_amount']; ?>">
    <?php
}
else
{
    echo 'NOT_FOUND';
}
?>
