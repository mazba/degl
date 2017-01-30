<?php
use Cake\Core\Configure;

?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Items'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('Edit Item') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Items'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Item'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <li class="active"><?=
            $this->Html->link(__('Edit Item'), ['action' => 'edit', $item->id
            ]) ?>
        </li>
        <?php
        if ($user_roles['delete'] == 1)
        {
            ?>
            <li><?=
                $this->Form->postLink(
                    __('Delete Item'),
                    ['action' => 'delete', $item->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $item
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
                $this->Html->link(__('Details Item'), ['action' => 'view', $item->id])
                ?>
            </li>
        <?php
        }
        ?>


    </ul>
</div>


<?= $this->Form->create($item, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Item') ?>
        </h6></div>
    <div class="panel-body col-sm-6">
        <?php
        echo $this->Form->input('chapter_id', ['options' => $chapters]);
        echo $this->Form->input('item_display_code');
        echo $this->Form->input('main_code');
        ?>
    </div>
    <div class="panel-body col-sm-6">
        <?php
        echo $this->Form->input('level');
        echo $this->Form->input('unit');
        echo $this->Form->input('description');
        ?>
    </div>
    <div class="form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

