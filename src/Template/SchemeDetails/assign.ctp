<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Scheme Details'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('Scheme Approve') ?></li>
    </ul>
</div>
<?= $this->Form->create(null, ['controller'=>'scheme_details','action'=>'assign/'.$id,'class' => 'form-horizontal', 'role' => 'form', 'type' => 'file']); ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h6 class="panel-title">
            <i class="icon-paragraph-right2"></i><?= __('Scheme Assign') ?>
        </h6>
    </div>
    <div class="panel-body">
        <?php
            ?>
            <div class="form-group input">
                <label class="col-sm-3 control-label text-right"><?= __('Contractors') ?></label>
                <div class="col-sm-9 contractors">
                    <select class="select-multiple" name="contractors[]" id="contractors" multiple="multiple" tabindex="2" required="required">
                    <?php
                        foreach($contractors as $contractor)
                        {
                            ?>
                            <option value="<?php echo $contractor['id']; ?>"><?php echo $contractor['contractor_title']; ?></option>
                            <?php
                        }
                    ?>
                    </select>
                </div>
            </div>

            <div class="form-group input">
                <label class="col-sm-3 control-label text-right"><?= __('Lead Contractor') ?></label>
                <div class="col-sm-9 lead_contractor">
                    <select class="select-search" tabindex="2" name="lead_contractor" id="lead-contractor" required="required">
                        <option value="Selected"><?= __('Select Lead Contractor') ?></option>
                        <?php
                        foreach($contractors as $contractor)
                        {
                            ?>
                            <option value="<?php echo $contractor['id']; ?>"><?php echo $contractor['contractor_title']; ?></option>
                             <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <?php
            echo $this->Form->input('actual_start_date',['type'=>'text','required','class'=>'form-control hasdatepicker']);
            echo $this->Form->input('remarks',['type'=>'textarea','required','class'=>'form-control']);
            ?>
            <div class="form-group input">
                <label class="col-sm-3 control-label text-right"><?= __('Tender Documents') ?></label>
                <div class="col-sm-9 tender_documents">
                    <input type="file" name="tender_documents[]" multiple required="required">
                </div>
            </div>
            <div class="form-group input">
                <label class="col-sm-3 control-label text-right"><?= __('Tender Notice') ?></label>
                <div class="col-sm-9 tender_notices">
                    <input type="file" name="tender_notices[]" multiple required="required">
                </div>
            </div>
            <div class="form-group input">
                <label class="col-sm-3 control-label text-right"><?= __('Tender Contract') ?></label>
                <div class="col-sm-9 tender_contracts">
                    <input type="file" name="tender_contracts[]" multiple required="required">
                </div>
            </div>
        <div class="form-actions text-center">
            <input type="submit" value="<?= __('Assign') ?>" class="btn btn-danger">
        </div>
    </div>
</div>
<?= $this->Form->end() ?>

