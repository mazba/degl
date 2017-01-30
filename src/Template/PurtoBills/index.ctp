<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Purto Bills') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Purto Bills'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Reports of Purto Bill'), ['action' => 'report']) ?></li>
        <?php
        if ($user_roles['add'] == 1) {
            ?>
            <li><?= $this->Html->link(__('New Purto Bill'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>

    </ul>
</div>

<div class="well text-center">
    <div id="dataTable" style="margin-top:5px ">

    </div>
</div>
<!--SCRIPT-->
<script type="text/javascript">
    $(document).ready(function ()
    {
        var url = "<?php echo $this->request->webroot; ?>PurtoBills/ajax/grid";

        // prepare the data
        var source =
        {
            dataType: "json",
            dataFields: [
                { name: 'id', type: 'int' },
                { name: 'scheme', type: 'string' },
                { name: 'project', type: 'string' },
                { name: 'bill_type', type: 'string' },
                { name: 'gross_bill', type: 'string' },
                { name: 'security', type: 'string' },
                { name: 'financial_year', type: 'string' },
                { name: 'vat', type: 'string' },
                { name: 'income_taxes', type: 'string' },
                { name: 'roller_charge', type: 'string' },
                { name: 'lab_fee', type: 'string' },
                { name: 'fine', type: 'string' },
                { name: 'net_taka', type: 'string' },
                { name: 'actions', type: 'string' }
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
                    { text: '<?= __('Project') ?>', dataField: 'project',filtertype: 'checkedlist',width:'20%'},
                    { text: '<?= __('Scheme') ?>', dataField: 'scheme',filtertype: 'checkedlist',width:'20%'},
                    { text: '<?= __('Financial Year Estimate') ?>', dataField: 'financial_year',width:'8%'},
                    { text: '<?= __('Bill Type') ?>', dataField: 'bill_type',width:'10%'},
                    { text: '<?= __('Gross Amount') ?>', dataField: 'gross_bill',width:'5%'},
                    { text: '<?= __('Security') ?>', dataField: 'security',width:'5%'},
                    { text: '<?= __('Vat') ?>', dataField: 'vat',width:'5%'},
                    { text: '<?= __('Tax') ?>', dataField: 'income_taxes',width:'5%'},
                    { text: '<?= __('Roller Charge') ?>', dataField: 'roller_charge',width:'5%'},
                    { text: '<?= __('Lab Fee') ?>', dataField: 'lab_fee',width:'5%'},
                    { text: '<?= __('Fine') ?>', dataField: 'fine',width:'5%'},
                    { text: '<?= __('Total Amount') ?>', dataField: 'net_taka',width:'5%'},
                    { text: '<?= __('Action') ?>', cellsalign: 'center',dataField: 'actions',width:'10%'}
                ]
            });
    });
</script>