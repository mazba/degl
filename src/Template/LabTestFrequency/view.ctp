<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Lab Test Frequency'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Lab Test Frequency') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Lab Test Frequency'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Lab Test Frequency'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['edit'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('Edit Lab Test Frequency'), ['action' => 'edit', $labTestFrequency->id]) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['delete'] == 1)
        {
            ?>
            <li><?= $this->Form->postLink(__('Delete Lab Test Frequency'), ['action' => 'delete', $labTestFrequency->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $labTestFrequency->id)]) ?>
            </li>
        <?php
        }
        ?>

        <li class="active"><?= $this->Html->link(__('Details Lab Test Frequency'), ['action' => 'view', $labTestFrequency->id
            ]) ?>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-6">
        
                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Lab Test List') ?></h6>
                        </div>
                        <div class="panel-body"><?= $labTestFrequency->has('lab_test_list') ?
                            $this->Html->link($labTestFrequency->lab_test_list
                            ->test_short_name_en, ['controller' => 'LabTestLists',
                            'action' => 'view', $labTestFrequency->lab_test_list
                            ->id]) : '' ?>
                        </div>
                    </div>
                                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Created User') ?></h6>
                        </div>
                        <div class="panel-body"><?= $labTestFrequency->has('created_user') ?
                            $this->Html->link($labTestFrequency->created_user
                            ->name_en, ['controller' => 'Users',
                            'action' => 'view', $labTestFrequency->created_user
                            ->id]) : '' ?>
                        </div>
                    </div>
                                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Updated User') ?></h6>
                        </div>
                        <div class="panel-body"><?= $labTestFrequency->has('updated_user') ?
                            $this->Html->link($labTestFrequency->updated_user
                            ->name_en, ['controller' => 'Users',
                            'action' => 'view', $labTestFrequency->updated_user
                            ->id]) : '' ?>
                        </div>
                    </div>
                                                                        <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Id') ?></h6></div>
                                            <div class="panel-body"><?= $this->Number->format($labTestFrequency->id) ?></div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Item of Work') ?></h6></div>
                                            <div class="panel-body"><?= $this->Number->format($labTestFrequency->lab_test_group_id) ?></div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Test No') ?></h6></div>
                                            <div class="panel-body"><?= $this->Number->format($labTestFrequency->test_no) ?></div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Test No Type') ?></h6></div>
                                            <div class="panel-body"><?= $this->Number->format($labTestFrequency->test_no_type) ?></div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Per Unit') ?></h6></div>
                                            <div class="panel-body"><?= $this->Number->format($labTestFrequency->per_unit) ?></div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Unit Type') ?></h6></div>
                                            <div class="panel-body"><?= $this->Number->format($labTestFrequency->unit_type) ?></div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Created Date') ?></h6></div>
                                            <div class="panel-body"><?= $this->System->display_date_time($labTestFrequency->created_date)
                            ?>
                        </div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Updated Date') ?></h6></div>
                                            <div class="panel-body"><?= $this->System->display_date_time($labTestFrequency->updated_date)
                            ?>
                        </div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Status') ?></h6></div>
                                            <?php
                        if ($labTestFrequency->status==1)
                        {
                        ?>
                        <div class="panel-body">Active</div>
                    <?php
                    }
                    elseif ($labTestFrequency->status==0)
                    {
                    ?>
                    <div class="panel-body">In-Active</div>
                    <?php
                    }
                    else
                    {
                        ?>
                        <div class="panel-body"><?php echo $labTestFrequency->status;?></div>
                    <?php

                    }
                    ?>
                                    </div>
                                </div>
</div>