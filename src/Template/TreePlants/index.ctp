<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Tree Plants') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Tree Plants'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1) {
            ?>
            <li><?= $this->Html->link(__('New Tree Plant'), ['action' => 'add']) ?></li>
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

<div class="treePlants index panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i><?= __('List of Tree Plants') ?></h6>
    </div>
    <div class="datatable">
        <table class="table">
            <thead>
            <tr>
                <th><?= __('id') ?></th>
                <th><?= __('Financial Year') ?></th>
                <th><?= __('Total Target Plant') ?></th>
                <th><?= __('Total Progress Plant') ?></th>
                <th><?= __('Total Alive Plant') ?></th>
                <th><?= __('Total Plant Cost') ?></th>
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
            foreach ($treePlants as $treePlant) {
                ?>
                <tr>
                    <td><?= $this->Number->format($treePlant->id) ?></td>
                    <td><?= $treePlant->has('financial_year_estimate') ?
                            $this->Html->link($treePlant->financial_year_estimate
                                ->name, ['controller' => 'FinancialYearEstimates',
                                'action' => 'view', $treePlant->financial_year_estimate
                                    ->id]) : '' ?></td>
                    <td><?= $this->Number->format($treePlant->target_total_plant) ?></td>
                    <td><?= $this->Number->format($treePlant->progress_total_plant) ?></td>
                    <td><?= $this->Number->format($treePlant->alive_total_plant) ?></td>
                    <td><?= $this->Number->format($treePlant->total_plant_cost) ?></td>
                    <td class="actions">
                        <?php
                        if ($user_roles['view'] == 1) {
                            echo $this->Html->link('<button class="btn btn-primary btn-icon" type="button"><i class="icon-newspaper"></i></button>', ['action' => 'view', $treePlant->id
                                , '_full' => true], ['escapeTitle' => false, 'title' => 'Details']);
                        }

                        ?>
                        <?php
                        if ($user_roles['edit'] == 1) {
                            echo $this->Html->link('<button class="btn btn-info btn-icon" type="button"><i class="icon-pencil3"></i></button>', ['action' => 'edit', $treePlant->id
                            ], ['escapeTitle' => false, 'title' => 'edit']);
                        }
                        ?>
                        <?php
                        if ($user_roles['delete'] == 1) {
                            echo $this->Form->postLink('<button class="btn btn-danger btn-icon" type="button"><i class="icon-close"></i></button>', ['action' => 'delete', $treePlant->id],
                                ['confirm' => __('Are you sure you want to delete # {0}?', $treePlant->id), 'escapeTitle' => false,
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