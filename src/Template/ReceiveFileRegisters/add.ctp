<?php
use Cake\Core\Configure;
Configure::load('config_receive_file_registers', 'default');
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Receive File Registers'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('New Receive File Register') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Receive File Registers'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('New Receive File Register'), ['action' => 'add']) ?></li>


    </ul>
</div>


<?= $this->Form->create($receiveFileRegister, ['class' => 'form-horizontal', 'role' => 'form', 'type' => 'file']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Receive File Register') ?>
        </h6></div>
    <div class="panel-body col-sm-12">
        <?php
        echo $this->Form->input('sender_name',['required'=>'required']);
        echo $this->Form->input('receive_date',['required'=>'required','class'=>'form-control hasdatepicker','type'=>'text']);
        echo $this->Form->input('office_name');
        echo $this->Form->input('address',['type'=>'textarea']);
        echo $this->Form->input('subject');
        ?>
        <div class="form-group">
            <label class="col-sm-3 control-label text-right"><?= __('Description') ?></label>
            <div class="col-sm-9">
                <textarea name="description" id="ckeditor"></textarea>
            </div>
        </div>
        <?= $this->Form->input('letter_media'); ?>
        <div class="form-group input">
            <label class="col-sm-3 control-label text-right"><?= __('Attach File(s)') ?></label>
            <div class="col-sm-9 container_attached_files">
                <input type="file" name="attachments[]" multiple>
            </div>
        </div>

    </div>



    <hr>



    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="<?= __('Forward') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

<script>
    CKEDITOR.replace( 'ckeditor' );
</script>
