<div>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#list" aria-controls="list" role="tab"
                                                  data-toggle="tab">List</a></li>
        <li role="presentation"><a href="#add" aria-controls="add" role="tab" data-toggle="tab">Add
                item & boq </a></li>

        <li role="presentation" class=""><a href="#estimated_item_list" aria-controls="list" role="tab"
                                            data-toggle="tab">Estimated Items List</a></li>

        <li role="presentation"><a href="#add_estimated_item" aria-controls="add" role="tab" data-toggle="tab">Add
                estimated item </a></li>

    </ul>
    <!-- Tab panes -->
    <div class="tab-content">

        <div role="tabpanel" class="tab-pane  active" id="list">


            <div class="panel panel-default">
                <div class="panel-heading">

                    <h6 class="panel-title"><i class="icon-table2"></i>Item List</h6>


                </div>
                <div class="panel-body">
                    <table class="table  table-bordered">
                        <tr>
                         <td>SL</td>
                            <td>Item Code</td>
                            <td>Description</td>
                            <td>Unit</td>
                            <td>Quantity</td>
                            <td>Rate</td>
                            
                            <td>Action</td>

                        </tr>
                        <?php 
                        $i=1;
                        foreach ($items as $itm): ?>
                            <tr>
                            	<td><?= $i; ?></td>
                                <td><?= $itm['item_display_code'] ?></td>
                                <td><?= $itm['description'] ?></td>
                                <td><?= $itm['unit'] ?></td>
                                <td><?= $itm['quantity'] ?></td>
                                <td><?= $itm['rate'] ?></td>
                                
                                <td id="item_id">
                                    <button class="delete_item btn btn-danger" data-id="<?= $itm['id'] ?>">Delete
                                    </button>
                                </td>
                            </tr>
                        <?php
                        
                        $i++;
                         endforeach ?>

                    </table>


                </div>

            </div>

        </div>

        <div role="tabpanel" class="tab-pane fade" id="add">

            <div class="panel panel-default">
                <div class="panel-heading">

                    <h6 class="panel-title"><i class="icon-table2"></i>Add item </h6>


                </div>
                <div class="panel-body">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="row show-grid">
                                <div class="col-xs-3">
                                    <label class="control-label pull-right">আইটেম কোড</label>
                                </div>
                                <div class="col-xs-3">
                                    <input type="text" id="new_itm" class="form-control" value="">
                                </div>
                                <div class="col-xs-3">
                                    <button id="button_item_add" class="btn btn-danger" type="button">যোগ করুন</button>
                                </div>
                                <div class="col-xs-3">
                                    <div style="display: none" id="add_item"
                                         class="alert alert-warning fade in block-inner">
                                        <i class="icon-warning"></i> Duplicate Items
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="margin-bottom: 20px">
                            <form method="post" id="itm_bbq_form" class="">
                                <div id="items_wrp" data-current="0"></div>
                                <button type="button" id="add_items" class="btn btn-info pull-right"
                                        style="margin-top: 20px; margin-right: 69px">Submit
                                </button>
                            </form>
                        </div>
                        <?php if (isset($success)): ?>
                            <div class="alert alert-success fade in block col-md-11">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <i class="icon-info"></i><?= $success; ?>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger fade in block col-md-11">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <i class="icon-info"></i><?= $error; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div id="hidn-itm">
                        <div class="itm row" style="display: none;">
                            <div class="col-md-2 ">
                                <label for="item_display_code">Item Code</label>
                                <input class="itm-input" type="text" name="item[0][item_display_code]"/>
                            </div>
                            <div class="col-md-2">
                                <label for="description">Description</label>
                                <input class="description" type="text" name="item[0][description]"/>
                            </div>
                            <div class="col-md-2">
                                <label for="unit">Unit</label>
                                <input class="unit" type="text" name="item[0][unit]"/>
                            </div>
                            <div class="col-md-2">
                                <label for="rate">Rate</label>
                                <input type="text" name="item[0][rate]"/>
                            </div>
                            <div class="col-md-2">
                                <label for="quantity">Quantity</label>
                                <input type="text " name="item[0][quantity]"/>
                            </div>
                            <div class="col-md-2">
                                <i class="icon-close"></i>
                            </div>
                            <input type="hidden" class="itm_scheme_id" name="item[0][scheme_id]"/>
                        </div>
                    </div>


                </div>

            </div>


        </div>


        <div role="tabpanel" class="tab-pane" id="estimated_item_list">

            <div class="panel panel-default">
                <div class="panel-heading">

                    <h6 class="panel-title"><i class="icon-table2"></i> Estimated Item List</h6>


                </div>
                <div class="panel-body">
                    <table class="table  table-bordered">
                        <tr>
                            <td>Item Code</td>
                            <td>Description</td>
                            <td>Unit</td>
                            <td>Rate</td>
                            <td>Quantity</td>
                            <td>Action</td>

                        </tr>
                        <?php foreach ($estimated_itms as $itm): ?>
                            <tr>
                                <td><?= $itm['item_display_code'] ?></td>
                                <td><?= $itm['description'] ?></td>
                                <td><?= $itm['unit'] ?></td>
                                <td><?= $itm['rate'] ?></td>
                                <td><?= $itm['quantity'] ?></td>
                                <td id="item_id">
                                    <button class="delete_item btn btn-danger" data-id="<?= $itm['id'] ?>">Delete
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach ?>

                    </table>


                </div>

            </div>

        </div>
        <div role="tabpanel" class="tab-pane fade" id="add_estimated_item">

            <div class="panel panel-default">
                <div class="panel-heading">

                    <h6 class="panel-title"><i class="icon-table2"></i>Add estimated item </h6>


                </div>
                <div class="panel-body">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="row show-grid">
                                <div class="col-xs-3">
                                    <label class="control-label pull-right">আইটেম কোড</label>
                                </div>
                                <div class="col-xs-3">
                                    <input type="text" id="estimated_new_itm" class="form-control" value="">
                                </div>
                                <div class="col-xs-3">
                                    <button id="button_estimated_item_add" class="btn btn-danger" type="button">যোগ করুন</button>
                                </div>
                                <div class="col-xs-3">
                                    <div style="display: none" id="add_item"
                                         class="alert alert-warning fade in block-inner">
                                        <i class="icon-warning"></i> Duplicate Items
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="margin-bottom: 20px">
                            <form method="post" id="itm_bbq_form" class="">
                                <div id="estimated_items_wrp" data-current="0"></div>
                                <button type="button" id="add_estimated_items" class="btn btn-info pull-right"
                                        style="margin-top: 20px; margin-right: 69px">Submit
                                </button>
                            </form>
                        </div>
                    </div>

                    <div id="estimated_hidn-itm">
                        <div class="estimated_itm row" style="display: none;">
                            <div class="col-md-2 ">
                                <label for="item_display_code">Item Code</label>
                                <input class="estimated-itm-input" type="text" name="item[0][item_display_code]"/>
                            </div>
                            <div class="col-md-2">
                                <label for="description">Description</label>
                                <input class="description" type="text" name="item[0][description]"/>
                            </div>
                            <div class="col-md-2">
                                <label for="unit">Unit</label>
                                <input class="unit" type="text" name="item[0][unit]"/>
                            </div>
                            <div class="col-md-2">
                                <label for="rate">Rate</label>
                                <input type="text" name="item[0][rate]"/>
                            </div>
                            <div class="col-md-2">
                                <label for="quantity">Quantity</label>
                                <input type="text " name="item[0][quantity]"/>
                            </div>
                            <div class="col-md-2">
                                <i class="icon-remove"></i>
                            </div>
                            <input type="hidden" class="itm_scheme_id" name="item[0][scheme_id]"/>
                        </div>
                    </div>


                </div>

            </div>


        </div>

    </div>
