<div class="row">
    <div class="col-md-12">
        <?= $this->Flash->render() ?>
        <?= $this->Form->create('', ['class' => 'form-horizontal', 'role' => 'form', 'type' => 'file']); ?>
        <?php
            if(isset($errors))
            {
                foreach($errors as $error){
                ?>
                    <div class="alert alert-danger fade in block">
                        <button data-dismiss="alert" class="close" type="button">×</button>
                        <i class="icon-info"></i><?= $error ?></div>
                <?php
                }
            }
        ?>
        <div class="form-group has-info has-feedback">
            <label class="col-sm-2 control-label"><?= __('Password') ?> </label>
            <div class="col-sm-10">
                <input name="pass" required="" type="password"   class="form-control">
            </div>
        </div>
        <div class="form-group has-info has-feedback">
            <label class="col-sm-2 control-label"><?= __('Confirm Password') ?> </label>
            <div class="col-sm-10">
                <input name="c_pass" type="password" required="" class="form-control">
            </div>
        </div>
        <div class="form-actions text-right">
            <button class="btn btn-primary" type="submit"><?= __('Submit') ?></button>
        </div>
        <?= $this->Form->end() ?>

    </div>
</div>