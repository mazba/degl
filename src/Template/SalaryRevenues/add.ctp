<?php
use Cake\Core\Configure;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Salary Revenues'), ['action' => 'index']) ?></li>
                    <li class="active"><?= __('New Salary Revenue') ?></li>
        
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Salary Revenues'), ['action' => 'index']) ?></li>
                    <li class="active"><?= $this->Html->link(__('New Salary Revenue'), ['action' => 'add']) ?></li>
        

    </ul>
</div>


<?= $this->Form->create($salaryRevenue,['class' => 'form-horizontal','role'=>'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Salary Revenue') ?>
        </h6></div>
    <div class="panel-body col-sm-6">
        <?php
                            echo $this->Form->input('office_id', ['options' => $offices]);
                                    echo $this->Form->input('employee_id', ['options' => $employees]);
                                    echo $this->Form->input('year');
                                    echo $this->Form->input('month');
                                    echo $this->Form->input('bill_pay_date');
                                    echo $this->Form->input('basic');
                                    echo $this->Form->input('house_rent');
                                    echo $this->Form->input('medical');
                                    echo $this->Form->input('transport');
                                    echo $this->Form->input('festival');
                                    echo $this->Form->input('tiffin');
                                    echo $this->Form->input('recreation');
                                    echo $this->Form->input('laundry');
                                    echo $this->Form->input('overtime');
                                    echo $this->Form->input('domestic_aid');
                                    echo $this->Form->input('travel');
                                    echo $this->Form->input('pahari');
                                    echo $this->Form->input('preshon');
                                    echo $this->Form->input('appayon');
                                    echo $this->Form->input('education_aid');
                                    echo $this->Form->input('welfare_cut');
                                    echo $this->Form->input('other_cut');
                                echo $this->Form->input('status', ['options' => Configure::read('status_options')]);
                        ?>
    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

