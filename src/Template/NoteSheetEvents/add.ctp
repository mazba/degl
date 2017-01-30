<?php
use Cake\Core\Configure;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>">Dashboard</a></li>
        <li><?= $this->Html->link(__('Note Sheet Events'), ['action' => 'index']) ?></li>
                    <li class="active">New Note Sheet Event</li>
        
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Note Sheet Events'), ['action' => 'index']) ?></li>
                    <li class="active"><?= $this->Html->link(__('New Note Sheet Event'), ['action' => 'add']) ?></li>
        

    </ul>
</div>


<?= $this->Form->create($noteSheetEvent,['class' => 'form-horizontal','role'=>'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Note Sheet Event') ?>
        </h6></div>
    <div class="panel-body col-sm-6">
        <?php
                            echo $this->Form->input('scheme_id', ['options' => $schemes]);
                                    echo $this->Form->input('note_sheet_entry_id', ['options' => $noteSheetEntries]);
                                    echo $this->Form->input('recipient_designation_id');
                                    echo $this->Form->input('office_id', ['options' => $offices]);
                                    echo $this->Form->input('is_read');
                        ?>
    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="Save" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

