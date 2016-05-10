<?php
    use Cake\Core\Configure;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('New Salary') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Permanent Salary'), ['action' => 'index']) ?></li>
        <li class="active"><?=
            $this->Html->link(__('New Salary'), ['action' => 'edit', $employee->id
            ]) ?>
        </li>
        <?php
        if ($user_roles['view'] == 1)
        {
            ?>
            <li><?=
                $this->Html->link(__('Details Salary'), ['action' => 'view', $employee->id])
                ?>
            </li>
        <?php
        }
        ?>
    </ul>
</div>
<?= $this->Form->create(null, ['controller'=>'salary_revenues','action'=>'edit/'.$employee->id,'class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="row panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('New Wage For').' '.$employee->name_en; ?>
        </h6></div>
    <div class="col-sm-4">
        <?php
            echo $this->Form->input('bill_pay_date',['type'=>'text','value'=>'','class'=>'form-control hasdatepicker','required'=>'required']);
        ?>
    </div>
    <div class="col-sm-4">
        <?php
        $current_year=date("Y",time());
        $current_month=date("n",time());
        //echo $current_year.' '.$current_month;
        $options=array();
        for($i=0;$i<=7;$i++)
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
            $options[$year.'_'.$month]=date("M/y",strtotime($year.'-'.$month.'-01'));
        }
        echo $this->Form->input('month', ['options' => $options]);

        ?>
    </div>
    <div class="col-sm-4">
        <?php
        echo $this->Form->input('remarks');
        ?>
    </div>
    <div class="panel-body col-sm-12">
        <table class="table table-bordered">
            <tr>
                <td colspan="2" class="text-center">
                    <?= __('Salary and Allowance') ?>
                </td>
                <td>
                    <?= __('Cut and Collect') ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $this->Form->input('basic',['class'=>'salary allowance text-right form-control']); ?></td>
                <td><?php echo $this->Form->input('house_rent',['class'=>'salary allowance text-right form-control']); ?></td>
                <td><?php echo $this->Form->input('welfare_cut',['class'=>'salary cut text-right form-control']); ?></td>
            </tr>
            <tr>
                <td><?php echo $this->Form->input('medical',['class'=>'salary allowance text-right form-control']); ?></td>
                <td><?php echo $this->Form->input('transport',['class'=>'salary allowance text-right form-control']); ?></td>
                <td><?php echo $this->Form->input('other_cut',['class'=>'salary cut text-right form-control']); ?></td>
            </tr>
            <tr>
                <td><?php echo $this->Form->input('education_aid',['class'=>'salary allowance text-right form-control']); ?></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><?php echo $this->Form->input('festival',['class'=>'salary allowance text-right form-control']); ?></td>
                <td><?php echo $this->Form->input('tiffin',['class'=>'salary allowance text-right form-control']); ?></td>
                <td></td>
            </tr>
            <tr>
                <td><?php echo $this->Form->input('recreation',['class'=>'salary allowance text-right form-control']); ?></td>
                <td><?php echo $this->Form->input('laundry',['class'=>'salary allowance text-right form-control']); ?></td>
                <td></td>
            </tr>
            <tr>
                <td><?php echo $this->Form->input('overtime',['class'=>'salary allowance text-right form-control']); ?></td>
                <td><?php echo $this->Form->input('domestic_aid',['class'=>'salary allowance text-right form-control']); ?></td>
                <td></td>
            </tr>
            <tr>
                <td><?php echo $this->Form->input('travel',['class'=>'salary allowance text-right form-control']); ?></td>
                <td><?php echo $this->Form->input('pahari',['class'=>'salary allowance text-right form-control']); ?></td>
                <td></td>
            </tr>
            <tr>
                <td><?php echo $this->Form->input('preshon',['class'=>'salary allowance text-right form-control']); ?></td>
                <td><?php echo $this->Form->input('appayon',['class'=>'salary allowance text-right form-control']); ?></td>
                <td></td>
            </tr>

            <tr>
                <td colspan="2" id="total_salary" class="text-right"></td>
                <td id="total_cut" class="text-right"></td>
            </tr>
            <tr>
                <td colspan="3" id="net_salary" class="text-right"></td>
            </tr>
        </table>
    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>
<script type="text/javascript">
    jQuery(document).ready(function()
    {
        $(document).on("change", ".salary", function(event)
        {
            var total_cut=0;
            var total_salary=0;
            $(".salary").each(function( index )
            {
                var val=parseFloat($(this).val());
                console.log('here'+val+$(this).val());
                if(val)
                {
                    if($(this).hasClass('allowance'))
                    {
                        total_salary+=val;
                    }
                    else if($(this).hasClass('cut'))
                    {
                        total_cut+=val;
                    }
                }
            });
            var net_salary=total_salary-total_cut;
            $("#total_salary").html('Total Salary:'+total_salary);
            $("#total_cut").html('Total Cut:'+total_cut);
            $("#net_salary").html('Net Salary:'+net_salary);

        });

    });
</script>

