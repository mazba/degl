<?php
use Cake\Core\Configure;
use Cake\Routing\Router;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Measurement Books') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Measurement'), ['action' => 'measurement_index',$id]) ?></li>
    </ul>
</div>
<div class="measurementBooks index panel panel-default">
    <div class="panel-heading">
        <h6 class="panel-title"><i class="icon-table"></i><?= __('Edit Measurement') ?></h6>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" role="role" method="post" action="<?php echo Router::url('/',true); ?>measurement_books/edit_measurement/<?php echo $id; ?>/<?php echo $measurement_no; ?>">
            <div id="container" class="row">
                <div class="col-md-12">
                    <div class="form-group input">
                        <label class="col-sm-2 control-label"><?= __('Measurement Date') ?></label>
                        <div class="col-sm-3 tender_documents">
                            <input type="text" class="form-control hasdatepicker" value="<?php echo date('d-M-y',$old_measurements[0]['measurement_date']); ?>" name="measurement_date" required="required">
                        </div>
                    </div>
                </div>
                <?php
                $key=0;
                foreach($old_measurements as $key=>$item)
                {
                    ?>
                    <div class="item_wrp col-md-12">
                        <hr>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <div class="form-group col-sm-3">
                            <div class="col-md-12">
                                <label class="col-sm-4 control-label text-right"><?= __('Items') ?></label>
                                <div class="col-sm-8">
                                    <select type="text" class="form-control item" name="item[<?php echo $key ?>][id]" required="required">
                                        <option value=""><?= __('Select') ?></option>
                                        <?php
                                        foreach($scheme_details as $scheme_detail)
                                        {
                                        ?>
                                            <option value="<?php echo $scheme_detail['id'] ?>" <?php echo ($item['scheme_details_id'] == $scheme_detail['id'] ? 'selected' : '') ?>><?php echo $scheme_detail['item_code'].' ('.$scheme_detail['comp_serial_no'].')' ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label text-right"><?= __('Work Done') ?></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control quantity_of_work_done" name="item[<?php echo $key ?>][quantity_of_work_done]" value="<?php echo $item['quantity_of_work_done']; ?>" required="required">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9 item_details">
                            <table class="table table-bordered show-grid">
                                <thead>
                                <tr style="background:#ED5F40; color: #fff; font-weight: bold; text-align: center">
                                    <td><?= __('Details') ?></td>
                                    <td><?= __('Comp Sl') ?></td>
                                    <td><?= __('Item Unit') ?></td>
                                    <?php
                                    if($item['scheme_details']['item_unit']=='cum')
                                    {
                                        ?>
                                        <td><?= __('Length') ?></td>
                                        <td><?= __('Width') ?></td>
                                        <td><?= __('Height') ?></td>
                                        <td><?= __('Volume') ?></td>
                                    <?php
                                    }
                                    elseif($item['scheme_details']['item_unit']=='sqm')
                                    {
                                        ?>
                                        <td><?= __('Length') ?></td>
                                        <td><?= __('Width') ?></td>
                                        <td><?= __('Area') ?></td>
                                    <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <td><?= __('No of items') ?></td>
                                    <?php
                                    }
                                    ?>
                                    <td><?= __('Rate') ?></td>
                                    <td><?= __('Total') ?></td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <?php
                                    $string = $item['scheme_details']['details'];
                                    if (strlen($string) > 50)
                                    {
                                        // truncate string
                                        $stringCut = substr($string, 0, 50);
                                        $string = substr($stringCut, 0, strrpos($stringCut, ' ')).' ...';
                                    }

                                    ?>
                                    <td title="<?php echo $item['scheme_details']['details'] ?>"><?= $string ?></td>
                                    <td><?php echo $item['scheme_details']['comp_serial_no'] ?></td>
                                    <td><?php echo $item['scheme_details']['item_unit'] ?></td>
                                    <?php
                                    if($item['scheme_details']['item_unit']=='cum')
                                    {
                                        ?>
                                        <td><?php echo $item['scheme_details']['cl_length'] ?></td>
                                        <td><?php echo $item['scheme_details']['cl_width'] ?></td>
                                        <td><?php echo $item['scheme_details']['cl_height_depth'] ?></td>
                                        <td><?php echo $item['scheme_details']['cl_area_volume'] ?></td>
                                    <?php
                                    }
                                    elseif($item['scheme_details']['item_unit']=='sqm')
                                    {
                                        ?>
                                        <td><?php echo $item['scheme_details']['cl_length'] ?></td>
                                        <td><?php echo $item['scheme_details']['cl_width'] ?></td>
                                        <td><?php echo $item['scheme_details']['cl_area_volume'] ?></td>
                                    <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <td><?php echo $item['scheme_details']['item_quantity'] ?></td>
                                    <?php
                                    }
                                    ?>
                                    <td><?php echo $item['scheme_details']['rate'] ?></td>
                                    <td><?php echo $item['scheme_details']['total'] ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="col-md-12">
                <button type="button" id="add_more_btn" class="btn btn-icon btn-danger pull-right"><i class="icon-arrow-down8"></i></button>
            </div>
            <div class="col-md-2 col-md-offset-5">
                <button type="submit" style="margin: 0 auto;" class="btn btn-sm btn-info"><?= __('Save') ?></button>
            </div>
        </form>
    </div>
</div>
<!--END THE MAIN HTML-->

<div class="hidden" id="hidden_content" data-current-id="<?php echo $key; ?>">
    <div class="item_wrp col-md-12">
        <hr>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <div class="form-group col-sm-3">
            <div class="col-md-12">
                <label class="col-sm-4 control-label text-right"><?= __('Items') ?></label>
                <div class="col-sm-8">
                    <select type="text" class="form-control item" name="item[<?php echo $key; ?>][id]" required="required">
                        <option value=""><?= __('Select') ?></option>
                        <?php
                        foreach($scheme_details as $scheme_detail)
                        {
                        ?>
                            <option value="<?php echo $scheme_detail['id'] ?>" ><?php echo $scheme_detail['item_code'].' ('.$scheme_detail['comp_serial_no'].')' ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label class="col-sm-4 control-label text-right"><?= __('Work Done') ?></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control quantity_of_work_done" name="item[<?php echo $key; ?>][quantity_of_work_done]" required="required">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9 item_details">

        </div>
    </div>
</div>
<style>
    tr > td{
        padding: 7px 6px!important;
        text-align: center;
    }
</style>
<script type="text/javascript">
    jQuery(document).ready(function()
    {
        $(document).on("click", "#add_more_btn", function(event)
        {
            var current_id=parseInt($('#hidden_content').attr('data-current-id'));
            current_id=current_id+1;
            $('#hidden_content').attr('data-current-id',current_id);
            $('#hidden_content .item').attr('name','item['+current_id+'][id]');
            $('#hidden_content .quantity_of_work_done').attr('name','item['+current_id+'][quantity_of_work_done]');
            var html=$('#hidden_content').html();
            $('#container').append(html);
        });
        // Change item
        $(document).on("change", ".item", function(event)
        {
            var item_details = $(this).closest('.item_wrp').find('.item_details');

            var scheme_details_id = $(this).val();
            var measurement_book_id = <?php echo $id; ?>;
            //check already exits
            var found = 0;
            $('#container .item').each(function(i){

               if($(this).val() == scheme_details_id)
               {
                   found++;
               }
            });
            if(found >1)
            {
                alert('The same item cannot be selected more than once.');
                $(this).val('')
                $(item_details).html('');
                return false;
            }
            // Send Ajax
            if(scheme_details_id > 0)
            {
                $.ajax({
                    url: '<?=$this->Url->build(('/MeasurementBooks/get_item_details'), true)?>',
                    type: 'POST',
                    data:{scheme_details_id:scheme_details_id,measurement_book_id:measurement_book_id},
                    success: function (data, status)
                    {
                        $(item_details).html(data);
                    },
                    error: function (xhr, desc, err)
                    {
                        console.log("error");

                    }
                });
            }
            else
            {
                alert("Item cannot be empty");
                $(item_details).html('');
            }
        });
    });
</script>