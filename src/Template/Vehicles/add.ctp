<?php
use Cake\Core\Configure;

Configure::load('config_vehicles', 'default');
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Vehicles'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('New Vehicle') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Vehicles'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('New Vehicle'), ['action' => 'add']) ?></li>


    </ul>
</div>


<?= $this->Form->create($vehicle, ['class' => 'form-horizontal', 'role' => 'form', 'type' => 'file']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Vehicle') ?>
        </h6></div>
    <div class="panel-body col-sm-6">
        <?php
        echo $this->Form->input('type', ['options' => ['vehicles' => 'Vehicles', 'equipments' => 'Equipments']]);
        echo $this->Form->input('title', ['class' => 'form-control vehicles']);
        echo $this->Form->input('serial_no', ['class' => 'form-control vehicles']);
        echo $this->Form->input('registration_no', ['class' => 'form-control vehicles']);
        //        echo $this->Form->input('prefix_no',['class'=>'form-control vehicles']);
        echo $this->Form->input('engine_no', ['class' => 'form-control vehicles']);
        echo $this->Form->input('chasis_no', ['class' => 'form-control vehicles']);
        echo $this->Form->input('vehicle_location', ['class' => 'form-control']);
        //        echo $this->Form->input('vehicle_place_of_user',['class'=>'form-control']);
        ?>
        <?php
        echo $this->Form->input('equipment_id_no', ['class' => 'form-control equipment']);
        //        echo $this->Form->input('equipment_category',['class'=>'form-control equipment']);
        //        echo $this->Form->input('equipment_capacity',['class'=>'form-control equipment']);
        echo $this->Form->input('others',['label'=>_('Others / Lubricant Oil Capacity')]);
        echo $this->Form->input('daily_cost_ratio',['class' => 'form-control vehicles']);
        ?>
    </div>
    <div class="panel-body col-sm-6">
        <?php
        echo $this->Form->input('procurement_date', ['type' => 'text', 'value' => $this->System->display_date($vehicle->procurement_date), 'class' => 'form-control hasdatepicker vehicles']);
        echo $this->Form->input('make_and_model', ['class' => 'form-control vehicles']);
        echo $this->Form->input('country_of_origin', ['class' => 'form-control vehicles']);
        echo $this->Form->input('fuel_tank_capacity', ['class' => 'form-control vehicles']);
        //        echo $this->Form->input('oil_sump_capacity',['class'=>'form-control vehicles']);
        //        echo $this->Form->input('load_capacity',['class'=>'form-control vehicles']);
        echo $this->Form->input('vehicle_status', ['options' => Configure::read('vehicle_status')]);
        ?>
        <?php
        echo $this->Form->input('equipment_engine_capacity', ['class' => 'form-control equipment']);
        echo $this->Form->input('equipment_fuel_type', ['class' => 'form-control equipment', 'options' => ['Petrol' => 'Petrol', 'Octane' => 'Octane', 'Diesel' => 'Diesel', 'CNG' => 'CNG'],'empty'=>__('Select')]);
        echo $this->Form->input('equipment_source', ['class' => 'form-control equipment']);
        echo $this->Form->input('equipment_brand', ['class' => 'form-control equipment']);
        echo $this->Form->input('image', ['type' => 'file', 'data-preview-container' => '#profile_image_preview']);
        ?>
        <div id="profile_image_preview" class="col-sm-offset-3">

        </div>
    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>
<script>
    $(document).ready(function () {
        $(document).on('submit', 'form', function (e) {
            var type = $('#type').val();
            if (type == 'vehicles') {
                if ($('#title').val() == '') {
                    alert('<?php echo __('Title is required') ?>');
                    $('#title').css('background', '#FFF2F2')
                    e.preventDefault();
                }
            }
            else {
                if ($('#equipment-id-no').val() == '' || $('#equipment-category').val() == '') {
                    alert('<?php echo __('Equipment id and Equipment category is required') ?>');
                    $('#equipment-id-no').css('background', '#FFF2F2');
                    $('#equipment-category').css('background', '#FFF2F2');
                    e.preventDefault();
                }
            }
        });
    });
</script>
