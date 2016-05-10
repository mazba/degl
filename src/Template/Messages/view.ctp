<?php
use Cake\Core\Configure;

Configure::load('config_receive_file_registers', 'default');
use Cake\Routing\Router;

?>

<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Messages'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('View') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('Inbox'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Sent'), ['action' => 'sent']) ?></li>
        <li class="active"><?= $this->Html->link(__('View'), ['action' => 'view']) ?></li>
        <li><?= $this->Html->link(__('New Message'), ['action' => 'add']) ?></li>


    </ul>
</div>

<div class="row panel panel-default">
    <div class="panel-heading">
        <h6 class="panel-title">
            <i class="icon-paragraph-right2"></i><?= __('Details Message') ?>
        </h6>
    </div>
    <div class="panel-body col-sm-12">
        <div class="well" style="border:1px solid #003399;margin-bottom: 20px">
            <div class="form-group">
                <label><?= __('From') ?></label>
                <input value="<?= $messages->user->name_en . " (" . $messages->user->designation->name_en . ")" ?>"
                       class="form-control" type="text" disabled>

            </div>

            <div class="form-group">
                <label><?= __('To') ?></label>
                <input
                    value="<?php foreach ($messages->recipients as $user) {
                        echo $user->user->name_en . " (" . $user->user->designation->name_en . "), ";
                    } ?>"
                    class="form-control" type="text" disabled>

            </div>

            <?php if (!empty($messages->project)) { ?>
                <div class="form-group">
                    <label><?= __('Project') ?></label>
                    <input
                        value="<?= $messages->project->name_en ?>"
                        class="form-control" type="text" disabled>

                </div>
            <?php } ?>

            <?php if (!empty($messages->scheme)) { ?>
                <div class="form-group">
                    <label><?= __('Scheme') ?></label>
                    <input
                        value="<?= $messages->scheme->name_en ?>"
                        class="form-control" type="text" disabled>

                </div>
            <?php } ?>

            <?php if (!empty($messages->work_description)) { ?>
                <div class="form-group">
                    <label><?= __('Work Description') ?></label>
                    <textarea style="padding: 10px" disabled name="" id="" cols="196"
                              rows="10"><?= $messages->work_description ?></textarea>
                </div>
            <?php } ?>

            <div class="form-group">
                <label><?= __('Subject') ?></label>
                <input value="<?= $messages->subject ?>" class="form-control" type="text" disabled>

            </div>

            <div class="form-group">
                <label style="display: block"><?= __('Message') ?></label>

                <div style="padding: 10px;background: #fafafa;border:1px solid #ddd;min-height: 100px"
                     disabled><?= $messages->message_text ?></div>
            </div>

            <?php if ($messages->msg_type == 'labBill') { ?>
                 <a href="<?= $this->Url->build(('/LabBills'), true); ?>/view/<?= $messages->resource_id; ?>">View Report</a>

            <?php } ?>
            <?php if ($messages->msg_type == 'hireCharges') { ?>
                 <a href="<?= $this->Url->build(('/hireCharges'), true); ?>/view/<?= $messages->resource_id; ?>">View Vehicle Hire Charge</a>

            <?php } ?>

            <?php if (!empty($attachments)) { ?>
                <div class="form-group">
                    <label><?= __('Attachment') ?></label>
                    <?php foreach ($attachments as $data) { ?>
                        <a href="<?php echo Router::url('/', true) . 'files/receive_files/' . $data->file_path; ?>"><?php echo $data->file_path; ?></a>
                    <?php } ?>
                </div>
            <?php } ?>

        </div>
        <?php if ($reply) { ?>
            <div class="well" style="border:1px solid #003bb3;margin-bottom: 20px">
                <?php foreach ($reply as $data) { ?>
                    <div class="well" style="border:1px solid #004d40;margin-bottom: 20px">
                        <div class="form-group">
                            <label><?= __('Form') ?></label>
                            <input
                                value="<?= $data['users']['name_en'] . " (" . $data['designations']['name_en'] . ")" ?>"
                                class="form-control" type="text" disabled>
                        </div>
                        <div class="form-group">
                            <label style="display: block"><?= __('Message') ?></label>

                            <div style="padding: 10px;background: #fafafa;border:1px solid #ddd;min-height: 100px"
                                 disabled><?= $data->message_text ?></div>
                        </div>

                        <?php if (!empty($data['files'])) { ?>
                            <div class="form-group">
                                <label><?= __('Attachment') ?></label>
                                <?php foreach ($data['files'] as $value) { ?>
                                    <a href="<?= Router::url('/', true) . 'files/receive_files/' . $value['file_path']; ?>"><?= $value['file_path']; ?></a>&nbsp;
                                <?php } ?>
                            </div>
                        <?php } ?>

                    </div>
                <?php } ?>
            </div>
        <?php } ?>

        <div class="form-group">
            <button id="forward_btn" class="btn btn-default"><?= __('Forward') ?></button>
            <button id="reply_btn" class="btn btn-default"><?= __('Reply') ?></button>
        </div>


    </div>


    <div id="forward" class="col-md-12" style="display: none">
        <?= $this->Form->create(null, ['url' => ['controller' => 'messages', 'action' => 'view/' . $messages->id], 'class' => 'form-horizontal', 'role' => 'form']); ?>

        <input type="hidden" name="tag" value="forward"/>

        <div class="panel-body col-md-10">
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
            echo $this->Form->input('subject', ['required']);
            echo $this->Form->input('message_text', ['type' => 'textarea', 'label' => 'Message']);
            echo $this->Form->input('reply_deadline', ['type' => 'text', 'class' => 'form-control hasdatepicker']);
            ?>
        </div>
        <div class="col-sm-10 form-actions text-right">
            <input type="submit" value="<?= __('Forward') ?>" class="btn btn-primary">
        </div>

        <?= $this->Form->end() ?>
    </div>

    <div id="reply" class="col-md-12" style="display: none">
        <?= $this->Form->create(null, ['url' => ['controller' => 'messages', 'action' => 'view/' . $messages->id], 'class' => 'form-horizontal', 'role' => 'form', 'type' => 'file']); ?>

        <input type="hidden" name="tag" value="reply"/>

        <div class="panel-body col-md-10">
            <?php

            echo $this->Form->input('message_text', ['type' => 'textarea', 'label' => 'Message']);
            echo $this->Form->input('attachments[]', ['type' => 'file', 'label' => 'Attach File(s)', 'multiple' => 'multiple']);
            ?>
        </div>

        <div class="col-sm-10 form-actions text-right">
            <input type="submit" value="<?= __('Reply') ?>" class="btn btn-primary">
        </div>
        <?= $this->Form->end() ?>
    </div>

</div>

<script>
    $(document).on('click', '#forward_btn', function (event) {
        $('#forward').show();
        $('#reply').hide();
    })

    $(document).on('click', '#reply_btn', function (event) {
        $('#forward').hide();
        $('#reply').show();
    })

</script>