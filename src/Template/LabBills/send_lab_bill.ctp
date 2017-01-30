<?php
use Cake\Core\Configure;
use Cake\Routing\Router;
?>
<div id="send_Modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" style="">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-delicious"></i> <?= __('Lab Bills') ?></h4>
            </div>
            <div class="modal-body with-padding">
                <div class="row">

                    <div class="col-sm-12 ">
                        <form class="form-horizontal" role="role" method="post" action="<?php echo Router::url('/',true); ?>lab_bills/sendLabBill/<?php echo $bill_id; ?>" enctype="multipart/form-data">

                        <div class="form-group input select">
                            <label for="user" class="col-sm-3 control-label text-right"><?= __('User') ?></label>
                            <div class="col-sm-9 container_subject">
                                <select id="user" class="form-control multi-select" multiple="multiple" name="user[]">
                                    <?php
                                    $dept = "";
                                    foreach ($departments as $department) { ?>
                                    <?php if ($department['name_bn'] != $dept) { ?>
                                    <optgroup label="<?= $department['name_bn'] ?>">
                                        <?php $dept = $department['name_bn'];
                                        } ?>
                                        <?php if (isset($department['users']['name_bn'])) { ?>
                                            <option
                                                value="<?= $department['users']['id'] ?>"><?= $department['users']['name_bn'] . " (" . $department['designations']['name_bn'] . ")" ?></option>
                                        <?php }
                                        } ?>
                                </select>
                            </div>
                        </div>
                        <div style="margin-top: 15px"></div>
                        <?= $this->Form->input('subject') ?>
                        <div style="margin-top: 15px"></div>
                        <?= $this->Form->input('message', ['type' => 'textarea']) ?>
                            <div class="col-sm-12 form-actions text-center">
                                <input type="submit" value="Send" class="btn btn-primary">
                            </div>
                        <?= $this->Form->end() ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript"
        src="<?php echo $this->request->webroot; ?>bs3admin/js/plugins/forms/select2.min.js"></script>

<script type="text/javascript" src="<?php echo $this->request->webroot; ?>bs3admin/js/application.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $(".multi-selects").select2();

    });
</script>