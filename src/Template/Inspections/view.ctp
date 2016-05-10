<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>">Dashboard</a></li>
        <li><?= $this->Html->link(__('Inspections'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Inspection') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Inspections'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1) {
            ?>
            <li><?= $this->Html->link(__('New Inspection'), ['action' => 'add']) ?></li>
            <?php
        }
        ?>
        <?php
        if ($user_roles['edit'] == 1) {
            ?>
            <li><?= $this->Html->link(__('Edit Inspection'), ['action' => 'edit', $inspection->id]) ?></li>
            <?php
        }
        ?>
        <?php
        if ($user_roles['delete'] == 1) {
            ?>
            <li><?= $this->Form->postLink(__('Delete Inspection'), ['action' => 'delete', $inspection->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $inspection->id)]) ?>
            </li>
            <?php
        }
        ?>

        <li class="active"><?= $this->Html->link(__('Details Inspection'), ['action' => 'view', $inspection->id
            ]) ?>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-6">

        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Financial Year Estimate') ?></h6>
            </div>
            <div class="panel-body"><?= $inspection->has('financial_year_estimate') ?
                    $this->Html->link($inspection->financial_year_estimate
                        ->name, ['controller' => 'FinancialYearEstimates',
                        'action' => 'view', $inspection->financial_year_estimate
                            ->id]) : '' ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Inspected Team') ?></h6>
            </div>
            <div class="panel-body"><?= $inspection->has('inspected_team') ?
                    $this->Html->link($inspection->inspected_team
                        ->id, ['controller' => 'InspectedTeams',
                        'action' => 'view', $inspection->inspected_team
                            ->id]) : '' ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Created User') ?></h6>
            </div>
            <div class="panel-body"><?= $inspection->has('created_user') ?
                    $this->Html->link($inspection->created_user
                        ->name_en, ['controller' => 'Users',
                        'action' => 'view', $inspection->created_user
                            ->id]) : '' ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Updated User') ?></h6>
            </div>
            <div class="panel-body"><?= $inspection->has('updated_user') ?
                    $this->Html->link($inspection->updated_user
                        ->name_en, ['controller' => 'Users',
                        'action' => 'view', $inspection->updated_user
                            ->id]) : '' ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Id') ?></h6></div>
            <div class="panel-body"><?= $this->Number->format($inspection->id) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Status') ?></h6></div>
            <?php
            if ($inspection->status == 1) {
                ?>
                <div class="panel-body">Active</div>
                <?php
            } elseif ($inspection->status == 0) {
                ?>
                <div class="panel-body">In-Active</div>
                <?php
            } else {
                ?>
                <div class="panel-body"><?php echo $inspection->status; ?></div>
                <?php

            }
            ?>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Created Date') ?></h6></div>
            <div class="panel-body"><?= $this->System->display_date_time($inspection->created_date)
                ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Updated Date') ?></h6></div>
            <div class="panel-body"><?= $this->System->display_date_time($inspection->updated_date)
                ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Remarks') ?></h6></div>
            <div class="panel-body"><?= $this->Text->autoParagraph(h($inspection->remarks)); ?>
            </div>
        </div>
    </div>
</div>