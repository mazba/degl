<?php
use Cake\Core\Configure;

?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Purto Bills'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('Edit Purto Bill') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Purto Bills'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1) {
            ?>
            <li><?= $this->Html->link(__('New Purto Bill'), ['action' => 'add']) ?></li>
            <?php
        }
        ?>
        <li class="active"><?=
            $this->Html->link(__('Edit Purto Bill'), ['action' => 'edit', $purtoBill->id
            ]) ?>
        </li>
        <?php
        if ($user_roles['delete'] == 1) {
            ?>
            <li><?=
                $this->Form->postLink(
                    __('Delete Purto Bill'),
                    ['action' => 'delete', $purtoBill->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $purtoBill
                        ->id)]
                )
                ?>
            </li>
            <?php
        }
        ?>
        <?php
        if ($user_roles['view'] == 1) {
            ?>
            <li><?=
                $this->Html->link(__('Details Purto Bill'), ['action' => 'view', $purtoBill->id])
                ?>
            </li>
            <?php
        }
        ?>


    </ul>
</div>


<?= $this->Form->create($purtoBill, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Edit Purto Bill') ?>
        </h6></div>
    <div class="panel-body col-sm-6 col-md-offset-2">
        <?php
        echo $this->Form->input('selected_nothi', ['value' => isset($selected_nothi) ? $selected_nothi['nothi_no'] : "", 'disabled']);
        echo $this->Form->input('parent_id', ['required', 'options' => $nothiRegisters, 'empty' => __('Select'), 'templates' => ['inputContainer' => '<div class="form-group nothi_register {{type}}{{required}}">{{content}}</div>']]);
        echo $this->Form->input('bill_type', ['class' => 'form-control']);
        echo $this->Form->input('gross_bill', ['class' => 'form-control']);
        echo $this->Form->input('security', ['class' => 'form-control cal']);
        echo $this->Form->input('vat', ['class' => 'form-control cal']);
        echo $this->Form->input('income_taxes', ['class' => 'form-control cal']);
        echo $this->Form->input('roller_charge', ['class' => 'form-control cal']);
        echo $this->Form->input('lab_fee', ['class' => 'form-control cal']);
        echo $this->Form->input('fine', ['class' => 'form-control cal']);
        echo $this->Form->input('net_taka');
        echo $this->Form->input('status', ['options' => Configure::read('status_options')]);
        ?>
    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>
<script>
    $(document).ready(function () {
        $(document).on('keyup', '.cal', function () {
            var gross_bill = parseFloat($('#gross-bill').val());
            $.each($('.cal'), function () {
                if (parseFloat($(this).val())) {
                    gross_bill = gross_bill - parseFloat($(this).val());
                }

            });
            if (gross_bill) {
                $('#net-taka').val(gross_bill)
            }
        });
    });
</script>