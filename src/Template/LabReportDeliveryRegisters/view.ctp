<?php
use Cake\Core\Configure;
use Cake\Routing\Router;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Lab Report Delivery Registers'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('Lab Report Delivery Registers') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Lab Report Delivery Registers'), ['action' => 'index']) ?></li>
    </ul>
</div>


<div class="row panel panel-default">

    <div class="panel-heading">
        <h6 class="panel-title">
            <i class="icon-paragraph-right2"></i><?= __('Lab Report Delivery Registers') ?>
        </h6>
    </div>
    <div class="panel-body col-sm-12">
        <div class="form-group input col-sm-10">
            <label class="col-sm-5 control-label text-right"><?= __('Scheme/Work Descriptions') ?></label>
            <div class="col-sm-5 files">
                <textarea class="form-control" rows="4" disabled><?php echo (isset($labLetterRegisters['schemes']['name_en']) ? $labLetterRegisters['schemes']['name_en'] : $labLetterRegisters['work_description']); ?></textarea>
            </div>
        </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <td><?= __('Test Short Name') ?></td>
                <td><?= __('Test Full Name') ?></td>
                <td><?= __('Test Fee') ?></td>
                <td><?= __('Action') ?></td>
            </tr>
        </thead>
        <tbody>
            <?php
            if($all_tests)
            {
                foreach($all_tests as $test)
                {
                    ?>
                    <tr>
                        <td><?php echo $test['test_short_name']; ?></td>
                        <td><?php echo $test['test_full_name']; ?></td>
                        <td><?php echo $test['test_fee']; ?></td>
                        <td>
                            <?php
                            if(!$test['report_delivery_status'])
                            {
                                echo $this->Html->link('<button class="btn btn-info btn-icon" type="button"><i class="icon-signup"></i></button>', ['action' => 'add', $test['id']
                                    , '_full' => true], ['escapeTitle' => false, 'title' => 'Delivery Report']);
                            }
                            else
                            {
                                ?>
                                <sapn class="label label-danger"><?= __('Report Delivered') ?></sapn>
                            <?php
                            }
                            ?>
                        </td>
                    </tr>
                <?php
                }
            }
            else
            {
                ?>
                <tr><td class="text-center text-danger" colspan="4"><?= __('Test not found') ?></td></tr>
                <?php

            }
            ?>
        </tbody>

    </table>
    </div>
</div>


