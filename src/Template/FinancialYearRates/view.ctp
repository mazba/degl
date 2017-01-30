<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Financial Year Rates'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Financial Year Rate') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Financial Year Rates'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Financial Year Rate'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['edit'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('Edit Financial Year Rate'), ['action' => 'edit', $financialYearRate->id]) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['delete'] == 1)
        {
            ?>
            <li><?= $this->Form->postLink(__('Delete Financial Year Rate'), ['action' => 'delete', $financialYearRate->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $financialYearRate->id)]) ?>
            </li>
        <?php
        }
        ?>

        <li class="active"><?= $this->Html->link(__('Details Financial Year Rate'), ['action' => 'view', $financialYearRate->id
            ]) ?>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-6">
        
                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Financial Year Estimate') ?></h6>
                        </div>
                        <div class="panel-body"><?= $financialYearRate->has('financial_year_estimate') ?
                            $this->Html->link($financialYearRate->financial_year_estimate
                            ->name, ['controller' => 'FinancialYearEstimates',
                            'action' => 'view', $financialYearRate->financial_year_estimate
                            ->id]) : '' ?>
                        </div>
                    </div>
                                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Irl Tag') ?></h6></div>
                        <div class="panel-body"><?= h($financialYearRate->irl_tag) ?></div>
                    </div>
                                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Created User') ?></h6>
                        </div>
                        <div class="panel-body"><?= $financialYearRate->has('created_user') ?
                            $this->Html->link($financialYearRate->created_user
                            ->name_en, ['controller' => 'Users',
                            'action' => 'view', $financialYearRate->created_user
                            ->id]) : '' ?>
                        </div>
                    </div>
                                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Updated User') ?></h6>
                        </div>
                        <div class="panel-body"><?= $financialYearRate->has('updated_user') ?
                            $this->Html->link($financialYearRate->updated_user
                            ->name_en, ['controller' => 'Users',
                            'action' => 'view', $financialYearRate->updated_user
                            ->id]) : '' ?>
                        </div>
                    </div>
                                                                        <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Id') ?></h6></div>
                                            <div class="panel-body"><?= $this->Number->format($financialYearRate->id) ?></div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Rate Month') ?></h6></div>
                                            <div class="panel-body"><?= $this->Number->format($financialYearRate->rate_month) ?></div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Created Date') ?></h6></div>
                                            <div class="panel-body"><?= $this->System->display_date_time($financialYearRate->created_date)
                            ?>
                        </div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Updated Date') ?></h6></div>
                                            <div class="panel-body"><?= $this->System->display_date_time($financialYearRate->updated_date)
                            ?>
                        </div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Status') ?></h6></div>
                                            <?php
                        if ($financialYearRate->status==1)
                        {
                        ?>
                        <div class="panel-body"><?= __('Active') ?></div>
                    <?php
                    }
                    elseif ($financialYearRate->status==0)
                    {
                    ?>
                    <div class="panel-body"><?= __('In-Active') ?></div>
                    <?php
                    }
                    else
                    {
                        ?>
                        <div class="panel-body"><?php echo $financialYearRate->status;?></div>
                    <?php

                    }
                    ?>
                                    </div>
                                </div>
</div>