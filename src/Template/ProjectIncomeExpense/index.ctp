<?php
$year = date('Y');
$months = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
$list_of_yr = range(date('Y'),'2016');
$list_of_yr = array_combine($list_of_yr,$list_of_yr);
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('প্রকল্পের প্রাপ্ত অর্থ ও ব্যয়') ?></li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12">
        <p style="float: right; background-color: #65b688; color: white; padding: 10px 8px"><a href="<?=$this->Url->build(['controller' => 'ProjectIncomeExpense', 'action' => 'add'])?>" style="color: #fff"><?= __('নতুন প্রকল্পের প্রাপ্ত অর্থ ও ব্যয') ?></a></p>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?= $this->Form->create(null,['action'=>'index']); ?>
        <div class="col-sm-offset-2 col-sm-6" style="margin-top: 15px">
            <div class="form-group input select">
                <label class="col-sm-3 control-label text-right" for="category-name">Month</label>
                <div id="container_month" class="col-sm-9">
                    <select name="month" class="form-control" required="required">
                        <option value="">নির্বাচন করুন</option>
                        <?php
                        foreach ($months as $month) {
                            echo "<option value=\"" . $month . "\">" . $month . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-offset-2 col-sm-6" style="margin-top: 15px">
            <div class="form-group input select">
                <label class="col-sm-3 control-label text-right" for="category-name">Year</label>
                <div id="container_year" class="col-sm-9">
                    <select name="year" class="form-control" required="required">
                        <option value="">নির্বাচন করুন</option>
                        <?php
                        foreach ($list_of_yr as $list) {
                            echo "<option value=\"" . $list . "\">" . $list . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-8" style="margin-top: 15px">
        <div class="form-action">
            <?= $this->Form->submit('Submit', ['class' => 'btn btn-primary pull-right']); ?>
        </div>
    </div>
    <?= $this->Form->end(); ?>
</div>
<?php if(isset($results)): ?>
    <?php if(!empty($results)): ?>
        <div style="margin-top: 3em"></div>
        <div class="col-md-12">
            <button style="margin-right: 5px; margin-bottom: 1em" class="btn btn-info pull-right" id="print_button" onclick="print_rpt()"><?= __('Print') ?></button>
        </div>
        <div id="PrintArea" style="margin-top: 10px; padding: 5px; margin-bottom: 10px">
            <div class="col-md-12">
                <h3 class="text-center"><?= $this->Common->eng_to_bn($year-1) ?>-<?= $this->Common->eng_to_bn($year) ?><?= __('ইং অর্থ বৎসরে নির্বাহী প্রকৌশলী, এলজিইডি, গাজীপুর জেলার বিভিন্ন উন্নয়ন প্রকল্পের অনুকূলে প্রাপ্ত অর্থ ও ব্যয়ের হিসাব ') ?></h3>
                <p style="float: left; margin-left: 2em">জেলা:- গাজীপুর</p>
                <p style="float: right">তারিখ: <span contenteditable="true">এখানে লিখুন</span> পর্যন্ত</p>
            </div>
            <div class="col-sm-12">
                <table class="table table-bordered" style="border: 1px solid #eee; margin-bottom: 10px;">
                    <thead>
                    <tr>
                        <th><?= __('id') ?></th>
                        <th><?= __('প্রকল্পের / কর্মসূচির নাম') ?></th>
                        <th><?= __('প্রাপ্ত অর্থ (লক্ষ টাকা)') ?></th>
                        <th><?= __('ব্যয়িত অর্থ (লক্ষ টাকা)') ?></th>
                        <th><?= __('অব্যয়িত অর্থ (লক্ষ টাকা)') ?></th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($results as $key => $result)
                    {
                        ?>
                        <tr>
                            <td><?= $this->Number->format($key+1); ?></td>
                            <td><?= $result['project']['name_en'] ?></td>
                            <td><?= $result['receive_money'] ?></td>
                            <td><?= $result['expense_money'] ?></td>
                            <td><?= $result['unpaid_money'] ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <div style="margin-top: 3em"></div>
        <h3 class="text-center"><?= __('কোন তথ্য পাওয়া যায় নি') ?></h3>
    <?php endif; ?>
<?php endif; ?>
<script>
    function print_rpt(){
        URL="<?php echo $this->request->webroot; ?>page/Print_a4_Eng.php?selLayer=PrintArea";
        day = new Date();
        id = day.getTime();
        eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=yes,scrollbars=yes ,location=0,statusbar=0 ,menubar=yes,resizable=1,width=880,height=600,left = 20,top = 50');");
    }
</script>