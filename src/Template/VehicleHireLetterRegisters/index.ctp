<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Vehicle Hire Letter Registers') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Vehicle Hire Letter Registers'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Vehicle Hire Letter Register'), ['action' => 'add']) ?></li>
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
        var url = "<?php echo $this->request->webroot; ?>VehicleHireLetterRegisters/ajax/get_grid_data";

        // prepare the data
        var source =
        {
            dataType: "json",
            dataFields: [
                { name: 'id', type: 'int' },
                { name: 'sarok_no', type: 'string' },
                { name: 'receive_date', type: 'string' },
                { name: 'subject', type: 'string' },
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
                    { text: '<?= __('Serial No') ?>',dataField: 'id',width:'12%'},
                    { text: '<?= __('Sarok No') ?>', dataField: 'sarok_no',width:'10%'},
                    { text: '<?= __('Subject') ?>', dataField: 'subject',width:'32%'},
                    { text: '<?= __('Receive Date') ?>', dataField: 'receive_date',width:'36%'},
                    { text: '<?= __('Action') ?>', cellsalign: 'center',dataField: 'action',width:'10%'}
                ]
            });
    });
</script>