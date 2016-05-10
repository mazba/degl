<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Schemes') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Schemes'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1) {
            ?>
            <li><?= $this->Html->link(__('New Scheme'), ['action' => 'add']) ?></li>
            <?php
        }
        ?>

    </ul>
</div>

<div class="schemes index panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i> <?= __('List of Schemes') ?></h6>
    </div>
    <div class="datatable">
        <table class="table">
            <thead>
            <tr>
                <th><?= __('id') ?></th>
                <th><?= __('name_en') ?></th>
                <th><?= __('Scheme Code') ?></th>
                <th><?= __('project') ?></th>
                <th><?= __('district') ?></th>
                <?php
                if (($user_roles['edit'] == 1)) {
                    ?>
                    <th class="actions"><?= __('Actions') ?></th>
                    <?php
                }
                ?>
            </tr>
            </thead>
            <tbody>
            <?php
            $i=1;
            foreach ($schemes as $scheme) {
                ?>
                <tr>
                    <td><?= $this->Number->format($i++) ?></td>
                    <td><?= h($scheme->name_en) ?></td>
                    <td><?= h($scheme->scheme_code) ?></td>
                    <td><?= $scheme['project'] ?></td>
                    <td><?= $scheme['district'] ?></td>

                    <td class="actions">

                        <?php
                        if ($user_roles['edit'] == 1) {
                            echo $this->Html->link('<button style="margin-right: 2px" class="btn btn-info btn-icon" type="button"><i class="icon-pencil3"></i></button>', ['action' => 'edit', $scheme->id
                            ], ['escapeTitle' => false, 'title' => 'edit']);
                            echo $this->Html->link('<button class="btn btn-danger btn-icon" type="button"><i class="icon-stackoverflow"></i></button>', ['action' => 'View', $scheme->id
                            ], ['escapeTitle' => false, 'title' => 'View']);
                            echo $this->Html->link('<button class="btn btn-warning btn-icon" type="button"><i class="icon-exit"></i></button>', ['action' => 'close_scheme', $scheme->id
                            ], ['escapeTitle' => false, 'title' => 'Close Scheme']);
                        }

                        if ($user_info['user_group_id'] == 2 && $scheme->approved) {
                            echo $this->Html->link('<button class="btn btn-success btn-icon" type="button"><i class="icon-user-plus"></i></button>', ['action' => 'assign_contractors', $scheme->id
                            ], ['escapeTitle' => false, 'title' => 'Assign Contractors']);
                        }

                        ?>
                    </td>
                </tr>

            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<style>
    .table td {
        padding: 5px 1px !important;
    }
</style>