<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>">Dashboard</a></li>
        <li><?= $this->Html->link(__('Processed Ra Bills'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Processed Ra Bill') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Processed Ra Bills'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Processed Ra Bill'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['edit'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('Edit Processed Ra Bill'), ['action' => 'edit', $processedRaBill->id]) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['delete'] == 1)
        {
            ?>
            <li><?= $this->Form->postLink(__('Delete Processed Ra Bill'), ['action' => 'delete', $processedRaBill->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $processedRaBill->id)]) ?>
            </li>
        <?php
        }
        ?>

        <li class="active"><?= $this->Html->link(__('Details Processed Ra Bill'), ['action' => 'view', $processedRaBill->id
            ]) ?>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-6">
        
                                                <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('Scheme') ?></h6>
                        </div>
                        <div class="panel-body"><?= $processedRaBill->has('scheme') ?
                            $this->Html->link($processedRaBill->scheme
                            ->name_en, ['controller' => 'Schemes',
                            'action' => 'view', $processedRaBill->scheme
                            ->id]) : '' ?>
                        </div>
                    </div>
                                                                        <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Id') ?></h6></div>
                                            <div class="panel-body"><?= $this->Number->format($processedRaBill->id) ?></div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Security') ?></h6></div>
                                            <div class="panel-body"><?= $this->Number->format($processedRaBill->security) ?></div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Income Tex') ?></h6></div>
                                            <div class="panel-body"><?= $this->Number->format($processedRaBill->income_tex) ?></div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Vat') ?></h6></div>
                                            <div class="panel-body"><?= $this->Number->format($processedRaBill->vat) ?></div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Hire Charge') ?></h6></div>
                                            <div class="panel-body"><?= $this->Number->format($processedRaBill->hire_charge) ?></div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Lab Fee') ?></h6></div>
                                            <div class="panel-body"><?= $this->Number->format($processedRaBill->lab_fee) ?></div>
                                    </div>
                            <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('Net Payable') ?></h6></div>
                                            <div class="panel-body"><?= $this->Number->format($processedRaBill->net_payable) ?></div>
                                    </div>
                                </div>
</div>