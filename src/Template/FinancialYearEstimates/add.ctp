<?php
use Cake\Core\Configure;

?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Financial Year Estimates'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('New Financial Year Estimate') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Financial Year Estimates'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('New Financial Year Estimate'), ['action' => 'add']) ?></li>


    </ul>
</div>


<?= $this->Form->create($financialYearEstimate, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Financial Year Estimate') ?>
        </h6></div>
    <div class="panel-body col-sm-12">
        <?php
        echo $this->Form->input('name');
        ?>
    </div>
    <div class="form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

