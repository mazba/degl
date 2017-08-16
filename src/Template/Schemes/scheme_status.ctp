<?php
use Cake\Core\Configure;
//pr($status['scheme_progress_status']);die;
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">

<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('স্কীমের অবস্থা'), ['action' => 'index']) ?></li>

    </ul>
</div>
<div class="schemes index panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i>
            <?php if($status['scheme_progress_status'] === 0): ?>
                <?= __('স্কীমটি বন্ধ করা হয়েছে') ?>
            <?php else: ?>
                <?= __('স্কীমটি সচল আছে') ?>
            <?php endif; ?>
        </h6>
    </div>
    <div class="panel-body">
        <?= $this->Form->create($scheme,['role'=>'form']); ?>
        <div class="col-sm-offset-1 col-sm-8">
            <div class="form-group input select">
                <?= $this->Form->input('scheme_progress_status', ['options' => Configure::read('scheme_progress_status'), 'empty' => 'নির্বাচন করুন']); ?>
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