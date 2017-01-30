<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Packages'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Package') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Packages'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Package'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['edit'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('Edit Package'), ['action' => 'edit', $package->id]) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['delete'] == 1)
        {
            ?>
            <li><?= $this->Form->postLink(__('Delete Package'), ['action' => 'delete', $package->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $package->id)]) ?>
            </li>
        <?php
        }
        ?>

        <li class="active"><?= $this->Html->link(__('Details Package'), ['action' => 'view', $package->id
            ]) ?>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-6">
        
                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Name En') ?></h6></div>
                        <div class="panel-body"><?= h($package->name_en) ?></div>
                    </div>
                                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Name Bn') ?></h6></div>
                        <div class="panel-body"><?= h($package->name_bn) ?></div>
                    </div>
                                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Created User') ?></h6>
                        </div>
                        <div class="panel-body"><?= $package->has('created_user') ?
                            $this->Html->link($package->created_user
                            ->name_en, ['controller' => 'Users',
                            'action' => 'view', $package->created_user
                            ->id]) : '' ?>
                        </div>
                    </div>
                                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Updated User') ?></h6>
                        </div>
                        <div class="panel-body"><?= $package->has('updated_user') ?
                            $this->Html->link($package->updated_user
                            ->name_en, ['controller' => 'Users',
                            'action' => 'view', $package->updated_user
                            ->id]) : '' ?>
                        </div>
                    </div>
                                                                        <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Id') ?></h6></div>
                                            <div class="panel-body"><?= $this->Number->format($package->id) ?></div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Created Date') ?></h6></div>
                                            <div class="panel-body"><?= $this->System->display_date_time($package->created_date)
                            ?>
                        </div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Updated Date') ?></h6></div>
                                            <div class="panel-body"><?= $this->System->display_date_time($package->updated_date)
                            ?>
                        </div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Status') ?></h6></div>
                                            <?php
                        if ($package->status==1)
                        {
                        ?>
                        <div class="panel-body">Active</div>
                    <?php
                    }
                    elseif ($package->status==0)
                    {
                    ?>
                    <div class="panel-body">In-Active</div>
                    <?php
                    }
                    else
                    {
                        ?>
                        <div class="panel-body"><?php echo $package->status;?></div>
                    <?php

                    }
                    ?>
                                    </div>
                                </div>
</div>