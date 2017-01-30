<?php
use Cake\Core\Configure;
Configure::load('config_receive_file_registers', 'default');
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Letter Issues') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Letter Issues'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Letter Issue'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>

    </ul>
</div>

<div class="well text-center">
    <?php
    if($user_roles['print_it'])
    {
        ?>
        <button class="print btn btn-info" type="button" data-print="today"><i class="icon-print2"></i><?=  __('Print Today') ?></button>
        <a data-toggle="modal" role="button" href="#small_modal"><button class="btn btn-success" type="button"><i class="icon-print"></i><?=  __('Print By Date Range') ?></button></a>
    <?php
    }
    ?>
    <div id="dataTable" style="margin-top:5px ">

    </div>
</div>

<!-- Small modal -->
<div id="small_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-accessibility"></i><?=  __('Print By Date Range') ?></h4>
            </div>
            <div class="modal-body with-padding form-inline">
                <div class="form-group input text">
                    <label for="birth-date" class="col-sm-3 control-label"><?= __('Start Date') ?></label>
                    <div class="col-sm-9 container_birth_date">
                        <input type="text" required="required" name="start_date" id="start_date" class="form-control hasdatepicker">
                    </div>
                </div>
                <div class="form-group input text">
                    <label for="birth-date" class="col-sm-3 control-label"><?= __('End Date') ?></label>
                    <div class="col-sm-9 container_birth_date">
                        <input type="text" required="required" name="end_date" id="end_date" class="form-control hasdatepicker">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-warning" data-dismiss="modal"><?=  __('Close') ?></button>
                <button class="print btn btn-danger" data-print="by_date"><?= __('Submit') ?></button>
            </div>
        </div>
    </div>
</div>
<!-- /small modal -->
<!--SCRIPT-->
<script type="text/javascript">
    $(document).ready(function ()
    {
        var url = "<?php echo $this->request->webroot; ?>LetterIssueRegisters/ajax/get_grid_data";

        // prepare the data
        var source =
        {
            dataType: "json",
            dataFields: [
                { name: 'id', type: 'int' },
                { name: 'issue_date', type: 'string' },
                { name: 'receiver_name', type: 'string' },
                { name: 'subject', type: 'string' },
                { name: 'remarks', type: 'string' },
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
                    { text: '<?= __('Issue no') ?>', dataField: 'issue_date',width:'15%'},
                    { text: '<?= __('Receiver Name') ?>', dataField: 'receiver_name',width:'27x%'},
                    { text: '<?= __('Subject') ?>', dataField: 'subject',width:'20%'},
                    { text: '<?= __('Remarks') ?>', dataField: 'remarks',width:'25%'},
                    { text: '<?= __('Actions') ?>', cellsalign: 'center',dataField: 'action',width:'8%'}
                ]
            });

        $(document).on("click", ".print", function(event)
        {
            var req_type = $(this).data('print');
            var newWin = window.open('','','height=700,width=900');
            $.ajax({
                url: '<?=$this->Url->build(('/LetterIssueRegisters/print_it'), true)?>',
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