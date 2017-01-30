<?php
use Cake\Core\Configure;
use Cake\Routing\Router;

Configure::load('config_receive_file_registers', 'default');

?>
<?php if ($receiveFileRegister['project_id'] == null && $receiveFileRegister['scheme_id'] == null && $receiveFileRegister['nothi_assigns']['nothi_register_id'] == null) { ?>
    <div class="callout callout-danger fade in" style="margin-top: 20px;">
        <button class="close" data-dismiss="alert" type="button">x</button>
        <h5><?= __('Notification') ?></h5>
        <p><?= __('এই চিঠি কোন প্রকল্প/ স্কীম/ নথিতে অর্ন্তভূক্ত নেই') ?></p>
    </div>
<?php } ?>


<div class="panel panel-success" style="margin-top: 60px">
    <div class="panel-heading">
        <h6 class="panel-title">
            <i class="icon-stack"></i>
            File Deatils
        </h6>
        <?php if ($receiveFileRegister['id']) { ?>
            <div class="dropdown pull-right">
                <a class="dropdown-toggle btn btn-link btn-icon" data-toggle="dropdown" href="#">
                    <i class="icon-cog3"></i>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu icons-right dropdown-menu-right" style="display: none;">
                    <li>
                        <a href="<?= $this->request->webroot; ?>MyFiles/edit/<?= $receiveFileRegister['id'] ?>">
                            <i class="icon-pencil3"></i>
                            Edit
                        </a>
                    </li>
                </ul>
            </div>
        <?php } ?>
    </div>

    <div class="panel-body">
        <div class="row">
            <div class="col-md-10">
                <p><b><?= __('Subject') ?>: </b><?= h($my_file->subject) ?></p>

                <p><b><?= __('Sender Name') ?>: </b><?= h($receiveFileRegister['sender_name']) ?></p>

                <p><b><?= __('Office Name') ?>: </b><?= h($receiveFileRegister['sender_office_name']) ?></p>
            </div>
            <div class="col-md-2">
                <p><b><?= __('Letter No') ?>: </b><?= h($my_file->id) ?></p>

                <p><b><?= __('Date') ?>: </b><?= date('d-m-Y', $my_file->created_date) ?></p>
            </div>
        </div>
        <div class="row" style="margin-top: 20px;border-top: 1px solid #ddd;padding-top: 10px">
            <div class="col-md-5">

                <?php if (isset($my_file->project->name_en)) { ?>
                    <label><?= __('Project') ?></label><br>
                    <?= h($my_file->project->name_en) ?><br><br>
                <?php } ?>


                <?php if (isset($my_file->scheme->name_en)) { ?>
                    <label><?= __('Scheme') ?></label><br>
                    <?= h($my_file->scheme->name_en) ?><br><br>
                <?php } ?>


                <?php if (!empty($my_file->message_text)) { ?>
                    <label><?= __('Message') ?></label><br>
                    <?= htmlspecialchars_decode($my_file->message_text) ?><br><br>
                <?php } ?>

                <?php if (!empty($my_file->work_description)) { ?>
                    <label><?= __('Work Description') ?></label><br>
                    <?= htmlspecialchars_decode($my_file->work_description) ?><br><br>
                <?php } else if (!empty($reply_msg)) { ?>
                    <label><?= __('Work Description') ?></label><br>
                    <?= htmlspecialchars_decode($reply_msg->work_description) ?><br><br>

                <?php } ?>

                <?php if (isset($my_file->msg_direction)) { ?>

                    <label><?= __('Direction') ?></label><br>
                    <ul>
                        <?php
                        $direction_data = json_decode($my_file->msg_direction);

                        foreach ($directions as $direction) {
                            if (in_array($direction->id, $direction_data)) {
                                if ($direction->urgent_type == 1) {
                                    echo "<li style='color:red'>" . $direction->title . "</li>";
                                } else {
                                    echo "<li>" . $direction->title . "</li>";
                                }

                            }

                        }
                        ?>
                    </ul>
                <?php } ?>

                <?php if (!empty($attach)) { ?>
                    <label><?= __('Attachment') ?></label>

                    <p>

                        <?php foreach ($attach as $data) {
                            $path = pathinfo($data['file_path']);
                            if ($path['extension'] == 'jpg' || $path['extension'] == 'png' || $path['extension'] == 'JPG' || $path['extension'] == 'PNG') {

                                ?>
                                <a data-lightbox="dak_file_image"
                                   href="<?php echo Router::url('/', true) . 'files/receive_files/' . $data['file_path']; ?>">
                                    <img width="100" height="80" class="dak_file_image"
                                         src="<?php echo Router::url('/', true) . 'files/receive_files/' . $data['file_path']; ?>">
                                </a>
                                <?php
                            } else { ?>
                                <a target="_blank"
                                   href="<?php echo Router::url('/', true) . 'files/receive_files/' . $data['file_path']; ?>">
                                    <?php echo $data['file_path']; ?>
                                </a><br>
                            <?php } ?>
                        <?php } ?>
                    </p>
                <?php } ?>

                <?php if (!empty($reply_attach) && isset($reply_attach)) { ?>

                    <label><?= __('Reply Attachment') ?></label><br>
                    <?= h($reply_msg->message_text) ?><br><br>
                    <?php foreach ($reply_attach as $data) {
                        $path = pathinfo($data['file_path']);
                        if ($path['extension'] == 'jpg' || $path['extension'] == 'png' || $path['extension'] == 'JPG' || $path['extension'] == 'PNG') {

                            ?>
                            <a data-lightbox="dak_file_image"
                               href="<?php echo Router::url('/', true) . 'files/receive_files/' . $data['file_path']; ?>">
                                <img width="100" height="80" class="dak_file_image"
                                     src="<?php echo Router::url('/', true) . 'files/receive_files/' . $data['file_path']; ?>">
                            </a>
                            <?php
                        } else { ?>
                            <a target="_blank"
                               href="<?php echo Router::url('/', true) . 'files/receive_files/' . $data['file_path']; ?>">
                                <?php echo $data['file_path']; ?>
                            </a><br>
                        <?php }
                    } ?>

                <?php } ?>
            </div>
            <div class="col-md-7">
                <div class="panel-group">
                    <?php if (!empty($history)):
                        $i = 0;
                        for ($i; $i < count($history); $i++):
                            ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h6 class="panel-title panel-trigger">
                                        <a class="collapsed" href="#question<?= $i ?>"
                                           data-toggle="collapse"><?= $history[$i]['subject'] ?></a>
                                    </h6>
                                </div>
                                <div id="question<?= $i ?>" class="panel-collapse collapse" style="height: 0px;">
                                    <div class="panel-body">
                                        <div class="callout callout-danger" style="margin-bottom: 20px">
                                            <p><b><?= __('From') ?>: </b>
                                                <?php if ($history[$i]['sender_id']) { ?>
                                                    <?= $history[$i]['users']['name_en'] . " (" . $history[$i]['designations']['name_en'] . ")" ?>
                                                <?php } else { ?>
                                                    <?= $history[$i]['sender_name'] ?>
                                                <?php } ?>
                                            </p>

                                            <p><b><?= __('To') ?>: </b><?= $history[$i]['recipient_name'] ?></p>

                                            <p><b><?= __('Date') ?>
                                                    : </b><?= date("Y-m-d H:s a", $history[$i]['created_date']) ?></p>
                                        </div>
                                        <?= $history[$i]['message_text'] ?>
                                    </div>
                                </div>
                            </div>
                        <?php endfor; endif; ?>
                </div>
            </div>
        </div>
        <?php if ($receiveFileRegister['project_id'] || $receiveFileRegister['scheme_id'] || $receiveFileRegister['nothi_assigns']['nothi_register_id'] || $this->request->session()->read('Auth.User.user_group_id') == 2) { ?>
            <div class="row" style="border-top: 1px solid #ddd;margin-top: 10px;padding-top: 25px;">
                <div class="col-md-12">
                    <?php if ($my_file->msg_flow_control == null) { ?>
                        <button style="width:80px" class="btn btn-danger"
                                onclick="showForward()"><?= __('Forward') ?></button>
                    <?php } ?>
                    <?php if (isset($forward_msg) || isset($reply_msg) || $my_file->sender_id) { ?>
                        <button style="width:80px" class="btn btn-success"
                                onclick="showReply()"><?= __('Reply') ?></button>
                    <?php } ?>

                    <?php if ($user_info['department_id'] == 3) { ?>
                        <a class="btn btn-info"
                           href="<?php echo Router::url('/', true); ?>allotment_registers/add/letter/<?= $receiveFileRegister['id'] ?>/<?= $my_file->id ?>">Allotment
                            Register</a>
                        <a class="btn btn-default"
                           href="<?php echo Router::url('/', true); ?>purto_bills/add/<?= $my_file->id ?>">Purto
                            Bill</a>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>


</div>

<div id="forward" class="panel panel-info" style="display: none">
    <div class="panel-body">
        <div class="col-md-12">
            <form method="post"
                  action="<?php echo $this->request->webroot; ?>my_files/forward/<?= $my_file->id ?>" enctype="multipart/form-data">
                <div class="col-md-10">
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?= __("Recipients") ?></label>

                        <div class="col-sm-10">
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

                </div>

                <input type="hidden" name="receive_file_register_id" value="<?= $receiveFileRegister['id']; ?>">


                <div class="row">
                    <div id="user_wrp" class="col-md-offset-2 col-md-10">


                    </div>

                </div>

                <div class="col-md-10">
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?= __('Subject') ?></label>

                        <div class="col-sm-10">
                            <input type="text" name="subject" class="form-control" required="required"
                                   value="<?php if (isset($my_file->subject)) {
                                       echo $my_file->subject;
                                   }; ?>"/>
                        </div>
                    </div>
                </div>

                <div class="col-md-10">
                    <div class="form-group input">
                        <label class="col-sm-2 control-label"><?= __('Message') ?></label>

                        <div class="col-sm-10">
                        <textarea name="message_text" rows="5" style="width: 100%">


                        </textarea>
                        </div>
                    </div>
                </div>

                <div class="col-md-10">

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?= __('Direction') ?> </label>

                        <div class="col-sm-5">
                            <?php
                            //echo $this->Form->select('direction',$directionSetups,['multiple' => 'checkbox']);
                            foreach ($directions as $direction) {
                                if (!$direction['urgent_type']) {
                                    ?>
                                    <div class="checkbox">
                                        <label><input type="checkbox"
                                                      value="<?php echo $direction['id']; ?>"
                                                      name="direction[]"><?php echo $direction['title']; ?>
                                        </label>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <div class="col-sm-5">
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

                </div>

                <div class="col-md-10 read-only">

                    <label class="col-sm-2 control-label"><?= __('Read Only') ?> </label>
                    <label class="col-sm-1 checkbox-inline checkbox-success">
                        <div class="checker">
                                            <span class="checked">
                                            <input class="styled" type="checkbox" name="read_only" value="1">
                                            </span>
                        </div>

                    </label>


                </div>

                <div class="col-md-10" style="margin: 20px 0">

                    <label class="col-sm-2 control-label"><?= __('Reply Deadline') ?> </label>

                    <div class="col-sm-6">
                        <div id="datetimepicker6" class="input-group date">
                            <input class="form-control" type="text" name="reply_deadline">
                                        <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="form-group input">
                        <label class="col-sm-2 control-label"><?= __('Attach File(s)') ?></label>

                        <div class="col-sm-10 container_attached_files">
                            <input type="file" multiple="" name="attachments[]">
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-sm-12 form-actions text-right">
                        <div class="col-sm-12 form-group input">
                            <input class="btn btn-primary" type="submit" value="<?= __('Send') ?>">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="reply" class="panel panel-info" style="display: none">
    <div class="panel-body">
        <div class="row">
            <form method="post"
                  action="<?php echo $this->request->webroot; ?>my_files/reply/<?= $my_file->id ?>"
                  enctype="multipart/form-data">
                <?php if (isset($reply_msg)) { ?>
                    <input type="hidden" name="user_id" value="<?= $reply_msg->sender_id ?>">
                <?php } elseif (isset($forward_msg)) { ?>
                    <input type="hidden" name="user_id" value="<?= $forward_msg->sender_id ?>">
                <?php } else { ?>
                    <input type="hidden" name="user_id" value="<?= $my_file->sender_id ?>">
                <?php } ?>
                <div class="col-md-10">
                    <div class="form-group input">
                        <label class="col-sm-2 control-label"><?= __('Message') ?></label>

                        <div class="col-sm-10">
                                    <textarea id="ckeditor" name="message_text" rows="5" style="width: 100%">


                                    </textarea>
                        </div>
                    </div>
                </div>

                <div class="col-md-10">
                    <div class="form-group input">
                        <label class="col-sm-2 control-label"><?= __('Attach File(s)') ?></label>

                        <div class="col-sm-10 container_attached_files">
                            <input type="file" multiple="" name="attachments[]">
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="col-sm-12 form-actions text-right">
                        <div class="col-sm-12 form-group input">
                            <input class="btn btn-primary" type="submit" value="<?= __('Send') ?>">
                        </div>
                    </div>
                </div>
            </form>
        </div>


    </div>
</div>


<script type="text/javascript">
    function showForward() {
        var x = document.getElementById('forward');
        var y = document.getElementById('reply');
        x.style.display = "block";
        y.style.display = "none";
    }

    function showReply() {
        var x = document.getElementById('reply');
        var y = document.getElementById('forward');
        x.style.display = "block";
        y.style.display = "none";
    }
    //    var user="";
    //    $('#user').on('change', function(){
    //        user +=$(this).find('option:selected').html();
    //        $('#user_list').html(user);
    //    });

</script>
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

        $('#datetimepicker6').datetimepicker();


        $(document).on('change', '#user', function () {
            var text = $(this).find('option:selected').html();
            var id = $(this).val();
            var new_div = '<div class="col-sm-12 individual_usr_wrp" id="' + id + '" style="margin:15px 0">' +
                '<div class="col-md-4 user">' +
                '<label style="display:inline-block; margin-bottom:5px;margin-right:10px;min-width: 200px;line-height: 20px" class="label label-success">' + text + ' </label>' +
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
            var text_div = '<textarea cols="64" name="individual_msg[' + user_id + ']"></textarea></div>'
            $(this).closest('.individual_usr_wrp').find('.user_msg').html(text_div);
        });

        $('.dak_file_image').on('mouseenter', function () {
            $(this).trigger('click');
        });
    });

    CKEDITOR.replace('ckeditor');

</script>
<style>
    .plus_button:hover {
        cursor: pointer;
    }

    .col-md-4.user {
        margin-left: -38px;
    }

    .radio-inline, .checkbox-inline {
        padding-left: 15px;
    }

    .read-only {
        margin-top: 10px
    }

</style>