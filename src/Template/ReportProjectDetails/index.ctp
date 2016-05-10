<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Project Report') ?></li>
    </ul>
</div>

<div class="projects index panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i> <?= __('List of Projects') ?></h6>
    </div>
    <div class="datatable">
        <table class="table">
            <thead>
            <tr>
                <th><?= __('id') ?></th>
                <th><?= __('Project Name') ?></th>
                <th><?= __('No of Schemes') ?></th>
                <th><?= __('Completed Schemes') ?></th>
                <th><?= __('Ongoing Schemes') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($projects as $project)
            {
                ?>
                <tr>
                    <td><?= $this->Number->format($project['id']); ?></td>
                    <td><?= h($project['name_en']); ?></td>
                    <td><?= $this->Number->format($project['total_scheme']); ?></td>
                    <td><?= $this->Number->format($project['complete_scheme']); ?></td>
                    <td><?= $this->Number->format($project['total_scheme']-$project['complete_scheme']); ?></td>
                </tr>

            <?php } ?>
            </tbody>
        </table>
    </div>
</div>