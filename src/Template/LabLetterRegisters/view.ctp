<?php
use Cake\Routing\Router;

?>

<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Lab Letter Registers'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Lab Letter Register') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Lab Letter Registers'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1) {
            ?>
            <li><?= $this->Html->link(__('New Lab Letter Register'), ['action' => 'add']) ?></li>
            <?php
        }
        ?>
        <li class="active"><?=
            $this->Html->link(__('Details Lab Letter Register'), ['action' => 'view', $labLetterRegister->id
            ]) ?>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12">

        <table class="table">
            <tr>
                <td colspan="2"><h6><?= $labLetterRegister->office->name_bn ?></h6></td>
            </tr>
            <tr>
                <td width="80%"><b><?= __('Letter No: ') ?></b><?= h($labLetterRegister->letter_no) ?></td>
                <td><b><?= __('Received Date: ') ?></b><?=
                    $this->System->display_date($labLetterRegister->receive_date)
                    ?></td>
            </tr>
            <tr>
                <td colspan="2"><b><?= __('Subject: ') ?></b><?= h($labLetterRegister->subject) ?></td>
            </tr>

            <tr>
                <td colspan="2"><b><?= __('Work Name: ') ?></b><?=
                    $labLetterRegister->has('scheme') ?
                        $this->Html->link($labLetterRegister->scheme
                            ->name_en, ['controller' => 'Schemes',
                            'action' => 'view', $labLetterRegister->scheme
                                ->id]) : '' ?></td>
            </tr>

            <tr>
                <td colspan="2"><b><?= __('Received From: ') ?></b><?= h($labLetterRegister->received_from) ?></td>

            </tr>

            <tr>
                <td colspan="2"><b><?= __('Letter Date: ') ?></b><?=
                    $this->System->display_date($labLetterRegister->letter_date)
                    ?></td>
            </tr>
        </table>

        <div class="col-sm-12" style="margin:40px 0">
            <label for="">Files</label>
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

<div class="row">
    <div class="col-md-12" style="text-align: center;">
        <div style="border-top: 1px solid #ddd;padding: 40px 0">
            <a href="<?php echo $this->Url->build(["controller" => "AddNewLabTests", "action" => "view", $labLetterRegister->id]); ?>">
                <button class="btn btn-default" type="button">
                    <i class="text-primary icon-upload3"></i>
                    Report Delivery
                </button>
            </a>
            <a href="<?php echo $this->Url->build(["controller" => "AddNewLabTests", "action" => "report", $labLetterRegister->id]); ?>">
                <button class="btn btn-default" type="button">
                    <i class="text-primary icon-file"></i>
                    View Report
                </button>
            </a>
            <a href="<?php echo $this->Url->build(["controller" => "AddNewLabTests", "action" => "add", $labLetterRegister->id]); ?>">
                <button class="btn btn-default" type="button">
                    <i class="text-danger icon-lab"></i>
                    Add Lab Test
                </button>
            </a>
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
        border: 0px solid
    }
</style>