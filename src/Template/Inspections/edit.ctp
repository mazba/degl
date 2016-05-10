<?php
use Cake\Core\Configure;

?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>">Dashboard</a></li>
        <li><?= $this->Html->link(__('Inspections'), ['action' => 'index']) ?></li>
        <li class="active">Edit Inspection</li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Inspections'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1) {
            ?>
            <li><?= $this->Html->link(__('New Inspection'), ['action' => 'add']) ?></li>
            <?php
        }
        ?>
        <li class="active"><?= $this->Html->link(__('Edit Inspection'), ['action' => 'edit', $inspection->id
            ]) ?>
        </li>
        <?php
        if ($user_roles['delete'] == 1) {
            ?>
            <li><?=
                $this->Form->postLink(
                    __('Delete Inspection'),
                    ['action' => 'delete', $inspection->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $inspection
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
            <li><?= $this->Html->link(__('Details Inspection'), ['action' => 'view', $inspection->id])
                ?>
            </li>
            <?php
        }
        ?>


    </ul>
</div>


<?= $this->Form->create($inspection, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Edit Inspection') ?>
        </h6></div>
    <div class="panel-body col-sm-offset-2 col-sm-8">
        <div class="col-sm-10">
            <?php
            echo $this->Form->input('financial_year_estimate_id', ['options' => $financialYearEstimates, 'disabled']); ?>
        </div>
        <div class="col-sm-10">
            <?php
            echo $this->Form->input('inspected_team', ['value' => $inspection->inspected_team['name_bn'], 'disabled']);
            ?>
        </div>

        <div class="scheme_area col-sm-12">
            <?php foreach ($schemes as $scheme) { ?>
                <div class="row" style="background: #e0e2e5;padding-top: 15px">
                    <div class="col-sm-10 scheme_form">
                        <div class="form-group input text">
                            <label for="inspected-scheme" class="col-sm-3 control-label text-right">Scheme</label>

                            <div class="col-sm-9 container_inspected_scheme">
                                <input type="text" name="" class="form-control" value="<?= $scheme->name ?>">
                            </div>
                        </div>
                        <div class="form-group input text">
                            <label for="status" class="col-sm-3 control-label text-right"><?= __('অবস্থা ১') ?></label>

                            <div class="col-sm-9 container_status">
                                <input disabled type="text" name="" class="form-control"
                                       value="<?php if ($scheme->status1 == 1) {
                                           echo "Ok";
                                       } else {
                                           echo "Not Ok";
                                       } ?>" id="status">
                            </div>
                        </div>
                        <?= $this->Form->input('status2[' . $scheme->id . ']', ['type'=>'select','label' => __('অবস্থা ' . $this->Number->format('2')), 'options' => [0 => 'Not Ok', 1 => 'Ok'],'default'=>$scheme->status2]) ?>
                    </div>

                </div>
            <?php } ?>
        </div>


        <div class="col-sm-10">
            <?php
            echo $this->Form->input('remarks');
            echo $this->Form->input('status', ['options' => Configure::read('status_options')]);
            ?>
        </div>
    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

