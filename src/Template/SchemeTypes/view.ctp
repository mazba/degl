<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Scheme Types'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Scheme Type') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Scheme Types'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Scheme Type'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['edit'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('Edit Scheme Type'), ['action' => 'edit', $schemeType->id]) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['delete'] == 1)
        {
            ?>
            <li><?= $this->Form->postLink(__('Delete Scheme Type'), ['action' => 'delete', $schemeType->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $schemeType->id)]) ?>
            </li>
        <?php
        }
        ?>

        <li class="active"><?= $this->Html->link(__('Details Scheme Type'), ['action' => 'view', $schemeType->id
            ]) ?>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-6">
        
                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Title') ?></h6></div>
                        <div class="panel-body"><?= h($schemeType->title) ?></div>
                    </div>
                                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Updated User') ?></h6>
                        </div>
                        <div class="panel-body"><?= $schemeType->has('updated_user') ?
                            $this->Html->link($schemeType->updated_user
                            ->name_en, ['controller' => 'Users',
                            'action' => 'view', $schemeType->updated_user
                            ->id]) : '' ?>
                        </div>
                    </div>
                                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Created User') ?></h6>
                        </div>
                        <div class="panel-body"><?= $schemeType->has('created_user') ?
                            $this->Html->link($schemeType->created_user
                            ->name_en, ['controller' => 'Users',
                            'action' => 'view', $schemeType->created_user
                            ->id]) : '' ?>
                        </div>
                    </div>
                                                                        <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Id') ?></h6></div>
                                            <div class="panel-body"><?= $this->Number->format($schemeType->id) ?></div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Status') ?></h6></div>
                                            <?php
                        if ($schemeType->status==1)
                        {
                        ?>
                        <div class="panel-body">Active</div>
                    <?php
                    }
                    elseif ($schemeType->status==0)
                    {
                    ?>
                    <div class="panel-body">In-Active</div>
                    <?php
                    }
                    else
                    {
                        ?>
                        <div class="panel-body"><?php echo $schemeType->status;?></div>
                    <?php

                    }
                    ?>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Updated Date') ?></h6></div>
                                            <div class="panel-body"><?= $this->System->display_date_time($schemeType->updated_date)
                            ?>
                        </div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Created Date') ?></h6></div>
                                            <div class="panel-body"><?= $this->System->display_date_time($schemeType->created_date)
                            ?>
                        </div>
                                    </div>
                                </div>
</div>