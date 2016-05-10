<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Permanent Salary'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Salary') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Permanent Salary'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['edit'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Salary'), ['action' => 'edit', $employee->id]) ?></li>
        <?php
        }
        ?>
        <li class="active"><?=
            $this->Html->link(__('Details Salary'), ['action' => 'view', $employee->id
            ]) ?>
        </li>
    </ul>
</div>
<div class="row">
    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Details Salary of').' '.$employee->name_en; ?>
        </h6></div>
    <table class="table table-bordered">
        <tr>
            <td><?= __('Total Salary') ?></td>
            <td><?= __('Total cut') ?></td>
            <td><?= __('Net Salary') ?></td>
            <td><?= __('Month') ?></td>
            <td><?= __('Bill Pay date') ?></td>
        </tr>
        <?php
        if(sizeof($salary_details)>0)
        {
            foreach($salary_details as $details)
            {
                ?>
                <tr>
                    <td><?= $details['total_salary'];?></td>
                    <td><?= $details['total_cut'];?></td>
                    <td><?= $details['net_salary'];?></td>
                    <td><?= date("M/y",strtotime($details['year'].'-'.$details['month'].'-01'))?></td>
                    <td><?= $this->System->display_date($details['bill_pay_date']);?></td>
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