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
        <div class="form-group input col-md-6">
            <label class="col-sm-3 control-label text-right"><?= __('Scheme') ?></label>
            <div class="col-sm-9 actual_complete_date">
                <select class="form-control" name="scheme_id" id="scheme-id">
                    <option value=""><?= __('Select') ?></option>
                        <?php
                            foreach($schemes as $scheme_id=>$scheme)
                            {
                               ?>
                                <option value="<?php echo $scheme_id; ?>"><?php echo $scheme;  ?></option>
                               <?php
                            }
                        ?>
                </select>
            </div>
        </div>
        <div class="form-group input col-md-6" id="measurement_book_wrp">
            <label class="col-sm-4 control-label text-right"><?= __('Measurement') ?></label>
            <div class="col-sm-8">
                <select type="text" class="form-control" id="measurement_book_id" name="measurement_book_id" required="required">
                </select>
            </div>
        </div>
    </div>
    <div id="items_wrp" class="panel-body col-sm-12" style="padding-top: 0px;">

    </div>
</div>
<?= $this->Form->end() ?>
<script type="text/javascript">
    jQuery(document).ready(function()
    {
        $(document).on("change", "#scheme-id", function(event)
        {
            $('#items_wrp').html('');
            var scheme_id = $(this).val();
            if(scheme_id)
            {
                $.ajax({
                    url: '<?= $this->Url->build(('/ProposedRaBills/ajax/get_measurement_books'), true) ?>',
                    type: 'POST',
                    data:{scheme_id:scheme_id},
                    success: function (data, status)
                    {
                        if(data)
                        {
                            var json = jQuery.parseJSON(data);
                            var html = '<option value="">Select</option>';
                            $.each( json, function( key, value ) {
                                html += '<option value="'+ value.id+'">'+ value.book_no+'</option>';
                            });
                            $('#measurement_book_id').html(html);
                        }
                    },
                    error: function (xhr, desc, err)
                    {
                        console.log("error");
                    }
                });
            }
            else
            {
                alert("Scheme cannot be empty");
            }
        });
        $(document).on("change", "#measurement_book_id", function(event)
        {
            $('#items_wrp').html('');
            var measurement_book_id = $(this).val();
            var scheme_id = $('#scheme-id').val();
            if(measurement_book_id)
            {
                $.ajax({
                    url: '<?= $this->Url->build(('/ProposedRaBills/ajax/get_items'), true) ?>',
                    type: 'POST',
                    data:{scheme_id:scheme_id,measurement_book_id:measurement_book_id},
                    success: function (data, status)
                    {
                        if(data)
                        {
                            $('#items_wrp').html(data);
                        }
                    },
                    error: function (xhr, desc, err)
                    {
                        console.log("error");
                    }
                });
            }
            else
            {
                alert("Measurement cannot be empty");
            }
        });
        $(document).on("change", "#above_or_less", function(event)
        {
            var above_or_less = $(this).val();
            if(above_or_less == 'ABOVE')
            {
                $('#percentage_wrp').show();
            }
            else if(above_or_less == 'LESS')
            {
                $('#percentage_wrp').show();
            }
            else
            {
                $('#percentage_wrp').hide();
                $('#so_far_payable_wrp').hide();
                $('#percentage_vale_wrp').hide();
                $('#bill_amount_wrp').hide();
            }
            $('#percentage_vale').val('');
            $('#percentage').val('');
            $('#so_far_payable').html('');
            $('#bill_amount').val('');
        });
        $(document).on("keyup", "#percentage", function(event)
        {
            var percentage = parseFloat($(this).val());
            var above_or_less = $('#above_or_less').val();
            var total_payable = parseFloat($('#total_payable').val());
            var up_to_date_approved = parseFloat($('#up_to_date_approved').html());
            var so_far_payable = 0;
            var bill_amount = 0;
            if(percentage)
            {
                var percentage_value = (total_payable*percentage)/100;
                percentage_value = parseFloat(percentage_value.toFixed(2));
                if(above_or_less == 'ABOVE')
                {

                    so_far_payable = total_payable + percentage_value;
                    bill_amount = so_far_payable - up_to_date_approved;
                }
                else
                {
                    so_far_payable = total_payable - percentage_value;
                }
                $('#so_far_payable').html(so_far_payable);
                $('#so_far_payable_wrp').show();
                $('#percentage_vale').val(percentage_value);
                $('#percentage_vale_wrp').show();
                $('#bill_amount').val(bill_amount);
                $('#bill_amount_wrp').show();
                $('#up_to_date_approved_wrp').show();
            }
            else
            {
                $('#so_far_payable_wrp').hide();
                $('#so_far_payable').html('');
                $('#percentage_vale_wrp').hide();
                $('#percentage').val('');
                $('#bill_amount').val('');
                $('#bill_amount_wrp').hide();
                $('#up_to_date_approved_wrp').hide();
            }
        });
    });
</script>