<?php
use Cake\Core\Configure;

?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Financial Year Rates'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('New Financial Year Rate') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Financial Year Rates'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('New Financial Year Rate'), ['action' => 'add']) ?></li>


    </ul>
</div>


<?= $this->Form->create($financialYearRate, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Financial Year Rate') ?>
        </h6></div>
    <div class="panel-body col-sm-6">
        <?php
        echo $this->Form->input('financial_year_estimate_id', ['options' => $financialYearEstimates]);
        echo $this->Form->input('rate_month');

        ?>
    </div>
    <div class="panel-body col-sm-6">
        <?php

        echo $this->Form->input('irl_tag');
        ?>
    </div>
    <div class="form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

