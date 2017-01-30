<?php
use Cake\Routing\Router;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Vehicle Hire Letter Registers'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Vehicle Hire Letter Register') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Vehicle Hire Letter Registers'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1) {
            ?>
            <li><?= $this->Html->link(__('New Vehicle Hire Letter Register'), ['action' => 'add']) ?></li>
            <?php
        }
        ?>
        <li class="active"><?=
            $this->Html->link(__('Details Vehicle Hire Letter Register'), ['action' => 'view', $vehicleHireLetterRegister->id
            ]) ?>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12">

        <table class="table">
            <tr>
                <td width="80%"><b><?= __('Latter No: ') ?></b><?= h($vehicleHireLetterRegister->letter_no) ?></td>
                <td>
                    <b><?= __('Receive Date') ?></b> <?= $this->System->display_date($vehicleHireLetterRegister->receive_date) ?>
                </td>
            </tr>
            <tr>
                <td><b><?= __('Sharok No: ') ?></b><?= h($vehicleHireLetterRegister->sharok_no) ?> </td>
            </tr>
            <tr>
                <td><b><?= __('Subject: ') ?></b><?= h($vehicleHireLetterRegister->subject) ?> </td>
            </tr>
            <tr>
                <td><b><?= __('Work Name: ') ?></b> <?= $vehicleHireLetterRegister['scheme']['name_en'] ?> </td>
            </tr>

            <tr>
                <td>
                    <b><?= __('From: ') ?></b> <?= h($vehicleHireLetterRegister->receive_from) ?>
                </td>
            </tr>
            <tr>
                <td>
                    <b><?= __('Remarks') ?></b> <?= $this->Text->autoParagraph(h($vehicleHireLetterRegister->remarks)); ?>
                </td>
            </tr>

        </table>

        <div class="col-sm-6" style="margin: 40px 0;padding-top: 10px">
            <label><b style="color: #0000cc"><?= __('Files') ?></b></label>

            <div>
                <?php
                if (sizeof($files) > 0) {
                    foreach ($files as $file) {
                        $path = pathinfo($file['file_path']);
                        if ($path['extension'] == 'jpg' || $path['extension'] == 'png' || $path['extension'] == 'JPG' || $path['extension'] == 'PNG') {

                            ?>
                            <a data-lightbox="dak_file_image"
                               href="<?php echo Router::url('/', true) . 'files/receive_files/' . $file['file_path']; ?>">
                                <img width="100" height="80" class="dak_file_image"
                                     src="<?php echo Router::url('/', true) . 'files/receive_files/' . $file['file_path']; ?>">
                            </a>
                            <?php
                        } else { ?>
                            <a target="_blank"
                               href="<?php echo Router::url('/', true) . 'files/receive_files/' . $file['file_path']; ?>">
                                <?php echo $file['file_path']; ?>
                            </a><br>
                        <?php } ?>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
<script>
    $('.dak_file_image').on('mouseenter', function(){
        $(this).trigger('click');
    });
</script>
<style>
    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
        border: 0px solid;
    }
</style>