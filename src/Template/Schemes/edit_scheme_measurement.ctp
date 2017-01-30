
<div>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#list_measurement" aria-controls="list_measurement" role="tab"
                                                  data-toggle="tab">List</a></li>
        <li role="presentation"><a href="#add_measurement" aria-controls="add_measurement" role="tab" data-toggle="tab">Add
                measurement </a></li>

    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane  active" id="list_measurement">


            <div class="panel panel-default">
                <div class="panel-heading">

                    <h6 class="panel-title"><i class="icon-table2"></i>Measurement  List</h6>


                </div>
                <div class="panel-body">




                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <?php foreach ($measurement_info as $key => $single_info): ?>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion"
                                           href="#<?= $key ?>" aria-expanded="false" aria-controls="collapseOne">
                                            Measurement no: <?= $key ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="<?= $key ?>" class="panel-collapse collapse " role="tabpanel"
                                     aria-labelledby="headingOne">
                                    <div class="panel-body">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td>Measured By</td>
                                                <td>Item Code</td>
                                                <td>Description</td>
                                                <td>Unit</td>
                                                <td>Work done</td>

                                            </tr>
                                            <?php foreach ($single_info['info'] as $row): ?>
                                                <tr>
                                                    <td><?= $row['measured_by']?></td>
                                                    <td><?= $row['item_display_code']?></td>
                                                    <td><?= substr($row['description'],0,25) ?></td>
                                                    <td><?= $row['unit']?></td>
                                                    <td><?= $row['quantity_of_work_done']?></td>

                                                </tr>
                                            <?php endforeach; ?>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>


                    </div>

                </div>

            </div>

        </div>
        <div role="tabpanel" class="tab-pane fade" id="add_measurement">

            <div class="panel panel-default">
                <div class="panel-heading">

                    <h6 class="panel-title"><i class="icon-table2"></i>Add measurement </h6>


                </div>
                <div class="panel-body">

                    <form class="form-horizontal" id="progress_form" method="post">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Measurement no:</label>
                                <!--                                <input type="hidden" name="scheme_id" value="-->
                                <? //= $id ?><!--">-->
                                <input name="measurement_no" required type="number" class="form-control" id="measurement_no" value="">
                            </div>
                        </div>

                        <div class="col-md-3 col-md-offset-1">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Measurement Date:</label>
                                <!--                                <input type="hidden" name="scheme_id" value="-->
                                <? //= $id ?><!--">-->
                                <input type="text" name="measurement_date" required class="form-control hasdatepicker"
                                       id="measurement_date" value="">
                            </div>

                        </div>

                        <div class="col-md-3 col-md-offset-1">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Measured By:</label>
                                <!--                                <input type="hidden" name="scheme_id" value="-->
                                <? //= $id ?><!--">-->
                                <input type="text" name="measured-by" required class="form-control " id="measured-by" value="">
                            </div>

                        </div>


                        <table class="table table-bordered">

                            <tr>
                                <td width="15%">Iteme Code</td>
                                <td width="55%">Description</td>
                                <td width="15% ">BBQ</td>
                                <td width="15% ">Quantity of work done</td>
                            </tr>

                            <?php foreach ($items as $key => $item): ?>
                                <tr>
                                    <td><input type="text" id="" class="form-control " name=""
                                               value="<?= $item['item_display_code'] ?>" readonly>
                                        <input type="hidden" id="" class="form-control "
                                               name=" measurement[<?= $key ?>][item_id]"
                                               value="<?= $item['id'] ?>" readonly>
                                    </td>
                                    <td><input type="text" id="" class="form-control " name=""
                                               value="<?= $item['description'] ?>" readonly>
                                    </td>

                                    <td><input type="text" id="bbq" class="form-control bbq" name=""
                                               value="<?= $item['quantity'] ?>" readonly>
                                    </td>
                                    <td><input type="text" id="" class="form-control quantity_of_work_done"
                                               name="measurement[<?= $key ?>][quantity_of_work_done]" required="required">
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>


                        <div class="col-md-12 text-right">
                            <br>
                            <input type="submit" id="measurement-post" class="btn btn-default" value="Submit">
                        </div>
                    </form>


                </div>

            </div>


        </div>

    </div>
</div>
<script>
    $(document).ready(function () {
        var display_date_format = "dd-M-yy";

        $(".hasdatepicker").datepicker({
            dateFormat: display_date_format,
            changeMonth: true,
            changeYear: true,
            yearRange: "-50:+10"
        });

        $(document).off("click", "#measurement-post");

        $(document).on('click', '#measurement-post', function (event) {
            event.preventDefault();

            var measurement_no=$('#measurement_no').val();
            var measurement_date=$('#measurement_date').val();
            var measured_by=$('#measured-by').val();
            var scheme_id = $('[name=scheme_id]').val();

            if(measurement_no && measurement_date && measured_by){
                $.ajax({
                    type: "POST",
                    url: '<?= $this->Url->build("/Schemes/edit_scheme_measurement")?>/' + scheme_id,
                    data: $(this).closest('form').serialize(),
                    timeout: 3000,
                    success: function (response) {
                        $('#item_bbq').html(response);
                        $('#scheme_measurements').trigger('click');
                    }
                });

            }else {
                alert('Please check your Inputs, And try again!!')
            }
        });

        $(document).on('keyup','.quantity_of_work_done',function(event){
            var work_done= parseFloat($(this).val());
            var bbq =parseFloat($(this).closest('tr').find('.bbq').val());
            if(work_done>bbq){
                $(this).val(0);
            }
    });


    });
</script>

