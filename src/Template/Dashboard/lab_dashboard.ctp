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

<div class="row">
<div class="col-md-6">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">
                <i class="icon-file"></i>
                <?= __('My Files') ?>
            </h6>
        </div>
        <div id="dataTable">

        </div>
    </div>
</div>

<div class="col-md-6">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">
                <i class="icon-file"></i>
                <?= __('My Tasks') ?>
            </h6>
        </div>
        <div id="dataTaskTable">

        </div>
    </div>
</div>
</div>
<!--<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">
                <i class="icon-spinner5"></i>
                <?/*= __('At a Glance Scheme') */?>
            </h6>
        </div>
        <div id="progressTable">

        </div>
    </div>
</div>-->

<!--<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">
                <i class="icon-file"></i>
                <?/*= __('Vehicles Status') */?>
            </h6>
        </div>
        <div id="vehicleStatus">

        </div>
    </div>
</div>-->



<script type="text/javascript">
    $(document).ready(function ()
    {
        var url = "<?php echo $this->request->webroot; ?>MyFiles/ajax/get_grid_data";

        // prepare the data
        var source =
        {
            dataType: "json",
            dataFields: [
                {name: 'id', type: 'int'},
                {name: 'sender_name', type: 'string'},
                {name: 'subject', type: 'string'},
                {name: 'sender_designation', type: 'string'},
                {name: 'created_date', type: 'string'},
                {name: 'action', type: 'string'}
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
                pagesize: 15,
                pagesizeoptions: ['100', '200', '300', '500', '1000', '1500'],
//                selectionmode: 'checkbox',
                altrows: true,
                autoheight: true,


                columns: [
                    {text: '<?= __('Sender Name') ?>', dataField: 'sender_name', width: '20%'},
                    {text: '<?= __('Sender Designation') ?>', dataField: 'sender_designation', width: '15%'},
                    {text: '<?= __('Subject') ?>', dataField: 'subject', width: '35%'},
                    {text: '<?= __('Date') ?>', dataField: 'created_date', width: '15%'},
                    {text: '<?= __('Actions') ?>', cellsalign: 'center', dataField: 'action', width: '15%'}
                ]
            });


        /*var url2 = "<?php echo $this->request->webroot; ?>VehicleStatusReports/ajax/get_grid_data";

        // prepare the data
        var source2 =
        {
            dataType: "json",
            dataFields: [
                { name: 'id', type: 'int' },
                { name: 'title', type: 'string' },
                { name: 'vehicle_status', type: 'string' },
                { name: 'load_capacity', type: 'string' },
                { name: 'vehicle_status', type: 'string' },
                { name: 'employees', type: 'string' }
            ],
            id: 'id',
            url: url2
        };

        var dataAdapter2 = new $.jqx.dataAdapter(source2);

        $("#vehicleStatus").jqxGrid(
            {
                width: '100%',
                source: dataAdapter2,
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
                    { text: '<?= __('Title') ?>', dataField: 'title',width:'23%'},
                    { text: '<?= __('Load Capacity') ?>',dataField: 'load_capacity',width:'22%'},
                    { text: '<?= __('Serial No') ?>', dataField: 'serial_no',width:'15x%'},
                    { text: '<?= __('Driver') ?>', dataField: 'employees',width:'10%'},
                    { text: '<?= __('Vehicle Status') ?>', dataField: 'vehicle_status',width:'25%'}
                ]
            });*/

        var url3 = "<?php echo $this->request->webroot; ?>TaskManagement/ajax/get_grid_data";

        // prepare the data
        var source3 =
        {
            dataType: "json",
            dataFields: [
                {name: 'title', type: 'string'},
                {name: 'media_type', type: 'string'},
                {name: 'priority', type: 'string'},
                {name: 'venue', type: 'string'},
                {name: 'diff', type: 'string'},
                {name: 'created_date', type: 'string'},
                {name: 'action', type: 'string'}
            ],
            id: 'id',
            url: url3
        };

        var dataAdapter3 = new $.jqx.dataAdapter(source3);

        $("#dataTaskTable").jqxGrid(
            {
                width: '100%',
                source: dataAdapter3,
                pageable: true,
                filterable: true,
                sortable: true,
                showfilterrow: true,
                columnsresize: true,
                rowsheight: 40,
                pagesize: 15,
                pagesizeoptions: ['100', '200', '300', '500', '1000', '1500'],
//                selectionmode: 'checkbox',
                altrows: true,
                autoheight: true,


                columns: [
                    {text: '<?= __('Task Title') ?>', dataField: 'title', width: '30%'},
                    {text: '<?= __('Priority') ?>', dataField: 'priority', width: '15%',cellsalign: 'center'},
                    {text: '<?= __('Location') ?>', dataField: 'venue', width: '15%',cellsalign: 'center'},
                    {text: '<?= __('Deadline') ?>', dataField: 'diff', width: '15%',cellsalign: 'center'},
                    {text: '<?= __('Date Added') ?>', dataField: 'created_date', width: '15%',cellsalign: 'center'},
                    {text: '<?= __('Actions') ?>', cellsalign: 'center', dataField: 'action', width: '10%'}
                ]
            });
        // prepare the data
        /*var url3 = "<?php echo $this->request->webroot; ?>Dashboard/get_scheme_info";
     var source3 =
     {
     dataType: "json",
     dataFields: [
     {name: 'title', type: 'string'},
     {name: 'progress', type: 'string'},
     {name: 'scheme_code', type: 'string'},
     {name: 'lab', type: 'string'},
     {name: 'letter', type: 'string'},
     {name: 'vehicle', type: 'string'},
     {name: 'accounts', type: 'string'},
     {name: 'multimedia', type: 'string'},
     ],
     id: 'id',
     url: url3
     };

     var dataAdapter3 = new $.jqx.dataAdapter(source3);

     $("#progressTable").jqxGrid(
     {
     width: '100%',
     source: dataAdapter3,
     pageable: true,
     filterable: true,
     sortable: true,
     showfilterrow: true,
     columnsresize: true,
     rowsheight: 40,
     pagesize: 15,
     pagesizeoptions: ['100', '200', '300', '500', '1000', '1500'],
     //                selectionmode: 'checkbox',
     altrows: true,
     autoheight: true,


     columns: [
     {text: '<?= __('Scheme') ?>', dataField: 'title', width: '40%'},
     {text: '<?= __('Scheme Code') ?>', dataField: 'scheme_code', width: '10%'},
     {text: '<?= __('Progress Value') ?>', dataField: 'progress', width: '25%',cellsalign: 'center'},
     {text: '<?= __('Letter') ?>', cellsalign: 'center', dataField: 'letter', width: '5%'},
     {text: '<?= __('Lab') ?>', cellsalign: 'center', dataField: 'lab', width: '5%'},
     {text: '<?= __('Vehicle') ?>', cellsalign: 'center', dataField: 'vehicle', width: '5%'},
     {text: '<?= __('Accounts') ?>', cellsalign: 'center', dataField: 'accounts', width: '5%'},
     {text: '<?= __('Multimedia') ?>', cellsalign: 'center', dataField: 'multimedia', width: '5%'}
     ]
     });
     */

    });
</script>