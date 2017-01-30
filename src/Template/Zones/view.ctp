<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Zones'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Zone') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Zones'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Zone'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['edit'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('Edit Zone'), ['action' => 'edit', $zone->id]) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['delete'] == 1)
        {
            ?>
            <li><?= $this->Form->postLink(__('Delete Zone'), ['action' => 'delete', $zone->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $zone->id)]) ?>
            </li>
        <?php
        }
        ?>

        <li class="active"><?= $this->Html->link(__('Details Zone'), ['action' => 'view', $zone->id
            ]) ?>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-6">
        
                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Division') ?></h6>
                        </div>
                        <div class="panel-body"><?= $zone->has('division') ?
                            $this->Html->link($zone->division
                            ->name_en, ['controller' => 'Divisions',
                            'action' => 'view', $zone->division
                            ->id]) : '' ?>
                        </div>
                    </div>
                                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Name En') ?></h6></div>
                        <div class="panel-body"><?= h($zone->name_en) ?></div>
                    </div>
                                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Name Bn') ?></h6></div>
                        <div class="panel-body"><?= h($zone->name_bn) ?></div>
                    </div>
                                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Created User') ?></h6>
                        </div>
                        <div class="panel-body"><?= $zone->has('created_user') ?
                            $this->Html->link($zone->created_user
                            ->name_en, ['controller' => 'Users',
                            'action' => 'view', $zone->created_user
                            ->id]) : '' ?>
                        </div>
                    </div>
                                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Updated User') ?></h6>
                        </div>
                        <div class="panel-body"><?= $zone->has('updated_user') ?
                            $this->Html->link($zone->updated_user
                            ->name_en, ['controller' => 'Users',
                            'action' => 'view', $zone->updated_user
                            ->id]) : '' ?>
                        </div>
                    </div>
                                                                        <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Id') ?></h6></div>
                                            <div class="panel-body"><?= $this->Number->format($zone->id) ?></div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Created Date') ?></h6></div>
                                            <div class="panel-body"><?= $this->System->display_date_time($zone->created_date)
                            ?>
                        </div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Updated Date') ?></h6></div>
                                            <div class="panel-body"><?= $this->System->display_date_time($zone->updated_date)
                            ?>
                        </div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Status') ?></h6></div>
                                            <?php
                        if ($zone->status==1)
                        {
                        ?>
                        <div class="panel-body"><?= __('Active') ?></div>
                    <?php
                    }
                    elseif ($zone->status==0)
                    {
                    ?>
                    <div class="panel-body"><?= __('In-Active') ?></div>
                    <?php
                    }
                    else
                    {
                        ?>
                        <div class="panel-body"><?php echo $zone->status;?></div>
                    <?php

                    }
                    ?>
                                    </div>
                                </div>
</div>