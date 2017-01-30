<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Financial Year Estimates'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Financial Year Estimate') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Financial Year Estimates'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Financial Year Estimate'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['edit'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('Edit Financial Year Estimate'), ['action' => 'edit', $financialYearEstimate->id]) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['delete'] == 1)
        {
            ?>
            <li><?=
                $this->Form->postLink(__('Delete Financial Year Estimate'), ['action' => 'delete', $financialYearEstimate->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $financialYearEstimate->id)]) ?>
            </li>
        <?php
        }
        ?>

        <li class="active"><?=
            $this->Html->link(__('Details Financial Year Estimate'), ['action' => 'view', $financialYearEstimate->id
            ]) ?>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-6">

        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Name') ?></h6></div>
            <div class="panel-body"><?= h($financialYearEstimate->name) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Created User') ?></h6>
            </div>
            <div class="panel-body"><?=
                $financialYearEstimate->has('created_user') ?
                    $this->Html->link($financialYearEstimate->created_user
                        ->name_en, ['controller' => 'Users',
                        'action' => 'view', $financialYearEstimate->created_user
                            ->id]) : '' ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Updated User') ?></h6>
            </div>
            <div class="panel-body"><?=
                $financialYearEstimate->has('updated_user') ?
                    $this->Html->link($financialYearEstimate->updated_user
                        ->name_en, ['controller' => 'Users',
                        'action' => 'view', $financialYearEstimate->updated_user
                            ->id]) : '' ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Id') ?></h6></div>
            <div class="panel-body"><?= $this->Number->format($financialYearEstimate->id) ?></div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Created Date') ?></h6></div>
            <div class="panel-body"><?=
                $this->System->display_date_time($financialYearEstimate->created_date)
                ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Updated Date') ?></h6></div>
            <div class="panel-body"><?=
                $this->System->display_date_time($financialYearEstimate->updated_date)
                ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Status') ?></h6></div>
            <?php
            if ($financialYearEstimate->status == 1)
            {
                ?>
                <div class="panel-body"><?= __('Active') ?></div>
            <?php
            }
            elseif ($financialYearEstimate->status == 0)
            {
                ?>
                <div class="panel-body"><?= __('In-Active') ?></div>
            <?php
            }
            else
            {
                ?>
                <div class="panel-body"><?php echo $financialYearEstimate->status; ?></div>
            <?php

            }
            ?>
        </div>
    </div>
</div>