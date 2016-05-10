<?php
use Cake\Core\Configure;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Purto Bills'), ['action' => 'index']) ?></li>
                    <li class="active"><?= __('New Purto Bill') ?></li>
        
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Purto Bills'), ['action' => 'index']) ?></li>
                    <li class="active"><?= $this->Html->link(__('New Purto Bill'), ['action' => 'add']) ?></li>
        

    </ul>
</div>


<?= $this->Form->create($purtoBill,['class' => 'form-horizontal','role'=>'form']); ?>
<div class="row panel panel-success">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Purto Bill') ?>
        </h6></div>
    <div class="panel-body col-sm-6 col-md-offset-2">
        <?php echo $this->Form->input('parent_id', ['required', 'options' => $nothiRegisters, 'empty' => __('Select'), 'templates' => ['inputContainer' => '<div class="form-group nothi_register {{type}}{{required}}">{{content}}</div>']]); ?>
        <div class="form-group">
            <label class="col-sm-3 control-label text-right"><?= __('Scheme: ') ?></label>
            <div class="col-sm-9">
                <select id="scheme-id" name="scheme_id" class="form-control scheme_id" required="required">
                    <option title="<?= __('Select') ?>" value=""><?= __('Select') ?></option>
                    <?php
                    foreach($schemes as $id=>$scheme)
                    {

                        $scheme =  str_replace('"',' ',$scheme);
                        $string = $scheme;
                        if (strlen($string) > 80)
                        {
                            // truncate string
                            $stringCut = substr($string, 0, 80);
                            $string = substr($stringCut, 0, strrpos($stringCut, ' '));
                        }
                        ?>
                        <option title="<?= $scheme ?>" value="<?= $id ?>"><?= $string ?> ...</option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <?php
        echo $this->Form->input('financial_year_estimate_id', ['options' => $financialYearEstimates]);
        echo $this->Form->input('bill_type',['class'=>'form-control']);
        echo $this->Form->input('gross_bill',['class'=>'form-control']);
        echo $this->Form->input('security',['class'=>'form-control cal']);
        echo $this->Form->input('vat',['class'=>'form-control cal']);
        echo $this->Form->input('income_taxes',['class'=>'form-control cal']);
        echo $this->Form->input('roller_charge',['class'=>'form-control cal']);
        echo $this->Form->input('lab_fee',['class'=>'form-control cal']);
        echo $this->Form->input('fine',['class'=>'form-control cal']);
        echo $this->Form->input('net_taka');
        echo $this->Form->input('status', ['options' => Configure::read('status_options')]);
        ?>
    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>
<script>
    $(document).ready(function(){
       $(document).on('keyup','.cal',function(){
           var gross_bill = parseFloat($('#gross-bill').val());
           $.each($('.cal'),function(){
               if(parseFloat($(this).val()))
               {
                   gross_bill = gross_bill-parseFloat($(this).val());
                   console.log(gross_bill)
               }

           });
           if(gross_bill)
           {
               $('#net-taka').val(gross_bill)
           }
       });
        
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
    });
</script>
