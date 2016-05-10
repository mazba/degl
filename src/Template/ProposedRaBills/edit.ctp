<?php
use Cake\Core\Configure;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Proposed Ra Bills'), ['action' => 'index']) ?></li>
                    <li class="active"><?= __('Edit Proposed Ra Bill') ?></li>
        
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Proposed Ra Bills'), ['action' => 'index']) ?></li>
                    <?php
            if ($user_roles['add'] == 1)
            {
                ?>
                <li><?= $this->Html->link(__('New Proposed Ra Bill'), ['action' => 'add']) ?></li>
            <?php
            }
            ?>
            <li class="active"><?= $this->Html->link(__('Edit Proposed Ra Bill'), ['action' => 'edit', $proposedRaBill->id
                ]) ?>
            </li>
            <?php
            if ($user_roles['delete'] == 1)
            {
                ?>
                <li><?=
                    $this->Form->postLink(
                        __('Delete Proposed Ra Bill'),
                        ['action' => 'delete', $proposedRaBill->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $proposedRaBill
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
                <li><?= $this->Html->link(__('Details Proposed Ra Bill'), ['action' => 'view', $proposedRaBill->id])
                    ?>
                </li>
            <?php
            }
            ?>

        

    </ul>
</div>


<?= $this->Form->create($proposedRaBill,['class' => 'form-horizontal','role'=>'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Edit Proposed Ra Bill') ?>
        </h6></div>
    <div class="panel-body col-sm-6">
        <?php
                            echo $this->Form->input('office_id', ['options' => $offices]);
                                    echo $this->Form->input('scheme_id', ['options' => $schemes]);
                                    echo $this->Form->input('ra_bill_no');
                                    echo $this->Form->input('total_payable');
                                    echo $this->Form->input('above_or_less');
                                    echo $this->Form->input('percentage');
                                    echo $this->Form->input('bill_amount');
                                    echo $this->Form->input('measurement_book_id', ['options' => $measurementBooks]);
                                echo $this->Form->input('status', ['options' => Configure::read('status_options')]);
                        ?>
    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

