<?php
use Cake\Core\Configure;

?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Proposed Ra Bills'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('New Proposed Ra Bill') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Proposed Ra Bills'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('New Proposed Ra Bill'), ['action' => 'add']) ?></li>
    </ul>
</div>


<?= $this->Form->create($proposedRaBill, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="row panel panel-default">
    <div class="panel-heading">
        <h6 class="panel-title">
            <i class="icon-paragraph-right2"></i><?= __('Add Proposed Ra Bill') ?>
        </h6>
    </div>
    <div class="panel-body col-sm-12" style="padding-bottom: 0px;">
        <div class="form-group input col-md-4">
            <label class="col-sm-3 control-label text-right"><?= __('Scheme') ?></label>

            <div class="col-sm-9 actual_complete_date">
                <select class="form-control" name="scheme_id" id="scheme-id">
                    <option value=""><?= __('Select') ?></option>
                    <?php
                    foreach ($schemes as $scheme_id => $scheme) {
                        ?>
                        <option value="<?php echo $scheme_id; ?>"><?php echo $scheme; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group input col-md-4" id="measurement_book_wrp">
            <label class="col-sm-4 control-label text-right"><?= __('Measurement') ?></label>

            <div class="col-sm-8">
                <select type="text" class="form-control" id="measurement_no" name="measurement_no" required="required">
                </select>
            </div>
        </div>

        <div class="form-group input col-md-4" id="bill_type_wrap">
            <label class="col-sm-4 control-label text-right"><?= __('Type') ?></label>

            <div class="col-sm-8">
                <select type="text" class="form-control" id="bill_type" name="bill_type" required="required">
                    <option value="">Select</option>
                    <option value="1">General</option>
                    <option value="2">Final</option>
                </select>
            </div>
        </div>
    </div>
    <div id="items_wrp" class="panel-body col-sm-12" style="padding-top: 0px;">

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
<script type="text/javascript">
    jQuery(document).ready(function () {
        $('#bill_type_wrap').hide();
        $(document).on("change", "#scheme-id", function (event) {
            $('#items_wrp').html('');
            var scheme_id = $(this).val();
            if (scheme_id) {
                $.ajax({
                    url: '<?= $this->Url->build(('/ProposedRaBills/ajax/get_measurement_books'), true) ?>',
                    type: 'POST',
                    data: {scheme_id: scheme_id},
                    success: function (data, status) {
                        if (data) {
                            data = JSON.parse(data);
                            var html = '<option value="">নির্বাচন করুন</option>';
                            $.each(data, function (key, value) {
                                html = html + '<option value="' + key + '">' + value + '</option>';
                            })
//
//                            data = JSON.parse(data);
//                            var html = '<option value="">Select</option>';
//                            $.each( data, function( key, value ) {
//                                html += '<option value="'+ key+'">'+ value+'</option>';
//                            });
                            $('#measurement_no').html(html);
                        }
                    },
                    error: function (xhr, desc, err) {
                        console.log("error");
                    }
                });
            }
            else {
                alert("Scheme cannot be empty");
            }
        });


        $(document).on("change", "#measurement_no", function (event) {
            $('#bill_type_wrap').show();
            $('#items_wrp').html('');


        });

        $(document).on("change", "#bill_type", function (event) {
            $('#items_wrp').html('');
            var measurement_no = $('#measurement_no').val();
            var scheme_id = $('#scheme-id').val();
            var bill_type = $(this).val();

            if (bill_type) {
                if (bill_type == 1) {
                    if (measurement_no) {
                        $.ajax({
                            url: '<?= $this->Url->build(('/ProposedRaBills/ajax/get_items'), true) ?>',
                            type: 'POST',
                            data: {scheme_id: scheme_id, measurement_no: measurement_no},
                            success: function (data, status) {
                                if (data) {
                                    $('#items_wrp').html(data);
                                }
//                                calculate_total();
                            },
                            error: function (xhr, desc, err) {
                                console.log("error");
                            }
                        });
                    }
                    else {
                        alert("Measurement cannot be empty");
                    }
                }else {
                    if (measurement_no) {
                        $.ajax({
                            url: '<?= $this->Url->build(('/ProposedRaBills/ajax/get_final_items'), true) ?>',
                            type: 'POST',
                            data: {scheme_id: scheme_id, measurement_no: measurement_no},
                            success: function (data, status) {
                                if (data) {
                                    $('#items_wrp').html(data);
                                }
//                                calculate_total();
                            },
                            error: function (xhr, desc, err) {
                                console.log("error");
                            }
                        });
                    }
                    else {
                        alert("Measurement cannot be empty");
                    }
                }
            }

        });

        $(document).on("click", "#remove_item", function (event) {
            event.preventDefault();
            var id = $(this).data('item-id');
            $(this).closest('tr').remove();
//            calculate_total();
            $("#above_or_less").val('');
            $('#percentage_wrp').hide();
            $('#so_far_payable_wrp').hide();
            $('#percentage_vale_wrp').hide();
            $('#bill_amount_wrp').hide();
        });

        $(document).on("change", "#above_or_less", function (event) {
            var above_or_less = $(this).val();
            if (above_or_less == 'ABOVE') {
                $('#percentage_wrp').show();
            }
            else if (above_or_less == 'LESS') {
                $('#percentage_wrp').show();
            }
            else {
                $('#percentage_wrp').hide();
                $('#so_far_payable_wrp').hide();
                $('#percentage_vale_wrp').hide();
                $('#bill_amount_wrp').hide();
            }
            $('#percentage_vale').val('');
            $('#percentage').val('');
            $('#so_far_payable').val('');
            $('#bill_amount').val('');
        });
        $(document).on("keyup", "#percentage", function (event) {

            console.log($(this).val())
            var percentage = parseFloat($(this).val());
            var above_or_less = $('#above_or_less').val();
            var total_payable = parseFloat($('#total_payable').val());
            console.log(total_payable);
            var up_to_date_approved = parseFloat($('#up_to_date_approved').html());
            // console.log(up_to_date_approved);
            var so_far_payable = 0;
            var bill_amount = 0;
            if (percentage || percentage==0) {
                var percentage_value = (total_payable * percentage) / 100;
                percentage_value = parseFloat(percentage_value.toFixed(2));
                if (above_or_less == 'ABOVE') {

                    so_far_payable = total_payable + percentage_value;
                    //bill_amount = so_far_payable - up_to_date_approved;
					  bill_amount = so_far_payable;
                    //bill_amount = so_far_payable;
                    console.log(bill_amount);
                }
                else {
                    so_far_payable = total_payable - percentage_value;
                    //bill_amount = so_far_payable - up_to_date_approved;
                     bill_amount = so_far_payable;
                    // bill_amount = so_far_payable;
                }
                $('#so_far_payable').val(so_far_payable);
                $('#so_far_payable_wrp').show();
                $('#percentage_vale').val(percentage_value);
                $('#percentage_vale_wrp').show();
                $('#bill_amount').val(bill_amount);
                $('#bill_amount_wrp').show();
                $('#up_to_date_approved_wrp').show();

            }
            else {
                $('#so_far_payable_wrp').hide();
                $('#so_far_payable').val('');
                $('#percentage_vale_wrp').hide();
                $('#percentage').val('');
                $('#bill_amount').val('');
                $('#bill_amount_wrp').hide();
                $('#up_to_date_approved_wrp').hide();
            }
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
    });

   /* function calculate_total() {
        var total = 0;
        $(".payable").each(function (index) {
            total += parseInt($(this).text());

        });
        console.log(total);
        $('#show_total').html(total);
        $('#total_payable').val(total);
    }*/

    //    function so_far_payable(){
    //        var total= $('#show_total').html();
    //        var above_or_less= $('#above_or_less').val();
    //        var so_far_payable= $('so_far_payable').html();
    //        var value= 0;
    //
    //        if(above_or_less=="ABOVE"){
    //            value= total+so_far_payable;
    //            $('#total_payables').val(value);
    //
    //        }
    //    }
</script>