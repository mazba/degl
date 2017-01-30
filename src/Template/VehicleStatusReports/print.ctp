<?php
use Cake\Core\Configure;
Configure::load('config_vehicles', 'default');
$vehicle_status = Configure::read('vehicle_status');
?>
<h1 class="text-center" style="padding-top: 20px"><?=  __('Local Government Engineering Department') ?></h1>
<h3 class="text-center" style=""><?=  $office['name_en'].', '.$office['address'] ?></h3>
<h4 class="text-center" style="font-weight: bold"><?= __('List of Equipments') ?></h4>
<table class="table table-bordered" style="padding: 5px">
    <thead>
        <tr>
            <th><?= __('No') ?></th>
            <th><?= __('Equipments Name & Driver name, Phone no') ?></th>
            <th><?= __('Present Location') ?></th>
            <th><?= __('Status') ?></th>
            <th></th>
            <th><?= __('Remarks') ?></th>
        </tr>

    </thead>
    <tbody>
       <?php
            foreach($vehicles as $vehicle)
            {
                ?>
                <tr>
                    <td><?= $vehicle['id'];  ?></td>
                    <td>
                        <?= $vehicle['title'].' '.__('Roller No').' - '.$vehicle['serial_no'];  ?>
                        <br>
                        <?= $vehicle['employees']['name_en'].' - '.$vehicle['employees']['mobile'] ?>
                    </td>
                    <td><?= $vehicle['vehicle_location'];  ?></td>
                    <td><?= $vehicle_status[$vehicle['vehicle_status']];  ?></td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td></td>
                </tr>
                <?php
            }
       ?>
    </tbody>
</table>
