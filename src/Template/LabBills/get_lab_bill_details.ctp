<div id="myModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" style="width: 1200px !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-delicious"></i> <?= __('Lab Bills') ?></h4>
            </div>
            <div class="modal-body with-padding">
                <div class="row">

                    <div style="" id="result">
                        <div class="col-sm-12">
                            <button onclick="print_rpt()" style="float: right">Print</button>
                        </div>
                        <div id="PrintArea">
                            <div style="font-size: 16px;margin-bottom:20px" class="col-sm-12 text-center">
                                <span>Local Government Engineering Department</span><br>
                                <span>Office of the Executive Engineer</span><br>
                                <span>Gazipur</span><br>

                            </div>

                            <div style="margin-bottom: 20px" class="col-sm-10 scheme_info">
                                <span><b>Memo No: </b>LGED/XEN/GAZI/<?= date('Y') ?>/ </span><br>
                                <?php if (isset($scheme)) { ?>
                                    <span><b>Name of Project: </b><?= $scheme[0]['projects']['name_bn'] ?></span><br>
                                    <span><b>Name of Work: </b><?= $scheme[0]['name_bn'] ?> </span><br>
                                    <span><b>Name of
                                            Contractor: </b><?= $scheme[0]['contractors']['contractor_title'] ?></span>
                                    <br>
                                    <span><b>Package No: </b></span><br>
                                <?php } ?>
                                <?php if (isset($labLetter)) { ?>
                                    <span><b>Name: </b><?= $labLetter->receive_from ? $labLetter->receive_from : "" ?></span><br>
                                    <span><b>Subject: </b><?= $labLetter->subject ? $labLetter->subject : "" ?></span><br>
                                <?php } ?>
                            </div>
                            <div class="col-sm-2 date">
                                <span><b>Date: </b> <?= date('d-m-Y') ?> </span>
                            </div>
                            <div style="display: block" class="col-sm-12">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th><?= __('Sl. No.') ?></th>
                                        <th><?= __('Name of Test') ?></th>
                                        <th><?= __('পূর্ববর্তী টেস্টের সংখ্যা') ?></th>
                                        <th><?= __('চলমান টেস্টের সংখ্যা') ?></th>
                                        <th><?= __('Rate of Fee/Test') ?></th>
                                        <th><?= __('পূর্ববর্তী মোট পরিমান') ?></th>
                                        <th><?= __('Total Amount') ?></th>
                                    </tr>
                                    </thead>
                                    <tbody class="test_list">
                                    <?php foreach ($labTests as $key => $labTest) { ?>
                                        <tr>
                                            <td><?= $this->Number->format($key + 1) ?></td>
                                            <td><?= $labTest['lab_test_short_name'] ?></td>
                                            <td><?= $labTest['number_of_test'] ?></td>
                                            <td><?= $labTest['latest_number_of_test'] ?></td>
                                            <td><?= $labTest['rate'] ?></td>
                                            <td><?= $labTest['total'] ?></td>
                                            <td><?= $labTest['latest_total'] ?></td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td><?= array_sum(array_column($labTests, 'total')) ?></td>
                                        <td><?= array_sum(array_column($labTests, 'latest_total')) ?></td>
                                    </tr>
                                    <tr style="background: #dcd8ce">
                                        <td class="text-right" colspan="5"><?= __('Total') ?></td>
                                        <td class="text-center" colspan="2"><?= array_sum(array_column($labTests, 'latest_total')) + array_sum(array_column($labTests, 'total')) ?></td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div style="margin-top:100px;display: inline-block;width: 100%;text-align: center">
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
                                    float: left
                                }

                                .date {
                                    text-align: right
                                }

                                .balance_label {
                                    float: left;
                                    width: 80%
                                }

                                .balance_value {
                                    float: left;
                                    width: 20%
                                }

                                .sign {
                                    float: left;
                                    width: 25%
                                }
                            </style>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>