<?php
use Cake\Core\Configure;
Configure::load('config_receive_file_registers', 'default');
use Cake\Routing\Router;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Receive File Registers'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Receive File Register') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Receive File Registers'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Receive File Register'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>

        <li class="active"><?=
            $this->Html->link(__('Details Receive File Register'), ['action' => 'view', $receiveFileRegister->id
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
            <div class="panel-body"><?= date("d-M-Y",$receiveFileRegister->date) ?></div>
        </div>


        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Files') ?></h6></div>
            <?php
            if(sizeof($files)>0)
            {
                foreach($files as $file)
                {
                    ?>
                    <div class="panel-body"><a href="<?php echo Router::url('/',true).'files/receive_files/'.$file['file_path']; ?>"><?php echo $file['file_path']; ?></a></div>
                    <?php
                }
            }
            ?>
        </div>

    </div>


</div>