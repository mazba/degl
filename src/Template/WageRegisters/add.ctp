<?php
use Cake\Core\Configure;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Wage Registers'), ['action' => 'index']) ?></li>
                    <li class="active"><?= __('New Wage Register') ?></li>
        
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Wage Registers'), ['action' => 'index']) ?></li>
                    <li class="active"><?= $this->Html->link(__('New Wage Register'), ['action' => 'add']) ?></li>
        

    </ul>
</div>


<?= $this->Form->create($wageRegister,['class' => 'form-horizontal','role'=>'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Wage Register') ?>
        </h6></div>
    <div class="panel-body col-sm-6">
        <?php
                            echo $this->Form->input('office_id', ['options' => $offices]);
                                    echo $this->Form->input('employee_id', ['options' => $employees]);
                                    echo $this->Form->input('billing_days');
                                    echo $this->Form->input('daily_wage_rate');
                                    echo $this->Form->input('bill_no');
                                    echo $this->Form->input('bill_pay_date');
                                echo $this->Form->input('status', ['options' => Configure::read('status_options')]);
                        ?>
    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

