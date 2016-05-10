<?php
use Cake\Core\Configure;

?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Scheme Types'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('Edit Scheme Type') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Scheme Types'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1) {
            ?>
            <li><?= $this->Html->link(__('New Scheme Type'), ['action' => 'add']) ?></li>
            <?php
        }
        ?>
        <li class="active"><?= $this->Html->link(__('Edit Scheme Type'), ['action' => 'edit', $schemeType->id
            ]) ?>
        </li>
        <?php
        if ($user_roles['delete'] == 1) {
            ?>
            <li><?=
                $this->Form->postLink(
                    __('Delete Scheme Type'),
                    ['action' => 'delete', $schemeType->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $schemeType
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
            <li><?= $this->Html->link(__('Details Scheme Type'), ['action' => 'view', $schemeType->id])
                ?>
            </li>
            <?php
        }
        ?>


    </ul>
</div>


<?= $this->Form->create($schemeType, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Edit Scheme Type') ?>
        </h6></div>
    <div class="panel-body col-sm-6">
        <?php
        echo $this->Form->input('title');
        echo $this->Form->input('status', ['options' => Configure::read('status_options')]);
        ?>
    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

