<?php
use Cake\Routing\Router;
?>

<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Scheme Details'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('Scheme Approve') ?></li>
    </ul>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Scheme English Name') ?></h6></div>
            <div class="panel-body"><?= h($scheme->name_en) ?></div>
        </div>

    </div>
    <div class="col-md-6">

        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Scheme Bangla Name') ?></h6></div>
            <div class="panel-body"><?= h($scheme->name_bn) ?></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Scheme Code') ?></h6></div>
            <div class="panel-body"><?= h($scheme->scheme_code) ?></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('District') ?></h6></div>
            <div class="panel-body"><?= $scheme->has('district') ?h($scheme->district->name_en):'' ?></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Upazila') ?></h6></div>
            <div class="panel-body"><?= $scheme->has('upazila') ?h($scheme->upazila->name_en):'' ?></div>
        </div>
    </div>
    <div class="col-md-3">

        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Municipality') ?></h6></div>
            <div class="panel-body"><?= $scheme->has('municipality')?h($scheme->municipality->name_en):'' ?></div>
        </div>

    </div>
</div>

<form class="form-horizontal" role="role" method="post" action="<?php echo Router::url('/',true); ?>scheme_details/revise/<?php echo $scheme->id; ?>">
<div class="row">
    <div class="col-md-6">
        <div class="col-md-12 show-grid">
            <div class="form-group input">
                <label class="col-sm-5 control-label text-right"><?= __('Proposed Start Date') ?></label>
                <div class="col-sm-7 proposed_start_date">
                    <input type="text" name="scheme[proposed_start_date]" class="form-control hasdatepicker" value="<?php echo $this->System->display_date($scheme->proposed_start_date); ?>" multiple required="required">
                </div>
            </div>
        </div>
        <div class="col-md-12 show-grid">
            <div class="form-group input">
                <label class="col-sm-5 control-label text-right"><?= __('Tender Date') ?></label>
                <div class="col-sm-7 tender_date">
                    <input type="text" name="scheme[tender_date]" class="form-control hasdatepicker" value="<?php echo $this->System->display_date($scheme->tender_date); ?>" multiple required="required">
                </div>
            </div>
        </div>
        <div class="col-md-12 show-grid">
            <div class="form-group input">
                <label class="col-sm-5 control-label text-right"><?= __('Expected Complete Date') ?></label>
                <div class="col-sm-7 expected_complete_date">
                    <input type="text" name="scheme[expected_complete_date]" class="form-control hasdatepicker" value="<?php echo $this->System->display_date($scheme->expected_complete_date); ?>" multiple required="required">
                </div>
            </div>
        </div>
        <div class="col-md-12 show-grid">
            <div class="form-group input">
                <label class="col-sm-5 control-label text-right"><?= __('Actual Start Date') ?></label>
                <div class="col-sm-7 actual_start_date">
                    <input type="text" name="scheme[actual_start_date]" class="form-control hasdatepicker" value="<?php echo $this->System->display_date($scheme->actual_start_date); ?>" multiple required="required">
                </div>
            </div>
        </div>
        <div class="col-md-12 show-grid">
            <div class="form-group input">
                <label class="col-sm-5 control-label text-right"><?= __('Actual Complete Date') ?></label>
                <div class="col-sm-7 actual_complete_date">
                    <input type="text" name="scheme[actual_complete_date]" class="form-control hasdatepicker" value="<?php echo $this->System->display_date($scheme->actual_complete_date); ?>" multiple required="required">
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="col-md-12 show-grid">
            <div class="form-group input">
                <label class="col-sm-5 control-label text-right"><?= __('District') ?></label>
                <div class="col-sm-7 district_id">
                    <select class="form-control" name="scheme[district_id]" id="district-id">
                        <option value=""><?= __('Select District') ?></option>
                        <?php
                            foreach($districts as $district)
                            {

                               ?>
                                <option <?php echo ($scheme->district_id == $district['id']? 'selected': '' ); ?> value="<?php echo $district['id']; ?>"><?php echo $district['name_en']; ?></option>
                                <?php
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-12 show-grid">
            <div class="form-group input">
                <label class="col-sm-5 control-label text-right"><?= __('Municipality') ?></label>
                <div class="col-sm-7 municipality_id">
                    <select class="form-control" name="scheme[municipality_id]" id="municipality-id">
                        <option value=""><?= __('Select Municipality') ?></option>
                        <?php
                            foreach($municipalities as $municipality)
                            {
                               ?>
                                <option <?php echo ($scheme->municipality_id == $municipality['id']? 'selected': '' ); ?> value="<?php echo $municipality['id']; ?>"><?php echo $municipality['name_en']; ?></option>
                                <?php
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-12 show-grid">
            <div class="form-group input">
                <label class="col-sm-5 control-label text-right"><?= __('Upazila') ?></label>
                <div class="col-sm-7 upazila_id">
                    <select class="form-control" name="scheme[upazila_id]" id="upazila-id">
                        <option value=""><?= __('Select Upazila') ?></option>
                        <?php
                            foreach($upazilas as $upazila)
                            {
                               ?>
                                <option <?php echo ($scheme->upazila_id == $upazila['id']? 'selected': '' ); ?> value="<?php echo $upazila['id']; ?>"><?php echo $upazila['name_en']; ?></option>
                                <?php
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>

    </div>

</div>


<div class="row show-grid">
    <div class="col-xs-4">
        <label class="control-label pull-right"><?= __('Item Code') ?></label>
    </div>
    <div class="col-xs-4">
        <input id="input_item_add" type="text" class="form-control" value="">
    </div>
    <div class="col-xs-4">
        <button id="button_item_add" class="btn btn-primary" type="button"><?= __('Add') ?></button>
    </div>
    <input type="hidden" name="scheme_id" id="scheme_id" value="<?php echo $scheme->id ?>"/>
</div>

<div class="row show-grid">
    <div class="col-xs-12 text-center">
        <p id="total_wrp"><?= __('Total: ') ?><span class="label label-success" id="total_show"></span></p>
    </div>
</div>



    <div id="container_items_input" style="overflow-x: auto">

    </div>

    <div class="form-actions text-center">
        <input type="submit" value="<?= __('Revise') ?>" class="btn btn-danger">
    </div>
</form>
<script type="text/javascript">
jQuery(document).ready(function()
{
    $(document).on("click", "#button_item_add", function(event)
    {
        var item_code = $('#input_item_add').val();
        var scheme_id = $('#scheme_id').val();
        if(item_code)
        {
            var found=false;
            //console.log($('#container_items_input table').attr('data-item-code'));
            $('#container_items_input table').each(function(){
                if($(this).attr('data-item-code')==item_code)
                {
                    found=true;
                    return false;
                }
            });
            if(found)
            {
                alert("This item already added.Add more element.")
            }
            else
            {
                $.ajax({
                    url: '<?=$this->Url->build(('/SchemeDetails/ajax/get_item'), true)?>',
                    type: 'POST',
                    data:{item_code:item_code,scheme_id:scheme_id},
                    success: function (data, status)
                    {
                        console.log(data);
                        if(data.trim()=='NOT_FOUND')
                        {
                            alert('ITEM NOT FOUND');
                        }
                        else
                        {
                            $('#container_items_input').html(data);
                            //console.log(data);
                        }


                    },
                    error: function (xhr, desc, err)
                    {
                        console.log("error");

                    }
                });
            }
        }
        else
        {
            alert("Item Code cannot be empty");
        }



    });
    $(document).on("click", ".button_remove_item", function(event)
    {
        $(this).closest('table').remove();
        show_total();

    });
    $(document).on("click", ".button_remove_element", function(event)
    {
        $(this).closest('tr').remove();
        show_total();

    });
    $(document).on("click", ".button_add_element", function(event)
    {
        var item_id = $(this).attr('data-item-id');
        var item_unit = $(this).closest('table').attr('data-item-unit');
        var item_rate = $(this).closest('table').attr('data-item-rate');
        var item_code = $(this).closest('table').attr('data-item-code');
        var financial_year = $(this).closest('table').attr('data-financial-year');
        var data_item_table = $(this).closest('table').attr('data-item-table');

        var current_index = $(this).attr('data-last-id');
        current_index++;
        $(this).attr('data-last-id',current_index);
        if(item_unit == 'cum')
        {
            var node='<tr>'+
                '<td><input type="text" name="item_element['+current_index+'][deducation]" value="" required="required"></td>'+
                '<td><input type="text" name="item_element['+current_index+'][comp_serial_no]" value="" required="required"></td>'+
                '<td><input type="text" name="item_element['+current_index+'][component_location]" value="" required="required"></td>'+
                '<td><input type="text" name="item_element['+current_index+'][cl_length]" class="ele_calculation length" value="" required="required"></td>'+
                '<td><input type="text" name="item_element['+current_index+'][cl_width]" class="ele_calculation width" value="" required="required"></td>'+
                '<td><input type="text" name="item_element['+current_index+'][cl_height_depth]" class="ele_calculation height" value="" required="required"></td>'+
                '<td><input type="text" name="item_element['+current_index+'][cl_area_volume]"  readonly="readonly" class="area_volume" value="" required="required"></td>'+
                '<td><input type="text" name="item_element['+current_index+'][rate]" class="ele_calculation rate" value="'+item_rate+'" required="required"></td>'+
                '<td><input type="text" name="item_element['+current_index+'][total]" class="total" value="" required="required"></td>'+
                '<td><input type="text" name="item_element['+current_index+'][remarks]" value=""></td>'+
                '<td><input type="text" name="item_element['+current_index+'][has_breakup]" value=""></td>'+

                '<td><button type="button" class="btn btn-warning button_remove_element">Remove element</button></td>'+
                '</tr>';
        }
        else if(item_unit == 'sqm')
        {
            var node='<tr>'+
                '<td><input type="text" name="item_element['+current_index+'][deducation]" value="" required="required"></td>'+
                '<td><input type="text" name="item_element['+current_index+'][comp_serial_no]" value="" required="required"></td>'+
                '<td><input type="text" name="item_element['+current_index+'][component_location]" value="" required="required"></td>'+
                '<td><input type="text" name="item_element['+current_index+'][cl_length]" class="ele_calculation length" value="" required="required"></td>'+
                '<td><input type="text" name="item_element['+current_index+'][cl_width]" class="ele_calculation width" value="" required="required"></td>'+
                '<td><input type="text" name="item_element['+current_index+'][cl_area_volume]"  readonly="readonly" class="area_volume" value="" required="required"></td>'+
                '<td><input type="text" name="item_element['+current_index+'][rate]" class="ele_calculation rate" value="'+item_rate+'" required="required"></td>'+
                '<td><input type="text" name="item_element['+current_index+'][total]" class="total" value="" required="required"></td>'+
                '<td><input type="text" name="item_element['+current_index+'][remarks]" value=""></td>'+
                '<td><input type="text" name="item_element['+current_index+'][has_breakup]" value=""></td>'+

                '<td><button type="button" class="btn btn-warning button_remove_element">Remove element</button></td>'+
                '</tr>';
        }
        else
        {
            var node='<tr>'+
                '<td><input type="text" name="item_element['+current_index+'][deducation]" value="" required="required"></td>'+
                '<td><input type="text" name="item_element['+current_index+'][comp_serial_no]" value="" required="required"></td>'+
                '<td><input type="text" name="item_element['+current_index+'][component_location]" value="" required="required"></td>'+
                '<td><input type="text" name="item_element['+current_index+'][item_quantity]" class="ele_calculation item_quantity" value="" required="required"></td>'+
                '<td><input type="text" name="item_element['+current_index+'][rate]" class="ele_calculation rate" value="'+item_rate+'" required="required"></td>'+
                '<td><input type="text" name="item_element['+current_index+'][total]" class="total" value="" required="required"></td>'+
                '<td><input type="text" name="item_element['+current_index+'][remarks]" value=""></td>'+
                '<td><input type="text" name="item_element['+current_index+'][has_breakup]" value=""></td>'+

                '<td><button type="button" class="btn btn-warning button_remove_element">Remove element</button></td>'+
                '</tr>';
        }
        $(this).closest('tr').before(node);

    });
    $(document).on("keyup", ".ele_calculation", function(event)
    {
        var item_unit = $(this).closest('table').attr('data-item-unit');
        var tr =  $(this).closest('tr');
        var item_rate = tr.find('.rate').val();
        var area_volume  = 0;

        var this_value = $(this).val();//for checking the value grater than 0
        if(this_value>0)
        {
            if(item_unit == 'cum')
            {
                var length = parseFloat(tr.find('.length').val());
                var width = parseFloat(tr.find('.width').val());
                var height = parseFloat(tr.find('.height').val());
                if(length && width && height)
                {
                    area_volume = (length*width*height);
                    var total = (area_volume*item_rate);
                    tr.find('.area_volume').val(area_volume);
                    tr.find('.total').val(total);
                }
                else
                {
                    tr.find('.area_volume').val('');
                    tr.find('.total').val('');
                }
            }
            else if(item_unit == 'sqm')
            {
                var length = parseFloat(tr.find('.length').val());
                var width = parseFloat(tr.find('.width').val());
                if(length && width)
                {
                    area_volume = (length*width);
                    var total = (area_volume*item_rate);
                    tr.find('.area_volume').val(area_volume);
                    tr.find('.total').val(total);
                }
                else
                {
                    tr.find('.area_volume').val('');
                    tr.find('.total').val('');
                }
            }
            else
            {
                var item_quantity = parseFloat(tr.find('.item_quantity').val());
                if(item_quantity)
                {
                    var total = (item_quantity*item_rate);
                    tr.find('.total').val(total);
                }
                else
                {
                    tr.find('.total').val('');
                }
            }
            show_total();
        }
        else
        {
            $(this).val('');
        }
    });

    $(document).on("change", "#district-id", function(event)
    {

        var district_id = $(this).val();
        $('#upazila-id').html('<option value="">select a upazila</option>');
        $('#municipality-id').html('<option value="">NONE</option>');
        if(district_id)
        {
            $.ajax({
                url: '<?=$this->Url->build(('/SchemeDetails/ajax/get_upazila_municpaltiy_by_disctrict_id'), true)?>',
                type: 'POST',
                dataType:'json',
                data:{district_id:district_id},
                success: function (data, status)
                {
                    var html = '';
                    $.each(data.upazilas,function(i,e)
                    {
                        html += '<option value="'+ e.id+'">'+ e.name_en+'</option>'
                    });
                    $('#upazila-id').html(html);

                    html = '';
                    $.each(data.municipalities,function(i,e)
                    {
                        html += '<option value="'+ e.id+'">'+ e.name_en+'</option>'
                    });
                    $('#municipality-id').html(html);
                },
                error: function (xhr, desc, err)
                {
                    console.log("error");

                }
            });
        }
    });

    // when load data show the total;
    show_total();
});

// SHOW the total of all
function show_total()
{
    var all_total = $('.total');
    var total=0;
    var ele_val;
    $.each(all_total,function(i,ele)
    {
        ele_val = parseFloat($(ele).val());
        if(ele_val>0)
        {
            total += ele_val;
        }
    });
    $('#total_show').html(total);
}
</script>

