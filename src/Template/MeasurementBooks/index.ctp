<?php
use Cake\Core\Configure;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Measurement Books') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Measurement Books'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Measurement Book'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>

    </ul>
</div>

<div class="measurementBooks index panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i> <?= __('List of Measurement Books') ?></h6>
    </div>
    <div class="datatable">
        <table class="table">
            <thead>
            <tr>
                <th><?= __('id') ?></th>
                <th><?= __('scheme') ?></th>
                <th><?= __('contractor') ?></th>
                <th><?= __('work_status') ?></th>
                <th><?= __('work commencement date') ?></th>
                <th><?= __('work completion date') ?></th>
                <?php
                if (($user_roles['view'] == 1) || ($user_roles['edit'] == 1))
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
            foreach ($measurementBooks as $measurementBook)
            {
                ?>
                <tr>
                    <td><?= $this->Number->format($measurementBook->id) ?></td>
                    <td><?=
                        $measurementBook->has('scheme') ?$measurementBook->scheme
                            ->name_en : '' ?></td>
                    <td><?=
                        $measurementBook->has('contractor') ?$measurementBook->contractor
                            ->contractor_title : '' ?></td>
                    <td><?= h(Configure::read('books_work_status')[$measurementBook->work_status]) ?></td>
                    <td><?= $this->System->display_date($measurementBook->work_commencement_date) ?></td>
                    <td><?= $this->System->display_date($measurementBook->work_completion_date) ?></td>
                    <td class="actions">
                        <?php
                        if ($user_roles['view'] == 1)
                        {
                            echo $this->Html->link('<button class="btn btn-primary btn-icon" type="button"><i class="icon-newspaper"></i></button>', ['action' => 'view', $measurementBook->id
                                , '_full' => true], ['escapeTitle' => false, 'title' => 'Details']);
                        }
                        ?>
                        <?php
                        if ($user_roles['edit'] == 1)
                        {
                            echo $this->Html->link('<button class="btn btn-info btn-icon" type="button"><i class="icon-pencil3"></i></button>', ['action' => 'edit', $measurementBook->id
                            ], ['escapeTitle' => false, 'title' => 'edit']);
                        }
                        ?>
                        <?php
                        if ($user_roles['edit'] == 1)
                        {
                            echo $this->Html->link('<button class="btn btn-warning btn-icon" type="button"><i class="icon-stackoverflow"></i></button>', ['action' => 'measurement_index', $measurementBook->id
                            ], ['escapeTitle' => false, 'title' => 'Measurement']);
                        }
                        ?>
                    </td>
                </tr>

            <?php } ?>
            </tbody>
        </table>
    </div>
</div>