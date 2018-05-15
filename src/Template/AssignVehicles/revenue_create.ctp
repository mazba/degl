<?php
use Cake\Core\Configure;
$month = [1 => 'January',2 => 'February',3 => 'March',4 => 'April',5 => 'May',6 => 'June',7=>'July',8=>'August',9=>'September',10=>'october',11=>'November',12=>'December']
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('নতুন রেকর্ড') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li>নতুন আয়-ব্যয়ের তথ্য</li>
    </ul>
</div>


<?= $this->Form->create($equipmentRevenues, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="panel panel-default">
    <div class="col-md-offset-3 col-md-6">
        <div class="panel-body col-sm-12">
            <?php
            echo $this->Form->input('financial_year_estimate_id', ['options' => $fiscalYears, 'empty' => 'নির্বাচন করুন', 'required' => 'required']);
            echo $this->Form->input('month', ['label' => 'মাস', 'options' => $month,  'empty' => 'নির্বাচন করুন', 'required' => 'required']);
            echo $this->Form->input('income', ['type' => 'number', 'label' => 'আয়', 'required' => 'required']);
            echo $this->Form->input('total_expense', ['type' => 'number', 'label' => 'পূর্তকাজের মোট ব্যয়', 'required' => 'required']);
            echo $this->Form->input('expense', ['type' => 'number', 'label' => 'ব্যয়', 'required' => 'required']);
            ?>
        </div>
        <div class="form-actions text-right">
            <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
        </div>
    </div>
</div>
<?= $this->Form->end() ?>

