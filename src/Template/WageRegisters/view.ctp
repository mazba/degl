<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Wage Registers'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Wage') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Wage Registers'), ['action' => 'index']) ?> </li>

        <?php
        if ($user_roles['edit'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Wage Register'), ['action' => 'edit', $employee->id]) ?></li>
        <?php
        }
        ?>
        <li class="active"><?=
            $this->Html->link(__('Details Wage Register'), ['action' => 'view', $employee->id
            ]) ?>
        </li>
    </ul>
</div>
<div class="row">
    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Details Wage of').' => '.$employee->name_en; ?>
        </h6></div>
    <table class="table table-bordered">
        <tr>
            <td><?= __('Billing Days') ?></td>
            <td><?= __('Daily Wage Rate') ?></td>
            <td><?= __('Total Wage') ?></td>
            <td><?= __('Bill No') ?></td>
            <td><?= __('Bill Pay date') ?></td>
            <td><?= __('Month(s)') ?></td>
        </tr>
        <?php
        if(sizeof($wage_details)>0)
        {
            foreach($wage_details as $details)
            {
                ?>
                <tr>
                    <td><?= $details['billing_days'];?></td>
                    <td><?= $details['daily_wage_rate'];?></td>
                    <td><?= $details['total_wage'];?></td>
                    <td><?= $details['bill_no'];?></td>
                    <td><?= $this->System->display_date($details['bill_pay_date']);?></td>
                    <td>
                        <?php

                        foreach($details['months'] as $month)
                        {

                            echo $month.'<br>';
                        }

                        ?>
                    </td>
                </tr>
                <?php
            }
        }
        else
        {
            ?>
                <tr class="alert-danger">
                    <td colspan="10"><?= __('No data found') ?></td>
                </tr>
            <?php
        }
        ?>
    </table>
</div>