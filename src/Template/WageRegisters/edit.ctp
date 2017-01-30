<?php
use Cake\Core\Configure;

/*echo "<pre>";
print_r($employee);
echo "</pre>";*/
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('New Wage') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Wage Registers'), ['action' => 'index']) ?></li>
        <li class="active"><?=
            $this->Html->link(__('New Wage Register'), ['action' => 'edit', $employee->id
            ]) ?>
        </li>
        <?php
        if ($user_roles['view'] == 1)
        {
            ?>
            <li><?=
                $this->Html->link(__('Details Wage Register'), ['action' => 'view', $employee->id])
                ?>
            </li>
        <?php
        }
        ?>


    </ul>
</div>

<?= $this->Form->create(null, ['controller'=>'wage_registers','action'=>'edit/'.$employee->id,'class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('New Wage').'  =>  '.$employee->name_en; ?>
        </h6></div>
    <div class="panel-body col-sm-6">
        <?php
        echo $this->Form->input('billing_days',['required'=>'required']);
        echo $this->Form->input('daily_wage_rate',['required'=>'required']);
        echo $this->Form->input('bill_no',['required'=>'required']);
        echo $this->Form->input('bill_pay_date',['type'=>'text','value'=>'','class'=>'form-control hasdatepicker','required'=>'required']);
        ?>
    </div>
    <div class="panel-body col-sm-6">
        <div class="row show-grid">
            <div class="col-xs-4">
                <label class="control-label pull-right"><?= __('Select Months');?><span style="color:#FF0000">*</span></label>
            </div>
            <div class="col-sm-4 col-xs-8">

                    <?php
                    $current_year=date("Y",time());
                    $current_month=date("n",time());
                    //echo $current_year.' '.$current_month;
                    for($i=7;$i>=0;$i--)
                    {
                        $year=$current_year;
                        if($current_month>$i)
                        {
                            $month=$current_month-$i;
                        }
                        else
                        {
                            $year--;
                            $month=12+$current_month-$i;
                        }
                        ?>
                        <input type="checkbox" name="months[]" value="<?php echo $year.'_'.$month;?>"> <?php echo date("M/y",strtotime($year.'-'.$month.'-01'));?><br>
                    <?php
                    }
                    ?>

            </div>
        </div>
    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

