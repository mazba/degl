<?php
if($flag == 'new_item')
{
    ?>
    <table id="<?php echo 'item_'.$data['item_id']; ?>" data-item-table="<?php echo $data['item_table']; ?>" data-item-code="<?=$data['item_code']?>" data-item-unit='<?=$data['item_unit']?>' data-item-rate='<?=$data['item_rate']?>' data-financial-year='<?=$data['financial_year']?>' class="table table-bordered show-grid">
        <tr>
            <td class="text-center bg-warning" colspan="1"><?php echo $data['item_code']; ?></td>
            <td class="bg-info" colspan="11"><?php echo $data['description']; ?></td>
            <input type="hidden" name="item_code" value="<?php echo $data['item_code']; ?>">
            <input type="hidden" name="item_unit" value="<?php echo $data['item_unit']; ?>">
            <input type="hidden" name="financial_year" value="<?php echo $data['financial_year']; ?>">
            <input type="hidden" name="item_table" value="<?php echo $data['item_table']; ?>">
            <input type="hidden" name="item_id" value="<?=$data['item_id']?>">
            <input type="hidden" name="item_description" value="<?=$data['description']?>">

        </tr>
        <?php
        if($data['item_unit']=='cum')
        {
            ?>
            <tr>
                <td><?= __('Deduction') ?></td>
                <td><?= __('Comp Sl') ?></td>
                <td><?= __('Location/Component') ?></td>
                <td><?= __('Length') ?></td>
                <td><?= __('Width') ?></td>
                <td><?= __('Height/Depth') ?></td>
                <td><?= __('Volume') ?></td>
                <td><?= __('Rate') ?></td>
                <td><?= __('Total') ?></td>
                <td><?= __('Remarks') ?></td>
                <td><?= __('Break up') ?></td>
                <td></td>
            </tr>
            <tr>
                <td><input type="text" name="item_element[0][deducation]" value="" required="required"></td>
                <td><input type="text" name="item_element[0][comp_serial_no]" value="" required="required"></td>
                <td><input type="text" name="item_element[0][component_location]" value="" required="required"></td>
                <td><input type="text" name="item_element[0][cl_length]" class="ele_calculation length" value="" required="required"></td>
                <td><input type="text" name="item_element[0][cl_width]" class="ele_calculation width" value="" required="required"></td>
                <td><input type="text" name="item_element[0][cl_height_depth]" class="ele_calculation height" value="" required="required"></td>
                <td><input type="text" name="item_element[0][cl_area_volume]" class="area_volume" readonly="readonly" value="" required="required"></td>
                <td><input type="text" name="item_element[0][rate]" class="ele_calculation rate" value="<?=$data['item_rate']?>" required="required"></td>
                <td><input type="text" name="item_element[0][total]" class="total" value="" required="required"></td>
                <td><input type="text" name="item_element[0][remarks]" value=""></td>
                <td><input type="text" name="item_element[0][has_breakup]" value=""></td>

                <td><button type="button" class="btn btn-warning button_remove_element"><?= __('Remove element') ?></button></td>
            </tr>
        <?php
        }
        elseif($data['item_unit']=='sqm')
        {
            ?>
            <tr>
                <td><?= __('Deduction') ?></td>
                <td><?= __('Comp Sl') ?></td>
                <td><?= __('Location/Component') ?></td>
                <td><?= __('Length') ?></td>
                <td><?= __('Width') ?></td>
                <td><?= __('Area') ?></td>
                <td><?= __('Rate') ?></td>
                <td><?= __('Total') ?></td>
                <td><?= __('Remarks') ?></td>
                <td><?= __('Break up') ?></td>
                <td></td>
            </tr>
            <tr>
                <td><input type="text" name="item_element[0][deducation]" value="" required="required"></td>
                <td><input type="text" name="item_element[0][comp_serial_no]" value="" required="required"></td>
                <td><input type="text" name="item_element[0][component_location]" value="" required="required"></td>
                <td><input type="text" name="item_element[0][cl_length]" class="ele_calculation length" value="" required="required"></td>
                <td><input type="text" name="item_element[0][cl_width]" class="ele_calculation width" value="" required="required"></td>
                <td><input type="text" name="item_element[0][cl_area_volume]" class="area_volume" readonly="readonly" value="" required="required"></td>
                <td><input type="text" name="item_element[0][rate]" class="ele_calculation rate" value="<?=$data['item_rate']?>" required="required"></td>
                <td><input type="text" name="item_element[0][total]" class="total" value="" required="required"></td>
                <td><input type="text" name="item_element[0][remarks]" value=""></td>
                <td><input type="text" name="item_element[0][has_breakup]" value=""></td>

                <td><button type="button" class="btn btn-warning button_remove_element"><?= __('Remove element') ?></button></td>
            </tr>
        <?php
        }
        else
        {
            ?>
            <tr>
                <td><?= __('Deduction') ?></td>
                <td><?= __('Comp Sl') ?></td>
                <td><?= __('Location/Component') ?></td>
                <td><?= __('Length') ?></td>
                <td><?= __('Width') ?></td>
                <td><?= __('Area') ?></td>
                <td><?= __('Rate') ?></td>
                <td><?= __('Total') ?></td>
                <td><?= __('Remarks') ?></td>
                <td><?= __('Break up') ?></td>
                <td></td>
            </tr>
            <tr>
                <td><input type="text" name="item_element[0][deducation]" value="" required="required"></td>
                <td><input type="text" name="item_element[0][comp_serial_no]" value="" required="required"></td>
                <td><input type="text" name="item_element[0][component_location]" value="" required="required"></td>
                <td><input type="text" name="item_element[0][item_quantity]" class="ele_calculation item_quantity" value="" required="required"></td>
                <td><input type="text" name="item_element[0][rate]" class="ele_calculation rate" value="<?=$data['item_rate']?>" required="required"></td>
                <td><input type="text" name="item_element[0][total]" class="total" value="" required="required"></td>
                <td><input type="text" name="item_element[0][remarks]" value=""></td>
                <td><input type="text" name="item_element[0][has_breakup]" value=""></td>

                <td><button type="button" class="btn btn-warning button_remove_element"><?= __('Remove element') ?></button></td>
            </tr>
        <?php
        }
        ?>
        <tr>
            <td colspan="13" class="text-center">
                <button type="button" data-item-id="<?=$data['item_id']?>" data-last-id="0" class="btn btn-primary button_add_element">Add element</button>
            </td>
        </tr>
    </table>
    <?php
}
elseif($flag == 'old_items')
{
    $i=0;
?>
    <table id="<?php echo 'item_'.$old_scheme_item['item_id']; ?>" data-item-table="<?php echo $old_scheme_item['item_table']; ?>" data-item-code="<?=$old_scheme_item['item_code']?>" data-item-unit='<?=$old_scheme_item['item_unit']?>' data-item-rate='<?=$old_scheme_item['rate']?>' data-financial-year='<?=$old_scheme_item['financial_year']?>' class="table table-bordered show-grid">
        <tr>
            <td class="text-center bg-warning" colspan="1"><?php echo $old_scheme_item['item_code']; ?></td>
            <td class="bg-info" colspan="11"><?= $old_scheme_item['details'] ?></td>
            <input type="hidden" name="item_code" value="<?php echo $old_scheme_item['item_code']; ?>">
            <input type="hidden" name="item_unit" value="<?php echo $old_scheme_item['item_unit']; ?>">
            <input type="hidden" name="financial_year" value="<?php echo $old_scheme_item['financial_year']; ?>">
            <input type="hidden" name="item_table" value="<?php echo $old_scheme_item['item_table']; ?>">
            <input type="hidden" name="item_id" value="<?=$old_scheme_item['item_id']?>">
            <input type="hidden" name="item_description" value="<?=$old_scheme_item['details']?>">
        </tr>
        <tr>
            <td><?= __('Deduction') ?></td>
            <td><?= __('Comp Sl') ?></td>
            <td><?= __('Location/Component') ?></td>
            <?php
            if($old_scheme_item['item_unit']=='cum')
            {
                ?>
                <td><?= __('Length') ?></td>
                <td><?= __('Width') ?></td>
                <td><?= __('Height/Depth') ?></td>
                <td><?= __('Volume') ?></td>
            <?php
            }
            elseif($old_scheme_item['item_unit']=='sqm')
            {
                ?>
                <td><?= __('Length') ?></td>
                <td><?= __('Width') ?></td>
                <td><?= __('Area') ?></td>
            <?php
            }
            else
            {
                ?>
                <td><?= __('No of items') ?></td>
            <?php
            }
            ?>
            <td><?= __('Rate') ?></td>
            <td><?= __('Total') ?></td>
            <td><?= __('Remarks') ?></td>
            <td><?= __('Break up') ?></td>
            <td></td>
        </tr>
        <?php
        foreach($old_scheme_item['rows'] as $key=>$item)
        {
            $i++;
            ?>
            <tr>
                <td><input type="text" name="item_element[<?php echo $key; ?>][deducation]" value="<?php echo $item['deducation'] ?>" required="required"></td>
                <td><input type="text" name="item_element[<?php echo $key; ?>][comp_serial_no]" value="<?php echo $item['comp_serial_no'] ?>" required="required"></td>
                <td><input type="text" name="item_element[<?php echo $key; ?>][component_location]" value="<?php echo $item['component_location'] ?>" required="required"></td>
                <?php
                if($old_scheme_item['item_unit']=='cum')
                {
                    ?>
                    <td><input type="text" name="item_element[<?php echo $key; ?>][cl_length]" class="ele_calculation length" value="<?php echo $item['cl_length'] ?>" required="required"></td>
                    <td><input type="text" name="item_element[<?php echo $key; ?>][cl_width]" class="ele_calculation width" value="<?php echo $item['cl_width'] ?>" required="required"></td>
                    <td><input type="text" name="item_element[<?php echo $key; ?>][cl_height_depth]" class="ele_calculation height" value="<?php echo $item['cl_height_depth'] ?>" required="required"></td>
                    <td><input type="text" name="item_element[<?php echo $key; ?>][cl_area_volume]" class="area_volume" readonly="readonly" value="<?php echo $item['cl_area_volume'] ?>" required="required"></td>
                <?php
                }
                elseif($old_scheme_item['item_unit']=='sqm')
                {
                    ?>
                    <td><input type="text" name="item_element[<?php echo $key; ?>][cl_length]" class="ele_calculation length" value="<?php echo $item['cl_length'] ?>" required="required"></td>
                    <td><input type="text" name="item_element[<?php echo $key; ?>][cl_width]" class="ele_calculation width" value="<?php echo $item['cl_width'] ?>" required="required"></td>
                    <td><input type="text" name="item_element[<?php echo $key; ?>][cl_area_volume]" class="area_volume" readonly="readonly" value="<?php echo $item['cl_area_volume'] ?>" required="required"></td>
                <?php
                }
                else
                {
                    ?>
                    <td><input type="text" name="item_element[<?php echo $key; ?>][item_quantity]" class="ele_calculation item_quantity" value="<?php echo $item['item_quantity'] ?>" required="required"></td>
                <?php
                }
                ?>
                <td><input type="text" name="item_element[<?php echo $key; ?>][rate]" class="ele_calculation rate" value="<?=$item['rate']?>" required="required"></td>
                <td><input type="text" name="item_element[<?php echo $key; ?>][total]" class="total" value="<?php echo $item['total'] ?>" required="required"></td>
                <td><input type="text" name="item_element[<?php echo $key; ?>][remarks]" value="<?php echo $item['remarks'] ?>"></td>
                <td><input type="text" name="item_element[<?php echo $key; ?>][has_breakup]" value="<?php echo $item['has_breakup'] ?>"></td>

                <input type="hidden" name="item_element[<?php echo $key; ?>][item_code]" value="<?php echo $item['item_code']; ?>">
                <input type="hidden" name="item_element[<?php echo $key; ?>][item_unit]" value="<?php echo $item['item_unit']; ?>">
                <input type="hidden" name="item_element[<?php echo $key; ?>][financial_year]" value="<?php echo $item['financial_year']; ?>">
                <input type="hidden" name="item_element[<?php echo $key; ?>][item_table]" value="<?php echo $item['item_table']; ?>">
                <input type="hidden" name="item_element[<?php echo $key; ?>][item_id]" value="<?php echo $item['item_id']; ?>">

                <td><button type="button" class="btn btn-warning button_remove_element"><?= __('Remove element') ?></button></td>
            </tr>
        <?php
        }
        ?>
        <tr>
            <td colspan="13" class="text-center">
                <button type="button" data-item-id="<?=$old_scheme_item['item_id']?>" data-last-id="<?php echo (isset($i) ? $i : 0); ?>" class="btn btn-primary button_add_element"><?= __('Add element') ?></button>
            </td>
        </tr>
    </table>
<?php
}
else
{
    echo 'NOT_FOUND';
}
?>

