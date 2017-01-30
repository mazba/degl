<?php
use Cake\Core\Configure;
use Cake\Routing\Router;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Lab Test'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('Lab Test') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Lab Test'), ['action' => 'index']) ?></li>
    </ul>
</div>

<div class="taskManagement index panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i> <?= __('List of All Lab Test') ?></h6>
    </div>
    <div class="table table-bordered">
        <table class="table">
            <thead>
                <tr>
                    <td><?= __('Short Name') ?></td>
                    <td><?= __('Full Name') ?></td>
                    <td><?= __('Test Fee') ?></td>
                    <td><?= __('Remarks') ?></td>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach($lab_tests as $lab_test)
                {
                    ?>
                    <tr>
                        <td><?php echo $lab_test['test_short_name']; ?></td>
                        <td><?php echo $lab_test['test_full_name']; ?></td>
                        <td><?php echo $lab_test['test_fee']; ?></td>
                        <td><?php echo $lab_test['remarks']; ?></td>
                    </tr>
                    <?php
                }
            ?>
            </tbody>
        </table>

