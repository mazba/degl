<?php
use Cake\Core\Configure;
//pr($others_info['scheme_contractors'][0]['contractor']['contractor_title']);die;
?>
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
    <div class="col-sm-12">
        <button style="float: right;margin-top: 5px" onclick="print_rpt()">Print</button>
    </div>
    <div id="PrintArea">
        <div class="panel-body" style="padding: 0">
            <div class="col-sm-12">
                <div class="col-sm-12">
                    <h3 align="center"><?= __('LOCAL GOVERNMENT ENGINEERING DEPARTMENT') ?></h3>
                    <h4 align="center"><?= __('CONTRACTOR\'S/SUPPLIERS\'S RUNNING/FINAL ACCOUNTS BILL FORM ') ?></h4>
                </div>
                <table style="width:100%; margin-left: 15px">
                    <tr>
                        <td width="50%">
                            <p><b>District: </b><?= $others_info['district']['name_en']?$others_info['district']['name_en']:'' ?></p>
                            <p><b>Name Of Contractor: </b><?= $others_info['scheme_contractors'][0]['contractor']['contractor_title']?$others_info['scheme_contractors'][0]['contractor']['contractor_title']:'' ?></p>
                            <p><b>Name Of Works:</b> <?= $others_info['name_en']?$others_info['name_en']:''?></p>
                        </td>
                        <td width="45%" style="margin-left: 20px">
                            <p><b>Upazila:</b> <?= $others_info['upazila']['name_en']?$others_info['upazila']['name_en']:'' ?></p>
                            <p><b>Contract Package/Slice No:</b> <?= $others_info['package']['name_en']?$others_info['package']['name_en']:'' ?></p>
                            <p><b><?= __('RA Bills No: ') ?> </b><?php echo $ra_bill_no; ?>&nbsp;<span><?= $bill_type?$bill_type:''?></span></p>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-12">
                <table class="table table-bordered show-grid">
                    <thead>
                    <tr style="background: #eea236; color: #fff; font-weight: bold;text-align: center;">
                        <td><?= 'Items' ?></td>
                        <td><?= __('Quantity as per Contract') ?></td>
                        <td><?= __('Previous R/A Bill Quantity') ?></td>
                        <td><?= __('Total Bill Quantity (Quantity Executed or Supplied since last Certificate)') ?></td>
                        <td><?= __('This Bill Quantity (Quantity Executed or Supplied upto date as per MB)') ?></td>
                        <td><?= 'Unit' ?></td>
                        <td><?= __('Description of Works(item)') ?></td>
                        <td><?= 'Rate' ?></td>
                        <td><?= __('Amount as per contract (Tk)') ?></td>
                        <td><?= __('Previous R/A Bill Amount (Tk)') ?></td>
                        <td><?= __('Total Bill/Upto date Bill/Amount (Tk)') ?></td>
                        <td><?= __('This Bill (Since Last Certificate Amount (Tk.))') ?></td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i =0; foreach($measurements as $key => $measurement_data): $i++; ?>
                        <input type="hidden" name="details[<?=$i?>][scheme_item_id]" value="<?=$key?>">
                        <input type="hidden" name="details[<?=$i?>][serial_number]" value="<?=$i?>">
                        <input type="hidden" name="details[<?=$i?>][short_description]" value="<?= $measurement_data['description']?>">
                        <?php $k= 0; foreach($measurement_data['item'] as $key => $measurement):  ?>
                            <tr>
                                <td><?= ++$k ?></td>
                                <td><?= $measurement_data['quantity']; ?></td>
                                <td><?php
                                    if($k == 1){
                                        echo $previous = '0';
                                    }else{
                                        echo $previous = $temp;
                                    }
                                    ?></td>
                                <td><?= $total = $measurement['quantity_of_work_done']?></td>
                                <td><?= $current = $total - $previous; ?></td>
                                <td><?= $measurement_data['unit']?></td>
                                <td><?= substr($measurement_data['description'], 0, 80).'...';?></td>
                                <td><?= number_format( $measurement_data['rate'], 2, '.', '')?></td>
                                <td><?= number_format( $measurement_data['quantity']*$measurement_data['rate'], 2, '.', '') ?></td>
                                <td><?= number_format( $previous * $measurement_data['rate'], 2, '.', '')?></td>
                                <td><?= number_format( $total * $measurement_data['rate'], 2, '.', '')?></td>
                                <td><?= number_format( $current * $measurement_data['rate'], 2, '.', '')?></td>
                            </tr>
                            <?php $temp = $measurement['quantity_of_work_done']; ?>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!--            <div class="col-sm-8"></div>-->
            <div class="col-sm-12">
                <table class="table" style="width: 33.33333333%; float: right;">
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
            </div>
        </div>
    </div>
</div>
<script>
    function print_rpt() {
        URL = "<?php echo $this->request->webroot; ?>page/Print_a4_Eng.php?selLayer=PrintArea";
        day = new Date();
        id = day.getTime();
        eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=yes,scrollbars=yes ,location=0,statusbar=0 ,menubar=yes,resizable=1,width=880,height=600,left = 20,top = 50');");
    }
</script>
