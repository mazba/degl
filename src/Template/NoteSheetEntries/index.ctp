<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>">Dashboard</a></li>
        <li class="active">Note Sheet Entries</li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Note Sheet Entries'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1) {
            ?>
            <li><?= $this->Html->link(__('New Note Sheet Entry'), ['action' => 'add']) ?></li>
            <?php
        }
        ?>

    </ul>
</div>

<div class="noteSheetEntries index panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i> List of Note Sheet Entries</h6>
    </div>
    <div class="datatable">
        <table class="table">
            <thead>
            <tr>
                <th><?= __('id') ?></th>
                <th><?= __('scheme_id') ?></th>
                <th><?= __('entry_serial_no') ?></th>
                <th><?= __('approval_status') ?></th>
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
            foreach ($noteSheetEntries as $noteSheetEntry) {
                ?>
                <tr>
                    <td><?= $this->Number->format($noteSheetEntry->id) ?></td>
                    <td><?= $noteSheetEntry->has('scheme') ?
                            $this->Html->link($noteSheetEntry->scheme
                                ->name_en, ['controller' => 'Schemes',
                                'action' => 'view', $noteSheetEntry->scheme
                                    ->id]) : '' ?></td>
                    <td><?= $this->Number->format($noteSheetEntry->entry_serial_no) ?></td>
                    <td><?php if($noteSheetEntry->approval_status==1){echo "Complete";}else{ echo "Pending";} ?></td>
                    <td class="actions">
                        <?php
                        if ($user_roles['view'] == 1) {
                            echo $this->Html->link('<button class="btn btn-primary btn-icon" type="button"><i class="icon-newspaper"></i></button>', ['action' => 'view', $noteSheetEntry->id
                                , '_full' => true], ['escapeTitle' => false, 'title' => 'Details']);
                        }

                        ?>

                        <?php
                        if ($user_roles['delete'] == 1) {
                            echo $this->Form->postLink('<button class="btn btn-danger btn-icon" type="button"><i class="icon-close"></i></button>', ['action' => 'delete', $noteSheetEntry->id],
                                ['confirm' => __('Are you sure you want to delete # {0}?', $noteSheetEntry->id), 'escapeTitle' => false,
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