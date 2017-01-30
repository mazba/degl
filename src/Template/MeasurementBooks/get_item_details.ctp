<?php
use Cake\Core\Configure;
/**
 * Created by PhpStorm.
 * User: Mazba
 * Date: 6/30/15
 * Time: 10:45 AM
 */
$string = strip_tags($scheme_details['details']);
if (strlen($string) > 50)
{
    // truncate string
    $stringCut = substr($string, 0, 50);
    $string = substr($stringCut, 0, strrpos($stringCut, ' ')).' ...';
}
?>
<table class="table table-bordered show-grid">
    <thead>
        <tr style="background:#eea236; color: #fff; font-weight: bold; text-align: center">
            <td><?= __('Details') ?></td>
            <td><?= __('Comp Sl') ?></td>
            <td><?= __('Item Unit') ?></td>
            <?php
            if($scheme_details['item_unit']=='cum')
            {
                ?>
                <td><?= __('Length') ?></td>
                <td><?= __('Width') ?></td>
                <td><?= __('Height') ?></td>
                <td><?= __('Volume') ?></td>
            <?php
            }
            elseif($scheme_details['item_unit']=='sqm')
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
            <td><?= __('Work Done') ?></td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td title="<?= $scheme_details['details'] ?>"><?php echo $string ?></td>
            <td><?php echo $scheme_details['comp_serial_no'] ?></td>
            <td><?php echo $scheme_details['item_unit'] ?></td>
            <?php
            if($scheme_details['item_unit']=='cum')
            {
                ?>
                <td><?php echo $scheme_details['cl_length'] ?></td>
                <td><?php echo $scheme_details['cl_width'] ?></td>
                <td><?php echo $scheme_details['cl_height_depth'] ?></td>
                <td><?php echo $scheme_details['cl_area_volume'] ?></td>
            <?php
            }
            elseif($scheme_details['item_unit']=='sqm')
            {
                ?>
                <td><?php echo $scheme_details['cl_length'] ?></td>
                <td><?php echo $scheme_details['cl_width'] ?></td>
                <td><?php echo $scheme_details['cl_area_volume'] ?></td>
            <?php
            }
            else
            {
                ?>
                <td><?php echo $scheme_details['item_quantity'] ?></td>
            <?php
            }
            ?>
            <td><?php echo $scheme_details['rate'] ?></td>
            <td><?php echo $scheme_details['total'] ?></td>
            <td><?php echo $measurement['quantity_of_work_done'] ?></td>
        </tr>
    </tbody>
</table>
