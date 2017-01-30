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
        <div class="btn-group btn-group-justified" role="group" aria-label="...">
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-default">Todays
                    Total <?= $details_file_info['todays_total'] ?></button>
            </div>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-default">Todays
                    Unread <?= $details_file_info['todays_unread'] ?></button>
            </div>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-default">Todays
                    Forward <?= $details_file_info['todays_forward'] ?></button>
            </div>
        </div>

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
        <div class="btn-group btn-group-justified" role="group" aria-label="...">
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-default">Total Task <?= $details_task_info['total'] ?></button>
            </div>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-default">Total Active
                    Task <?= $details_task_info['total_active'] ?></button>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h6 class="panel-title">
                    <i class="icon-wand2"></i>
                    <?= __('My Tasks') ?>
                </h6>
            </div>
            <div id="dataTaskTable">

            </div>
        </div>
    </div>

    <hr/>
    <div class="col-md-12">

        <div class="row">
            <div class="col-md-6">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6 class="panel-title">
                            <i class="icon-wand2"></i>
                            <?= __('RA Bill Applications') ?>
                        </h6>
                    </div>
                    <div id="dataTable_application" style="margin-top:5px ">

                    </div>
                </div>

            </div>

            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6 class="panel-title">
                            <i class="icon-wand2"></i>
                            <?= __('Task Calendar') ?>
                        </h6>
                    </div>
                    <div id='calendar'></div>
                    </div>
                </div>

            </div>
        </div>





    </div>


<script type="text/javascript">
    $(document).ready(function () {
        var url = "<?php echo $this->request->webroot; ?>RaBillApplication/ajax/get_grid_data";

        // prepare the data
        var source =
        {
            dataType: "json",
            dataFields: [
                {name: 'id', type: 'int'},

                {name: 'subject', type: 'string'},
                {name: 'message_text', type: 'string'},
                {name: 'created_date', type: 'string'},
                {name: 'action', type: 'string'},

            ],
            id: 'id',
            url: url
        };

        var dataAdapter = new $.jqx.dataAdapter(source);

        $("#dataTable_application").jqxGrid(
            {
                width: '100%',
                source: dataAdapter,
                pageable: true,
                filterable: true,
                sortable: true,
                showfilterrow: true,
                columnsresize: true,
                rowsheight: 40,
                pagesize: 10,
                pagesizeoptions: ['100', '200', '300', '500', '1000', '1500'],
//                selectionmode: 'checkbox',
                altrows: true,
                autoheight: true,


                columns: [
                    {text: '<?= __('#') ?>', cellsalign: 'center', dataField: 'id', width: '5%'},
                    {text: '<?= __('Subject') ?>', dataField: 'subject', width: '30%'},
                    {text: '<?= __('Message') ?>', dataField: 'message_text', width: '42%'},
                    {text: '<?= __('Date') ?>', dataField: 'created_date', width: '15%'},
                    {text: '<?= __('Actions') ?>', cellsalign: 'center', dataField: 'action', width: '8%'}
                ]
            });


    });
</script>


<script type="text/javascript">
    $(document).ready(function () {
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
                pagesize: 10,
                pagesizeoptions: ['100', '200', '300', '500', '1000', '1500'],
//                selectionmode: 'checkbox',
                altrows: true,
                autoheight: true,


                columns: [
                    {text: '<?= __('Sender Name') ?>', dataField: 'sender_name', width: '20%'},
                    {text: '<?= __('Sender Designation') ?>', dataField: 'sender_designation', width: '10%'},
                    {text: '<?= __('Subject') ?>', dataField: 'subject', width: '35%'},
                    {text: '<?= __('Date') ?>', dataField: 'created_date', width: '15%'},
                    {text: '<?= __('Actions') ?>', cellsalign: 'center', dataField: 'action', width: '20%'}
                ]
            });

        var url2 = "<?php echo $this->request->webroot; ?>TaskManagement/ajax/get_grid_data";

        // prepare the data
        var source2 =
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
            url: url2
        };

        var dataAdapter2 = new $.jqx.dataAdapter(source2);

        $("#dataTaskTable").jqxGrid(
            {
                width: '100%',
                source: dataAdapter2,
                pageable: true,
                filterable: true,
                sortable: true,
                showfilterrow: true,
                columnsresize: true,
                rowsheight: 40,
                pagesize: 10,
                pagesizeoptions: ['100', '200', '300', '500', '1000', '1500'],
//                selectionmode: 'checkbox',
                altrows: true,
                autoheight: true,


                columns: [
                    {text: '<?= __('Task Title') ?>', dataField: 'title', width: '30%'},
                    {text: '<?= __('Priority') ?>', dataField: 'priority', width: '15%', cellsalign: 'center'},
                    {text: '<?= __('Location') ?>', dataField: 'venue', width: '15%', cellsalign: 'center'},
                    {text: '<?= __('Deadline') ?>', dataField: 'diff', width: '15%', cellsalign: 'center'},
                    {text: '<?= __('Date Added') ?>', dataField: 'created_date', width: '15%', cellsalign: 'center'},
                    {text: '<?= __('Actions') ?>', cellsalign: 'center', dataField: 'action', width: '10%'}
                ]
            });


    });
</script>

<script>

    $(document).ready(function () {
        $.ajax({
            url: "<?php echo $this->request->webroot; ?>TaskManagement/ajax/get_my_calendar_task_data",
            type: 'POST',
            data: 'type=fetch',
            async: false,
            success: function(response){
               // console.log(response);
                json_events = response;
            }
        });



        $('#calendar').fullCalendar({
            defaultDate: '<?php echo date('Y-m-d')?>',
            //  editable: true,
            //  eventLimit: true, // allow "more" link when too many events
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },



        events: JSON.parse(json_events),


        });


    });

</script>
<style>

    body {
        padding: 0;
        font-family: "Lucida Grande", Helvetica, Arial, Verdana, sans-serif;
        font-size: 14px;
    }

    #calendar {
        margin: 40px 10px;

        max-width: 900px;
        margin: 0 auto;
    }

    .fc-today {
        background: #b3cccc  !important;
        border: none !important;
        border-top: 1px solid #ddd !important;
        font-weight: bold;
    }

</style>