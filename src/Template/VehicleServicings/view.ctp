<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Vehicle Servicings'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Vehicle Servicing') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Vehicle Servicings'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Vehicle Servicing'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['edit'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('Edit Vehicle Servicing'), ['action' => 'edit', $vehicleServicing->id]) ?></li>
        <?php
        }
        ?>
        <li class="active"><?=
            $this->Html->link(__('Details Vehicle Servicing'), ['action' => 'view', $vehicleServicing->id
            ]) ?>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-6">

        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Office') ?></h6>
            </div>
            <div class="panel-body"><?=
                $vehicleServicing->has('office') ?
                    $this->Html->link($vehicleServicing->office
                        ->name_en, ['controller' => 'Offices',
                        'action' => 'view', $vehicleServicing->office
                            ->id]) : '' ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Vehicle') ?></h6>
            </div>
            <div class="panel-body"><?=
                $vehicleServicing->has('vehicle') ?
                    $this->Html->link($vehicleServicing->vehicle
                        ->title, ['controller' => 'Vehicles',
                        'action' => 'view', $vehicleServicing->vehicle
                            ->id]) : '' ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Defects') ?></h6></div>
            <div class="panel-body"><?= h($vehicleServicing->defects) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Job Card') ?></h6></div>
            <div class="panel-body"><?= h($vehicleServicing->job_card) ?></div>
        </div>

    </div>
    <div class="col-md-6">

        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Breakdown Date') ?></h6></div>
            <div class="panel-body"><?=
                $this->System->display_date($vehicleServicing->breakdown_date)
                ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Km Hr') ?></h6></div>
            <div class="panel-body"><?= $this->Number->format($vehicleServicing->km_hr) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Is Periodic Maintenance') ?></h6></div>
            <div class="panel-body"><?= $this->Number->format($vehicleServicing->is_periodic_maintenance) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Servicing Start Date') ?></h6></div>
            <div class="panel-body"><?=
                $this->System->display_date($vehicleServicing->servicing_start_date)
                ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Servicing End Date') ?></h6></div>
            <div class="panel-body"><?=
                $this->System->display_date($vehicleServicing->servicing_end_date)
                ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Service Charge') ?></h6></div>
            <div class="panel-body"><?= $this->Number->format($vehicleServicing->service_charge) ?></div>
        </div>



    </div>
</div>