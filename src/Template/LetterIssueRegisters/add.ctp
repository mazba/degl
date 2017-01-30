<?php
use Cake\Core\Configure;

Configure::load('config_receive_file_registers', 'default');
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Letter Issue Registers'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('New Letter Issue') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Letter Issues'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('New Letter Issue'), ['action' => 'add']) ?></li>
    </ul>
</div>


<?= $this->Form->create($letterIssueRegister, ['class' => 'form-horizontal', 'role' => 'form', 'type' => 'file']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Issue Letter') ?>
        </h6></div>
    <div class="panel-body col-sm-6">
        <?php
        echo $this->Form->input('issue_date', ['type' => 'text', 'class' => 'form-control hasdatepicker']);
        echo $this->Form->input('receiver_name');
        echo $this->Form->input('receiver_designation');
        //echo $this->Form->input('letter_no');
        echo $this->Form->input('subject');
        //echo $this->Form->input('sender_office');
        echo $this->Form->input('letter_nature', ['options' => Configure::read('letter_nature')]);
        ?>

        <div class="form-group input">
            <label class="col-sm-3 control-label text-right"><?= __('Urgent?') ?></label>

            <div class="col-sm-9 container_is_urgent">
                <?php
                foreach (Configure::read('yes_no_options') as $key => $ot) {
                    ?>
                    <input class="" name="is_urgent" value="<?= $key ?>" <?php if ($key == 0) {
                        echo 'checked';
                    } ?> required="required" type="radio"><?= $ot ?>
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="form-group input">
            <label class="col-sm-3 control-label text-right"><?= __('Answer Required?') ?></label>

            <div class="col-sm-9 container_is_answer_required">
                <?php
                foreach (Configure::read('yes_no_options') as $key => $ot) {
                    ?>
                    <input class="" name="is_answer_required" value="<?= $key ?>" <?php if ($key == 0) {
                        echo 'checked';
                    } ?> required="required" type="radio"><?= $ot ?>
                    <?php
                }
                ?>
            </div>
        </div>

        <div class="form-group input">
            <label class="col-sm-3 control-label text-right"><?= __('Guard File') ?></label>

            <div class="col-sm-9 container_description">
                <input type="checkbox" name="is_guard_file" value="1">
            </div>
        </div>
        <div class="form-group input">
            <label class="col-sm-3 control-label text-right"><?= __('Resolution File') ?></label>

            <div class="col-sm-9 container_description">
                <input type="checkbox" name="is_resolution" value="1">
            </div>
        </div>

    </div>
    <div class="panel-body col-sm-6">
        <?php
        echo $this->Form->input('answer_date', ['type' => 'text', 'class' => 'form-control hasdatepicker']);
        echo $this->Form->input('sender_department', ['options' => Configure::read('departments')]);
        echo $this->Form->input('project_id', ['options' => $projects, 'empty' => 'Other']);
        echo $this->Form->input('scheme_id', ['options' => $schemes, 'empty' => 'Other']);
        echo $this->Form->input('remarks');
        ?>
        <?php
        echo $this->Form->input('sarok_no',['required'=>'required']);
        ?>
        <!--        <div class="form-group input select required">-->
        <!--            <label class="col-sm-3 control-label text-right">Letter Type</label>-->
        <!--            <div class="col-sm-9" id="container_letter_type">-->
        <!--                --><?php
        //                foreach(Configure::read('letter_type') as $key=>$lt)
        //                {
        //                    ?>
        <!--                    <input class="" name="letter_type" value="--><? //=$key ?><!--" -->
        <?php //if($key=='INDIVIDUAL'){echo 'checked';} ?><!-- required="required" type="radio">--><? //=$lt ?>
        <!--                --><?php
        //                }
        //                ?>
        <!--            </div>-->
        <!--        </div>-->
        <!--        <div class="container_office_type_choice" style="display: none;">-->
        <!--            <div class="form-group input select">-->
        <!--                <label class="col-sm-3 control-label text-right">Office Type</label>-->
        <!--                <div class="col-sm-9" id="container_office_type">-->
        <!--                    --><?php
        //                    foreach(Configure::read('office_type') as $key=>$ot)
        //                    {
        //                        ?>
        <!--                        <input class="" name="office_type" value="--><? //=$key ?><!--" -->
        <?php //if($key=='OTHER'){echo 'checked';} ?><!-- type="radio">--><? //=$ot ?>
        <!--                    --><?php
        //                    }
        //                    ?>
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--        <div class="container_lged_office" style="display: none;">-->
        <!--            --><?php
        //            echo $this->Form->input('receiver_office', ['options' => $offices]);
        //            ?>
        <!--        </div>-->
        <!--        --><?php
        //
        //       // echo $this->Form->input('receiver_phone');
        //       // echo $this->Form->input('receiver_email');
        //       // echo $this->Form->input('receiver_fax');
        //       // echo $this->Form->input('receiver_address');
        //        ?>
        <!--        <div class="container_office" style="display: none;">-->
        <!--            <div class="form-group input">-->
        <!--                <label class="col-sm-3 control-label text-right">Guard File?</label>-->
        <!--                <div class="col-sm-9 container_is_guard_file">-->
        <!--                    --><?php
        //                    foreach(Configure::read('yes_no_options') as $key=>$ot)
        //                    {
        //                        ?>
        <!--                        <input class="" name="is_guard_file" value="--><? //=$key ?><!--" -->
        <?php //if($key==0){echo 'checked';} ?><!-- type="radio">--><? //=$ot ?>
        <!--                    --><?php
        //                    }
        //                    ?>
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
        <?php
        echo $this->Form->input('number_of_pages', ['value' => 1]);
        ?>
        <div class="form-group input">
            <label class="col-sm-3 control-label text-right"><?= __('Attach File(s)') ?></label>

            <div class="col-sm-9 container_attached_files">
                <input type="file" name="attachments[]" multiple>
            </div>
        </div>

        <?php echo $this->Form->input('parent_id', ['label' => __('Nothi'), 'options' => $nothiRegisters, 'empty' => __('Select'), 'required', 'templates' => ['inputContainer' => '<div class="form-group nothi_register {{type}}{{required}}">{{content}}</div>']]); ?>

    </div>
    <div class="panel-body col-sm-12">
        <div class="form-group input">
            <label class="col-sm-1 control-label text-right" style="width: 12.333%;"><?= __('Description') ?></label>

            <div class="col-sm-11 container_description" style="width: 87.667%;">
                <textarea name="description" id="ckeditor" cols="30" rows="10"></textarea>
            </div>
        </div>
    </div>

    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

<script type="text/javascript">
    jQuery(document).ready(function () {
        $(document).on("change", 'input[name="letter_type"]:radio', function () {
            var letter_type = $(this).val();
            if (letter_type == 'INDIVIDUAL') {

                $(".container_office_type_choice").hide();
                $(".container_lged_office").hide();
                $(".container_office").hide();
            }
            else {

                $(".container_office_type_choice").show();
                $(".container_lged_office").hide();
                $(".container_office").show();
            }

        });
        $(document).on("change", 'input[name="office_type"]:radio', function () {
            var office_type = $(this).val();
            if (office_type == 'OTHER') {

                $(".container_lged_office").hide();
            }
            else {

                $(".container_lged_office").show();
            }

        });

        $(document).on('change', '#parent-id', function () {
            var parent_id = $(this).val();
            var obj = $(this);
            obj.closest('#container_parent_id').find('.child').remove()
            $.ajax({
                type: 'POST',
                url: '<?= $this->Url->build("/LetterIssueRegisters/getSubNothi")?>',
                data: {parent_id: parent_id},
                dataType: 'json',
                success: function (data, status) {
                    if(Object.keys(data).length){
                        var childSelect = $('<select class="child form-control"></select>');
                        childSelect.append($('<option></option>').text("নির্বাচন করুন").val(""));
                        $.each(data,function(i,v){
                            childSelect.append($('<option></option>').text(v).val(i));
                        });
                        obj.closest('#container_parent_id').append(childSelect)
                    }
                }
            });

        });

    });

    CKEDITOR.replace('ckeditor');
</script>

