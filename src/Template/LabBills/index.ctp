<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Lab Bills') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs" style="margin-bottom: 5px">
        <li class="active"><?= $this->Html->link(__('Generate Lab Bills'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List of Lab Bills'), ['action' => 'lists']) ?></li>
    </ul>
</div>
<?= $this->Form->create($labBill, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="row" style="margin-top: 40px">
    <div class="col-sm-offset-2 col-sm-7">
        <?= $this->Form->input('related_to', ['options' => ['letter' => __('Letter'), 'scheme' => __('Scheme')]]); ?>
        <div class="lists">
            <?= $this->Form->input('letter_id', ['options' => $labLetterRegisters, 'empty' => __('Select'), 'id' => 'scheme-id']); ?>
        </div>
    </div>
    <div class="col-sm-offset-2 col-sm-7 text-center">
        <span id="submit" class="btn btn-primary"><?= __('Generate Bill') ?></span>
    </div>

</div>

<div class="row" style="margin-top: 60px">

    <div id="result" style="display: none">
        <div class="col-sm-12">
            <button style="float: right" onclick="print_rpt()">Print</button>
        </div>
        <div id="PrintArea">
            <div class="col-sm-12 text-center" style="font-size: 16px;margin-bottom:20px">
                <span>Government of the People's Republic of Bangladesh</span><br>
                <span>Local Government Engineering Department</span><br>
                <span>Office of the Executive Engineer</span><br>
                <span>Gazipur</span><br>

            </div>

            <div class="col-sm-10 scheme_info" style="margin-bottom: 20px">

            </div>
            <div class="col-sm-2 date">
                <span><b>Date: </b> <?= date('d-m-Y') ?> </span>
            </div>
            <div class="col-sm-12" style="display: block">
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

                    </tbody>
                </table>
            </div>
            <div class="col-sm-9 text-right balance_label" style="margin-top: 10px">
                <span>Total Amount Tk.</span><br>
                <span>Test Fee Paid Up to Previous Bill Tk.</span><br>
                <span>Net payable this bill Tk.</span><br>
                <span><b>Tk.=</b></span><br>
            </div>
            <div class="col-sm-3 balance_value" style="margin-top: 10px">
                <span id="total"></span><br>
                <span id="previous">0</span><br>
                <span id="net_total"></span><br>

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

        <input type="hidden" name="total_amount" value="" id="total_amount">
        <input type="hidden" name="net_payable" value="" id="net_payable_amount">

        <div class="col-md-6" style="margin-top: 30px">
            <?php echo $this->Form->input('selected_nothi', ['value' => "", 'disabled']) ?>
            <?php echo $this->Form->input('parent_id', ['required', 'options' => $nothiRegisters, 'empty' => __('Select'), 'templates' => ['inputContainer' => '<div class="form-group nothi_register {{type}}{{required}}">{{content}}</div>']]); ?>
        </div>
        <div class="col-sm-6 user" style="display: none;margin-top: 30px">
            <div class="form-group input select">
                <label for="user" class="col-sm-3 control-label text-right"><?= __('User') ?></label>
                <div class="col-sm-9 container_subject">
                    <select id="user" class="form-control multi-select" multiple="multiple" name="user[]">
                        <?php
                        $dept = "";
                        foreach ($departments as $department) { ?>
                        <?php if ($department['name_bn'] != $dept) { ?>
                        <optgroup label="<?= $department['name_bn'] ?>">
                            <?php $dept = $department['name_bn'];
                            } ?>
                            <?php if (isset($department['users']['name_bn'])) { ?>
                                <option
                                    value="<?= $department['users']['id'] ?>"><?= $department['users']['name_bn'] . " (" . $department['designations']['name_bn'] . ")" ?></option>
                            <?php }
                            } ?>
                    </select>
                </div>
            </div>
            <div style="margin-top: 15px"></div>
            <?= $this->Form->input('subject') ?>
            <div style="margin-top: 15px"></div>
            <?= $this->Form->input('message', ['type' => 'textarea']) ?>
        </div>
        <div class="col-sm-12 form-actions text-right" style="padding-right: 0">
            <span id="save_send" class="btn btn-primary"><?= __('Save and Send') ?></span>
            <input id="save" type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
        </div>


    </div>
</div>
<?= $this->Form->end() ?>
<div class="row not_found" style="display: none;text-align: center">
    <div class="col-sm-12">
        <h3>No test found!. Please try again with another scheme </h3>
    </div>
</div>

<script>
    function print_rpt() {
        URL = "<?php echo $this->request->webroot; ?>page/Print_a4_Eng.php?selLayer=PrintArea";
        day = new Date();
        id = day.getTime();
        eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=yes,scrollbars=yes ,location=0,statusbar=0 ,menubar=yes,resizable=1,width=880,height=600,left = 20,top = 50');");
    }
</script>

<script type="text/javascript">
    $(document).ready(function () {

        $(document).on("click", "#submit", function (event) {
            event.preventDefault();
            var related_to = $('#related-to').val();
            var scheme_id = $('#scheme-id').val(); //letter_id=scheme_id when related_to = letter
            if (scheme_id) {
                $.ajax({
                    url: '<?=$this->Url->build(('/LabBills/report'), true)?>',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        type: related_to,
                        scheme_id: scheme_id
                    },
                    success: function (data, status) {
//                        console.log(data);
//                        data = JSON.parse(data);
                        var scheme = data['scheme'];
                        var prebill = data['prebill'];
                        var i = 1;
                        var html;
                        var dataYear = '<?= date('Y'); ?>';
                        var total = 0;
                        var previous = 0;
                        if (prebill != null) {
                            previous = prebill.total_amount;
                        }
                        console.log(data['test'])
                        var net_total = 0;
                        if (!$.isEmptyObject(data['test'])) {
                            $.each(data['test'], function (key, value) {
//                                console.log(value)
                                html = html + '<tr>'
                                    + '<td>' + i++ + '</td>'
                                    + '<td>' + value.lab_test_short_name + '</td>'
                                    + '<td>' + (value.number_of_test - value.latest_number_of_test) + '</td>'
                                    + '<td>' + value.latest_number_of_test + '</td>'
                                    + '<td>' + value.rate + '</td>'
                                    + '<td>' + (value.total - value.latest_total) + '</td>'
                                    + '<td>' + (value.total) + '</td>'
                                    + '</tr>';

                                total = total + value.total;

                            })

                            if (related_to == 'letter') {
                                var scheme_info = '<span><b>Memo No: </b>LGED/XEN/GAZI/' + dataYear + '</span><br><br>'
                                    + '<span><b>Name: </b>' + (scheme.received_from ? scheme.received_from : "") + '</span><br><br>'
                                    + '<span><b>Subject: </b>' + (scheme.subject ? scheme.subject : "") + '</span><br><br>';
                            } else if (related_to == 'scheme') {
                                var scheme_info = '<span><b>Memo No: </b>LGED/XEN/GAZI/' + dataYear + '/ </span><br><br>'
                                    + '<span><b>Name of Project: </b>' + (scheme[0].projects.name_bn ? scheme[0].projects.name_bn : "") + ' </span><br>'
                                    + '<span><b>Name of Work: </b>' + (scheme[0].name_bn ? scheme[0].name_bn : "") + ' </span><br>'
                                    + '<span><b>Name of Contractor: </b>' + (isNaN(scheme[0].contractors.contractor_title) ? scheme[0].contractors.contractor_title : "") + '</span><br>'
                                    + '<span><b>Name of Package: </b>' + (scheme[0].packages.name_bn ? scheme[0].packages.name_bn : "") + ' </span>';
                            }

                            net_total = total - previous;

                            $('#total').html(total);
                            $('#total_amount').val(total);
                            $('#previous').html(previous);
                            $('#net_total').html(net_total);
                            $('#net_payable_amount').val(net_total);

                            $('.scheme_info').html(scheme_info);
                            $('.test_list').html(html);
                            $('#result').show();
                            $('.not_found').hide();
                            if (net_total <= 0) {
                                $('#save_send').hide();
                                $('#save').hide();
                            } else {
                                $('#save_send').show();
                                $('#save').show();
                            }
                        } else {
                            $('#result').hide();
                            $('.not_found').show();
                        }
                    }

                });
            }

        });

        $(document).on('click', '#save_send', function () {
            $('.user').show();
            $('#save_send').hide();
            $('#save').val('Save & Send')
        });

        $(document).on('change', '#related-to', function () {
            var type = $(this).val();

            $.ajax({
                type: 'POST',
                url: '<?= $this->request->webroot ?>LabBills/getSchemeLists',
                data: {type: type},
                success: function (data, status) {
                    $('.lists').html(data);
                },
                error: function (xhr, desc, err) {

                }
            })
        });

        $(document).on('change', '#parent-id', function () {
            var parent_id = $(this).val();
            var obj = $(this);
            $.ajax({
                type: 'POST',
                url: '<?= $this->Url->build("/NothiRegisters/getSubNothi")?>',
                data: {parent_id: parent_id},
                success: function (data, status) {
                    obj.closest('.nothi_register').nextAll('.nothi_register').remove();
                    if (data) {
                        obj.closest('.form-group').after(data);
                    }
                }
            });
        });


    });
</script>
