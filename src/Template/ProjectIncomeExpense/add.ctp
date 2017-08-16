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
        <?= $this->Form->create($income,['action'=>'add']); ?>
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
    <div class="col-sm-12" style="margin-top: 1em">
        <table class="table table-bordered" style="border: 1px solid #eee; margin-bottom: 10px;">
            <thead>
            <tr>
                <th><?= __('id') ?></th>
                <th><?= __('প্রকল্পের / কর্মসূচির নাম') ?></th>
                <th><?= __('প্রাপ্ত অর্থ (লক্ষ টাকা )') ?></th>
                <th><?= __('ব্যয়িত অর্থ (লক্ষ টাকা)') ?></th>
                <th><?= __('অব্যয়িত অর্থ (লক্ষ টাকা)') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php $i=1; foreach($projects as $key => $project):  ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td>
                        <?= $project ?>
                        <input type="hidden" name="project_id[]" value="<?= $key ?>">
                    </td>
                    <td><input type="text" name="receive_money[]" id="" required></td>
                    <td><input type="text" name="expense_money[]" id="" required></td>
                    <td><input type="text" name="unpaid_money[]" id="" required></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="col-sm-12" style="margin-top: 15px">
        <div class="form-action">
            <?= $this->Form->submit('Submit', ['class' => 'btn btn-primary pull-right']); ?>
        </div>
    </div>
    <?= $this->Form->end(); ?>
</div>
