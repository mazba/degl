<?php use Cake\Routing\Router; ?>

<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Lab Letter Registers'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Lab Letter Register') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Lab Letter Registers'), ['controller' => 'LabLetterRegisters', 'action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1) {
            ?>
            <li><?= $this->Html->link(__('New Lab Letter Register'), ['controller' => 'LabLetterRegisters', 'action' => 'add']) ?></li>
            <?php
        }
        ?>
        <li><?=
            $this->Html->link(__('Details Lab Letter Registert'), ['controller' => 'LabLetterRegisters', 'action' => 'view', $labLetterRegister->id
            ]) ?>
        </li>
        <li class="active"><?=
            $this->Html->link(__('Report Delivery'), ['action' => 'view', $labLetterRegister->id
            ]) ?>
        </li>

    </ul>
</div>

<div class="panel panel-default">
    <div class="panel-heading"><h6
            class="panel-title"><?= __('Report Delivery') ?></h6></div>
    <div class="panel-body">
        <table class="table table-bordered">
            <tr>
                <th><?= __('Sl. No.') ?></th>
                <th><?= __('Name of Test') ?></th>
                <th><?= __('Financial Year') ?></th>
                <th><?= __('Rate') ?></th>
                <th><?= __('N0. of Test') ?></th>
                <th><?= __('Upload Test Report') ?></th>
                <th><?= __('Is Ok ?') ?></th>
            </tr>
            <form class="form-horizontal"
                  action="<?= $this->Url->build(('/'), true); ?>add_new_lab_tests/edit/<?= $labLetterRegister->id ?>"
                  role="form" accept-charset="utf-8" method="post" enctype="multipart/form-data">
                <?php $i = 1;
                foreach ($tests as $test): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= $test->lab_test_short_name ?></td>
                        <td><?= $test->financial_year ?></td>
                        <td><?= $test->rate ?></td>
                        <td><?= $test->number_of_test ?></td>
                        <td>
                            <?php if (empty($test->file_path)) {
                                echo $this->Form->input('report[' . $test->id . '][]', ['label' => '', 'type' => 'file', 'multiple' => 'multiple']) ?>
                                <input type="hidden" name="test_id[]" value="<?= $test->id ?>">
                            <?php } else {
                                $path = pathinfo($test->file_path);
                                if ($path['extension'] == 'jpg' || $path['extension'] == 'png' || $path['extension'] == 'JPG' || $path['extension'] == 'PNG') {

                                    ?>
                                    <a data-lightbox="dak_file_image"
                                       href="<?php echo Router::url('/', true) . 'files/lab_test_files/' . $test->file_path; ?>">
                                        <img width="100" height="80" class="dak_file_image"
                                             src="<?php echo Router::url('/', true) . 'files/lab_test_files/' . $test->file_path; ?>">
                                    </a>
                                    <?php
                                } else { ?>
                                    <a target="_blank"
                                       href="<?php echo Router::url('/', true) . 'files/lab_test_files/' . $test->file_path; ?>">
                                        <?php echo $test->file_path; ?>
                                    </a><br>
                                <?php }
                            }
                            ?>
                        </td>
                        <td>
                            <?= $this->Form->input('is_ok[]', ['label' => '', 'options' => [0 => 'Not Ok', 1 => 'Ok'], 'default' => $test->is_ok]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <div class="col-sm-12 form-actions text-right" style="padding-right: 0">
                    <input type="submit" value="Update" class="btn btn-primary">
                </div>
            </form>
        </table>
    </div>
</div>