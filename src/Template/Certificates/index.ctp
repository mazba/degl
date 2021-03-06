<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Schemes') ?></li>
    </ul>
</div>

<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Schemes'), ['action' => 'index']) ?></li>
    </ul>
</div>

<div class="schemes index panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i> <?= __('List of Schemes') ?></h6>
    </div>
    <div class="well text-center">
        <div id="dataTable" style="margin-top:5px ">

        </div>
    </div>

    <div id="scheme-modal-main-letter" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="modal-content-letter">

            </div>
        </div>
    </div>

</div>


<script type="text/javascript">
    $(document).ready(function () {
        var url = "<?php echo $this->request->webroot; ?>Certificates/index_ajax";

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
                    {text: '<?= __('#') ?>', cellsalign: 'center', dataField: 'sl', width: '5%'},

                    {text: '<?= __('Upazila') ?>', dataField: 'upazilas_name', filtertype: 'list', width: '10%'},
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
                    {text: '<?= __('Contract Date') ?>', dataField: 'contract_date', width: '7%'},
                    {text: '<?= __('Complete Date') ?>', dataField: 'expected_complete_date', width: '7%'},
                    {text: '<?= __('Action') ?>', cellsalign: 'center', dataField: 'action', width: '10%'}
                ]
            });
    });
</script>


<script>
    $(document).ready(function () {

        // karjo sompadon sonod
        $(document).on ('click', ".letter", function () {
            var id = $(this).data('scheme_id');
            $.ajax({
                type: 'POST',
                url: '<?= $this->Url->build("/Certificates/letter/")?>',
                data: {id: id},
                success: function (data, status) {
                    $('#modal-content-letter').html(data);
                    $('#scheme-modal-main-letter').modal('show')
                }
            });
        });

        // protoyon potro
        $(document).on ('click', ".report", function () {
            var id = $(this).data('scheme_id');
            $.ajax({
                type: 'POST',
                url: '<?= $this->Url->build("/Certificates/certificate/")?>',
                data: {id: id},
                success: function (data, status) {
                    $('#modal-content-letter').html(data);
                    $('#scheme-modal-main-letter').modal('show')
                }
            });
        });

        // protoyon potro
        $(document).on ('click', ".upload", function () {
            var id = $(this).data('scheme_id');
            var url = '<?= $this->Url->build("/Certificates/upload/")?>'+id;
            $.ajax({
                type: 'GET',
                url:url,
                success: function (data, status) {
                    $('#modal-content-letter').html(data);
                    $('#scheme-modal-main-letter').modal('show')
                }
            });
        });
    });
</script>