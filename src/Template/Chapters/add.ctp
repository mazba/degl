<?php
use Cake\Core\Configure;

?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Chapters'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('New Chapter') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Chapters'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('New Chapter'), ['action' => 'add']) ?></li>


    </ul>
</div>


<?= $this->Form->create($chapter, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Chapter') ?>
        </h6></div>
    <div class="panel-body col-sm-6">
        <?php
        echo $this->Form->input('chapter_code');
        ?>
    </div>
    <div class="panel-body col-sm-6">
        <?php

        echo $this->Form->input('name');
        ?>
    </div>
    <div class="form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

