<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Lab Test Frequency') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Lab Test Frequency'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1) {
            ?>
            <li><?= $this->Html->link(__('New Lab Test Frequency'), ['action' => 'add']) ?></li>
            <?php
        }
        ?>

    </ul>
</div>

<div class="labTestFrequency index panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-table"></i> <?= __('List of Lab Test Frequency') ?></h6>
    </div>
    <div class="datatable">
        <table class="table">
            <thead>
            <tr>
                <th><?= __('id') ?></th>
                <th><?= __('Item of Work') ?></th>
                <th><?= __('Test Name') ?></th>
                <th><?= __('Number of Test') ?></th>
                <th><?= __('Test Type') ?></th>
                <th><?= __('Per Unit') ?></th>
                <th><?= __('Unit Type') ?></th>
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
            foreach ($labTestFrequency as $labTestFrequency) {
                ?>
                <tr>
                    <td><?= $this->Number->format($labTestFrequency->id) ?></td>
                    <td><?= $labTestFrequency->lab_test_group->name_bn ?></td>
                    <td><?= $labTestFrequency->has('lab_test_list') ?
                            $this->Html->link($labTestFrequency->lab_test_list
                                ->test_short_name_en, ['controller' => 'LabTestLists',
                                'action' => 'view', $labTestFrequency->lab_test_list
                                    ->id]) : '' ?></td>
                    <td><?= $this->Number->format($labTestFrequency->test_no) ?></td>
                    <td><?= $this->Number->format($labTestFrequency->test_no_type) ?></td>
                    <td><?= $this->Number->format($labTestFrequency->per_unit) ?></td>
                    <td><?= $this->Number->format($labTestFrequency->unit_type) ?></td>
                    <td class="actions">
                        <?php
                        if ($user_roles['view'] == 1) {
                            echo $this->Html->link('<button class="btn btn-primary btn-icon" type="button"><i class="icon-newspaper"></i></button>', ['action' => 'view', $labTestFrequency->id
                                , '_full' => true], ['escapeTitle' => false, 'title' => 'Details']);
                        }

                        ?>
                        <?php
                        if ($user_roles['edit'] == 1) {
                            echo $this->Html->link('<button class="btn btn-info btn-icon" type="button"><i class="icon-pencil3"></i></button>', ['action' => 'edit', $labTestFrequency->id
                            ], ['escapeTitle' => false, 'title' => 'edit']);
                        }
                        ?>
                        <?php
                        if ($user_roles['delete'] == 1) {
                            echo $this->Form->postLink('<button class="btn btn-danger btn-icon" type="button"><i class="icon-close"></i></button>', ['action' => 'delete', $labTestFrequency->id],
                                ['confirm' => __('Are you sure you want to delete # {0}?', $labTestFrequency->id), 'escapeTitle' => false,
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