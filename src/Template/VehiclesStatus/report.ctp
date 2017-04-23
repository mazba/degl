<?php
use Cake\Core\Configure;
//echo "<pre>";print_r($vehicleDetails);die();
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('যানবাহন ব্যবস্থাপনা'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('রিপোর্ট') ?></li>

    </ul>
</div>

<div class="row">
    <div class="col-sm-12">
        <button style="float: right" onclick="print_rpt()">Print</button>
    </div>
    <div id="PrintArea">
        <h2 class="text-center"><?= __('LOCAL GOVERNMENT ENGINEERING DEPARTMENT') ?></h2>
        <p class="text-center">(MECHANICAL CELL)</p>
        <h4 class="text-center">O & M CARD</h4>
        <div class="col-sm-3">
            <img
                src="<?= $this->request->webroot . 'img/' . ($vehicle['image'] ? $vehicle['image'] : 'NoImage.jpg'); ?>"
                style="width: 100%; border: 1px solid #aaa; box-shadow: 0 0 1px #aaa;">
        </div>
        <div class="col-sm-9">
            <table class="table">
                <tr>
                    <td class="col-sm-3"><?= __('NAME OF EQUIPMENT') ?></td>
                    <td class="col-sm-3">: <?php if ($vehicle->type == "vehicles") {
                            echo $vehicle->title;
                        } else {
                            echo $vehicle->equipment_id_no;
                        } ?></td>
                    <td class="col-sm-3"><?= __('DATE OF PROCUREMENT') ?></td>
                    <td class="col-sm-3">: <?= $this->System->display_date($vehicle->procurement_date) ?></td>
                </tr>
                <tr>
                    <td class="col-sm-3"><?= __('DESIGNATION OF USER') ?></td>
                    <td class="col-sm-3">:</td>
                    <td class="col-sm-3"><?= __('MAKE AND MODEL') ?></td>
                    <td class="col-sm-3">: <?= $vehicle->make_and_model ?> </td>
                </tr>
                <tr>
                    <td class="col-sm-3"><?= __('REGISTRATION NO') ?></td>
                    <td class="col-sm-3">: <?= $vehicle->registration_no ?></td>
                    <td class="col-sm-3"><?= __('COUNTRY OF ORIGIN') ?></td>
                    <td class="col-sm-3">: <?= $vehicle->country_of_origin ?></td>
                </tr>
                <tr>
                    <td class="col-sm-3"><?= __('PREFIX NO') ?></td>
                    <td class="col-sm-3">: <?= $vehicle->prefix_no ?></td>
                    <td class="col-sm-3"><?= __('FUEL TANK CAPACITY') ?></td>
                    <td class="col-sm-3">: <?= $vehicle->fuel_tank_capacity ?></td>
                </tr>
                <tr>
                    <td class="col-sm-3"><?= __('ENGINE NO') ?></td>
                    <td class="col-sm-3">: <?= $vehicle->engine_no ?></td>
                    <td class="col-sm-3"><?= __('OIL SUMP CAPACITY') ?></td>
                    <td class="col-sm-3">: <?= $vehicle->oil_sump_capacity ?></td>
                </tr>
                <tr>
                    <td class="col-sm-3"><?= __('CHASSIS NO') ?></td>
                    <td class="col-sm-3">: <?= $vehicle->chasis_no ?></td>
                    <td class="col-sm-3"><?= __('NAME OF PROJECT') ?></td>
                    <td class="col-sm-3">: <?= "" ?></td>
                </tr>

                <tr>
                    <td class="col-sm-3"><?= __('PLACE OF USE') ?></td>
                    <td class="col-sm-3">: <?= "" ?></td>
                </tr>

            </table>
        </div>

        <div class="col-sm-12" style="margin:40px 0">
            <table class="table table-bordered text-center">
                <tr>
                    <th class="text-center" ><?= __('SL NO') ?></th>
                    <th class="text-center"><?= __('DRIVER NAME') ?></th>
                    <th class="text-center"><?= __('Scheme Name') ?></th>
                    <th class="text-center"><?= __('assign_date') ?></th>
                    <th class="text-center"><?= __('end_date') ?></th>
                    <th class="text-center"><?= __('Used Days') ?></th>
                    <th class="text-center"><?= __('Daily Cost') ?></th>
                    <th class="text-center"><?= __('Revenue Income') ?></th>
                </tr>
                <?php  $i = 1;
                foreach($vehicleDetails as $vehicleDetail):
                    if($vehicleDetail['end_date'] >= $vehicleDetail['assign_date']){
                        $diff = $vehicleDetail['end_date'] - $vehicleDetail['assign_date'];
                        $days = round(abs($diff)/86400);
                    }
                    if($vehicleDetail['end_date'] < $vehicleDetail['assign_date']){
                        $days = "Wrong Date";
                    }
                    if($vehicleDetail['end_date'] == ""){
                        $days = "Running";
                    }
                    ?>
                    <tr>
                        <td><?= $i++ ?> </td>
                        <td><?= $vehicleDetail['employee']['name_bn']?></td>
                        <td><?= $vehicleDetail['scheme']['name_bn']?></td>
                        <td><?= $vehicleDetail['assign_date']?date('d/m/y', $vehicleDetail['assign_date']):'' ?></td>
                        <td><?= $vehicleDetail['end_date']?date('d/m/y', $vehicleDetail['end_date']):'' ?></td>
                        <td><?= $days ?></td>
                        <td><?= $vehicleDetail['vehicle']['daily_cost_ratio'] ?></td>
                        <td><?php if($days>0){
                                echo $income = $days * $vehicleDetail['vehicle']['daily_cost_ratio'];
                            } ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
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