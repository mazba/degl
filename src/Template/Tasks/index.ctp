<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Tasks') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Tasks'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Task'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>

    </ul>
</div>

<div class="tasks index panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i> <?= __('List of Tasks') ?></h6>
    </div>
    <div class="datatable">
        <table class="table">
            <thead>
            <tr>
                <th><?= __('id') ?></th>
                <th><?= __('Component') ?></th>
                <th><?= __('Module') ?></th>
                <th><?= __('English Name') ?></th>
                <th><?= __('Bangla Name') ?></th>
                <th><?= __('icon') ?></th>
                <th><?= __('controller') ?></th>
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
            foreach ($tasks as $task)
            {
                ?>
                <tr>
                    <td><?= $this->Number->format($task->id) ?></td>
                    <td><?=
                        $task->has('component') ?
                            $this->Html->link($task->component
                                ->name_en, ['controller' => 'Components',
                                'action' => 'view', $task->component
                                    ->id]) : '' ?></td>
                    <td><?=
                        $task->has('module') ?
                            $this->Html->link($task->module
                                ->name_en, ['controller' => 'Modules',
                                'action' => 'view', $task->module
                                    ->id]) : '' ?></td>
                    <td><?= h($task->name_en) ?></td>
                    <td><?= h($task->name_bn) ?></td>
                    <td><?= h($task->icon) ?></td>
                    <td><?= h($task->controller) ?></td>
                    <td class="actions">
                        <?php
                        if ($user_roles['view'] == 1)
                        {
                            echo $this->Html->link('<button class="btn btn-primary btn-icon" type="button"><i class="icon-newspaper"></i></button>', ['action' => 'view', $task->id
                                , '_full' => true], ['escapeTitle' => false, 'title' => 'Details']);
                        }

                        ?>
                        <?php
                        if ($user_roles['edit'] == 1)
                        {
                            echo $this->Html->link('<button class="btn btn-info btn-icon" type="button"><i class="icon-pencil3"></i></button>', ['action' => 'edit', $task->id
                            ], ['escapeTitle' => false, 'title' => 'edit']);
                        }
                        ?>
                        <?php
                        if ($user_roles['delete'] == 1)
                        {
                            echo $this->Form->postLink('<button class="btn btn-danger btn-icon" type="button"><i class="icon-close"></i></button>', ['action' => 'delete', $task->id],
                                ['confirm' => __('Are you sure you want to delete # {0}?', $task->name_en), 'escapeTitle' => false,
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