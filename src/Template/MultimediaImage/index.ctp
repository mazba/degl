<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Images') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Images'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Images'), ['action' => 'add']) ?></li>
    </ul>
</div>

<div class="tasks index panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i> <?= __('List of Images') ?></h6>
    </div>
    <div class="datatable">
        <table class="table">
            <thead>
            <tr>
                <th><?= __('Scheme') ?></th>
                <th><?= __('No Of Images') ?></th>
                <th><?= __('Action') ?></th>

            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($arrange_schemes as $scheme_id=>$scheme)
            {
                ?>
                <tr>
                    <td><?= h($scheme[0]) ?></td>
                    <td><?= count($scheme) ?></td>
                    <td class="actions">
                        <a href="<?= $this->Url->build(['controller'=>'MultimediaImage','action'=>'view',$scheme_id], true);?>"><button class="btn btn-icon icon-vimeo3" type="button"></button></a>
                    </td>
                </tr>

            <?php } ?>
            </tbody>
        </table>
    </div>
</div>