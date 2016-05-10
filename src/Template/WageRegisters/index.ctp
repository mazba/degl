<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Wages') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Wage Registers'), ['action' => 'index']) ?></li>
    </ul>
</div>

<div class="wageRegisters index panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i> <?= __('List of Wage Registers') ?></h6>
    </div>
    <div class="datatable">
        <table class="table">
            <thead>
            <tr>
                <th><?= __('id') ?></th>
                <th><?= __('office') ?></th>
                <th><?= __('employee name') ?></th>
                <th><?= __('Total Billing Days') ?></th>
                <th><?= __('Total Wage') ?></th>
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
            foreach ($employees as $employee)
            {
                ?>
                <tr>
                    <td><?= $this->Number->format($employee->id) ?></td>
                    <td><?=
                        $employee->has('office') ?$employee->office
                            ->name_en : '' ?></td>
                    <td><?= $employee->name_en?></td>
                    <td><?= $this->Number->format($employee->wr['total_billing_days']) ?></td>
                    <td><?= $this->Number->format($employee->wr['total_wage']) ?></td>
                    <td class="actions">
                        <?php
                        if ($user_roles['view'] == 1)
                        {
                            echo $this->Html->link('<button class="btn btn-primary btn-icon" type="button"><i class="icon-newspaper"></i></button>', ['action' => 'view', $employee->id
                                , '_full' => true], ['escapeTitle' => false, 'title' => 'Details']);
                        }

                        ?>
                        <?php
                        if ($user_roles['edit'] == 1)
                        {
                            echo $this->Html->link('<button class="btn btn-info btn-icon" type="button"><i class="icon-pencil3"></i></button>', ['action' => 'edit', $employee->id
                            ], ['escapeTitle' => false, 'title' => 'New Wage']);
                        }
                        ?>
                    </td>
                </tr>

            <?php } ?>
            </tbody>
        </table>
    </div>
</div>