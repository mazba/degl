<?php
use Cake\Core\Configure;

Configure::load('config_receive_file_registers', 'default');
use Cake\Routing\Router;

?>

<div class="panel panel-success">
    <div class="panel-heading">
        <h6 class="panel-title"><i class="icon-stack"></i><?= __('File Details') ?></h6>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-info">
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?= __('Subject') ?></label>
                                <input value="<?= h($my_file->subject) ?>" class="form-control" type="text" disabled>

                            </div>
                        </div>
                        <?php if (isset($my_file->sender_name)) { ?>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><?= __('Sender Name') ?></label>
                                    <input value="<?= h($my_file->sender_name) ?>" class="form-control" type="text"
                                           disabled>

                                </div>
                            </div>
                        <?php } ?>


                        <?php if (isset($my_file->project->name_en)) { ?>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><?= __('Project') ?></label>
                                    <input value="<?= h($my_file->project->name_bn) ?>" class="form-control" type="text"
                                           disabled>

                                </div>
                            </div>
                        <?php } ?>


                        <?php if (isset($my_file->scheme->name_en)) { ?>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><?= __('Scheme') ?></label>
                                    <input value="<?= h($my_file->scheme->name_bn) ?>" class="form-control" type="text"
                                           disabled>

                                </div>
                            </div>

                        <?php } ?>

                        <?php if (!empty($my_file->work_description)) { ?>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><?= __('Work Description') ?></label>

                                    <div class="well" contenteditable="false">
                                        <?= htmlspecialchars_decode($my_file->work_description) ?>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>

                        <?php if (!empty($attach)) { ?>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label style="display: block"><?= __('Attachment') ?></label>
                                    <?php foreach ($attach as $data) {
                                        $path = pathinfo($data['file_path']);
                                        if ($path['extension'] == 'jpg' || $path['extension'] == 'JPG' || $path['extension'] == 'png' || $path['extension'] == 'PNG') {

                                            ?>
                                            <div class="single_attach_file" style="float: left">
                                                <a data-lightbox="dak_file_image"
                                                   href="<?php echo Router::url('/', true) . 'files/receive_files/' . $data['file_path']; ?>">
                                                    <img width="100" height="80"
                                                         src="<?php echo Router::url('/', true) . 'files/receive_files/' . $data['file_path']; ?>">
                                                </a><br>
                                                <br>
                                                <?php
                                                $path = $data['file_path'];
                                                echo $this->Html->link('<button class="btn btn-sm btn-info" type="button">Download</button>', ['controller' => 'MyFiles', 'action' => 'download_file', $path], ['target' => '_blank','escape' => false]);
                                                ?>
                                            </div>
                                            <?php
                                        } else { ?>
                                            <a target="_blank"
                                               href="<?php echo Router::url('/', true) . 'files/receive_files/' . $data['file_path']; ?>">
                                                <?php echo $data['file_path']; ?>
                                            </a>
                                        <?php }

                                    } ?>
                                </div>
                            </div>
                        <?php } ?>


                    </div>
                </div>

                <div class="panel panel-info">
                    <div class="panel-body">
                        <div class="form-group">
                            <label style="display: block"><?= __('Reply attached files') ?></label>
                            <?php foreach ($reply as $data) {

                                $path = pathinfo($data['file_path']);
                                if ($path['extension'] == 'jpg' || $path['extension'] == 'JPG' || $path['extension'] == 'png' || $path['extension'] == 'PNG') {

                                    ?>
                                    <a data-lightbox="dak_file_image"
                                       href="<?php echo Router::url('/', true) . 'files/receive_files/' . $data['file_path']; ?>">
                                        <img width="100" height="80"
                                             src="<?php echo Router::url('/', true) . 'files/receive_files/' . $data['file_path']; ?>">
                                    </a>
                                    <?php
                                } else { ?>
                                    <a target="_blank"
                                       href="<?php echo Router::url('/', true) . 'files/receive_files/' . $data['file_path']; ?>">
                                        <?php echo $data['file_path']; ?>
                                    </a>
                                <?php }
                            } ?>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-4 block-inner">
            </div>
            <div class="col-md-4">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h6 class="panel-title">
                            History
                        </h6>
                    </div>
                    <div class="panel-body" style="height: 330px; overflow: scroll;">
                        <?php if (!empty($history)):
                            $i = 0;
                            for ($i; $i < count($history); $i++):
                                ?>
                                <div class="block task task-high">
                                    <div class="row with-padding">
                                        <div class="col-sm-12">
                                            <div class="task-description">
                                                <?php if ($history[$i]['sender_id']) { ?>
                                                    <p><?= "From: " . $history[$i]['users']['name_en'] . " (" . $history[$i]['designations']['name_en'] . ")" ?></p>
                                                <?php } else { ?>
                                                    <p><?= "From: " . $history[$i]['sender_name'] ?></p>
                                                <?php } ?>
                                                <p><?= "To: " . $history[$i]['recipient_name'] ?></p>

                                                <p><?= "Date: " . date("Y-m-d H:s a", $history[$i]['created_date']) ?></p>

                                                <p><?= "Subject: " . $history[$i]['subject'] ?></p>
                                                <?php if (!empty($history[$i]['message_text'])): ?>
                                                    <p><?= "Message: " . $history[$i]['message_text'] ?></p>
                                                <?php endif; ?>

                                            </div>
                                        </div>

                                    </div>

                                </div>
                            <?php endfor; endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

