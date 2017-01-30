<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Modules'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('Edit Module') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Modules'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Module'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <li class="active"><?=
            $this->Html->link(__('Edit Module'), ['action' => 'edit', $module->id
            ]) ?>
        </li>
        <?php
        if ($user_roles['delete'] == 1)
        {
            ?>
            <li><?=
                $this->Form->postLink(
                    __('Delete Module'),
                    ['action' => 'delete', $module->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $module
                        ->name_en)]
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
                $this->Html->link(__('Details Module'), ['action' => 'view', $module->id])
                ?>
            </li>
        <?php
        }
        ?>


    </ul>
</div>


<?= $this->Form->create($module, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Edit Module') ?>
        </h6></div>
    <div class="panel-body">
        <?php
        echo $this->Form->input('component_id', ['options' => $components]);
        echo $this->Form->input('name_en');
        echo $this->Form->input('name_bn');
        echo $this->Form->input('icon');
        echo $this->Form->input('description');
        echo $this->Form->input('ordering');
        echo $this->Form->input('status', ['options' => ['1' => 'Active', '0' => 'In-Active']]);
        ?>

        <div class="form-actions text-right">
            <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
        </div>
    </div>
</div>
<?= $this->Form->end() ?>

