<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Purto Bills'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Purto Bill') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Purto Bills'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1) {
            ?>
            <li><?= $this->Html->link(__('New Purto Bill'), ['action' => 'add']) ?></li>
            <?php
        }
        ?>
        <?php
        if ($user_roles['edit'] == 1) {
            ?>
            <li><?= $this->Html->link(__('Edit Purto Bill'), ['action' => 'edit', $purtoBill->id]) ?></li>
            <?php
        }
        ?>
        <?php
        if ($user_roles['delete'] == 1) {
            ?>
            <li><?= $this->Form->postLink(__('Delete Purto Bill'), ['action' => 'delete', $purtoBill->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $purtoBill->id)]) ?>
            </li>
            <?php
        }
        ?>

        <li class="active"><?= $this->Html->link(__('Details Purto Bill'), ['action' => 'view', $purtoBill->id
            ]) ?>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-sm-12">
        <table class="table top-table">
            <tr>
                <td class="text-center" colspan="3"><h4><?= $purtoBill->office->name_bn ?></h4></td>
            </tr>
            <tr>
                <td width="15%"><?= __('Financial Year : ') ?></td>
                <td><?= $purtoBill->financial_year_estimate->name ?></td>
                <td width="20%"><?= __('Date : ') . $this->System->display_date_time($purtoBill->created_date) ?></td>
            </tr>
            <tr>
                <td><?= __('Contractor Name : ') ?> </td>
                <td colspan="2"><?= $purtoBill->contractor->contractor_title ?></td>
            </tr>
            <tr>
                <td><?= __('Project : ') ?> </td>
                <td colspan="2"><?= $purtoBill->project->name_bn ?></td>
            </tr>
            <tr>
                <td><?= __('Scheme : ') ?> </td>
                <td colspan="2"><?= $purtoBill->scheme->name_bn ?></td>
            </tr>
            <tr>
                <td><?= __('Bill Types : ') ?> </td>
                <td colspan="2"><?= $purtoBill->bill_type ?></td>
            </tr>
            <tr>
                <td><?= __('Status : ') ?> </td>
                <td colspan="2"><?php
                    if ($purtoBill->status == 1) {
                        ?>
                        Active
                        <?php
                    } elseif ($purtoBill->status == 0) {
                        ?>
                        In-Active
                        <?php
                    } else {
                        ?>
                        <?php echo $purtoBill->status; ?>
                        <?php

                    }
                    ?></td>
            </tr>
        </table>
        <div class="col-sm-offset-3 col-sm-6">
            <table class="table table-bordered" style="margin:20px 0">
                <tr>
                    <th class="text-center" colspan="4"><?= $purtoBill->bill_type ?></th>
                </tr>
                <tr>
                    <td><?= __('Gross Bill') ?></td>
                    <td><?= $this->Number->format($purtoBill->gross_bill) ?></td>
                </tr>
                <tr>
                    <td><?= __('Security') ?></td>
                    <td><?= $this->Number->format($purtoBill->security) ?></td>
                </tr>

                <tr>
                    <td><?= __('Vat') ?></td>
                    <td><?= $this->Number->format($purtoBill->vat) ?></td>
                </tr>
                <tr>
                    <td><?= __('Income Taxes') ?></td>
                    <td><?= $this->Number->format($purtoBill->income_taxes) ?></td>
                </tr>
                <tr>
                    <td><?= __('Roller Charge') ?></td>
                    <td><?= $this->Number->format($purtoBill->roller_charge) ?></td>
                </tr>
                <tr>
                    <td><?= __('Lab Fee') ?></td>
                    <td><?= $this->Number->format($purtoBill->lab_fee) ?></td>
                </tr>
                <tr>
                    <td><?= __('Fine') ?></td>
                    <td><?= $this->Number->format($purtoBill->fine) ?></td>
                </tr>
                <tr>
                    <td><?= __('Net Taka') ?></td>
                    <td><?= $this->Number->format($purtoBill->net_taka) ?></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="col-sm-12">
        <a href="<?= $this->request->webroot; ?>purto_bills/invoice_form/<?= $purtoBill->id ?>"
           class="btn btn-primary"><?= __('Chalan Form') ?></a>
    </div>
</div>


<style>
    .table.top-table {
        border-bottom: 0px !important;
    }

    .table.top-table th, .table.top-table td {
        border: 0px !important;
    }

    .fixed-table-container {
        border: 0px !important;
    }
</style>