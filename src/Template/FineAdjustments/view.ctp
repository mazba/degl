<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>">Dashboard</a></li>
        <li><?= $this->Html->link(__('Fine Adjustments'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Fine Adjustment') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Fine Adjustments'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Fine Adjustment'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['edit'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('Edit Fine Adjustment'), ['action' => 'edit', $fineAdjustment->id]) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['delete'] == 1)
        {
            ?>
            <li><?= $this->Form->postLink(__('Delete Fine Adjustment'), ['action' => 'delete', $fineAdjustment->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $fineAdjustment->id)]) ?>
            </li>
        <?php
        }
        ?>

        <li class="active"><?= $this->Html->link(__('Details Fine Adjustment'), ['action' => 'view', $fineAdjustment->id
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
                        <div class="panel-body"><?= $fineAdjustment->has('scheme') ?
                            $this->Html->link($fineAdjustment->scheme
                            ->name_en, ['controller' => 'Schemes',
                            'action' => 'view', $fineAdjustment->scheme
                            ->id]) : '' ?>
                        </div>
                    </div>
                                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Economic Code') ?></h6></div>
                        <div class="panel-body"><?= h($fineAdjustment->economic_code) ?></div>
                    </div>
                                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Created User') ?></h6>
                        </div>
                        <div class="panel-body"><?= $fineAdjustment->has('created_user') ?
                            $this->Html->link($fineAdjustment->created_user
                            ->name_en, ['controller' => 'Users',
                            'action' => 'view', $fineAdjustment->created_user
                            ->id]) : '' ?>
                        </div>
                    </div>
                                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Updated User') ?></h6>
                        </div>
                        <div class="panel-body"><?= $fineAdjustment->has('updated_user') ?
                            $this->Html->link($fineAdjustment->updated_user
                            ->name_en, ['controller' => 'Users',
                            'action' => 'view', $fineAdjustment->updated_user
                            ->id]) : '' ?>
                        </div>
                    </div>
                                                                        <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Id') ?></h6></div>
                                            <div class="panel-body"><?= $this->Number->format($fineAdjustment->id) ?></div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Adjusted Amount') ?></h6></div>
                                            <div class="panel-body"><?= $this->Number->format($fineAdjustment->adjusted_amount) ?></div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Created Dayte') ?></h6></div>
                                            <div class="panel-body"><?= $this->Number->format($fineAdjustment->created_dayte) ?></div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Updated Date') ?></h6></div>
                                            <div class="panel-body"><?= $this->System->display_date_time($fineAdjustment->updated_date)
                            ?>
                        </div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Status') ?></h6></div>
                                            <?php
                        if ($fineAdjustment->status==1)
                        {
                        ?>
                        <div class="panel-body">Active</div>
                    <?php
                    }
                    elseif ($fineAdjustment->status==0)
                    {
                    ?>
                    <div class="panel-body">In-Active</div>
                    <?php
                    }
                    else
                    {
                        ?>
                        <div class="panel-body"><?php echo $fineAdjustment->status;?></div>
                    <?php

                    }
                    ?>
                                    </div>
                                                        <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Reason') ?></h6></div>
                    <div class="panel-body"><?= $this->Text->autoParagraph(h($fineAdjustment->reason)); ?>
                    </div>
                </div>
                        </div>
</div>