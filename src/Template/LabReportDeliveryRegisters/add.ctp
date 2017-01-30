<?php
use Cake\Core\Configure;
use Cake\Routing\Router;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Lab Report Delivery Registers'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('Lab Report Delivery Registers') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Lab Report Delivery Registers'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="row panel panel-default">
    <div class="panel-heading">
        <h6 class="panel-title">
            <i class="icon-paragraph-right2"></i><?= __('Lab Report Delivery Registers') ?>
        </h6>
    </div>
    <div class="panel-body">
            <form class="form-horizontal" role="role" method="post" action="<?php echo Router::url('/',true); ?>lab_report_delivery_registers/add/<?php echo $id; ?>" enctype="multipart/form-data">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label text-right"><?= __('Client Name') ?></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="<?php echo (isset($lab_letter_registers['client_name']) ? $lab_letter_registers['client_name'] : ''); ?>" name="client_name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label text-right"><?= __('Sample by') ?> </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="sample_by" id="sample_by">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label text-right"><?= __('Sample Date') ?> </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control hasdatepicker" name="sample_date">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label text-right"> </label><?= __('Sample Description') ?>
                        <div class="col-sm-9">
                            <textarea type="text" class="form-control" name="sample_description"></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label text-right"><?= __('Work Description') ?></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="<?php echo (isset($lab_letter_registers['work_description']) ? $lab_letter_registers['work_description'] : ''); ?>" name="work_description">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label text-right"><?= __('Delivered To') ?></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="delivered_to">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label text-right"><?= __('Date of Delivery') ?></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control hasdatepicker" name="date_of_delivery">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label text-right"><?= __('Remarks') ?></label>
                        <div class="col-sm-9">
                            <textarea type="text" class="form-control" name="remarks"></textarea>
                        </div>
                    </div>
                    <div class="form-group input">
                        <label class="col-sm-3 control-label text-right"><?= __('Files') ?></label>
                        <div class="col-sm-9 files">
                            <input type="file" name="file" multiple required="required">
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-info pull-right"><?= __('Submit') ?></button>
                </div>

            </form>
    </div>

</div>


