<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Work Program Setups'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Work Program Setup') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Work Program Setups'), ['action' => 'index']) ?> </li>
        <li class="active"><a href="#"><?= __('Details Work Program Setup'); ?></a></li>
    </ul>
</div>
<div id="ganttChart"></div>
<br/><br/>
<div id="eventMessage"></div>
<link href="<?= $this->request->webroot.'js/ganttChart/css.css'?>" rel="stylesheet" type="text/css">
<script src="<?= $this->request->webroot.'js/ganttChart/date.js'?>" type="text/javascript"></script>
<script src="<?= $this->request->webroot.'js/ganttChart/jquery.ganttView.js'?>" type="text/javascript"></script>
<script type="text/javascript">
    var ganttData = [
        {
            id: 1, name: "<?= __('Items') ?>", series: [
        <?php
         foreach($workProgramSetups as $workProgramSetup)
         {
         ?>
                { name: "<?= $workProgramSetup['item_code'] ?>", start: new Date(<?= date('Y,m,d',strtotime('-1 Month',$workProgramSetup['start_date'])); ?>), end: new Date(<?= date('Y,m,d',strtotime('-1 Month',$workProgramSetup['end_date'])); ?>) },
         <?php
         }
         ?>
        ]
        }
    ];
    $(function () {
        $("#ganttChart").ganttView({
            data: ganttData,
            slideWidth: 840
        });

        // $("#ganttChart").ganttView("setSlideWidth", 600);
    });
</script>
