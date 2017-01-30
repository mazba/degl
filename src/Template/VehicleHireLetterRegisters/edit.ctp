<?php
use Cake\Core\Configure;

?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Vehicle Hire Letter Registers'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('Edit Vehicle Hire Letter Register') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Vehicle Hire Letter Registers'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1) {
            ?>
            <li><?= $this->Html->link(__('New Vehicle Hire Letter Register'), ['action' => 'add']) ?></li>
            <?php
        }
        ?>
        <li class="active"><?= $this->Html->link(__('Edit Vehicle Hire Letter Register'), ['action' => 'edit', $vehicleHireLetterRegister->id
            ]) ?>
        </li>
        <?php
        if ($user_roles['delete'] == 1) {
            ?>
            <li><?=
                $this->Form->postLink(
                    __('Delete Vehicle Hire Letter Register'),
                    ['action' => 'delete', $vehicleHireLetterRegister->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $vehicleHireLetterRegister
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
            <li><?= $this->Html->link(__('Details Vehicle Hire Letter Register'), ['action' => 'view', $vehicleHireLetterRegister->id])
                ?>
            </li>
            <?php
        }
        ?>


    </ul>
</div>


<?= $this->Form->create($vehicleHireLetterRegister, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Edit Vehicle Hire Letter Register') ?>
        </h6></div>
    <div class="panel-body col-sm-6">
        <?php
        echo $this->Form->input('letter_no');
        echo $this->Form->input('sharok_no');
        echo $this->Form->input('subject');
        echo $this->Form->input('sender_office');
        echo $this->Form->input('receive_office');
        echo $this->Form->input('receive_date');
        echo $this->Form->input('scheme_id', ['options' => $schemes, 'empty' => true]);
        echo $this->Form->input('client_name');
        echo $this->Form->input('client_phone');
        echo $this->Form->input('client_email');
        echo $this->Form->input('client_fax');
        echo $this->Form->input('work_description');
        echo $this->Form->input('remarks');
        echo $this->Form->input('status', ['options' => Configure::read('status_options')]);
        ?>
    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

