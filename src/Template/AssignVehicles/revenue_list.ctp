<?php
$month = [1 => 'January',2 => 'February',3 => 'March',4 => 'April',5 => 'May',6 => 'June',7=>'July',8=>'August',9=>'September',10=>'october',11=>'November',12=>'December']
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Equipment Revenue') ?></li>
    </ul>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i> <?= __('Lists') ?></h6>
        </div>
    </div>
    <div class="col-md-6">
        <div class="pull-right">
        <a class="vehicle-list" href="<?= $this->Url->build(['controller' => 'AssignVehicles', 'action' => 'revenueCreate'])?>">নতুন আয় ব্যয়</a>
        </div>
    </div>
    <div class="col-md-12">
        <div class="districts index panel panel-default">
            <div class="datatable">
                <table class="table">
                    <thead>
                    <tr>
                        <th><?= __('id') ?></th>
                        <th><?= __('অর্থবছর') ?></th>
                        <th><?= __('মাস') ?></th>
                        <th><?= __('আয়') ?></th>
                        <th><?= __('ব্যয়') ?></th>
                        <th><?= __('পদক্ষেপ') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($revenueLists as $key => $revenueList)
                    {
                        ?>
                        <tr>
                            <td> <?= ++$key ?></td>
                            <td><?= h($revenueList['financial_year_estimate']['name']) ?></td>
                            <td><?= h($month[$revenueList['month']]) ?></td>
                            <td><?= h($revenueList['income']) ?></td>
                            <td><?= h($revenueList['expense']) ?></td>
                            <td class="actions">
                                <?php
                                echo $this->Html->link(__('সম্পাদন'), ['action' => 'revenueEdit', $revenueList['id']],['class'=>'btn btn-sm btn-warning', 'style' => ['margin-right:10px']]);
                                echo $this->Form->postLink(__('বাতিল'), ['action' => 'revenueDelete', $revenueList['id']],['class'=>'btn btn-sm btn-danger','confirm' => __('Are you sure you want to delete # {0}?', $revenueList['id'])]);
                                ?>

                            </td>
                        </tr>

                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<style>
    .vehicle-list {
        font-weight: bold;
        background: mediumseagreen;
        padding: 10px 12px;
        color: #fff;
        border-radius: 3px;
    }
    .vehicle-list:hover{
        color: #fff !important;
    }
</style>
