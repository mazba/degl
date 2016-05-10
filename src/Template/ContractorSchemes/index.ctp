<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= $this->Html->link(__('Contractor Schemes'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <h6 class="panel-title">
            <i class="icon-paragraph-right2"></i><?= __('Scheme Assign') ?>
        </h6>
    </div>
    <div class="panel-body">
        <?php
        ?>
        <div class="form-group input">
            <label class="col-sm-3 control-label text-right"><?= __('Contractors') ?></label>
            <div class="col-sm-9 lead_contractor">
                <select class="select-search" tabindex="2" name="contractor" id="contractor" required="required">
                    <option value="Selected"><?= __('Select Contractor') ?></option>
                    <?php
                    foreach ($contractors as $contractor) {
                        if ($contractor['id'] == $is_lead->id) {
                            ?>
                            <option selected="selected"
                                    value="<?php echo $contractor['id']; ?>"><?php echo $contractor['contractor_title']; ?></option>
                            <?php
                        } else {
                            ?>
                            <option
                                value="<?php echo $contractor['id']; ?>"><?php echo $contractor['contractor_title']; ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="report" style="margin-top: 60px">

        </div>
    </div>
</div>

<style>
    #s2id_contractor{
        width:600px !important;}
</style>


<script>
    $(document).ready(function(){
       $(document).on('change', '#contractor', function(){
           var contractor_id=$(this).val();

           $.ajax({
               type:'POST',
               url: '<?= $this->request->webroot ?>ContractorSchemes/get_schemes_by_contractor_id',
               data: { contractor_id: contractor_id},
               success: function(data,status)
               {
                   console.log(data);
                    $('.report').html(data);
               },
               error: function(xhr, desc, err)
               {

               }
           })
       })
    });

    function print_rpt(){
        URL="<?php echo $this->request->webroot; ?>page/Print_a4_Eng.php?selLayer=PrintArea";
        day = new Date();
        id = day.getTime();
        eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=yes,scrollbars=yes ,location=0,statusbar=0 ,menubar=yes,resizable=1,width=880,height=600,left = 20,top = 50');");
    }
</script>

