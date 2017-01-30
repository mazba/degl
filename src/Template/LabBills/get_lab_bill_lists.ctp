<div class="panel panel-default">
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th><?= __('Sl No.') ?></th>
                <th><?= __('Date') ?></th>
                <th><?= __('Up to Last Bill') ?></th>
                <th><?= __('This Bill') ?></th>
                <th><?= __('Action') ?></th>

            </tr>
            </thead>
            <tbody>
            <?php
            if (sizeof($labBills) > 0) {
                $net_payable = 0;
                foreach ($labBills as $key => $labBill) {
                    $net_payable += $labBill->net_payable
                    ?>
                    <tr>
                        <td><?= $key + 1 ?></td>
                        <td><?= date('d-m-Y', $labBill->created_date) ?></td>
                        <td><?= $labBill->total_amount - $labBill->net_payable ?></td>
                        <td><?= $labBill->net_payable ?></td>
                        <td> <span class="btn btn-info view_detail"><?= __('View') ?></span>  <span class="btn btn-success send_bill"><?= __('Send Bill') ?></span> </td>
                        <input type="hidden" class="bill_id"  value="<?= $labBill->id ?>">
                        <input type="hidden" class="type"  value="<?= $labBill->type ?>">
                        <input type="hidden" class="reference_id"  value="<?= $labBill->reference_id ?>">
                    </tr>
                    <?php
                }
                ?>
                <tr style="background: #d9d9d9">
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td class="text-right"><?= __('Total') ?></td>
                    <td><?= $net_payable ?></td>
                    <td>&nbsp;</td>
                </tr>
                <?php
            } else {
                ?>

                <tr>
                    <td colspan="4"><?= __('No data found.') ?></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>