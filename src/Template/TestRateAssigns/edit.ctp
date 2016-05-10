<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('List of Test Rate') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Test Rate'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('Edit Test Rate'), ['action' => 'edit']) ?></li>
        <li><?= $this->Html->link(__('Add Test Rate'), ['action' => 'add']) ?></li>
    </ul>
</div>

<?= $this->Form->create($testRateAssign, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Lab Lest') ?>
        </h6></div>
    <div class="panel-body col-sm-7">
        <?php
        echo $this->Form->input('lab_test_list_id',['options'=>$labTestList,'empty'=>'Select test']);
        echo $this->Form->input('financial_year_estimate_id',['options'=>$financialYear,'empty'=>'Select Financial year']);
        echo $this->Form->input('rate');
        echo $this->Form->input('status',['options'=>[1=>'Active',0=>'Inactive']]);
        ?>

        <div class="col-sm-12 form-actions text-right" style="padding-right: 0">
            <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
        </div>
    </div>
    <?= $this->Form->end() ?>
