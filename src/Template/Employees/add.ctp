<?php
use Cake\Core\Configure;

?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Employees'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('New Employee') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Employees'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('New Employee'), ['action' => 'add']) ?></li>


    </ul>
</div>


<?= $this->Form->create($employee, ['class' => 'form-horizontal', 'role' => 'form','type'=>'file']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Employee') ?>
        </h6></div>
    <div class="panel-body col-sm-6">
        <?php
        echo $this->Form->input('office_id', ['options' => $offices]);
        echo $this->Form->input('designation_id', ['options' => $designations]);
        echo $this->Form->input('gender', ['options' => Configure::read('gender')]);
        echo $this->Form->input('phone');
        echo $this->Form->input('office_phone');
        echo $this->Form->input('mobile');
        echo $this->Form->input('email');
        echo $this->Form->input('national_id_no');


        echo $this->Form->input('birth_date',['type'=>'text','value'=>$this->System->display_date($employee->birth_date),'class'=>'form-control hasdatepicker']);
        echo $this->Form->input('employee_no');
        echo $this->Form->input('type',['options' => Configure::read('employee_type')]);
        echo $this->Form->input('joining_date',['type'=>'text','value'=>$this->System->display_date($employee->joining_date),'class'=>'form-control hasdatepicker']);
        echo $this->Form->input('is_married', ['options' => Configure::read('yes_no_options')]);
        echo $this->Form->input('religion');
        ?>
    </div>
    <div class="panel-body col-sm-6">
        <?php
        echo $this->Form->input('name_en', ['label' => __('NAME_EN')]);
        echo $this->Form->input('name_bn', ['label' => __('NAME_BN')]);
        echo $this->Form->input('father_name');
        echo $this->Form->input('mother_name');
        echo $this->Form->input('present_address');
        echo $this->Form->input('permanent_address');

        echo $this->Form->input('picture', ['type' => 'file','data-preview-container'=>'#profile_image_preview']);
        ?>
        <div id="profile_image_preview" class="col-sm-offset-3">

        </div>
        <div id="nothi_register" class="">

                <?php
                echo $this->Form->input('parent_id', ['required', 'options' => $nothiRegisters, 'empty' => __('Select'), 'templates' => ['inputContainer' => '<div class="form-group nothi_register {{type}}{{required}}">{{content}}</div>']]);
                ?>

        </div>

        <div id="nothi_register" class="tab-pane fade">
            <div class="col-sm-6">
                <?php
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value='<?= __("Save") ?>' class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

<script>
    jQuery(document).ready(function () {
        $(document).on('change', '#parent-id', function () {
            var parent_id = $(this).val();
            var obj = $(this);
            $.ajax({
                type: 'POST',
                url: '<?= $this->Url->build("/NothiRegisters/getSubNothi")?>',
                data: {parent_id: parent_id},
                success: function (data, status) {
                    obj.closest('.nothi_register').nextAll('.nothi_register').remove();
                    if (data) {
                       // console.log(data);
                        obj.closest('.form-group').after(data);
                    }
                }
            });
        });
    });

</script>