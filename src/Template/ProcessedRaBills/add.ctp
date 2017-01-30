<?php
use Cake\Core\Configure;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>">Dashboard</a></li>
        <li><?= $this->Html->link(__('Processed Ra Bills'), ['action' => 'index']) ?></li>
                    <li class="active">New Processed Ra Bill</li>
        
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Processed Ra Bills'), ['action' => 'index']) ?></li>
                    <li class="active"><?= $this->Html->link(__('New Processed Ra Bill'), ['action' => 'add']) ?></li>
        

    </ul>
</div>


<?= $this->Form->create(null, ['url'=>['controller'=>'ProcessedRaBills','action'=>'add',$id],'class' => 'form-horizontal', 'role' => 'form','type'=>'file']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Processed Ra Bill') ?>
        </h6></div>
    <div class="panel-body col-sm-9 col-sm-offset-1">

        <div class="form-group input text">
            <label class="col-sm-3 control-label text-right" for="security">Bill Amount</label>
            <div class="col-sm-9 container_security">
                <input id="" class="form-control" value="<?=$measurementInfo['approve_bill_amount']?>" name="" type="text" readonly>
                <input value="<?=$measurementInfo['scheme_id']?>" name="scheme_id" type="hidden" readonly>
            </div>
        </div>

        <div class="form-group input text">
            <label class="col-sm-3 control-label text-right" for="security">Security</label>
            <div class="col-sm-9 container_security">
                <input id="security" class="form-control common" name="security" type="text">
            </div>
        </div>

        <div class="form-group input text">
            <label class="col-sm-3 control-label text-right" for="security">Income Tex</label>
            <div class="col-sm-9 container_security">
                <input id="income_tex" class="form-control common" name="income_tex" type="text">
            </div>
        </div>

        <div class="form-group input text">
            <label class="col-sm-3 control-label text-right" for="security">Vat</label>
            <div class="col-sm-9 container_security">
                <input id="vat" class="form-control common" name="vat" type="text">
            </div>
        </div>

        <div class="form-group input text">
            <label class="col-sm-3 control-label text-right" for="security">Hire Charge</label>
            <div class="col-sm-9 container_security">
                <input id="" class="form-control" name="hire_charge" type="text" readonly value="<?=$hire_charge['net_payable']?>">
                <input  name="hire_charge_id" type="hidden"  value="<?=$hire_charge['id']?>">
            </div>
        </div>

        <div class="form-group input text">
            <label class="col-sm-3 control-label text-right" for="security">Lab Fee</label>
            <div class="col-sm-9 container_security">
                <input id="" class="form-control" name="lab_fee" type="text" readonly value="<?=$lab_actual_tests['net_payable']?>">
                <input  name="lab_fee_id" type="hidden"  value="<?=$lab_actual_tests['id']?>">
            </div>
        </div>

        <div class="form-group input text">
            <label class="col-sm-3 control-label text-right" for="security">Net Payable</label>
            <div class="col-sm-9 container_security">
                <input id="net_payable" class="form-control" name="net_payable" value="<?php echo $measurementInfo['approve_bill_amount']-($hire_charge['net_payable']+$lab_actual_tests['net_payable'])?>" type="text" readonly >
            </div>
        </div>
    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="Save" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

<script>
    jQuery(document).ready(function()
    {

        $(document).on("change", "#security", function(event)
        {
            var net_payable= parseInt($('#net_payable').val());

            var security= parseInt($('#security').val());
            var net_amount=net_payable-security;
            $('#net_payable').val(net_amount)

    });

        $(document).on("change", "#income_tex", function(event)
        {
            var net_payable= parseInt($('#net_payable').val());

            var income_tex= parseInt($('#income_tex').val());
            var net_amount=net_payable-income_tex;
            $('#net_payable').val(net_amount)

    });

        $(document).on("change", "#vat", function(event)
        {
            var net_payable= parseInt($('#net_payable').val());

            var vat= parseInt($('#vat').val());
            var net_amount=net_payable-vat;
            $('#net_payable').val(net_amount)

    });

    });


    function total(){
        var num_1= parseInt($('#vat').val());
        var num_3= parseInt($('#security').val());



    }
</script>

