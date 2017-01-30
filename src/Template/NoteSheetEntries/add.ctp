<?php
use Cake\Core\Configure;

?>
<div class="breadcrumb-line" xmlns="http://www.w3.org/1999/html">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>">Dashboard</a></li>
        <li><?= $this->Html->link(__('Note Sheet Entries'), ['action' => 'index']) ?></li>
        <li class="active">New Note Sheet Entry</li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Note Sheet Entries'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('New Note Sheet Entry'), ['action' => 'add']) ?></li>


    </ul>
</div>


<?= $this->Form->create($noteSheetEntry, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Note Sheet Entry') ?>
        </h6></div>
    <div class="panel-body col-sm-8 col-sm-offset-2">
        <?php
        echo $this->Form->input('scheme_id', ['options' => $schemes, 'empty' => '--select--']);
        ?>
        <div id="entry_definition_wrp">
            <?php
            echo $this->Form->input('entry_definition_id', ['options' => $entry_definitions, 'empty' => '--select--', 'label' => 'Type',]);
            ?>
        </div>
        <div id="form_wrp">

        </div>

    </div>

    <div class="col-sm-12">
        <div id="prev_note_sheet_view_wrp"> </div>
    </div>

    <div class="col-sm-12 form-actions text-right">
        <input type="submit" id="submit_btn" value="Save" class="btn btn-primary">
        <input type="button" id="add_new" value="Add New" class="btn btn-primary">

    </div>
</div>
<?= $this->Form->end() ?>

<script>
    $(document).ready(function () {
        $('#entry_definition_wrp').hide();
        $('#submit_btn').hide();
    });

    $(document).on('click', '#add_new', function () {

        $('#entry_definition_wrp').show();
        $('#submit_btn').show();
        $('#prev_note_sheet_view_wrp').hide();
        $(this).hide();

    });

    $(document).on("change", "#entry-definition-id", function (event) {
        var entry_definition_id = $(this).val();
        var scheme_id = $('#scheme-id').val();
        if(entry_definition_id){
        $.ajax({
            url: '<?= $this->Url->build(('/NoteSheetEntries/get_note_sheet_entry_form'), true) ?>',
            type: 'POST',

            data: {entry_definition_id: entry_definition_id, scheme_id: scheme_id},
            success: function (data, status) {
                $('#form_wrp').html(data);
                //console.log(data);

            },
            error: function (xhr, desc, err) {
                console.log("error");

            }
        });
    }


    });


    $(document).on("change", "#scheme-id", function (event) {

        $('#prev_note_sheet_view_wrp').show();
        $('#entry_definition_wrp').hide();
        $('#submit_btn').hide();
        $('#add_new').show();

        var scheme_id = $(this).val();
        if(scheme_id){
        $.ajax({
            url: '<?= $this->Url->build(('/NoteSheetEntries/get_note_sheets'), true) ?>',
            type: 'POST',

            data: {scheme_id: scheme_id},
            success: function (data, status) {
                $('#prev_note_sheet_view_wrp').html(data);
                //console.log(data);

            },
            error: function (xhr, desc, err) {
                console.log("error");

            }
        });
    }


    });
</script>