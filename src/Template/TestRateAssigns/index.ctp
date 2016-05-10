<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('List of Test Rate') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Test Rate'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Add Test Rate'), ['action' => 'add']) ?></li>
    </ul>
</div>

<div class="well text-center">
    <div id="dataTable" style="margin-top:5px ">

    </div>
</div>


<script type="text/javascript">
    $(document).ready(function ()
    {
        var url = "<?php echo $this->request->webroot; ?>TestRateAssigns/ajax/get_grid_data";

        // prepare the data
        var source =
        {
            dataType: "json",
            dataFields: [
                { name: 'test_full_name_en', type: 'string' },
                { name: 'financial_year', type: 'string' },
                { name: 'rate', type: 'string' },
                { name: 'created_date', type: 'string' },
                { name: 'status_text', type: 'string' },
                { name: 'action', type: 'string' },
            ],
            id: 'id',
            url: url,
            sortcolumn: 'financial_year',
            sortdirection: 'desc'
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
                    { text: '<?= __('Test Name') ?>', dataField: 'test_full_name_en',width:'30%'},
                    { text: '<?= __('Financial Year') ?>', dataField: 'financial_year',width:'15%', sortorder: 'desc'},
                    { text: '<?= __('Rate') ?>', dataField: 'rate',width:'15%'},
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
