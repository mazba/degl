<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Task Management'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Task Management') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Task Management'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1) {
            ?>
            <li><?= $this->Html->link(__('New Task Management'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['edit'] == 1) {
            ?>
            <li><?= $this->Html->link(__('Edit Task Management'), ['action' => 'edit', $taskManagement->id]) ?></li>
        <?php
        }
        ?>
        <li class="active"><?=
            $this->Html->link(__('Details Task Management'), ['action' => 'view', $taskManagement->id
            ]) ?>
        </li>
    </ul>
</div>
<div class="panel panel-info">
    <div class="panel-heading">
        <h6 class="panel-title"><i class="icon-meter-fast"></i> <?= __('Task') ?> </h6>
    </div>
    <div class="panel-body">
        <div class="col-md-6">
            <div class="form-group">
                <label><?= __('Type') ?></label>
                <input value="<?php echo $taskManagement->type; ?>" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><?= __('Media Type') ?></label>
                <input value="<?php echo $taskManagement->media_type; ?>" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><?= __('Title') ?></label>
                <input value="<?php echo $taskManagement->title; ?>" class="form-control" type="text" disabled>
            </div>
        </div>
        <?php
        if($taskManagement->type == 'Appointment')
        {
            ?>
            <div class="col-md-6">
                <div class="form-group">
                    <label><?= __('Person Name') ?></label>
                    <input value="<?php echo $taskManagement->name; ?>" class="form-control" type="text" disabled>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label><?= __('Person Phone') ?></label>
                    <input value="<?php echo $taskManagement->phone; ?>" class="form-control" type="text" disabled>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="col-md-6">
            <div class="form-group">
                <label><?= __('Venue') ?></label>
                <input value="<?php echo $taskManagement->venue; ?>" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><?= __('Priority') ?></label>
                <input value="<?php echo h($taskManagement->priority); ?>" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><?= __('Priority') ?></label>
                <input value="<?php echo h($taskManagement->priority); ?>" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><?= __('Start Date Time') ?></label>
                <input value="<?php echo date('d / m / Y  H:i:s',$taskManagement->start_date_time); ?>" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><?= __('Status') ?></label>
                <input value="<?php echo ($taskManagement->status==1 ? 'Not Completed' : ' Completed'); ?>" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><?= __('End Date Time') ?></label>
                <input value="<?php echo date('d / m / Y  H:i:s',$taskManagement->end_date_time); ?>" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><?= __('Reminder By SMS') ?></label>
                <input value="<?php echo ($taskManagement->reminder_by_sms==1 ? 'Active' : 'Not Active'); ?>" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><?= __('Description') ?></label>
                <textarea class="form-control" rows="5" disabled>
                    <?php echo $taskManagement->description; ?>
                </textarea>
            </div>
        </div>

    </div>
</div>