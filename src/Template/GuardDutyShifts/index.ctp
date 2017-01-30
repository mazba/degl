<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Guard Duty Shifts') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Guard Duty Shifts'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Guard Duty Shift'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>

    </ul>
</div>

<div class="guardDutyShifts index panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i> <?= __('List of Guard Duty Shifts') ?></h6>
    </div>
    <div class="datatable">
        <table class="table">
            <thead>
            <tr>
                <th><?= __('id') ?></th>
                <th><?= __('Shift Name') ?></th>
                <th><?= __('Start Time') ?></th>
                <th><?= __('End Time') ?></th>
                <?php
                if (($user_roles['view'] == 1) || ($user_roles['edit'] == 1))
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
            foreach ($guardDutyShifts as $guardDutyShift)
            {
                ?>
                <tr>
                    <td><?= $this->Number->format($guardDutyShift->id) ?></td>
                    <td><?= h($guardDutyShift->name) ?></td>
                    <td><?= ($guardDutyShift->start_time) ?></td>
                    <td><?= ($guardDutyShift->end_time) ?></td>
                    <td class="actions">
                        <?php
                        if ($user_roles['view'] == 1)
                        {
                            echo $this->Html->link('<button class="btn btn-primary btn-icon" type="button"><i class="icon-newspaper"></i></button>', ['action' => 'view', $guardDutyShift->id
                                , '_full' => true], ['escapeTitle' => false, 'title' => 'Details']);
                        }

                        ?>
                        <?php
                        if ($user_roles['edit'] == 1)
                        {
                            echo $this->Html->link('<button class="btn btn-info btn-icon" type="button"><i class="icon-pencil3"></i></button>', ['action' => 'edit', $guardDutyShift->id
                            ], ['escapeTitle' => false, 'title' => 'edit']);
                        }
                        ?>
                    </td>
                </tr>

            <?php } ?>
            </tbody>
        </table>
    </div>
</div>