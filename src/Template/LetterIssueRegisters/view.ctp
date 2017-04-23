<?php
use Cake\Core\Configure;

Configure::load('config_receive_file_registers', 'default');
use Cake\Routing\Router;

?>
<div class="breadcrumb-line">
  <ul class="breadcrumb">
    <li><a href="<?= $this->Url->build(('/Dashboard'), TRUE); ?>"><?= __('Dashboard') ?></a></li>
    <li><?= $this->Html->link(__('Letter Issue Registers'), ['action' => 'index']) ?> </li>
    <li class="active"><?= __('Detail Letter Issue Register') ?> </li>
  </ul>
</div>
<div class="tabbable page-tabs">
  <ul class="nav nav-tabs">
    <li><?= $this->Html->link(__('List of Letter Issues'), ['action' => 'index']) ?> </li>
    <?php
    if ($user_roles['add'] == 1) {
      ?>
      <li><?= $this->Html->link(__('New Letter Issues'), ['action' => 'add']) ?></li>
      <?php
    }
    ?>

    <li class="active"><?= $this->Html->link(__('Details Letter Issue'), ['action' => 'view', $letterIssueRegister->id]) ?>
    </li>
  </ul>
</div>

<div class="row">
  <div class="col-sm-12">
    <button style="float: right" onclick="print_rpt()">Print</button>
  </div>
  <div id="PrintArea">
    <div class="col-sm-12">
      <h2 class="text-center"><?= __('Government of the People\'s Republic of Bangladesh') ?></h2>
      <h4 class="text-center"><?= __('Local Govt. Engineering Department') ?> </h4>
      <h4 class="text-center"><?= __('Office of the Executive Engineer') ?></h4>
      <h4 class="text-center">নলজানী,<?= __('District: Gazipur') ?></h4>
      <h4 class="text-center"><a>www.lged.gov.bd</a></h4>
      <div class="shek-hasina">
        উন্নয়নের গণতন্ত্র<br/>শেখ হাসিনার মূলমন্ত্র
      </div>
    </div>
    <div class="col-xs-10">
      <p style="font-size:14px;">স্মারক নং: <?= $letterIssueRegister->sarok_no; ?></p>
    </div>
    <div class="col-xs-2">
      <p style="font-size:14px;"> তারিখঃ <?= EngToBanglaNum(date('m/d/Y', $letterIssueRegister->issue_date)); ?></p>
    </div>
    <div class="col-sm-12" style="font-size:14px;">
      <?= $letterIssueRegister->description; ?>
    </div>

    <div class="col-sm-12" style="margin-top: 40px;">
      <p class="text-center" style="float: right;font-size:15px;">
        মোঃ আমিরুল ইসলাম খান <br>
        নির্বাহী প্রকৌশলী<br>
        এলজিইডি, গাজীপুর<br>
        ফোনঃ ৯২৬৩৯৮৯, ফ্যাক্সঃ ৯২৬৪১২৮<br>
        Email: xen.gazipur@lged.gov.bd<br>

      </p>
    </div>
    <style type="text/css">
      .shek-hasina {
        display: inline-block;
        position: absolute;
        right: 150px;
        top: 30px;
        border: 1px solid #ccc;
        padding: 5px;
        text-align: center;
        color: #ccc;
        font-size: 13px;
      }
      @media print {
        .shek-hasina {
          display: inline-block;
          position: absolute;
          right: 50px;
          top: 10px;
          border: 1px solid #ccc;
          padding: 5px;
          text-align: center;
          color: #ccc;
          font-size: 13px;
        }
      }
    </style>

  </div>
</div>
<?php
function EngToBanglaNum($input) {
  $bn_digits = array('০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯');
  return str_replace(range(0, 9), $bn_digits, $input);
}

?>

<script>
    function print_rpt() {
        URL = "<?php echo $this->request->webroot; ?>page/Print_a4_Eng.php?selLayer=PrintArea";
        day = new Date();
        id = day.getTime();
        eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=yes,scrollbars=yes ,location=0,statusbar=0 ,menubar=yes,resizable=1,width=880,height=600,left = 20,top = 50');");
    }

</script>
