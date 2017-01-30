<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Project Income Expenses') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('Project Income Expenses'), ['action' => 'index']) ?> </li>
    </ul>
</div>
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title"><i class="icon-page-break"></i><?= __('Project Income Expenses') ?></h6>
        </div>
        <div class="panel-body">
            <div class="col-md-6 col-md-offset-3">
                <?php
                echo $this->Form->input('financial_year_estimate_id');
                ?>
                <button id="submit" style="margin-top: 10px" class="btn btn-info pull-right"><i class="icon-file"></i> <?= __('Show Report') ?> </button>
            </div>
            <div class="col-md-12" id="report_wrp">

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on("click", "#submit", function(event)
        {
            var financial_yr_id = $('#financial-year-estimate-id').val();
            var financial_yr_text = $('#financial-year-estimate-id :selected').text();
            if(financial_yr_id)
            {
                $.ajax({
                    url: '<?=$this->Url->build(('/ProjectIncomeExpenses/ajax/get_report'), true)?>',
                    type: 'POST',
                    data:{financial_yr_id:financial_yr_id,financial_yr_text:financial_yr_text},
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