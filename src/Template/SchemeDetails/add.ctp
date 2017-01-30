<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Scheme Details'), ['action' => 'index']) ?></li>
                    <li class="active"><?= __('New Scheme Detail') ?></li>
        
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Scheme Details'), ['action' => 'index']) ?></li>
                    <li class="active"><?= $this->Html->link(__('New Scheme Detail'), ['action' => 'add']) ?></li>
        

    </ul>
</div>


<?= $this->Form->create($schemeDetail,['class' => 'form-horizontal','role'=>'form']); ?>
<div class="panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Scheme Detail') ?>
        </h6></div>
    <div class="panel-body">
        <?php
                            echo $this->Form->input('scheme_id', ['options' => $schemes]);
                                    echo $this->Form->input('item_id', ['options' => $items]);
                                    echo $this->Form->input('scheme_status');
                                    echo $this->Form->input('comp_serial_no');
                                    echo $this->Form->input('deducation');
                                    echo $this->Form->input('component_location');
                                    echo $this->Form->input('cl_length');
                                    echo $this->Form->input('cl_width');
                                    echo $this->Form->input('cl_height_depth');
                                    echo $this->Form->input('cl_area_volume');
                                    echo $this->Form->input('item_quantity');
                                    echo $this->Form->input('has_breakup');
                                    echo $this->Form->input('remarks');
                                echo $this->Form->input('status', ['options' => ['1'=>'Active','0'=>'In-Active']]);
                        ?>

        <div class="form-actions text-right">
            <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
        </div>
    </div>
</div>
<?= $this->Form->end() ?>

