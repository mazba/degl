<?php
use Cake\Routing\Router;
if(!empty($file)){ ?>
<div class="row panel panel-default">
    <?php
    $path = pathinfo($file['document']);
    if ($path['extension'] == 'jpg' || $path['extension'] == 'png' || $path['extension'] == 'JPG' || $path['extension'] == 'PNG') {
        ?>

        <div>
            <a data-lightbox="dak_file_image"
               href="<?php echo Router::url('/', true) . 'img/' . $file['document']; ?>">
                <img width="150" height="130" class="dak_file_image" style="display: block; margin: 0 auto"
                     src="<?php echo Router::url('/', true) . 'img/' . $file['document']; ?>">
            </a>
        </div>
    <?php }
    else if($path['extension'] == 'pdf'){
        ?>
        <div style="text-align: center; color: #000; font-size: 22px "  >
            <a href="<?php echo Router::url('/', true) . 'img/' . $file['document']; ?>" target="_blank">Click here to see</a>
        </div>
    <?php }
     ?>
    <div class="panel-heading">
        <h6 class="panel-title">
            <i class="icon-paragraph-right2"></i><?= __('You have already uploaded a document. If you want to update document please browse and save again') ?>
        </h6>
    </div>
    <?php } ?>
    <?php if(empty($file)): ?>
    <div class="row panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">
                <i class="icon-paragraph-right2"></i><?= __('Upload scan document') ?>
            </h6>
        </div>
        <?php endif; ?>
        <?= $this->Form->create(null, ['class' => 'form-horizontal', 'role' => 'form', 'type' => 'file']); ?>

        <div class="panel-body col-sm-12">
            <?php
            echo $this->Form->input('document', ['type' => 'file', 'data-preview-container' => '#profile_image_preview']);
            ?>
        </div>
        <div class="col-sm-6 form-actions text-right">
            <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
        </div>
    </div>
    <?= $this->Form->end() ?>
    <script type="text/javascript" src="<?php echo $this->request->webroot; ?>js/bootstrap/moment.js"></script>
    <script type="text/javascript" src="<?php echo $this->request->webroot; ?>js/bootstrap/collapse.js"></script>
    <script type="text/javascript" src="<?php echo $this->request->webroot; ?>js/bootstrap/transition.js"></script>
    <script>
        $('.dak_file_image').on('mouseenter', function () {
            $(this).trigger('click');
        });
    </script>