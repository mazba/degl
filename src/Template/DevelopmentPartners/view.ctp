<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Development Partners'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Development Partner') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Development Partners'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Development Partner'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['edit'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('Edit Development Partner'), ['action' => 'edit', $developmentPartner->id]) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['delete'] == 1)
        {
            ?>
            <li><?=
                $this->Form->postLink(__('Delete Development Partner'), ['action' => 'delete', $developmentPartner->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $developmentPartner->id)]) ?>
            </li>
        <?php
        }
        ?>

        <li class="active"><?=
            $this->Html->link(__('Details Development Partner'), ['action' => 'view', $developmentPartner->id
            ]) ?>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-6">

        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Short Code') ?></h6></div>
            <div class="panel-body"><?= h($developmentPartner->short_code) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Name En') ?></h6></div>
            <div class="panel-body"><?= h($developmentPartner->name_en) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Name Bn') ?></h6></div>
            <div class="panel-body"><?= h($developmentPartner->name_bn) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Created User') ?></h6>
            </div>
            <div class="panel-body"><?=
                $developmentPartner->has('created_user') ?
                    $this->Html->link($developmentPartner->created_user
                        ->name_en, ['controller' => 'Users',
                        'action' => 'view', $developmentPartner->created_user
                            ->id]) : '' ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Updated User') ?></h6>
            </div>
            <div class="panel-body"><?=
                $developmentPartner->has('updated_user') ?
                    $this->Html->link($developmentPartner->updated_user
                        ->name_en, ['controller' => 'Users',
                        'action' => 'view', $developmentPartner->updated_user
                            ->id]) : '' ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Id') ?></h6></div>
            <div class="panel-body"><?= $this->Number->format($developmentPartner->id) ?></div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Created Date') ?></h6></div>
            <div class="panel-body"><?=
                $this->System->display_date_time($developmentPartner->created_date)
                ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Updated Date') ?></h6></div>
            <div class="panel-body"><?=
                $this->System->display_date_time($developmentPartner->updated_date)
                ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Ordering') ?></h6></div>
            <div class="panel-body"><?= $this->Number->format($developmentPartner->ordering) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Status') ?></h6></div>
            <?php
            if ($developmentPartner->status == 1)
            {
                ?>
                <div class="panel-body"><?= __('Active') ?></div>
            <?php
            }
            elseif ($developmentPartner->status == 0)
            {
                ?>
                <div class="panel-body"><?= __('In-Active') ?></div>
            <?php
            }
            else
            {
                ?>
                <div class="panel-body"><?php echo $developmentPartner->status; ?></div>
            <?php

            }
            ?>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Address') ?></h6></div>
            <div class="panel-body"><?= $this->Text->autoParagraph(h($developmentPartner->address)); ?>
            </div>
        </div>
    </div>
</div>