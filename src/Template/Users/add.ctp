<?php
use Cake\Core\Configure;

?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Users'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('New User') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Users'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('New User'), ['action' => 'add']) ?></li>


    </ul>
</div>


<?= $this->Form->create($user, ['class' => 'form-horizontal', 'role' => 'form', 'type' => 'file']); ?>
<div class="panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add User') ?>
        </h6></div>
    <div class="panel-body col-sm-6">
        <?php
        if($user_info['user_group_id']==1)
        {
            echo $this->Form->input('office_id', ['options' => $offices, 'empty' => 'Select an Office']);
            echo $this->Form->input('department_id',['empty'=>'Select a department']);
            ?>
            <div id="container_designation">
                <?php
                echo $this->Form->input('designation_id', ['options' => $designations, 'empty' => 'Select Designation']);
                ?>
            </div>
            <?php
        }
        else
        {
            echo $this->Form->input('office_id', ['options' => $offices]);
            echo $this->Form->input('department_id',['empty'=>'Select a department']);
            echo $this->Form->input('designation_id', ['options' => $designations]);
        }
        echo $this->Form->input('user_group_id', ['options' => $userGroups]);
        echo $this->Form->input('email');
        echo $this->Form->input('mobile');
        echo $this->Form->input('phone');
        echo $this->Form->input('office_phone');
        echo $this->Form->input('birth_date',['type'=>'text','value'=>$this->System->display_date($user->birth_date),'class'=>'form-control hasdatepicker']);
        echo $this->Form->input('gender', ['options' => Configure::read('gender')]);
        echo $this->Form->input('status', ['options' => Configure::read('status_options')]);

        ?>

    </div>
    <div class="panel-body col-sm-6">
        <?php
        echo $this->Form->input('username');
        echo $this->Form->input('password');
        echo $this->Form->input('name_en', ['label' => __('NAME_EN')]);
        echo $this->Form->input('name_bn', ['label' => __('NAME_BN')]);
        echo $this->Form->input('national_id_no');
        echo $this->Form->input('present_address');
        echo $this->Form->input('permanent_address');
        echo $this->Form->input('picture', ['type' => 'file','data-preview-container'=>'#profile_image_preview']);
        ?>
        <div id="profile_image_preview" class="col-sm-offset-3">

        </div>
    </div>
    <div class="form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

<script type="text/javascript">
    jQuery(document).ready(function()
    {
        $(document).on("change", "#office-id", function(event)
        {
            var office_id = $(this).val();
            $('#designation-id').val('');
            if(office_id)
            {
                $.ajax({
                    url: '<?=$this->Url->build(('/Dashboard/ajax/get_designation_by_office_id'), true)?>',
                    type: 'POST',

                    data:{office_id:office_id},
                    success: function (data, status)
                    {
                        $('#container_designation').html(data);
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

