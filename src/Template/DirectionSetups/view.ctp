<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Direction Setups'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Direction Setup') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Direction Setups'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Direction Setup'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['edit'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('Edit Direction Setup'), ['action' => 'edit', $directionSetup->id]) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['delete'] == 1)
        {
            ?>
            <li><?= $this->Form->postLink(__('Delete Direction Setup'), ['action' => 'delete', $directionSetup->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $directionSetup->id)]) ?>
            </li>
        <?php
        }
        ?>

        <li class="active"><?= $this->Html->link(__('Details Direction Setup'), ['action' => 'view', $directionSetup->id
            ]) ?>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-6">
        
                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Title') ?></h6></div>
                        <div class="panel-body"><?= h($directionSetup->title) ?></div>
                    </div>
                                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Created User') ?></h6>
                        </div>
                        <div class="panel-body"><?= $directionSetup->has('created_user') ?
                            $this->Html->link($directionSetup->created_user
                            ->name_en, ['controller' => 'Users',
                            'action' => 'view', $directionSetup->created_user
                            ->id]) : '' ?>
                        </div>
                    </div>
                                                                        <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Id') ?></h6></div>
                                            <div class="panel-body"><?= $this->Number->format($directionSetup->id) ?></div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Created Date') ?></h6></div>
                                            <div class="panel-body"><?= $this->System->display_date_time($directionSetup->created_date)
                            ?>
                        </div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Status') ?></h6></div>
                                            <?php
                        if ($directionSetup->status==1)
                        {
                        ?>
                        <div class="panel-body"><?= __('Active') ?></div>
                    <?php
                    }
                    elseif ($directionSetup->status==0)
                    {
                    ?>
                    <div class="panel-body"><?= __('In-Active') ?></div>
                    <?php
                    }
                    else
                    {
                        ?>
                        <div class="panel-body"><?php echo $directionSetup->status;?></div>
                    <?php

                    }
                    ?>
                                    </div>
                                </div>
</div>