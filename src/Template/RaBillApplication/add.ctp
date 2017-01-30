<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('RA Bill Approve And Send'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('New RA Bill') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('Inbox'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Sent'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('Create New RA Bill'), ['action' => 'add']) ?></li>


    </ul>
</div>

<?= $this->Form->create(null, ['url'=>['controller'=>'RaBillApplication','action'=>'add'],'class' => 'form-horizontal', 'role' => 'form','type'=>'file']); ?>
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

       // echo $this->Form->input('related_to',['id'=>'displayField','empty'=>'Select one','options'=>['project'=>'Projects','scheme'=>'Schemes','work_description'=>'Others']]);
?>

<!--        <div id="project" style="display: none">-->
<!--            --><?php //echo $this->Form->input('project_id',['empty'=>'Select one']); ?>
<!--        </div>-->
<!---->
<!--        <div id="scheme" style="display: none">-->
<!--            --><?php //echo $this->Form->input('scheme_id',['empty'=>'Select one']); ?>
<!--        </div>-->

        <div id="work_description" style="display: none">
            <?php echo $this->Form->input('work_description',['type'=>'textarea']); ?>
        </div>
        <?php
        echo $this->Form->input('subject',['required']);
        echo $this->Form->input('message_text',['type'=>'textarea','label'=>__('Message')]);
      //  echo $this->Form->input('attachments[]',['type'=>'file','label'=>__('Attach File(s)'),'multiple'=>'multiple']);
        echo $this->Form->input('reply_deadline',['type'=>'text','class'=>'form-control hasdatepicker']);
        ?>
        <div class="form-group">
            <label class="col-sm-3 control-label text-right"><?= __("RaBill") ?></label>

            <div class="col-sm-9">
                <select name="resource_id" data-placeholder="Select Users" class="form-control" required>
                    <option value="">Select</option>
                    <?php foreach ($RaBills as $row) { ?>
                        <option
                            value="<?= $row['id'] ?>"><?= $row['scheme']['name_bn'] . " (" . $row['ra_bill_no'] . ")" ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div id="file_wrapper">
            <div class="file_div" data-index_no="0">
                <div class="form-group input file required" aria-required="true">
                    <label for="document-file"
                           class="mandetory col-sm-3 control-label text-right">ডকুমেন্ট
                        ফাইল</label>

                    <div class="col-sm-4 container_file_label[]">

                        <select class="form-control" id="file-label"  name="file_label[]" required="required" aria-required="true">
                            <option value="rabill">RA Bill</option>
                            <option value="application">Application</option>
                            <option value="other">Other</option>

                        </select>
                    </div>
                    <div class="col-sm-3 container_document_file[]">
                        <input type="file" name="attachments[]" class="" id="document-file"
                               required="required" multiple="multiple" aria-required="true">
                    </div>
                    <div class="col-sm-1">
                        <span class='btn btn-success add_file'>+</span>
                    </div>
                    <div class="col-sm-1">
                        <span class='btn btn-danger remove_file'>-</span>
                    </div>
                </div>


            </div>
        </div>
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


    $(document).on('click', '.add_file', function () {

        var index = $('.file_div').data('index_no');
        $('.file_div').data('index_no', index + 1);


        $('.file_div:last').clone()
            .find("input:text, input:file").val("").end()
            .appendTo('#file_wrapper');
    });

    $(document).on('click', '.remove_file', function () {
        var obj = $(this);
        var count = $('.file_div').length;
        if (count > 1) {
            obj.closest('.file_div').remove();
        }
    });


</script>
