<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Issue Completion Certificate') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('Issue Completion Certificate'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class=" row panel panel-default">
    <div class="panel-heading">
        <h6 class="panel-title">
            <i class="icon-paragraph-right2"></i><?= __('Issue Completion Certificate') ?>
        </h6>
    </div>
    <div class="panel-body ">
        <div class="col-sm-12">
            <div class="form-group">
                <label class="col-sm-3 control-label text-right"><?= __('Scheme: ') ?></label>
                <div class="col-sm-6">
                    <select data-placeholder="Choose a Scheme" class="chosen-select"  id="scheme-id" name="scheme_id" class="form-control scheme_id" required="required">
                        <option title="<?= __('Select') ?>" value=""><?= __('Select') ?></option>
                        <?php
                        foreach($schemes as $id=>$scheme)
                        {

//                            $scheme =  str_replace('"',' ',$scheme);
//                            $string = $scheme;
//                            if (strlen($string) > 80)
//                            {
//                                // truncate string
//                                $stringCut = substr($string, 0, 80);
//                                $string = substr($stringCut, 0, strrpos($stringCut, ' '));
//                            }
                            ?>
                            <option title="<?= $scheme ?>" value="<?= $id ?>"><?= $scheme ?> ...</option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <button id="generate" class="btn btn-info"><?= __('Generate Certificate') ?></button>
                </div>
            </div>
        </div>
        <div class="col-md-12" id="report_wrp">

        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
       $(document).on('click','#generate',function(){
           var scheme_id = $('#scheme-id').val();
           if(scheme_id)
           {
               $.ajax({
                   url: '<?=$this->Url->build(('/IssueCompletionCertificate/ajax/get_certificate'), true)?>',
                   type: 'POST',
                   data:{scheme_id:scheme_id},
                   success: function (data, status)
                   {
                       $('#report_wrp').html(data);
                   },
                   error: function (xhr, desc, err)
                   {
                       console.log("error");
                   }
               });
           }
       });
    });
    function print_rpt($printArea){
        URL="<?php echo $this->request->webroot; ?>page/Print_a4_Eng.php?selLayer="+$printArea;
        day = new Date();
        id = day.getTime();
        eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=yes,scrollbars=yes ,location=0,statusbar=0 ,menubar=yes,resizable=1,width=880,height=600,left = 20,top = 50');");
    }
</script>