</div>


<style>
    .icon-close:hover {
        cursor: pointer;
    }
</style>
<script>
    $(document).ready(function () {
        var scheme_id = $('[name=scheme_id]').val();
        $('.itm_scheme_id').val(scheme_id);
        $(document).off("click", "#button_item_add");
        $(document).off("click", "#button_estimated_item_add");
        $(document).off("click", ".delete_item");
        $(document).off("submit", "#itm_bbq_form");
        $(document).off("click", "#add_items");
        $(document).off("click", "#add_estimated_items");

        $(document).on('click', '#add_items', function (event) {
            $(this).prop('disabled', true);
            event.preventDefault();
            if ($('#items_wrp').find('itm-input')) {
                $.ajax({
                    type: "POST",
                    url: '<?= $this->Url->build("/Schemes/edit_item_bbq")?>/' + scheme_id,
                    data: $(this).closest('form').serialize(),
                    timeout: 3000,
                    success: function (response) {
                        $('#item_bbq').html(response);
                        //  $('#item_and_bbq').trigger('click');
                    }
                });
            }
            else {
                alert('No input found!')
            }
        });



        $(document).on('click', '.icon-close', function (event) {
            $(this).closest('.itm').remove();
        });

        $(document).on('click', '.delete_item', function (event) {
            event.preventDefault();
            var id = $(this).data("id");

            $.ajax({
                type: "POST",
                url: '<?= $this->Url->build("/Schemes/delete_item_bbq")?>/' + id,
                // data: $(this).closest('form').serialize(),
                timeout: 3000,
                success: function (response) {
                    //   $('#item_bbq').html(response);
                    $('#item_and_bbq').trigger('click');
                }
            });
        });


        //main part
        $(document).on('click', '#button_item_add', function (event) {
            var index = parseInt($('#items_wrp').attr('data-current'));
            $('#items_wrp').attr('data-current', index + 1);
            // var item = $('#input_item_add').val();
            var itm_val = $('#new_itm').val();
            $('.itm-input').each(function () {
                if (itm_val && $(this).val() == itm_val) {
                    itm_val = false;
                }
            });
            if (itm_val === false) {
                alert('Item already exits');
                return false;
            }


            if (itm_val) {
                $.ajax({
                    type: "POST",
                    url: '<?= $this->Url->build("/Schemes/get_items_by_code")?>',
                    data: {itm_val: itm_val},
                    timeout: 3000,
                    success: function (response) {
                        response = JSON.parse(response);
                        if (response) {

                            var html = $('#hidn-itm .itm').clone().find('input').each(function () {
                                this.name = this.name.replace(/\d+/, index + 1);
                                this.value = '';
                                if ($(this).hasClass('itm-input'))
                                    this.value = itm_val;
                                if ($(this).hasClass('description'))
                                    this.value = response.description;
                                if ($(this).hasClass('unit'))
                                    this.value = response.unit;
                            }).end();
                            $('#items_wrp').append(html)
                            $('#items_wrp .itm').last().show();

                        } else {
                            var html = $('#hidn-itm .itm').clone().find('input').each(function () {
                                this.name = this.name.replace(/\d+/, index + 1);
                                this.value = '';
                                if ($(this).hasClass('itm-input'))
                                    this.value = itm_val;
                            }).end();
                            $('#items_wrp').append(html)
                            $('#items_wrp .itm').last().show();
                        }
                        //  console.log(response);

                    }
                });
            }


        });







        //estimated item part start//
        $(document).on('click', '#add_estimated_items', function (event) {
            $(this).prop('disabled', true);
            event.preventDefault();
            if ($('#estimated_items_wrp').find('estimated-itm-input')) {
                $.ajax({
                    type: "POST",
                    url: '<?= $this->Url->build("/Schemes/add_estimated_item_bbq")?>/' + scheme_id,
                    data: $(this).closest('form').serialize(),
                    timeout: 3000,
                    success: function (response) {

                          $('#item_and_bbq').trigger('click');
                    }
                });
            }
            else {
                alert('No input found!')
            }
        });

        $(document).on('click', '.icon-remove', function (event) {
            $(this).closest('.estimated_itm').remove();
        });


        $(document).on('click', '#button_estimated_item_add', function (event) {

            var index = parseInt($('#estimated_items_wrp').attr('data-current'));
            $('#estimated_items_wrp').attr('data-current', index + 1);
            // var item = $('#input_item_add').val();
            var itm_val = $('#estimated_new_itm').val();
            $('.estimated-itm-input').each(function () {
                if (itm_val && $(this).val() == itm_val) {
                    itm_val = false;
                }
            });
            if (itm_val === false) {
                alert('Item already exits');
                return false;
            }


            if (itm_val) {
                $.ajax({
                    type: "POST",
                    url: '<?= $this->Url->build("/Schemes/get_items_by_code")?>',
                    data: {itm_val: itm_val},
                    timeout: 3000,
                    success: function (response) {
                        response = JSON.parse(response);
                        if (response) {

                            var html = $('#estimated_hidn-itm .estimated_itm').clone().find('input').each(function () {
                                this.name = this.name.replace(/\d+/, index + 1);
                                this.value = '';
                                if ($(this).hasClass('estimated-itm-input'))
                                    this.value = itm_val;
                                if ($(this).hasClass('description'))
                                    this.value = response.description;
                                if ($(this).hasClass('unit'))
                                    this.value = response.unit;
                            }).end();
                            $('#estimated_items_wrp').append(html)
                            $('#estimated_items_wrp .estimated_itm').last().show();

                        } else {
                            var html = $('#estimated_hidn-itm .estimated_itm').clone().find('input').each(function () {
                                this.name = this.name.replace(/\d+/, index + 1);
                                this.value = '';
                                if ($(this).hasClass('estimated-itm-input'))
                                    this.value = itm_val;
                            }).end();
                            $('#estimated_items_wrp').append(html)
                            $('#estimated_items_wrp .estimated_itm').last().show();
                        }
                        //  console.log(response);

                    }
                });
            }


        });
    });
</script>