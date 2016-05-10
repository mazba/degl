<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Offices'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Office') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Offices'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Office'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['edit'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('Edit Office'), ['action' => 'edit', $office->id]) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['delete'] == 1)
        {
            ?>
            <li><?=
                $this->Form->postLink(__('Delete Office'), ['action' => 'delete', $office->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $office->id)]) ?>
            </li>
        <?php
        }
        ?>

        <li class="active"><?=
            $this->Html->link(__('Details Office'), ['action' => 'view', $office->id
            ]) ?>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('NAME_EN') ?></h6></div>
            <div class="panel-body"><?= h($office->name_en) ?></div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Office Code') ?></h6></div>
            <div class="panel-body"><?= h($office->office_code) ?></div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('DIVISION') ?></h6>
            </div>
            <div class="panel-body"><?=
                $office->has('division') ?
                    $this->Html->link($office->division
                        ->name_en, ['controller' => 'Divisions',
                        'action' => 'view', $office->division
                            ->id]) : '' ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('ZONE') ?></h6>
            </div>
            <div class="panel-body"><?=
                $office->has('zone') ?
                    $this->Html->link($office->zone
                        ->name_en, ['controller' => 'Zones',
                        'action' => 'view', $office->zone
                            ->id]) : '' ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('DISTRICT') ?></h6>
            </div>
            <div class="panel-body"><?=
                $office->has('district') ?
                    $this->Html->link($office->district
                        ->name_en, ['controller' => 'Districts',
                        'action' => 'view', $office->district
                            ->id]) : '' ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('UPAZILA') ?></h6>
            </div>
            <div class="panel-body"><?=
                $office->has('upazila') ?
                    $this->Html->link($office->upazila
                        ->name_en, ['controller' => 'Upazilas',
                        'action' => 'view', $office->upazila
                            ->id]) : '' ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('NAME_BN') ?></h6></div>
            <div class="panel-body"><?= h($office->name_bn) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Office Short Title') ?></h6></div>
            <div class="panel-body"><?= h($office->office_short_title) ?></div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Office Level') ?></h6></div>
            <div class="panel-body"><?= h($office->office_level) ?></div>
        </div>


        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Office Contact No') ?></h6></div>
            <div class="panel-body"><?= h($office->office_contact_no) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Created User') ?></h6>
            </div>
            <div class="panel-body"><?=
                $office->has('created_user') ?
                    $this->Html->link($office->created_user
                        ->name_en, ['controller' => 'Users',
                        'action' => 'view', $office->created_user
                            ->id]) : '' ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Updated User') ?></h6>
            </div>
            <div class="panel-body"><?=
                $office->has('updated_user') ?
                    $this->Html->link($office->updated_user
                        ->name_en, ['controller' => 'Users',
                        'action' => 'view', $office->updated_user
                            ->id]) : '' ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Id') ?></h6></div>
            <div class="panel-body"><?= $this->Number->format($office->id) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Created Date') ?></h6></div>
            <div class="panel-body"><?=
                $this->System->display_date_time($office->created_date)
                ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Updated Date') ?></h6></div>
            <div class="panel-body"><?=
                $this->System->display_date_time($office->updated_date)
                ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Status') ?></h6></div>
            <?php
            if ($office->status == 1)
            {
                ?>
                <div class="panel-body"><?= __('Active') ?></div>
            <?php
            }
            elseif ($office->status == 0)
            {
                ?>
                <div class="panel-body"><?= __('In-Active') ?></div>
            <?php
            }
            else
            {
                ?>
                <div class="panel-body"><?php echo $office->status; ?></div>
            <?php

            }
            ?>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Address') ?></h6></div>
            <div class="panel-body"><?= $this->Text->autoParagraph(h($office->address)); ?>
            </div>
        </div>
    </div>
</div>