<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= $this->Html->link(__('Development Summary'), ['action' => 'index']) ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('Development Summary'), ['action' => 'index']) ?> </li>



    </ul>
</div>
<div class="row">

    <div class="col-sm-offset-3 col-sm-6">
        <?php echo $this->Form->input('financial_year_id',['label'=>__('Financial Year'),'options'=>$financialYearEstimates,'empty'=>__('Select'),'id'=>'financial_year']) ?>
    </div>

    <div class="report_list col-sm-12" style="margin-top: 100px;">

    </div>

</div>


<script>
    $(document).ready(function(){
        $(document).on('change', '#financial_year', function(){
            var financial_year_id=$('#financial_year option:selected').text();

            $.ajax({
                type: 'POST',
                url: '<?php echo $this->request->webroot; ?>development_summary/project_list',
                data: {financial_year_id:financial_year_id},
                success: function(data,status){
                    if(data)
                    {
                        $('.report_list').html(data);
                    }else
                    {
                        $('.report_list').html("<h4 class='text-center'>No data found!.</h4>");
                    }

                },
                error: function(dhr,desc, err)
                {

                }
            })
        })
    })
</script>