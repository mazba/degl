<?php
//pr($vehicles);die;
?>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
            <li class="active"><?= __('Vehicles') ?></li>
        </ul>
    </div>
    <div class="row">
        <?= $this->Form->create(null, ['class' => 'form-horizontal', 'role' => 'form']); ?>
        <div class="col-md-8">
            <?php echo $this->Form->input('financial_year_estimate_id', ['options' => $finalcialYears, 'empty' => 'Select']); ?>
            <div class="text-center">
                <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
            </div>
        </div>
        <?= $this->Form->end() ?>
    </div>

<?php if(isset($vehicles)): ?>
    <!-- Report -->
    <div class="col-sm-12">
        <button style="float: right;margin-top: 5px" onclick="print_rpt()">Print</button>
    </div>
    <div id="PrintArea">
        <div class="col-sm-12">
            <h3 class="text-center"><?= __('List Of Vechile & Equipment at XEN Office, LGED, Dist-Gazipur') ?></h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div style="display: block" class="col-sm-12">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th><?= 'Sl. No.' ?></th>
                            <th><?= 'Description' ?></th>
                            <th><?= 'Reg NO/CC' ?></th>
                            <th><?= 'C/Origin' ?></th>
                            <th><?= 'Source off Fund' ?></th>
                            <th><?= 'P/Position' ?></th>
                            <th> Cost
                                <?php if(isset($finalcialYear)){
                                    echo $finalcialYear['name'].' Financial Year';
                                }else{
                                    echo 'Total';
                                }
                                ?>
                            </th>
                            <th><?= 'Remarks' ?></th>
                        </tr>
                        </thead>
                        <tbody class="test_list">
                        <?php foreach($vehicles as $key => $vehicle):?>
                            <tr>
                                <td><?= $key+1 ?></td>
                                <td><?= $vehicle['title'] ?></td>
                                <td><?php if($vehicle['type'] == 'vehicles'){
                                        echo $vehicle['registration_no'];
                                    }else{
                                        echo $vehicle['equipment_engine_capacity'];
                                    }
                                    ?>
                                </td>
                                <td><?= $vehicle['country_of_origin']?></td>
                                <td><?= $vehicle['equipment_source']?></td>
                                <td><?= $vehicle['vehicle_status']?></td>
                                <td><?= $vehicle['serviceCost']?></td>
                                <td></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <style>
            td:last-child {width: 150px !important; }
        </style>
    </div>

    <script>
        function print_rpt() {
            URL = "<?php echo $this->request->webroot; ?>page/Print_a4_Eng.php?selLayer=PrintArea";
            day = new Date();
            id = day.getTime();
            eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=yes,scrollbars=yes ,location=0,statusbar=0 ,menubar=yes,resizable=1,width=880,height=600,left = 20,top = 50');");
        }
    </script>
<?php endif; ?>