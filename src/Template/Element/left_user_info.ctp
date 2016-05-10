<?php

use Cake\Routing\Router;
?>
<div class="user-menu dropdown">

    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <?php
        if($user_info['picture'])
        {
            ?>
            <img src="<?php echo Router::url('/',true).'img/'.$user_info['picture']; ?>">
            <?php
        }
        ?>
        <div class="user-info">

            <?= $user_info['name_en'] ?> <span><?= $user_info['name_bn'] ?></span>
            <br>


        </div>

        <div class="user_role" style="float: left">
            <span class="status status-success item-before"></span><?= "<b style='color: #0a73a7'> Login As: </b>". $user_roles['role_name'] ?>
        </div>

    </a>

    <div class="popup dropdown-menu dropdown-menu-right">

        <div class="thumbnail">

            <div class="thumb">

                <?php
                if($user_info['picture'])
                {
                    ?>
                    <img src="<?php echo Router::url('/',true).'img/'.$user_info['picture']; ?>">
                <?php
                }
                ?>

                <div class="thumb-options">

									<span>

										<a href="#" class="btn btn-icon btn-success"><i class="icon-pencil"></i></a>

										<a href="#" class="btn btn-icon btn-success"><i class="icon-remove"></i></a>

									</span>

                </div>

            </div>


            <div class="caption text-center">

                <h6><?= $user_info['name_bn'] ?></h6>

            </div>

        </div>


        <ul class="list-group">

            <li class="list-group-item"><i class="icon-pencil3 text-muted"></i> My posts <span
                    class="label label-success">289</span></li>

            <li class="list-group-item"><i class="icon-people text-muted"></i> Users online <span
                    class="label label-danger">892</span></li>

            <li class="list-group-item"><i class="icon-stats2 text-muted"></i> Reports <span
                    class="label label-primary">92</span></li>

            <li class="list-group-item"><i class="icon-stack text-muted"></i> Balance <h5
                    class="pull-right text-danger">$45.389</h5></li>

        </ul>

    </div>

</div>

<!-- /user dropdown -->
