<?php
use Cake\Core\Configure;

?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Contractors'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('New Contractor') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Contractors'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('New Contractor'), ['action' => 'add']) ?></li>


    </ul>
</div>


<?= $this->Form->create($contractor, ['class' => 'form-horizontal', 'role' => 'form', 'type' => 'file']); ?>
<div class=" row panel panel-default">

    <div class="panel-heading">
        <h6 class="panel-title">
            <i class="icon-paragraph-right2"></i><?= __('Add Contractor') ?>
        </h6>
    </div>
    <div class="panel-body ">
        <div class="col-sm-6">
            <?php
            echo $this->Form->input('contractor_class_title');
            echo $this->Form->input('contractor_title');
            echo $this->Form->input('contact_person_name');
            echo $this->Form->input('contractor_phone');
            echo $this->Form->input('mobile');
            echo $this->Form->input('contractor_email');
            echo $this->Form->input('picture', ['type' => 'file']);
            ?>
        </div>
        <div class="col-sm-6">
            <?php
            echo $this->Form->input('fax');
            echo $this->Form->input('vat_no');
            echo $this->Form->input('tin_no');
            echo $this->Form->input('trade_licence_no');
            echo $this->Form->input('nid', ['label' => 'জাতীয় পরিচয়পত্র']);
            echo $this->Form->input('contractor_address', ['type' => 'textarea']);

            ?>
        </div>
    </div>

    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

