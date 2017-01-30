<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Proposed Ra Bills'), ['action' => 'index']) ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Proposed Ra Bills'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('View'), ['action' => 'add']) ?></li>
    </ul>
</div>

<div class="panel panel-info">
    <div class="panel-heading">
        <h6 class="panel-title"><i class="icon-share"></i><?= __('Approve Bills') ?></h6>
    </div>
    <div class="panel-body">
        <?php
        use Cake\Core\Configure;

        ?>
        <div class="form-group input col-md-4 pull-right" id="measurement_book_wrp">
            <label class="col-sm-4 control-label text-right"><?= __('RA Bills No') ?></label>

            <div class="col-sm-6">
                <label class="form-control"><?php echo $ra_bill_no; ?></label>
            </div>
        </div>
        <?php if($proposedRaBill['bill_type']==1){?>
        <table class="table table-bordered show-grid">
            <thead>
            <tr style="background: #eea236; color: #fff; font-weight: bold;text-align: center;">

                <td><?= __('Unit') ?></td>
                <td style="width: 150px;"><?= __('Quantity Excess or Supplied Sin Last R-A Bill') ?></td>
                <td style="width: 150px;"><?= __('Quantity Executed or Supplied up to date per MB') ?></td>
                <td><?= __('Items') ?></td>
                <td><?= __('Rate in Taka') ?></td>
                <td><?= __('Payable') ?></td>

            </tr>
            </thead>
            <tbody>
            <?php
            $total = 0;
            $i = 0;
            foreach ($scheme_details as $scheme_detail) {
                $i++;
                ?>
                <tr>
                    <td><?php echo $scheme_detail['unit']; ?></td>
                    <td><?php echo(isset($last_ra_bills_items[$scheme_detail['id']]) ? $scheme_detail['quantity_executed'] - $last_ra_bills_items[$scheme_detail['id']] : $scheme_detail['quantity_executed']) ?></td>
                    <td><?php echo $scheme_detail['quantity_executed']; ?></td>
                    <td><span class="label label-info"> Item <?php echo $i; ?> </span>
                        <?php echo $scheme_detail['description']; ?></td>
                    <td><?php echo $scheme_detail['rate']; ?></td>
                    <td class="payable"><?php echo $scheme_detail['quantity_executed'] * $scheme_detail['rate']; ?></td>

                </tr>
                <?php
                $total += $scheme_detail['quantity_executed'] * $scheme_detail['rate'];
            }
            ?>
            <tr>
                <td colspan="5"><?= __('Total Work done to Date') ?></td>
                <td id="show_total"><?php echo $total; ?></td>
            </tr>
            </tbody>
        </table>
        <?php }else{?>
            <table class="table table-bordered show-grid">
                <thead>
                <tr>
                    <td>Item of work</td>
                    <td colspan="3">As Estimated</td>
                    <td colspan="3">As Excepted</td>
                    <td colspan="4">Difference</td>
                </tr>
                <tr style="background: #eea236; color: #fff; font-weight: bold;text-align: center;">
                    <td><?= __('Items') ?></td>
                    <td>Quantity</td>
                    <td>Rate</td>
                    <td>Amount</td>

                    <td>Quantity</td>
                    <td>Rate</td>
                    <td>Amount</td>


                    <td>Quantity</td>
                    <td>Rate</td>
                    <td>Amount</td>

                    <td>explaning deference</td>

                </tr>
                </thead>
                <tbody>
                <?php
                $total = 0;
                $i =0;
                foreach($scheme_details as $scheme_detail)
                {
                    $i++;
                    ?>
                    <tr>
                        <td>                <b><u> Item No. <?php echo $i; ?>:</u></b> &nbsp;<?php echo $scheme_detail['description']; ?>
                        </td>
                        <td><?php echo $scheme_detail['quantity']; ?></td>
                        <td><?php echo $scheme_detail['rate']; ?></td>
                        <td><?php echo number_format( $scheme_detail['quantity']*$scheme_detail['rate'], 2, '.', ''); ?></td>

                        <td><?php echo $scheme_detail['quantity_executed']; ?></td>
                        <td><?php echo $scheme_detail['rate']; ?></td>
                        <td class="payable"><?php echo number_format( $scheme_detail['quantity_executed']*$scheme_detail['rate'], 2, '.', ''); ?></td>

                        <td><?php echo $scheme_detail['quantity']-$scheme_detail['quantity_executed']; ?></td>
                        <td><?php echo $scheme_detail['rate']-$scheme_detail['rate']; ?></td>
                        <td><?php echo number_format( ($scheme_detail['quantity']*$scheme_detail['rate'])-( $scheme_detail['quantity_executed']*$scheme_detail['rate']), 2, '.', ''); ?></td>

                        <td ></td>
                    </tr>
                    <?php
                    $total += $scheme_detail['quantity_executed']*$scheme_detail['rate'];
                }
                ?>
                <tr>
                    <td colspan="6"><?= __('Total Work done to Date') ?></td><td id="show_total"><?php echo $total; ?></td>
                    <td>&nbsp;</td>
                </tr>
                </tbody>
            </table>
        <?php }?>

        <div class="col-md-8">

        </div>


        <div class="col-md-4">
            <table class="table">
                <tr>
                    <td> <?= __('Above or Less') ?></td>
                    <td>  <?= $proposedRaBill['above_or_less']?> </td>
                </tr>

                <tr>
                    <td> <?= __('Percentage') ?></td>
                    <td>    <?= $proposedRaBill['percentage']?>% </td>
                </tr>

                <tr>
                    <td> <?= __('Percentage Value') ?></td>
                    <td>   <?php echo $Percentage_Value=($total*$proposedRaBill['percentage'])/100?> </td>
                </tr>


                <tr>
                    <td><?= __('So Far Payable')  ?></td>
                    <td>    <?php if($proposedRaBill['above_or_less']=='ABOVE'){
                            echo $Bill_Amoun =$total+$Percentage_Value;
                        }else{
                            echo $Bill_Amoun =$total-$Percentage_Value;
                        }?></td>
                </tr>

                <tr>
                    <td><?= __('Upto date Approved') ?></td>
                    <td>   <?=$up_to_date_approved?$up_to_date_approved:0?> </td>
                </tr>

                <tr>
                    <td><?= __('Bill Amount') ?></td>
                    <td>   <?=$Bill_Amoun -$up_to_date_approved?> </td>
                </tr>
            </table>



            <!--    <div class="form-group input" id="up_to_date_approved_wrp" style="display: none;">-->
            <!--        <label class="col-sm-4 control-label text-right">-->
            <? //= __('Upto date Approved') ?><!--</label>-->
            <!--        <div class="col-sm-5 pull-right">-->
            <!--            <label class="form-control" id="up_to_date_approved">-->
            <?php //echo $up_to_date_approved; ?><!--</label>-->
            <!--        </div>-->
            <!--    </div>-->

        </div>


    </div>
</div>
