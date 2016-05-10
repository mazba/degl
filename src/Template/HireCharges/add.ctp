<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Hire Charges'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('New Hire Charges') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Hire Charges'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('New Hire Charges'), ['action' => 'add']) ?></li>
    </ul>
</div>
<?= $this->Form->create($hireCharge, ['class' => 'form-horizontal', 'role' => 'form', 'type' => 'file']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Hire Charges') ?>
        </h6></div>
    <div class="panel-body col-sm-7 col-sm-offset-2">
        <?php echo $this->Form->input('parent_id', ['required', 'options' => $nothiRegisters, 'empty' => __('Select'), 'templates' => ['inputContainer' => '<div class="form-group nothi_register {{type}}{{required}}">{{content}}</div>']]); ?>
        <div class="form-group">
            <label class="col-sm-3 control-label text-right"><?= __('Scheme: ') ?></label>
            <div class="col-sm-9">
                <select data-placeholder="Choose a Scheme" class="chosen-select" id="scheme-id" name="scheme_id"
                        class="form-control scheme_id" required="required">
                    <option title=" " value=""><?= __('Select') ?></option>
                    <?php
                    foreach ($schemes as $id => $scheme) {
                        ?>
                        <option title="<?= $scheme ?>" value="<?= $id ?>"><?= $scheme ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <?php
        echo $this->Form->input('financial_year_id', ['options' => $FinancialYearEstimates, 'empty' => __('Select')]);
        ?>
    </div>
    <div class="row show-grid">
        <div class="col-xs-4">
            <label class="control-label pull-right"><?= __('Item Code') ?></label>
        </div>
        <div class="col-xs-4">
            <input type="text" value="" class="form-control" id="input_item_add">
        </div>
        <div class="col-xs-1">
            <button type="button" class="btn btn-danger" id="button_item_add"><?= __('Add') ?></button>
        </div>
        <div class="col-xs-3">
            <div class="alert alert-warning fade in block-inner" id="add_item_noti" style="display: none">
                <i class="icon-warning"></i> <?= __('No Previous Charges found for this Scheme. Please Add.') ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-responsive table-bordered" style="border: 1px solid #eee; margin: 5px 5px">
                <thead>
                <tr style="background: #ebebeb">
                    <th><?= __('Item Code') ?></th>
                    <th><?= __('Item of Work') ?></th>
                    <th><?= __('Unit') ?></th>
                    <th><?= __('Total Quantity of work done') ?></th>
                    <th><?= __('Rate of Charge Quantities(Tk.)') ?></th>
                    <th><?= __('Total Amount(Tk.)') ?></th>
                    <th><?= __('Delete') ?></th>
                </tr>
                <tr style="background: #f0fafb">
                    <th class="text-center"><?= __('1') ?></th>
                    <th class="text-center"><?= __('2') ?></th>
                    <th class="text-center"><?= __('3') ?></th>
                    <th class="text-center"><?= __('4') ?></th>
                    <th class="text-center"><?= __('5') ?></th>
                    <th class="text-center"><?= __('6') ?></th>
                    <th class="text-center"><?= __('7') ?></th>
                </tr>
                </thead>
                <tbody id="container_items_input" data-current-row="0">

                </tbody>
                <tfoot>
                <tr>
                    <td colspan="5" style="text-align: right; font-weight: bold">Total</td>
                    <td colspan="2"><input required="" type="text" class="form-control" name="total_amount"
                                           id="main_total"/></td>
                </tr>
                <tr>
                    <td colspan="5" style="text-align: right;font-weight: bold">Paid up to previous Bill</td>
                    <td colspan="2"><input type="text" class="form-control" value="" id="previous_bill"/></td>
                </tr>
                <tr>
                    <td colspan="5" style="text-align: right;font-weight: bold">Net Payable</td>
                    <td colspan="2"><input required="" type="text" class="form-control" name="net_payable"
                                           id="net_payable"/></td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="col-sm-6 user">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h6 class="panel-title">
                    <a id="collapsed_click" href="#colorOne" data-parent="#accordion-color" data-toggle="collapse"
                       class="collapsed"><?= __('Send to Users') ?></a>
                </h6>
            </div>
            <div class="panel-collapse collapse" id="colorOne">
                <div class="panel-body">
                    <select id="user" class="form-control multi-select" multiple="multiple" name="user[]">
                        <?php foreach ($departments as $department) { ?>
                            <optgroup label="<?= $department->name_bn ?>">
                                <?php foreach ($department['users'] as $user) { ?>
                                    <option
                                        value="<?= $user['id'] ?>"><?= $user['name_bn'] . " (" . $user['designation']['name_bn'] . ")" ?></option>
                                <?php } ?>
                            </optgroup>
                        <?php } ?>
                    </select>
                    <?= $this->Form->input('subject', ['style' => 'margin-top:10px;']); ?>
                    <?= $this->Form->input('message', ['type' => 'textarea']) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 form-actions text-right">
        <input id="save" type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
        <input id="save_and_send" type="submit" value="<?= __('Save & Send') ?>" class="btn btn-danger">
    </div>
</div>
<?= $this->Form->end() ?>
<script>
    $(document).ready(function () {
        $(document).on("change", "#scheme-id", function (event) {
            var scheme_id = $(this).val();
            $('#add_item_noti').hide()
            $('#container_items_input').html('');
            $('#previous_bill').val('');
            $('#net_payable').val('');
            $('#main_total').val('');
            if (scheme_id) {
                $.ajax({
                    url: '<?=$this->Url->build(('/HireCharges/ajax/get_scheme_wise_items'), true)?>',
                    type: 'POST',
                    data: {scheme_id: scheme_id},
                    success: function (data, status) {
                        if (data.trim() != 'NOT_FOUND') {
                            $('#container_items_input').html(data);
                            $('#previous_bill').val($('#old_bill').val());
                            cal_total();
                        }
                        else {
                            $('#add_item_noti').show()
                        }
                    },
                    error: function (xhr, desc, err) {
                        console.log("error");
                    }
                });
            }
        });
        $(document).on("click", "#button_item_add", function (event) {
            var item_code = $('#input_item_add').val();
            $('#input_item_add').val('');
            var scheme_id = $('#scheme-id').val();
            var financial_year_id = $('#financial-year-id').val();
            if (item_code) {
                var found = false;
                $('#container_items_input > tr').each(function () {
                    if ($(this).attr('data-item-code') == item_code) {
                        found = true;
                        return false;
                    }
                });
                if (found) {
                    alert("<?= __('This item already added. Add more element.') ?>");
                }
                else {
                    $.ajax({
                        url: '<?=$this->Url->build(('/HireCharges/ajax/get_item'), true)?>',
                        type: 'POST',
                        data: {item_code: item_code, financial_year_id: financial_year_id, scheme_id: scheme_id},
                        success: function (data, status) {
                            if (data.trim() == 'NOT_FOUND') {
                                var html_row = '<tr data-item-code="' + item_code + '">' +
                                    '<td><input name="items[' + item_code + '][item_code]" value="' + item_code + '" class="form-control"/></td>' +
                                    '<td><input name="items[' + item_code + '][description]" class="form-control"/></td>' +
                                    '<td><input name="items[' + item_code + '][item_unit]" class="form-control"/></td>' +
                                    '<td><input name="items[' + item_code + '][quantity]" class="form-control quantity calculate"/></td>' +
                                    '<td><input name="items[' + item_code + '][rate]" class="form-control rate calculate"/></td>' +
                                    '<td><input name="items[' + item_code + '][item_total]" class="form-control total"/></td>' +
                                    '<td><button class="btn btn-icon btn-danger button_remove_item" type="button"><i class="icon-close"></i></button></td>' +
                                    '</tr>';
                                $('#container_items_input').append(html_row);
                            }
                            else {
                                $('#container_items_input').append(data);
                                //console.log(data);
                            }
                        },
                        error: function (xhr, desc, err) {
                            console.log("error");
                        }
                    });
                }
            }
            else {
                alert("<?= __('Item Code cannot be empty') ?>");
            }
        });
        $(document).on("click", ".button_remove_item", function (event) {
            $(this).closest('tr').remove();
            cal_total();
        });
        $(document).on("keyup", ".calculate", function (event) {
            var quantity = parseFloat($(this).closest('tr').find('.quantity').val());
            var rate = parseFloat($(this).closest('tr').find('.rate').val());
            $(this).closest('tr').find('.total').val('');
            if (quantity && rate) {
                $(this).closest('tr').find('.total').val(quantity * rate);
            }
            cal_total();
        });
        $(document).on("click", "#save", function (event) {
            $('#user').val([]);
        });
        $(document).on("click", "#save_and_send", function (event) {

            if ($('#collapsed_click').hasClass('collapsed')) {
                event.preventDefault();
                $('#collapsed_click').trigger('click');
            }
            else {
                var user = $('#user').find(":selected").val();
                var subject = $('#subject').val();
                var message = $('#message').val();
                if (!user || !subject || !message) {
                    alert('<?= __('Users, Subject , Message is Required Fields'); ?>');
                    event.preventDefault();
                }

            }

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
    function cal_total() {
        var total = 0;
        $('.total').each(function () {
            if ($(this).val()) {
                total += parseFloat($(this).val());
            }
        });
        total = total.toFixed(2);
        $('#main_total').val(total);
        var net_payable = total;
        if (parseFloat($('#previous_bill').val())) {
            net_payable = total - parseFloat($('#previous_bill').val());
        }
//        net_payable = net_payable.toFixed(2)
//        console.log(net_payable)
        $('#net_payable').val(net_payable);
    }
</script>
