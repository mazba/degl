<?php
use Cake\Core\Configure;
use Cake\Routing\Router;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Lab Test Fee Registers'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('Edit Lab Test Fee Register') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Lab Test Fee Registers'), ['action' => 'index']) ?></li>
    </ul>
</div>

<form class="form-horizontal" role="role" method="post" action="<?php echo Router::url('/',true); ?>lab_test_fee_registers/add/<?php echo $id; ?>" enctype="multipart/form-data">
<div class="row panel panel-default">

    <div class="panel-heading">
        <h6 class="panel-title">
            <i class="icon-paragraph-right2"></i><?= __('Edit Lab Test Fee Register') ?>
        </h6>
    </div>
    <div class="panel-body col-sm-10">
        <?php
        if($labLetterRegisters['schemes']['name_en'])
        {
            ?>
            <div class="form-group input">
                <label class="col-sm-3 control-label text-right"><?= __('Scheme') ?></label>
                <div class="col-sm-9 files">
                    <label style="height: 68px" class="form-control"><?php echo $labLetterRegisters['schemes']['name_en']; ?></label>
                </div>
            </div>
            <?php
        }
        else
        {
            ?>
            <div class="form-group input">
                <label class="col-sm-3 control-label text-right"><?= __('Work Description') ?></label>
                <div class="col-sm-9 files">
                    <label class="form-control"><?php echo $labLetterRegisters['work_description']; ?></label>
                </div>
            </div>
            <?php
        }
        ?>

        <?php
        echo $this->Form->input('lab_fee',['required']);
        echo $this->Form->input('pay_details',['required']);
        echo $this->Form->input('payment_date',['type'=>'text','value'=>'','class'=>'form-control hasdatepicker','required']);
        ?>
    </div>
    <div class="col-sm-12 form-actions text-center">
        <input type="submit" value="Save" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

