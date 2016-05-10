<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Departments'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('Edit Department') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Departments'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('Edit Department'), ['action' => 'edit']) ?></li>
        <li><?= $this->Html->link(__('New Department'), ['action' => 'add']) ?></li>


    </ul>
</div>

<?= $this->Form->create($department, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Departments') ?>
        </h6></div>
    <div class="panel-body col-sm-12">
        <?php
        echo $this->Form->input('office_id', ['options' => $offices]);
        echo $this->Form->input('name_en');
        echo $this->Form->input('name_bn');
        echo $this->Form->input('keyword');
        echo $this->Form->input('order_no',['label'=>__('Order')]);
        ?>


    </div>



    <hr>



    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>