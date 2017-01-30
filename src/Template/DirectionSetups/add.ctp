<?php
use Cake\Core\Configure;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Direction Setups'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('New Direction Setup') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Direction Setups'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('New Direction Setup'), ['action' => 'add']) ?></li>


    </ul>
</div>


<?= $this->Form->create($directionSetup, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading">
        <h6 class="panel-title"><i  class="icon-paragraph-right2"></i><?= __('Add Direction Setup') ?></h6>
    </div>
    <div class="panel-body col-sm-12">
        <?php
        echo $this->Form->input('title');
        echo $this->Form->input('ordering');
        echo $this->Form->input('type',['options'=>['0'=>'Comments Type','1'=>'Urgent Type']]);
        echo $this->Form->input('status', ['options' => Configure::read('status_options')]);
        ?>
    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

