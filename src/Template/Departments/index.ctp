
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Departments') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Departments'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Department'), ['action' => 'add']) ?></li>
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
        var url = "<?php echo $this->request->webroot; ?>Departments/ajax/get_grid_data";

        // prepare the data
        var source =
        {
            dataType: "json",
            dataFields: [
                { name: 'id', type: 'int' },
                { name: 'name_en', type: 'string' },
                { name: 'name_bn', type: 'string' },
                { name: 'order_no', type: 'string' },
                { name: 'action', type: 'string' },

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
                    { text: '<?= __('Name English') ?>', dataField: 'name_en',width:'40%'},
                    { text: '<?= __('Name Bangla') ?>', dataField: 'name_bn',width:'40%'},
                    { text: '<?= __('Order') ?>', dataField: 'order_no',width:'7%'},
                    { text: '<?= __('Actions') ?>', cellsalign: 'center',dataField: 'action',width:'8%'}
                ]
            });


    });
</script>