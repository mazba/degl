<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>">Dashboard</a></li>
        <li><?= $this->Html->link(__('Entry Definitions'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Entry Definition') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Entry Definitions'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1) {
            ?>
            <li><?= $this->Html->link(__('New Entry Definition'), ['action' => 'add']) ?></li>
            <?php
        }
        ?>


        <?php
        if ($user_roles['delete'] == 1) {
            ?>
            <li><?= $this->Form->postLink(__('Delete Entry Definition'), ['action' => 'delete', $entryDefinition->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $entryDefinition->id)]) ?>
            </li>
            <?php
        }
        ?>

        <li class="active"><?= $this->Html->link(__('Details Entry Definition'), ['action' => 'view', $entryDefinition->id
            ]) ?>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Name') ?></h6></div>
            <div class="panel-body"><?= h($entryDefinition->name) ?></div>
        </div>
        <div class="col-sm-6">

            <div class="panel panel-default">
                <div class="panel-heading"><h6
                        class="panel-title"><?= __('View Scope') ?></h6></div>
                <div class="panel-body">
                    <?php foreach($view_scope as $row){
                        echo $row." , ";
                    }?>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading"><h6
                        class="panel-title"><?= __('Attachments') ?></h6></div>
                <div class="panel-body"><?php foreach($attachments as $row){
                        echo $row.' , ';
                    } ?>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading"><h6
                        class="panel-title"><?= __('Creation Permission') ?></h6></div>
                <div class="panel-body"><?php foreach($creation_permission as $row){
                        echo $row.' , ';
                    } ?>
                </div>
            </div>

            </div>
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading"><h6
                        class="panel-title"><?= __('Approval Sequence') ?></h6></div>
                <div class="panel-body"><?php foreach($approval_sequence as $row){
                        echo $row.' , ';
                    } ?>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading"><h6
                        class="panel-title"><?= __('Preconditions') ?></h6></div>
                <div class="panel-body"><?php foreach($preconditions as $row){
                        echo $row.' , ';
                    }?>
                </div>
            </div>

        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Status') ?></h6></div>
            <?php
            if ($entryDefinition->status == 1) {
                ?>
                <div class="panel-body">Active</div>
                <?php
            } elseif ($entryDefinition->status == 0) {
                ?>
                <div class="panel-body">In-Active</div>
                <?php
            } else {
                ?>
                <div class="panel-body"><?php echo $entryDefinition->status; ?></div>
                <?php

            }
            ?>
        </div>

    </div>
</div>