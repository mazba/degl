<?php
use Cake\Core\Configure;

?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Items'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('New Item') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Items'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('New Item'), ['action' => 'add']) ?></li>


    </ul>
</div>


<?= $this->Form->create($item, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Item') ?>
        </h6></div>
    <div class="panel-body col-sm-6">
        <?php
        echo $this->Form->input('chapter_id', ['options' => $chapters]);
        echo $this->Form->input('item_display_code');
        echo $this->Form->input('main_code');
        ?>
    </div>
    <div class="panel-body col-sm-6">
        <?php
        echo $this->Form->input('level');
        echo $this->Form->input('unit');
        echo $this->Form->input('description');
        ?>
    </div>
    <div class="form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

