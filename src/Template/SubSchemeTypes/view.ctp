<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>">Dashboard</a></li>
        <li><?= $this->Html->link(__('Sub Scheme Types'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Sub Scheme Type') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Sub Scheme Types'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Sub Scheme Type'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['edit'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('Edit Sub Scheme Type'), ['action' => 'edit', $subSchemeType->id]) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['delete'] == 1)
        {
            ?>
            <li><?= $this->Form->postLink(__('Delete Sub Scheme Type'), ['action' => 'delete', $subSchemeType->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $subSchemeType->id)]) ?>
            </li>
        <?php
        }
        ?>

        <li class="active"><?= $this->Html->link(__('Details Sub Scheme Type'), ['action' => 'view', $subSchemeType->id
            ]) ?>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-6">
        
                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Scheme Type') ?></h6>
                        </div>
                        <div class="panel-body"><?= $subSchemeType->has('scheme_type') ?
                            $this->Html->link($subSchemeType->scheme_type
                            ->title, ['controller' => 'SchemeTypes',
                            'action' => 'view', $subSchemeType->scheme_type
                            ->id]) : '' ?>
                        </div>
                    </div>
                                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Title') ?></h6></div>
                        <div class="panel-body"><?= h($subSchemeType->title) ?></div>
                    </div>
                                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Created User') ?></h6>
                        </div>
                        <div class="panel-body"><?= $subSchemeType->has('created_user') ?
                            $this->Html->link($subSchemeType->created_user
                            ->name_en, ['controller' => 'Users',
                            'action' => 'view', $subSchemeType->created_user
                            ->id]) : '' ?>
                        </div>
                    </div>
                                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Updated User') ?></h6>
                        </div>
                        <div class="panel-body"><?= $subSchemeType->has('updated_user') ?
                            $this->Html->link($subSchemeType->updated_user
                            ->name_en, ['controller' => 'Users',
                            'action' => 'view', $subSchemeType->updated_user
                            ->id]) : '' ?>
                        </div>
                    </div>
                                                                        <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Id') ?></h6></div>
                                            <div class="panel-body"><?= $this->Number->format($subSchemeType->id) ?></div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Status') ?></h6></div>
                                            <?php
                        if ($subSchemeType->status==1)
                        {
                        ?>
                        <div class="panel-body">Active</div>
                    <?php
                    }
                    elseif ($subSchemeType->status==0)
                    {
                    ?>
                    <div class="panel-body">In-Active</div>
                    <?php
                    }
                    else
                    {
                        ?>
                        <div class="panel-body"><?php echo $subSchemeType->status;?></div>
                    <?php

                    }
                    ?>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Updated Date') ?></h6></div>
                                            <div class="panel-body"><?= $this->System->display_date_time($subSchemeType->updated_date)
                            ?>
                        </div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Created Date') ?></h6></div>
                                            <div class="panel-body"><?= $this->System->display_date_time($subSchemeType->created_date)
                            ?>
                        </div>
                                    </div>
                                </div>
</div>