<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Guard Duties') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Guard Duties'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Guard Duty'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>

    </ul>
</div>

<div class="guardDuties index panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i> <?= __('List of Guard Duties') ?></h6>
    </div>
    <div class="datatable">
        <table class="table">
            <thead>
            <tr>
                <th><?= __('id') ?></th>
                <th><?= __('employee name') ?></th>
                <th><?= __('Shift Name') ?></th>
                <th><?= __('Shift Time') ?></th>
                <th><?= __('Shift date') ?></th>
                <th><?= __('location') ?></th>
                <?php
                if (($user_roles['view'] == 1) || ($user_roles['edit'] == 1) || ($user_roles['delete'] == 1))
                {
                    ?>
                    <th class="actions"><?= __('Actions') ?></th>
                <?php
                }
                ?>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($guardDuties as $guardDuty)
            {
                ?>
                <tr>
                    <td><?= $this->Number->format($guardDuty->id) ?></td>

                    <td><?=
                        $guardDuty->has('employee') ?$guardDuty->employee
                            ->name_en : '' ?></td>
                    <td><?=
                        $guardDuty->has('guard_duty_shift') ?$guardDuty->guard_duty_shift
                            ->name: '' ?></td>
                    <td><?=
                        $guardDuty->has('guard_duty_shift') ?$guardDuty->guard_duty_shift
                            ->start_time.'-'.$guardDuty->guard_duty_shift
                                ->end_time: '' ?></td>
                    <td><?= $this->System->display_date($guardDuty->duty_date) ?></td>
                    <td><?= h($guardDuty->location) ?></td>
                    <td class="actions">
                        <?php
                        if ($user_roles['view'] == 1)
                        {
                            echo $this->Html->link('<button class="btn btn-primary btn-icon" type="button"><i class="icon-newspaper"></i></button>', ['action' => 'view', $guardDuty->id
                                , '_full' => true], ['escapeTitle' => false, 'title' => 'Details']);
                        }

                        ?>
                        <?php
                        if ($user_roles['edit'] == 1)
                        {
                            echo $this->Html->link('<button class="btn btn-info btn-icon" type="button"><i class="icon-pencil3"></i></button>', ['action' => 'edit', $guardDuty->id
                            ], ['escapeTitle' => false, 'title' => 'edit']);
                        }
                        ?>
                        <?php
                        if ($user_roles['delete'] == 1)
                        {
                            echo $this->Form->postLink('<button class="btn btn-danger btn-icon" type="button"><i class="icon-close"></i></button>', ['action' => 'delete', $guardDuty->id],
                                ['confirm' => __('Are you sure you want to delete # {0}?', $guardDuty->id), 'escapeTitle' => false,
                                    'title' => 'delete']);
                        }

                        ?>
                    </td>
                </tr>

            <?php } ?>
            </tbody>
        </table>
    </div>
</div>