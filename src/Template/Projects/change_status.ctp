<?php
use Cake\Core\Configure;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Projects'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('Edit Project') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Projects'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Project'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <li><?=
            $this->Html->link(__('Edit Project'), ['action' => 'edit', $project->id
            ]) ?>
        </li>
        <li class="active"><?=
            $this->Html->link(__('Close Project'), ['action' => 'change_status', $project->id
            ]) ?>
        </li>
    </ul>
</div>
<?= $this->Form->create($project, ['class' => 'form-horizontal', 'role' => 'form']); ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title"><i class="icon-paragraph-right2"></i><?= __('Close Project') ?>
            </h6>
        </div>
        <div class="panel-body">
            <?php
            echo $this->Form->input('status', ['options' => Configure::read('project_status')]);
            ?>

            <div class="form-group input number">
                <label for="completion-date" class="col-sm-3 control-label text-right"><?= __('Completion Date') ?></label>
                <div class="col-sm-9 container_completion_date">
                    <input type="text" value="<?= $this->System->display_date($project['completion_date']) ?>" name="completion_date" class="form-control hasdatepicker">
                </div>
            </div>

            <div class="form-actions text-right">
                <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
            </div>
        </div>

    </div>
<?= $this->Form->end() ?>
<script>
    $(document).ready(function(){
        $(".hasdatepicker" ).datepicker({changeMonth: true,changeYear: true});
    });
</script>
