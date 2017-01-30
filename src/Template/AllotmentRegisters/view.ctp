<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Allotment Registers'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Allotment Register') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Allotment Registers'), ['action' => 'index']) ?> </li>
        <li class="active"><?=
            $this->Html->link(__('Details Allotment Register'), ['action' => 'view', $allotmentRegister->id
            ]) ?>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-6 col-md-offset-2">

        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Office') ?></h6>
            </div>
            <div class="panel-body"><?=
                $allotmentRegister->has('office') ?
                    $this->Html->link($allotmentRegister->office
                        ->name_en, ['controller' => 'Offices',
                        'action' => 'view', $allotmentRegister->office
                            ->id]) : '' ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Dr Cr') ?></h6></div>
            <div class="panel-body"><?= h($allotmentRegister->dr_cr) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Project') ?></h6>
            </div>
            <div class="panel-body"><?=
                $allotmentRegister->has('project') ?
                    $this->Html->link($allotmentRegister->project
                        ->name_en, ['controller' => 'Projects',
                        'action' => 'view', $allotmentRegister->project
                            ->id]) : '' ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Scheme') ?></h6>
            </div>
            <div class="panel-body"><?=
                $allotmentRegister->has('scheme') ?
                    $this->Html->link($allotmentRegister->scheme
                        ->name_en, ['controller' => 'Schemes',
                        'action' => 'view', $allotmentRegister->scheme
                            ->id]) : '' ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Particulars') ?></h6></div>
            <div class="panel-body"><?= h($allotmentRegister->particulars) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Id') ?></h6></div>
            <div class="panel-body"><?= $this->Number->format($allotmentRegister->id) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Memo No') ?></h6></div>
            <div class="panel-body"><?= $this->Number->format($allotmentRegister->memo_no) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Purto Bill Id') ?></h6></div>
            <div class="panel-body"><?= $this->Number->format($allotmentRegister->purto_bill_id) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Allotment Date') ?></h6></div>
            <div class="panel-body"><?=
                $this->System->display_date($allotmentRegister->allotment_date)
                ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Allotment Amount') ?></h6></div>
            <div class="panel-body"><?= $this->Number->format($allotmentRegister->allotment_amount) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Remarks') ?></h6></div>
            <div class="panel-body"><?= $this->Text->autoParagraph(h($allotmentRegister->remarks)); ?>
            </div>
        </div>
    </div>
</div>