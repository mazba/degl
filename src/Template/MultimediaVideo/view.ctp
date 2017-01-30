<?php use Cake\Routing\Router; ?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Videos'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Video') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Videos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Videos'), ['action' => 'add']) ?></li>
    </ul>
</div>
<div class="panel panel-default">
    <div class="panel-heading bg-info">
        <h6 class="panel-title text-center"><i class="icon-grid4"></i><?= __('Videos') ?></h6>
    </div>
    <div class="panel-body">
        <table class="table table-bordered show-grid">
            <thead>
            <tr>
                <td><?= __('Title') ?></td>
                <td><?= __('Location') ?></td>
                <td><?= __('Remarks') ?></td>
                <td><?= __('Image date') ?></td>
                <td><?= __('File') ?></td>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach($videos as $video)
            {
                ?>
                <tr>
                    <td><?php echo $video['title'] ?></td>
                    <td><?php echo $video['location'] ?></td>
                    <td><?php echo $video['remarks'] ?></td>
                    <td><?php echo date('d-m-Y',$video['date']) ?></td>
                    <td><a href="<?php echo Router::url('/',true).'files/multimedia_videos/'.$video['file_link']; ?>"> <i class="icon-play"></i> <?php echo $video['file_link']; ?></a></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>