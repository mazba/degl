<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Lab Letter Registers'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Lab Letter Register') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Lab Letter Registers'), ['controller' => 'LabLetterRegisters', 'action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1) {
            ?>
            <li><?= $this->Html->link(__('New Lab Letter Register'), ['controller' => 'LabLetterRegisters', 'action' => 'add']) ?></li>
            <?php
        }
        ?>
        <li><?=
            $this->Html->link(__('Details Lab Letter Registert'), ['controller' => 'LabLetterRegisters', 'action' => 'view', $labLetterRegister->id
            ]) ?>
        </li>
        <li class="active"><?=
            $this->Html->link(__('View Report'), ['action' => 'report', $labLetterRegister->id
            ]) ?>
        </li>

    </ul>
</div>

<div class="panel panel-default">
    <div class="panel-body">
        <div class="col-sm-12">
            <button style="float: right" onclick="print_rpt()">Print</button>
        </div>
        <div id="result">
            <div class="col-sm-12 text-center" style="font-size: 16px;margin-bottom: 10px">
                <span>Local Government Engineering Department</span><br>
                <span>Office of the Executive Engineer</span><br>
                <span>Gazipur</span><br>
            </div>
            <div class="col-sm-10 scheme_info" style="margin-bottom: 30px">
                <span><b>Memo No:</b> LGED/XEN/Gazi/<?= date('Y') ?></span><br><br>
                <span><b>Subject:</b><?=$labLetterRegister['subject'] ?></span><br/>
                <span><b>Name of Project:</b> <?= $scheme ? $scheme[0]['projects']['name_bn'] : "" ?> </span><br>
                <span><b>Name of Work:</b> <?= $scheme ? $scheme[0]['name_bn'] : "" ?></span><br>
                <span><b>Name of Contractor:</b> <?= $scheme ? $scheme[0]['contractors']['contractor_title'] : "" ?> </span><br>
                <span><b>Package No:</b> </span><br>
            </div>
            <div class="col-sm-2 date">
                <span><b>Date:</b> <?= date('d-m-Y') ?></span>
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
                    $total = 0;
                    foreach ($tests as $test): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?php echo $test->lab_test_group?$test->lab_test_group." / ":''; echo $test->lab_test_short_name ?></td>
                            <td><?= $test->number_of_test ?></td>
                            <td><?= $test->rate ?></td>
                            <td><?= ($test->number_of_test * $test->rate) ?></td>
                        </tr>
                        <?php $total += ($test->number_of_test * $test->rate) ?>
                    <?php endforeach; ?>
                </table>
            </div>
            <div class="row">
                <div class="col-sm-10 text-right balance" style="font-size: 14px">
                    <spapn>Total Amount Tk. <?= $total ?></spapn>
                    <br>
                    <spapn>Net payable this bill Tk. <?= $total ?></spapn>
                    <br>
                    <spapn><b>Tk.=</b></spapn>
                    <br>
                </div>
            </div>
            <div class="row" style="margin-top:100px">
                <div class="col-sm-3 sign">
                    <span>Lab: Technician</span><br>
                    <span>LGED, Gazipur</span><br>
                </div>
                <div class="col-sm-3 sign">
                    <span>Assistant Engineer</span><br>
                    <span>LGED, Gazipur</span><br>
                </div>
                <div class="col-sm-3 sign">
                    <span>Sr. Assistant Engineer</span><br>
                    <span>LGED, Gazipur</span><br>
                </div>
                <div class="col-sm-3 sign">
                    <span>Executive Engineer</span><br>
                    <span>LGED, Gazipur</span><br>
                </div>
            </div>

            <style>
                .scheme_info {
                    float: left;
                }

                .date {
                    float: right
                }

                .balance {
                    width: 85%
                }

                .sign {
                    float: left;
                    width: 25%
                }
            </style>
        </div>
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
