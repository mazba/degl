<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Districts') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Districts'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New District'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>

    </ul>
</div>

<div class="districts index panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i> <?= __('List of Districts') ?></h6>
    </div>
    <div class="datatable">
        <table class="table">
            <thead>
            <tr>
                                                            <th><?= __('id') ?></th>
                                                                                <th><?= __('division_id') ?></th>
                                                                                <th><?= __('zone_id') ?></th>
                                                                                <th><?= __('name_en') ?></th>
                                                                                <th><?= __('name_bn') ?></th>
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
            foreach ($districts as $district)
            {
            ?>
            <tr>
                                            <td><?= h($district->id) ?></td>
                                                        <td><?= $district->has('division') ?
                                $this->Html->link($district->division
                                ->name_en, ['controller' => 'Divisions',
                                'action' => 'view', $district->division
                                ->id]) : '' ?></td>
                                                                <td><?= $district->has('zone') ?
                                $this->Html->link($district->zone
                                ->name_en, ['controller' => 'Zones',
                                'action' => 'view', $district->zone
                                ->id]) : '' ?></td>
                                                            <td><?= h($district->name_en) ?></td>
                                                    <td><?= h($district->name_bn) ?></td>
                                        <td class="actions">
                    <?php
                    if ($user_roles['view'] == 1)
                    {
                    echo $this->Html->link('<button class="btn btn-primary btn-icon" type="button"><i class="icon-newspaper"></i></button>', ['action' => 'view', $district->id
                    ,'_full'=>true],['escapeTitle' => false, 'title' => 'Details']);
                    }

                    ?>
                    <?php
                    if ($user_roles['edit'] == 1)
                    {
                    echo $this->Html->link('<button class="btn btn-info btn-icon" type="button"><i class="icon-pencil3"></i></button>', ['action' => 'edit', $district->id
                    ],['escapeTitle' => false, 'title' => 'edit']);
                    }
                    ?>
                    <?php
                    if ($user_roles['delete'] == 1)
                    {
                    echo $this->Form->postLink('<button class="btn btn-danger btn-icon" type="button"><i class="icon-close"></i></button>', ['action' => 'delete', $district->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $district->id),'escapeTitle' => false,
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