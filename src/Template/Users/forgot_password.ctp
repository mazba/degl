<div class="row">
    <div class="col-md-12">
        <?= $this->Flash->render() ?>
        <?= $this->Form->create('', ['class' => 'form-horizontal', 'role' => 'form', 'type' => 'file']); ?>
        <div class="form-group has-info has-feedback">
            <label class="col-sm-2 control-label"><?= __('Email') ?> </label>
            <div class="col-sm-10">
                <input name="email" required="" type="email"   class="form-control">
                <i class="icon icon-warning form-control-feedback"></i>
            </div>
        </div>
        <div class="form-group has-info has-feedback">
            <label class="col-sm-2 control-label"><?= __('Mobile') ?> </label>
            <div class="col-sm-10">
                <input name="mobile" type="number" required="" class="form-control">
                <i class="icon icon-warning form-control-feedback"></i>
            </div>
        </div>
        <div class="form-actions text-right">
            <button class="btn btn-primary" type="submit"><?= __('Submit a request to reset password.') ?></button>
        </div>
        <?= $this->Form->end() ?>

    </div>
</div>