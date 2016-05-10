<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('List of Lab Test') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Lab Test'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('Add Lab Test'), ['action' => 'add']) ?></li>
    </ul>
</div>

<?= $this->Form->create($labTestList, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Lab Lest') ?>
        </h6></div>
    <div class="panel-body col-sm-12">
        <?php
        echo $this->Form->input('lab_test_group_id',['options'=>$labTestGroups,'empty'=>__('Select')]);
        echo $this->Form->input('test_short_name_en');
        echo $this->Form->input('test_short_name_bn');
        echo $this->Form->input('test_full_name_en');
        echo $this->Form->input('test_full_name_bn');
        ?>

    <div class="col-sm-12 form-actions text-right" style="padding-right: 0">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>
