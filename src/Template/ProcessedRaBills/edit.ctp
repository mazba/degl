<?php
use Cake\Core\Configure;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>">Dashboard</a></li>
        <li><?= $this->Html->link(__('Processed Ra Bills'), ['action' => 'index']) ?></li>
                    <li class="active">Edit Processed Ra Bill</li>
        
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Processed Ra Bills'), ['action' => 'index']) ?></li>
                    <?php
            if ($user_roles['add'] == 1)
            {
                ?>
                <li><?= $this->Html->link(__('New Processed Ra Bill'), ['action' => 'add']) ?></li>
            <?php
            }
            ?>
            <li class="active"><?= $this->Html->link(__('Edit Processed Ra Bill'), ['action' => 'edit', $processedRaBill->id
                ]) ?>
            </li>
            <?php
            if ($user_roles['delete'] == 1)
            {
                ?>
                <li><?=
                    $this->Form->postLink(
                        __('Delete Processed Ra Bill'),
                        ['action' => 'delete', $processedRaBill->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $processedRaBill
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
                <li><?= $this->Html->link(__('Details Processed Ra Bill'), ['action' => 'view', $processedRaBill->id])
                    ?>
                </li>
            <?php
            }
            ?>

        

    </ul>
</div>


<?= $this->Form->create($processedRaBill,['class' => 'form-horizontal','role'=>'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Edit Processed Ra Bill') ?>
        </h6></div>
    <div class="panel-body col-sm-6">
        <?php
                            echo $this->Form->input('scheme_id', ['options' => $schemes, 'empty' => true]);
                                    echo $this->Form->input('security');
                                    echo $this->Form->input('income_tex');
                                    echo $this->Form->input('vat');
                                    echo $this->Form->input('hire_charge');
                                    echo $this->Form->input('lab_fee');
                                    echo $this->Form->input('net_payable');
                        ?>
    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="Save" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

