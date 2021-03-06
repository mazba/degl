<?php
use Cake\Core\Configure;

?>
<div class="breadcrumb-line">
  <ul class="breadcrumb">
    <li><a href="<?= $this->Url->build(('/Dashboard'), TRUE); ?>"><?= __('Dashboard') ?></a></li>
    <li><?= $this->Html->link(__('Vehicle Servicing'), ['action' => 'index']) ?></li>
    <li class="active"><?= __('Edit Vehicle Servicing') ?></li>

  </ul>
</div>
<div class="tabbable page-tabs">
  <ul class="nav nav-tabs">
    <li><?= $this->Html->link(__('List of Vehicle Servicings'), ['action' => 'index']) ?></li>
    <?php
    if ($user_roles['add'] == 1) {
      ?>
      <li><?= $this->Html->link(__('New Vehicle Servicing'), ['action' => 'add']) ?></li>
      <?php
    }
    ?>
    <li class="active"><?= $this->Html->link(__('Edit Vehicle Servicing'), ['action' => 'edit', $vehicleServicing->id]) ?>
    </li>
    <?php
    if ($user_roles['view'] == 1) {
      ?>
      <li><?= $this->Html->link(__('Details Vehicle Servicing'), ['action' => 'view', $vehicleServicing->id]) ?>
      </li>
      <?php
    }
    ?>

  </ul>
</div>

