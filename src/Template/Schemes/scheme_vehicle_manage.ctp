<div id="container">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#list" aria-controls="work_schedule" role="tab"
                                                  data-toggle="tab"><?=__('Letters')?></a></li>

        <li role="presentation" class=""><a href="#vehicle_list" aria-controls="" role="tab"
                                                  data-toggle="tab"><?=__('Vehicle List')?></a></li>

        <li role="presentation" class=""><a href="#test_list" aria-controls="" role="tab"
                                                  data-toggle="tab"><?=__('Bill List')?></a></li>
       </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane  active" id="list">
            <div class="panel panel-default">
                <div class="panel-heading">

                    <h6 class="panel-title"><i class="icon-table2"></i><?=__('List of Vehicle Letters')?></h6>


                </div>
                <div class="panel-body">


                        <div id="dataTable_vehicle" style="margin-top:5px ">

                        </div>



                </div>

            </div>


        </div>



        <div role="tabpanel" class="tab-pane" id="vehicle_list">
            <div class="panel panel-default">
                <div class="panel-heading">

                    <h6 class="panel-title"><i class="icon-table2"></i><?=__('List of hired Vehicles')?></h6>


                </div>
                <div class="panel-body">

                <table class="table table-bordered">
                    <tr>
                        <td>ID</td>
                        <td>Title</td>
                        <td>Location</td>
                        <td>Remark</td>
                        <td>Assign Date</td>
                    </tr>
                    <?php foreach ($hired_vehicles as $key=>$row): $key++?>
                        <tr>
                            <td><?= $key?></td>
                            <td><?= $row['title']?></td>
                            <td><?= $row['location']?></td>
                            <td><?= $row['remark']?></td>
                            <td><?= date("Y/m/d",$row['assign_date'])?></td>
                        </tr>
                    <?php endforeach;?>
                </table>

                </div>
            </div>
        </div>

        <div role="tabpanel" class="tab-pane" id="test_list">
            <div class="panel panel-default">
                <div class="panel-heading">

                    <h6 class="panel-title"><i class="icon-table2"></i><?=__('List of Hired Vehicle Bills')?></h6>


                </div>
                <div class="panel-body">

                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                       <?php $number=1?>
                        <?php foreach ($details as $key => $detail): ?>
                            <?php $total=0?>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion"
                                           href="#<?= $key ?>" aria-expanded="false" aria-controls="collapseOne">
                                            Bill no: <?= $number ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="<?= $key ?>" class="panel-collapse collapse " role="tabpanel"
                                     aria-labelledby="headingOne">
                                    <div class="panel-body">

                                        <table class="table table-bordered" style="margin:10px 0; border: 1px solid #eee">
                                            <thead>
                                            <tr style="background: #f5f5f5">
                                                <th><?= __('Item Code'); ?></th>
                                                <th><?= __('Item of Work'); ?></th>
                                                <th><?= __('Unit'); ?></th>
                                                <th><?= __('Total Quantity of Work Done'); ?></th>
                                                <th><?= __('Rate of Charge per unit quantities(Tk.)'); ?></th>
                                                <th><?= __('Total Amount(Tk.)'); ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach($detail['info'] as $item)
                                            {
                                                ?>
                                                <tr>
                                                    <td><?= $item['item_code'] ?></td>

                                                    <td style="text-align: justify;"><?= $item['description'] ?></td>
                                                    <td><?= $item['unit'] ?></td>
                                                    <td><?= $item['quantity_done'] ?></td>
                                                    <td><?= $item['item_total']/$item['quantity_done'] ?></td>
                                                    <td><?php $total +=$item['item_total']; echo $item['item_total'] ?></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <td colspan="1"></td>
                                                <td colspan="4" style="text-align: right; font-weight: bold">Total Amount= </td>
                                                <td colspan="1"><?=$total  //$hireCharge->total_amount; ?></td>
                                            </tr> <tr>
                                                <td colspan="1"></td>
                                                <td colspan="4" style="text-align: right; font-weight: bold">Net Payable Amount= </td>
                                                <td colspan="1"><?=$detail['total'] //$hireCharge->total_amount; ?></td>
                                            </tr>
                                            </tfoot>
                                        </table>

                                    </div>
                                </div>
                            </div>
                            <?php $number++?>
                        <?php endforeach; ?>


                    </div>

                </div>
            </div>
        </div>





    </div>
</div>





<!--SCRIPT-->
<script type="text/javascript">
    $(document).ready(function ()
    {
        var url = "<?php echo $this->request->webroot; ?>VehicleHire/ajax/get_grid_data_by_scheme_id/"+<?=$scheme_id?>;

        // prepare the data
        var source =
        {
            dataType: "json",
            dataFields: [
                { name: 'id', type: 'int' },
                { name: 'sarok_no', type: 'string' },
                { name: 'subject', type: 'string' },
                { name: 'total_vehicles', type: 'string' },
                { name: 'schemes', type: 'string' },
                { name: 'action', type: 'string' }
            ],
            id: 'id',
            url: url
        };

        var dataAdapter = new $.jqx.dataAdapter(source);

        $("#dataTable_vehicle").jqxGrid(
            {
                width: '100%',
                source: dataAdapter,
                pageable: true,
                filterable: true,
                sortable: true,
                showfilterrow: true,
                columnsresize: true,
                pagesize:15,
                pagesizeoptions: ['100', '200', '300', '500','1000','1500'],
//                selectionmode: 'checkbox',
                altrows: true,
                autoheight: true,


                columns: [
                    { text: '<?= __('Sarok No') ?>', dataField: 'sarok_no',width:'10%'},
                    { text: '<?= __('Subject') ?>', dataField: 'subject',width:'27%'},
                    { text: '<?= __('Total Vehicles') ?>',dataField: 'total_vehicles',width:'12%'},
                    { text: '<?= __('Schemes') ?>', dataField: 'schemes',width:'36%'},
                    { text: '<?= __('Action') ?>', cellsalign: 'center',dataField: 'action',width:'15%'}
                ]
            });


//        $(document).on('click', '.vehicle_hire_letter', function () {
//            var id = $(this).attr('data-letter-id');
//           if(id){
//               url = '<?//= $this->Url->build("/Schemes/add_vehicle_in_scheme/")?>//' + id;
//               $.ajax({
//                   type: "GET",
//                   url: url,
//                   timeout: 3000,
//                   success: function (response) {
//                       $('#container').html(response)
//                   }
//               });
//           }
//        });


    });


</script>