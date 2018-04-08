<?php
use Cake\Core\Configure;
use Cake\Routing\Router;
$contractor_type = Configure::read('contractor_type');
?>
<style>
    .report-table {
        overflow: scroll;
        overflow-y: hidden;
    }

    .dropdown {
        cursor: pointer;
    }

</style>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Nothi Registers'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Nothi') ?> </li>
    </ul>
</div>
<script type="text/javascript"
        src="http://maps.google.com/maps/api/js?key=AIzaSyDm0DLjHrJ0j56M4Od2ch81kP0wIIhDpzk"></script>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Nothi'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1) {
            ?>
            <li><?= $this->Html->link(__('New Nothi'), ['action' => 'add']) ?></li>
            <?php
        }
        ?>
        <?php
        if ($user_roles['edit'] == 1) {
            ?>
            <li><?= $this->Html->link(__('Edit Nothi'), ['action' => 'edit', $nothiRegister->id]) ?></li>
            <?php
        }
        ?>
        <?php
        if ($user_roles['delete'] == 1) {
            ?>
            <li><?=
                $this->Form->postLink(__('Delete Nothi'), ['action' => 'delete', $nothiRegister->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $nothiRegister->id)]) ?>
            </li>
            <?php
        }
        ?>

        <li class="active"><?=
            $this->Html->link(__('Details Nothi'), ['action' => 'view', $nothiRegister->id
            ]) ?>
        </li>
    </ul>
