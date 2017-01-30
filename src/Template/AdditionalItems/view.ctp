<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Additional Items'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Additional Item') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Additional Items'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Additional Item'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['edit'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('Edit Additional Item'), ['action' => 'edit', $additionalItem->id]) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['delete'] == 1)
        {
            ?>
            <li><?=
                $this->Form->postLink(__('Delete Additional Item'), ['action' => 'delete', $additionalItem->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $additionalItem->id)]) ?>
            </li>
        <?php
        }
        ?>

        <li class="active"><?=
            $this->Html->link(__('Details Additional Item'), ['action' => 'view', $additionalItem->id
            ]) ?>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-6">

        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Item Display Code') ?></h6></div>
            <div class="panel-body"><?= h($additionalItem->item_display_code) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Unit') ?></h6></div>
            <div class="panel-body"><?= h($additionalItem->unit) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Created User') ?></h6>
            </div>
            <div class="panel-body"><?=
                $additionalItem->has('created_user') ?
                    $this->Html->link($additionalItem->created_user
                        ->name_en, ['controller' => 'Users',
                        'action' => 'view', $additionalItem->created_user
                            ->id]) : '' ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Updated User') ?></h6>
            </div>
            <div class="panel-body"><?=
                $additionalItem->has('updated_user') ?
                    $this->Html->link($additionalItem->updated_user
                        ->name_en, ['controller' => 'Users',
                        'action' => 'view', $additionalItem->updated_user
                            ->id]) : '' ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Id') ?></h6></div>
            <div class="panel-body"><?= $this->Number->format($additionalItem->id) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Rate') ?></h6></div>
            <div class="panel-body"><?= $this->Number->format($additionalItem->rate) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Created Date') ?></h6></div>
            <div class="panel-body"><?=
                $this->System->display_date_time($additionalItem->created_date)
                ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Updated Date') ?></h6></div>
            <div class="panel-body"><?=
                $this->System->display_date_time($additionalItem->updated_date)
                ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Status') ?></h6></div>
            <?php
            if ($additionalItem->status == 1)
            {
                ?>
                <div class="panel-body"><?= __('Active') ?></div>
            <?php
            }
            elseif ($additionalItem->status == 0)
            {
                ?>
                <div class="panel-body"><?= __('In-Active') ?></div>
            <?php
            }
            else
            {
                ?>
                <div class="panel-body"><?php echo $additionalItem->status; ?></div>
            <?php

            }
            ?>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Description') ?></h6></div>
            <div class="panel-body"><?= $this->Text->autoParagraph(h($additionalItem->description)); ?>
            </div>
        </div>
    </div>
</div>