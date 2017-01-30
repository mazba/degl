<?php
use Cake\Core\Configure;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Packages'), ['action' => 'index']) ?></li>
                    <li class="active"><?= __('New Package') ?></li>
        
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Packages'), ['action' => 'index']) ?></li>
                    <li class="active"><?= $this->Html->link(__('New Package'), ['action' => 'add']) ?></li>
        

    </ul>
</div>


<?= $this->Form->create($package,['class' => 'form-horizontal','role'=>'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Package') ?>
        </h6></div>
    <div class="panel-body col-sm-6">
        <?php
                        echo $this->Form->input('name_en',['label'=> __('NAME_EN')]);
                                echo $this->Form->input('name_bn',['label'=> __('NAME_BN')]);
                                echo $this->Form->input('status', ['options' => Configure::read('status_options')]);
                        ?>
    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

