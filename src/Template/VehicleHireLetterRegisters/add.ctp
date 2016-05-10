<?php
use Cake\Core\Configure;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Vehicle Hire Letter Registers'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('New Vehicle Hire Letter Register') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Vehicle Hire Letter Registers'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('New Vehicle Hire Letter Register'), ['action' => 'add']) ?></li>


    </ul>
</div>


<?= $this->Form->create($vehicleHireLetterRegister, ['class' => 'form-horizontal', 'role' => 'form','type'=>'file']); ?>
<div class="row panel panel-default">

    <div class="panel-heading">
        <h6 class="panel-title">
            <i class="icon-paragraph-right2"></i><?= __('Add Vehicle Hire Letter Register') ?>
        </h6>
    </div>
    <div class="panel-body col-sm-6">
        <?php
        //echo $this->Form->input('letter_no');
        echo $this->Form->input('sarok_no');
        echo $this->Form->input('subject');
        echo $this->Form->input('sender_office',['options' => $offices, 'empty' => 'Individual/Other']);
        //echo $this->Form->input('receive_office');

        echo $this->Form->input('receive_date',['type'=>'text','class'=>'form-control hasdatepicker']);
        echo $this->Form->input('scheme_id', ['options' => $schemes, 'empty' => 'Others']);
        ?>

        <div class="form-group input">
            <label class="col-sm-3 control-label text-right"><?= __('Attach File(s)') ?></label>
            <div class="col-sm-9 container_attached_files">
                <input type="file" name="attachments[]" multiple>
            </div>
        </div>
    </div>
    <div class="panel-body col-sm-6">
        <?php
        //echo $this->Form->input('client_name');
        //echo $this->Form->input('client_phone');
        //echo $this->Form->input('client_email');
        //echo $this->Form->input('client_fax');
        echo $this->Form->input('receive_from');
        echo $this->Form->input('remarks');

        ?>
        <div class="form-group input textarea" id="work_description_wrp">
            <label for="work-description" class="col-sm-3 control-label text-right"><?= __('Work Description') ?></label>
            <div class="col-sm-9">
                <textarea rows="5" id="work_description" name="work_description" class="form-control">
                </textarea>
            </div>
        </div>
    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>
<script>
    $(document).ready(function(){
        $(document).on('change','#scheme-id',function(){
           var value = $(this).val();
            $('#work_description').val('');
            if(value)
            {
                $('#work_description_wrp').hide();
            }
            else
            {
                $('#work_description_wrp').show();
            }
        });
    });
</script>
