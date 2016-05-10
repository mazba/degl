<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Proposed Ra Bills'), ['action' => 'index']) ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Proposed Ra Bills'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1) {
            ?>
            <li><?= $this->Html->link(__('New Proposed Ra Bill'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <li class="active"><?=
            $this->Html->link(__('Details Proposed Ra Bill'), ['action' => 'view', $proposedRaBill->id
            ]) ?>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="form-group">
            <label>Scheme English Name</label>
            <label class="form-control"><?php echo $proposedRaBill->scheme->name_en ?></label>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>RA Bill no</label>
            <label class="form-control"><?php echo $proposedRaBill->ra_bill_no; ?></label>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Total Payable</label>
            <label class="form-control"><?php echo $this->Number->format($proposedRaBill->total_payable); ?></label>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Percentage %</label>
            <label class="form-control"><?php echo $proposedRaBill->percentage; ?></label>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Bill Amount</label>
            <label class="form-control"><?php echo $proposedRaBill->bill_amount; ?></label>
        </div>
    </div>
</div>
<?php
if($approve_ra_bills)
{
    ?>
        <div class="panel panel-info">
            <div class="panel-heading">
                <h6 class="panel-title"><i class="icon-share"></i><?= __('Approve Bills') ?></h6>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th><?= __('Part no') ?></th>
                        <th><?= __('Approved Quantity') ?></th>
                        <th><?= __('Security Money') ?></th>
                        <th><?= __('Roller Fee') ?></th>
                        <th><?= __('Lab Fee') ?></th>
                        <th><?= __('Fine') ?></th>
                        <th><?= __('Is Final') ?></th>
                        <th><?= __('etc') ?></th>
                        <th><?= __('Remarks') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($approve_ra_bills as $approve_ra_bill)
                    {
                        ?>
                        <tr>
                            <td><?php echo $approve_ra_bill['part_no']; ?></td>
                            <td><?php echo $approve_ra_bill['approved_quantity']; ?></td>
                            <td><?php echo $approve_ra_bill['security_money']; ?></td>
                            <td><?php echo $approve_ra_bill['roller_fee']; ?></td>
                            <td><?php echo $approve_ra_bill['lab_fee']; ?></td>
                            <td><?php echo $approve_ra_bill['fine']; ?></td>
                            <td><?php echo $approve_ra_bill['is_final']; ?></td>
                            <td><?php echo $approve_ra_bill['etc']; ?></td>
                            <td><?php echo $approve_ra_bill['remarks']; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php
}
?>