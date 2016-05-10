<?php
if (!isset($active_module)) {
    $active_module = 0;
    $active_task = 0;
}
?>
<ul class="info-blocks" style="margin-top: 25px; text-align: left">

    <li class="bg-success">
        <a href="<?php echo $this->Url->build(('/Dashboard'), true); ?>">
            <div class="top-info">
                <?= __('Dashboard') ?>
            </div>
            <i class="icon-screen2"></i>
        </a>
    </li>
    <!--    <li class="--><?php //if($active_module==0){ echo 'active';} ?><!--"><a href="-->
    <?php //echo $this->Url->build(('/Dashboard'), true);?><!--"><span>-->
    <? //= __('Dashboard') ?><!-- </span> <i class="icon-screen2"></i></a></li>-->
    <?php
    foreach ($menus as $module) {
        ?>
        <li class="bg-success dropdown">
            <a href="#" class="dropdown-toggle"
               data-toggle="dropdown" <?php if ($active_module == $module[0]['module']['id']) {
                echo 'id="second-level"';
            } ?>>
                <div class="top-info">
                    <span><?= $module[0]['module']['name_bn'] ?></span>
                </div>
                <i class=" <?= $module[0]['module']['icon'] ? $module[0]['module']['icon'] : 'icon-spinner4' ?>"></i></a>
            <ul class="dropdown-menu">
                <?php
                foreach ($module as $task) {
                    ?>
                    <li class="<?php if ($active_task == $task->task['id']) {
                        echo 'active';
                    } ?>"><a
                            href="<?= $this->Url->build(['controller' => $task['task']['controller'], 'action' => 'index'], true); ?>"><?= $task['task']['name_bn'] ?></a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </li>
        <?php
    }
    ?>
</ul>

<style>
    .info-blocks > li {
        display: inline-block;
        min-width: 115px;
        margin: 0;
        text-align: center;
        white-space: nowrap;
        margin-top: 5px;
    }

    .info-blocks > li > a > i {
        display: inline-block;
        font-size: 29px;
        margin-bottom: 20px;
    }
</style>

