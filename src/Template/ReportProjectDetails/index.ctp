<?php
//pr($scheme_statuses);die;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Project Report') ?></li>
    </ul>
</div>

<div class="projects index panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i> <?= __('List of Projects') ?></h6>
    </div>
        <table class="table">
            <thead>
            <tr>
                <th><?= __('id') ?></th>
                <th><?= __('Project Name') ?></th>
                <th><?= __('No of Schemes') ?></th>
                <th><?= __('Ongoing Schemes') ?></th>
                <th><?= __('Completed Schemes') ?></th>

            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($scheme_statuses as $key => $project)
            {
                ?>
                <tr>
                    <td><?= $this->Number->format($key+1); ?></td>
                    <td><?= isset($project['title'])?$project['title']:'' ?></td>
                    <td><?= isset($project['number_of_scheme'])?$this->Number->format($project['number_of_scheme']):''; ?></td>
                    <td><?= isset($project['deactive'])?$this->Number->format($project['number_of_scheme']-$project['deactive']):$this->Number->format($project['number_of_scheme']); ?></td>
                    <td><?= isset($project['deactive'])?$this->Number->format($project['deactive']):'0'; ?></td>
                </tr>

            <?php } ?>
            </tbody>
        </table>
    </div>