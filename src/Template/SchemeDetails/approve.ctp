<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Scheme Details'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('Scheme Approve') ?></li>
    </ul>
</div>
<?= $this->Form->create($scheme,['class' => 'form-horizontal','role'=>'form']); ?>
<div class="panel panel-default">

    <div class="panel-heading">
        <h6 class="panel-title">
            <i class="icon-paragraph-right2"></i><?= __('Scheme Approve') ?>
        </h6>
    </div>
    <div class="panel-body">
        <div class="form-group input text">
            <label class="col-sm-3 control-label text-right" for="proposed-start-date"><?= __('Proposed Start Date') ?></label>
            <div class="col-sm-9 container_proposed_start_date">
                <input class="form-control hasdatepicker" id="proposed-start-date" value="<?php echo date('d-M-y',$scheme['proposed_start_date']); ?>" type="text" name="proposed_start_date">
            </div>
        </div>
        <div class="form-group input text">
            <label class="col-sm-3 control-label text-right" for="expected_complete_date"><?= __('Expected Complete Date') ?></label>
            <div class="col-sm-9 expected_complete_date">
                <input class="form-control hasdatepicker" id="expected_complete_date" value="<?php echo date('d-M-y',$scheme['expected_complete_date']); ?>" type="text" name="expected_complete_date">
            </div>
        </div>
        <div class="form-group input text">
            <label class="col-sm-3 control-label text-right" for="tender_date"><?= __('Tender Date') ?></label>
            <div class="col-sm-9 tender_date">
                <input class="form-control hasdatepicker" id="tender_date" value="<?php echo date('d-M-y',$scheme['tender_date']); ?>" type="text" name="tender_date">
            </div>
        </div>
        <?php
            echo $this->Form->input('remarks',['type'=>'textarea','class'=>'form-control']);
        ?>
        <div class="form-actions text-center">
            <input type="submit" value="<?= __('Approve') ?>" class="btn btn-warning">
        </div>
    </div>
</div>
<?= $this->Form->end() ?>

