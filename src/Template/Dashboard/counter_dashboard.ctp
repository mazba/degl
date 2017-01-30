<?php use Cake\Routing\Router; ?>
<!-- Page header -->
<div class="page-header">
    <div class="page-title">
        <h3><?= __('Dashboard') ?>
            <small><?= __('Welcome'); ?> <?php echo $user_info['name_en']; ?>.</small>
        </h3>
    </div>

    <div id="reportrange" class="range">
        <iframe src="http://free.timeanddate.com/clock/i4otle9z/n73/fn7/ftb/tt0/tm1" frameborder="0" width="307"
                height="21"></iframe>
    </div>
</div>

<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">
                <i class="icon-file"></i>
                <?= __('Dak Files') ?>
            </h6>
        </div>
        <div id="dataTable">

        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function ()
    {
        var url = "<?php echo $this->request->webroot; ?>ReceiveFileRegisters/ajax/get_grid_data";

        // prepare the data
        var source =
        {
            dataType: "json",
            dataFields: [
                { name: 'id', type: 'int' },
                { name: 'sender_name', type: 'string' },
                { name: 'office_name', type: 'string' },
                { name: 'address', type: 'string' },
                { name: 'subject', type: 'string' },
                { name: 'date', type: 'string' },
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
                    { text: '<?= __('Sender Name') ?>', dataField: 'sender_name',width:'20%'},
                    { text: '<?= __('Office Name') ?>', dataField: 'office_name',width:'20%'},
                    { text: '<?= __('Address') ?>',dataField: 'address',width:'20%'},
                    { text: '<?= __('Subject') ?>',dataField: 'subject',width:'17%'},
                    { text: '<?= __('Date') ?>', dataField: 'date',width:'10%'},
                    { text: '<?= __('Actions') ?>', cellsalign: 'center',dataField: 'action',width:'8%'}
                ]
            });


    });
</script>