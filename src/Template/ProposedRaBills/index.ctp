<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Proposed Ra Bills') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Proposed Ra Bills'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1) {
            ?>
            <li><?= $this->Html->link(__('New Proposed Ra Bill'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>

    </ul>
</div>

<div class="proposedRaBills index panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i> <?= __('List of Proposed Ra Bills') ?></h6>
    </div>
    <div class="datatable">
        <table class="table">
            <thead>
            <tr>
                <th><?= __('office') ?></th>
                <th><?= __('scheme') ?></th>
                <th><?= __('ra_bill_no') ?></th>
                <th><?= __('Bill Amount') ?></th>
                <th><?= __('total_payable') ?></th>
                <th><?= __('above_or_less') ?></th>
                <th><?= __('percentage') ?></th>
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
            foreach ($proposedRaBills as $proposedRaBill) {
                ?>
                <tr>
                    <td><?= $proposedRaBill->office ->name_en ?></td>
                    <td><?= $proposedRaBill->scheme->name_en ?></td>
                    <td><?= h($proposedRaBill->ra_bill_no) ?></td>
                    <td><?= h($proposedRaBill->total_payable) ?></td>
                    <td><?= h($proposedRaBill->this_bill_amount) ?></td>
                    <td><?= h($proposedRaBill->above_or_less) ?></td>
                    <td><?= h($proposedRaBill->percentage) ?></td>
                    <td class="actions">
                        <?php
                        if ($user_roles['view'] == 1) {
                            echo $this->Html->link('<button class="btn btn-primary btn-icon" type="button"><i class="icon-newspaper"></i></button>', ['action' => 'view', $proposedRaBill->id
                                , '_full' => true], ['escapeTitle' => false, 'title' => 'Details']);
                        }

                        ?>
<!--                        --><?php
//                            if(isset($arranged_bills[$proposedRaBill->id]))
//                            {
//                                if($arranged_bills[$proposedRaBill->id] < $proposedRaBill->bill_amount)
//                                {
//                                    echo $this->Html->link('<button class="btn btn-info btn-icon" type="button"><i class="icon-checkmark3"></i></button>', ['action' => 'approve', $proposedRaBill->id
//                                    ], ['escapeTitle' => false, 'title' => 'Approve']);
//                                }
//                            }
//                            else
//                            {
//                                echo $this->Html->link('<button class="btn btn-info btn-icon" type="button"><i class="icon-checkmark3"></i></button>', ['action' => 'approve', $proposedRaBill->id
//                                ], ['escapeTitle' => false, 'title' => 'Approve']);
//                            }
////                      ?>
                    </td>
                </tr>

            <?php } ?>
            </tbody>
        </table>
    </div>
</div>