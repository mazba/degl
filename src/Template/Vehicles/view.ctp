<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Vehicles'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Vehicle') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Vehicles'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1) {
            ?>
            <li><?= $this->Html->link(__('New Vehicle'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['edit'] == 1) {
            ?>
            <li><?= $this->Html->link(__('Edit Vehicle'), ['action' => 'edit', $vehicle->id]) ?></li>
        <?php
        }
        ?>
        <li class="active"><?=
            $this->Html->link(__('Details Vehicle'), ['action' => 'view', $vehicle->id
            ]) ?>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-6">
        <?php
        if($vehicle->type == 'vehicles')
        {
            ?>
            <div class="panel panel-default">
                <div class="panel-heading"><h6
                        class="panel-title"><?= __('Title') ?></h6></div>
                <div class="panel-body"><?= h($vehicle->title) ?></div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading"><h6
                        class="panel-title"><?= __('Registration No') ?></h6></div>
                <div class="panel-body"><?= h($vehicle->registration_no) ?></div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading"><h6
                        class="panel-title"><?= __('Prefix No') ?></h6></div>
                <div class="panel-body"><?= h($vehicle->prefix_no) ?></div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading"><h6
                        class="panel-title"><?= __('Engine No') ?></h6></div>
                <div class="panel-body"><?= h($vehicle->engine_no) ?></div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading"><h6
                        class="panel-title"><?= __('Chasis No') ?></h6></div>
                <div class="panel-body"><?= h($vehicle->chasis_no) ?></div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading"><h6
                        class="panel-title"><?= __('Make And Model') ?></h6></div>
                <div class="panel-body"><?= h($vehicle->make_and_model) ?></div>
            </div>
            <?php
        }
        else
        {
            ?>
            <div class="panel panel-default">
                <div class="panel-heading"><h6
                        class="panel-title"><?= __('Equipment Id') ?></h6></div>
                <div class="panel-body"><?= $this->Number->format($vehicle->equipment_id_no) ?></div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading"><h6
                        class="panel-title"><?= __('Equipment Category') ?></h6></div>
                <div class="panel-body"><?= $vehicle->equipment_category ?></div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading"><h6
                        class="panel-title"><?= __('Equipment Brand') ?></h6></div>
                <div class="panel-body"><?= $vehicle->equipment_brand ?></div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading"><h6
                        class="panel-title"><?= __('Equipment Capacity') ?></h6></div>
                <div class="panel-body"><?= $vehicle->equipment_capacity ?></div>
            </div>
            <?php
        }
        ?>


    </div>
    <div class="col-md-6">
        <?php
        if($vehicle->type == 'vehicles')
        {
        ?>
            <div class="panel panel-default">
                <div class="panel-heading"><h6
                        class="panel-title"><?= __('Fuel Tank Capacity') ?></h6></div>
                <div class="panel-body"><?= $this->Number->format($vehicle->fuel_tank_capacity) ?></div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading"><h6
                        class="panel-title"><?= __('Oil Sump Capacity') ?></h6></div>
                <div class="panel-body"><?= $this->Number->format($vehicle->oil_sump_capacity) ?></div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading"><h6
                        class="panel-title"><?= __('Load Capacity') ?></h6></div>
                <div class="panel-body"><?= $this->Number->format($vehicle->load_capacity) ?></div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading"><h6
                        class="panel-title"><?= __('Country Of Origin') ?></h6></div>
                <div class="panel-body"><?= h($vehicle->country_of_origin) ?></div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading"><h6
                        class="panel-title"><?= __('Serial No') ?></h6></div>
                <div class="panel-body"><?= $this->Number->format($vehicle->serial_no) ?></div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading"><h6
                        class="panel-title"><?= __('Procurement Date') ?></h6></div>
                <div class="panel-body"><?=
                    $this->System->display_date($vehicle->procurement_date)
                    ?>
                </div>
            </div>
        <?php
        }
        else
        {
        ?>

            <div class="panel panel-default">
                <div class="panel-heading"><h6
                        class="panel-title"><?= __('Equipment Engine Capacity') ?></h6></div>
                <div class="panel-body"><?= $vehicle->equipment_engine_capacity ?></div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading"><h6
                        class="panel-title"><?= __('Equipment Fuel Type') ?></h6></div>
                <div class="panel-body"><?= $vehicle->equipment_fuel_type ?></div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading"><h6
                        class="panel-title"><?= __('Equipment Source') ?></h6></div>
                <div class="panel-body"><?= $vehicle->equipment_source ?></div>
            </div>
        <?php
        }
        ?>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Vehicle Status') ?></h6></div>
            <div class="panel-body"><?= h($vehicle->vehicle_status) ?></div>
        </div>
    </div>
</div>

