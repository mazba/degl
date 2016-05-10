<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Inspections') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Inspections'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1) {
            ?>
            <li><?= $this->Html->link(__('New Inspection'), ['action' => 'add']) ?></li>
            <?php
        }
        ?>

        <?php
        if ($user_roles['report'] == 1) {
            ?>
            <li><?= $this->Html->link(__('Report'), ['action' => 'report']) ?></li>
            <?php
        }
        ?>

    </ul>
</div>

<div class="inspections index panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i><?= __('List of Inspections') ?></h6>
    </div>
    <div class="datatable">
        <table class="table">
            <thead>
            <tr>
                <th><?= __('id') ?></th>
                <th><?= __('Financial Year') ?></th>
                <th><?= __('Inspected Team') ?></th>
                <th><?= __('Status') ?></th>
                <?php
                if (($user_roles['view'] == 1) || ($user_roles['edit'] == 1) || ($user_roles['delete'] == 1)) {
                    ?>
                    <th class="actions"><?= __('Actions') ?></th>
                    <?php
                }
                ?>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($inspections as $inspection) {
                ?>
                <tr>
                    <td><?= $this->Number->format($inspection->id) ?></td>
                    <td><?= $inspection->financial_year_estimate->name; ?></td>
                    <td><?= $inspection->inspected_team->name_bn; ?></td>
                    <td><?= ($inspection->status==1)? __('Active') : __('Inactive') ?></td>
                    <td class="actions">
                        <?php
                        if ($user_roles['view'] == 1) {
                            echo $this->Html->link('<button class="btn btn-primary btn-icon" type="button"><i class="icon-newspaper"></i></button>', ['action' => 'view', $inspection->id
                                , '_full' => true], ['escapeTitle' => false, 'title' => 'Details']);
                        }

                        ?>
                        <?php
                        if ($user_roles['edit'] == 1) {
                            echo $this->Html->link('<button class="btn btn-info btn-icon" type="button"><i class="icon-pencil3"></i></button>', ['action' => 'edit', $inspection->id
                            ], ['escapeTitle' => false, 'title' => 'edit']);
                        }
                        ?>
                        <?php
                        if ($user_roles['delete'] == 1) {
                            echo $this->Form->postLink('<button class="btn btn-danger btn-icon" type="button"><i class="icon-close"></i></button>', ['action' => 'delete', $inspection->id],
                                ['confirm' => __('Are you sure you want to delete # {0}?', $inspection->id), 'escapeTitle' => false,
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