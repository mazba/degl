<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Districts'), ['action' => 'index']) ?></li>
                    <li class="active"><?= __('New District') ?></li>
        
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Districts'), ['action' => 'index']) ?></li>
                    <li class="active"><?= $this->Html->link(__('New District'), ['action' => 'add']) ?></li>
        

    </ul>
</div>


<?= $this->Form->create($district,['class' => 'form-horizontal','role'=>'form']); ?>
<div class="panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add District') ?>
        </h6></div>
    <div class="panel-body">
        <?php
                            echo $this->Form->input('division_id', ['options' => $divisions]);
                                    echo $this->Form->input('zone_id', ['options' => $zones]);
                                    echo $this->Form->input('name_en');
                                    echo $this->Form->input('name_bn');
                                echo $this->Form->input('status', ['options' => ['1'=>'Active','0'=>'In-Active']]);
                        ?>

        <div class="form-actions text-right">
            <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
        </div>
    </div>
</div>
<?= $this->Form->end() ?>

