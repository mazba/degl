<?php
use Cake\Core\Configure;

Configure::load('config_receive_file_registers', 'default');
use Cake\Routing\Router;

?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Letter Issue Registers'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Letter Issue Register') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Letter Issues'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Letter Issues'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>

        <li class="active"><?=
            $this->Html->link(__('Details Letter Issue'), ['action' => 'view', $letterIssueRegister->id
            ]) ?>
        </li>
    </ul>
</div>

<div class="row">
    <div class="col-sm-12">
        <button style="float: right" onclick="print_rpt()">Print</button>
    </div>
    <div id="PrintArea">
    <div class="col-sm-12">
        <h4 class="text-center"><?= __('Government of the People\'s Republic of Bangladesh')?></h4>
        <h4 class="text-center"><?= __('Local Govt. Engineering Department')?> </h4>
        <h4 class="text-center"><?= __('Office of the Executive Engineer')?></h4>
        <h4 class="text-center"><?= __('District: Gazipur')?></h4>
        <h4 class="text-center"><a>www.lged.gov.bd</a></h4>
    </div>
    <div class="col-sm-10">
        <p>Memo No: <?= $letterIssueRegister->sarok_no; ?></p>
    </div>
    <div class="col-sm-2">
        <p>Date: <?= date('m/d/Y',$letterIssueRegister->issue_date); ?></p>
    </div>
    <div class="col-sm-12">
        <?= $letterIssueRegister->description; ?>
    </div>

    <div class="col-sm-12" style="margin-top: 40px;">
        <p class="text-center" style="float: left">
            (Md. Amirul Islam Khan)<br>
            Executive Engineer<br>
            LGED, Gazipur.<br>
            Phone: 9263989, Fax: 9264128<br>
            e-mail: xen.gazipur@lged.gov.bd<br>
        </p>
    </div>
</div>
</div>

<script>
    function print_rpt() {
        URL = "<?php echo $this->request->webroot; ?>page/Print_a4_Eng.php?selLayer=PrintArea";
        day = new Date();
        id = day.getTime();
        eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=yes,scrollbars=yes ,location=0,statusbar=0 ,menubar=yes,resizable=1,width=880,height=600,left = 20,top = 50');");
    }

</script>
