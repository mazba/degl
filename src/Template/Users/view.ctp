<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Users'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail User') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Users'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1) {
            ?>
            <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?></li>
            <?php
        }
        ?>
        <?php
        if ($user_roles['edit'] == 1) {
            ?>
            <li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id]) ?></li>
            <?php
        }
        ?>
        <?php
        if ($user_roles['delete'] == 1) {
            ?>
            <li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
            </li>
            <?php
        }
        ?>

        <li class="active"><?= $this->Html->link(__('Details User'), ['action' => 'view', $user->id
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
            <div class="panel-body"><?= $user->has('office') ?
                    $this->Html->link($user->office
                        ->name_en, ['controller' => 'Offices',
                        'action' => 'view', $user->office
                            ->id]) : '' ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Department') ?></h6>
            </div>
            <div class="panel-body"><?= $user->has('department') ?
                    $this->Html->link($user->department
                        ->name_en, ['controller' => 'Departments',
                        'action' => 'view', $user->department
                            ->id]) : '' ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Designation') ?></h6>
            </div>
            <div class="panel-body"><?= $user->has('designation') ?
                    $this->Html->link($user->designation
                        ->name_en, ['controller' => 'Designations',
                        'action' => 'view', $user->designation
                            ->id]) : '' ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Username') ?></h6></div>
            <div class="panel-body"><?= h($user->username) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Password') ?></h6></div>
            <div class="panel-body"><?= h($user->password) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Name En') ?></h6></div>
            <div class="panel-body"><?= h($user->name_en) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Name Bn') ?></h6></div>
            <div class="panel-body"><?= h($user->name_bn) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('User Group') ?></h6>
            </div>
            <div class="panel-body"><?= $user->has('user_group') ?
                    $this->Html->link($user->user_group
                        ->name_en, ['controller' => 'UserGroups',
                        'action' => 'view', $user->user_group
                            ->id]) : '' ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Gender') ?></h6></div>
            <div class="panel-body"><?= h($user->gender) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Phone') ?></h6></div>
            <div class="panel-body"><?= h($user->phone) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Office Phone') ?></h6></div>
            <div class="panel-body"><?= h($user->office_phone) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Mobile') ?></h6></div>
            <div class="panel-body"><?= h($user->mobile) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Email') ?></h6></div>
            <div class="panel-body"><?= h($user->email) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('National Id No') ?></h6></div>
            <div class="panel-body"><?= h($user->national_id_no) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Picture') ?></h6></div>
            <div class="panel-body"><?= h($user->picture) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Id') ?></h6></div>
            <div class="panel-body"><?= $this->Number->format($user->id) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Birth Date') ?></h6></div>
            <div class="panel-body"><?= $this->System->display_date($user->birth_date)?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Created By') ?></h6></div>
            <div class="panel-body"><?= $this->System->display_date_time($user->created_by)
                ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Created Date') ?></h6></div>
            <div class="panel-body"><?= $this->System->display_date_time($user->created_date)
                ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Updated By') ?></h6></div>
            <div class="panel-body"><?= $this->System->display_date_time($user->updated_by)
                ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Updated Date') ?></h6></div>
            <div class="panel-body"><?= $this->System->display_date_time($user->updated_date)
                ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Status') ?></h6></div>
            <?php
            if ($user->status == 1) {
                ?>
                <div class="panel-body"><?= __('Active') ?></div>
                <?php
            } elseif ($user->status == 0) {
                ?>
                <div class="panel-body"><?= __('In-Active') ?></div>
                <?php
            } else {
                ?>
                <div class="panel-body"><?php echo $user->status; ?></div>
                <?php

            }
            ?>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Present Address') ?></h6></div>
            <div class="panel-body"><?= $this->Text->autoParagraph(h($user->present_address)); ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Permanent Address') ?></h6></div>
            <div class="panel-body"><?= $this->Text->autoParagraph(h($user->permanent_address)); ?>
            </div>
        </div>
    </div>
</div>