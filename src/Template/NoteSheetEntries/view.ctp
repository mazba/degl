<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>">Dashboard</a></li>
        <li><?= $this->Html->link(__('Note Sheet Entries'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Note Sheet Entry') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Note Sheet Entries'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Note Sheet Entry'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['edit'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('Edit Note Sheet Entry'), ['action' => 'edit', $noteSheetEntry->id]) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['delete'] == 1)
        {
            ?>
            <li><?= $this->Form->postLink(__('Delete Note Sheet Entry'), ['action' => 'delete', $noteSheetEntry->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $noteSheetEntry->id)]) ?>
            </li>
        <?php
        }
        ?>

        <li class="active"><?= $this->Html->link(__('Details Note Sheet Entry'), ['action' => 'view', $noteSheetEntry->id
            ]) ?>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-6">
        
                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Scheme') ?></h6>
                        </div>
                        <div class="panel-body"><?= $noteSheetEntry->has('scheme') ?
                            $this->Html->link($noteSheetEntry->scheme
                            ->name_en, ['controller' => 'Schemes',
                            'action' => 'view', $noteSheetEntry->scheme
                            ->id]) : '' ?>
                        </div>
                    </div>
                                                                        <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Id') ?></h6></div>
                                            <div class="panel-body"><?= $this->Number->format($noteSheetEntry->id) ?></div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Entry Serial No') ?></h6></div>
                                            <div class="panel-body"><?= $this->Number->format($noteSheetEntry->entry_serial_no) ?></div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Approval Status') ?></h6></div>
                                            <div class="panel-body"><?= $this->Number->format($noteSheetEntry->approval_status) ?></div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Created By') ?></h6></div>
                                            <div class="panel-body"><?= $this->System->display_date_time($noteSheetEntry->created_by)
                            ?>
                        </div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Created Date') ?></h6></div>
                                            <div class="panel-body"><?= $this->System->display_date_time($noteSheetEntry->created_date)
                            ?>
                        </div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Updated By') ?></h6></div>
                                            <div class="panel-body"><?= $this->System->display_date_time($noteSheetEntry->updated_by)
                            ?>
                        </div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Updated Date') ?></h6></div>
                                            <div class="panel-body"><?= $this->System->display_date_time($noteSheetEntry->updated_date)
                            ?>
                        </div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Status') ?></h6></div>
                                            <?php
                        if ($noteSheetEntry->status==1)
                        {
                        ?>
                        <div class="panel-body">Active</div>
                    <?php
                    }
                    elseif ($noteSheetEntry->status==0)
                    {
                    ?>
                    <div class="panel-body">In-Active</div>
                    <?php
                    }
                    else
                    {
                        ?>
                        <div class="panel-body"><?php echo $noteSheetEntry->status;?></div>
                    <?php

                    }
                    ?>
                                    </div>
                                                        <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Attachments') ?></h6></div>
                    <div class="panel-body"><?= $this->Text->autoParagraph(h($noteSheetEntry->attachments)); ?>
                    </div>
                </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Approval Sequence') ?></h6></div>
                    <div class="panel-body"><?= $this->Text->autoParagraph(h($noteSheetEntry->approval_sequence)); ?>
                    </div>
                </div>
                        </div>
</div>