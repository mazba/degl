	<!-- Main navigation -->
    <?php
    if(!isset($active_module))
    {
        $active_module='dashboard';
    }
    ?>
<ul class="navigation">
    <li class="<?php if($active_module=='dashboard'){ echo 'active';} ?>"><a href="<?php echo $this->Url->build(('/Dashboard'), true);?>"><span>Dashboard</span> <i class="icon-screen2"></i></a></li>
    <?php
    foreach($menus as $module)
    {
        ?>
        <li class="<?php if($active_module==$module[0]['module']['id']){ echo 'active';} ?>">

            <a href="#" class="expand"><span><?=$module[0]['module']['name_en']?></span> <i class="<?=$module[0]['module']['icon']?>"></i></a>

            <ul>
                <?php
                    foreach($module as $task)
                    {
                        ?>
                        <li><a href="<?= $this->Url->build(('/'.$task['task']['controller']), true);?>"><?=$task['task']['name_en']?></a></li>
                        <?php
                    }
                ?>
            </ul>

        </li>
        <?php
    }
    ?>
</ul>

<!-- /main navigation -->