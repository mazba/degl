<?php
use Cake\Core\Configure;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>">Dashboard</a></li>
        <li><?= $this->Html->link(__('Sectors'), ['action' => 'index']) ?></li>
                    <li class="active">Edit Sector</li>
        
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Sectors'), ['action' => 'index']) ?></li>
                    <?php
            if ($user_roles['add'] == 1)
            {
                ?>
                <li><?= $this->Html->link(__('New Sector'), ['action' => 'add']) ?></li>
            <?php
            }
            ?>
            <li class="active"><?= $this->Html->link(__('Edit Sector'), ['action' => 'edit', $sector->id
                ]) ?>
            </li>
            <?php
            if ($user_roles['delete'] == 1)
            {
                ?>
                <li><?=
                    $this->Form->postLink(
                        __('Delete Sector'),
                        ['action' => 'delete', $sector->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $sector
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
                <li><?= $this->Html->link(__('Details Sector'), ['action' => 'view', $sector->id])
                    ?>
                </li>
            <?php
            }
            ?>

        

    </ul>
</div>


<?= $this->Form->create($sector,['class' => 'form-horizontal','role'=>'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Edit Sector') ?>
        </h6></div>
    <div class="panel-body col-sm-6">
        <?php
                        echo $this->Form->input('name_en',['label'=> __('NAME_EN')]);
                                echo $this->Form->input('name_bn',['label'=> __('NAME_BN')]);
                                echo $this->Form->input('status', ['options' => Configure::read('status_options')]);
                        ?>
    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

