<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Messages'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('New Message') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('Inbox'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Sent'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('New Message'), ['action' => 'add']) ?></li>


    </ul>
</div>

<?= $this->Form->create(null, ['url'=>['controller'=>'messages','action'=>'add'],'class' => 'form-horizontal', 'role' => 'form','type'=>'file']); ?>
<div class="row panel panel-default">
    <div class="panel-heading">
        <h6 class="panel-title">
            <i  class="icon-paragraph-right2"></i><?= __('New Message') ?>
        </h6>
    </div>
    <div class="panel-body col-sm-10">
        <div class="form-group">
            <label class="col-sm-3 control-label text-right"><?= __("Recipients") ?></label>

            <div class="col-sm-9">
                <select name="user[]" data-placeholder="Select Users" class="select-multiple"
                        multiple="multiple" tabindex="2">
                    <?php foreach ($departments as $department) { ?>
                        <optgroup label="<?= $department->name_bn ?>">
                            <?php foreach ($department['users'] as $user) { ?>
                                <option
                                    value="<?= $user['id'] ?>"><?= $user['name_bn'] . " (" . $user['designation']['name_bn'] . ")" ?></option>
                            <?php } ?>
                        </optgroup>
                    <?php } ?>
                </select>
            </div>
        </div>
        <?php

        echo $this->Form->input('related_to',['id'=>'displayField','empty'=>'Select one','options'=>['project'=>'Projects','scheme'=>'Schemes','work_description'=>'Others']]);
?>

        <div id="project" style="display: none">
            <?php echo $this->Form->input('project_id',['empty'=>'Select one']); ?>
        </div>

        <div id="scheme" style="display: none">
            <?php echo $this->Form->input('scheme_id',['empty'=>'Select one']); ?>
        </div>

        <div id="work_description" style="display: none">
            <?php echo $this->Form->input('work_description',['type'=>'textarea']); ?>
        </div>
        <?php
        echo $this->Form->input('subject',['required']);
        echo $this->Form->input('message_text',['type'=>'textarea','label'=>__('Message')]);
        echo $this->Form->input('attachments[]',['type'=>'file','label'=>__('Attach File(s)'),'multiple'=>'multiple']);
        echo $this->Form->input('reply_deadline',['type'=>'text','class'=>'form-control hasdatepicker']);
        ?>
    </div>

    <div class="col-sm-10 form-actions text-right">
        <input type="submit" value="<?= __('Send') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

<script>

    $(document).on('change','#displayField', function(event){
        var value = $(this).val();
        if(value=='project')
        {
            $('#project').show();
            $('#scheme').hide();
            $('#work_discription').hide();
        }
        else if(value=='scheme')
        {
            $('#project').hide();
            $('#scheme').show();
            $('#work_discription').hide();
        }else if(value=='work_description')
        {
            $('#project').hide();
            $('#scheme').hide();
            $('#work_description').show();
        }
    });



</script>
