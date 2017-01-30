<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Projects'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Project') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Projects'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Project'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['edit'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('Edit Project'), ['action' => 'edit', $project->id]) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['delete'] == 1)
        {
            ?>
            <li><?=
                $this->Form->postLink(__('Delete Project'), ['action' => 'delete', $project->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $project->id)]) ?>
            </li>
        <?php
        }
        ?>

        <li class="active"><?=
            $this->Html->link(__('Details Project'), ['action' => 'view', $project->id
            ]) ?>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-6">

        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Short Code') ?></h6></div>
            <div class="panel-body"><?= h($project->short_code) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Name En') ?></h6></div>
            <div class="panel-body"><?= h($project->name_en) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Name Bn') ?></h6></div>
            <div class="panel-body"><?= h($project->name_bn) ?></div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Development Partner') ?></h6>
            </div>
            <div class="panel-body"><?=
                $project->has('development_partner') ?
                    $this->Html->link($project->development_partner
                        ->name_en, ['controller' => 'DevelopmentPartners',
                        'action' => 'view', $project->development_partner
                            ->id]) : '' ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Created User') ?></h6>
            </div>
            <div class="panel-body"><?=
                $project->has('created_user') ?
                    $this->Html->link($project->created_user
                        ->name_en, ['controller' => 'Users',
                        'action' => 'view', $project->created_user
                            ->id]) : '' ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Updated User') ?></h6>
            </div>
            <div class="panel-body"><?=
                $project->has('updated_user') ?
                    $this->Html->link($project->updated_user
                        ->name_en, ['controller' => 'Users',
                        'action' => 'view', $project->updated_user
                            ->id]) : '' ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Id') ?></h6></div>
            <div class="panel-body"><?= $this->Number->format($project->id) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Economic Head') ?></h6></div>
            <div class="panel-body"><?= h($project->economic_head) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Sector') ?></h6></div>
            <div class="panel-body"><?= h($project->sector['name_bn']) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Created Date') ?></h6></div>
            <div class="panel-body"><?=
                $this->System->display_date_time($project->created_date)
                ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Updated Date') ?></h6></div>
            <div class="panel-body"><?=
                $this->System->display_date_time($project->updated_date)
                ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Ordering') ?></h6></div>
            <div class="panel-body"><?= $this->Number->format($project->ordering) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Status') ?></h6></div>
            <?php
            if ($project->status == 1)
            {
                ?>
                <div class="panel-body"><?= __('Active') ?></div>
            <?php
            }
            elseif ($project->status == 0)
            {
                ?>
                <div class="panel-body"><?= __('In-Active') ?></div>
            <?php
            }
            else
            {
                ?>
                <div class="panel-body"><?php echo $project->status; ?></div>
            <?php

            }
            ?>
        </div>
    </div>
</div>