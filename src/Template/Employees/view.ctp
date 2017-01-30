<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Employees'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Employee') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Employees'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Employee'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['edit'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('Edit Employee'), ['action' => 'edit', $employee->id]) ?></li>
        <?php
        }
        ?>
        <li class="active"><?=
            $this->Html->link(__('Details Employee'), ['action' => 'view', $employee->id
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
                $employee->has('office') ?
                    $this->Html->link($employee->office
                        ->name_en, ['controller' => 'Offices',
                        'action' => 'view', $employee->office
                            ->id]) : '' ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Designation') ?></h6>
            </div>
            <div class="panel-body"><?=
                $employee->has('designation') ?
                    $this->Html->link($employee->designation
                        ->name_en, ['controller' => 'Designations',
                        'action' => 'view', $employee->designation
                            ->id]) : '' ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Father Name') ?></h6></div>
            <div class="panel-body"><?= h($employee->father_name) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Mother Name') ?></h6></div>
            <div class="panel-body"><?= h($employee->mother_name) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Name En') ?></h6></div>
            <div class="panel-body"><?= h($employee->name_en) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Name Bn') ?></h6></div>
            <div class="panel-body"><?= h($employee->name_bn) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Gender') ?></h6></div>
            <div class="panel-body"><?= h($employee->gender) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Phone') ?></h6></div>
            <div class="panel-body"><?= h($employee->phone) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Office Phone') ?></h6></div>
            <div class="panel-body"><?= h($employee->office_phone) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Mobile') ?></h6></div>
            <div class="panel-body"><?= h($employee->mobile) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Email') ?></h6></div>
            <div class="panel-body"><?= h($employee->email) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('National Id No') ?></h6></div>
            <div class="panel-body"><?= h($employee->national_id_no) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Picture') ?></h6></div>
            <div class="panel-body"><?= h($employee->picture) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Employee No') ?></h6></div>
            <div class="panel-body"><?= h($employee->employee_no) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Type') ?></h6></div>
            <div class="panel-body"><?= h($employee->type) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Religion') ?></h6></div>
            <div class="panel-body"><?= h($employee->religion) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Created User') ?></h6>
            </div>
            <div class="panel-body"><?=
                $employee->has('created_user') ?
                    $this->Html->link($employee->created_user
                        ->name_en, ['controller' => 'Users',
                        'action' => 'view', $employee->created_user
                            ->id]) : '' ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Updated User') ?></h6>
            </div>
            <div class="panel-body"><?=
                $employee->has('updated_user') ?
                    $this->Html->link($employee->updated_user
                        ->name_en, ['controller' => 'Users',
                        'action' => 'view', $employee->updated_user
                            ->id]) : '' ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Id') ?></h6></div>
            <div class="panel-body"><?= $this->Number->format($employee->id) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Birth Date') ?></h6></div>
            <div class="panel-body"><?=
                $this->System->display_date($employee->birth_date)
                ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Joining Date') ?></h6></div>
            <div class="panel-body"><?=
                $this->System->display_date($employee->joining_date)
                ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Created Date') ?></h6></div>
            <div class="panel-body"><?=
                $this->System->display_date_time($employee->created_date)
                ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Updated Date') ?></h6></div>
            <div class="panel-body"><?=
                $this->System->display_date_time($employee->updated_date)
                ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Status') ?></h6></div>
            <?php
            if ($employee->status == 1)
            {
                ?>
                <div class="panel-body"><?= __('Active') ?></div>
            <?php
            }
            elseif ($employee->status == 0)
            {
                ?>
                <div class="panel-body"><?= __('In-Active') ?></div>
            <?php
            }
            else
            {
                ?>
                <div class="panel-body"><?php echo $employee->status; ?></div>
            <?php

            }
            ?>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Present Address') ?></h6></div>
            <div class="panel-body"><?= $this->Text->autoParagraph(h($employee->present_address)); ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Permanent Address') ?></h6></div>
            <div class="panel-body"><?= $this->Text->autoParagraph(h($employee->permanent_address)); ?>
            </div>
        </div>
    </div>
</div>