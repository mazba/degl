<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Upazilas') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Upazilas'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Upazila'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>

    </ul>
</div>

<div class="upazilas index panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i> <?= __('List of Upazilas') ?></h6>
    </div>
    <div class="datatable">
        <table class="table">
            <thead>
            <tr>
                                                            <th><?= __('id') ?></th>
                                                                                <th><?= __('lged_syscode') ?></th>
                                                                                <th><?= __('division_id') ?></th>
                                                                                <th><?= __('district_id') ?></th>
                                                                                <th><?= __('lged_code') ?></th>
                                                                                <th><?= __('upazila_geocode') ?></th>
                                                                                <th><?= __('district_name_en') ?></th>
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
            foreach ($upazilas as $upazila)
            {
            ?>
            <tr>
                                            <td><?= $this->Number->format($upazila->id) ?></td>
                                                    <td><?= $this->Number->format($upazila->lged_syscode) ?></td>
                                                        <td><?= $upazila->has('division') ?
                                $this->Html->link($upazila->division
                                ->name_en, ['controller' => 'Divisions',
                                'action' => 'view', $upazila->division
                                ->id]) : '' ?></td>
                                                                <td><?= $upazila->has('district') ?
                                $this->Html->link($upazila->district
                                ->name_en, ['controller' => 'Districts',
                                'action' => 'view', $upazila->district
                                ->id]) : '' ?></td>
                                                            <td><?= $this->Number->format($upazila->lged_code) ?></td>
                                                    <td><?= h($upazila->upazila_geocode) ?></td>
                                                    <td><?= h($upazila->district_name_en) ?></td>
                                        <td class="actions">
                    <?php
                    if ($user_roles['view'] == 1)
                    {
                    echo $this->Html->link('<button class="btn btn-primary btn-icon" type="button"><i class="icon-newspaper"></i></button>', ['action' => 'view', $upazila->id
                    ,'_full'=>true],['escapeTitle' => false, 'title' => 'Details']);
                    }

                    ?>
                    <?php
                    if ($user_roles['edit'] == 1)
                    {
                    echo $this->Html->link('<button class="btn btn-info btn-icon" type="button"><i class="icon-pencil3"></i></button>', ['action' => 'edit', $upazila->id
                    ],['escapeTitle' => false, 'title' => 'edit']);
                    }
                    ?>
                    <?php
                    if ($user_roles['delete'] == 1)
                    {
                    echo $this->Form->postLink('<button class="btn btn-danger btn-icon" type="button"><i class="icon-close"></i></button>', ['action' => 'delete', $upazila->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $upazila->id),'escapeTitle' => false,
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