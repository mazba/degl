<?php
use Cake\Core\Configure;

?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Tree Plants'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('New Tree Plant') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Tree Plants'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('New Tree Plant'), ['action' => 'add']) ?></li>


    </ul>
</div>


<?= $this->Form->create($treePlant, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Tree Plant') ?>
        </h6></div>
    <div class="panel-body col-sm-12">
        <div class="row">
            <div class="col-sm-offset-3 col-sm-6">
                <?php
                echo $this->Form->input('financial_year_estimate_id', ['options' => $FinancialYearEstimates, 'empty' => __('Select'),'required']);
                echo $this->Form->input('status', ['options' => Configure::read('status_options')]);
                ?>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="row panel panel-default">
                <div class="panel-heading"><h6 class="panel-title"><i
                            class="icon-paragraph-right2"></i><?= __('Tree Plantation Target') ?>
                    </h6></div>
                <div class="panel-body col-sm-6">
                    <?php
                    echo $this->Form->input('target_bonoz',['label'=>__('Bonoz')]);
                    echo $this->Form->input('target_vesoz',['label'=>__('Vesoz')]);
                    ?>
                </div>

                <div class="panel-body col-sm-6">
                    <?php
                    echo $this->Form->input('target_foloz',['label'=>__('Foloz')]);
                    echo $this->Form->input('total_plant_cost',['label'=>__('Total Cost')]);
                    ?>
                </div>
            </div>
        </div>

        <div class="col-sm-12" style="margin-top:15px">
            <div class="row panel panel-default">
                <div class="panel-heading"><h6 class="panel-title"><i
                            class="icon-paragraph-right2"></i><?= __('Tree Plantation Progress') ?>
                    </h6></div>
                <div class="panel-body col-sm-6">
                    <?php
                    echo $this->Form->input('progress_bonoz',['label'=>__('Bonoz')]);
                    echo $this->Form->input('progress_vesoz',['label'=>__('Vesoz')]);
                    echo $this->Form->input('progress_foloz',['label'=>__('Foloz')]);
                    //echo $this->Form->input('progress_total_plant',['label'=>__('Total Plant')]);
                    ?>
                </div>

                <div class="panel-body col-sm-6">
                    <?php


                    echo $this->Form->input('road_length',['label'=>__('Road Length')]);
                    echo $this->Form->input('number_of_institution',['label'=>__('Institution No.')]);
                    echo $this->Form->input('total_cost',['label'=>__('Total Cost')]);
                    ?>
                </div>
            </div>
        </div>


        <!--<div class="col-sm-12" style="margin-top:15px">
            <div class="row panel panel-default">
                <div class="panel-heading"><h6 class="panel-title"><i
                            class="icon-paragraph-right2"></i><?/*= __('Alive Number of Tree') */?>
                    </h6></div>
                <div class="panel-body col-sm-6">
                    <?php
/*                    echo $this->Form->input('alive_bonoz');
                    echo $this->Form->input('alive_vesoz');
                    */?>
                </div>

                <div class="panel-body col-sm-6">
                    <?php
/*                    echo $this->Form->input('alive_foloz');
                    echo $this->Form->input('alive_total_plant');
                    */?>
                </div>
            </div>
        </div>-->

    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>


<?= $this->Form->end() ?>

