<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Guard Duties'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Guard Duty') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Guard Duties'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Guard Duty'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['edit'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('Edit Guard Duty'), ['action' => 'edit', $guardDuty->id]) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['delete'] == 1)
        {
            ?>
            <li><?=
                $this->Form->postLink(__('Delete Guard Duty'), ['action' => 'delete', $guardDuty->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $guardDuty->id)]) ?>
            </li>
        <?php
        }
        ?>

        <li class="active"><?=
            $this->Html->link(__('Details Guard Duty'), ['action' => 'view', $guardDuty->id
            ]) ?>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Guard') ?></h6>
            </div>
            <div class="panel-body"><?=
                $guardDuty->has('employee') ?$guardDuty->employee
                    ->name_en: '' ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Guard Duty Shift') ?></h6>
            </div>
            <div class="panel-body"><?=
                $guardDuty->has('guard_duty_shift') ?$guardDuty->guard_duty_shift
                    ->start_time.'-'.$guardDuty->guard_duty_shift
                        ->end_time : '' ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Duty date') ?></h6></div>
            <div class="panel-body"><?= $this->System->display_date($guardDuty->duty_date)
                ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Location') ?></h6></div>
            <div class="panel-body"><?= h($guardDuty->location) ?></div>
        </div>

    </div>
</div>