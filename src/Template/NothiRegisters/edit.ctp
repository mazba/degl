<?php
use Cake\Core\Configure;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Nothi'), ['action' => 'index']) ?></li>
                    <li class="active"><?= __('Edit Nothi') ?></li>
        
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Nothi'), ['action' => 'index']) ?></li>
                    <?php
            if ($user_roles['add'] == 1)
            {
                ?>
                <li><?= $this->Html->link(__('New Nothi'), ['action' => 'add']) ?></li>
            <?php
            }
            ?>
            <li class="active"><?= $this->Html->link(__('Edit Nothi'), ['action' => 'edit', $nothiRegister->id
                ]) ?>
            </li>
            <?php
            if ($user_roles['delete'] == 1)
            {
                ?>
                <li><?=
                    $this->Form->postLink(
                        __('Delete Nothi'),
                        ['action' => 'delete', $nothiRegister->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $nothiRegister
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
                <li><?= $this->Html->link(__('Details Nothi Register'), ['action' => 'view', $nothiRegister->id])
                    ?>
                </li>
            <?php
            }
            ?>

        

    </ul>
</div>


<?= $this->Form->create($nothiRegister, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Edit Nothi') ?>
        </h6></div>
    <div class="panel-body col-sm-8">
        <?php
        echo $this->Form->input('parent_id', ['options' => $nothiRegisters, 'empty' => __('Select')]);
        echo $this->Form->input('nothi_no', ['label' => __('Name')]);
        echo $this->Form->input('nothi_date', ['type' => 'text', 'value' => $this->System->display_date($nothiRegister->nothi_date), 'class' => 'form-control hasdatepicker']);
        echo $this->Form->input('remarks');
        ?>
        <div class="is_parent" style="<?= !$nothiRegister->parent_id? 'display:none': '' ?>">
            <?php
            echo $this->Form->input('project_id', ['options' => $projects, 'empty' => 'Other']);
            echo $this->Form->input('nothi_description');
            echo $this->Form->input('scheme_id', ['options' => $schemes, 'empty' => 'Other']);
            ?>
        </div>

    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>


<script>
    $(document).ready(function () {
        $(document).on('change', '#parent-id', function () {
            var parent_id = $(this).val();
            console.log(parent_id)
            if (parent_id) {
                $('.is_parent').show();
            } else {
                $('.is_parent').hide();
            }
        });
    });
</script>


