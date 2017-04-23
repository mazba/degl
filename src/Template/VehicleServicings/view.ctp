<div class="breadcrumb-line" xmlns="http://www.w3.org/1999/html">
  <ul class="breadcrumb">
    <li><a href="<?= $this->Url->build(('/Dashboard'), TRUE); ?>"><?= __('Dashboard') ?></a></li>
    <li><?= $this->Html->link(__('Vehicle Servicings'), ['action' => 'index']) ?> </li>
    <li class="active"><?= __('Detail Vehicle Servicing') ?> </li>
  </ul>
</div>
<div class="tabbable page-tabs">
  <ul class="nav nav-tabs">
    <li><?= $this->Html->link(__('List of Vehicle Servicings'), ['action' => 'index']) ?> </li>
    <?php
    if ($user_roles['add'] == 1) {
      ?>
      <li><?= $this->Html->link(__('New Vehicle Servicing'), ['action' => 'add']) ?></li>
      <?php
    }
    ?>
    <?php
    if ($user_roles['edit'] == 1) {
      ?>
      <li><?= $this->Html->link(__('Edit Vehicle Servicing'), ['action' => 'edit', $vehicleServicing->id]) ?></li>
      <?php
    }
    ?>
    <li class="active"><?= $this->Html->link(__('Details Vehicle Servicing'), ['action' => 'view', $vehicleServicing->id]) ?>
    </li>
  </ul>
</div>

<div class="row panel panel-default">

  <div class="panel-heading"><h6 class="panel-title"><i class="icon-paragraph-right2"></i>যানবাহন মেরামত যোগ করুন</h6>
    <button class="btn btn-success" style="float: right" onclick="print_rpt()">Print</button>

  </div>
  <div class="panel-body" id="PrintArea">

    <h3 style="text-align: center">JOB CARD</h3>

    <div class="" style="margin: 0px">

      <p><strong>Name of Vehicle :</strong><?= $vehicleServicing->vehicle->title ?></p>

      <p><strong>Model/Brand :</strong><?= $vehicleServicing->vehicle->make_and_model ?></p>
      <p><strong>User :</strong></p>

      <p><strong>Name of Operator :</strong> <?= isset($VehicleStatus->employee->name_bn)?$VehicleStatus->employee->name_bn:'NA'; ?></p>
      <!-- <p><strong>Date of Breakdown:</strong> <? /*= !empty($vehicleServicing->breakdown_date)?date('d/m/Y',$vehicleServicing->breakdown_date):'NA'; */ ?></p>-->

    </div>

    <div class="col-sm-12" data-index_no="0"><br/><br/>
      <table class="table table-bordered">
        <tr>
          <td>SL No</td>
          <td>Date of Breakdown</td>
          <td>Name of Spare Parts</td>
          <td>Quantity</td>
          <td>Rate</td>
          <td>Total</td>
        </tr>
        <?php foreach ($vehicleServicing->vehicle_servicing_details as $key => $row): ?>
          <tr>
            <td><?= $key + 1 ?></td>
            <td><?= !empty($vehicleServicing->breakdown_date) ? date('d/m/Y', $vehicleServicing->breakdown_date) : 'NA'; ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['quantity'] ?></td>
            <td><?= $row['rate'] ?></td>
            <td><?= $row['total'] ?></td>
          </tr>
        <?php endforeach; ?>
        <tr>
          <td colspan="4">&nbsp;</td>
          <td colspan="">Other Charge</td>
          <td><?= $vehicleServicing->other_charge ?></td>
        </tr>

        <tr>
          <td colspan="4">&nbsp;</td>
          <td colspan="">Total</td>
          <td><?= $vehicleServicing->service_charge ?></td>
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

</div>

<script>
  function print_rpt() {
    URL = "<?php echo $this->request->webroot; ?>page/Print_a4_Eng.php?selLayer=PrintArea";
    day = new Date();
    id = day.getTime();
    eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=yes,scrollbars=yes ,location=0,statusbar=0 ,menubar=yes,resizable=1,width=880,height=600,left = 20,top = 50');");
  }

</script>