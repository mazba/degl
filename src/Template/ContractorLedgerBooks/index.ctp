<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Contractor Ledger Books') ?> </li>
    </ul>
</div>
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title"><i class="icon-page-break"></i><?= __('Contractor Ledger Books') ?></h6>
        </div>
        <div class="panel-body">
            <div class="col-md-6 col-md-offset-3">
                <?= $this->Form->input('contractor_id',['empty'=>'Select']) ?>
                <br/>
                <br/>
                <?= $this->Form->input('financial_year_id',['empty'=>'Select','options'=>$financial_years]) ?>

                <button id="load" style="margin-top: 10px" class="btn btn-warning pull-right" type="button"><i class="icon-globe"></i><?= __('Load') ?></button>
            </div>
            <div class="row" id="report_wrp">

            </div>
            <div class="row">
                <div class="col-md-2 col-md-offset-5">
                    <button class="btn btn-info pull-right" id="print" onclick="print_rpt('PrintArea')"  style="display: none;" type="button"><i class="icon-print2"></i><?= __('Print') ?></button>
                </div>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyDm0DLjHrJ0j56M4Od2ch81kP0wIIhDpzk&language=bn">
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on("click", "#load", function(event)
        {
            $('#print').show();
            var contractor_id = $('#contractor-id').val();
            var financial_year_id = $('#financial-year-id').val();
            if(contractor_id && financial_year_id)
            {
                //$('#loader').show();
                $.ajax({
                    url: '<?=$this->Url->build(('/ContractorLedgerBooks/ajax/load_ledger'), true)?>',
                    type: 'POST',
                    data:{contractor_id:contractor_id, financial_year_id:financial_year_id},
                    success: function (data, status)
                    {
                        $('#report_wrp').html(data);
                        //$('#loader').hide();
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