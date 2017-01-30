<?php
use Cake\Core\Configure;
use Cake\Routing\Router;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Lab Test'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('Edit Lab Test') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Lab Test'), ['action' => 'index']) ?></li>
    </ul>
</div>

<form class="form-horizontal" role="role" method="post" action="<?php echo Router::url('/',true); ?>add_lab_test_registers/add/<?php echo $id; ?>" enctype="multipart/form-data">
<div class="row panel panel-default">

    <div class="panel-heading">
        <h6 class="panel-title">
            <i class="icon-paragraph-right2"></i><?= __('Add Lab Test') ?>
        </h6>
    </div>
    <div class="panel-body">
        <div class="col-md-10">
            <?php
            if($labLetterRegisters['schemes']['name_en'])
            {
                ?>
                <div class="form-group input">
                    <label class="col-sm-3 control-label text-right"><?= __('Scheme') ?></label>
                    <div class="col-sm-9 files">
                        <label class="form-control"><?php echo $labLetterRegisters['schemes']['name_en']; ?></label>
                    </div>
                </div>
            <?php
            }
            else
            {
            ?>
                <div class="form-group input">
                    <label class="col-sm-3 control-label text-right"><?= __('Work Description') ?></label>
                    <div class="col-sm-9 files">
                        <label class="form-control"><?php echo $labLetterRegisters['work_description']; ?></label>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
        <div id="wrapper" class="row">
            <div class="base_content col-sm-12 ">
                <div class="col-sm-12">
                    <div class="form-group input col-sm-6">
                        <label class="col-sm-4 control-label text-right"><?= __('Test Short Name') ?></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control test_short_name" name="lab_test[0][test_short_name]" multiple required="required">
                        </div>
                    </div>
                    <div class="form-group input col-sm-6">
                        <label class="col-sm-4 control-label text-right"><?= __('Test Full Name') ?> </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control test_full_name" name="lab_test[0][test_full_name]" multiple required="required">
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group input col-sm-6">
                        <label class="col-sm-4 control-label text-right"><?= __('Test Fee') ?></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control test_fee" name="lab_test[0][test_fee]" multiple required="required">
                        </div>
                    </div>
                    <div class="form-group input col-sm-6">
                        <label class="col-sm-4 control-label text-right"><?= __('Remarks') ?></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control remarks" name="lab_test[0][remarks]" multiple required="required">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button type="button" id="add_more_btn" class="btn btn-warning pull-right"><?= __('Add More') ?></button>
    </div>
    <div class="col-sm-12 form-actions text-center">
        <input type="submit" value="Save" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

<div class="hidden_content hidden"  data-current-id="0">
    <div class="add-more-content col-sm-12 ">
        <hr>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <div class="col-sm-12">
            <div class="form-group input col-sm-6">
                <label class="col-sm-4 control-label text-right"><?= __('Test Short Name') ?></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control test_short_name" name="" multiple required="required">
                </div>
            </div>
            <div class="form-group input col-sm-6">
                <label class="col-sm-4 control-label text-right"><?= __('Test Full Name') ?></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control test_full_name" name="" multiple required="required">
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group input col-sm-6">
                <label class="col-sm-4 control-label text-right"><?= __('Test Fee') ?></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control test_fee" name="" multiple required="required">
                </div>
            </div>
            <div class="form-group input col-sm-6">
                <label class="col-sm-4 control-label text-right"><?= __('Remarks') ?></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control remarks" name="" multiple required="required">
                </div>
            </div>
        </div>
    </div>

</div>

    <script type="text/javascript">
        jQuery(document).ready(function()
        {
            $(document).on("click", "#add_more_btn", function(event)
            {
                var current_id=parseInt($('.hidden_content').attr('data-current-id'));
                current_id=current_id+1;
                $('.hidden_content').attr('data-current-id',current_id);
                $('.hidden_content .test_short_name').attr('name','lab_test['+current_id+'][test_short_name]');
                $('.hidden_content .test_full_name').attr('name','lab_test['+current_id+'][test_full_name]');
                $('.hidden_content .test_fee').attr('name','lab_test['+current_id+'][test_fee]');
                $('.hidden_content .remarks').attr('name','lab_test['+current_id+'][remarks]');
                var html=$('.hidden_content').html();
                $('#wrapper').append(html);
            });
        });
    </script>

