<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>">Dashboard</a></li>
        <li><?= $this->Html->link(__('Tree Plants'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Tree Plant') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Tree Plants'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1) {
            ?>
            <li><?= $this->Html->link(__('New Tree Plant'), ['action' => 'add']) ?></li>
            <?php
        }
        ?>
        <?php
        if ($user_roles['edit'] == 1) {
            ?>
            <li><?= $this->Html->link(__('Edit Tree Plant'), ['action' => 'edit', $treePlant->id]) ?></li>
            <?php
        }
        ?>
        <?php
        if ($user_roles['delete'] == 1) {
            ?>
            <li><?= $this->Form->postLink(__('Delete Tree Plant'), ['action' => 'delete', $treePlant->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $treePlant->id)]) ?>
            </li>
            <?php
        }
        ?>

        <li class="active"><?= $this->Html->link(__('Details Tree Plant'), ['action' => 'view', $treePlant->id
            ]) ?>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12">

        <h4 class="text-center"><?= __($treePlant->financial_year_estimate
                    ->name . ' অর্থবছরে এলজিইডির আওতায় গাজীপুর জেলার বৃক্ষরোপণ সংক্রাস্ত তথ্যাদি'); ?></h4>

        <table class="table table-bordered">
            <tr>
                <td colspan="5"><?= __($treePlant->financial_year_estimate
                            ->name . ' অর্থবছরে চারা রোপণের লক্ষমাত্রা ') ?></td>
                <td colspan="7"><?= __($treePlant->financial_year_estimate
                            ->name . ' অর্থবছরে চারা রোপণের অগ্রগতি ') ?></td>
                <td colspan="4"><?= __($treePlant->financial_year_estimate
                            ->name . ' অর্থবছরে পরিচর্যার পর জীবিত গাছের সংখ্যা ') ?></td>
            </tr>
            <tr>
                <td><?= __('বনজ (সংখ্যা)') ?></td>
                <td><?= __('ভেষজ (সংখ্যা)') ?></td>
                <td><?= __('ফলজ (সংখ্যা)') ?></td>
                <td><?= __('Tt') ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

        </table>

        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Financial Year Estimate') ?></h6>
            </div>
            <div class="panel-body"><?= $treePlant->has('financial_year_estimate') ?
                    $this->Html->link($treePlant->financial_year_estimate
                        ->name, ['controller' => 'FinancialYearEstimates',
                        'action' => 'view', $treePlant->financial_year_estimate
                            ->id]) : '' ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Created User') ?></h6>
            </div>
            <div class="panel-body"><?= $treePlant->has('created_user') ?
                    $this->Html->link($treePlant->created_user
                        ->name_en, ['controller' => 'Users',
                        'action' => 'view', $treePlant->created_user
                            ->id]) : '' ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Updated User') ?></h6>
            </div>
            <div class="panel-body"><?= $treePlant->has('updated_user') ?
                    $this->Html->link($treePlant->updated_user
                        ->name_en, ['controller' => 'Users',
                        'action' => 'view', $treePlant->updated_user
                            ->id]) : '' ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Id') ?></h6></div>
            <div class="panel-body"><?= $this->Number->format($treePlant->id) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Target Bonoz') ?></h6></div>
            <div class="panel-body"><?= $this->Number->format($treePlant->target_bonoz) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Target Vesoz') ?></h6></div>
            <div class="panel-body"><?= $this->Number->format($treePlant->target_vesoz) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Target Foloz') ?></h6></div>
            <div class="panel-body"><?= $this->Number->format($treePlant->target_foloz) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Target Total Plant') ?></h6></div>
            <div class="panel-body"><?= $this->Number->format($treePlant->target_total_plant) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Total Plant Cost') ?></h6></div>
            <div class="panel-body"><?= $this->Number->format($treePlant->total_plant_cost) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Progress Bonoz') ?></h6></div>
            <div class="panel-body"><?= $this->Number->format($treePlant->progress_bonoz) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Progress Vesoz') ?></h6></div>
            <div class="panel-body"><?= $this->Number->format($treePlant->progress_vesoz) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Progress Foloz') ?></h6></div>
            <div class="panel-body"><?= $this->Number->format($treePlant->progress_foloz) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Progress Total Plant') ?></h6></div>
            <div class="panel-body"><?= $this->Number->format($treePlant->progress_total_plant) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Road Length') ?></h6></div>
            <div class="panel-body"><?= $this->Number->format($treePlant->road_length) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Number Of Instution') ?></h6></div>
            <div class="panel-body"><?= $this->Number->format($treePlant->number_of_instution) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Total Cost') ?></h6></div>
            <div class="panel-body"><?= $this->Number->format($treePlant->total_cost) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Alive Bonoz') ?></h6></div>
            <div class="panel-body"><?= $this->Number->format($treePlant->alive_bonoz) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Alive Vesoz') ?></h6></div>
            <div class="panel-body"><?= $this->Number->format($treePlant->alive_vesoz) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Alive Foloz') ?></h6></div>
            <div class="panel-body"><?= $this->Number->format($treePlant->alive_foloz) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Alive Total Plant') ?></h6></div>
            <div class="panel-body"><?= $this->Number->format($treePlant->alive_total_plant) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Status') ?></h6></div>
            <?php
            if ($treePlant->status == 1) {
                ?>
                <div class="panel-body">Active</div>
                <?php
            } elseif ($treePlant->status == 0) {
                ?>
                <div class="panel-body">In-Active</div>
                <?php
            } else {
                ?>
                <div class="panel-body"><?php echo $treePlant->status; ?></div>
                <?php

            }
            ?>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Created Date') ?></h6></div>
            <div class="panel-body"><?= $this->System->display_date_time($treePlant->created_date)
                ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Updated Date') ?></h6></div>
            <div class="panel-body"><?= $this->System->display_date_time($treePlant->updated_date)
                ?>
            </div>
        </div>
    </div>
</div>