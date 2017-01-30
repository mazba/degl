<?php
use Cake\Core\Configure;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>">Dashboard</a></li>
        <li><?= $this->Html->link(__('Assets'), ['action' => 'index']) ?></li>
                    <li class="active">Edit Asset</li>
        
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Assets'), ['action' => 'index']) ?></li>
                    <?php
            if ($user_roles['add'] == 1)
            {
                ?>
                <li><?= $this->Html->link(__('New Asset'), ['action' => 'add']) ?></li>
            <?php
            }
            ?>
            <li class="active"><?= $this->Html->link(__('Edit Asset'), ['action' => 'edit', $asset->id
                ]) ?>
            </li>
            <?php
            if ($user_roles['delete'] == 1)
            {
                ?>
                <li><?=
                    $this->Form->postLink(
                        __('Delete Asset'),
                        ['action' => 'delete', $asset->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $asset
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
                <li><?= $this->Html->link(__('Details Asset'), ['action' => 'view', $asset->id])
                    ?>
                </li>
            <?php
            }
            ?>

        

    </ul>
</div>


<?= $this->Form->create($asset,['class' => 'form-horizontal','role'=>'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Edit Asset') ?>
        </h6></div>
    <div class="panel-body col-sm-6 col-sm-offset-3">
        <?php
                            echo $this->Form->input('name');
                                    echo $this->Form->input('asset_code');
                                    echo $this->Form->input('description');
                                    echo $this->Form->input('quantity');
                                echo $this->Form->input('status', ['options' => Configure::read('status_options')]);
                        ?>
    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="Save" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

