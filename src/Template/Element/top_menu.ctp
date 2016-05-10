
<ul class="nav navbar-nav navbar-right collapse" id="navbar-icons">
    <li>
        <a  href="<?php echo $this->Url->build(["controller" => "Messages","action" => "index"]); ?>"> <img style="width: 35px;margin-top: -8px" src="<?= $this->request->webroot ?>img/envelope.png" alt=""> <span class="envelope"><?= $message['total'] ?></span> </a>
    </li>
    <li class="user dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown">
            <img width="40" height="40" style="border-radius:500px" src="<?php echo $this->request->webroot.'img/'.$user_info['picture']; ?>">
            <span><?= $user_info['name_bn'] ?></span>
            <i class="caret"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-right icons-right">
            <li><a href="<?php echo $this->Url->build([
                    "controller" => "MyProfiles",
                    "action" => "index"
                ]); ?>"><i class="icon-user"></i> <?= __('Profile') ?></a></li>
            <li>
                <a href="<?php echo $this->Url->build(array('controller' => 'Dashboard', 'action' => 'logout'), true); ?>">
                    <i class="icon-exit"></i> <?= __('Logout') ?>
                </a>
            </li>
        </ul>
    </li>
</ul>

<style>
    .envelope{
        color: white;
        font-size: 11px;
        font-weight: bold;
        margin-left: -2px;
        margin-top: -4px;
        position: absolute;
    }
</style>