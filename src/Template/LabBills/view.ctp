<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Lab Bills') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs" style="margin-bottom: 5px">
        <li class="active"><?= $this->Html->link(__('Details of Lab Bills'), ['action' => 'view',]) ?></li>


    </ul>
</div>


<div class="row" style="margin-top: 60px">
    <div class="col-sm-12">
        <button style="float: right" onclick="print_rpt()">Print</button>
    </div>
    <div id="result">
        <div class="col-sm-12 text-center" style="font-size: 16px;margin-bottom:20px">
            <span>Local Government Engineering Department</span><br>
            <span>Office of the Executive Engineer</span><br>
            <span>Gazipur</span><br>

        </div>

        <div class="col-sm-12">

            <table class="project">
                <tr>
                    <td width="85%"><b>Memo No: </b> <?= "LGED/XEN/GAZI/" . date('Y'); ?></td>
                    <td width="15%"><b>Date: </b> <?= date('d-m-Y'); ?></td>
                </tr>
                <tr>
                    <td colspan="2"><b>Name of Project: </b><?= $scheme[0]['projects']['name_bn'] ?></td>
                </tr>
                <tr>
                    <td colspan="2"><b>Name of Work: </b> <?= $scheme[0]['name_bn'] ?></td>
                </tr>
                <tr>
                    <td colspan="2"><b>Name of Contractor: </b> <?= $scheme[0]['contractors']['contractor_title'] ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><b>Package No: </b></td>
                </tr>
            </table>
        </div>

        <div class="col-sm-12">
            <table class="table table-bordered">
                <tr>
                    <th><?= __('Sl. No.') ?></th>
                    <th><?= __('Name of Test') ?></th>
                    <th><?= __('N0. of Test') ?></th>
                    <th><?= __('Rate of Fee/Test') ?></th>
                    <th><?= __('Total Amount') ?></th>
                </tr>

                <?php $i = 1;
                $previous = $labBills->total_amount - $labBills->net_payable;
                foreach ($labTests as $test) { ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $test['lab_actual_tests']['lab_test_short_name']; ?></td>
                        <td><?= $test['lab_actual_tests']['number_of_test']; ?></td>
                        <td><?= $test['lab_actual_tests']['rate']; ?></td>
                        <td><?= $test['lab_actual_tests']['rate'] * $test['lab_actual_tests']['number_of_test']; ?></td>
                    </tr>

                <?php } ?>

            </table>
        </div>
        <div class="col-sm-12">
            <table class="balance" style="margin-top: 10px">
                <tr>
                    <td>Total Amount Tk.</td>
                    <td id="total"><?= $labBills->total_amount ?></td>
                </tr>
                <tr>
                    <td>Test Fee Paid Up to Previous Bill Tk.</td>
                    <td id="previous"><?= $previous ?></td>
                </tr>
                <tr>
                    <td>Net payable this bill Tk.</td>
                    <td id="net_total"><?= $labBills->net_payable ?></td>
                </tr>
                <tr>
                    <td><b>Tk.=</b></td>
                </tr>

            </table>
        </div>

        <div class="col-sm-12">
            <table class="sign">
                <tr>
                    <td>Lab: Technician</td>
                    <td>Assistant Engineer</td>
                    <td>Sr. Assistant Engineer</td>
                    <td>Executive Engineer</td>

                </tr>
                <tr>
                    <td>LGED, Gazipur</td>
                    <td>LGED, Gazipur</td>
                    <td>LGED, Gazipur</td>
                    <td>LGED, Gazipur</td>
                </tr>
            </table>
        </div>

        <style>
            .project {
                margin-bottom: 20px
            }

            .project td {
                padding: 5px 10px;
            }

            .balance td {
                padding: 5px 10px;
                width: 92.5%;
                text-align: right;

            }
            .balance{
                margin-bottom:100px;
            }

            .sign td {
                width: 29%
            }

        </style>

    </div>
</div>


<script type="text/javascript">
    function print_rpt() {
        URL = "<?php echo $this->request->webroot; ?>page/Print_a4_Eng.php?selLayer=result";
        day = new Date();
        id = day.getTime();
        eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=yes,scrollbars=yes ,location=0,statusbar=0 ,menubar=yes,resizable=1,width=880,height=600,left = 20,top = 50');");
    }
</script>

<style>
    .sign td {
        width: 30%
    }

    .sign{
        margin-bottom: 40px;
    }
    .balance td {
        padding: 5px 10px;
        width: 93.8%;
        text-align: right;

    }
</style>

