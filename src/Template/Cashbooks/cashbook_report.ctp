<div class="col-md-12" style="margin-top: 20px; border: 1px solid #eee">
    <button onclick="print_rpt('received_print_wrp')" class="btn btn-right-icon btn-info" type="button" style="margin-top: 10px; float: right"><i class="icon-print"></i><?= __('Print') ?></button>
    <div id="received_print_wrp">
        <h4 style="text-align: center">LOCAL GOVERNMENT ENGINEERING DEPARTMENT</h4>
        <h1 style="text-align: center">CASHBOOK</h1>
        <span>Name of the Office: &nbsp;&nbsp;&nbsp; <?= $user_office['name_en'] ?> </span>
        <hr>
        <h1 class="text-center">RECEIVED SIDE</h1>
        <table class="table table-bordered" style="border: 1px solid #eee;margin-top: 25px;">
            <thead>
            <tr>
                <th rowspan="3">Date of Receipt</th>
                <th rowspan="3">No of Voucher or Receipt</th>
                <th rowspan="3">From Whom received etc.</th>
                <th colspan="3" style="text-align: center; background: #ebebeb">Amount</th>
                <th rowspan="3">Classified</th>
            </tr>
            <tr>
                <th rowspan="2">Cash</th>
                <th>BANK</th>
            </tr>
            <tr>
                <th>Cheque no.</th>
                <th>Amount</th>
            </tr>
            <tr>
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th colspan="3">4</th>
                <th>5</th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th>Tk.</th>
                <th></th>
                <th>Tk.</th>
                <th></th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th>Opening Balance</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $total_allotment = 0;
            foreach($allotments as $allotment)
            {
                if($allotment['dr_cr'] == 'Debit')
                {
                    ?>
                    <tr>
                        <td><?= $this->System->display_date($allotment['allotment_date']) ?></td>
                        <td></td>
                        <td><?= $allotment['project']['name_en'] ?></td>
                        <td></td>
                        <td></td>
                        <td><?= $allotment['allotment_amount'] ?></td>
                        <td></td>
                    </tr>
                    <?php
                    $total_allotment+=$allotment['allotment_amount'];
                }
            }
            ?>
            </tbody>
            <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td style="font-weight: bold">Total</td>
                <td></td>
                <td></td>
                <td style="text-align: center; font-weight: bold"><?= $total_allotment ?></td>
                <td></td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
<div class="col-md-12" style="margin-top: 20px; border: 1px solid #eee">
    <button onclick="print_rpt('payment_print_wrp')" class="btn btn-right-icon btn-info" type="button" style="margin-top: 10px; float: right"><i class="icon-print"></i><?= __('Print') ?></button>
    <div id="payment_print_wrp">
        <h4 style="text-align: center">LOCAL GOVERNMENT ENGINEERING DEPARTMENT</h4>
        <h1 style="text-align: center">CASHBOOK</h1>
        <span>Name of the Office: &nbsp;&nbsp;&nbsp; <?= $user_office['name_en'] ?> </span>
        <hr>
        <h1 class="text-center">PAYMENTS SIDE</h1>
        <table class="table table-bordered" style="border: 1px solid #eee;margin-top: 25px;">
            <thead>
            <tr>
                <th rowspan="3">Date of Receipt</th>
                <th rowspan="3">No of Voucher or Receipt</th>
                <th rowspan="3">From Whom received etc.</th>
                <th colspan="3" style="text-align: center; background: #ebebeb">Amount</th>
                <th rowspan="3">Classified</th>
            </tr>
            <tr>
                <th rowspan="2">Cash</th>
                <th>BANK</th>
            </tr>
            <tr>
                <th>Cheque no.</th>
                <th>Amount</th>
            </tr>
            <tr>
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th colspan="3">4</th>
                <th>5</th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th>Tk.</th>
                <th></th>
                <th>Tk.</th>
                <th></th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th>Opening Balance</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $total_payment = 0;
            foreach($allotments as $allotment)
            {
                if($allotment['dr_cr'] == 'Credit')
                {
                    ?>
                    <tr>
                        <td><?= $this->System->display_date($allotment['allotment_date']) ?></td>
                        <td></td>
                        <td><?= $allotment['scheme']['name_en'] ?></td>
                        <td></td>
                        <td></td>
                        <td><?= $allotment['allotment_amount'] ?></td>
                        <td></td>
                    </tr>
                    <?php
                    $total_payment+=$allotment['allotment_amount'];
                }
            }
            ?>
            </tbody>
            <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td style="font-weight: bold;">Total</td>
                <td></td>
                <td></td>
                <td style="text-align: center; font-weight: bold"><?= $total_payment ?></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td style="font-weight: bold;">Closing Balance</td>
                <td></td>
                <td></td>
                <td style="text-align: center; font-weight: bold"><?= $total_allotment-$total_payment ?></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td style="font-weight: bold;">Total</td>
                <td></td>
                <td></td>
                <td style="text-align: center; font-weight: bold"><?= $total_allotment ?></td>
                <td></td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
<style type="text/css">
    table tr th{
       padding: 4px!important;
       text-align: center;
    }
</style>