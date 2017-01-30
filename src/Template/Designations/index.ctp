<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Designations') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Designations'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Designation'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>

    </ul>
</div>

<div class="designations index panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i> <?= __('List of Designations') ?></h6>
    </div>
    <div class="datatable">
        <table class="table">
            <thead>
            <tr>
                <th><?= __('id') ?></th>
                <th><?= __('Office name') ?></th>
                <th><?= __('NAME_EN') ?></th>
                <th><?= __('NAME_BN') ?></th>
                <th><?= __('PARENT DESIGNATION') ?></th>
                <th><?= __('ORDER') ?></th>
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
            $i=1;
            foreach ($designations as $designation)
            {
                ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?=
                        $designation->has('office') ?
                            $this->Html->link($designation->office
                                ->name_en, ['controller' => 'Offices',
                                'action' => 'view', $designation->office
                                    ->id]) : '' ?></td>
                    <td><?= h($designation->name_en) ?></td>
                    <td><?= h($designation->name_bn) ?></td>
                    <td><?=
                        $designation->has('parent_designation') ?
                            $this->Html->link($designation->parent_designation
                                ->name_en, [
                                'action' => 'view', $designation->parent_designation
                                    ->id]) : '' ?></td>
                    <td><?= h($designation->order_no) ?></td>
                    <td class="actions">
                        <?php
                        if ($user_roles['view'] == 1)
                        {
                            echo $this->Html->link('<button class="btn btn-primary btn-icon" type="button"><i class="icon-newspaper"></i></button>', ['action' => 'view', $designation->id
                                , '_full' => true], ['escapeTitle' => false, 'title' => 'Details']);
                        }

                        ?>
                        <?php
                        if ($user_roles['edit'] == 1)
                        {
                            echo $this->Html->link('<button class="btn btn-info btn-icon" type="button"><i class="icon-pencil3"></i></button>', ['action' => 'edit', $designation->id
                            ], ['escapeTitle' => false, 'title' => 'edit']);
                        }
                        ?>
                        <?php
                        if ($user_roles['delete'] == 1)
                        {
                            echo $this->Form->postLink('<button class="btn btn-danger btn-icon" type="button"><i class="icon-close"></i></button>', ['action' => 'delete', $designation->id],
                                ['confirm' => __('Are you sure you want to delete # {0}?', $designation->id), 'escapeTitle' => false,
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