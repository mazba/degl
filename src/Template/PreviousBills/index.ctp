<?php
use Cake\Core\Configure;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>">Dashboard</a></li>
        <li class="active">Previous Bill List</li>
    </ul>
</div>

<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Previous Ra Bills'), ['action' => 'index']) ?></li>
        <li ><?= $this->Html->link(__('New Adjust Ra Bill'), ['action' => 'add']) ?></li>
    </ul>
</div>

<div class="schemes index panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i> <?= __('List of Previous RA Bills') ?></h6>
    </div>
    <div class="well text-center">
        <div id="dataTable" style="margin-top:5px ">

        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var url = "<?php echo $this->request->webroot; ?>previous_bills/index_ajax";

        // prepare the data
        var source =
        {
            dataType: "json",
            dataFields: [
                {name: 'sl', type: 'int'},
                {name: 'scheme_name', type: 'string'},
                {name: 'contractor_name', type: 'string'},
                {name: 'financial_year_estimates', type: 'string'},
                {name: 'bill_amount', type: 'string'},
                {name: 'income_tex', type: 'string'},
                {name: 'vat', type: 'string'},
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
                altrows: true,
                autoheight: true,

                columns: [
                    {text: '<?= __('#') ?>', cellsalign: 'center', dataField: 'sl', width: '5%'},
                    {text: '<?= __('Scheme Name') ?>', dataField: 'scheme_name', filtertype: 'list', width: '35%'},
                    {text: '<?= __('Contractor') ?>', dataField: 'contractor_name', filtertype: 'list', width: '20%'},
                    {text: '<?= __('Financial Year') ?>', dataField: 'financial_year_estimates', filtertype: 'list', width: '10%'},
                    {text: '<?= __('Bill Amount') ?>', dataField: 'bill_amount', width: '10%'},
                    {text: '<?= __('Income Tax') ?>', dataField: 'income_tex', width: '8%'},
                    {text: '<?= __('Vat') ?>', dataField: 'vat', width: '8%'},
                    {text: '<?= __('Action') ?>', cellsalign: 'center', dataField: 'action', width: '4%'}
                ]
            });
    });
</script>

<script>
    $(document).ready(function () {

        // Delete Bill
        $(document).on ('click', ".delete", function () {
            var id = $(this).data('bill_id');
            var url = '<?= $this->Url->build("/previous_bills/delete/")?>'+id;
            window.location.href = url;
            });
        });
</script>