<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Vehicle Servicing') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Vehicle Servicing'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Vehicle Servicing'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>

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
        var url = "<?php echo $this->request->webroot; ?>VehicleServicings/ajax/get_grid_data";

        // prepare the data
        var source =
        {
            dataType: "json",
            dataFields: [
                { name: 'id', type: 'int' },
                { name: 'office', type: 'string' },
                { name: 'vehicle', type: 'string' },
                { name: 'breakdown_date', type: 'string' },
                { name: 'km_hr', type: 'string' },
                { name: 'servicing_start_date', type: 'string' },
                { name: 'defects', type: 'string' },
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
                    { text: '<?= __('#') ?>',cellsalign: 'center', dataField: 'id',width:'5%'},
                    { text: '<?= __('Office') ?>', dataField: 'office',width:'21%'},
                    { text: '<?= __('Vehicle') ?>', dataField: 'vehicle',width:'15x%'},
                    { text: '<?= __('Breakdown Date') ?>', dataField: 'breakdown_date',width:'10%'},
                    { text: '<?= __('Km Hr') ?>',dataField: 'km_hr',width:'12%'},
                    { text: '<?= __('Servicing Start Date') ?>', dataField: 'servicing_start_date',width:'12%'},
                    { text: '<?= __('Defects') ?>', dataField: 'defects',width:'15%'},
                    { text: '<?= __('Action') ?>', cellsalign: 'center',dataField: 'action',width:'10%'}
                ]
            });
    });
</script>