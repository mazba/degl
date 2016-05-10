<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Allotment Registers') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Allotment Registers'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Report'), ['action' => 'report']) ?></li>
    </ul>
</div>

<div class="allotmentRegisters index panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i><?= __(' List of Allotment Registers') ?></h6>
    </div>
    <div class="datatable">
        <table class="table">
            <thead>
            <tr>
                <th><?= __('id') ?></th>
                <th><?= __('Debit/Credit') ?></th>
                <th><?= __('Project') ?></th>
                <th><?= __('Scheme') ?></th>
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
            foreach ($allotmentRegisters as $allotmentRegister) {
                ?>
                <tr>
                    <td><?= $this->Number->format($allotmentRegister->id) ?></td>
                    <td><?= h($allotmentRegister->dr_cr) ?></td>
                    <td><?=
                        $allotmentRegister->has('project') ?
                            $this->Html->link($allotmentRegister->project
                                ->name_en, ['controller' => 'Projects',
                                'action' => 'view', $allotmentRegister->project
                                    ->id]) : 'N/A' ?></td>
                    <td><?=
                        $allotmentRegister->has('scheme') ?
                            $this->Html->link($allotmentRegister->scheme
                                ->name_en, ['controller' => 'Schemes',
                                'action' => 'view', $allotmentRegister->scheme
                                    ->id]) : 'N/A' ?></td>
                    <td class="actions">
                        <?php
                        if ($user_roles['view'] == 1) {
                            echo $this->Html->link('<button class="btn btn-primary btn-icon" type="button"><i class="icon-newspaper"></i></button>', ['action' => 'view', $allotmentRegister->id
                                , '_full' => true], ['escapeTitle' => false, 'title' => 'Details']);
                        }

                        ?>
                    </td>
                </tr>

            <?php } ?>
            </tbody>
        </table>
    </div>
</div>