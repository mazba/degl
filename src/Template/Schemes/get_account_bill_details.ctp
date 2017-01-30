
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#ra_bill_letter_list" aria-controls="" role="tab"
                                                  data-toggle="tab"><?=__('Letters')?></a></li>



        <li role="presentation" class=""><a href="#ra_bill_list" aria-controls="" role="tab"
                                            data-toggle="tab"><?=__('Purto Bill List')?></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">

        <div role="tabpanel" class="tab-pane  active" id="ra_bill_letter_list">
            <div class="panel panel-default">
                <div class="panel-heading">

                    <h6 class="panel-title"><i class="icon-table2"></i><?=__('Accounts Letters')?></h6>


                </div>
                <div class="panel-body">

                    <div id="ra_bill_dataTable" style="margin-top:5px ">

                </div>

            </div>


        </div>
        </div>

        <div role="tabpanel" class="tab-pane" id="ra_bill_list">
            <div class="panel panel-default">
                <div class="panel-heading">

                    <h6 class="panel-title"><i class="icon-table2"></i><?=__('List of Purto bills')?></h6>


                </div>
                <div class="panel-body">

                    <div class="panel panel-default">
                        <div class="panel-heading">

                            <h6 class="panel-title"><i class="icon-table2"></i>Bill Information</h6>

                        </div>
                        <div class="panel-body">


                            <table class="table table-bordered">
                                <tr>
                                    <td>Bill NO:</td>
                                    <td>Bill Amount</td>
                                    <td>Hire Charge</td>
                                    <td>Lab Fee</td>
                                    <td>Security</td>
                                    <td>Income Tex</td>
                                    <td>Vat</td>
                                    <td>Net Payed Amount</td>

                                </tr>
                                <?php

                                $total = 0;
                                $total_net_payable = 0;
                                $total_vat = 0;
                                $total_income_tex = 0;
                                $total_security = 0;
                                $total_hire_charge = 0;
                                $total_lab_fee = 0;

                                ?>
                                <?php foreach ($bill_info as $key => $row): ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td>
                                            <strong><?php echo $row['net_payable'] + $row['vat'] + $row['income_tex'] + $row['security'] + $row['lab_fee'] + $row['hire_charge'] ?></strong>
                                            <?php $total +=$row['net_payable'] + $row['vat'] + $row['income_tex'] + $row['security'] + $row['lab_fee'] + $row['hire_charge']?>
                                        </td>
                                        <td><?php $total_hire_charge+=$row['hire_charge']; echo $row['hire_charge'] ?></td>
                                        <td><?php $total_lab_fee +=$row['lab_fee']; echo $row['lab_fee'] ?></td>
                                        <td><?php $total_security +=$row['security']; echo $row['security'] ?></td>
                                        <td><?php $total_income_tex +=$row['income_tex']; echo $row['income_tex'] ?></td>
                                        <td><?php $total_vat +=$row['vat'];  echo $row['vat'] ?></td>
                                        <td><?php $total_net_payable +=$row['net_payable']; echo $row['net_payable'] ?></td>
                                    </tr>

                                <?php endforeach; ?>
                                <!--            <tr>-->
                                <!--                <td colspan="8">Total</td>-->
                                <!--            </tr>-->
                                <tr>
                                    <td><strong>Total</strong></td>
                                    <td><strong><?=$total?></strong></td>
                                    <td><strong><?php echo $total_hire_charge; ?></strong></td>
                                    <td><strong><?php echo $total_lab_fee; ?></strong></td>
                                    <td><strong><?php echo $total_security; ?></strong></td>
                                    <td><strong><?php echo $total_income_tex; ?></strong></td>
                                    <td><strong><?php echo $total_vat; ?></strong></td>
                                    <td><strong><?php echo $total_net_payable; ?></strong></td>
                                </tr>
                            </table>
                        </div>

                    </div>


                </div>
            </div>
        </div>



</div>



    <script type="text/javascript">
        $(document).ready(function ()
        {
            var url = "<?php echo $this->request->webroot; ?>Schemes/get_ra_bill_applications/"+<?=$id?>;


            // prepare the data
            var source =
            {
                dataType: "json",
                dataFields: [
                    { name: 'id', type: 'int' },
                    { name: 'subject', type: 'string' },
                    { name: 'message_text', type: 'string' },
                    { name: 'created_date', type: 'string' },
                    { name: 'action', type: 'string' },

                ],
                id: 'id',
                url: url
            };

            var dataAdapter = new $.jqx.dataAdapter(source);

            $("#ra_bill_dataTable").jqxGrid(
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
                        { text: '<?= __('Subject') ?>', dataField: 'subject',width:'30%'},
                        { text: '<?= __('Message') ?>',dataField: 'message_text',width:'47%'},
                        { text: '<?= __('Date') ?>', dataField: 'created_date',width:'10%'},
                        { text: '<?= __('Actions') ?>', cellsalign: 'center',dataField: 'action',width:'8%'}
                    ]
                });


        });
    </script>

