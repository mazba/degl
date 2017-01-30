<?php
use Cake\Core\Configure;

/**
 * Created by PhpStorm.
 * User: Mazba
 * Date: 7/6/15
 * Time: 2:36 PM
 */

if($bills)
{
    foreach($bills as $ra_bill_np => $ra_bill)
    {
        ?>
        <optgroup label="RA Bill No <?php echo $ra_bill_np;?>">
            <?php
                foreach($ra_bill as $approve_id=>$approve_part_no)
                {
                    ?>
                    <option value="<?php echo $approve_id ?>">Part NO - <?php echo  $approve_part_no;?></option>
                    <?php
                }
            ?>
        </optgroup>
        <?php
    }
}