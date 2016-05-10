<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Vehicle Hire'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('Edit Vehicle Hire') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of hired Vehicles'), ['action' => 'index']) ?></li>

        <li class="active"><?=
            $this->Html->link(__('Edit Vehicle Hire'), ['action' => 'edit', $id
            ]) ?>
        </li>
        <li><?=
            $this->Html->link(__('Details Vehicle Hire'), ['action' => 'view', $id
            ]) ?>
        </li>


    </ul>
</div>
<?= $this->Form->create(null, ['controller'=>'vehicle_hire','action'=>'edit/'.$id,'class' => 'form-horizontal', 'role' => 'form']); ?>
    <table class="table table-bordered">
        <tr>
            <td><?= __('Vehilce Title') ?></td>
            <td><?= __('Select') ?></td>
            <td><?= __('Location') ?></td>
        </tr>
        <?php
        $i=0;
        foreach($vehicles as $vehicle)
        {
            ?>
            <tr>
                <td><?=$vehicle['title']?></td>
                <td><input type="checkbox" value="<?=$vehicle['id']?>" name="selected_vehicles[]" <?php if(in_array($vehicle['id'],$hired_vehicles)){echo 'checked';} ?>> </td>
                <td><input <?php if(!in_array($vehicle['id'],$hired_vehicles)){echo "disabled";} ?> class="form-control location<?=$vehicle['id']?> <?php if(in_array($vehicle['id'],$hired_vehicles)){echo "change".$hired_vehicles[$i];} ?>" type="text" value="<?php if(in_array($vehicle['id'],$hired_vehicles)){echo $location[$i++];} ?>" name="location[<?=$vehicle['id']?>]"> </td>
            </tr>
            <?php
        }
        ?>
    </table>
    <div class="form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
<?= $this->Form->end() ?>


<script>
    $(document).ready(function(){
        $( "input[type=checkbox]").on('click',function(){
            if($(this).is(':checked'))
            {
                var location="location"+ $(this).val();
                $('.'+location).removeAttrs('disabled')
            }else
            {
                var location="location"+ $(this).val();
                var change="change"+ $(this).val();
                if($('.'+location).hasClass(change))
                {
                    $('.'+location).removeAttrs('disabled')
                }else
                {
                    $('.'+location).attr('disabled',true)
                }


            }
        })
    })
</script>
