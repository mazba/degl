<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Scheme Progresses'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Scheme Progress') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Scheme Progresses'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1) {
            ?>
            <li><?= $this->Html->link(__('New Scheme Progress'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <li class="active">
            <?= $this->Html->link(__('View Scheme Progress'), ['action' => '#']) ?>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12">
        <h1 class="text-center"><?= __('Scheme Name').': '.$schemeProgresses[0]['scheme']['name_en'] ?></h1>
        <h3 class="text-center"><?= __('Scheme Code').': '.$schemeProgresses[0]['scheme']['scheme_code'] ?></h3>
    </div>
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h6 class="panel-title"><i class="icon-grid"></i><?= __('Progress History') ?></h6></div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th><?= __('User') ?></th>
                        <th><?= __('Progress bars') ?></th>
                        <th><?= __('Progress %') ?></th>
                        <th><?= __('Date') ?></th>
                        <th><?= __('Remarks') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach($schemeProgresses as $schemeProgress)
                        {
                            ?>
                            <tr>
                                <td><span class="label label-info"><?= $schemeProgress['created_user']['name_en']; ?></span></td>
                                <td>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar <?= ($schemeProgress['progress_value']>50 ? 'progress-bar-success' : 'progress-bar-danger') ?>" role="progressbar" aria-valuenow="<?= $schemeProgress['progress_value'] ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $schemeProgress['progress_value'] ?>%;">
                                            <span class="sr-only"><?= $schemeProgress['progress_value'] ?>% <?= __('Complete') ?></span>
                                        </div>

                                    </div>
                                </td>
                                <td><span class="label label-default"><?= $schemeProgress['progress_value']; ?></span></td>
                                <td><?= $this->System->display_date($schemeProgress['created_date']); ?></td>
                                <td>
                                   <?= $schemeProgress['remarks'] ?>
                                </td>
                            </tr>
                            <?php
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>