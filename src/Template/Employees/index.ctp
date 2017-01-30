<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Employees') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Employees'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1) {
            ?>
            <li><?= $this->Html->link(__('New Employee'), ['action' => 'add']) ?></li>
            <?php
        }
        ?>

    </ul>
</div>

<div class="employees index panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i> <?= __('List of Employees') ?></h6>
    </div>
    <div class="datatable">
        <table class="table">
            <thead>
            <tr>
                <th><?= __('id') ?></th>
                <th><?= __('office') ?></th>
                <th><?= __('designation') ?></th>
                <th><?= __('NAME_EN') ?></th>
                <th><?= __('NAME_BN') ?></th>
                <?php
                if (($user_roles['view'] == 1) || ($user_roles['edit'] == 1)) {
                    ?>
                    <th class="actions"><?= __('Actions') ?></th>
                    <?php
                }
                ?>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($employees as $employee) {
                ?>
                <tr>
                    <td><?= $this->Number->format($employee->id) ?></td>
                    <td><?=
                        $employee->has('office') ? $employee->office
                            ->name_en : '' ?></td>
                    <td><?=
                        $employee->has('designation') ? $employee->designation
                            ->name_en : '' ?></td>
                    <td><?= h($employee->name_en) ?></td>
                    <td><?= h($employee->name_bn) ?></td>
                    <td class="actions">
                        <?php
                        if ($user_roles['view'] == 1) {
                            echo $this->Html->link('<button class="btn btn-primary btn-icon" type="button"><i class="icon-newspaper"></i></button>', ['action' => 'view', $employee->id
                                , '_full' => true], ['escapeTitle' => false, 'title' => 'Details']);
                        }

                        ?>
                        <?php
                        if ($user_roles['edit'] == 1) {
                            echo $this->Html->link('<button class="btn btn-info btn-icon" type="button"><i class="icon-pencil3"></i></button>', ['action' => 'edit', $employee->id
                            ], ['escapeTitle' => false, 'title' => 'edit']);
                        }
                        ?>

                        <?php
                        if ($user_roles['delete'] == 1) {
                            echo $this->Html->link('<button class="btn btn-danger btn-icon" type="button"><i class="icon-remove2"></i></button>', ['action' => 'delete', $employee->id
                            ], ['escapeTitle' => false, 'title' => 'delete', 'confirm' => ['Are you sure to delete?']]);
                        }
                        ?>
                    </td>
                </tr>

            <?php } ?>
            </tbody>
        </table>
    </div>
</div>