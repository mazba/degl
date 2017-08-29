<?php
//pr($services->toArray());die;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Vehicles') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Vehicles'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1) {
            ?>
            <li><?= $this->Html->link(__('New Vehicle'), ['action' => 'add']) ?></li>
            <?php
        }
        ?>
        <li class="active"><?= $this->Html->link(__('Vehicle Servicing Report'), ['action' => 'service_report']) ?></li>

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
                    <th class="text-center" rowspan="2"><?= __('SL NO') ?></th>
                    <th class="text-center" rowspan="2"><?= __('DATE OF BREAK DOWN') ?></th>
                    <th class="text-center" rowspan="2"><?= __('KM/HR') ?></th>
                    <th class="text-center" rowspan="2"><?= __('PREIODIC MAINTENANCE') ?></th>
                    <th class="text-center" rowspan="2"><?= __('DEFECTS') ?></th>
                    <th class="text-center" rowspan="2"><?= __('Name of Spare Parts') ?></th>
                    <th class="text-center" rowspan="2"><?= __('মোট খরচ') ?></th>
                    <th class="text-center" colspan="2">
                        <?= __('DATE OF REPAIR/REPLACE') ?>
                    </th>
                    <th class="text-center" rowspan="2"><?= __('JOB CARD') ?></th>

                </tr>

                <tr>
                    <th class="text-center"><?= __('START') ?></th>
                    <th class="text-center"><?= __('COMPLETE') ?></th>
                </tr>

                <?php $i = 1; $expense = 0;
                foreach ($services as $service):
                    $expense += $service->service_charge_approved;
                    ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= date('d-m-Y', $service->breakdown_date) ?></td>
                        <td><?= $service->km_hr ?></td>
                        <td><?php if ($service->is_periodic_maintenance == 1) {
                                echo "Yes";
                            } else {
                                echo "No";
                            } ?></td>
                        <td><?= $service->defects ?></td>
                        <td><?php foreach ($service->vehicle_servicing_details as $key => $vehicle_servicing_detail) {
                                if ($key == (count($service->vehicle_servicing_details) - 1)) {
                                    echo $vehicle_servicing_detail['name'];
                                } else {
                                    echo $vehicle_servicing_detail['name'] . ", ";
                                }
                            } ?></td>
                        <td><?= $service->service_charge_approved?$service->service_charge_approved:0 ?></td>
                        <td><?= date('d-m-Y', $service->servicing_start_date) ?></td>
                        <td><?= date('d-m-Y', $service->servicing_end_date) ?> </td>
                        </td>
                        <td><?= $service->job_card ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?= $expense ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </div>
        <div style="margin-top:100px;display: inline-block;width: 100%;text-align: center">
            <div class="col-sm-3 sign">
                <span>Mechanical: Foreman</span><br>
                <span>LGED, Gazipur</span><br>
            </div>
            <div class="col-sm-3 sign">
                <span>Assistant Engineer</span><br>
                <span>LGED, Gazipur</span><br>
            </div>
            <div class="col-sm-3 sign">
                <span>Sr. Assistant Engineer</span><br>
                <span>LGED, Gazipur</span><br>
            </div>
            <div class="col-sm-3 sign">
                <span>Executive Engineer</span><br>
                <span>LGED, Gazipur</span><br>
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