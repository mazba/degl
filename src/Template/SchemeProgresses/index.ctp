<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Scheme Progresses') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Scheme Progresses'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1) {
            ?>
            <li><?= $this->Html->link(__('New Scheme Progress'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>

    </ul>
</div>

<div class="schemeProgresses index panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i> <?= __('List of Scheme Progresses') ?></h6>
    </div>
    <div class="datatable">
        <table class="table">
            <thead>
            <tr>
                <th><?= __('Scheme') ?></th>
                <th><?= __('Progress Value') ?></th>
                <?php
                if (($user_roles['view'] == 1) || ($user_roles['edit'] == 1) || ($user_roles['delete'] == 1)) {
                    ?>
                    <th class="actions"><?= __('Actions') ?></th>
                <?php
                }
                ?>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($schemeProgresses as $schemeProgress) {
                ?>
                <tr>
                    <td title="<?=  $schemeProgress['schemes']['name_en']; ?>">
                        <?php
                        $string = strip_tags( $schemeProgress['schemes']['name_en']);

                        if (strlen($string) > 60)
                        {
                            // truncate string
                            $stringCut = substr($string, 0, 60);
                            $string = substr($stringCut, 0, strrpos($stringCut, ' ')).'...';
                        }
                        echo $string;
                        ?>
                    </td>
                    <td>
                        <div class="progress block-inner">
                            <div class="progress-bar <?= ($schemeProgress['progress_value']>50 ? 'progress-bar-success' : 'progress-bar-danger') ?>" role="progressbar" aria-valuenow="<?= $schemeProgress['progress_value'] ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $schemeProgress['progress_value'] ?>%;">
                                <?= $schemeProgress['progress_value'] ?>%
                            </div>
                        </div>
                    </td>
                    <td class="actions">
                        <?php
                        if ($user_roles['view'] == 1) {
                            echo $this->Html->link('<button class="btn btn-primary btn-icon" type="button"><i class="icon-newspaper"></i></button>', ['action' => 'view', $schemeProgress->scheme_id
                                , '_full' => true], ['escapeTitle' => false, 'title' => 'Details']);
                        }

                        ?>
                    </td>
                </tr>

            <?php } ?>
            </tbody>
        </table>
    </div>
</div>