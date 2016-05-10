<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Contractors') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Contractors'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Contractor'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
    </ul>
</div>

<div class="contractors index panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i> <?= __('List of Contractors') ?></h6>
    </div>
    <div class="datatable">
        <table class="table">
            <thead>
            <tr>
                <th><?= __('Contractor class') ?></th>
                <th><?= __('Contractor title') ?></th>
                <th><?= __('Contact person Name') ?></th>
                <th><?= __('Contractor phone') ?></th>
                <th><?= __('Contractor email') ?></th>
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
            foreach ($contractors as $contractor)
            {
                ?>
                <tr>
                    <td><?= h($contractor->contractor_class_title) ?></td>
                    <td><?= h($contractor->contractor_title) ?></td>
                    <td><?= h($contractor->contact_person_name) ?></td>
                    <td><?= h($contractor->contractor_phone) ?></td>
                    <td><?= h($contractor->contractor_email) ?></td>
                    <td class="actions">
                        <?php
                        if ($user_roles['view'] == 1)
                        {
                            echo $this->Html->link('<button class="btn btn-primary btn-icon" type="button"><i class="icon-newspaper"></i></button>', ['action' => 'view', $contractor->id
                                , '_full' => true], ['escapeTitle' => false, 'title' => 'Details']);
                        }
                        ?>
                        <?php
                        if ($user_roles['edit'] == 1)
                        {
                            echo $this->Html->link('<button class="btn btn-info btn-icon" type="button"><i class="icon-pencil3"></i></button>', ['action' => 'edit', $contractor->id
                            ], ['escapeTitle' => false, 'title' => 'edit']);
                        }
                        ?>
                    </td>
                </tr>

            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>