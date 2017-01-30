<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Tasks'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('New Task') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Tasks'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('New Task'), ['action' => 'add']) ?></li>


    </ul>
</div>


<?= $this->Form->create($task, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Task') ?>
        </h6></div>
    <div class="panel-body">
        <?php
        echo $this->Form->input('component_id', ['options' => $components,'empty' => 'Select','required'=>true]);
        echo $this->Form->input('module_id', ['options' => $modules,'empty' => 'Select','required'=>true]);
        echo $this->Form->input('name_en');
        echo $this->Form->input('name_bn');
        echo $this->Form->input('description');
        echo $this->Form->input('icon');
        echo $this->Form->input('controller');
        echo $this->Form->input('ordering');
        echo $this->Form->input('position_left',['options' => ['1' => 'Yes', '0' => 'No']]);
        echo $this->Form->input('position_top',['options' => [ '0' => 'No','1' => 'Yes']]);
        echo $this->Form->input('status', ['options' => ['1' => 'Active', '0' => 'In-Active']]);
        ?>

        <div class="form-actions text-right">
            <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
        </div>
    </div>
</div>
<?= $this->Form->end() ?>

<script type="text/javascript">
    jQuery(document).ready(function()
    {
        $(document).on("change", "#component-id", function(event)
        {
            var component_id = $(this).val();
            //console.log(component_id);
            $.ajax({
                url: '<?=$this->Url->build(('/Tasks/ajax/get_modules_by_componentId'), true)?>',
                type: 'POST',

                data:{component_id:component_id},
                success: function (data, status)
                {
                    $('#container_module_id').html(data);
                    //console.log(data);

                },
                error: function (xhr, desc, err)
                {
                    console.log("error");

                }
            });


        });
    });
</script>