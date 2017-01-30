<?php
use Cake\Core\Configure;

?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>">Dashboard</a></li>
        <li><?= $this->Html->link(__('Entry Definitions'), ['action' => 'index']) ?></li>
        <li class="active">New Entry Definition</li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Entry Definitions'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('New Entry Definition'), ['action' => 'add']) ?></li>


    </ul>
</div>


<?= $this->Form->create($entryDefinition, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Entry Definition') ?>
        </h6></div>
    <div class="panel-body col-sm-6 col-sm-offset-3">
        <?php echo $this->Form->input('name'); ?>

        <div class="form-group">
            <label class="col-sm-3 control-label text-right"><?= __("View Scope") ?></label>

            <div class="col-sm-9">
                <select tabindex="5" name="view_scope[]" data-placeholder="Select Designations" class="select-multiple"
                        multiple="multiple" required>


                    <?php foreach ($departments as $row) { ?>
                        <option
                            value="<?= $row['id'] ?>"><?= $row['name_bn'] ?></option>
                    <?php } ?>

                </select>
            </div>
        </div>

        <div id="file_wrapper" class="">
            <div class="file_div" data-index_no="0">
                <div class="form-group input file ">


                    <label class="col-sm-3 control-label text-right"><?= __("Attachments") ?></label>

                    <div class="col-sm-7">
                        <select name="attachments[0][attachment_id]" data-placeholder="" class="form-control tt">
                            <option value="">Select</option>
                            <?php foreach ($resourceList as $row) { ?>
                                <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                            <?php } ?>
                        </select>

                        <div class="checkbox">
                            <label>
                                <input class="tt" name=attachments[0][is_require]" type="checkbox" value="1"> is require
                            </label>
                        </div>
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


        <div class="form-group">
            <label class="col-sm-3 control-label text-right"><?= __("Creation Permission") ?></label>

            <div class="col-sm-9">
                <select name="creation_permission[]" data-placeholder="" class="select-multiple "
                        multiple="multiple" required>
                    <?php foreach ($departments as $row) { ?>
                        <option
                            value="<?= $row['id'] ?>"><?= $row['name_bn'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div id="approve_wrapper" class="">
            <div class="approve_div" data-index_no="0">
                <div class="form-group">
                    <label class="col-sm-3 control-label text-right"><?= __("Approval Sequence") ?></label>

                    <div class="col-sm-7">
                        <select name="approval_sequence[0][approval_id]" data-placeholder="" class="form-control tt" required>
                           <option value="">--Select--</option>
                            <?php foreach ($departments as $row) { ?>
                                <option
                                    value="<?= $row['id'] ?>"><?= $row['name_bn'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-1">
                        <span class='btn btn-success add_approval_sequence'>+</span>
                    </div>
                    <div class="col-sm-1">
                        <span class='btn btn-danger remove_approval_sequence'>-</span>
                    </div>
                </div>
            </div>
        </div>


        <div class="form-group">
            <label class="col-sm-3 control-label text-right"><?= __("Precondition") ?></label>

            <div class="col-sm-9">
                <select name="preconditions[]" data-placeholder="" class="select-multiple"
                        multiple="multiple">
                    <?php foreach ($preconditions as $row) { ?>
                        <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <?php
        //        echo $this->Form->input('preconditions');
        //        echo $this->Form->input('status', ['options' => Configure::read('status_options')]);
        ?>


    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="Save" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>
<script>
    $(document).ready(function () {
        $(document).on('click', '.add_file', function () {

            var index = $('.file_div').data('index_no');
            $('.file_div').data('index_no', index + 1);

            var html = $('.file_div:last').clone().find('.tt').each(function () {
                this.name = this.name.replace(/\d+/, index + 1);
                //   this.id = this.id.replace(/\d+/, index + 1);
                //this.value = '';
            }).end();
            $('#file_wrapper').append(html);


        });

        $(document).on('click', '.remove_file', function () {
            var obj = $(this);
            var count = $('.file_div').length;
            if (count > 1) {
                obj.closest('.file_div').remove();
            }
        });



        //approval_sequence
        $(document).on('click', '.add_approval_sequence', function () {

            var index = $('.approve_div').data('index_no');
            $('.approve_div').data('index_no', index + 1);

            var html = $('.approve_div:last').clone().find('.tt').each(function () {
                this.name = this.name.replace(/\d+/, index + 1);
                //   this.id = this.id.replace(/\d+/, index + 1);
                //this.value = '';
            }).end();
            $('#approve_wrapper').append(html);


        });

        $(document).on('click', '.remove_approval_sequence', function () {
            var obj = $(this);
            var count = $('.approve_div').length;
            if (count > 1) {
                obj.closest('.approve_div').remove();
            }
        });
    });

</script>
