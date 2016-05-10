<?php
use Cake\Core\Configure;

?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Lab Letter Registers'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('New Lab Letter Register') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Lab Letter Registers'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('New Lab Letter Register'), ['action' => 'add']) ?></li>


    </ul>
</div>


<?= $this->Form->create($labLetterRegister, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Lab Letter Register') ?>
        </h6></div>
    <div class="panel-body col-sm-6">
        <div class="form-group">
            <label class="col-sm-3 control-label text-right"><?= __('Scheme: ') ?></label>
            <div class="col-sm-9">
                <select id="scheme-id" name="scheme_id" class="form-control scheme_id">
                    <option value="">Others</option>
                    <?php
                        foreach($schemes as $id=>$scheme)
                        {
//                            $string = $scheme;
//                            if (strlen($string) > 50)
//                            {
//                                // truncate string
//                                $stringCut = substr($string, 0, 50);
//                                $string = substr($stringCut, 0, strrpos($stringCut, ' '));
//                            }
                          ?>
                            <option title="<?= $scheme ?>" value="<?= $id ?>"><?= $scheme ?></option>
                          <?php
                        }
                    ?>
                </select>
            </div>
        </div>

        <?php
        echo $this->Form->input('letter_no');
        echo $this->Form->input('receive_date',['type'=>'text','required','class'=>'form-control hasdatepicker']);
        ?>

<!--        <div class="form-group client">-->
<!--            <label class="col-sm-3 control-label text-right">Client Name: </label>-->
<!--            <div class="col-sm-9">-->
<!--                <input class="form-control" type="text" name="client_name">-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="form-group client">-->
<!--            <label class="col-sm-3 control-label text-right">Client Designation: </label>-->
<!--            <div class="col-sm-9">-->
<!--                <input class="form-control" type="text" name="client_designation">-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="form-group client">-->
<!--            <label class="col-sm-3 control-label text-right">Client Phone: </label>-->
<!--            <div class="col-sm-9">-->
<!--                <input class="form-control" type="text" name="client_phone">-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="form-group client">-->
<!--            <label class="col-sm-3 control-label text-right">Client Email: </label>-->
<!--            <div class="col-sm-9">-->
<!--                <input class="form-control" type="text" name="client_email">-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="form-group client">-->
<!--            <label class="col-sm-3 control-label text-right">Client Address: </label>-->
<!--            <div class="col-sm-9">-->
<!--                <input class="form-control" type="text" name="client_address">-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="form-group" id="contractor" style="display: none;">-->
<!--            <label class="col-sm-3 control-label text-right">Contractor: </label>-->
<!--            <div class="col-sm-9">-->
<!--                <input type="text" class="form-control" name="contractor_name" id="contractor_name">-->
<!--                <input type="hidden" name="contractor_id" id="contractor_id">-->
<!--            </div>-->
<!--        </div>-->
    </div>
    <div class="panel-body col-sm-6">
        <?php
            echo $this->Form->input('received_from');
            echo $this->Form->input('letter_date',['type'=>'text','required','class'=>'form-control hasdatepicker']);
            echo $this->Form->input('subject');
        ?>
        <div class="form-group" id="work_description_wrp">
            <label class="col-sm-3 control-label text-right"><?= __('Work Description:') ?></label>
            <div class="col-sm-9">
                <textarea class="form-control" name="work_description" id="work_description"></textarea>
            </div>
        </div>
    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>
<script>
    jQuery(document).ready(function()
    {
        $(document).on("change", "#scheme-id", function(event)
        {
//            $('#contractor_id').val('');
//            $('#contractor_name').val('');
            $('#work_description').val('');
            var scheme_id = $(this).val();
            if(!scheme_id)
            {
//                $('.client').show();
                $('#work_description_wrp').show();
//                $('#contractor').hide();
            }
            else
            {
//                $('.client').hide();
                $('#work_description_wrp').hide();
//                $('#contractor').show();
<!--                $.ajax({-->
<!--                    url: '--><?//=$this->Url->build(('/LabLetterRegisters/get_contractor_by_scheme/'), true)?><!--',-->
<!--                    type: 'POST',-->
<!--                    dataType:'json',-->
<!--                    data:{scheme_id:scheme_id},-->
<!--                    success: function (data, status)-->
<!--                    {-->
<!--                        if(data)-->
<!--                        {-->
<!--                            $('#contractor_id').val(data.id);-->
<!--                            $('#contractor_name').val(data.contractor_title);-->
<!--                        }-->
<!--                        else-->
<!--                        {-->
<!--                            alert('No Contractors Found!')-->
<!--                        }-->
<!--                    },-->
<!--                    error: function (xhr, desc, err)-->
<!--                    {-->
<!--                        console.log("error");-->
<!---->
<!--                    }-->
<!--                });-->
            }
        });
    });
</script>
