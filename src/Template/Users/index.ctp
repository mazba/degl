<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Users') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Users'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>

    </ul>
</div>

<div class="users index panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i> <?= __('List of Users') ?></h6>
    </div>
    <div class="datatable">
        <table class="table">
            <thead>
            <tr>
                <th><?= __('id') ?></th>
                <th><?= __('Office') ?></th>
                <th><?= __('Designation') ?></th>
                <th><?= __('username') ?></th>
                <th><?= __('NAME_EN') ?></th>
                <th><?= __('NAME_BN') ?></th>
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
            foreach ($users as $user)
            {
                ?>
                <tr>
                    <td><?= $this->Number->format($user->id) ?></td>
                    <td><?=
                        $user->has('office') ?
                            $this->Html->link($user->office
                                ->name_en, ['controller' => 'Offices',
                                'action' => 'view', $user->office
                                    ->id]) : '' ?></td>
                    <td><?=
                        $user->has('designation') ?
                            $this->Html->link($user->designation
                                ->name_en, ['controller' => 'Designations',
                                'action' => 'view', $user->designation
                                    ->id]) : '' ?></td>
                    <td><?= h($user->username) ?></td>
                    <td><?= h($user->name_en) ?></td>
                    <td><?= h($user->name_bn) ?></td>
                    <td class="actions">
                        <?php
                        if ($user_roles['view'] == 1)
                        {
                            echo $this->Html->link('<button class="btn btn-primary btn-icon" type="button"><i class="icon-newspaper"></i></button>', ['action' => 'view', $user->id
                                , '_full' => true], ['escapeTitle' => false, 'title' => 'Details']);
                        }

                        ?>
                        <?php
                        if ($user_roles['edit'] == 1)
                        {
                            echo $this->Html->link('<button class="btn btn-info btn-icon" type="button"><i class="icon-pencil3"></i></button>', ['action' => 'edit', $user->id
                            ], ['escapeTitle' => false, 'title' => 'edit']);
                        }
                        ?>
                        <?php
                        if ($user_roles['delete'] == 1)
                        {
                            echo $this->Form->postLink('<button class="btn btn-danger btn-icon" type="button"><i class="icon-close"></i></button>', ['action' => 'delete', $user->id],
                                ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'escapeTitle' => false,
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