<?php // echo "<pre>";print_r($id);die();?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Messages'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('New Message') ?></li>

    </ul>
</div>
<?= $this->Form->create(null, ['url'=>['controller'=>'RaBillApplication','action'=>'approve_ra_bill',$id],'class' => 'form-horizontal', 'role' => 'form','type'=>'file']); ?>
<div class="row panel panel-default">
    <div class="panel-heading">
        <h6 class="panel-title">
            <i  class="icon-paragraph-right2"></i><?= __('New Message') ?>
        </h6>
    </div>
    <div class="panel-body col-sm-10">
        <div class="form-group input text">
            <label class="col-sm-3 control-label text-right" for="subject">Bill Amount</label>
            <div class="col-sm-9 container_subject">
                <input required="required" id="" class="form-control" name="" type="text" value="<?= $measurementInfo['this_bill_amount']?>" readonly>
            </div>
        </div>

        <div class="form-group input text">
            <label class="col-sm-3 control-label text-right" for="subject">Approve Amount</label>
            <div class="col-sm-9 container_subject">
                <input required="required" id="" class="form-control" name="approve_bill_amount" type="text" >
            </div>
        </div>

        <div class="col-sm-6 user">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title">
                        <a id="collapsed_click" href="#colorOne" data-parent="#accordion-color" data-toggle="collapse"
                           class="collapsed"><?= __('Send to Users') ?></a>
                    </h6>
                </div>
                <div class="panel-collapse collapse" id="colorOne">
                    <div class="panel-body">
                        <select id="user" class="form-control multi-select" multiple="multiple" name="user[]">
                            <?php foreach ($departments as $department) { ?>
                                <optgroup label="<?= $department->name_bn ?>">
                                    <?php foreach ($department['users'] as $user) { ?>
                                        <option
                                            value="<?= $user['id'] ?>"><?= $user['name_bn'] . " (" . $user['designation']['name_bn'] . ")" ?></option>
                                    <?php } ?>
                                </optgroup>
                            <?php } ?>
                        </select>
                        <?= $this->Form->input('subject', ['style' => 'margin-top:10px;']); ?>
                        <?= $this->Form->input('message', ['type' => 'textarea']) ?>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="col-sm-10 form-actions text-right">
        <input type="submit" value="<?= __('Send') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>





                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       