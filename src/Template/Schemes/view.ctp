<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Schemes'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Scheme') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Schemes'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Scheme'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['edit'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('Edit Scheme'), ['action' => 'edit', $multimedia_data->id]) ?></li>
        <?php
        }
        ?>
        <li class="active"><?= $this->Html->link(__('Details Scheme'), ['action' => 'view', $multimedia_data->id
            ]) ?>
        </li>
    </ul>
</div>
<div class="row">
    <div class="well text-center" style="margin-bottom: 20px">
        <h3><?= $multimedia_data->name_en ?></h3>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2><?= __('Investigation Report') ?></h2>
        </div>
        <div class="panel-body">
            <?php
            foreach($project_images as $project_image)
            {
                ?>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="block">
                        <div class="thumbnail thumbnail-boxed">
                            <div class="thumb">
                                <img style="width: 100%; height: 200px;" src="<?= $this->request->webroot; ?>api/images/<?= $project_image['image_path'] ?>" alt=""/>
                                <div class="thumb-options">
                                    <span>
                                        <a class="btn btn-icon btn-success" href="<?= $this->request->webroot; ?>api/images/<?= $project_image['image_path'] ?>" target="_blank"><i class="icon-folder-download"></i></a>
                                    </span>
                                </div>
                            </div>
                            <div class="caption">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <?= date('d/m/Y',$project_image['created_date']) ?>
                                        <?= date('h:i:s A',$project_image['created_date']) ?>
                                    </div>
                                    <div class="col-xs-7">
                                        <img style="width: 40px;height: 40px; float:left;" src="<?= $this->request->webroot; ?>img/<?= $project_image['users']['picture'] ?>" alt=""/><?= $project_image['users']['name_bn'] ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            foreach($project_videos as $project_video)
            {
                ?>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="block">
                        <div class="thumbnail thumbnail-boxed">
                            <div class="thumb">
                                <video width="100%"  controls="controls">
                                    <source src="<?= $this->request->webroot; ?>api/videos/<?= $project_video['video_path'] ?>" type="video/mp4">
                                </video>

                            </div>
                            <div class="caption">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <?= date('d/m/Y',$project_video['created_date']) ?>
                                        <?= date('h:i:s A',$project_video['created_date']) ?>
                                    </div>
                                    <div class="col-xs-7">
                                        <img style="width: 40px;height: 40px; float:left;" src="<?= $this->request->webroot; ?>img/<?= $project_video['users']['picture'] ?>" alt=""/><?= $project_video['users']['name_bn'] ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2><?= __('Multimedia') ?></h2>
        </div>
        <div class="panel-body">
            <?php
            foreach($multimedia_data['multimedia'] as $multimedia)
            {
                if($multimedia['type'] == 'image')
                {
                    ?>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="block">
                            <div class="thumbnail thumbnail-boxed">
                                <div class="thumb">
                                    <img style="max-height: 170px; width: 100%" src="<?= $this->request->webroot; ?>files/multimedia_images/<?= $multimedia['file_link'] ?>" alt="">
                                    <div class="thumb-options">
                                    <span>
                                        <a target="_blank" class="btn btn-icon btn-success" href="<?= $this->request->webroot; ?>files/multimedia_images/<?= $multimedia['file_link'] ?>"><i class="icon-quill2"></i></a>
                                    </span>
                                    </div>
                                </div>
                                <div class="caption">
                                    <a class="caption-title" title="" href="#"><?= $multimedia['title']; ?></a>
                                    <?= $multimedia['remarks'] ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                else
                {
                    ?>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="block">
                            <div class="thumbnail thumbnail-boxed">
                                <div class="thumb">
                                    <video width="100%" src="<?= $this->request->webroot; ?>files/multimedia_videos/<?= $multimedia['file_link'] ?>" controls="controls"></video>
                                </div>
                                <div class="caption">
                                    <a class="caption-title" title="" href="#"><?= $multimedia['title']; ?></a>
                                    <?= $multimedia['remarks'] ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>

                <?php
            }
            ?>
        </div>
    </div>
</div>
<style>
    .thumbnail{
        height: 300px;
    }
</style>