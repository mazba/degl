<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Schemes') ?></li>
    </ul>
</div>

<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Schemes'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1) {
            ?>
            <li><?= $this->Html->link(__('New Scheme'), ['action' => 'add']) ?></li>
            <?php
        }
        ?>

    </ul>
</div>

<div class="schemes index panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i> <?= __('List of Schemes') ?></h6>
    </div>
    <div class="well text-center">
        <div id="dataTable" style="margin-top:5px ">

        </div>
    </div>


    <div id="scheme-modal-main" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="modal-content">

            </div>
        </div>
    </div>


</div>


<script type="text/javascript">
    $(document).ready(function () {
        var url = "<?php echo $this->request->webroot; ?>Schemes/index_ajax/get_grid_data";

        // prepare the data
        var source =
        {
            dataType: "json",
            dataFields: [
                {name: 'sl', type: 'int'},

                {name: 'upazilas_name', type: 'string'},
                {name: 'financial_year', type: 'string'},
                {name: 'scheme_name', type: 'string'},
                {name: 'projects_name', type: 'string'},
                {name: 'contractor_name', type: 'string'},
                {name: 'contract_amount', type: 'float'},
                {name: 'scheme_progresses', type: 'string'},
                {name: 'contract_date', type: 'string'},
                {name: 'expected_complete_date', type: 'string'},
                {name: 'action', type: 'string'}
            ],
            id: 'id',
            url: url
        };

        var dataAdapter = new $.jqx.dataAdapter(source);
        var spanWithTitle = function (row, columnfield, value, defaulthtml, columnproperties, rowdata) {
            return '<span title="'+rowdata.scheme_name+'"> '+rowdata.scheme_name+' </span> ';
        };
        $("#dataTable").jqxGrid(
            {
                width: '100%',
                source: dataAdapter,
                pageable: true,
                filterable: true,
                sortable: true,
                showfilterrow: true,
                columnsresize: true,
                pagesize: 15,
                pagesizeoptions: ['100', '200', '300', '500', '1000', '1500'],
//                selectionmode: 'checkbox',
                altrows: true,
                autoheight: true,


                columns: [
                    {text: '<?= __('#') ?>', cellsalign: 'center', dataField: 'sl', width: '4%'},

                    {text: '<?= __('Upazila') ?>', dataField: 'upazilas_name', filtertype: 'list', width: '8%'},
                    {text: '<?= __('Financial Year') ?>', dataField: 'financial_year', filtertype: 'list', width: '7%'},
                    {text: '<?= __('Project') ?>', dataField: 'projects_name', filtertype: 'list', width: '9%'},

                    {text: '<?= __('Scheme Name') ?>', dataField: 'scheme_name', width: '20%'},
                    {text: '<?= __('Contractor') ?>', dataField: 'contractor_name', width: '10%'},
                    {                       text: '<?= __('Contract Amount') ?>',
                        dataField: 'contract_amount',
                        filtertype: 'list',
                        width: '7%'
                    },
                    {text: '<?= __('Progress Value') ?>', dataField: 'scheme_progresses', width: '7%'},
                    {text: '<?= __('চুক্তির শুরুর তারিখ') ?>', dataField: 'contract_date', width: '7%'},
                    {text: '<?= __('Complete Date') ?>', dataField: 'expected_complete_date',
                        cellsrenderer: function (row, value1, value2, value3, value4, value5 ) {
                            var currentDate =  new Date();
                            var expected_date = value5.expected_complete_date;
                            var date = expected_date;
                            var datearray = date.split("/");
                            var expected = datearray[1] + '/' + datearray[0] + '/' + datearray[2];
                            var expected = new Date(expected);

                            if(currentDate > expected ){
                                return '<span class="label label-danger">'+expected_date+'</span>';
                            }
                        },
                        width: '7%'},
                    {text: '<?= __('Action') ?>', cellsalign: 'center', dataField: 'action', width: '14%'}
                ]
            });
    });
</script>


<script>
    $(document).ready(function () {
        $(document).on ('click', ".view", function () {
            var id = $(this).data('scheme_id');
            console.log(id);
            $.ajax({
                type: 'POST',
                url: '<?= $this->Url->build("/Schemes/view_by_id/")?>',
                data: {id: id},
                success: function (data, status) {
                    $('#modal-content').html(data);
                    $('#scheme-modal-main').modal('show')
                }
            });
        });
        $(document).on ('click', ".edit", function () {
            var id = $(this).data('scheme_id');
            var url =  '<?= $this->Url->build("/Schemes/edit_by_id/")?>'+id;
            // console.log(id);
            $.ajax({
                type: 'GET',
                url:url,

                success: function (data, status) {
                    $('#modal-content').html(data);
                    $('#scheme-modal-main').modal('show')
                }
            });
        });

        $(document).on ('click', ".workOrder", function () {
            var id = $(this).data('scheme_id');
            var url =  '<?= $this->Url->build("/Schemes/work_order_by_id/")?>'+id;
            // console.log(id);
            $.ajax({
                type: 'GET',
                url:url,

                success: function (data, status) {
                    $('#modal-content').html(data);
                    $('#scheme-modal-main').modal('show')
                }
            });
        });

        $(document).on ('click', ".progress", function () {
            var id = $(this).data('scheme_id');
            var url =  '<?= $this->Url->build("/Schemes/progress/")?>'+id;
            // console.log(id);
            $.ajax({
                type: 'GET',
                url:url,
                success: function (data, status) {
                    $('#modal-content').html(data);
                    $('#scheme-modal-main').modal('show')
                }
            });
        });


    });
</script>