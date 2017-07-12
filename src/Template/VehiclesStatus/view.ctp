<?php
use Cake\Core\Configure;
// echo "<pre>";print_r($vehiclesStatus['vehicles_status']);die();
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Assign Vehicles'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('Vehicle Status') ?></li>

    </ul>
</div>



<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Vehicle status') ?>
        </h6></div>
    <div class="panel-body col-sm-12">
        <h3>Vehical Details</h3>
        <table class="table table-bordered">
            <tr>
                <td><b>Type:</b></td>
                <td><?= $vehiclesStatus['type']?></td>

                <td><b>Title:</b></td>
                <td><?= $vehiclesStatus['title']?></td>
            </tr>

            <tr>
                <td><b>Serial no:</b></td>
                <td><?= $vehiclesStatus['serial_no']?></td>

                <td><b>Registration no:</b></td>
                <td><?= $vehiclesStatus['registration_no']?></td>
            </tr>
        </table>
        <hr/>
        <div class="row">
            <div class="col-sm-12">
                <h3>History</h3>
                <div class="col-sm-12">
                    <button style="float: right" onclick="print_rpt()">Print</button>
                </div>
                <div id="PrintArea">
                    <h2 class="text-center"><?= __('LOCAL GOVERNMENT ENGINEERING DEPARTMENT') ?></h2>
                    <table class="table table-bordered">
                        <tr>
                            <td>Sl No</td>
                            <td>Equipment Or Vehicle Description</td>
                            <td>Scheme</td>
                            <td>Driver</td>
                            <td>Location</td>
                            <td>Assign Date</td>
                            <td>Return Date</td>
                            <td>Working Days</td>
                            <td>Total Cost</td>
                            <td>Remark</td>
                            <td>Status</td>
                        </tr>
                        <?php $i=1;?>
                        <?php foreach($vehiclesStatus['vehicles_status'] as $row):
                            if($row['end_date'] >= $row['assign_date']){
                                $diff = $row['end_date'] - $row['assign_date'];
                                $days = round(abs($diff)/86400);
                            }
                            if($row['end_date'] < $row['assign_date']){
                                $days = "Wrong Date";
                            }
                            if($row['end_date'] == ""){
                                $days = "Running";
                            }
                            ?>
                            <tr>
                                <td><?= $i;?></td>
                                <td><?= $vehiclesStatus['title'] ?></td>
                                <td><?= $row['scheme']['name_bn'];?></td>
                                <td><?= $row['employee']['name_bn'];?></td>
                                <td><?= $row['vehicle_location'];?></td>
                                <td><?= date('d/m/Y',$row['assign_date']);?></td>
                                <td><?=$row['end_date']?date('d/m/Y', $row['end_date']):'';?></td>
                                <td><?= $days ?></td>
                                <td><?php if($days>0){
                                        echo $income = $days * $vehiclesStatus['daily_cost_ratio'];
                                    } ?>
                                </td>
                                <td><?= $row['remark'];?></td>
                                <td><?= $row['status']?'On Hire':'Closed';?></td>

                            </tr>
                            <?php $i++;?>
                        <?php endforeach ?>
                    </table>
                </div>
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
