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



<?= $this->Form->create($vehiclesStatus, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Assign Vehicle') ?>
        </h6></div>
    <?php     echo $this->Form->hidden('id'); ?>
    <div class="panel-body col-sm-6">
        <?php

        echo $this->Form->input('vehicle_location', ['readonly']);
        echo $this->Form->input('remark', ['']);

        ?>
    </div>
    <div class="panel-body col-sm-6">
        <?php
        echo $this->Form->input('end_date',['type'=>'text','class'=>'form-control hasdatepicker']);
        ?>
    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

