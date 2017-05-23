<?php
use Cake\Core\Configure;
//;
?>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
            <li><?= $this->Html->link(__('Assign Vehicles'), ['action' => 'index']) ?></li>
            <li class="active"><?= __('New Assign Vehicle') ?></li>

        </ul>
    </div>

<?php if(isset($this->request->params['pass'][1])): ?>

    <?= $this->Form->create($vehiclesStatus, ['class' => 'form-horizontal', 'role' => 'form']); ?>
    <div class="row panel panel-default">

        <div class="panel-heading"><h6 class="panel-title"><i
                    class="icon-paragraph-right2"></i><?= __('Add Assign Vehicle') ?>
            </h6></div>
        <div class="panel-body col-sm-6">
            <?php

            echo $this->Form->input('employee_id', ['options' => $employees]);
            echo $this->Form->input('vehicle_location', ['']);
            echo $this->Form->input('remark', ['']);

            ?>
        </div>
        <div class="panel-body col-sm-6">
            <input type="hidden" name="scheme_id" value="<?= $this->request->params['pass'][1] ?>">
            <?php
//            echo $this->Form->input('scheme_id', ['options' => $schemes,'empty'=>'Select One']);
            echo $this->Form->input('assign_date',['value'=>$vehiclesStatus['assign_date']?date('m/d/Y',$vehiclesStatus['assign_date']):'', 'type'=>'text','class'=>'form-control hasdatepicker']);
            ?>
        </div>
        <div class="col-sm-12 form-actions text-right">
            <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
        </div>
    </div>
    <?= $this->Form->end() ?>
<?php else: ?>
    <?= $scheme_name ?>
    <div class="grid-data-global index panel panel-default">
        <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i> <?= __('List of Schemes') ?></h6>
        </div>
        <div class="well text-center">
            <div id="dataTable" style="margin-top:5px ">

            </div>
        </div>
    </div>
<?php endif; ?>

<script type="text/javascript">
    $(document).ready(function () {
        var url = "<?php echo $this->request->webroot.'Components/get_grid_data/'.$this->request->params['pass'][0]?>";

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
