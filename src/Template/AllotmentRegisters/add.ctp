<?php
use Cake\Core\Configure;

?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Allotment Registers'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('New Allotment Register') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Allotment Registers'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('New Allotment Register'), ['action' => 'add']) ?></li>


    </ul>
</div>


<?= $this->Form->create($allotmentRegister, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Allotment Register') ?>
        </h6>
    </div>
    <?php
    if(isset($scheme_info))
    {
        ?>
        <div class="col-md-12" style="margin-top: 10px">
            <div class="callout callout-info fade in">
                <b><?= __('Scheme') ?></b> : <span><?= $scheme_info->name_bn ?></span>
                <br>
                <b><?= __('Financial Year Estimate') ?></b> : <span><?= $scheme_info->financial_year_estimate->name ?></span>
                <br>
                <b><?= __('RA Bill No') ?></b> : <span><?= $proposed_ra_bill->ra_bill_no ?></span>
                <br>
                <b><?= __('Net Taka') ?></b> : <span><?= $processed_ra_bill_info->net_payable ?></span>
            </div>
        </div>
        <?php
    }
    ?>
    <div class="panel-body col-sm-6 col-md-offset-2">
        <?php
        if(isset($projects))
        {
            echo $this->Form->input('project_id');
            echo $this->Form->input('financial_year_id',['options'=>$financial_years,'empty'=>'Select Financial Year']);
        }
        else
        {
           ?>
           <input type="hidden" name="financial_year_id" value="<?= $scheme_info->financial_year_estimate->id ?>"/>
           <input type="hidden" name="scheme_id" value="<?= $scheme_info->id?>"/>
           <input type="hidden" name="project_id" value="<?= $scheme_info->project_id ?>"/>

           <?php
        }
        echo $this->Form->input('parent_id', ['required', 'options' => $nothiRegisters, 'empty' => __('Select'), 'templates' => ['inputContainer' => '<div class="form-group nothi_register {{type}}{{required}}">{{content}}</div>']]);
        echo $this->Form->input('allotment_date',['class'=>'form-control hasdatepicker','type'=>'text']);
        echo $this->Form->input('allotment_amount');
        echo $this->Form->input('particulars');
        echo $this->Form->input('remarks');
        ?>
    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

<script>
    $(document).ready(function () {
        $(document).on('change', '#parent-id', function () {
            var parent_id = $(this).val();
            var obj = $(this);
            $.ajax({
                type: 'POST',
                url: '<?= $this->Url->build("/NothiRegisters/getSubNothi")?>',
                data: {parent_id: parent_id},
                success: function (data, status) {
                    obj.closest('.nothi_register').nextAll('.nothi_register').remove();
                    if (data) {
                        obj.closest('.form-group').after(data);
                    }
                }
            });
        });
    })
</script>
