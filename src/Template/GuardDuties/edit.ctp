<?php
use Cake\Core\Configure;

?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Guard Duties'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('Edit Guard Duty') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Guard Duties'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Guard Duty'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <li class="active"><?=
            $this->Html->link(__('Edit Guard Duty'), ['action' => 'edit', $guardDuty->id
            ]) ?>
        </li>
        <?php
        if ($user_roles['delete'] == 1)
        {
            ?>
            <li><?=
                $this->Form->postLink(
                    __('Delete Guard Duty'),
                    ['action' => 'delete', $guardDuty->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $guardDuty
                        ->id)]
                )
                ?>
            </li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['view'] == 1)
        {
            ?>
            <li><?=
                $this->Html->link(__('Details Guard Duty'), ['action' => 'view', $guardDuty->id])
                ?>
            </li>
        <?php
        }
        ?>


    </ul>
</div>


<?= $this->Form->create($guardDuty, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Edit Guard Duty') ?>
        </h6></div>
    <div class="panel-body col-sm-6">
        <?php
        echo $this->Form->input('office_id', ['options' => $offices]);
        echo $this->Form->input('employee_id', ['options' => $employees]);
        echo $this->Form->input('guard_duty_shift_id', ['options' => $guardDutyShifts]);
        echo $this->Form->input('location');
        echo $this->Form->input('duty_date',['type'=>'text','value'=>$this->System->display_date($guardDuty->duty_date),'class'=>'form-control hasdatepicker']);
        ?>
    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

