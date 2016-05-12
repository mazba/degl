<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Nothi Registers'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Nothi') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Nothi'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1) {
            ?>
            <li><?= $this->Html->link(__('New Nothi'), ['action' => 'add']) ?></li>
            <?php
        }
        ?>
        <?php
        if ($user_roles['edit'] == 1) {
            ?>
            <li><?= $this->Html->link(__('Edit Nothi'), ['action' => 'edit', $nothiRegister->id]) ?></li>
            <?php
        }
        ?>
        <?php
        if ($user_roles['delete'] == 1) {
            ?>
            <li><?=
                $this->Form->postLink(__('Delete Nothi'), ['action' => 'delete', $nothiRegister->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $nothiRegister->id)]) ?>
            </li>
            <?php
        }
        ?>

        <li class="active"><?=
            $this->Html->link(__('Details Nothi'), ['action' => 'view', $nothiRegister->id
            ]) ?>
        </li>
    </ul>
</div>
<div class="row">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h6 class="panel-title"><i class="icon-table2"></i><?= __('Nothi Details') ?></h6>
        </div>
        <div class="panel-body">
            <div class="col-md-12">
                <table class="table table-striped">
                    <tbody>
                    <?php if ($nothiRegister->parent_id) { ?>
                        <tr>
                            <th><?= __('Nothi') ?> :</th>
                            <td>
                                <?= $nothiRegister->nothi_register['nothi_no'] ?>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <th><?= __('Office') ?> :</th>
                        <td><?=
                            $nothiRegister->has('office') ?
                                $this->Html->link($nothiRegister->office
                                    ->name_en, ['controller' => 'Offices',
                                    'action' => 'view', $nothiRegister->office
                                        ->id]) : '' ?>
                        </td>
                    </tr>
                    <tr>
                        <th><?= __('Nothi Description') ?> :</th>
                        <td>
                            <?= h($nothiRegister->nothi_description) ?>
                        </td>
                    </tr>
                    <tr>
                        <th><?= __('Nothi No') ?> :</th>
                        <td>
                            <?= h($nothiRegister->nothi_no) ?>
                        </td>
                    </tr>



                    <tr>
                        <th><?= __('Nothi Date') ?> :</th>
                        <td>
                            <?= $this->System->display_date($nothiRegister->nothi_date) ?>
                        </td>
                    </tr>
                    <tr>
                        <th><?= __('Status') ?> :</th>
                        <td>
                            <?php
                            if ($nothiRegister->status == 1) {
                                ?>
                                <div class="panel-body"><?= __('Active') ?></div>
                                <?php
                            } elseif ($nothiRegister->status == 0) {
                                ?>
                                <div class="panel-body"><?= __('In-Active') ?></div>
                                <?php
                            } else {
                                ?>
                                <div class="panel-body"><?php echo $nothiRegister->status; ?></div>
                                <?php

                            }
                            ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h6 class="panel-title">
                    <i class="icon-file"></i>
                    <?= __('Nothi Related Projects') ?>
                </h6>
            </div>
            <div id="projects">

            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h6 class="panel-title">
                    <i class="icon-file"></i>
                    <?= __('Nothi Related Schemes') ?>
                </h6>
            </div>
            <div id="schemes">

            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h6 class="panel-title">
                    <i class="icon-file"></i>
                    <?= __('Nothi Related Dak Files') ?>
                </h6>
            </div>
            <div id="dak_files">

            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h6 class="panel-title">
                    <i class="icon-file"></i>
                    <?= __('Nothi Related Lab Bills') ?>
                </h6>
            </div>
            <div id="lab_bills">

            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h6 class="panel-title">
                    <i class="icon-file"></i>
                    <?= __('Nothi Related Mechanical Bills') ?>
                </h6>
            </div>
            <div id="mechanical_bills">

            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h6 class="panel-title">
                    <i class="icon-file"></i>
                    <?= __('Nothi Related Purto Bills') ?>
                </h6>
            </div>
            <div id="purto_bills">

            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h6 class="panel-title">
                    <i class="icon-file"></i>
                    <?= __('Nothi Related Allotments') ?>
                </h6>
            </div>
            <div id="allotments">

            </div>
        </div>
    </div>


</div>


<script type="text/javascript">
    $(document).ready(function () {
        var url = "<?php echo $this->request->webroot; ?>NothiRegisters/ajax/get_dak_file/<?= $nothiRegister->id; ?>";
        // prepare the data
        var source =
        {
            dataType: "json",
            dataFields: [
                {name: 'id', type: 'int'},
                {name: 'sender_name', type: 'string'},
                {name: 'subject', type: 'string'},
                {name: 'sender_office_name', type: 'string'},
                {name: 'created_date', type: 'string'},
                {name: 'action', type: 'string'}
            ],
            id: 'id',
            url: url
        };

        var dataAdapter = new $.jqx.dataAdapter(source);

        $("#dak_files").jqxGrid(
            {
                width: '100%',
                source: dataAdapter,
                pageable: true,
                filterable: true,
                sortable: true,
                showfilterrow: true,
                columnsresize: true,
                pagesize: 15,
                pagesizeoptions: ['100', '200', '300', '500', '1000', '1500'],
//                selectionmode: 'checkbox',
                altrows: true,
                autoheight: true,


                columns: [
                    {text: '<?= __('Sender Name') ?>', dataField: 'sender_name', width: '20%'},
                    {text: '<?= __('Sender Office Name') ?>', dataField: 'sender_office_name', width: '22%'},
                    {text: '<?= __('Subject') ?>', dataField: 'subject', width: '40%'},
                    {text: '<?= __('Date') ?>', dataField: 'created_date', width: '10%'},
                    {text: '<?= __('Actions') ?>', cellsalign: 'center', dataField: 'action', width: '8%'}
                ]
            });


        //Projects
        var url2 = "<?php echo $this->request->webroot; ?>NothiRegisters/ajax/get_projects/<?= $nothiRegister->id; ?>";
        // prepare the data
        var source2 =
        {
            dataType: "json",
            dataFields: [
                {name: 'short_code', type: 'string'},
                {name: 'name_bn', type: 'string'},
                {name: 'development_partner', type: 'string'},
                {name: 'action', type: 'string'}
            ],
            id: 'id',
            url: url2
        };

        var dataAdapter2 = new $.jqx.dataAdapter(source2);

        $("#projects").jqxGrid(
            {
                width: '100%',
                source: dataAdapter2,
                pageable: true,
                filterable: true,
                sortable: true,
                showfilterrow: true,
                columnsresize: true,
                pagesize: 15,
                pagesizeoptions: ['100', '200', '300', '500', '1000', '1500'],
//                selectionmode: 'checkbox',
                altrows: true,
                autoheight: true,


                columns: [
                    {text: '<?= __('Short Code') ?>', dataField: 'short_code', width: '20%'},
                    {text: '<?= __('Name') ?>', dataField: 'name_bn', width: '50%'},
                    {text: '<?= __('Development Partner') ?>', dataField: 'development_partner', width: '22%'},
                    {text: '<?= __('Actions') ?>', cellsalign: 'center', dataField: 'action', width: '8%'}
                ]
            });

        //Schemes
        var url3 = "<?php echo $this->request->webroot; ?>NothiRegisters/ajax/get_schemes/<?= $nothiRegister->id; ?>";
        // prepare the data
        var source3 =
        {
            dataType: "json",
            dataFields: [
                {name: 'name_bn', type: 'string'},
                {name: 'scheme_code', type: 'string'},
                {name: 'action', type: 'string'}
            ],
            id: 'id',
            url: url3
        };

        var dataAdapter3 = new $.jqx.dataAdapter(source3);

        $("#schemes").jqxGrid(
            {
                width: '100%',
                source: dataAdapter3,
                pageable: true,
                filterable: true,
                sortable: true,
                showfilterrow: true,
                columnsresize: true,
                pagesize: 15,
                pagesizeoptions: ['100', '200', '300', '500', '1000', '1500'],
//                selectionmode: 'checkbox',
                altrows: true,
                autoheight: true,


                columns: [
                    {text: '<?= __('Name') ?>', dataField: 'name_bn', width: '70%'},
                    {text: '<?= __('Scheme Code') ?>', dataField: 'scheme_code', width: '22%'},
                    {text: '<?= __('Actions') ?>', cellsalign: 'center', dataField: 'action', width: '8%'}
                ]
            });

        //Lab Bills
        var url4 = "<?php echo $this->request->webroot; ?>NothiRegisters/ajax/get_lab_bills/<?= $nothiRegister->id; ?>";
        // prepare the data
        var source4 =
        {
            dataType: "json",
            dataFields: [
                {name: 'title', type: 'string'},
                {name: 'type', type: 'string'},
                {name: 'total_amount', type: 'string'},
                {name: 'net_payable', type: 'string'},
                {name: 'action', type: 'string'}
            ],
            id: 'id',
            url: url4
        };

        var dataAdapter4 = new $.jqx.dataAdapter(source4);

        $("#lab_bills").jqxGrid(
            {
                width: '100%',
                source: dataAdapter4,
                pageable: true,
                filterable: true,
                sortable: true,
                showfilterrow: true,
                columnsresize: true,
                pagesize: 15,
                pagesizeoptions: ['100', '200', '300', '500', '1000', '1500'],
//                selectionmode: 'checkbox',
                altrows: true,
                autoheight: true,


                columns: [
                    {text: '<?= __('Title') ?>', dataField: 'title', width: '40%'},
                    {text: '<?= __('Type') ?>', dataField: 'type', width: '10%'},
                    {text: '<?= __('Total Amount') ?>', dataField: 'total_amount', width: '21%'},
                    {text: '<?= __('Net Payable') ?>', dataField: 'net_payable', width: '21%'},
                    {text: '<?= __('Actions') ?>', cellsalign: 'center', dataField: 'action', width: '8%'}
                ]
            });

        //Mechanical Bills
        var url5 = "<?php echo $this->request->webroot; ?>NothiRegisters/ajax/get_mechanical_bills/<?= $nothiRegister->id; ?>";
        // prepare the data
        var source5 =
        {
            dataType: "json",
            dataFields: [
                {name: 'title', type: 'string'},
                {name: 'total_amount', type: 'string'},
                {name: 'net_payable', type: 'string'},
                {name: 'action', type: 'string'}
            ],
            id: 'id',
            url: url5
        };

        var dataAdapter5 = new $.jqx.dataAdapter(source5);

        $("#mechanical_bills").jqxGrid(
            {
                width: '100%',
                source: dataAdapter5,
                pageable: true,
                filterable: true,
                sortable: true,
                showfilterrow: true,
                columnsresize: true,
                pagesize: 15,
                pagesizeoptions: ['100', '200', '300', '500', '1000', '1500'],
//                selectionmode: 'checkbox',
                altrows: true,
                autoheight: true,


                columns: [
                    {text: '<?= __('Title') ?>', dataField: 'title', width: '50%'},
                    {text: '<?= __('Total Amount') ?>', dataField: 'total_amount', width: '21%'},
                    {text: '<?= __('Net Payable') ?>', dataField: 'net_payable', width: '21%'},
                    {text: '<?= __('Actions') ?>', cellsalign: 'center', dataField: 'action', width: '8%'}
                ]
            });

        //Purto Bills
        var url6 = "<?php echo $this->request->webroot; ?>NothiRegisters/ajax/get_purto_bills/<?= $nothiRegister->id; ?>";
        // prepare the data
        var source6 =
        {
            dataType: "json",
            dataFields: [
                {name: 'bill_type', type: 'string'},
                {name: 'bill_date', type: 'string'},
                {name: 'gross_bill', type: 'string'},
                {name: 'net_bill', type: 'string'},
                {name: 'action', type: 'string'}
            ],
            id: 'id',
            url: url6
        };

        var dataAdapter6 = new $.jqx.dataAdapter(source6);

        $("#purto_bills").jqxGrid(
            {
                width: '100%',
                source: dataAdapter6,
                pageable: true,
                filterable: true,
                sortable: true,
                showfilterrow: true,
                columnsresize: true,
                pagesize: 15,
                pagesizeoptions: ['100', '200', '300', '500', '1000', '1500'],
//                selectionmode: 'checkbox',
                altrows: true,
                autoheight: true,


                columns: [
                    {text: '<?= __('Bill Type') ?>', dataField: 'bill_type', width: '32%'},
                    {text: '<?= __('Bill Date') ?>', dataField: 'bill_date', width: '20%'},
                    {text: '<?= __('Gross Bill') ?>', dataField: 'gross_bill', width: '20%'},
                    {text: '<?= __('Net Bill') ?>', dataField: 'net_bill', width: '20%'},
                    {text: '<?= __('Actions') ?>', cellsalign: 'center', dataField: 'action', width: '8%'}
                ]
            });
        
        //Purto Bills
        var url7 = "<?php echo $this->request->webroot; ?>NothiRegisters/ajax/get_allotments/<?= $nothiRegister->id; ?>";
        // prepare the data
        var source7 =
        {
            dataType: "json",
            dataFields: [
                {name: 'project', type: 'string'},
                {name: 'allotment_date', type: 'string'},
                {name: 'dr_cr', type: 'string'},
                {name: 'allotment_amount', type: 'string'},
                {name: 'action', type: 'string'}
            ],
            id: 'id',
            url: url7
        };

        var dataAdapter7 = new $.jqx.dataAdapter(source7);

        $("#allotments").jqxGrid(
            {
                width: '100%',
                source: dataAdapter7,
                pageable: true,
                filterable: true,
                sortable: true,
                showfilterrow: true,
                columnsresize: true,
                pagesize: 15,
                pagesizeoptions: ['100', '200', '300', '500', '1000', '1500'],
//                selectionmode: 'checkbox',
                altrows: true,
                autoheight: true,


                columns: [
                    {text: '<?= __('Project') ?>', dataField: 'project', width: '32%'},
                    {text: '<?= __('Debit/Credit') ?>', dataField: 'dr_cr', width: '20%'},
                    {text: '<?= __('Allotment Date') ?>', dataField: 'allotment_date', width: '20%'},
                    {text: '<?= __('Allotment Amount') ?>', dataField: 'allotment_amount', width: '20%'},
                    {text: '<?= __('Actions') ?>', cellsalign: 'center', dataField: 'action', width: '8%'}
                ]
            });


    });
</script>