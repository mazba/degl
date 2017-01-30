<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>">Dashboard</a></li>
        <li class="active">Entry Definitions</li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Entry Definitions'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Entry Definition'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>

    </ul>
</div>

<div class="entryDefinitions index panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i> List of Entry Definitions</h6>
    </div>
    <div class="datatable">
        <table class="table">
            <thead>
            <tr>
                                                            <th><?= __('id') ?></th>
                                                                                <th><?= __('name') ?></th>
                                                                                                                                                                <th><?= __('status') ?></th>
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
            foreach ($entryDefinitions as $entryDefinition)
            {
            ?>
            <tr>
                                            <td><?= $this->Number->format($entryDefinition->id) ?></td>
                                                    <td><?= h($entryDefinition->name) ?></td>
                                                    <td><?= $this->Number->format($entryDefinition->status) ?></td>
                                        <td class="actions">
                    <?php
                    if ($user_roles['view'] == 1)
                    {
                    echo $this->Html->link('<button class="btn btn-primary btn-icon" type="button"><i class="icon-newspaper"></i></button>', ['action' => 'view', $entryDefinition->id
                    ,'_full'=>true],['escapeTitle' => false, 'title' => 'Details']);
                    }

                    ?>
                    <?php
                    if ($user_roles['edit'] == 1)
                    {
                    echo $this->Html->link('<button class="btn btn-info btn-icon" type="button"><i class="icon-pencil3"></i></button>', ['action' => 'edit', $entryDefinition->id
                    ],['escapeTitle' => false, 'title' => 'edit']);
                    }
                    ?>
                    <?php
                    if ($user_roles['delete'] == 1)
                    {
                    echo $this->Form->postLink('<button class="btn btn-danger btn-icon" type="button"><i class="icon-close"></i></button>', ['action' => 'delete', $entryDefinition->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $entryDefinition->id),'escapeTitle' => false,
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