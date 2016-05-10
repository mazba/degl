<?php
use Cake\Core\Configure;

Configure::load('config_receive_file_registers', 'default');
use Cake\Routing\Router;

?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Resolutions'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Resolutions') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Resolutions'), ['action' => 'index']) ?> </li>

        <li class="active"><?=
            $this->Html->link(__('Details Resolutions'), ['action' => 'view', $receiveFileRegister->id
            ]) ?>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Letter No') ?></h6></div>
            <div class="panel-body"><?= h($receiveFileRegister->id) ?></div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Sender Name') ?></h6></div>
            <div class="panel-body"><?= h($receiveFileRegister->sender_name) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Office Name') ?></h6></div>
            <div class="panel-body"><?= h($receiveFileRegister->office_name) ?></div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Address') ?></h6></div>
            <div class="panel-body"><?= h($receiveFileRegister->address) ?></div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Subject') ?></h6></div>
            <div class="panel-body"><?= h($receiveFileRegister->subject) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Date') ?></h6></div>
            <div class="panel-body"><?= date("d-M-Y", $receiveFileRegister->date) ?></div>
        </div>


        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Files') ?></h6></div>
            <div class="panel-body">
                <?php
                if (sizeof($files) > 0) {
                    foreach ($files as $file) {
                        ?>
                        <a data-lightbox="dak-file" href="<?php echo Router::url('/', true) . 'files/receive_files/' . $file['file_path']; ?>"><img style="width:200px; height:150px" src="<?php echo Router::url('/', true) . 'files/receive_files/' . $file['file_path']; ?>"></a>
                        <?php
                    }
                }
                ?>
            </div>
        </div>

    </div>


</div>