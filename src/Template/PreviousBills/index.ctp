<?php
use Cake\Core\Configure;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>">Dashboard</a></li>
        <li class="active">Previous Bill Adjust</li>

    </ul>
</div>


<?= $this->Form->create(null,['class' => 'form-horizontal', 'role' => 'form','type'=>'file']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Adjust Processed Ra Bill') ?>
        </h6></div>
    <div class="panel-body col-sm-9 col-sm-offset-1">

        <div class="form-group input">
            <label class="col-sm-3 control-label text-right"><?= __('Scheme') ?></label>

            <div class="col-sm-9 actual_complete_date">
                <select class="form-control" name="scheme_id" id="scheme-id">
                    <option value=""><?= __('Select') ?></option>
                    <?php
                    foreach ($schemes as $scheme_id => $scheme) {
                        ?>
                        <option value="<?php echo $scheme_id; ?>"><?php echo $scheme; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group input text">
            <label class="col-sm-3 control-label text-right" for="security">Bill Amount</label>
            <div class="col-sm-9 container_security">
                <input id="" class="form-control" name="bill_amount" type="text">
            </div>
        </div>
        <?php
        echo $this->Form->input('financial_year_estimate_id',['label' => 'Financial Year', 'options' =>$financial_year_estimate_id ,'class'=>'form-control', 'required' => 'required', 'empty' => 'Select']);
        ?>
        <div class="form-group input text">
            <label class="col-sm-3 control-label text-right" for="security">Security</label>
            <div class="col-sm-9 container_security">
                <input id="security" class="form-control common" name="security" type="text">
            </div>
        </div>

        <div class="form-group input text">
            <label class="col-sm-3 control-label text-right" for="security">Income Tax</label>
            <div class="col-sm-9 container_security">
                <input id="income_tex" class="form-control common" name="income_tex" type="text">
            </div>
        </div>

        <div class="form-group input text">
            <label class="col-sm-3 control-label text-right" for="security">Cost Of Material</label>
            <div class="col-sm-9 container_security">
                <input id="cost_of_material" class="form-control common" name="cost_of_material" type="text">
            </div>
        </div>

        <div class="form-group input text">
            <label class="col-sm-3 control-label text-right" for="security">Vat</label>
            <div class="col-sm-9 container_security">
                <input id="vat" class="form-control common" name="vat" type="text">
            </div>
        </div>

        <div class="form-group input text">
            <label class="col-sm-3 control-label text-right" for="security">Etc</label>
            <div class="col-sm-9 container_security">
                <input id="etc_fee" class="form-control common" name="etc_fee" type="text">
            </div>
        </div>
        <!-- Custom field added -->
        <div class="form-group input text">
            <label for="has_others" class="col-sm-3 control-label text-right"><?= __('Has Others:') ?></label>
            <div class="col-sm-9 container_etender_date">
                <input type="checkbox" name="checkbox" id="checkbox" value="1" style="margin-top: 13px;"/>
            </div>
        </div>
        <div id="showthis">
            <div class="form-group input text">
                <label for="edo_completion" class="col-sm-3 control-label text-right"><?= __('Text:') ?></label>
                <div class="col-sm-9 container_etender_date">
                    <input type="text" name="e_field"   value="" id="e_field" maxlength="11" class="form-control">
                </div>
            </div>
            <div class="form-group input text">
                <label for="e_value:" class="col-sm-3 control-label text-right"><?= __('Value:') ?></label>
                <div class="col-sm-9 container_etender_date">
                    <input type="text" name="e_value"   value="" id="e_value" maxlength="11" class="form-control">
                </div>
            </div>
        </div>

        <div class="form-group input text">
            <label class="col-sm-3 control-label text-right" for="security">Hire Charge</label>
            <div class="col-sm-9 container_security">
                <input id="" class="form-control" name="hire_charge" type="text">
            </div>
        </div>

        <div class="form-group input text">
            <label class="col-sm-3 control-label text-right" for="security">Lab Fee</label>
            <div class="col-sm-9 container_security">
                <input id="" class="form-control" name="lab_fee" type="text">
            </div>
        </div>

        <div class="form-group input text">
            <label class="col-sm-3 control-label text-right" for="security">Net Payable</label>
            <div class="col-sm-9 container_security">
                <input id="net_payable" class="form-control" name="net_payable" >
            </div>
        </div>
    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="Save" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

<script>
    jQuery(document).ready(function(){
        // show field based on checkbox
        $(function () {
            $('#showthis').hide();

            $('#checkbox').on('click', function () {
                if ($(this).prop('checked')) {
                    $('#showthis').fadeIn();
                } else {
                    $('#showthis').hide();
                }
            });
        });
    });
</script>