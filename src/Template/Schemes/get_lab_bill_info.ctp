<div id="">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#lab_letter_list" aria-controls="work_schedule" role="tab"
                                                  data-toggle="tab"><?=__('Letters')?></a></li>



        <li role="presentation" class=""><a href="#lab_bill_list" aria-controls="" role="tab"
                                            data-toggle="tab"><?=__('Bill List')?></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane  active" id="lab_letter_list">
            <div class="panel panel-default">
                <div class="panel-heading">

                    <h6 class="panel-title"><i class="icon-table2"></i><?=__('Lab Test Letters')?></h6>


                </div>
                <div class="panel-body">


                    <div id="lab_dataTable" style="margin-top:5px ">

                    </div>



                </div>

            </div>


        </div>





        <div role="tabpanel" class="tab-pane" id="lab_bill_list">
            <div class="panel panel-default">
                <div class="panel-heading">

                    <h6 class="panel-title"><i class="icon-table2"></i><?=__('List of lab bills')?></h6>


                </div>
                <div class="panel-body">

                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th><?= __('Sl No.') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Up to Last Bill') ?></th>
                            <th><?= __('This Bill') ?></th>
                            <th><?= __('Action') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (sizeof($labBills) > 0) {
                            $net_payable = 0;
                            foreach ($labBills as $key => $labBill) {
                                $net_payable += $labBill->net_payable
                                ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><?= date('d-m-Y', $labBill->created_date) ?></td>
                                    <td><?= $labBill->total_amount - $labBill->net_payable ?></td>
                                    <td><?= $labBill->net_payable ?></td>
                                    <td> <span class="btn btn-info view_detail"><?= __('View') ?></span> </td>
                                    <input type="hidden" class="bill_id"  value="<?= $labBill->id ?>">
                                    <input type="hidden" class="type"  value="<?= $labBill->type ?>">
                                    <input type="hidden" class="reference_id"  value="<?= $labBill->reference_id ?>">
                                </tr>
                                <?php
                            }
                            ?>
                            <tr style="background: #d9d9d9">
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td class="text-right"><?= __('Total') ?></td>
                                <td><?= $net_payable ?></td>
                                <td>&nbsp;</td>
                            </tr>
                            <?php
                        } else {
                            ?>

                            <tr>
                                <td colspan="4"><?= __('No data found.') ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>


        <div class="modal_view"></div>


    </div>
</div>





<script type="text/javascript">
    $(document).ready(function ()
    {

        var url = "<?php echo $this->request->webroot; ?>Schemes/get_lab_grid_data/"+<?=$scheme_id?>;

        // prepare the data
        var source =
        {
            dataType: "json",
            dataFields: [
                { name: 'id', type: 'int' },
                { name: 'receive_date', type: 'string' },
                { name: 'letter_no', type: 'string' },
                { name: 'created_date', type: 'string' },
                { name: 'received_from', type: 'string' },
                { name: 'subject', type: 'string' },
                { name: 'action', type: 'string' }
            ],
            id: 'id',
            url: url
        };

        var dataAdapter = new $.jqx.dataAdapter(source);

        $("#lab_dataTable").jqxGrid(
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
                    { text: '<?= __('#') ?>',cellsalign: 'center', dataField: 'id',width:'5%'},
                    { text: '<?= __('Receive Date') ?>', dataField: 'receive_date',width:'15%'},
                    { text: '<?= __('Sarok No') ?>', dataField: 'letter_no',width:'10%'},
                    { text: '<?= __('Date') ?>', dataField: 'created_date',width:'15x%'},
                    { text: '<?= __('Receive From') ?>',dataField: 'received_from',width:'22%'},
                    { text: '<?= __('Subject') ?>', dataField: 'subject',width:'25%'},
                    { text: '<?= __('Actions') ?>', cellsalign: 'center',dataField: 'action',width:'8%'}
                ]
            });

        $(document).on('click', '.view_detail', function () {
            var obj = $(this);
            var bill_id = obj.closest('tr').find('.bill_id').val();
            var type = obj.closest('tr').find('.type').val();
            var reference_id = obj.closest('tr').find('.reference_id').val();

            $.ajax({
                type: 'POST',
                url: '<?= $this->request->webroot ?>Schemes/getLabBillDetails',
                data: {bill_id: bill_id, type: type, reference_id: reference_id},
                success: function (data, status) {
                    $('.modal_view').html(data)
                    $('#myModal').modal('show');
                },
                error: function (xhr, desc, err) {

                }
            })
        });
    });
</script>

<script>
    function print_rpt() {
        URL = "<?php echo $this->request->webroot; ?>page/Print_a4_Eng.php?selLayer=PrintArea";
        day = new Date();
        id = day.getTime();
        eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=yes,scrollbars=yes ,location=0,statusbar=0 ,menubar=yes,resizable=1,width=880,height=600,left = 20,top = 50');");
    }
</script>