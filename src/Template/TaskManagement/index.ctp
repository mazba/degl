<?php //echo "<pre>";print_r($taskManagement['taskManagement_old']);die();?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Task Management') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Task Management'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Task Management'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>

    </ul>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="taskManagement index panel panel-default">
            <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i> নতুন <?= __('List of Task Management') ?></h6>
            </div>
            <div class="datatable">
                <table class="table">
                    <thead>
                    <tr>
                        <th><?= __('type') ?></th>
                        <th><?= __('media_type') ?></th>
                        <th><?= __('title') ?></th>
                        <th><?= __('name') ?></th>
                        <th><?= __('phone') ?></th>
                        <th><?= __('venue') ?></th>
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
                    foreach ($taskManagement['taskManagement_new'] as $task)
                    {
                    ?>
                        <tr>
                            <td><?= h($task->type) ?></td>
                            <td><?= h($task->media_type) ?></td>
                            <td><?= h($task->title) ?></td>
                            <td><?= h($task->name) ?></td>
                            <td><?= h($task->phone) ?></td>
                            <td><?= h($task->venue) ?></td>
                            <td class="actions">
                                <?php
                                if ($user_roles['view'] == 1)
                                {
                                    echo $this->Html->link('<button class="btn btn-primary btn-icon" type="button"><i class="icon-newspaper"></i></button>', ['action' => 'view', $task->id
                                        ,'_full'=>true],['escapeTitle' => false, 'title' => 'Details']);
                                }

                                ?>
                                <?php
                                if ($user_roles['edit'] == 1)
                                {
                                    echo $this->Html->link('<button class="btn btn-info btn-icon" type="button"><i class="icon-pencil3"></i></button>', ['action' => 'edit', $task->id
                                    ],['escapeTitle' => false, 'title' => 'edit']);
                                }
                                ?>
                            </td>
                        </tr>

                    <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="taskManagement index panel panel-default">
            <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i>সম্পন্ন  <?= __('List of Task Management') ?></h6>
            </div>
            <div class="datatable">
                <table class="table">
                    <thead>
                    <tr>
                        <th><?= __('type') ?></th>
                        <th><?= __('media_type') ?></th>
                        <th><?= __('title') ?></th>
                        <th><?= __('name') ?></th>
                        <th><?= __('phone') ?></th>
                        <th><?= __('venue') ?></th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($taskManagement['taskManagement_old'] as $row)
                    {
//                        echo "<pre>";print_r($row);die();
                        ?>
                        <tr>
                            <td><?= h($row->type) ?></td>
                            <td><?= h($row->media_type) ?></td>
                            <td><?= h($row->title) ?></td>
                            <td><?= h($row->name) ?></td>
                            <td><?= h($row->phone) ?></td>
                            <td><?= h($row->venue) ?></td>

                        </tr>

                    <?php
                    } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

