<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Vehicles') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Vehicles'), ['action' => 'index']) ?></li>
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
        var url = "<?php echo $this->request->webroot; ?>VehiclesStatus/ajax/get_grid_data";

        // prepare the data
        var source =
        {
            dataType: "json",
            dataFields: [
                { name: 'id', type: 'int' },
                { name: 'title', type: 'string' },
                { name: 'serviceCost', type: 'string' },
                { name: 'vehicle_location', type: 'string' },
                { name: 'vehicle_status', type: 'string' },
                { name: 'employee', type: 'string' },
                { name: 'schemes', type: 'string' },
                { name: 'daily_cost_ratio', type: 'string' },
                { name: 'assign_date', type: 'string' },
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
                pagesize:50,
                pagesizeoptions: ['100', '200', '300', '500','1000','1500'],
//                selectionmode: 'checkbox',
                altrows: true,
                autoheight: true,


                columns: [
                    { text: '<?= __('#') ?>',cellsalign: 'center' ,dataField: 'id',width:'5%'},
                    { text: '<?= __('Title') ?>', dataField: 'title',width:'16%'},
                    { text: '<?= __('Vehicle Status') ?>', dataField: 'vehicle_status',width:'7%'},
                    { text: '<?= 'বর্তমান অবস্থান' ?>',dataField: 'vehicle_location',width:'10%'},
                    { text: '<?= __('Driver') ?>', dataField: 'employee',width:'10%'},
                    { text: '<?= __('Scheme') ?>', dataField: 'schemes',width:'22%'},
                    { text: '<?= __('Service Cost') ?>', dataField: 'serviceCost',width:'6%'},
                    { text: '<?= __('Daily Cost Ratio') ?>', dataField: 'daily_cost_ratio',width:'5%'},
                    { text: '<?= __('Assign Date') ?>', dataField: 'assign_date',width:'10%'},
                    { text: '<?= __('Action') ?>', cellsalign: 'center',dataField: 'action',width:'9%'}

                ]
            });

    });
</script>