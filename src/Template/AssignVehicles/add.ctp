<?php
use Cake\Core\Configure;

?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Assign Vehicles'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('New Assign Vehicle') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Assign Vehicles'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('New Assign Vehicle'), ['action' => 'add']) ?></li>


    </ul>
</div>


<?= $this->Form->create($assignVehicle, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Assign Vehicle') ?>
        </h6></div>
    <div class="panel-body col-sm-6">
        <?php
        echo $this->Form->input('office_id', ['options' => $offices]);

        echo $this->Form->input('employee_id', ['options' => $employees]);

        ?>
    </div>
    <div class="panel-body col-sm-6">
        <?php
        echo $this->Form->input('vehicle_id', ['options' => $vehicles]);
        echo $this->Form->input('assign_date',['type'=>'text','value'=>$this->System->display_date($assignVehicle->assign_date),'class'=>'form-control hasdatepicker']);
        //echo $this->Form->input('end_date',['type'=>'text','value'=>$this->System->display_date($assignVehicle->end_date),'class'=>'form-control hasdatepicker']);
        ?>
    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

