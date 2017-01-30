<?php
use Cake\Core\Configure;
// echo "<pre>";print_r($vehiclesStatus['vehicles_status']);die();
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Assign Vehicles'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('Vehicle Status') ?></li>

    </ul>
</div>



<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Vehicle status') ?>
        </h6></div>
    <div class="panel-body col-sm-12">
        <h3>Vehical Details</h3>
        <table class="table table-bordered">
            <tr>
                <td><b>Type:</b></td>
                <td><?= $vehiclesStatus['type']?></td>

                <td><b>Title:</b></td>
                <td><?= $vehiclesStatus['title']?></td>
            </tr>

            <tr>
                <td><b>Serial no:</b></td>
                <td><?= $vehiclesStatus['serial_no']?></td>

                <td><b>Registration no:</b></td>
                <td><?= $vehiclesStatus['registration_no']?></td>
            </tr>
        </table>
        <hr/>
        <h3>History</h3>
        <table class="table table-bordered">
            <tr>
                <td>#</td>
                <td>Scheme</td>
                <td>Driver</td>
                <td>Location</td>
                <td>Assign Date</td>
                <td>Return Date</td>
                <td>Remark</td>
                <td>Status</td>
            </tr>
            <?php $i=1;?>
            <?php foreach($vehiclesStatus['vehicles_status'] as $row):?>
                <tr>
                    <td><?= $i;?></td>
                    <td><?= $row['scheme']['name_bn'];?></td>
                    <td><?= $row['employee']['name_bn'];?></td>
                    <td><?= $row['vehicle_location'];?></td>
                    <td><?= date('d/m/Y',$row['assign_date']);?></td>
                    <td><?=$row['end_date']?date('d/m/Y', $row['end_date']):'';?></td>
                    <td><?= $row['remark'];?></td>
                    <td><?= $row['status']?'On Hire':'Closed';?></td>

                </tr>
                <?php $i++;?>
            <?php endforeach ?>
        </table>

    </div>
    <div class="panel-body col-sm-12">

    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>

