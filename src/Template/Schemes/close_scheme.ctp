<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Schemes') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Schemes'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1) {
            ?>
            <li><?= $this->Html->link(__('New Scheme'), ['action' => 'add']) ?></li>
            <?php
        }
        ?>

        <?php
        if ($user_roles['edit'] == 1) {
            ?>
            <li class="active"><?= $this->Html->link(__('Close Scheme'), ['action' => 'close_scheme']) ?></li>
            <?php
        }
        ?>

    </ul>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h6 class="panel-title">
            <i class="icon-paragraph-right2"></i><?= __('Close Scheme') ?>
        </h6>
    </div>
    <?= $this->Form->create($scheme, ['class' => 'form-horizontal', 'role' => 'form']); ?>
    <div class="panel-body col-sm-12">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="form-group input number">
                <label class="col-sm-4 control-label text-right"><?= __('Work Assessment') ?></label>

                <div class="col-sm-8">
                    <textarea  name="work_remarks" class="form-control" id="work_remarks"> </textarea>
                </div>
            </div>
            <div class="form-group input text">
                <label for="actual-complete-date" class="col-sm-4 control-label text-right"><?= __('কাজ শেষের প্রকৃত
                        তারিখ') ?></label>

                <div class="col-sm-8 container_actual_complete_date">
                    <input type="text" name="actual_complete_date" value="17-Nov-2015" id="actual-complete-date"
                           maxlength="11" class="form-control hasdatepicker">
                </div>
            </div>
        </div>
        <div class="col-sm-10 form-actions text-right" style="display: block">
            <input type="submit" value="<?= __('Close Scheme') ?>" class="btn btn-primary">
        </div>
    </div>

    <?= $this->Form->end() ?>
</div>