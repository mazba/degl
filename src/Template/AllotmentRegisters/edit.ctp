<?php
use Cake\Core\Configure;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Allotment Registers'), ['action' => 'index']) ?></li>
                    <li class="active"><?= __('Edit Allotment Register') ?></li>
        
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Allotment Registers'), ['action' => 'index']) ?></li>
                    <?php
            if ($user_roles['add'] == 1)
            {
                ?>
                <li><?= $this->Html->link(__('New Allotment Register'), ['action' => 'add']) ?></li>
            <?php
            }
            ?>
            <li class="active"><?= $this->Html->link(__('Edit Allotment Register'), ['action' => 'edit', $allotmentRegister->id
                ]) ?>
            </li>
            <?php
            if ($user_roles['delete'] == 1)
            {
                ?>
                <li><?=
                    $this->Form->postLink(
                        __('Delete Allotment Register'),
                        ['action' => 'delete', $allotmentRegister->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $allotmentRegister
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
                <li><?= $this->Html->link(__('Details Allotment Register'), ['action' => 'view', $allotmentRegister->id])
                    ?>
                </li>
            <?php
            }
            ?>

        

    </ul>
</div>


<?= $this->Form->create($allotmentRegister,['class' => 'form-horizontal','role'=>'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Edit Allotment Register') ?>
        </h6></div>
    <div class="panel-body col-sm-6">
        <?php
                            echo $this->Form->input('office_id', ['options' => $offices]);
                                    echo $this->Form->input('dr_cr');
                                    echo $this->Form->input('project_id', ['options' => $projects, 'empty' => true]);
                                    echo $this->Form->input('scheme_id', ['options' => $schemes, 'empty' => true]);
                                    echo $this->Form->input('memo_no');
                                    echo $this->Form->input('purto_bill_id');
                                    echo $this->Form->input('allotment_date');
                                    echo $this->Form->input('particulars');
                                    echo $this->Form->input('allotment_amount');
                                    echo $this->Form->input('remarks');
                                echo $this->Form->input('status', ['options' => Configure::read('status_options')]);
                        ?>
    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

