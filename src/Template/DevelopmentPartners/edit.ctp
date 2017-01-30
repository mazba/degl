<?php
use Cake\Core\Configure;

?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Development Partners'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('Edit Development Partner') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Development Partners'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Development Partner'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <li class="active"><?=
            $this->Html->link(__('Edit Development Partner'), ['action' => 'edit', $developmentPartner->id
            ]) ?>
        </li>
        <?php
        if ($user_roles['delete'] == 1)
        {
            ?>
            <li><?=
                $this->Form->postLink(
                    __('Delete Development Partner'),
                    ['action' => 'delete', $developmentPartner->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $developmentPartner
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
                $this->Html->link(__('Details Development Partner'), ['action' => 'view', $developmentPartner->id])
                ?>
            </li>
        <?php
        }
        ?>


    </ul>
</div>


<?= $this->Form->create($developmentPartner, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Development Partner') ?>
        </h6></div>
    <div class="panel-body col-sm-6">
        <?php
        echo $this->Form->input('name_en', ['label' => __('NAME_EN')]);
        echo $this->Form->input('short_code');
        ?>
    </div>
    <div class="panel-body col-sm-6">
        <?php
        echo $this->Form->input('name_bn', ['label' => __('NAME_BN')]);
        echo $this->Form->input('address');
        ?>
    </div>
    <div class="form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

