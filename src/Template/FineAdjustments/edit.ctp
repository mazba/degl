<?php
use Cake\Core\Configure;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>">Dashboard</a></li>
        <li><?= $this->Html->link(__('Fine Adjustments'), ['action' => 'index']) ?></li>
                    <li class="active">Edit Fine Adjustment</li>
        
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Fine Adjustments'), ['action' => 'index']) ?></li>
                    <?php
            if ($user_roles['add'] == 1)
            {
                ?>
                <li><?= $this->Html->link(__('New Fine Adjustment'), ['action' => 'add']) ?></li>
            <?php
            }
            ?>
            <li class="active"><?= $this->Html->link(__('Edit Fine Adjustment'), ['action' => 'edit', $fineAdjustment->id
                ]) ?>
            </li>
            <?php
            if ($user_roles['delete'] == 1)
            {
                ?>
                <li><?=
                    $this->Form->postLink(
                        __('Delete Fine Adjustment'),
                        ['action' => 'delete', $fineAdjustment->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $fineAdjustment
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
                <li><?= $this->Html->link(__('Details Fine Adjustment'), ['action' => 'view', $fineAdjustment->id])
                    ?>
                </li>
            <?php
            }
            ?>

        

    </ul>
</div>


<?= $this->Form->create($fineAdjustment,['class' => 'form-horizontal','role'=>'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Edit Fine Adjustment') ?>
        </h6></div>
    <div class="panel-body col-sm-6 col-sm-offset-3">
        <?php
                            echo $this->Form->input('scheme_id', ['options' => $schemes]);
                                    echo $this->Form->input('economic_code');
                                    echo $this->Form->input('adjusted_amount');
                                    echo $this->Form->input('reason');

                        ?>
    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="Save" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

