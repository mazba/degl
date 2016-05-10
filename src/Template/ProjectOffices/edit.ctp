<?php
use Cake\Core\Configure;

?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Project Offices'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('Edit Project Office') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Project Offices'), ['action' => 'index']) ?></li>
        <li class="active"><?=
            $this->Html->link(__('Edit Project Office'), ['action' => 'edit', $project_id
            ]) ?>
        </li>
        <?php
        if ($user_roles['view'] == 1)
        {
            ?>
            <li><?=
                $this->Html->link(__('Details Project Office'), ['action' => 'view', $project_id])
                ?>
            </li>
        <?php
        }
        ?>


    </ul>
</div>


<?= $this->Form->create($projectOffice, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Edit('.$project->name_en.')') ?>
        </h6></div>
    <div class="panel-body col-sm-6">
        <?php
        ?>
        <input type="hidden" name="project_id" value="<?=$project_id?>">
        <?php
        echo $this->Form->input('office_id', ['options' => $offices]);
        ?>
    </div>
    <div class="panel-body col-sm-6">
        <?php
        echo $this->Form->input('financial_year_estimate_id', ['options' => $financialYearEstimates]);
        echo $this->Form->input('budget');
        ?>
    </div>
    <div class="form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>
<div>
    <?php
    if(sizeof($assigned_offices)>0)
    {
        ?>
        <table class="table">
            <thead>
            <tr>
                <th><?= __('Office') ?></th>
                <th><?= __('Financial Year') ?></th>
                <th><?= __('Budget') ?></th>
            </tr>
            <tbody>
                <?php
                foreach($assigned_offices as $office)
                {
                    ?>
                        <tr>
                            <td><?php echo $office['office']->name_en; ?></td>
                            <td><?php echo $office['financial_year_estimate']->name; ?></td>
                            <td><?php echo $office['budget']; ?></td>

                        </tr>
                    <?php
                }
                ?>
            </tbody>
            </thead>
        </table>
        <?php

    }
    ?>
</div>

