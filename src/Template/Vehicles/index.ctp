<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Vehicles') ?></li>
    </ul>
</div>
<div class="row">
    <div class="col-sm-10">
        <div class="tabbable page-tabs">
            <ul class="nav nav-tabs">
                <li class="active"><?= $this->Html->link(__('List of Vehicles'), ['action' => 'index']) ?></li>
                <?php
                if ($user_roles['add'] == 1)
                {
                    ?>
                    <li><?= $this->Html->link(__('New Vehicle'), ['action' => 'add']) ?></li>
                    <?php
                }
                ?>

            </ul>
        </div>
    </div>
    <div class="col-sm-2">
        <div class="pull-right">
            <a class="vehicle-list" href="<?= $this->Url->build(['action' => 'vehicleList'])?>"><?= __('Vehicle List Report') ?></a>
        </div>
    </div>
</div>


<div class="well text-center">
    <div id="dataTable" style="margin-top:5px ">

    </div>
</div>
<!--SCRIPT-->
<script type="text/javascript">
    $(document).ready(function ()
    {
        var url = "<?php echo $this->request->webroot; ?>Vehicles/ajax/get_grid_data";

        // prepare the data
        var source =
        {
            dataType: "json",
            dataFields: [
                { name: 'id', type: 'int' },
                { name: 'title', type: 'string' },
                { name: 'serial_no', type: 'string' },
                { name: 'vehicle_status', type: 'string' },
                { name: 'load_capacity', type: 'string' },
                { name: 'registration_no', type: 'string' },
                { name: 'type', type: 'string' },
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
                    { text: '<?= __('Title/Equipment ID') ?>', dataField: 'title',width:'30%'},
                    { text: '<?= __('Serial No/Equipment Category') ?>', dataField: 'serial_no',width:'16%'},
                    { text: '<?= __('Registration No/Equipment brand') ?>', dataField: 'registration_no',width:'25%'},
                    { text: '<?= __('Vehicle Status') ?>', dataField: 'vehicle_status',width:'8%'},
                    { text: '<?= __('Type') ?>', dataField: 'type',width:'9%'},
                    { text: '<?= __('Action') ?>', cellsalign: 'center',dataField: 'action',width:'12%'}
                ]
            });
    });
</script>

<style>
.vehicle-list {
    font-weight: bold;
    background: mediumseagreen;
    padding: 10px 12px;
    color: #fff;
    border-radius: 3px;
}
</style>