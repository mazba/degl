<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Projects') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Projects'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Project'), ['action' => 'add']) ?></li>
            <?php
        }
        ?>
    </ul>
</div>

<div class="projects index panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i> <?= __('List of Projects') ?></h6>
    </div>
    <div class="datatable">
        <table class="table">
            <thead>
            <tr>
                <th><?= __('id') ?></th>
                <th><?= __('short code') ?></th>
                <th><?= __('NAME_BN') ?></th>
                <th><?= __('development partner') ?></th>
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
            foreach ($projects as $project)
            {
                ?>
                <tr>
                    <td><?= $this->Number->format($project->id) ?></td>
                    <td><?= h($project->short_code) ?></td>
                    <td><?= h($project->name_bn) ?></td>
                    <td><?=
                        $project->has('development_partner') ?
                            $this->Html->link($project->development_partner
                                ->name_en, ['controller' => 'DevelopmentPartners',
                                'action' => 'view', $project->development_partner
                                    ->id]) : '' ?></td>
                    <td class="actions">
                        <?php
                        if ($user_roles['view'] == 1)
                        {
                            echo $this->Html->link('<button class="btn btn-sm btn-primary btn-icon" type="button"><i class="icon-newspaper"></i></button>', ['action' => 'view', $project->id
                                , '_full' => true], ['escapeTitle' => false, 'title' => 'Details']);
                        }

                        ?>
                        <?php
                        if ($user_roles['edit'] == 1)
                        {
                            echo $this->Html->link('<button class="btn btn-sm btn-info btn-icon" type="button"><i class="icon-pencil3"></i></button>', ['action' => 'edit', $project->id
                            ], ['escapeTitle' => false, 'title' => 'edit']);
                        }
                        ?>
                        <?php
                        if ($user_roles['delete'] == 1)
                        {
                            echo $this->Form->postLink('<button class="btn btn-sm btn-danger btn-icon" type="button"><i class="icon-close"></i></button>', ['action' => 'delete', $project->id],
                                ['confirm' => __('Are you sure you want to delete # {0}?', $project->id), 'escapeTitle' => false,
                                    'title' => 'delete']);
                        }
                        if ($user_roles['edit'] == 1 && $user_roles['delete'] == 1)
                        {
                            echo $this->Html->link(' &nbsp;<button class="btn btn-sm btn-warning btn-icon" type="button"><i class="icon-stop"></i></button>', ['action' => 'change_status', $project->id],['escapeTitle' => false,
                                    'title' => 'Close Project']);
                        }

                        ?>
                    </td>
                </tr>

            <?php } ?>
            </tbody>
        </table>
    </div>
</div>