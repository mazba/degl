<?php
use Cake\Core\Configure;

?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Projects'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('New Project') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Projects'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('New Project'), ['action' => 'add']) ?></li>


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
            echo $this->Form->input('start_date', ['type' => 'text', 'class' => 'form-control hasdatepicker']);
            echo $this->Form->input('parent_id', ['required', 'options' => $nothiRegisters, 'empty' => __('Select'), 'templates' => ['inputContainer' => '<div class="form-group nothi_register {{type}}{{required}}">{{content}}</div>']]);
            ?>
        </div>
        <div class="col-sm-6">
            <?php
            echo $this->Form->input('development_partner_id', ['options' => $developmentPartners, 'empty' => __('Select')]);
            echo $this->Form->input('name_bn', ['label' => __('NAME_BN')]);
            echo $this->Form->input('sector_id', ['options' => $sectors, 'empty' => __('Select')]);
            echo $this->Form->input('expected_completion_date', ['type' => 'text', 'class' => 'form-control hasdatepicker']);
            ?>
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

