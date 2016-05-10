<?php
use Cake\Core\Configure;
Configure::load('config_offices', 'default');

?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Offices'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('New Office') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Offices'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('New Office'), ['action' => 'add']) ?></li>


    </ul>
</div>


<?= $this->Form->create($office, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Office') ?>
        </h6></div>
    <div class="panel-body col-sm-6">
        <?php
        echo $this->Form->input('office_level',['options' => Configure::read('office_levels')]);
        echo $this->Form->input('office_code');
        echo $this->Form->input('office_short_title');
        echo $this->Form->input('division_id', ['options' => $divisions, 'empty' => __('SELECT_DIVISION')]);
        ?>
        <div id="main_container_zone_dropdown" style="display: none;">
            <?php
            echo $this->Form->input('zone_id', ['options' => [], 'empty' =>  __('SELECT_ZONE')]);
            ?>
        </div>
        <div id="main_container_district_dropdown" style="display: none;">
            <?php
            echo $this->Form->input('district_id', ['options' => [], 'empty' =>  __('SELECT_DISTRICT')]);
            ?>
        </div>
        <div id="main_container_upazila_dropdown" style="display: none;">
            <?php
            echo $this->Form->input('upazila_id', ['options' => [], 'empty' =>  __('SELECT_UPAZILA')]);
            ?>
        </div>
    </div>
    <div class="panel-body col-sm-6">
        <?php
        echo $this->Form->input('name_en',['label'=> __('NAME_EN')]);
        echo $this->Form->input('name_bn',['label'=> __('NAME_BN')]);
        echo $this->Form->input('office_contact_no');
        echo $this->Form->input('address');
        echo $this->Form->input('status', ['options' => Configure::read('status_options')]);
        ?>
    </div>
    <div class="form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>
<script type="text/javascript">
    jQuery(document).ready(function()
    {
        $(document).on("change", "#division-id", function(event)
        {
            var division_id = $(this).val();
            $('#zone-id').val('');
            $('#main_container_zone_dropdown').hide();
            $('#district-id').val('');
            $('#main_container_district_dropdown').hide();
            $('#upazila-id').val('');
            $('#main_container_upazila_dropdown').hide();

            if(division_id)
            {
                $.ajax({
                    url: '<?=$this->Url->build(('/Dashboard/ajax/get_zone_by_division_id'), true)?>',
                    type: 'POST',

                    data:{division_id:division_id},
                    success: function (data, status)
                    {
                        $('#main_container_zone_dropdown').html(data);
                        $('#main_container_zone_dropdown').show();
                        //$('#main_container_zone_dropdown').show();$('#container_module_id').html(data);
                        //console.log(data);

                    },
                    error: function (xhr, desc, err)
                    {
                        console.log("error");

                    }
                });
            }
        });
        $(document).on("change", "#zone-id", function(event)
        {
            var division_id = $('#division-id').val();
            var zone_id = $(this).val();
            $('#district-id').val('');
            $('#main_container_district_dropdown').hide();
            $('#upazila-id').val('');
            $('#main_container_upazila_dropdown').hide();

            if(division_id&&zone_id)
            {
                $.ajax({
                    url: '<?=$this->Url->build(('/Dashboard/ajax/get_district_by_division_zone_id'), true)?>',
                    type: 'POST',

                    data:{division_id:division_id,zone_id:zone_id},
                    success: function (data, status)
                    {
                        $('#main_container_district_dropdown').html(data);
                        $('#main_container_district_dropdown').show();
                        //$('#main_container_zone_dropdown').show();$('#container_module_id').html(data);
                        //console.log(data);

                    },
                    error: function (xhr, desc, err)
                    {
                        console.log("error");

                    }
                });
            }
        });
        $(document).on("change", "#district-id", function(event)
        {
            var division_id = $('#division-id').val();
            var district_id = $(this).val();
            $('#upazila-id').val('');
            $('#main_container_upazila_dropdown').hide();

            if(division_id&&district_id)
            {
                $.ajax({
                    url: '<?=$this->Url->build(('/Dashboard/ajax/get_upazila_by_division_district_id'), true)?>',
                    type: 'POST',

                    data:{division_id:division_id,district_id:district_id},
                    success: function (data, status)
                    {
                        $('#main_container_upazila_dropdown').html(data);
                        $('#main_container_upazila_dropdown').show();
                        //$('#main_container_zone_dropdown').show();$('#container_module_id').html(data);
                        //console.log(data);

                    },
                    error: function (xhr, desc, err)
                    {
                        console.log("error");

                    }
                });
            }
        });
    });
</script>

