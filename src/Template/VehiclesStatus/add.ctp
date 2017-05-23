<?php
use Cake\Core\Configure;
//;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Assign Vehicles'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('New Assign Vehicle') ?></li>

    </ul>
</div>

<?php if(isset($this->request->params['pass'][1])): ?>

<?= $this->Form->create($vehiclesStatus, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Assign Vehicle') ?>
        </h6></div>
    <div class="panel-body col-sm-6">
        <?php

        echo $this->Form->input('employee_id', ['options' => $employees]);
        echo $this->Form->input('vehicle_location', ['']);
        echo $this->Form->input('remark', ['']);

        ?>
    </div>
    <div class="panel-body col-sm-6">
        <?php
        echo $this->Form->input('scheme_id', ['options' => $schemes,'empty'=>'Select One']);
        echo $this->Form->input('assign_date',['value'=>$vehiclesStatus['assign_date']?date('m/d/Y',$vehiclesStatus['assign_date']):'', 'type'=>'text','class'=>'form-control hasdatepicker']);
        ?>
    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>
<?php else: ?>
    <h1>jugrid</h1>
<?php endif; ?>