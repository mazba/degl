<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Divisions'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Division') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Divisions'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Division'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['edit'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('Edit Division'), ['action' => 'edit', $division->id]) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['delete'] == 1)
        {
            ?>
            <li><?= $this->Form->postLink(__('Delete Division'), ['action' => 'delete', $division->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $division->id)]) ?>
            </li>
        <?php
        }
        ?>

        <li class="active"><?= $this->Html->link(__('Details Division'), ['action' => 'view', $division->id
            ]) ?>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-6">
        
                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Id') ?></h6></div>
                        <div class="panel-body"><?= h($division->id) ?></div>
                    </div>
                                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Name En') ?></h6></div>
                        <div class="panel-body"><?= h($division->name_en) ?></div>
                    </div>
                                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Name Bn') ?></h6></div>
                        <div class="panel-body"><?= h($division->name_bn) ?></div>
                    </div>
                                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Created User') ?></h6>
                        </div>
                        <div class="panel-body"><?= $division->has('created_user') ?
                            $this->Html->link($division->created_user
                            ->name_en, ['controller' => 'Users',
                            'action' => 'view', $division->created_user
                            ->id]) : '' ?>
                        </div>
                    </div>
                                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Updated User') ?></h6>
                        </div>
                        <div class="panel-body"><?= $division->has('updated_user') ?
                            $this->Html->link($division->updated_user
                            ->name_en, ['controller' => 'Users',
                            'action' => 'view', $division->updated_user
                            ->id]) : '' ?>
                        </div>
                    </div>
                                                                        <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Created Date') ?></h6></div>
                                            <div class="panel-body"><?= $this->System->display_date_time($division->created_date)
                            ?>
                        </div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Updated Date') ?></h6></div>
                                            <div class="panel-body"><?= $this->System->display_date_time($division->updated_date)
                            ?>
                        </div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Status') ?></h6></div>
                                            <?php
                        if ($division->status==1)
                        {
                        ?>
                        <div class="panel-body"><?= __('Active') ?></div>
                    <?php
                    }
                    elseif ($division->status==0)
                    {
                    ?>
                    <div class="panel-body"><?= __('In-Active') ?></div>
                    <?php
                    }
                    else
                    {
                        ?>
                        <div class="panel-body"><?php echo $division->status;?></div>
                    <?php

                    }
                    ?>
                                    </div>
                                </div>
</div>