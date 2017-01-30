<?php
use Cake\Core\Configure;

?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Measurement Books'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('Edit Measurement Book') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Measurement Books'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Measurement Book'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <li class="active"><?=
            $this->Html->link(__('Edit Measurement Book'), ['action' => 'edit', $measurementBook->id
            ]) ?>
        </li>
        <?php
        if ($user_roles['view'] == 1)
        {
            ?>
            <li><?=
                $this->Html->link(__('Details Measurement Book'), ['action' => 'view', $measurementBook->id])
                ?>
            </li>
        <?php
        }
        ?>


    </ul>
</div>


<?= $this->Form->create($measurementBook, ['class' => 'form-horizontal', 'role' => 'form']); ?>
    <div class="row panel panel-default">

        <div class="panel-heading"><h6 class="panel-title"><i
                    class="icon-paragraph-right2"></i><?= __('Add Measurement Book') ?>
            </h6></div>
        <div class="panel-body col-sm-6">
            <?php

            echo $this->Form->input('work_commencement_date',['type'=>'text','value'=>$this->System->display_date($measurementBook->work_commencement_date),'class'=>'form-control hasdatepicker']);
            echo $this->Form->input('work_status',['options' => Configure::read('books_work_status')]);
            ?>
        </div>
        <div class="panel-body col-sm-6">
            <?php


            echo $this->Form->input('work_completion_date',['type'=>'text','value'=>$this->System->display_date($measurementBook->work_completion_date),'class'=>'form-control hasdatepicker']);

            ?>
        </div>
        <div class="col-sm-12 form-actions text-right">
            <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
        </div>
    </div>
<?= $this->Form->end() ?>