<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Assign Vehicles'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Assign Vehicle') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Assign Vehicles'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Assign Vehicle'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['edit'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('Edit Assign Vehicle'), ['action' => 'edit', $assignVehicle->id]) ?></li>
        <?php
        }
        ?>

        <li class="active"><?=
            $this->Html->link(__('Details Assign Vehicle'), ['action' => 'view', $assignVehicle->id
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
                $assignVehicle->has('office') ?
                    $this->Html->link($assignVehicle->office
                        ->name_en, ['controller' => 'Offices',
                        'action' => 'view', $assignVehicle->office
                            ->id]) : '' ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Vehicle') ?></h6>
            </div>
            <div class="panel-body"><?=
                $assignVehicle->has('vehicle') ?
                    $this->Html->link($assignVehicle->vehicle
                        ->title, ['controller' => 'Vehicles',
                        'action' => 'view', $assignVehicle->vehicle
                            ->id]) : '' ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Employee') ?></h6>
            </div>
            <div class="panel-body"><?=
                $assignVehicle->has('employee') ?
                    $this->Html->link($assignVehicle->employee
                        ->id, ['controller' => 'Employees',
                        'action' => 'view', $assignVehicle->employee
                            ->id]) : '' ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Created User') ?></h6>
            </div>
            <div class="panel-body"><?=
                $assignVehicle->has('created_user') ?
                    $this->Html->link($assignVehicle->created_user
                        ->name_en, ['controller' => 'Users',
                        'action' => 'view', $assignVehicle->created_user
                            ->id]) : '' ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Updated User') ?></h6>
            </div>
            <div class="panel-body"><?=
                $assignVehicle->has('updated_user') ?
                    $this->Html->link($assignVehicle->updated_user
                        ->name_en, ['controller' => 'Users',
                        'action' => 'view', $assignVehicle->updated_user
                            ->id]) : '' ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Id') ?></h6></div>
            <div class="panel-body"><?= $this->Number->format($assignVehicle->id) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Assign Date') ?></h6></div>
            <div class="panel-body"><?=
                $this->System->display_date($assignVehicle->assign_date)
                ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('End Date') ?></h6></div>
            <div class="panel-body"><?=
                $this->System->display_date($assignVehicle->end_date)
                ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Created Date') ?></h6></div>
            <div class="panel-body"><?=
                $this->System->display_date_time($assignVehicle->created_date)
                ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Updated Date') ?></h6></div>
            <div class="panel-body"><?=
                $this->System->display_date_time($assignVehicle->updated_date)
                ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Status') ?></h6></div>
            <?php
            if ($assignVehicle->status == 1)
            {
                ?>
                <div class="panel-body"><?= __('Active') ?></div>
            <?php
            }
            elseif ($assignVehicle->status == 0)
            {
                ?>
                <div class="panel-body"><?= __('In-Active') ?></div>
            <?php
            }
            else
            {
                ?>
                <div class="panel-body"><?php echo $assignVehicle->status; ?></div>
            <?php

            }
            ?>
        </div>
    </div>
</div>