<?php
use Cake\Core\Configure;
$contractor_type = Configure::read('contractor_type');
//pr($contractor_type);die;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Contractors'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('New Contractor') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Contractors'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('New Contractor'), ['action' => 'add']) ?></li>


    </ul>
</div>


<?= $this->Form->create($contractor, ['class' => 'form-horizontal', 'role' => 'form', 'type' => 'file']); ?>
<div class=" row panel panel-default">

    <div class="panel-heading">
        <h6 class="panel-title">
            <i class="icon-paragraph-right2"></i><?= __('Add Contractor') ?>
        </h6>
    </div>
    <div class="panel-body ">
        <div class="col-sm-6">
            <?php
            echo $this->Form->input('contractor_type', ['empty' => 'নির্বাচন করুন', 'required' => 'required', 'options' => $contractor_type]);
            echo $this->Form->input('contractor_class_title');
            echo $this->Form->input('contractor_title', ['label' => 'প্রতিষ্ঠানের নাম (English)']);
            echo $this->Form->input('contractor_title_bn', ['label' => 'প্রতিষ্ঠানের নাম (বাংলা)']);
            echo $this->Form->input('contact_person_name');
            echo $this->Form->input('contractor_phone');
            echo $this->Form->input('mobile');
            echo $this->Form->input('contractor_email');

            ?>
        </div>
        <div class="col-sm-6">
            <?php
            echo $this->Form->input('fax');
            echo $this->Form->input('vat_no');
            echo $this->Form->input('tin_no');
            echo $this->Form->input('trade_licence_no');
            echo $this->Form->input('nid', ['label' => 'জাতীয় পরিচয়পত্র']);
            echo $this->Form->input('picture', ['type' => 'file']);
            echo $this->Form->input('contractor_address', ['type' => 'textarea']);
            ?>
            <div id="nothi_register" class="">
                <?php
                echo $this->Form->input('parent_id', ['required', 'options' => $nothiRegisters, 'empty' => __('Select'), 'templates' => ['inputContainer' => '<div class="form-group nothi_register {{type}}{{required}}">{{content}}</div>']]);
                ?>
            </div>
        </div>
    </div>

    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
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