</div>
<div class="row">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h6 class="panel-title"><i class="icon-table2"></i><?= __('Nothi Details') ?></h6>
        </div>
        <div class="panel-body">
            <div class="col-md-12">
                <table class="table table-striped">
                    <tbody>
                    <?php if ($nothiRegister->parent_id) { ?>
                        <tr>
                            <th><?= __('Nothi') ?> :</th>
                            <td>
                                <?= $nothiRegister->nothi_register['nothi_no'] ?>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <th><?= __('Office') ?> :</th>
                        <td><?=
                            $nothiRegister->has('office') ?
                                $this->Html->link($nothiRegister->office
                                    ->name_en, ['controller' => 'Offices',
                                    'action' => 'view', $nothiRegister->office
                                        ->id]) : '' ?>
                        </td>
                    </tr>
                    <tr>
                        <th><?= __('Nothi Description') ?> :</th>
                        <td>
                            <?= h($nothiRegister->nothi_description) ?>
                        </td>
                    </tr>
                    <tr>
                        <th><?= __('Nothi No') ?> :</th>
                        <td>
                            <?= h($nothiRegister->nothi_no) ?>
                        </td>
                    </tr>


                    <tr>
                        <th><?= __('Nothi Date') ?> :</th>
                        <td>
                            <?= $this->System->display_date($nothiRegister->nothi_date) ?>
                        </td>
                    </tr>
                    <tr>
                        <th><?= __('Status') ?> :</th>
                        <td>
                            <?php
                            if ($nothiRegister->status == 1) {
                                ?>
                                <div class="panel-body"><?= __('Active') ?></div>
                                <?php
                            } elseif ($nothiRegister->status == 0) {
                                ?>
                                <div class="panel-body"><?= __('In-Active') ?></div>
                                <?php
                            } else {
                                ?>
                                <div class="panel-body"><?php echo $nothiRegister->status; ?></div>
                                <?php

                            }
                            ?>
                        </td>
                    </tr>
                    </tbody>
                </table>


            </div>
        </div>

    </div>
</div>

<?php if (isset($nothiNothiAssigns['scheme'])) { ?>
    <br/>
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="col-md-7">
                    <h6 class="panel-title"><i class="icon-table2"></i>Scheme Details</h6>
                </div>
                <div class="col-md-5">
                    <a href=""> <span class="label label-danger">Lab Bills </span></a>
                    <a href=""> <span class="label label-info"> Mechanical Bills</span></a>
                    <a href=""> <span class="label label-success"> Purto Bills</span></a>
                    <a target="_blank"
                       href="<?= $this->Url->build(('/schemes/edit/' . $nothiNothiAssigns['scheme']['id']), true); ?>">
                        <span class="label label-danger">Edit</span></a>

                    <span class="dropdown label label-success">
                        <span id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                         Scheme Progress
                            <span class="caret"></span>
                        </span>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li><a target="_blank"
                                   href="<?= $this->Url->build(('/scheme_progresses/view/' . $nothiNothiAssigns['scheme']['id']), true); ?>">Progress
                                    Report</a></li>
                            <li><a href="#" data-toggle="modal" data-target="#myModal">Set progresses</a></li>
                        </ul>
                    </span>


                </div>

            </div>
            <div class="panel-body">
                <div class="col-md-12 report-table">
                    <table class="table table-striped table-responsive table-hover">
                        <thead>
                        <tr>
                            <td><b>Upazila Name</b></td>
                            <td><b>Category</b></td>
                            <td><b>Package No</b></td>
                            <td><b>Scheme Name</b></td>
                            <td><b>Financial Year</b></td>
                            <td><b>Contract Amount</b></td>
                            <td><b>Physical Progress</b></td>
                            <td><b>Work Order Date</b></td>
                            <td><b>Proposed Start Date</b></td>
                            <td><b>Actual Start Date</b></td>
                            <td><b>Completion Date</b></td>
                            <td><b>Actual Complete Date</b></td>
                            <td><b>Payment (Road)</b></td>
                            <td><b>Payment (Structure)</b></td>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td><?= $nothiNothiAssigns['scheme']['upazila']['name_en']; ?></td>
                            <td><?= $nothiNothiAssigns['scheme']['category_name']; ?></td>
                            <td><?= $nothiNothiAssigns['scheme']['package']['name_bn'] ?></td>
                            <td><?= $nothiNothiAssigns['scheme']['name_en']; ?></td>
                            <td><?= $nothiNothiAssigns['scheme']['financial_year_estimate']['name']; ?></td>
                            <td><?= $nothiNothiAssigns['scheme']['contract_amount']; ?></td>
                            <td><?= $nothiNothiAssigns['scheme']['scheme_progresses'] ? $nothiNothiAssigns['scheme']['scheme_progresses'][0]['progress_value'] . '%' : '0%'; ?></td>
                            <td><?= date('d-m-Y', $nothiNothiAssigns['scheme']['work_order_date']); ?></td>
                            <td><?= date('d-m-Y', $nothiNothiAssigns['scheme']['proposed_start_date']); ?></td>
                            <td><?= date('d-m-Y', $nothiNothiAssigns['scheme']['actual_start_date']); ?></td>
                            <td><?= date('d-m-Y', $nothiNothiAssigns['scheme']['completion_date']); ?></td>
                            <td><?= date('d-m-Y', $nothiNothiAssigns['scheme']['actual_complete_date']); ?></td>
                            <td><?= $nothiNothiAssigns['scheme']['payment_road']; ?></td>
                            <td><?= $nothiNothiAssigns['scheme']['payment_structure']; ?></td>

                        </tr>

                        </tbody>
                    </table>
                </div>

            </div>

        </div>

    </div>


<?php } ?>


<?php if (isset($employee_details) && !empty($employee_details)) { ?>
    <br/>
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="col-md-7">
                    <h6 class="panel-title"><i class="icon-table2"></i>Employee List</h6>
                </div>

            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    <table class="table table-striped table-responsive table-hover">
                        <thead>
                        <tr>
                            <th><?= __('id') ?></th>
                            <th><?= __('office') ?></th>
                            <th><?= __('designation') ?></th>
                            <th><?= __('NAME_EN') ?></th>
                            <th><?= __('NAME_BN') ?></th>
                            <?php
                            if (($user_roles['view'] == 1) || ($user_roles['edit'] == 1)) {
                                ?>
                                <th class="actions"><?= __('Actions') ?></th>
                                <?php
                            }
                            ?>

                        </tr>
                        </thead>

                        <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($employee_details as $row): ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td><?= $row['offices']['name_bn']; ?></td>
                                <td><?= $row['designations']['name_bn'] ?></td>
                                <td><?= $row['employees']['name_en']; ?></td>
                                <td><?= $row['employees']['name_bn']; ?></td>
                                <td class="actions">
                                    <?php
                                    if ($user_roles['view'] == 1) {
                                        echo $this->Html->link('<button class="btn btn-primary btn-icon" type="button"><i class="icon-newspaper"></i></button>', ['controller' => 'Employees', 'action' => 'view', $row['employees']['id']
                                            , '_full' => true], ['escapeTitle' => false, 'target' => '_blank', 'title' => 'Details']);
                                    }

                                    ?>
                                    <?php
                                    if ($user_roles['edit'] == 1) {
                                        echo $this->Html->link('<button class="btn btn-info btn-icon" type="button"><i class="icon-pencil3"></i></button>', ['controller' => 'Employees', 'action' => 'edit', $row['employees']['id']
                                        ], ['escapeTitle' => false, 'target' => '_blank', 'title' => 'edit']);
                                    }
                                    ?>

                                    <?php
                                    if ($user_roles['delete'] == 1) {
                                        echo $this->Html->link('<button class="btn btn-danger btn-icon" type="button"><i class="icon-remove2"></i></button>', ['controller' => 'Employees', 'action' => 'delete', $row['employees']['id']
                                        ], ['escapeTitle' => false, 'title' => 'delete', 'confirm' => ['Are you sure to delete?']]);
                                    }
                                    ?>
                                </td>

                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>

    </div>


<?php } ?>

<!--     contractors -->
<?php //if (isset($contractor_details) && !empty($contractor_details)) { ?>
<!--    <br/>-->
<!--    <div class="row">-->
<!--        <div class="panel panel-default">-->
<!--            <div class="panel-heading">-->
<!--                <div class="col-md-7">-->
<!--                    <h6 class="panel-title"><i class="icon-table2"></i>Contractor List</h6>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="panel-body">-->
<!--                <div class="col-md-12">-->
<!--                    <table class="table table-striped table-responsive table-hover">-->
<!--                        <thead>-->
<!--                        <tr>-->
<!--                            <th>--><?php //echo __('ক্রম') ?><!--</th>-->
<!--                            <th>--><?php //echo __('ঠিকাদার ধরণ') ?><!--</th>-->
<!--                            <th>--><?php //echo __('ঠিকাদার টাইটেল') ?><!--</th>-->
<!--                            <th>--><?php //echo __('কন্টাক্ট ব্যক্তি') ?><!--</th>-->
<!--                            <th>--><?php //echo __('মোবাইল') ?><!--</th>-->
<!--                        </tr>-->
<!--                        </thead>-->
<!--                        <tbody>-->
<!--                        --><?php //$i = 1; ?>
<!--                        --><?php //foreach ($contractor_details as $contractor_detail): ?>
<!--                            <tr>-->
<!--                                <td>--><?php //echo $i; ?><!--</td>-->
<!--                                <td>--><?php //echo $contractor_detail['contractor_type']?$contractor_type[$contractor_detail['contractor_type']]:''; ?><!--</td>-->
<!--                                <td>--><?php //echo $contractor_detail['contractor_title'] ?><!--</td>-->
<!--                                <td>--><?php //echo $contractor_detail['contact_person_name']; ?><!--</td>-->
<!--                                <td>--><?php //echo $contractor_detail['mobile']; ?><!--</td>-->
<!--                            </tr>-->
<!--                            --><?php //$i++; ?>
<!--                        --><?php //endforeach; ?>
<!--                        </tbody>-->
<!--                    </table>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<?php //} ?>


<?php if (isset($asset_list[0]['asset']) && !empty($asset_list[0]['asset'])) { ?>
    <br/>
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="col-md-7">
                    <h6 class="panel-title"><i class="icon-table2"></i>Asset List</h6>
                </div>

            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    <table class="table table-striped table-responsive table-hover">
                        <thead>
                        <tr>
                            <th><?= __('id') ?></th>
                            <th><?= __('name') ?></th>
                            <th><?= __('asset_code') ?></th>
                            <th><?= __('quantity') ?></th>

                            <th class="actions"><?= __('Actions') ?></th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($asset_list as $asset) {
                            ?>
                            <tr>
                                <td><?= $this->Number->format($asset->asset->id) ?></td>
                                <td><?= h($asset->asset->name) ?></td>
                                <td><?= h($asset->asset->asset_code) ?></td>
                                <td><?= $this->Number->format($asset->asset->quantity) ?></td>
                                <td class="actions">
                                    <?php

                                    echo $this->Html->link('<button class="btn btn-primary btn-icon" type="button"><i class="icon-newspaper"></i></button>', ['controller' => 'Assets', 'action' => 'view', $asset->asset->id
                                        , '_full' => true], ['escapeTitle' => false, 'title' => 'Details']);


                                    ?>
                                    <?php

                                    echo $this->Html->link('<button class="btn btn-info btn-icon" type="button"><i class="icon-pencil3"></i></button>', ['action' => 'edit', $asset->asset->id
                                    ], ['escapeTitle' => false, 'title' => 'edit']);

                                    ?>

                                </td>
                            </tr>

                        <?php } ?>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>

    </div>


<?php } ?>

<div class="row">
    <?php if ($nothi_related_project) { ?>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title">
                        <i class="icon-file"></i>
                        <?= __('Nothi Related Projects') ?>
                    </h6>
                </div>
                <div id="projects">

                </div>
            </div>
        </div>
    <?php } ?>
    <?php if ($nothi_related_scheme) { ?>

        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title">
                        <i class="icon-file"></i>
                        <?= __('Nothi Related Schemes') ?>
                    </h6>
                </div>
                <div id="schemes">

                </div>
            </div>
        </div>    <?php } ?>


    <?php $print = 0; $sn = 0; if ($nothi_related_dake_file): ?>
        <?php foreach($querys_data as $key => $querys_datum):?>
            <div class="panel-body">
                <div id="PrintArea-<?=++$print?>" class="find-id" style="margin-top: 10px; padding: 5px; margin-bottom: 10px">
                    <button class="btn btn-info pull-right print-button" id="print_button" ><?= __('Print') ?></button>
                    <div class="col-md-12">
                        <p><?= $this->Common->EngToBanglaNum(++$sn) ?>| <b> <?= __('বিষয়:') ?> </b><?= $querys_datum->subject ?></p>
                        <p>
                            <b><?= __('সূত্র:') ?> </b>
                            &nbsp;&nbsp;<span><?= __('প্রেরকের নামঃ') ?></span>&nbsp;<?= $querys_datum->sender_name ?>
                            &nbsp;&nbsp;<span><?= __('অফিসের নামঃ') ?></span>&nbsp;<?= $querys_datum->sender_office_name ?>
                            &nbsp;&nbsp;<span><?= __('স্মারক নং-') ?></span>&nbsp;<?= $querys_datum->sarok_no ?>
                            &nbsp;&nbsp;<span><?= __('তারিখঃ') ?></span>&nbsp;<?= EngToBanglaNum(date('d/m/y',$querys_datum->letter_date)) ?>
                        </p>
                        <p>
                            <?= $querys_datum->letter_description ?>
                        </p>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <?php foreach($querys_datum['letter_approvals'] as $signature):?>
                            <div class="col-xs-2 text-center">
                                <img src="<?= $this->request->webroot.'img'.DS.'signature'.DS.$signature['user']['signature'] ?>" alt="" height="75px">
                                <p><?= date('d-m-y',$signature['created_date'])?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="row">
                        <div class="col-md-1">
                            <?php if($querys_datum['file']['file_path']):?>
                                <?php $path = pathinfo($querys_datum['file']['file_path']) ;
                                if ($path['extension'] == 'jpg' || $path['extension'] == 'png' || $path['extension'] == 'JPG' || $path['extension'] == 'PNG'): ?>
                                    <a data-lightbox="dak_file_image"
                                       href="<?php echo Router::url('/', true) . 'files/receive_files/' . $querys_datum['file']['file_path']; ?>">
                                        <img width="100" height="80" class="dak_file_image"
                                             src="<?php echo Router::url('/', true) . 'files/receive_files/' . $querys_datum['file']['file_path']; ?>">
                                    </a>
                                <?php else: ?>
                                    <a target="_blank"
                                       href="<?php echo Router::url('/', true) . 'files/receive_files/' . $querys_datum['file']['file_path']; ?>">
                                        <?php echo $data['file_path']; ?>
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-4" style="margin-top: 1em">
                            <a class="btn btn-success modal-letter" data-action="<?= $querys_datum['id'] ?>" data-toggle="modal" data-target="#NewLetter"><?= __('জারীকৃত পত্র') ?></a>
                            <a class="btn btn-danger" href="<?= $this->Url->build(['controller' => 'MyFiles', 'action' =>'view', $querys_datum['message_register']['id']])?>" ><?= __('বিস্তারিত') ?></a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    <?php if(!empty($letterIssueRegisters)): ?>
        <?php foreach($letterIssueRegisters as $key => $letterIssueRegister):?>
            <div class="panel-body">
                <div id="PrintArea-<?=++$print?>" class="find-id" style="margin-top: 10px; padding: 5px; margin-bottom: 10px">
                    <button class="btn btn-info pull-right print-button" id="print_button" ><?= __('Print') ?></button>
                    <div class="col-md-12">
                        <p><?= $this->Common->EngToBanglaNum(++$sn) ?>| <b> <?= __('বিষয়:') ?> </b><?= $letterIssueRegister['subject'] ?></p>
                        <p>
                            <b><?= __('সূত্র:') ?> </b>
                            <!--&nbsp;&nbsp;<span><?php /*echo __('প্রেরকের নামঃ') */?></span>&nbsp;<?php /*echo $letterIssueRegister->sender_name */?>
                            &nbsp;&nbsp;<span><?php /*echo __('অফিসের নামঃ') */?></span>&nbsp;--><?php /*echo $letterIssueRegister->sender_office_name */?>
                            &nbsp;&nbsp;<span><?= __('স্মারক নং-') ?></span>&nbsp;<?= $letterIssueRegister['sarok_no'] ?>
                            &nbsp;&nbsp;<span><?= __('তারিখঃ') ?></span>&nbsp;<?= EngToBanglaNum(date('d/m/y',$letterIssueRegister['issue_date'])) ?>
                        </p>
                        <p>
                            <?= $letterIssueRegister['letter_summery'] ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if ($nothi_related_lab_bill) { ?>

        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title">
                        <i class="icon-file"></i>
                        <?= __('Nothi Related Lab Bills') ?>
                    </h6>
                </div>
                <div id="lab_bills">

                </div>
            </div>
        </div>
    <?php } ?>
    <?php if ($nothi_related_hire_charge) { ?>

        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title">
                        <i class="icon-file"></i>
                        <?= __('Nothi Related Mechanical Bills') ?>
                    </h6>
                </div>
                <div id="mechanical_bills">

                </div>
            </div>
        </div>
    <?php } ?>

    <?php if ($nothi_related_purto_bill) { ?>

        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title">
                        <i class="icon-file"></i>
                        <?= __('Nothi Related Purto Bills') ?>
                    </h6>
                </div>
                <div id="purto_bills">

                </div>
            </div>
        </div>
    <?php } ?>

    <?php if ($nothi_related_allotment_registe) { ?>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title">
                        <i class="icon-file"></i>
                        <?= __('Nothi Related Allotments') ?>
                    </h6>
                </div>
                <div id="allotments">

                </div>
            </div>
        </div>
    <?php } ?>


</div>
<?php if (array_key_exists(0, $project_images) || array_key_exists(0, $project_videos)) { ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-table2"></i><?= 'Investigation Details' ?></h6>
                </div>
                <div class="panel-body">
                    <?php if (array_key_exists(0, $project_images)) { ?>
                        <table class="table table-striped table-responsive table-hover">
                            <tr>
                                <td width="25%">Image</td>
                                <td width="35%">Location</td>
                                <td width="10%">Capture Time</td>
                                <td width="15%">Capture Date</td>
                                <td width="15%">Capture By</td>
                            </tr>

                            <?php
                            foreach ($project_images as $project_image) {
                                ?>
                                <tr>
                                    <td width="25%"><img style=" height: 100px;"
                                                         src="<?= $this->request->webroot . 'api/images/' . $project_image['image_path']; ?>"
                                                         alt=""/>
                                    </td>

                                    <td width="35%">
                                        <div style=" height: 100px;" class="map"
                                             data-lat="<?= $project_image['latitude'] ?>"
                                             data-lon="<?= $project_image['longitude'] ?>">

                                        </div>

                                    </td>
                                    <td>
                                        <?= date('h:i:s A', $project_image['created_date']) ?>
                                    </td>
                                    <td>
                                        <?= date('d/m/Y', $project_image['created_date']) ?>

                                    </td>
                                    <td>
                                        <?= $project_image['users']['name_bn'] ?>

                                    </td>

                                </tr>

                                <?php
                            } ?>

                        </table>
                        <br/>
                        <hr/>
                        <?php
                    }
                    if (isset($project_videos)) { ?>
                        <table class="table table-striped table-responsive table-hover">
                            <tr>
                                <td width="25%">Video</td>
                                <td width="35%">Location</td>
                                <td width="10%">Capture Time</td>
                                <td width="15%">Capture Date</td>
                                <td width="15%">Capture By</td>
                            </tr>

                            <?php foreach ($project_videos as $project_video) { ?>
                                <tr>
                                    <td>
                                        <video width="100%" height="100" controls="controls">
                                            <source
                                                    src="<?= $this->request->webroot . 'api/videos/' . $project_video['video_path']; ?>"
                                                    type="video/mp4">
                                        </video>
                                    </td>
                                    <td>
                                        <div style="height: 100px;" class="map"
                                             data-lat="<?= $project_video['latitude'] ?>"
                                             data-lon="<?= $project_video['longitude'] ?>"></div>
                                    </td>
                                    <td>
                                        <?= date('h:i:s A', $project_video['created_date']) ?>
                                    </td>

                                    <td><?= date('d/m/Y', $project_video['created_date']) ?> </td>
                                    <td>    <?= $project_video['users']['name_bn'] ?> </td>

                                </tr>
                            <?php } ?>
                        </table>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>


<script>
    $('.map').each(function (index, Element) {
        var latitude = parseFloat($(this).data('lat'));
        var longitude = parseFloat($(this).data('lon'));
        var latlng = new google.maps.LatLng(latitude, longitude);
        var myOptions =
            {
                zoom: 16,
                center: latlng,
                mapTypeId: google.maps.MapTypeId.HYBRID
            };
        var map = new google.maps.Map(Element, myOptions);

        var myMarker = new google.maps.Marker(
            {
                position: latlng,
                map: map,
                labelClass: "labels", // the CSS class for the label
                title: "The picture/video was taken here"
            });
    });

</script>

<script type="text/javascript">
    $(document).ready(function () {
        //Schemes
        if ( $( "#schemes" ).length ) {

            var url3 = "<?php echo $this->request->webroot; ?>NothiRegisters/ajax/get_schemes/<?= $nothiRegister->id; ?>";
            // prepare the data
            var source3 =
                {
                    dataType: "json",
                    dataFields: [
                        {name: 'name_bn', type: 'string'},
                        {name: 'scheme_code', type: 'string'},
                        {name: 'action', type: 'string'}
                    ],
                    id: 'id',
                    url: url3
                };

            var dataAdapter3 = new $.jqx.dataAdapter(source3);

            $("#schemes").jqxGrid(
                {
                    width: '100%',
                    source: dataAdapter3,
                    pageable: true,
                    filterable: true,
                    sortable: true,
                    showfilterrow: true,
                    columnsresize: true,
                    pagesize: 15,
                    pagesizeoptions: ['100', '200', '300', '500', '1000', '1500'],
//                selectionmode: 'checkbox',
                    altrows: true,
                    autoheight: true,


                    columns: [
                        {text: '<?= __('Name') ?>', dataField: 'name_bn', width: '70%'},
                        {text: '<?= __('Scheme Code') ?>', dataField: 'scheme_code', width: '22%'},
                        {text: '<?= __('Actions') ?>', cellsalign: 'center', dataField: 'action', width: '8%'}
                    ]
                });
        }

        if ( $( "#dak_files" ).length ) {

            var url = "<?php echo $this->request->webroot; ?>NothiRegisters/ajax/get_dak_file/<?= $nothiRegister->id; ?>";
            // prepare the data
            var source =
                {
                    dataType: "json",
                    dataFields: [
                        {name: 'id', type: 'int'},
                        {name: 'sender_name', type: 'string'},
                        {name: 'subject', type: 'string'},
                        {name: 'sender_office_name', type: 'string'},
                        {name: 'created_date', type: 'string'},
                        {name: 'action', type: 'string'}
                    ],
                    id: 'id',
                    url: url
                };

            var dataAdapter = new $.jqx.dataAdapter(source);

            $("#dak_files").jqxGrid(
                {
                    width: '100%',
                    source: dataAdapter,
                    pageable: true,
                    filterable: true,
                    sortable: true,
                    showfilterrow: true,
                    columnsresize: true,
                    pagesize: 15,
                    pagesizeoptions: ['100', '200', '300', '500', '1000', '1500'],
//                selectionmode: 'checkbox',
                    altrows: true,
                    autoheight: true,


                    columns: [
                        {text: '<?= __('Sender Name') ?>', dataField: 'sender_name', width: '20%'},
                        {text: '<?= __('Sender Office Name') ?>', dataField: 'sender_office_name', width: '22%'},
                        {text: '<?= __('Subject') ?>', dataField: 'subject', width: '40%'},
                        {text: '<?= __('Date') ?>', dataField: 'created_date', width: '10%'},
                        {text: '<?= __('Actions') ?>', cellsalign: 'center', dataField: 'action', width: '8%'}
                    ]
                });
        }

        //Lab Bills

        if ($("#lab_bills").length) {

            var url4 = "<?php echo $this->request->webroot; ?>NothiRegisters/ajax/get_lab_bills/<?= $nothiRegister->id; ?>";
            // prepare the data
            var source4 =
                {
                    dataType: "json",
                    dataFields: [
                        {name: 'title', type: 'string'},
                        {name: 'type', type: 'string'},
                        {name: 'total_amount', type: 'string'},
                        {name: 'net_payable', type: 'string'},
                        {name: 'action', type: 'string'}
                    ],
                    id: 'id',
                    url: url4
                };

            var dataAdapter4 = new $.jqx.dataAdapter(source4);

            $("#lab_bills").jqxGrid(
                {
                    width: '100%',
                    source: dataAdapter4,
                    pageable: true,
                    filterable: true,
                    sortable: true,
                    showfilterrow: true,
                    columnsresize: true,
                    pagesize: 15,
                    pagesizeoptions: ['100', '200', '300', '500', '1000', '1500'],
//                selectionmode: 'checkbox',
                    altrows: true,
                    autoheight: true,


                    columns: [
                        {text: '<?= __('Title') ?>', dataField: 'title', width: '40%'},
                        {text: '<?= __('Type') ?>', dataField: 'type', width: '10%'},
                        {text: '<?= __('Total Amount') ?>', dataField: 'total_amount', width: '21%'},
                        {text: '<?= __('Net Payable') ?>', dataField: 'net_payable', width: '21%'},
                        {text: '<?= __('Actions') ?>', cellsalign: 'center', dataField: 'action', width: '8%'}
                    ]
                });

        }


        //Mechanical Bills

        if ($("#mechanical_bills").length) {

            var url5 = "<?php echo $this->request->webroot; ?>NothiRegisters/ajax/get_mechanical_bills/<?= $nothiRegister->id; ?>";
            // prepare the data
            var source5 =
                {
                    dataType: "json",
                    dataFields: [
                        {name: 'title', type: 'string'},
                        {name: 'total_amount', type: 'string'},
                        {name: 'net_payable', type: 'string'},
                        {name: 'action', type: 'string'}
                    ],
                    id: 'id',
                    url: url5
                };

            var dataAdapter5 = new $.jqx.dataAdapter(source5);

            $("#mechanical_bills").jqxGrid(
                {
                    width: '100%',
                    source: dataAdapter5,
                    pageable: true,
                    filterable: true,
                    sortable: true,
                    showfilterrow: true,
                    columnsresize: true,
                    pagesize: 15,
                    pagesizeoptions: ['100', '200', '300', '500', '1000', '1500'],
//                selectionmode: 'checkbox',
                    altrows: true,
                    autoheight: true,


                    columns: [
                        {text: '<?= __('Title') ?>', dataField: 'title', width: '50%'},
                        {text: '<?= __('Total Amount') ?>', dataField: 'total_amount', width: '21%'},
                        {text: '<?= __('Net Payable') ?>', dataField: 'net_payable', width: '21%'},
                        {text: '<?= __('Actions') ?>', cellsalign: 'center', dataField: 'action', width: '8%'}
                    ]
                });

        }


        //allotments Bills
        if ( $( "#allotments" ).length ) {

            var url7 = "<?php echo $this->request->webroot; ?>NothiRegisters/ajax/get_allotments/<?= $nothiRegister->id; ?>";
            // prepare the data
            var source7 =
                {
                    dataType: "json",
                    dataFields: [
                        {name: 'project', type: 'string'},
                        {name: 'allotment_date', type: 'string'},
                        {name: 'dr_cr', type: 'string'},
                        {name: 'allotment_amount', type: 'string'},
                        {name: 'action', type: 'string'}
                    ],
                    id: 'id',
                    url: url7
                };

            var dataAdapter7 = new $.jqx.dataAdapter(source7);

            $("#allotments").jqxGrid(
                {
                    width: '100%',
                    source: dataAdapter7,
                    pageable: true,
                    filterable: true,
                    sortable: true,
                    showfilterrow: true,
                    columnsresize: true,
                    pagesize: 15,
                    pagesizeoptions: ['100', '200', '300', '500', '1000', '1500'],
//                selectionmode: 'checkbox',
                    altrows: true,
                    autoheight: true,


                    columns: [
                        {text: '<?= __('Project') ?>', dataField: 'project', width: '32%'},
                        {text: '<?= __('Debit/Credit') ?>', dataField: 'dr_cr', width: '20%'},
                        {text: '<?= __('Allotment Date') ?>', dataField: 'allotment_date', width: '20%'},
                        {text: '<?= __('Allotment Amount') ?>', dataField: 'allotment_amount', width: '20%'},
                        {text: '<?= __('Actions') ?>', cellsalign: 'center', dataField: 'action', width: '8%'}
                    ]
                });
        }
        //Purto Bills
        if ( $( "#purto_bills" ).length ) {

            var url6 = "<?php echo $this->request->webroot; ?>NothiRegisters/ajax/get_purto_bills/<?= $nothiRegister->id; ?>";
            // prepare the data
            var source6 =
                {
                    dataType: "json",
                    dataFields: [
                        {name: 'bill_type', type: 'string'},
                        {name: 'bill_date', type: 'string'},
                        {name: 'gross_bill', type: 'string'},
                        {name: 'net_bill', type: 'string'},
                        {name: 'action', type: 'string'}
                    ],
                    id: 'id',
                    url: url6
                };

            var dataAdapter6 = new $.jqx.dataAdapter(source6);

            $("#purto_bills").jqxGrid(
                {
                    width: '100%',
                    source: dataAdapter6,
                    pageable: true,
                    filterable: true,
                    sortable: true,
                    showfilterrow: true,
                    columnsresize: true,
                    pagesize: 15,
                    pagesizeoptions: ['100', '200', '300', '500', '1000', '1500'],
//                selectionmode: 'checkbox',
                    altrows: true,
                    autoheight: true,


                    columns: [
                        {text: '<?= __('Bill Type') ?>', dataField: 'bill_type', width: '32%'},
                        {text: '<?= __('Bill Date') ?>', dataField: 'bill_date', width: '20%'},
                        {text: '<?= __('Gross Bill') ?>', dataField: 'gross_bill', width: '20%'},
                        {text: '<?= __('Net Bill') ?>', dataField: 'net_bill', width: '20%'},
                        {text: '<?= __('Actions') ?>', cellsalign: 'center', dataField: 'action', width: '8%'}
                    ]
                });

        }
        //Projects
        if ( $( "#projects" ).length ) {

            var url2 = "<?php echo $this->request->webroot; ?>NothiRegisters/ajax/get_projects/<?= $nothiRegister->id; ?>";
            // prepare the data
            var source2 =
                {
                    dataType: "json",
                    dataFields: [
                        {name: 'short_code', type: 'string'},
                        {name: 'name_bn', type: 'string'},
                        {name: 'development_partner', type: 'string'},
                        {name: 'action', type: 'string'}
                    ],
                    id: 'id',
                    url: url2
                };

            var dataAdapter2 = new $.jqx.dataAdapter(source2);

            $("#projects").jqxGrid(
                {
                    width: '100%',
                    source: dataAdapter2,
                    pageable: true,
                    filterable: true,
                    sortable: true,
                    showfilterrow: true,
                    columnsresize: true,
                    pagesize: 15,
                    pagesizeoptions: ['100', '200', '300', '500', '1000', '1500'],
//                selectionmode: 'checkbox',
                    altrows: true,
                    autoheight: true,


                    columns: [
                        {text: '<?= __('Short Code') ?>', dataField: 'short_code', width: '20%'},
                        {text: '<?= __('Name') ?>', dataField: 'name_bn', width: '50%'},
                        {text: '<?= __('Development Partner') ?>', dataField: 'development_partner', width: '22%'},
                        {text: '<?= __('Actions') ?>', cellsalign: 'center', dataField: 'action', width: '8%'}
                    ]
                });

        }
    });
</script>
<script>
    // modal dynamic data load
    $(document).on('click', '.modal-letter', function(){
        var letter_new_id = $(this).attr('data-action');
        console.log(letter_new_id);
        $.ajax({
            type: 'POST',
            url: "<?= $this->Url->build(['controller' => 'NothiRegisters', 'action' => 'modalData']) ?>",
            data: {letter_new_id: letter_new_id},
            success: function(data, status){
                $('.modal-content').html(data);
            }
        });

    });
</script>
<!--Modal letter assign-->
<div id="NewLetter" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">


        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?= __('Add Scheme Progress') ?></h4>
            </div>
            <div class="modal-body">
                <br/>
                <?= $this->Form->create($schemeProgress, ['class' => 'form-horizontal', 'role' => 'form']); ?>

                <?php
                echo $this->Form->hidden('scheme_id', ['value' => $nothiNothiAssigns['scheme']['id']]);
                ?>
                <div class="col-sm-12">
                    <?php echo $this->Form->input('progress_value', ['max' => 100]); ?>
                </div>
                <div class="col-sm-12">
                    <?php echo $this->Form->input('remarks'); ?>
                </div>

            </div>
            <div class="modal-footer">
                <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
<?php
function EngToBanglaNum($input) {
    $bn_digits = array('০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯');
    return str_replace(range(0, 9), $bn_digits, $input);
}
?>
<script>

    $(".print-button").on("click", function(){
        var temp = $(this).closest('.panel-body').children('.find-id');
        var idName = temp[0].id;

        URL = "<?php echo $this->request->webroot; ?>page/Print_a4_Eng.php?selLayer="+idName;
        day = new Date();
        id = day.getTime();
        eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=yes,scrollbars=yes ,location=0,statusbar=0 ,menubar=yes,resizable=1,width=880,height=600,left = 20,top = 50');");
    });


</script>
