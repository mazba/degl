<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Project Offices'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Project Office') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Project Offices'), ['action' => 'index']) ?> </li>

        <?php
        if ($user_roles['edit'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('Edit Project Office'), ['action' => 'edit', $project_id]) ?></li>
        <?php
        }
        ?>
        <li class="active"><?=
            $this->Html->link(__('Details Project Office'), ['action' => 'view', $project_id
            ]) ?>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('NAME_EN') ?></h6>
            </div>
            <div class="panel-body"><?=
                $project->name_en ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('NAME_BN') ?></h6>
            </div>
            <div class="panel-body"><?=
                $project->name_bn ?>
            </div>
        </div>
    </div>

</div>
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