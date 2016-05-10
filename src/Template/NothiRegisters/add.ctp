<?php
use Cake\Core\Configure;

?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Nothi'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('New Nothi') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Nothi'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('New Nothi'), ['action' => 'add']) ?></li>


    </ul>
</div>


<?= $this->Form->create($nothiRegister, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Nothi') ?>
        </h6></div>
    <div class="panel-body col-sm-8">
        <?php
        echo $this->Form->input('parent_id', ['required','class'=>'form-control nothi_register_id','options' => $nothiRegisters, 'empty' => __('Select'), 'templates' => ['inputContainer' => '<div class="form-group nothi_register {{type}}{{required}}">{{content}}</div>']]);
        echo $this->Form->input('nothi_no', ['label' => __('Name')]);
        echo $this->Form->input('nothi_date', ['type' => 'text', 'value' => $this->System->display_date($nothiRegister->nothi_date), 'class' => 'form-control hasdatepicker']);
        echo $this->Form->input('nothi_description');
        ?>
    </div>

</div>
<div class="col-sm-12 form-actions text-right">
    <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
</div>
</div>
<?= $this->Form->end() ?>

<script>
    $(document).ready(function () {
        $(document).on('change', '#parent-id', function () {
            var parent_id = $(this).val();
            var obj=$(this);
            $.ajax({
                type: 'POST',
                url: '<?= $this->Url->build("/NothiRegisters/getSubNothi")?>',
                data: {parent_id: parent_id},
                success: function (data, status) {
                    obj.closest('.nothi_register').nextAll('.nothi_register').remove();
                    if (data) {
                        obj.closest('.form-group').after(data);
                    }
                }
            });
        });

        $(document).on('submit','form', function (e) {
            console.log($('.nothi_register_id:last').val())
            if(!$('.nothi_register_id:last').val()){
                var obj=$('.nothi_register_id:last');
                obj.closest('.form-group').remove();

            }
        })
    });
</script>

