<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Chapters'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Chapter') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Chapters'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Chapter'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['edit'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('Edit Chapter'), ['action' => 'edit', $chapter->id]) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['delete'] == 1)
        {
            ?>
            <li><?= $this->Form->postLink(__('Delete Chapter'), ['action' => 'delete', $chapter->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $chapter->id)]) ?>
            </li>
        <?php
        }
        ?>

        <li class="active"><?= $this->Html->link(__('Details Chapter'), ['action' => 'view', $chapter->id
            ]) ?>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-6">
        
                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Chapter Code') ?></h6></div>
                        <div class="panel-body"><?= h($chapter->chapter_code) ?></div>
                    </div>
                                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Name') ?></h6></div>
                        <div class="panel-body"><?= h($chapter->name) ?></div>
                    </div>
                                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Created User') ?></h6>
                        </div>
                        <div class="panel-body"><?= $chapter->has('created_user') ?
                            $this->Html->link($chapter->created_user
                            ->name_en, ['controller' => 'Users',
                            'action' => 'view', $chapter->created_user
                            ->id]) : '' ?>
                        </div>
                    </div>
                                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Updated User') ?></h6>
                        </div>
                        <div class="panel-body"><?= $chapter->has('updated_user') ?
                            $this->Html->link($chapter->updated_user
                            ->name_en, ['controller' => 'Users',
                            'action' => 'view', $chapter->updated_user
                            ->id]) : '' ?>
                        </div>
                    </div>
                                                                        <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Id') ?></h6></div>
                                            <div class="panel-body"><?= $this->Number->format($chapter->id) ?></div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Parent') ?></h6></div>
                                            <div class="panel-body"><?= $this->Number->format($chapter->parent) ?></div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Created Date') ?></h6></div>
                                            <div class="panel-body"><?= $this->System->display_date_time($chapter->created_date)
                            ?>
                        </div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Updated Date') ?></h6></div>
                                            <div class="panel-body"><?= $this->System->display_date_time($chapter->updated_date)
                            ?>
                        </div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Status') ?></h6></div>
                                            <?php
                        if ($chapter->status==1)
                        {
                        ?>
                        <div class="panel-body"><?= __('Active') ?></div>
                    <?php
                    }
                    elseif ($chapter->status==0)
                    {
                    ?>
                    <div class="panel-body"><?= __('In-Active') ?></div>
                    <?php
                    }
                    else
                    {
                        ?>
                        <div class="panel-body"><?php echo $chapter->status;?></div>
                    <?php

                    }
                    ?>
                                    </div>
                                </div>
</div>