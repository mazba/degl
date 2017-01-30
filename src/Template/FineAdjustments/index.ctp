<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>">Dashboard</a></li>
        <li class="active">Fine Adjustments</li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Fine Adjustments'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1) {
            ?>
            <li><?= $this->Html->link(__('New Fine Adjustment'), ['action' => 'add']) ?></li>
            <?php
        }
        ?>

    </ul>
</div>

<div class="fineAdjustments index panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i> List of Fine Adjustments</h6>
    </div>
    <div class="datatable">
        <table class="table">
            <thead>
            <tr>
                <th><?= __('id') ?></th>
                <th><?= __('scheme_id') ?></th>
                <th><?= __('economic_code') ?></th>
                <th><?= __('adjusted_amount') ?></th>
                <th><?= __('created_date') ?></th>
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
            foreach ($fineAdjustments as $fineAdjustment) {
                ?>
                <tr>
                    <td><?= $this->Number->format($fineAdjustment->id) ?></td>
                    <td><?= $fineAdjustment->has('scheme') ?
                            $this->Html->link($fineAdjustment->scheme
                                ->name_en, ['controller' => 'Schemes',
                                'action' => 'view', $fineAdjustment->scheme
                                    ->id]) : '' ?></td>
                    <td><?= h($fineAdjustment->economic_code) ?></td>
                    <td><?= $this->Number->format($fineAdjustment->adjusted_amount) ?></td>
                    <td><?= $this->System->display_date($fineAdjustment->created_date) ?></td>

                    <td class="actions">
                        <?php
                        if ($user_roles['view'] == 1) {
                            echo $this->Html->link('<button class="btn btn-primary btn-icon" type="button"><i class="icon-newspaper"></i></button>', ['action' => 'view', $fineAdjustment->id
                                , '_full' => true], ['escapeTitle' => false, 'title' => 'Details']);
                        }

                        ?>
                        <?php
                        if ($user_roles['edit'] == 1) {
                            echo $this->Html->link('<button class="btn btn-info btn-icon" type="button"><i class="icon-pencil3"></i></button>', ['action' => 'edit', $fineAdjustment->id
                            ], ['escapeTitle' => false, 'title' => 'edit']);
                        }
                        ?>
                        <?php
                        if ($user_roles['delete'] == 1) {
                            echo $this->Form->postLink('<button class="btn btn-danger btn-icon" type="button"><i class="icon-close"></i></button>', ['action' => 'delete', $fineAdjustment->id],
                                ['confirm' => __('Are you sure you want to delete # {0}?', $fineAdjustment->id), 'escapeTitle' => false,
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