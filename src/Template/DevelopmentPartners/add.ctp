<?php
use Cake\Core\Configure;

?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Development Partners'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('New Development Partner') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Development Partners'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('New Development Partner'), ['action' => 'add']) ?></li>


    </ul>
</div>


<?= $this->Form->create($developmentPartner, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Development Partner') ?>
        </h6></div>
    <div class="panel-body col-sm-6">
        <?php
        echo $this->Form->input('name_en', ['label' => __('NAME_EN')]);
        echo $this->Form->input('short_code');
        ?>
    </div>
    <div class="panel-body col-sm-6">
        <?php
        echo $this->Form->input('name_bn', ['label' => __('NAME_BN')]);
        echo $this->Form->input('address');
        ?>
    </div>
    <div class="form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

