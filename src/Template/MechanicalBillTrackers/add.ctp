<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Mechanical Bill'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('Add New') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Mechanical Bill'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('Add New'), ['action' => 'add']) ?></li>


    </ul>
</div>


<?= $this->Form->create($MechanicalBillTrackers, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add New') ?>
        </h6></div>
    <div class="panel-body">
        <div class="form-group">
            <label class="col-sm-5 control-label text-right"><?= __('Scheme: ') ?></label>
            <div class="col-sm-7">
                <select id="scheme-id" name="scheme_id" class="form-control scheme_id">
                    <?php
                    foreach($schemes as $id=>$scheme)
                    {
                        $string = $scheme;
//                        if (strlen($string) > 100)
//                        {
//                            // truncate string
//                            $stringCut = substr($string, 0, 100);
//                            $string = substr($stringCut, 0, strrpos($stringCut, ' ')).' ...';
//                        }
                        ?>
                        <option title="<?= $scheme ?>" value="<?= $id ?>"><?= $scheme ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group input text">
            <label for="ra-bill-no" class="col-sm-5 control-label text-right"><?= __('Ra Bill No') ?></label>
            <div class="col-sm-7 container_ra_bill_no">
                <input type="text" name="ra_bill_no" class="form-control" id="ra-bill-no">
            </div>
        </div>
        <div class="form-group input text required">
            <label for="deduction" class="col-sm-5 control-label text-right"><?= __('Deduction') ?></label>
            <div class="col-sm-7 container_deduction">
                <input type="text" name="deduction" class="form-control" id="deduction" required="">
            </div>
        </div>
        <div class="form-actions text-right">
            <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
        </div>
    </div>
</div>
<?= $this->Form->end() ?>

