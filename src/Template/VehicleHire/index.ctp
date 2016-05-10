<?php

?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Vehicles') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of hired Vehicles'), ['action' => 'index']) ?></li>

    </ul>
</div>

<div class="well text-center">
    <div id="dataTable" style="margin-top:5px ">

    </div>
</div>
<!--SCRIPT-->
<script type="text/javascript">
    $(document).ready(function ()
    {
        var url = "<?php echo $this->request->webroot; ?>VehicleHire/ajax/get_grid_data";

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

        $("#dataTable").jqxGrid(
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
    });
</script>