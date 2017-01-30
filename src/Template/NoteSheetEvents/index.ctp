<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>">Dashboard</a></li>
        <li class="active">Note Sheet Events</li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Note Sheet Events'), ['action' => 'index']) ?></li>


    </ul>
</div>

<div class="noteSheetEvents index panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i> List of Note Sheet Events</h6>
    </div>
    <div class="datatable">
        <table class="table">
            <thead>
            <tr>
                <th><?= __('id') ?></th>
                <th><?= __('scheme_id') ?></th>
                <th><?= __('note_sheet_entry_id') ?></th>
                <th><?= __('recipient_designation_id') ?></th>
                <th><?= __('office_id') ?></th>
                <th><?= __('is_read') ?></th>
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
            foreach ($noteSheetEvents as $noteSheetEvent) {
                ?>
                <tr>
                    <td><?= $this->Number->format($noteSheetEvent->id) ?></td>
                    <td><?= $noteSheetEvent->has('scheme') ?
                            $this->Html->link($noteSheetEvent->scheme
                                ->name_en, ['controller' => 'Schemes',
                                'action' => 'view', $noteSheetEvent->scheme
                                    ->id]) : '' ?></td>
                    <td><?= $noteSheetEvent->has('note_sheet_entry') ?
                            $this->Html->link($noteSheetEvent->note_sheet_entry
                                ->id, ['controller' => 'NoteSheetEntries',
                                'action' => 'view', $noteSheetEvent->note_sheet_entry
                                    ->id]) : '' ?></td>
                    <td><?= $this->Number->format($noteSheetEvent->recipient_designation_id) ?></td>
                    <td><?= $noteSheetEvent->has('office') ?
                            $this->Html->link($noteSheetEvent->office
                                ->name_en, ['controller' => 'Offices',
                                'action' => 'view', $noteSheetEvent->office
                                    ->id]) : '' ?></td>
                    <td><?= $this->Number->format($noteSheetEvent->is_read) ?></td>
                    <td class="actions">
                        <?php
                        if ($user_roles['view'] == 1) {
                            echo $this->Html->link('<button class="btn btn-primary btn-icon" type="button"><i class="icon-newspaper"></i></button>', ['action' => 'view', $noteSheetEvent->scheme_id
                                , '_full' => true], ['escapeTitle' => false, 'title' => 'Details']);
                        }

                        ?>


                    </td>
                </tr>

            <?php } ?>
            </tbody>
        </table>
    </div>
</div>