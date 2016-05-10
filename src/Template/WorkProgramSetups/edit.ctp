<?php
use Cake\Core\Configure;

?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Work Program Setups'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('Work Program Setup') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Work Program Setups'), ['action' => 'index']) ?></li>
    </ul>
</div>


<?= $this->Form->create('', ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-grid"></i> <?= __('Table elements') ?></h6></div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th><?= __('Item Code') ?></th>
                <th><?= __('Total Tk') ?></th>
                <th><?= __('Item Details') ?></th>
                <th><?= __('Start Date') ?></th>
                <th><?= __('End Date') ?></th>
                <th><?= __('Remarks') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php

            foreach($scheme_details as $scheme_detail)
            {
                ?>
                <tr>
                    <td class="text-center"><span class="label label-info"><?= $scheme_detail['item_code']; ?></span></td>
                    <td class="text-center"><?= $scheme_detail['total']; ?></td>
                    <td class="text-center"><?= $scheme_detail['details']; ?></td>
                    <td class="text-center"><input type="text" name="data[<?= $scheme_detail['id']; ?>][start_date]" value="<?= isset($old_work_data[$scheme_detail['id']]) ? $this->System->display_date($old_work_data[$scheme_detail['id']]['start_date']): ''; ?>"  class="form-control hasdatepicker"> </td>
                    <td class="text-center"><input type="text" name="data[<?= $scheme_detail['id']; ?>][end_date]" value="<?= isset($old_work_data[$scheme_detail['id']]) ? $this->System->display_date($old_work_data[$scheme_detail['id']]['end_date']): ''; ?>"  class="form-control hasdatepicker"> </td>
                    <td class="text-center"><input type="text" name="data[<?= $scheme_detail['id']; ?>][remarks]" value="<?= isset($old_work_data[$scheme_detail['id']]) ? $old_work_data[$scheme_detail['id']]['remarks'] : ''; ?>"  class="form-control"> </td>
                    <input type="hidden" name="data[<?= $scheme_detail['id']; ?>][item_code]" value="<?= $scheme_detail['item_code']; ?>" >
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
<div class="form-actions text-right">
    <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
</div>
<?= $this->Form->end() ?>

