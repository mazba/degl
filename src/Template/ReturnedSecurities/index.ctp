<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>">Dashboard</a></li>
        <li class="active">Returned Securities</li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Returned Securities'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Returned Security'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>

    </ul>
</div>

<div class="returnedSecurities index panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i> List of Returned Securities</h6>
    </div>
    <div class="datatable">
        <table class="table">
            <thead>
            <tr>
                                                            <th><?= __('id') ?></th>
                                                                                <th><?= __('scheme_id') ?></th>
                                                                                <th><?= __('returned_amount') ?></th>
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
            foreach ($returnedSecurities as $returnedSecurity)
            {
            ?>
            <tr>
                                            <td><?= $this->Number->format($returnedSecurity->id) ?></td>
                                                        <td><?= $returnedSecurity->has('scheme') ?
                                $this->Html->link($returnedSecurity->scheme
                                ->name_en, ['controller' => 'Schemes',
                                'action' => 'view', $returnedSecurity->scheme
                                ->id]) : '' ?></td>
                                                            <td><?= $this->Number->format($returnedSecurity->returned_amount) ?></td>
                                        <td class="actions">
                    <?php
                    if ($user_roles['view'] == 1)
                    {
                    echo $this->Html->link('<button class="btn btn-primary btn-icon" type="button"><i class="icon-newspaper"></i></button>', ['action' => 'view', $returnedSecurity->id
                    ,'_full'=>true],['escapeTitle' => false, 'title' => 'Details']);
                    }

                    ?>
                    <?php
                    if ($user_roles['edit'] == 1)
                    {
                    echo $this->Html->link('<button class="btn btn-info btn-icon" type="button"><i class="icon-pencil3"></i></button>', ['action' => 'edit', $returnedSecurity->id
                    ],['escapeTitle' => false, 'title' => 'edit']);
                    }
                    ?>
                    <?php
                    if ($user_roles['delete'] == 1)
                    {
                    echo $this->Form->postLink('<button class="btn btn-danger btn-icon" type="button"><i class="icon-close"></i></button>', ['action' => 'delete', $returnedSecurity->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $returnedSecurity->id),'escapeTitle' => false,
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