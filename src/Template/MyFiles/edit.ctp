<?php
use Cake\Core\Configure;
use Cake\Routing\Router;

Configure::load('config_receive_file_registers', 'default');

?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('My Files') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs" style="margin-bottom: 5px">
        <li><?= $this->Html->link(__('My Files List'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('My Edit'), ['action' => 'index']) ?></li>
    </ul>
</div>


<?= $this->Form->create($receiveFileRegister, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Receive File Register') ?>
        </h6></div>
    <div class="panel-body col-sm-12">
        <?php
        echo $this->Form->input('sender_name', ['required' => 'required']);
        echo $this->Form->input('sender_office_name');
        echo $this->Form->input('sender_address', ['type' => 'textarea']);
        ?>
        <?php if (!empty($receiveFileRegister['message_registers']['message_text'])): ?>
            <div class="form-group">
                <label class="col-sm-3 control-label text-right"><?= __('বার্তা') ?></label>

                <div class="col-sm-9">
                <textarea name="description" id="ckeditor">
                    <?= $receiveFileRegister['message_registers']['message_text'] ?>
                </textarea>
                </div>
            </div>
        <?php endif; ?>
        <?php echo $this->Form->input('subject'); ?>
        <?php if (!empty($files)) { ?>
            <div class="form-group input">
                <label class="col-sm-3 control-label text-right"><?= __('Attach File(s)') ?></label>

                <div class="col-sm-9 container_attached_files">
                    <?php
                    foreach ($files as $data) {
                        $path = pathinfo($data['file_path']);
                        if ($path['extension'] == 'jpg' || $path['extension'] == 'png') {
                            ?>
                            <a data-lightbox="dak_file_image"
                               href="<?php echo Router::url('/', true) . 'files/receive_files/' . $data['file_path']; ?>">
                                <img width="100" height="80"
                                     src="<?php echo Router::url('/', true) . 'files/receive_files/' . $data['file_path']; ?>">
                            </a>
                            <?php
                        } else { ?>
                            <a target="_blank"
                               href="<?php echo Router::url('/', true) . 'files/receive_files/' . $data['file_path']; ?>">
                                <?php echo $data['file_path']; ?>
                            </a>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        <?php } ?>
        <?php
        echo $this->Form->input('sarok_no');
        ?>
                <div class="form-group">
            <label class="col-sm-3 control-label text-right"><?= __('বিবরন') ?></label>
                    <div class="col-sm-9">
                        <textarea name="letter_description" id="ckeditorTwo">
                            <?= isset ($receiveFileRegister['letter_description'])?$receiveFileRegister['letter_description']:""?>
                        </textarea>
                    </div>
                </div>
        <?php
        echo $this->Form->input('releated_to', ['onchange' => 'displayField()', 'empty' => 'Select one', 'options' => ['project' => 'Projects', 'scheme' => 'Schemes', 'work_description' => 'Others'], 'required']);

        ?>

        <div id="project" style="display: none">
            <?php echo $this->Form->input('project_id', ['empty' => 'Select one']); ?>
        </div>

        <div id="scheme" style="display: none">
            <?php echo $this->Form->input('scheme_id', ['empty' => 'Select one', 'options' => $schemes]); ?>
        </div>

        <div id="work_description" style="display: none">
            <?php echo $this->Form->input('work_description', ['type' => 'textarea']); ?>
        </div>
        <?php
        echo $this->Form->input('selected_nothi', ['value' => isset($receiveFileRegister) ? $receiveFileRegister->nothi_registers['nothi_no'] : "", 'disabled']);
        ?>
        <?php echo $this->Form->input('parent_id', ['label' => __('Nothi'), 'options' => $nothiRegisters, 'empty' => __('Select'), 'required', 'templates' => ['inputContainer' => '<div class="form-group nothi_register {{type}}{{required}}">{{content}}</div>']]); ?>

    </div>


    <hr>


    <div id="send_btn" class="col-sm-12 form-actions text-right">
        <span id="forward_btn" class="btn btn-primary"><?= __('Update & Forward') ?></span>
        <input type="submit" value="<?= __('Update Only') ?>" class="btn btn-primary">
    </div>
    <div class="col-sm-12 forward" style="display: none">
        <div class="form-group input select">
            <label class="col-sm-3 control-label text-right"><?= __("Recipients") ?></label>

            <div class="col-sm-9">
                <select id="user" class="form-control">
                    <option value="">Select User</option>
                    <?php
                    $dept = "";
                    foreach ($departments as $department) { ?>
                    <?php if ($department['name_bn'] != $dept) { ?>
                    <optgroup label="<?= $department['name_bn'] ?>">
                        <?php $dept = $department['name_bn'];
                        } ?>
                        <?php if (isset($department['users']['name_bn'])) { ?>
                            <option
                                value="<?= $department['users']['id'] ?>"><?= $department['users']['name_bn'] . " (" . $department['designations']['name_bn'] . ")" ?></option>
                        <?php }
                        } ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div id="user_wrp" class="col-md-offset-2 col-md-10">


            </div>

        </div>

        <?php if (empty($receiveFileRegister['message_registers']['message_text'])): ?>
            <div class="form-group input">
                <label class="col-sm-3 control-label text-right"><?= __('Message') ?></label>

                <div class="col-sm-9">
                        <textarea name="description" id="ckeditor">

                        </textarea>
                </div>
            </div>
        <?php endif; ?>


        <div class="form-group">
            <label class="col-sm-3 control-label text-right"><?= __('Direction') ?> </label>

            <div class="col-sm-5">
                <?php
                //echo $this->Form->select('direction',$directionSetups,['multiple' => 'checkbox']);
                foreach ($directions as $direction) {
                    if (!$direction['urgent_type']) {
                        ?>
                        <div class="checkbox">
                            <label><input type="checkbox" value="<?php echo $direction['id']; ?>"
                                          name="direction[]"><?php echo $direction['title']; ?>
                            </label>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <div class="col-sm-4">
                <?php
                //echo $this->Form->select('direction',$directionSetups,['multiple' => 'checkbox']);
                foreach ($directions as $direction) {
                    if ($direction['urgent_type']) {
                        ?>
                        <div class="radio">
                            <label><input type="radio" value="<?php echo $direction['id']; ?>"
                                          name="direction[]"><?php echo $direction['title']; ?>
                            </label>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>


        </div>


        <div class="form-group">
            <label class="col-sm-3 control-label text-right"><?= __('Read Only') ?> </label>


            <label class="col-sm-1 checkbox-inline checkbox-success" style="padding-left: 15px">
                <div class="checker">
                                            <span class="checked">
                                            <input class="styled" type="checkbox" name="read_only" value="1">
                                            </span>
                </div>

            </label>

        </div>


        <div class="form-group">

            <label class="col-sm-3 control-label text-right"><?= __('Reply Deadline') ?> </label>

            <div class="col-sm-6">
                <div id="datetimepicker6" class="input-group date">
                    <input class="form-control" type="text" name="reply_deadline">
                                        <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                </div>
            </div>
        </div>


        <div class="col-sm-12 form-actions text-right">
            <input type="submit" value="<?= __('Update & Forward') ?>" class="btn btn-primary">
        </div>


    </div>

    <?= $this->Form->end() ?>

    <script type="text/javascript" src="<?php echo $this->request->webroot; ?>js/bootstrap/moment.js"></script>
    <script type="text/javascript" src="<?php echo $this->request->webroot; ?>js/bootstrap/collapse.js"></script>
    <script type="text/javascript" src="<?php echo $this->request->webroot; ?>js/bootstrap/transition.js"></script>
    <script type="text/javascript"
            src="<?php echo $this->request->webroot; ?>js/bootstrap/bootstrap-datetime-picker.js"></script>
    <script type="text/javascript"
            src="<?php echo $this->request->webroot; ?>js/bootstrap/bootstrap-datetime-picker.js"></script>
    <link type="text/css" rel="stylesheet"
          href="<?php echo $this->request->webroot; ?>js/bootstrap/bootstrap-datetime-picker.css"/>

    <script>

        $(document).ready(function () {

            $(document).on('change', '#user', function () {
                var text = $(this).find('option:selected').html();
                var id = $(this).val();
                var new_div = '<div class="col-sm-12 individual_usr_wrp" id="' + id + '" style="margin:15px 0">' +
                    '<div class="col-md-4 user">' +
                    '<label style="display:inline-block; margin-bottom:5px;margin-right:10px" class="label label-success">' + text + ' </label>' +
                    '<i class="plus_button icon-plus" data-user_id="' + id + '"></i>' +
                    '<input type="hidden" name="name[]" value="' + id + '">' +
                    '</div> ' +
                    '<div class="col-md-7 user_msg">' +
                    '</div>';
                '</div>';
                $('#user_wrp').append(new_div);
            });
            $(document).on('click', '.plus_button', function () {
                var user_id = $(this).attr('data-user_id');
                var text_div = '<textarea cols="56" name="individual_msg[' + user_id + ']"></textarea></div>'
                $(this).closest('.individual_usr_wrp').find('.user_msg').html(text_div);
            });
        });
    </script>

    <script>
        function displayField() {
            var x = document.getElementById('releated-to').value;
            if (x == "project") {
                var y = document.getElementById('project');
                var z = document.getElementById('scheme');
                var w = document.getElementById('work_description');
                y.style.display = "block";
                z.style.display = "none";
                w.style.display = "none";
            }
            if (x == "scheme") {
                var y = document.getElementById('project');
                var z = document.getElementById('scheme');
                var w = document.getElementById('work_description');
                y.style.display = "none";
                z.style.display = "block";
                w.style.display = "none";
            }

            if (x == "work_description") {
                var y = document.getElementById('project');
                var z = document.getElementById('scheme');
                var w = document.getElementById('work_description');
                y.style.display = "none";
                z.style.display = "none";
                w.style.display = "block";
            }
        }
        $('#datetimepicker6').datetimepicker();

        $(document).on('click', '#forward_btn', function () {
            $('#send_btn').hide();
            $('.forward').show();

        })

        $(document).on('change', '#nothi-id', function () {
            var nothi_id = $(this).val();
            $.ajax({
                type: 'POST',
                url: '<?= $this->Url->build('/MyFiles/getSubNothi') ?>',
                data: {nothi_id: nothi_id},
                success: function (data, status) {
                    $('.nothi_register').empty();
                    $('.nothi_register').html(data);

                },
                error: function (xhr, desc, err) {

                }
            });
        });

        $(document).on('change', '#parent-id', function () {
            var parent_id = $(this).val();
            var obj = $(this);
            $.ajax({
                type: 'POST',
                url: '<?= $this->Url->build("/NothiRegisters/getSubNothi")?>',
                data: {parent_id: parent_id},
                success: function (data, status) {
                    obj.closest('.nothi_register').nextAll('.nothi_register').remove();
                    if (data) {
                        obj.closest('.form-group').after(data);
                    }
                }
            });
        });

        CKEDITOR.replace('ckeditor');
        CKEDITOR.replace('ckeditorTwo');
    </script>
    <style>
        .plus_button:hover {
            cursor: pointer;
        }

        .chosen-container.chosen-container-single {
            width: 783px !important
        }
    </style>

