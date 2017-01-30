<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>">Dashboard</a></li>
        <li><?= $this->Html->link(__('Assets'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Asset') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Assets'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Asset'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['edit'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('Edit Asset'), ['action' => 'edit', $asset->id]) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['delete'] == 1)
        {
            ?>
            <li><?= $this->Form->postLink(__('Delete Asset'), ['action' => 'delete', $asset->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $asset->id)]) ?>
            </li>
        <?php
        }
        ?>

        <li class="active"><?= $this->Html->link(__('Details Asset'), ['action' => 'view', $asset->id
            ]) ?>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-6">
        
                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Name') ?></h6></div>
                        <div class="panel-body"><?= h($asset->name) ?></div>
                    </div>
                                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Asset Code') ?></h6></div>
                        <div class="panel-body"><?= h($asset->asset_code) ?></div>
                    </div>
                                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Created User') ?></h6>
                        </div>
                        <div class="panel-body"><?= $asset->has('created_user') ?
                            $this->Html->link($asset->created_user
                            ->name_en, ['controller' => 'Users',
                            'action' => 'view', $asset->created_user
                            ->id]) : '' ?>
                        </div>
                    </div>
                                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Updated User') ?></h6>
                        </div>
                        <div class="panel-body"><?= $asset->has('updated_user') ?
                            $this->Html->link($asset->updated_user
                            ->name_en, ['controller' => 'Users',
                            'action' => 'view', $asset->updated_user
                            ->id]) : '' ?>
                        </div>
                    </div>
                                                                        <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Id') ?></h6></div>
                                            <div class="panel-body"><?= $this->Number->format($asset->id) ?></div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Quantity') ?></h6></div>
                                            <div class="panel-body"><?= $this->Number->format($asset->quantity) ?></div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Created Date') ?></h6></div>
                                            <div class="panel-body"><?= $this->System->display_date_time($asset->created_date)
                            ?>
                        </div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Updated Date') ?></h6></div>
                                            <div class="panel-body"><?= $this->System->display_date_time($asset->updated_date)
                            ?>
                        </div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Status') ?></h6></div>
                                            <?php
                        if ($asset->status==1)
                        {
                        ?>
                        <div class="panel-body">Active</div>
                    <?php
                    }
                    elseif ($asset->status==0)
                    {
                    ?>
                    <div class="panel-body">In-Active</div>
                    <?php
                    }
                    else
                    {
                        ?>
                        <div class="panel-body"><?php echo $asset->status;?></div>
                    <?php

                    }
                    ?>
                                    </div>
                                                        <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Description') ?></h6></div>
                    <div class="panel-body"><?= $this->Text->autoParagraph(h($asset->description)); ?>
                    </div>
                </div>
                        </div>
</div>