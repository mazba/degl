<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('My Files') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs" style="margin-bottom: 5px">
        <li class="active"><?= $this->Html->link(__('My Files List'), ['action' => 'index']) ?></li>
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
        var url = "<?php echo $this->request->webroot; ?>MyFiles/ajax/get_grid_data";

        // prepare the data
        var source =
        {
            dataType: "json",
            dataFields: [
                { name: 'id', type: 'int' },
                { name: 'sender_name', type: 'string' },
                { name: 'subject', type: 'string' },
                { name: 'sender_designation', type: 'string' },
                { name: 'created_date', type: 'string' },
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
                rowsheight: 40,
                pagesize:15,
                pagesizeoptions: ['100', '200', '300', '500','1000','1500'],
//                selectionmode: 'checkbox',
                altrows: true,
                autoheight: true,


                columns: [
                    { text: '<?= __('Sender Name') ?>', dataField: 'sender_name',width:'20%'},
                    { text: '<?= __('Sender Designation') ?>', dataField: 'sender_designation',width:'12%'},
                    { text: '<?= __('Subject') ?>', dataField: 'subject',width:'40%'},
                    { text: '<?= __('Date') ?>', dataField: 'created_date',width:'10%'},
                    { text: '<?= __('Actions') ?>', cellsalign: 'center',dataField: 'action',width:'18%'}
                ]
            });
    });
</script>