<?php
use Cake\Core\Configure;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>">Dashboard</a></li>
        <li><?= $this->Html->link(__('Assets'), ['action' => 'index']) ?></li>
                    <li class="active">New Asset</li>
        
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Assets'), ['action' => 'index']) ?></li>
                    <li class="active"><?= $this->Html->link(__('New Asset'), ['action' => 'add']) ?></li>
        

    </ul>
</div>


<?= $this->Form->create($asset,['class' => 'form-horizontal','role'=>'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Asset') ?>
        </h6></div>
    <div class="panel-body col-sm-6 col-sm-offset-3">
        <?php
                            echo $this->Form->input('name');
                                    echo $this->Form->input('asset_code');
                                    echo $this->Form->input('description');
                                    echo $this->Form->input('quantity');
        ?>

        <div id="nothi_register" class="">

            <?php
            echo $this->Form->input('parent_id', ['required', 'options' => $nothiRegisters, 'empty' => __('Select'), 'templates' => ['inputContainer' => '<div class="form-group nothi_register {{type}}{{required}}">{{content}}</div>']]);
            ?>

        </div>


    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="Save" class="btn btn-primary">
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