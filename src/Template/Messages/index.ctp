<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Messages'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('Inbox') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('Inbox'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Sent'), ['action' => 'sent']) ?></li>
        <li><?= $this->Html->link(__('New Message'), ['action' => 'add']) ?></li>


    </ul>
</div>

<div id="dataTable" style="margin-top:5px ">

</div>

<script type="text/javascript">
    $(document).ready(function ()
    {
        var url = "<?php echo $this->request->webroot; ?>Messages/ajax/get_grid_data";

        // prepare the data
        var source =
        {
            dataType: "json",
            dataFields: [
                { name: 'id', type: 'int' },
                { name: 'msg_type', type: 'int' },
                { name: 'subject', type: 'string' },
                { name: 'message_text', type: 'string' },
                { name: 'created_date', type: 'string' },
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
                    { text: '<?= __('Message Type') ?>', dataField: 'msg_type',width:'20%'},
                    { text: '<?= __('Subject') ?>', dataField: 'subject',width:'20%'},
                    { text: '<?= __('Message') ?>',dataField: 'message_text',width:'37%'},
                    { text: '<?= __('Date') ?>', dataField: 'created_date',width:'10%'},
                    { text: '<?= __('Actions') ?>', cellsalign: 'center',dataField: 'action',width:'8%'}
                ]
            });


    });
</script>

