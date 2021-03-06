<?php
use Cake\Core\Configure;

?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Guard Duty Shifts'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('New Guard Duty Shift') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Guard Duty Shifts'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('New Guard Duty Shift'), ['action' => 'add']) ?></li>


    </ul>
</div>


<?= $this->Form->create($guardDutyShift, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Guard Duty Shift') ?>
        </h6></div>
    <div class="panel-body col-sm-6">
        <?php
        echo $this->Form->input('name',['label'=>'Shift Name']);
        echo $this->Form->input('start_time');
        echo $this->Form->input('end_time');
        ?>
    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

