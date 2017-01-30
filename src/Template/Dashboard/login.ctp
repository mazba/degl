<?= $this->Flash->render();?>
<form action="<?php echo $this->Url->build(array('controller' => 'Dashboard', 'action' => 'login'), true);?>" role="form" method="post">
    <div class="popup-header">
        <a href="#" class="pull-left"><i class="icon-user-plus"></i></a>
        <span class="text-semibold"><?= __('User Login') ?></span>
        <div class="btn-group pull-right">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-cogs"></i></a>
            <ul class="dropdown-menu icons-right dropdown-menu-right">
                <li><a href="<?= $this->request->webroot; ?>forgotpwd"><i class="icon-info"></i> <?= __('Forgot password?') ?></a></li>
                <li><a href="<?= $this->request->webroot; ?>usermanual.pdf"><i class="icon-file4"></i> <?= __('User Manual') ?></a></li>
                <li><a href="<?= $this->request->webroot; ?>app.apk"><i style="color: #008a00" class="icon-android"></i> Download LGED App &nbsp;</a></li>
            </ul>
        </div>
    </div>
    <div class="well">
        <div class="form-group has-feedback">
            <label><?= __('Username') ?></label>
            <input type="text" class="form-control" placeholder="<?= __('Username') ?>" name="username">
            <i class="icon-users form-control-feedback"></i>
        </div>

        <div class="form-group has-feedback">
            <label><?= __('Password') ?></label>
            <input type="password" class="form-control" placeholder="<?= __('Password') ?>" name="password">
            <i class="icon-lock form-control-feedback"></i>
        </div>

        <div class="row form-actions">
            <div class="col-xs-6">

            </div>

            <div class="col-xs-6">
                <button type="submit" class="btn btn-warning pull-right"><i class="icon-menu2"></i> <?= __('Login') ?></button>
            </div>
        </div>
    </div>
</form>