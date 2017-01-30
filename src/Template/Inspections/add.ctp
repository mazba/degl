<div id="add_team_form" style="display: none">
    <?= $this->Form->input('team_name_en', ['label' => __('Team Name English')]) ?>
    <?= $this->Form->input('team_name_bn', ['label' => __('Team Name Bangla')]) ?>
</div>

<div id="scheme_form_copy" style="display: none">
    <div class="row" style="background: #e0e2e5;padding-top: 15px">
        <div class="col-sm-10 scheme_form">
            <?= $this->Form->input('project_id', ['options' => $projects, 'empty' => __('Select'), 'class' => 'project_id']) ?>
            <div class="scheme_list"></div>
        </div>
        <div class="col-sm-2">
            <span id="add_project" class="btn btn-info btn-sm" style="margin-top: 5px"><?= __('+') ?></span>
            <span  class="btn btn-danger btn-sm remove_project" style="margin-top: 5px"><?= __('X') ?></span>
        </div>
    </div>
</div>

<?php
use Cake\Core\Configure;

?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Inspections'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('New Inspection') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Inspections'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('New Inspection'), ['action' => 'add']) ?></li>
        <?php
        if ($user_roles['report'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('Report'), ['action' => 'report']) ?></li>
            <?php
        }
        ?>

    </ul>
</div>


<?= $this->Form->create($inspection, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Inspection') ?>
        </h6></div>
    <div class="panel-body col-sm-offset-2 col-sm-8">
        <div class="col-sm-10">
            <?php
            echo $this->Form->input('financial_year_estimate_id', ['options' => $financialYearEstimates, 'empty' => __('Select')]); ?>
        </div>
        <div class="col-sm-10">
            <?php
            echo $this->Form->input('inspected_team_id', ['options' => $inspectedTeams, 'empty' => __('Select')]);
            ?>
        </div>
        <div class="col-sm-2">
            <span id="add_team" class="btn btn-warning btn-sm" style="margin-top: 5px"><?= __('+ Add Team') ?></span>
        </div>
        <div id="add_team_create_form" class="col-sm-10">
        </div>

        <div class="scheme_area col-sm-12">
            <div class="row" style="background: #e0e2e5;padding-top: 15px">
                <div class="col-sm-10 scheme_form">
                    <?= $this->Form->input('project_id', ['options' => $projects, 'empty' => __('Select'), 'class' => 'project_id']) ?>
                    <div class="scheme_list"></div>
                </div>
                <div class="col-sm-2">
                    <span id="add_project" class="btn btn-info btn-sm" style="margin-top: 5px"><?= __('+') ?></span>
                </div>
            </div>
        </div>



        <div class="col-sm-10">
            <?php
            echo $this->Form->input('remarks');
            echo $this->Form->input('status', ['options' => Configure::read('status_options')]);
            ?>
        </div>
    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>


<script>
    $(document).ready(function () {
        $(document).on('click', '#add_team', function () {
            var html = $('#add_team_form').html();
            $('#add_team_create_form').html(html);
        });

        $(document).on('change', '#project-id', function () {
            var project_id = $(this).val();
            var obj=$(this);

            $.ajax({
                type: 'POST',
                url: '<?= $this->request->webroot ?>inspections/get_scheme_list',
                data: {project_id: project_id},
                success: function (data, status) {
                    obj.closest('.scheme_form').find('.scheme_list').html(data)

                },
                error: function (xhr, desc, err) {

                }

            })
        });

        $(document).on('click', '#add_project', function () {
            $(this).hide();
            var html = $('#scheme_form_copy').html();
            $('.scheme_area').append(html);
        });

        $(document).on('click','.remove_project', function(){
            $(this).closest('.row').prev('.row').find('#add_project').show();
            $(this).closest('.row').remove();
        });
    })
</script>



