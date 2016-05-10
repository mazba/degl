<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Guard Duty Shifts'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Guard Duty Shift') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Guard Duty Shifts'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Guard Duty Shift'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['edit'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('Edit Guard Duty Shift'), ['action' => 'edit', $guardDutyShift->id]) ?></li>
        <?php
        }
        ?>
        <li class="active"><?=
            $this->Html->link(__('Details Guard Duty Shift'), ['action' => 'view', $guardDutyShift->id
            ]) ?>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-6">

        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Name') ?></h6></div>
            <div class="panel-body"><?= h($guardDutyShift->name) ?></div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Id') ?></h6></div>
            <div class="panel-body"><?= $this->Number->format($guardDutyShift->id) ?></div>
        </div>
    </div>
    <div class="col-md-6">

        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Start Time') ?></h6></div>
            <div class="panel-body"><?= ($guardDutyShift->start_time) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('End Time') ?></h6></div>
            <div class="panel-body"><?= ($guardDutyShift->end_time) ?></div>
        </div>

    </div>
</div>