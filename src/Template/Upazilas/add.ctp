<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Upazilas'), ['action' => 'index']) ?></li>
                    <li class="active"><?= __('New Upazila') ?></li>
        
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Upazilas'), ['action' => 'index']) ?></li>
                    <li class="active"><?= $this->Html->link(__('New Upazila'), ['action' => 'add']) ?></li>
        

    </ul>
</div>


<?= $this->Form->create($upazila,['class' => 'form-horizontal','role'=>'form']); ?>
<div class="panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Upazila') ?>
        </h6></div>
    <div class="panel-body">
        <?php
                            echo $this->Form->input('lged_syscode');
                                    echo $this->Form->input('division_id', ['options' => $divisions]);
                                    echo $this->Form->input('district_id', ['options' => $districts]);
                                    echo $this->Form->input('lged_code');
                                    echo $this->Form->input('upazila_geocode');
                                    echo $this->Form->input('district_name_en');
                                    echo $this->Form->input('name_bn');
                                    echo $this->Form->input('name_en');
                                echo $this->Form->input('status', ['options' => ['1'=>'Active','0'=>'In-Active']]);
                        ?>

        <div class="form-actions text-right">
            <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
        </div>
    </div>
</div>
<?= $this->Form->end() ?>

