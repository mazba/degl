<?php use Cake\Core\Configure; ?>


<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Scheme Status Change') ?></li>
    </ul>
</div>

<div class="schemes index panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i> <?= __('Scheme Status Change') ?></h6>
    </div>
    <div class="panel-body">
        <?= $this->Form->create(null,['action'=>'status_change']); ?>

        <div class="col-sm-offset-1 col-sm-8">
            <div class="form-group input select">
                <?= $this->Form->input('scheme_id', ['id' => 'scheme-id', 'options' => $schemes]); ?>
            </div>
        </div>
        <div class="col-sm-offset-1 col-sm-8">
            <div class="form-group input select">
                <?= $this->Form->input('scheme_progress_status', ['options' => Configure::read('scheme_progress_status')]); ?>
            </div>
        </div>

        <div class="col-sm-offset-5 col-sm-1" style="margin-top: 15px">
            <div class="form-action">
                <?= $this->Form->submit('Submit', ['class' => 'btn btn-primary']); ?>
            </div>
        </div>
        <?= $this->Form->end(); ?>
    </div>
</div>
<style>
    .table td {
        padding: 5px 1px !important;
    }
</style>