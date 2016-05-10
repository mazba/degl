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
        if ($user_roles['add'] == 1) {
            ?>
            <li><?= $this->Html->link(__('New Project'), ['action' => 'add']) ?></li>
            <?php
        }
        ?>
        <li class="active"><?=
            $this->Html->link(__('Edit Project'), ['action' => 'edit', $project->id
            ]) ?>
        </li>
        <?php
        if ($user_roles['delete'] == 1) {
            ?>
            <li><?=
                $this->Form->postLink(
                    __('Delete Project'),
                    ['action' => 'delete', $project->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $project
                        ->id)]
                )
                ?>
            </li>
            <?php
        }
        ?>
        <?php
        if ($user_roles['view'] == 1) {
            ?>
            <li><?=
                $this->Html->link(__('Details Project'), ['action' => 'view', $project->id])
                ?>
            </li>
            <?php
        }
        ?>


    </ul>
</div>


<?= $this->Form->create($project, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Project') ?>
        </h6></div>
    <div class="panel-body">
        <div class="col-sm-6">
            <?php
            echo $this->Form->input('short_code');
            echo $this->Form->input('name_en', ['label' => __('NAME_EN')]);
            echo $this->Form->input('economic_head');
            ?>
            <div class="form-group input text">
                <label for="start-date" class="col-sm-3 control-label text-right"><?= __('Start Date') ?></label>

                <div class="col-sm-9 container_start_date">
                    <input type="text" name="start_date" value="<?php if ($project->start_date) {
                        echo date('d-m-Y', $project->start_date);
                    } ?>" id="start-date" maxlength="11" class="form-control hasdatepicker">
                </div>
            </div>
            <div class="form-group input text">
                <label for="actual-completion-date"
                       class="col-sm-3 control-label text-right"><?= __('Actual Completion Date') ?></label>

                <div class="col-sm-9 container_actual_completion_date">
                    <input type="text" name="actual_completion_date"
                           value="<?php if ($project->actual_completion_date) {
                               echo date('d-m-Y', $project->actual_completion_date);
                           } ?>" id="actual-completion-date" maxlength="11" class="form-control hasdatepicker">
                </div>
            </div>
            <?= $this->Form->input('parent_id', ['required', 'options' => $nothiRegisters, 'empty' => __('Select'), 'templates' => ['inputContainer' => '<div class="form-group nothi_register {{type}}{{required}}">{{content}}</div>']]); ?>
        </div>
        <div class="col-sm-6">
            <?php
            echo $this->Form->input('development_partner_id', ['options' => $developmentPartners]);
            echo $this->Form->input('name_bn', ['label' => __('NAME_BN')]);
            echo $this->Form->input('sector_id', ['options' => $sectors]);
            ?>
            <div class="form-group input text">
                <label for="expected-completion-date"
                       class="col-sm-3 control-label text-right"><?= __('Expected Completion Date') ?></label>

                <div class="col-sm-9 container_expected_completion_date">
                    <input type="text" name="expected_completion_date"
                           value="<?php if ($project->expected_completion_date) {
                               echo date('d-m-Y', $project->expected_completion_date);
                           } ?>" id="expected-completion-date"
                           maxlength="11" class="form-control hasdatepicker">
                </div>
            </div>
            <div class="form-group input text">
                <label for="extended-completion-date"
                       class="col-sm-3 control-label text-right"><?= __('Extended Completion Date') ?></label>

                <div class="col-sm-9 container_extended_completion_date">
                    <input type="text" name="extended_completion_date"
                           value="<?php if ($project->extended_completion_date) {
                               echo date('d-m-Y', $project->extended_completion_date);
                           } ?>" id="extended-completion-date" maxlength="11" class="form-control hasdatepicker">
                </div>
            </div>
            <?php if (isset($selected_nothi)) {
                echo $this->Form->input('selected_nothi', ['value' => $selected_nothi['nothi_no'], 'disabled']);
            } ?>
        </div>
        <div class="col-md-12 text-right">
            <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
        </div>
    </div>

</div>
<?= $this->Form->end() ?>

<script>
    $(document).ready(function () {
        $(document).on('change', '#parent-id', function () {
            var parent_id = $(this).val();
            var obj = $(this);
            $.ajax({
                type: 'POST',
                url: '<?= $this->Url->build("/NothiRegisters/getSubNothi")?>',
                data: {parent_id: parent_id},
                success: function (data, status) {
                    obj.closest('.nothi_register').nextAll('.nothi_register').remove();
                    if (data) {
                        obj.closest('.form-group').after(data);
                    }
                }
            });
        });
    })
</script>
