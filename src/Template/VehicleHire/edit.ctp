<?php
use Cake\Core\Configure;
use Cake\Routing\Router;

?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Vehicle Hire'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('Edit Vehicle Hire') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of hired Vehicles'), ['action' => 'index']) ?></li>

        <li class="active"><?=
            $this->Html->link(__('Edit Vehicle Hire'), ['action' => 'edit', $id
            ]) ?>
        </li>

    </ul>
</div>
<table class="table table-bordered">
    <tr>
        <td>পেরক</td>
        <td><?= __('Subject') ?></td>
        <td><?= __('Attachment') ?></td>
    </tr>
    <tr>
        <td><?= $vehicle_hire_letter['receive_from'] ?></td>
        <td><?= $vehicle_hire_letter['subject'] ?></td>
        <td>


            <?php

            if (1) {

                ?>
                <a data-lightbox="dak_file_image"
                   href="<?php echo Router::url('/', true) . 'files/receive_files/' . $attachment['files']['file_path']; ?>">
                    <img width="100" height="80" class="dak_file_image"
                         src="<?php echo Router::url('/', true) . 'files/receive_files/' . $attachment['files']['file_path']; ?>">
                </a>
                <?php
            } else { ?>
                <a target="_blank"
                   href="<?php echo Router::url('/', true) . 'files/receive_files/' . $attachment['files']['file_path']; ?>">
                    <?php echo $attachment['files']['file_path']; ?>
                </a><br>
            <?php } ?>


        </td>
    </tr>

</table> <br/>


<?php if($hired_vehicles){?>
<table class="table table-bordered">
    <tr>
        <td><?= __('Vehilce Title') ?></td>
        <td><?= __('Vehicle Location') ?></td>
    </tr>
    <?php
    foreach($hired_vehicles as $row)
    {

        ?>
        <tr>
            <td><?=$row['title']?></td>
            <td><?=$row['location']?></td>
        </tr>
        <?php
    }
    ?>
</table>
<br> </hr>
<?php } ?>
<?= $this->Form->create(null, ['controller' => 'vehicle_hire', 'action' => 'edit/' . $id, 'class' => 'form-horizontal', 'role' => 'form']); ?>
<table class="table table-bordered">
    <tr>
        <td><?= __('Vehilce Title') ?></td>
        <td><?= __('Select') ?></td>
        <td><?= __('Location') ?></td>
    </tr>
    <?php
    $i = 0;
    foreach ($vehicles as $vehicle) {
        ?>
        <tr>
            <td><?= $vehicle['title'] ?></td>
            <td><input type="checkbox" value="<?= $vehicle['id'] ?>"
                       name="selected_vehicles[]" <?php if (in_array($vehicle['id'], $hired_vehicles)) {
                    echo 'checked';
                } ?>></td>
            <td><input <?php if (!in_array($vehicle['id'], $hired_vehicles)) {
                    echo "disabled";
                } ?>
                    class="form-control location<?= $vehicle['id'] ?> <?php if (in_array($vehicle['id'], $hired_vehicles)) {
                        echo "change" . $hired_vehicles[$i];
                    } ?>" type="text" value="<?php if (in_array($vehicle['id'], $hired_vehicles)) {
                    echo $location[$i++];
                } ?>" name="location[<?= $vehicle['id'] ?>]"></td>
        </tr>
        <?php
    }
    ?>
</table>
<div class="form-actions text-right">
    <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
</div>
<?= $this->Form->end() ?>


<script>
    $(document).ready(function () {
        $("input[type=checkbox]").on('click', function () {
            if ($(this).is(':checked')) {
                var location = "location" + $(this).val();
                $('.' + location).removeAttrs('disabled')
            } else {
                var location = "location" + $(this).val();
                var change = "change" + $(this).val();
                if ($('.' + location).hasClass(change)) {
                    $('.' + location).removeAttrs('disabled')
                } else {
                    $('.' + location).attr('disabled', true)
                }


            }
        })
    })
</script>
