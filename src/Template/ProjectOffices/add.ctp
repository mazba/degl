<?php
use Cake\Core\Configure;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Project Offices'), ['action' => 'index']) ?></li>
                    <li class="active"><?= __('New Project Office') ?></li>
        
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Project Offices'), ['action' => 'index']) ?></li>
                    <li class="active"><?= $this->Html->link(__('New Project Office'), ['action' => 'add']) ?></li>
        

    </ul>
</div>


<?= $this->Form->create($projectOffice,['class' => 'form-horizontal','role'=>'form']); ?>
<div class="panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Project Office') ?>
        </h6></div>
    <div class="panel-body col-sm-6">
        <?php
                            echo $this->Form->input('project_id', ['options' => $projects]);
                                    echo $this->Form->input('office_id', ['options' => $offices]);
                                    echo $this->Form->input('financial_year_estimate_id', ['options' => $financialYearEstimates]);
                                    echo $this->Form->input('budget');
                                echo $this->Form->input('status', ['options' => Configure::read('status_options')]);
                        ?>
    </div>
    <div class="form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

