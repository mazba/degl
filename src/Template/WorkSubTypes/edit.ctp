<?php
use Cake\Core\Configure;

?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Work Sub Types'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('Edit Work Sub Type') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Work Sub Types'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Work Sub Type'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <li class="active"><?=
            $this->Html->link(__('Edit Work Sub Type'), ['action' => 'edit', $workSubType->id
            ]) ?>
        </li>
        <?php
        if ($user_roles['delete'] == 1)
        {
            ?>
            <li><?=
                $this->Form->postLink(
                    __('Delete Work Sub Type'),
                    ['action' => 'delete', $workSubType->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $workSubType
                        ->id)]
                )
                ?>
            </li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['view'] == 1)
        {
            ?>
            <li><?=
                $this->Html->link(__('Details Work Sub Type'), ['action' => 'view', $workSubType->id])
                ?>
            </li>
        <?php
        }
        ?>


    </ul>
</div>


<?= $this->Form->create($workSubType, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Work Sub Type') ?>
        </h6></div>
    <div class="panel-body col-sm-6">
        <?php
        echo $this->Form->input('work_type_id', ['options' => $workTypes]);

        echo $this->Form->input('title');
        ?>
    </div>
    <div class="panel-body col-sm-6">
        <?php
        echo $this->Form->input('short_title');

        ?>
    </div>
    <div class="form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

