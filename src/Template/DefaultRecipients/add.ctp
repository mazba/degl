<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Default Recipients'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('New Work Sub Type') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Default Recipients'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('New Default Recipient'), ['action' => 'add']) ?></li>


    </ul>
</div>

<?= $this->Form->create($defaultRecipient, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Default Recipient') ?>
        </h6></div>

    <div class="panel-body col-sm-12">
        <div class="form-group input select">
            <label class="col-sm-1 control-label text-right" for="user-id"><?= __('User') ?></label>
            <div id="container_user_id" class="col-sm-11">
                <select id="user-id" class="form-control" name="user_id">
                    <?php foreach($users as $user){ ?>
                    <option value="<?= $user->id ?>"><?= $user->name_en." (".$user->designation->name_en.")"; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>

    </div>

    <div class="form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>