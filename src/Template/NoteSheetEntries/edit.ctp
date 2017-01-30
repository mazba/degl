<?php
use Cake\Core\Configure;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>">Dashboard</a></li>
        <li><?= $this->Html->link(__('Note Sheet Entries'), ['action' => 'index']) ?></li>
                    <li class="active">Edit Note Sheet Entry</li>
        
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Note Sheet Entries'), ['action' => 'index']) ?></li>
                    <?php
            if ($user_roles['add'] == 1)
            {
                ?>
                <li><?= $this->Html->link(__('New Note Sheet Entry'), ['action' => 'add']) ?></li>
            <?php
            }
            ?>
            <li class="active"><?= $this->Html->link(__('Edit Note Sheet Entry'), ['action' => 'edit', $noteSheetEntry->id
                ]) ?>
            </li>
            <?php
            if ($user_roles['delete'] == 1)
            {
                ?>
                <li><?=
                    $this->Form->postLink(
                        __('Delete Note Sheet Entry'),
                        ['action' => 'delete', $noteSheetEntry->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $noteSheetEntry
                    ->id)]
                    )
                    ?>
                </li>
            <?php
            }
            ?>
            <?php
            if ($user_roles['view'] == 1)
            {
                ?>
                <li><?= $this->Html->link(__('Details Note Sheet Entry'), ['action' => 'view', $noteSheetEntry->id])
                    ?>
                </li>
            <?php
            }
            ?>

        

    </ul>
</div>


<?= $this->Form->create($noteSheetEntry,['class' => 'form-horizontal','role'=>'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Edit Note Sheet Entry') ?>
        </h6></div>
    <div class="panel-body col-sm-6">
        <?php
                            echo $this->Form->input('scheme_id', ['options' => $schemes]);
                                    echo $this->Form->input('entry_serial_no');
                                    echo $this->Form->input('attachments');
                                    echo $this->Form->input('approval_sequence');
                                    echo $this->Form->input('approval_status');
                                echo $this->Form->input('status', ['options' => Configure::read('status_options')]);
                        ?>
    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="Save" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