<?= $this->Form->create($vehicleServicing, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="row panel panel-default">

  <div class="panel-heading"><h6 class="panel-title"><i
        class="icon-paragraph-right2"></i><?= __('Add Vehicle Servicing') ?>
    </h6></div>
  <div class="panel-body">
    <?php echo $this->Form->hidden('job_card'); ?>
    <div class="col-sm-6">

      <?php
      echo $this->Form->input('breakdown_date', ['type' => 'text', 'value' => $this->System->display_date($vehicleServicing->breakdown_date), 'class' => 'form-control hasdatepicker']);
      echo $this->Form->input('km_hr');
      echo $this->Form->input('is_periodic_maintenance', ['options' => Configure::read('yes_no_options')]);
      echo $this->Form->input('vehicle_location');
      ?>
    </div>
    <div class="col-sm-6">
      <?php
      echo $this->Form->input('servicing_start_date', ['type' => 'text', 'value' => $this->System->display_date($vehicleServicing->servicing_start_date), 'class' => 'form-control hasdatepicker']);
      echo $this->Form->input('servicing_end_date', ['type' => 'text', 'value' => $this->System->display_date($vehicleServicing->servicing_end_date), 'class' => 'form-control hasdatepicker']);
      echo $this->Form->input('financial_year_estimate_id', ['options' => $finalcialYears, 'empty' => 'Select']);
      echo $this->Form->input('job_card');
      echo $this->Form->input('defects');
      echo $this->Form->input('vehicle_place_of_user');
      ?>
    </div>

    <div class="col-sm-12 list" data-index_no="0">
      <div class="form-group">
        <div class='col-md-5'>
          <label for=""><?= __('Name of Spare Parts') ?></label>
        </div>
        <div class='col-md-2'>
          <label for=""><?= __('Quantity') ?></label>
        </div>
        <div class='col-md-2'>
          <label for=""><?= __('Rate') ?></label>
        </div>
        <div class='col-md-2'>
          <label for=""><?= __('Total') ?></label>
        </div>
        <div class='col-md-1'>
          <label for=""></label>
        </div>
      </div>
      <?php if (count($vehicleServicing->vehicle_servicing_details) == 0) { ?>
        <div class="form-group single_list">
          <div class='col-md-5'>
            <input type="text" placeholder="Name of Spare Parts" class="form-control" name="parts[0][name]">
          </div>
          <div class='col-md-2'>
            <input type="number" placeholder="Quantity" min="1" step="0.01" class="form-control quantity"
                   name="parts[0][quantity]">
          </div>
          <div class='col-md-2'>
            <input type="number" placeholder="Rate" min="0.01" step="0.01" class="form-control rate"
                   name="parts[0][rate]">
          </div>
          <div class='col-md-2'>
            <input type="number" class="form-control total" name="parts[0][total]" readonly>
          </div>
          <div class='col-md-1'>
            <span class="btn btn-danger remove">X</span>
          </div>
        </div>

      <?php } else {
        foreach ($vehicleServicing->vehicle_servicing_details as $key => $row): ?>
          <div class="form-group single_list">
            <div class='col-md-5'>
              <input type="text" placeholder="Name of Spare Parts" class="form-control" name="parts[<?= $key ?>][name]" value="<?= $row['name'] ?>"/>
            </div>
            <div class='col-md-2'>
              <input type="number" placeholder="Quantity" min="1" step="0.01" class="form-control quantity" name="parts[<?= $key ?>][quantity]" value="<?= $row['quantity'] ?>"/>
            </div>
            <div class='col-md-2'>
              <input type="number" placeholder="Rate" min="0.01" step="0.01" class="form-control rate" name="parts[<?= $key ?>][rate]" value="<?= $row['rate'] ?>"/>
            </div>
            <div class='col-md-2'>
              <input type="number" class="form-control total" name="parts[<?= $key ?>][total]" readonly value="<?= $row['total'] ?>"/>
            </div>
            <div class='col-md-1'>
              <span class="btn btn-danger remove">X</span>
            </div>
          </div>
        <?php endforeach;
      } ?>

    </div>

    <div class="col-sm-12 text-right">
      <span class="btn btn-success add_more"><?= __('Add more') ?></span>
    </div>

    <div class="col-sm-offset-6 col-sm-6" style="margin-top: 40px">
      <?php
      echo $this->Form->input('other_charge', ['type' => 'number']);
      echo $this->Form->input('service_charge', ['label' => __('আনুমানিক মূল্য মোট')]);
      echo $this->Form->input('service_charge_approved', ['label' => __('বরাদ্দকৃত মূল্য মোট')]);
      ?>
    </div>
    <div class="col-sm-12 form-actions text-right">
      <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
  </div>

</div>

<?= $this->Form->end() ?>

<script>
  $(document).ready(function () {
    $(document).on('click', '.add_more', function () {
      var index = $('.list').data('index_no');
      $('.list').data('index_no', index + 1);
      var html = $('.single_list:last').clone().find('input').each(function () {
        this.name = this.name.replace(/\d+/, index + 1);
        this.value = '';
      }).end();
      $('.list').append(html);
    });

    $(document).on('click', '.remove', function () {
      var obj = $(this);
      var count = $('.single_list').length;
      if (count > 1) {
        obj.closest('.single_list').remove();
        calculate();
      }
    });

    $(document).on('keyup', '.quantity', function () {
      var quantity = parseFloat($(this).val());
      var obj = $(this);
      var rate = parseFloat(obj.closest('.single_list').find('.rate').val());
      var total = rate * quantity || '';
      if (rate) {
        obj.closest('.single_list').find('.total').val(total);
        calculate();
      }
    });

    $(document).on('keyup', '.rate', function () {
      var rate = parseFloat($(this).val());
      var obj = $(this);
      var quantity = parseFloat(obj.closest('.single_list').find('.quantity').val());
      var total = rate * quantity || '';
      if (quantity) {
        obj.closest('.single_list').find('.total').val(total);
        calculate();
      }
    });

    $(document).on('keyup', '#other-charge', function () {
      calculate();
    })
  });

  function calculate() {
    var other_cost = parseFloat($('#other-charge').val()) || 0;
    var total = 0;
    $('.total').each(function () {
      total = total + parseFloat($(this).val() || 0);
    });
    $('#service-charge').val(other_cost + total);

  }
</script>


