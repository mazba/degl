<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Scheme Types') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Scheme Types'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1) {
            ?>
            <li><?= $this->Html->link(__('New Scheme Type'), ['action' => 'add']) ?></li>
            <?php
        }
        ?>

    </ul>
</div>

<div class="schemeTypes index panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i> List of Scheme Types</h6>
    </div>
    <div class="datatable">
        <table class="table">
            <thead>
            <tr>
                <th><?= __('id') ?></th>
                <th><?= __('title') ?></th>
                <th><?= __('status') ?></th>
                <?php
                if (($user_roles['view'] == 1) || ($user_roles['edit'] == 1) || ($user_roles['delete'] == 1)) {
                    ?>
                    <th class="actions"><?= __('Actions') ?></th>
                    <?php
                }
                ?>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($schemeTypes as $schemeType) {
                ?>
                <tr>
                    <td><?= $this->Number->format($schemeType->id) ?></td>
                    <td><?= h($schemeType->title) ?></td>
                    <td><?= $this->Number->format($schemeType->status) ?></td>
                    <td class="actions">
                        <?php
                        if ($user_roles['view'] == 1) {
                            echo $this->Html->link('<button class="btn btn-primary btn-icon" type="button"><i class="icon-newspaper"></i></button>', ['action' => 'view', $schemeType->id
                                , '_full' => true], ['escapeTitle' => false, 'title' => 'Details']);
                        }

                        ?>
                        <?php
                        if ($user_roles['edit'] == 1) {
                            echo $this->Html->link('<button class="btn btn-info btn-icon" type="button"><i class="icon-pencil3"></i></button>', ['action' => 'edit', $schemeType->id
                            ], ['escapeTitle' => false, 'title' => 'edit']);
                        }
                        ?>
                    </td>
                </tr>

            <?php } ?>
            </tbody>
        </table>
    </div>
</div>