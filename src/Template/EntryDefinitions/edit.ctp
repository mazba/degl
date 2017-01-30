<?php
use Cake\Core\Configure;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>">Dashboard</a></li>
        <li><?= $this->Html->link(__('Entry Definitions'), ['action' => 'index']) ?></li>
                    <li class="active">Edit Entry Definition</li>
        
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Entry Definitions'), ['action' => 'index']) ?></li>
                    <?php
            if ($user_roles['add'] == 1)
            {
                ?>
                <li><?= $this->Html->link(__('New Entry Definition'), ['action' => 'add']) ?></li>
            <?php
            }
            ?>
            <li class="active"><?= $this->Html->link(__('Edit Entry Definition'), ['action' => 'edit', $entryDefinition->id
                ]) ?>
            </li>
            <?php
            if ($user_roles['delete'] == 1)
            {
                ?>
                <li><?=
                    $this->Form->postLink(
                        __('Delete Entry Definition'),
                        ['action' => 'delete', $entryDefinition->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $entryDefinition
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
                <li><?= $this->Html->link(__('Details Entry Definition'), ['action' => 'view', $entryDefinition->id])
                    ?>
                </li>
            <?php
            }
            ?>

        

    </ul>
</div>


<?= $this->Form->create($entryDefinition,['class' => 'form-horizontal','role'=>'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Edit Entry Definition') ?>
        </h6></div>
    <div class="panel-body col-sm-6">
        <?php
                            echo $this->Form->input('name');
                                    echo $this->Form->input('view_scope');
                                    echo $this->Form->input('attachments');
                                    echo $this->Form->input('creation_permission');
                                    echo $this->Form->input('approval_sequence');
                                    echo $this->Form->input('preconditions');
                                echo $this->Form->input('status', ['options' => Configure::read('status_options')]);
                        ?>
    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="Save" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

