<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Financial Year Rates') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Financial Year Rates'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Financial Year Rate'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>

    </ul>
</div>

<div class="financialYearRates index panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i> <?= __('List of Financial Year Rates') ?></h6>
    </div>
    <div class="datatable">
        <table class="table">
            <thead>
            <tr>
                <th><?= __('id') ?></th>
                <th><?= __('Financial Year') ?></th>
                <th><?= __('rate_month') ?></th>
                <th><?= __('irl_tag') ?></th>
                <?php
                if (($user_roles['view'] == 1) || ($user_roles['edit'] == 1) || ($user_roles['delete'] == 1))
                {
                    ?>
                    <th class="actions"><?= __('Actions') ?></th>
                <?php
                }
                ?>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($financialYearRates as $financialYearRate)
            {
                ?>
                <tr>
                    <td><?= $this->Number->format($financialYearRate->id) ?></td>
                    <td><?=
                        $financialYearRate->has('financial_year_estimate') ?
                            $this->Html->link($financialYearRate->financial_year_estimate
                                ->name, ['controller' => 'FinancialYearEstimates',
                                'action' => 'view', $financialYearRate->financial_year_estimate
                                    ->id]) : '' ?></td>
                    <td><?= $this->Number->format($financialYearRate->rate_month) ?></td>
                    <td><?= h($financialYearRate->irl_tag) ?></td>
                    <td class="actions">
                        <?php
                        if ($user_roles['view'] == 1)
                        {
                            echo $this->Html->link('<button class="btn btn-primary btn-icon" type="button"><i class="icon-newspaper"></i></button>', ['action' => 'view', $financialYearRate->id
                                , '_full' => true], ['escapeTitle' => false, 'title' => 'Details']);
                        }

                        ?>
                        <?php
                        if ($user_roles['edit'] == 1)
                        {
                            echo $this->Html->link('<button class="btn btn-info btn-icon" type="button"><i class="icon-pencil3"></i></button>', ['action' => 'edit', $financialYearRate->id
                            ], ['escapeTitle' => false, 'title' => 'edit']);
                        }
                        ?>
                        <?php
                        if ($user_roles['delete'] == 1)
                        {
                            echo $this->Form->postLink('<button class="btn btn-danger btn-icon" type="button"><i class="icon-close"></i></button>', ['action' => 'delete', $financialYearRate->id],
                                ['confirm' => __('Are you sure you want to delete # {0}?', $financialYearRate->id), 'escapeTitle' => false,
                                    'title' => 'delete']);
                        }

                        ?>
                    </td>
                </tr>

            <?php } ?>
            </tbody>
        </table>
    </div>
</div>