<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Scheme Details') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Scheme Details'), ['action' => 'index']) ?></li>


    </ul>
</div>

<div class="schemes index panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i> <?= __('List of Schemes') ?></h6>
    </div>
    <div class="datatable">
        <table class="table">
            <thead>
            <tr>
                <th><?= __('id') ?></th>
                <th><?= __('Scheme Name') ?></th>
                <th><?= __('Scheme code') ?></th>
                <th><?= __('project name') ?></th>
                <th><?= __('District') ?></th>
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
            foreach ($schemes as $scheme)
            {
                ?>
                <tr>
                    <td><?= $this->Number->format($scheme->id) ?></td>
                    <td><?= h($scheme->name_en) ?></td>
                    <td><?= h($scheme->scheme_code) ?></td>
                    <td><?= $scheme['project'] ?></td>
                    <td><?= $scheme['district'] ?></td>
                    <td class="actions">
                        <?php
                        if ($user_roles['view'] == 1)
                        {
                            echo $this->Html->link('<button class="btn btn-primary btn-icon" type="button"><i class="icon-newspaper"></i></button>', ['action' => 'view', $scheme->id
                                , '_full' => true], ['escapeTitle' => false, 'title' => 'Details']);
                        }

                        ?>
                        <?php
                        if ($user_roles['edit'] == 1)
                        {
                            if ($scheme->status == 1 && $scheme->revised == 0 && $scheme->approved == 0)
                            {
                                echo $this->Html->link('<button class="btn btn-info btn-icon" type="button"><i class="icon-pencil3"></i></button>', ['action' => 'edit', $scheme->id
                                ], ['escapeTitle' => false, 'title' => 'add/edit']);
                            }
                            if ($scheme->status != 4 && $scheme->revised == 0 && $scheme->approved == 0)
                            {
                                echo $this->Html->link('<button class="btn btn-success btn-icon" type="button"><i class="icon-checkmark"></i></button>', ['action' => 'approve', $scheme->id
                                ], ['escapeTitle' => false, 'title' => 'Approve']);
                            }
                            if ($scheme->approved == 1 && $scheme->assigned == 1)
                            {
                                echo $this->Html->link('<button class="btn btn-danger btn-icon" type="button"><i class="icon-transmission2"></i></button>', ['action' => 'revise', $scheme->id
                                ], ['escapeTitle' => false, 'title' => 'Revise']);
                            }

                            if ($scheme->approved == 1 && $scheme->assigned == 0)
                            {
                                echo $this->Html->link('<button class="btn btn-info btn-icon" type="button"><i class="icon-user-plus2"></i></button>', ['action' => 'assign', $scheme->id
                                ], ['escapeTitle' => false, 'title' => 'Assign']);
                            }

                        }
                        ?>
                    </td>
                </tr>

            <?php } ?>
            </tbody>
        </table>
    </div>
</div>