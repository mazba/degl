<?php
use Cake\Core\Configure;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Designations'), ['action' => 'index']) ?></li>
                    <li class="active"><?= __('Edit Designation') ?></li>
        
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Designations'), ['action' => 'index']) ?></li>
                    <?php
            if ($user_roles['add'] == 1)
            {
                ?>
                <li><?= $this->Html->link(__('New Designation'), ['action' => 'add']) ?></li>
            <?php
            }
            ?>
            <li class="active"><?= $this->Html->link(__('Edit Designation'), ['action' => 'edit', $designation->id
                ]) ?>
            </li>
            <?php
            if ($user_roles['delete'] == 1)
            {
                ?>
                <li><?=
                    $this->Form->postLink(
                        __('Delete Designation'),
                        ['action' => 'delete', $designation->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $designation
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
                <li><?= $this->Html->link(__('Details Designation'), ['action' => 'view', $designation->id])
                    ?>
                </li>
            <?php
            }
            ?>

        

    </ul>
</div>


<?= $this->Form->create($designation, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Designation') ?>
        </h6></div>
    <div class="panel-body">
        <?php
        echo $this->Form->input('office_id', ['options' => $offices]);
        echo $this->Form->input('name_en', ['label' => __('NAME_EN')]);
        echo $this->Form->input('name_bn', ['label' => __('NAME_BN')]);
        echo $this->Form->input('designationParentid',['label'=> __('PARENT_DESIGNATION'),'options' => $parent_designations, 'empty' =>  __('SELECT_PARENT_DESIGNATION')]);
        echo $this->Form->input('order_no',['label'=>__('Order')]);
        //echo $this->Form->input('status', ['options' => Configure::read('status_options')]);
        ?>

        <div class="form-actions text-right">
            <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
        </div>
    </div>
</div>
<?= $this->Form->end() ?>

