<?php
use Cake\Core\Configure;

?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Vehicle Servicing'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('Edit Vehicle Servicing') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Vehicle Servicings'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Vehicle Servicing'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <li class="active"><?=
            $this->Html->link(__('Edit Vehicle Servicing'), ['action' => 'edit', $vehicleServicing->id
            ]) ?>
        </li>
        <?php
        if ($user_roles['view'] == 1)
        {
            ?>
            <li><?=
                $this->Html->link(__('Details Vehicle Servicing'), ['action' => 'view', $vehicleServicing->id])
                ?>
            </li>
        <?php
        }
        ?>


    </ul>
</div>


<?= $this->Form->create($vehicleServicing, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Vehicle Servicing') ?>
        </h6></div>
    <div class="panel-body col-sm-6">
        <?php

        echo $this->Form->input('defects',['type'=>'textarea']);
        ?>
    </div>
    <div class="panel-body col-sm-6">
        <?php
        echo $this->Form->input('servicing_end_date',['type'=>'text','value'=>$this->System->display_date($vehicleServicing->servicing_end_date),'class'=>'form-control hasdatepicker']);

        echo $this->Form->input('service_charge');

        ?>
    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

