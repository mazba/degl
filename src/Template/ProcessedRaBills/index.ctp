<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>">Dashboard</a></li>
        <li class="active">Purto Bill List</li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Processed Ra Bills'), ['action' => 'index']) ?></li>


    </ul>
</div>

<div class="processedRaBills index panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i> List of Processed Ra Bills</h6>
    </div>
    <div class="datatable">
        <table class="table">
            <thead>
            <tr>
                                                            <th><?= __('id') ?></th>
                                                                                <th><?= __('scheme_id') ?></th>
                                                                                <th><?= __('security') ?></th>
                                                                                <th><?= __('income_tex') ?></th>
                                                                                <th><?= __('vat') ?></th>
                                                                                <th><?= __('hire_charge') ?></th>
                                                                                <th><?= __('lab_fee') ?></th>
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
            foreach ($processedRaBills as $processedRaBill)
            {
            ?>
            <tr>
                                            <td><?= $this->Number->format($processedRaBill->id) ?></td>
                                                        <td><?= $processedRaBill->has('scheme') ?
                                $this->Html->link($processedRaBill->scheme
                                ->name_en, ['controller' => 'Schemes',
                                'action' => 'view', $processedRaBill->scheme
                                ->id]) : '' ?></td>
                                                            <td><?= $this->Number->format($processedRaBill->security) ?></td>
                                                    <td><?= $this->Number->format($processedRaBill->income_tex) ?></td>
                                                    <td><?= $this->Number->format($processedRaBill->vat) ?></td>
                                                    <td><?= $this->Number->format($processedRaBill->hire_charge) ?></td>
                                                    <td><?= $this->Number->format($processedRaBill->lab_fee) ?></td>
                                        <td class="actions">
                    <?php
                    if ($user_roles['view'] == 1)
                    {
                    echo $this->Html->link('<button class="btn btn-primary btn-icon" type="button"><i class="icon-newspaper"></i></button>', ['action' => 'view', $processedRaBill->id
                    ,'_full'=>true],['escapeTitle' => false, 'title' => 'Details']);
                    }

                    ?>
                    <?php
                    if ($user_roles['edit'] == 1 && false)
                    {
                    echo $this->Html->link('<button class="btn btn-info btn-icon" type="button"><i class="icon-pencil3"></i></button>', ['action' => 'edit', $processedRaBill->id
                    ],['escapeTitle' => false, 'title' => 'edit']);
                    }
                    ?>
                    <?php
                    if ($user_roles['delete'] == 1)
                    {
                    echo $this->Form->postLink('<button class="btn btn-danger btn-icon" type="button"><i class="icon-close"></i></button>', ['action' => 'delete', $processedRaBill->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $processedRaBill->id),'escapeTitle' => false,
                    'title' => 'delete']);
                    }
                    echo $this->Form->postLink('<button class="btn btn-success btn-icon" type="button"><i class="icon-close"></i></button>', ['action' => 'invoice_form', $processedRaBill->id],
                        ['escapeTitle' => false,
                            'title' => 'Invoice Form']);


                    ?>
                     <a href="<?php $this->request->webroot?>AllotmentRegisters/add/purto_bill/<?=$processedRaBill->id?>" class="btn btn-warning btn-icon" title="test"><i class="icon-close"></i></button></a>
                </td>
            </tr>

            <?php } ?>
            </tbody>
        </table>
    </div>
</div>