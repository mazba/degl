<?php use Cake\Routing\Router; ?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Images'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Image') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Images'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Images'), ['action' => 'add']) ?></li>
    </ul>
</div>
<div class="panel panel-default">
    <div class="panel-heading bg-info">
        <h6 class="panel-title text-center"><i class="icon-grid4"></i><?= __('Images') ?></h6>
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
            foreach($images as $image)
            {
                ?>
                <tr>
                    <td><?php echo $image['title'] ?></td>
                    <td><?php echo $image['location'] ?></td>
                    <td><?php echo $image['remarks'] ?></td>
                    <td><?php echo date('d-m-Y',$image['date']) ?></td>
                    <td><a href="<?php echo Router::url('/',true).'files/multimedia_images/'.$image['file_link']; ?>"> <i class="icon-image"></i> <?php echo $image['file_link']; ?></a></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>