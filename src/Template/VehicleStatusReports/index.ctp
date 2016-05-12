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
    <?php
    if($user_roles['print_it'])
    {
        ?>
        <button class="print btn btn-info" type="button" data-print="all"><i class="icon-print2"></i><?=  __('Print') ?></button>
    <?php
    }
    ?>
    <div id="dataTable" style="margin-top:5px ">

    </div>
</div>

<!--SCRIPT-->
<script type="text/javascript">
    $(document).ready(function ()
    {
        var url = "<?php echo $this->request->webroot; ?>VehicleStatusReports/ajax/get_grid_data";

        // prepare the data
        var source =
        {
            dataType: "json",
            dataFields: [
                { name: 'id', type: 'int' },
                { name: 'title', type: 'string' },
                { name: 'type', type: 'string' },
                { name: 'registration_no', type: 'string' },
                { name: 'vehicle_status', type: 'string' },
                { name: 'vehicle_location', type: 'string' },
//                { name: 'work_description', type: 'string' },
                { name: 'vehicle_status', type: 'string' },
                { name: 'employees', type: 'string' }
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
                    { text: '<?= __('Title') ?>', dataField: 'title',width:'20%'},
                    { text: '<?= __('Type') ?>', dataField: 'type',width:'10%'},
                    { text: '<?= __('Registration No') ?>', dataField: 'registration_no',width:'20%'},
                    { text: '<?= __('Present Location') ?>',dataField: 'vehicle_location',width:'15%'},
//                    { text: '<?//= __('Work Description') ?>//', dataField: 'work_description',width:'15%'},
                    { text: '<?= __('Driver') ?>', dataField: 'employees',width:'20%'},
                    { text: '<?= __('Vehicle Status') ?>', dataField: 'vehicle_status',width:'10%'}
                ]
            });

        $(document).on("click", ".print", function(event)
        {
            var req_type = $(this).data('print');
            var newWin = window.open('','','height=700,width=900');
            $.ajax({
                url: '<?=$this->Url->build(('/VehicleStatusReports/print_it'), true)?>',
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