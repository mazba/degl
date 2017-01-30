<?php
use Cake\Core\Configure;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>">Dashboard</a></li>
        <li><?= $this->Html->link(__('Fine Adjustments'), ['action' => 'index']) ?></li>
                    <li class="active">New Fine Adjustment</li>
        
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Fine Adjustments'), ['action' => 'index']) ?></li>
                    <li class="active"><?= $this->Html->link(__('New Fine Adjustment'), ['action' => 'add']) ?></li>
        

    </ul>
</div>


<?= $this->Form->create($fineAdjustment,['class' => 'form-horizontal','role'=>'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Fine Adjustment') ?>
        </h6></div>
    <div class="panel-body col-sm-6 col-sm-offset-3">
        <?php
                            echo $this->Form->input('scheme_id', ['options' => $schemes]);
                                    echo $this->Form->input('economic_code');
                                    echo $this->Form->input('adjusted_amount');
                                    echo $this->Form->input('reason');

                        ?>
    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="Save" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

