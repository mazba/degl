<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('List of Lab Test Register') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Test'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Add New Lab Test Register'), ['action' => 'add']) ?></li>
    </ul>
</div>

<div class="well text-center">
    <div id="dataTable" style="margin-top:5px ">

    </div>
</div>

<script type="text/javascript">
    $(document).ready(function ()
    {
        var url = "<?php echo $this->request->webroot; ?>AddNewLabTests/ajax/get_grid_data";

        // prepare the data
        var source =
        {
            dataType: "json",
            dataFields: [
                { name: 'test_short_name_en', type: 'string' },
                { name: 'test_full_name_en', type: 'string' },
                { name: 'created_date', type: 'string' },
                { name: 'status_text', type: 'string' },
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
                    { text: '<?= __('Short Name') ?>', dataField: 'test_short_name_en',width:'20%'},
                    { text: '<?= __('Full Name') ?>', dataField: 'test_full_name_en',width:'40%'},
                    { text: '<?= __('Created Date') ?>', dataField: 'created_date',width:'20x%'},
                    { text: '<?= __('Status') ?>', cellsalign: 'center',dataField: 'status_text',width:'10%'},
                    { text: '<?= __('Action') ?>', cellsalign: 'center',dataField: 'action',width:'10%'}
                ]
            });

        $(document).on("click", ".print", function(event)
        {
            var req_type = $(this).data('print');
            var newWin = window.open('','','height=700,width=700');
            $.ajax({
                url: '<?=$this->Url->build(('/LabLetterRegisters/print_it'), true)?>',
                type: 'POST',
                data:{
                    type:req_type,
                    start_date:$('[name=start_date]').val(),
                    end_date:$('[name=end_date]').val()
                },
                success: function (data, status)
                {
                    if(data)
                    {
                        newWin.document.write(data);
                        newWin.document.close();
                        newWin.focus();
                        newWin.print();
                        newWin.close();
                    }
                    else
                    {
                        alert('NO DATA FOUND');
                    }
                },
                error: function (xhr, desc, err)
                {
                    console.log("error");

                }
            });
        });
    });
</script>
