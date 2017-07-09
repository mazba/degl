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
                    <thead class="cell-design">
                    <tr>
                        <th style="vertical-align: middle">Items</th>
                        <th style="vertical-align: middle">Unit</th>
                        <th style="vertical-align: middle">Description of Works (item)</th>
                        <th style="vertical-align: middle">Quantity as per Contract</th>
                        <th style="vertical-align: middle">Previous R/A Bill Quantity</th>
                        <th style="vertical-align: middle">Total Bill Quantity (Quantity Executed or Supplied since last Certificate</th>
                        <th style="vertical-align: middle">This Bill Quantity (Quantity Executed or Supplied upto date as per MB</th>
                        <th style="vertical-align: middle">Rate</th>
                        <th style="vertical-align: middle">Amount as per contract (Tk)</th>
                        <th style="vertical-align: middle">Previous R/A Bill Amount (Tk)</th>
                        <th style="vertical-align: middle">Total Bill/Upto date Bill/Amount (Tk)</th>
                        <th style="vertical-align: middle">This Bill (Since Last Certificate Amount (Tk.))</th>
                        <th style="vertical-align: middle">Remarks</th>
                    </tr>

                    </thead>
                    <tbody>
                    <?php $i =0; foreach($measurements as $key => $measurement_data):  ?>
                        <input type="hidden" name="details[<?=$i?>][scheme_item_id]" value="<?=$key?>">
                        <input type="hidden" name="details[<?=$i?>][serial_number]" value="<?=$i?>">
                        <input type="hidden" name="details[<?=$i?>][short_description]" value="<?= $measurement_data['description']?>">
                        <?php
                        $item_count=count($measurement_data['item']);
                        $current_index=0;
                        ?>
                        <?php $k= 0; foreach($measurement_data['item'] as $key => $measurement):  ?>
                            <?php
                            ++$k;
                            $current_index++;
                            if($k == 1){
                                $previous = '0';
                            }else{
                                $previous = $temp;
                            }
                            $temp = $measurement['quantity_of_work_done'];
                            if($item_count!=$current_index)
                                continue;
                            ?>
                            <tr>
                                <td><?= ++$i ?></td>
                                <td><?= $measurement_data['unit']?></td>
                                <td><?= substr($measurement_data['description'], 0, 60).'...';?></td>
                                <td><?= $measurement_data['quantity']; ?></td>
                                <td><?= $previous ?></td>
                                <td><?= $total = $measurement['quantity_of_work_done']?></td>
                                <td><?= $current = $total - $previous; ?></td>

                                <td><?= number_format( $measurement_data['rate'], 2, '.', '')?></td>
                                <td><?= number_format( $measurement_data['quantity']*$measurement_data['rate'], 2, '.', '') ?></td>
                                <td><?= number_format( $previous * $measurement_data['rate'], 2, '.', '')?></td>
                                <td><?= number_format( $total * $measurement_data['rate'], 2, '.', '')?></td>
                                <td><?= number_format( $current * $measurement_data['rate'], 2, '.', '')?></td>
                                <td></td>
                            </tr>

                        <?php endforeach; ?>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <style>
                    .table td:nth-child(3){
                        width: 250px !important;
                    }
                </style>
                <!--<style>
                    .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
                        border: 1px solid #000 !important;
                    }
                    .textd {

                    }
                    .rotate-cell{
                        height:200px;
                        vertical-align: bottom !important;
                        position: relative;
                        /*text-align: center !important;*/
                    }
                    .rotate{
                        transform: rotate(-90deg) !important;
                        -moz-transform:rotate(-90deg)  !important;;
                        -moz-transform-origin: top left;
                        -webkit-transform: rotate(-90deg)  !important;;
                        -webkit-transform-origin: top left;
                        -o-transform: rotate(-90deg)  !important;;
                        -o-transform-origin:  top left;
                        position: absolute;
                        width: 180px;
                        text-align: left !important;
                    }
                    .cell-design > tr {
                        border: 1px solid #000;
                    }
                </style>-->
            </div>

            <!--            <div class="col-sm-8"></div>-->
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
