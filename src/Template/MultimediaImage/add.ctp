<?php use Cake\Routing\Router;?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Image'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('New Image') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Images'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('New Images'), ['action' => 'add']) ?></li>


    </ul>
</div>


<form class="form-horizontal" role="role" method="post" action="<?php echo Router::url('/',true); ?>multimedia_image/add" enctype="multipart/form-data">
<div class="panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-image"></i><?= __('Add Image') ?>
        </h6></div>
    <div class="panel-body">
        <div class="col-md-6">
            <?php
                echo $this->Form->input('title');
                echo $this->Form->input('scheme_id', ['options' => $schemes, 'empty' => 'Others']);
                echo $this->Form->input('location');
            ?>
        </div>
        <div class="col-md-6">
            <?php
                echo $this->Form->input('remarks');
                echo $this->Form->input('image_capture_date',['type'=>'text','value'=>'','class'=>'form-control hasdatepicker']);
            ?>
            <div class="form-group input">
                <label class="col-sm-3 control-label text-right"><?= __('Files') ?></label>
                <div class="col-sm-9 files">
                    <input type="file" name="files[]" multiple required="required">
                </div>
            </div>
        </div>
        <div class="form-actions text-right">
            <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
        </div>
    </div>
</div>
<?= $this->Form->end() ?>
