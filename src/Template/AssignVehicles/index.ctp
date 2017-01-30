<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Assign Vehicles') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Assign Vehicles'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Assign Vehicle'), ['action' => 'add']) ?></li>
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
        var url = "<?php echo $this->request->webroot; ?>AssignVehicles/ajax/get_grid_data";

        // prepare the data
        var source =
        {
            dataType: "json",
            dataFields: [
                { name: 'id', type: 'int' },
                { name: 'registration_no', type: 'string' },
                { name: 'vehicle', type: 'string' },
                { name: 'employee', type: 'string' },
                { name: 'assign_date', type: 'string' },
                { name: 'end_date', type: 'string' },
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
                    { text: '<?= __('Registration No') ?>', dataField: 'registration_no',width:'24x%'},
                    { text: '<?= __('Vehicle') ?>', dataField: 'vehicle',width:'22%'},
                    { text: '<?= __('Employee') ?>',dataField: 'employee',width:'12%'},
                    { text: '<?= __('Assign Date') ?>', dataField: 'assign_date',width:'12%'},
                    { text: '<?= __('End Date') ?>', dataField: 'end_date',width:'15%'},
                    { text: '<?= __('Action') ?>', cellsalign: 'center',dataField: 'action',width:'10%'}
                ]
            });
    });
</script>