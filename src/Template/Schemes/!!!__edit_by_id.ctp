<link href="https://fonts.googleapis.com/css?family=Asap" rel="stylesheet">


<div id="addMoreNewspaper" style="display: none">
    <div class="loop">
        <div class="panel-body col-sm-5">
            <div class="form-group input text">
                <label for="etender-no" class="col-sm-4 control-label text-right"><?= __('Newspaper Name') ?></label>

                <div class="col-sm-8 container_etender_no">
                    <input type="text" name="newspaper[]" class="form-control" id="etender-no" maxlength="100">
                </div>
            </div>
        </div>
        <div class="panel-body col-sm-6">
            <div class="form-group input text">
                <label for="" class="col-sm-4 control-label text-right"><?= __('Publication Date') ?></label>

                <div class="col-sm-8 container_etender_no">
                    <input type="text" name="publicationdate[]" class="form-control date_input">
                </div>
            </div>
        </div>
        <div class="col-sm-1">
            <div class="panel-body">
                <div class="form-group input">
                    <span id="close" class="btn btn-danger icon-close"></span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>

    * {
        font-family: 'Asap', sans-serif;
    }

    /* custom inclusion of right, left and below tabs */

    /*******************************************
    *   CHANGED BY SHAMIM
    *******************************************/

    .col-md-3 > .nav.nav-tabs {
        background-color: #efefef !important;
    }

    .col-md-3 > .nav.nav-tabs li {
        width: 100% !important;
    }

    .modal-header h4 {
        font-size: 17px;
    }

    .col-md-3 > .nav.nav-tabs a {
        padding: 5px 20px;
        border: 0;
    }

    /******************************************/
    .tabs-below > .nav-tabs,
    .tabs-right > .nav-tabs,
    .tabs-left > .nav-tabs {
        border-bottom: 0;
    }

    .tab-content > .tab-pane,
    .pill-content > .pill-pane {
        display: none;
    }

    .tab-content > .active,
    .pill-content > .active {
        display: block;
    }

    .tabs-left > .nav-tabs > li,
    .tabs-right > .nav-tabs > li {
        float: none;
    }

    .tabs-left > .row > .col-md-3 > .nav-tabs > li > a {
        min-width: 200px;
        margin-right: 0;
        margin-bottom: 3px;

    }

    .tabs-left > .nav-tabs {
        float: left;
        margin-right: 19px;
        border-right: 1px solid #ddd;
    }

    .tabs-left > .nav-tabs > li > a {
        margin-right: -1px;
        -webkit-border-radius: 4px 0 0 4px;
        -moz-border-radius: 4px 0 0 4px;
        border-radius: 4px 0 0 4px;
    }

    .tabs-left > .nav-tabs > li > a:hover,
    .tabs-left > .nav-tabs > li > a:focus {
        border-color: #eeeeee #dddddd #eeeeee #eeeeee;
    }

    .tabs-left > .nav-tabs .active > a,
    .tabs-left > .nav-tabs .active > a:hover,
    .tabs-left > .nav-tabs .active > a:focus {
        border-color: #ddd transparent #ddd #ddd;
        *border-right-color: #ffffff;
    }

    div.bhoechie-tab-container {
        z-index: 10;
        background-color: #ffffff;
        padding: 0 !important;
        border-radius: 4px;
        -moz-border-radius: 4px;
        border: 1px solid #ddd;
        margin-top: 20px;
        margin-left: 50px;
        -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, .175);
        box-shadow: 0 6px 12px rgba(0, 0, 0, .175);
        -moz-box-shadow: 0 6px 12px rgba(0, 0, 0, .175);
        background-clip: padding-box;
        opacity: 0.97;
        filter: alpha(opacity=97);
    }
    #modal-body{
        height:500px;
        overflow-y:scroll;
        overflow-x:hidden;

    }

</style>

<?php
use Cake\Core\Configure;

Configure::load('config_offices', 'default');

?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
    <h5 class="modal-title" id="gridSystemModalLabel"><?=$scheme->name_en?></h5>
</div>
<div class="modal-body" id="modal-body">
    <input type="hidden" name="scheme_id" value="<?php echo $scheme['id']; ?>"/>

    <div class="">
        <div class="">
            <!-- tabs left -->
            <div class="tabbable tabs-left">
                <div class="row">
                    <div class="col-md-3 ">
                        <ul class="nav nav-tabs ">
<!--                            <li class="active"><a href="#a" data-toggle="tab">Summary of Scheme</a></li>-->
                            <li><a class="active" href="#b" data-toggle="tab">Scheme Info</a></li>
                            <li><a data-toggle="tab" href="#nothi_register"></i>Nothi</a></li>

                            <li><a class="" href="#quantity" data-toggle="tab">Scheme Quantity</a></li>
                            <li><a class="" href="#nature_of_job" data-toggle="tab">Nature of Job</a></li>
                            <li><a data-toggle="tab" href="#tender"> Tender</a></li>

                            <li><a class="action_btn" href="#app_tender" data-toggle="tab">App Tender</a></li>
                            <li><a class="action_btn" href="#contract_sign" data-toggle="tab">Contract Sign</a></li>
                            <li><a class="action_btn" href="#contractor" data-toggle="tab">Contractor</a></li>
                            <li><a data-toggle="tab" href="#approval_allotment">Approval Allotment</a></li>
                            <li><a data-toggle="tab" href="#estimated">Estimated Cost</a></li>
                            <li><a data-toggle="tab" href="#payment">Payment</a></li>

                            <li><a class="action_btn" id="item_and_bbq" data-tab-url="edit_item_bbq" href="#item_bbq" data-toggle="tab">Item
                                    & BOQ</a></li>
                            <li><a class="action_btn" href="#i" data-toggle="tab">Lab</a></li>
                            <li><a class="action_btn" data-tab-url="scheme_vehicle_manage" href="#scheme_vehicle_wrp"  data-toggle="tab" id="scheme_vehicles">Vehicles</a></li>
                            <li><a class="action_btn" href="#k" data-toggle="tab">Account</a></li>
                            <li><a class="action_btn" href="#picture_files" data-toggle=" tab">Picture & Files</a></li>
                            <li><a class="action_btn" data-tab-url="edit_scheme_progress" href="#scheme_progress_wrp"
                                   data-toggle="tab" id="scheme_progress">Progress</a></li>

                            <li><a class="action_btn" data-tab-url="edit_scheme_measurement" href="#scheme_measurement_wrp"
                                   data-toggle="tab" id="scheme_measurements">Measurement</a></li>
                        </ul>
                    </div>
                    <div class="col-md-9">
                        <?= $this->Form->create($scheme, ['class' => 'form-horizontal', 'role' => 'form']); ?>

                        <div class="tab-content">

                            <div class="tab-pane " id="a">

                                <p>Not set yet</p>

                            </div>

                            <div class="tab-pane active" id="b">

                                <div class="col-sm-12">
                                    <?php
                                    if (in_array($office_type, ['HEAD_QUARTER', 'DIVISION', 'ZONAL'])) {
                                        echo $this->Form->input('district_id', ['options' => $districts, 'empty' => 'Select a district']);
                                    } else {
                                        echo $this->Form->input('district_id', ['options' => $districts]);
                                    } ?>
                                    <div id="main_container_municipality_dropdown">
                                        <?php
                                        echo $this->Form->input('municipality_id', ['options' => $municipalities, 'empty' => 'NONE']);
                                        ?>
                                    </div>

                                    <?php
                                    echo $this->Form->input('financial_year_estimate_id', ['options' => $financialYearEstimates, 'empty' => __('Select')]);
                                    echo $this->Form->input('name_bn', ['label' => __('NAME_BN'), 'type' => 'text']);

                                    echo $this->Form->input('scheme_code');

                                    ?>

                                    <?php

                                    ?>

                                    <?php
                                    echo $this->Form->input('pic_flag', ['options' => ['1' => 1, '2' => 2], 'empty' => __('Select')]);
                                    // echo $this->Form->input('proposed_start_date', ['type' => 'text', 'value' => $this->System->display_date($scheme->proposed_start_date), 'class' => 'form-control hasdatepicker']);
                                    //echo $this->Form->input('tender_date', ['type' => 'text', 'value' => $this->System->display_date($scheme->tender_date), 'class' => 'form-control hasdatepicker']);
                                    //echo $this->Form->input('expected_complete_date', ['type' => 'text', 'value' => $this->System->display_date($scheme->expected_complete_date), 'class' => 'form-control hasdatepicker']);
                                    ?>
                                    <div class="form-group input text">
                                        <label
                                            class="col-sm-3 control-label text-right"><?= __('Estimated Cost') ?></label>

                                        <div class="col-sm-9 estimated_cost_wrp">
                                            <input type="text" name="estimated_cost" class="form-control"
                                                   id="estimated_cost"
                                                   value="<?= $scheme->estimated_cost ?>">
                                        </div>
                                    </div>
                                    <div class="form-group input number">
                                        <label
                                            class="col-sm-3 control-label text-right"><?= __('Work Order Date') ?></label>

                                        <div class="col-sm-9">
                                            <input type="text" name="work_order_date" class="form-control hasdatepicker"
                                                   id="work_order_date"
                                                   value="<?= date('d-m-Y', $scheme->work_order_date) ?>">
                                        </div>
                                    </div>

                                    <div class="form-group input number">
                                        <label
                                            class="col-sm-3 control-label text-right"><?= __('Sub Assistant Engineer') ?></label>

                                        <div class="col-sm-9">
                                            <input type="text" name="sub_engineer_name" class="form-control"
                                                   id="sub_engineer_name" value="<?= $scheme->sub_engineer_name ?>">
                                        </div>
                                    </div>
                                    <!--<div class="form-group input number">
                                <label
                                    class="col-sm-3 control-label text-right"><? /*= __('Extended Date of Completion') */ ?></label>

                                <div class="col-sm-9">
                                    <input type="text" name="approve_extended_date" class="form-control hasdatepicker"
                                           id="approve_extended_date">
                                </div>
                            </div>-->
                                </div>

                                <div class="col-sm-12">
                                    <div id="main_container_upazila_dropdown">
                                        <?php
                                        if (in_array($office_type, ['UPAZILA'])) {
                                            echo $this->Form->input('upazila_id', ['options' => $upazilas]);
                                        } else {
                                            echo $this->Form->input('upazila_id', ['options' => $upazilas, 'empty' => 'select a upazila']);
                                        }
                                        ?>
                                    </div>
                                    <?php
                                    echo $this->Form->input('constituency_no', ['label' => __('Constituency No'), 'type' => 'text']);
                                    echo $this->Form->input('project_id', ['options' => $projects, 'empty' => __('Select')]);
                                    echo $this->Form->input('name_en', ['label' => __('NAME_EN'), 'type' => 'text']);
                                    echo $this->Form->input('package_id', ['options' => $packages, 'empty' => __('Select')]);

                                    ?>

                                    <?php
                                    echo $this->Form->input('category_name', ['options' => Configure::read('scheme_category'), 'empty' => __('Select')]);
                                    echo $this->Form->input('contract_amount', ['label' => __('Contract Amount'), 'type' => 'text']);
                                    echo $this->Form->input('scheme_type_id', ['options' => $scheme_types, 'empty' => 'Select']);
                                    echo $this->Form->input('sub_scheme_type_id', ['options' => $scheme_sub_types, 'empty' => 'Select']);

                                    ?>



                                    <?php
                                    //echo $this->Form->input('actual_start_date', ['type' => 'text', 'value' => $this->System->display_date($scheme->actual_start_date), 'class' => 'form-control hasdatepicker']);
                                    //echo $this->Form->input('actual_complete_date', ['type' => 'text', 'value' => $this->System->display_date($scheme->actual_complete_date), 'class' => 'form-control hasdatepicker']);
                                    echo $this->Form->input('performance_security');
                                    ?>

                                    <div class="form-group input number">
                                        <label class="col-sm-3 control-label text-right"><?= __('Sarok No') ?></label>

                                        <div class="col-sm-9">
                                            <input type="text" name="sarok_no" value="<?= $scheme->sarok_no; ?>"
                                                   class="form-control" id="sarok_no">
                                        </div>
                                    </div>

                                    <div class="form-group input number">
                                        <label
                                            class="col-sm-3 control-label text-right"><?= __('Work Assistant') ?></label>

                                        <div class="col-sm-9">
                                            <input type="text" name="assistant_worker" class="form-control"
                                                   value="<?= $scheme->assistant_worker; ?>" id="assistant_worker">
                                        </div>
                                    </div>

                                    <!--<div class="form-group input number">
                                <label class="col-sm-3 control-label text-right"><? /*= __('Work Assessment') */ ?></label>

                                <div class="col-sm-9">
                                    <input type="text" name="work_remarks" class="form-control" id="work_remarks">
                                </div>
                            </div>-->

                                </div>

                            </div>

                            <div id="nothi_register" class="tab-pane fade">
                                <div class="col-sm-6">
                                    <?= $this->Form->input('selected_nothi', ['value' => isset($selected_nothi) ? $selected_nothi['nothi_no'] : "", 'disabled']) ?>
                                    <?php echo $this->Form->input('parent_id', ['options' => $nothiRegisters, 'empty' => __('Select'), 'templates' => ['inputContainer' => '<div class="form-group nothi_register {{type}}{{required}}">{{content}}</div>']]); ?>

                                </div>
                            </div>

                            <div class="tab-pane" id="quantity">
                                <div class="col-sm-12">
                                    <?= $this->Form->input('roadid'); ?>
                                    <?= $this->Form->input('structure_length', ['label' => __('Bridge/Culvert Length')]); ?>
                                </div>
                                <div class="col-sm-12">
                                    <?= $this->Form->input('road_length'); ?>
                                    <?= $this->Form->input('building_quantity'); ?>
                                </div>
                            </div>

                            <div id="nature_of_job" class="tab-pane fade">
                                <div class="col-sm-6">
                                    <?= $this->Form->input('work_type_id', ['options' => $workTypes, 'empty' => 'Select Work type']); ?>

                                </div>
                                <div class="col-sm-6">
                                    <div id="main_container_subwork_dropdown">
                                        <?php
                                        echo $this->Form->input('work_sub_type_id', ['options' => $workSubTypes, 'empty' => 'Select Subwork Type']);
                                        ?>
                                    </div>

                                </div>
                            </div>

                            <div id="tender" class="tab-pane fade">
                                <div class="col-sm-12">
                                    <div class="col-sm-5">
                                        <div class="form-group input text">
                                            <label for="etender-no"
                                                   class="col-sm-4 control-label text-right"><?= __('e-Tender No') ?></label>

                                            <div class="col-sm-8 container_etender_no">
                                                <input type="text" name="etender_no"   value="<?= $scheme->etender_no ;?>" class="form-control"id="etender-no"maxlength="100">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group input text">
                                            <label for="etender-date"
                                                   class="col-sm-4 control-label text-right"><?= __('e-Tender Date') ?></label>

                                            <div class="col-sm-8 container_etender_date">
                                                <input type="text" name="etender_date"   value="<?= $this->System->display_date($scheme->etender_date) ;?>" id="etender-date" maxlength="11" class="form-control hasdatepicker">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="newspaper">
                                        <div class="loop">
                                            <div class="col-sm-5">
                                                <div class="form-group input text">
                                                    <label for="etender-no"
                                                           class="col-sm-4 control-label text-right"><?= __('Newspaper Name') ?></label>

                                                    <div class="col-sm-8 container_etender_no">
                                                        <input type="text" name="newspaper[]" class="form-control"
                                                               id="etender-no" maxlength="100">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group input text">
                                                    <label for="etender-no"
                                                           class="col-sm-4 control-label text-right"><?= __('Publication Date') ?></label>

                                                    <div class="col-sm-8 container_etender_no">
                                                        <input type="text" name="publicationdate[]"
                                                               class="form-control hasdatepicker">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-1">
                                                <div class="">
                                                    <div class="form-group input">
                                                        <span id="addMore" class="btn btn-success icon-plus"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-5">
                                        <div class="form-group input number">
                                            <label for="number-of-tender"
                                                   class="col-sm-4 control-label text-right"><?= __('প্রাপ্ত দরপত্র সংখ্যা') ?></label>

                                            <div class="col-sm-8 container_number_of_tender">
                                                <input type="number" name="number_of_tender" class="form-control"
                                                       value="<?= $scheme->number_of_tender ;?>"   id="number-of-tender">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group input number">
                                            <label for="habitual-number-of-tender"
                                                   class="col-sm-4 control-label text-right"><?= __('রীতিসিদ্ধ দরপত্র সংখ্যা') ?></label>

                                            <div class="col-sm-8 container_habitual_number_of_tender">
                                                <input type="number" name="habitual_number_of_tender"  value="<?= $scheme->habitual_number_of_tender ;?>"  class="form-control" id="habitual-number-of-tender">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-5">
                                        <div class="form-group input number">
                                            <label for="applied-tender-price"
                                                   class="col-sm-4 control-label text-right"><?= __('দাখিলকৃত দরপত্র মূল্য') ?></label>

                                            <div class="col-sm-8 container_applied_tender_price">
                                                <input type="number" name="applied_tender_price" class="form-control"
                                                       value="<?= $scheme->applied_tender_price ;?>"   id="applied-tender-price">
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>

                            <div id="app_tender" class="tab-pane fade">
                                <div class="col-sm-12">
                                    <?php
                                    echo $this->Form->input('app_tender_id', ['label' => __('APP Tender ID'), 'type' => 'text']);
                                    echo $this->Form->input('tender_id', ['label' => __('Tender ID'), 'type' => 'text']);
                                    ?>
                                </div>
                                <div class="col-sm-12">

                                    <?php

                                    echo $this->Form->input('app_sent', ['label' => __('APP Sent'), 'type' => 'text', 'value' => $this->System->display_date($scheme->app_sent), 'class' => 'form-control hasdatepicker']);
                                    echo $this->Form->input('app_approved', ['label' => __('APP Approved'), 'type' => 'text', 'value' => $this->System->display_date($scheme->app_approved), 'class' => 'form-control hasdatepicker']);
                                    ?>


                                </div>
                            </div>
                            <div id="contract_sign" class="tab-pane fade">

                                <div class="col-sm-12">
                                    <?php
                                    echo $this->Form->input('proposed_start_date', ['type' => 'text', 'value' => $this->System->display_date($scheme->proposed_start_date), 'class' => 'form-control hasdatepicker']);
                                    echo $this->Form->input('contract_date', ['type' => 'text', 'value' => $this->System->display_date($scheme->contract_date), 'class' => 'form-control hasdatepicker']);
                                    echo $this->Form->input('noa_date', ['label' => __('NOA Date'), 'type' => 'text', 'value' => $this->System->display_date($scheme->noa_date), 'class' => 'form-control hasdatepicker']);
                                    echo $this->Form->input('insurance_date', ['label' => __('Insurance Date'), 'type' => 'text', 'value' => $this->System->display_date($scheme->insurance_date), 'class' => 'form-control hasdatepicker']);

                                    ?>

                                    <?php
                                    //echo $this->Form->input('tender_date', ['type' => 'text', 'value' => $this->System->display_date($scheme->tender_date), 'class' => 'form-control hasdatepicker']);
                                    echo $this->Form->input('expected_complete_date', ['type' => 'text', 'value' => $this->System->display_date($scheme->expected_complete_date), 'class' => 'form-control hasdatepicker']);
                                    echo $this->Form->input('actual_start_date', ['type' => 'text', 'value' => $this->System->display_date($scheme->actual_start_date), 'class' => 'form-control hasdatepicker']);
                                    echo $this->Form->input('noa_subject', ['label' => __('NOA Subject'), 'type' => 'text']);

                                    ?>
                                </div>
                                <!--<div class="col-sm-6">
                            <?php
                                /*                            echo $this->Form->input('actual_start_date', ['type' => 'text', 'value' => $this->System->display_date($scheme->actual_start_date), 'class' => 'form-control hasdatepicker']);
                                                            //echo $this->Form->input('actual_complete_date', ['type' => 'text', 'value' => $this->System->display_date($scheme->actual_complete_date), 'class' => 'form-control hasdatepicker']);
                                                            */ ?>
                        </div>-->

                            </div>

                            <div id="contractor" class="tab-pane fade">

                                <div class="col-sm-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">

                                            <h6 class="panel-title"><i class="icon-table2"></i>Contractor List</h6>


                                        </div>
                                        <div class="panel-body">
                                            <table class="table  table-bordered">
                                                <tr>
                                                    <td>Contractor Title</td>
                                                    <td>Contact Person Name</td>
                                                    <td>Contractor Phone</td>
                                                    <td>Mobile</td>
                                                    <td>Is Lead?</td>

                                                </tr>
                                                <?php foreach($assigned_contractors  as $row):?>
                                                    <tr>
                                                        <td><?= $row['contractor']['contractor_title']?></td>
                                                        <td><?= $row['contractor']['contact_person_name']?></td>
                                                        <td><?= $row['contractor']['contractor_phone']?></td>
                                                        <td><?= $row['contractor']['mobile']?></td>
                                                        <td><?= $row['is_lead']?'Yes':''?></td>
                                                    </tr>
                                                <?php endforeach?>

                                            </table>

                                            <div class=""


                                        </div>

                                    </div>
                                </div>
                                <!--<div class="col-sm-6">
                            <?php
                                /*                            echo $this->Form->input('actual_start_date', ['type' => 'text', 'value' => $this->System->display_date($scheme->actual_start_date), 'class' => 'form-control hasdatepicker']);
                                                            //echo $this->Form->input('actual_complete_date', ['type' => 'text', 'value' => $this->System->display_date($scheme->actual_complete_date), 'class' => 'form-control hasdatepicker']);
                                                            */ ?>
                        </div>-->

                            </div>

                            <div id="approval_allotment" class="tab-pane fade">
                                <div id="approval" class="col-sm-12">

                                    <div class="panel-body col-sm-4">
                                        <div class="form-group input number"><label for="allotment-no"
                                                                                    class="col-sm-4 control-label text-right"><?= __('Allotment No') ?></label>

                                            <div class="col-sm-8 container_allotment_no">
                                                <input type="number" name="allotment_no" class="form-control"
                                                       id="allotment-no"
                                                       value="<?= $scheme->allotment_no ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body col-sm-4">
                                        <div class="form-group input text">
                                            <label for="allotment-date"
                                                   class="col-sm-4 control-label text-right"><?= __('Allotment Date'); ?></label>

                                            <div class="col-sm-8 container_allotment_date">
                                                <input type="text" name="allotment_date"
                                                       value="<?= date('d-M-Y', $scheme->allotment_date) ?>"
                                                       id="allotment-date"
                                                       maxlength="11"
                                                       class="form-control hasdatepicker">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body col-sm-4">
                                        <div class="form-group input number">
                                            <label for="allotment-bill"
                                                   class="col-sm-4 control-label text-right"><?= __('TK') ?></label>

                                            <div class="col-sm-8 container_allotment_bill">
                                                <input type="number" name="allotment_bill" class="form-control"
                                                       value="<?= $scheme->allotment_bill ?>"
                                                       id="allotment-bill" step="any">
                                            </div>
                                        </div>
                                    </div>
                                    <div style="clear: both;"></div>
                                    <div class="panel-body col-sm-4">
                                        <div class="form-group input number">
                                            <label for="eve-approval-sarok-no"
                                                   class="col-sm-4 control-label text-right"><?= __('Approval Sarok No') ?></label>

                                            <div class="col-sm-8 container_eve_approval_sarok_no">
                                                <input type="number" name="eve_approval_sarok_no" class="form-control"
                                                       value="<?= $scheme->eve_approval_sarok_no ?>"
                                                       id="eve-approval-sarok-no">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="panel-body col-sm-4">
                                        <div class="form-group input text">
                                            <label for="eve-approval-date"
                                                   class="col-sm-4 control-label text-right"><?= __('Approval Date') ?></label>

                                            <div class="col-sm-8 container_eve_approval_date">
                                                <input type="text" name="eve_approval_date"
                                                       value="<?= date('d-M-Y', $scheme->eve_approval_date) ?>"
                                                       id="eve-approval-date"
                                                       maxlength="11"
                                                       class="form-control hasdatepicker">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body col-sm-4">
                                        <div class="form-group input number">
                                            <label for="eve-approval-bill"
                                                   class="col-sm-4 control-label text-right"><?= __('TK') ?></label>

                                            <div class="col-sm-8 container_eve_approval_bill">
                                                <input type="number" name="eve_approval_bill" class="form-control"
                                                       value="<?= $scheme->eve_approval_bill ?>"
                                                       id="eve-approval-bill" step="any">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div id="estimated" class="tab-pane fade">
                                <div class="col-sm-12">
                                    <?php
                                    echo $this->Form->input('estimated_road');
                                    echo $this->Form->input('estimated_structure');
                                    ?>
                                </div>
                            </div>
                            <div id="payment" class="tab-pane fade">
                                <div class="col-sm-12">

                                    <?php
                                    echo $this->Form->input('payment_road');
                                    echo $this->Form->input('payment_structure');
                                    ?>
                                    <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">

                                    <?= $this->Form->end() ?>
                                </div>
                            </div>
                            <div class="tab-pane" id="item_bbq">

                            </div>
                            <div class="tab-pane" id="scheme_progress_wrp">

                            </div>
                            

                            <div class="tab-pane active" id="scheme_measurement_wrp">
                            </div>


                        </div><!--End tab content-->

                    </div>
                </div>
            </div>
            <!-- /tabs -->
        </div>
    </div><!-- /row -->
</div>
<div class="modal-footer">
    <div id="footer"></div>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
<script>
    $(document).ready(function () {
        var display_date_format = "dd-M-yy";
        $(".hasdatepicker").datepicker({
            dateFormat: display_date_format,
            changeMonth: true,
            changeYear: true,
            yearRange: "-50:+10"
        });

        $('.action_btn').click(function () {
            var scheme_id = $('[name=scheme_id]').val();
            var url = $(this).attr('data-tab-url');
            var wrp = $(this).attr('href');
            if (url) {
                url = '<?= $this->Url->build("/Schemes/")?>' + url + '/' + scheme_id;
                $.ajax({
                    type: "GET",
                    url: url,
                    timeout: 9000,
                    success: function (response) {
                        $(wrp).html(response)
                    }
                });
            }
            //this one for turn on add multiple row of scheme progress plan
           $(document).off('click','.add_file');
        });

        $(document).on("change", "#work-type-id", function (event) {
            var work_type_id = $(this).val();
            $.ajax({
                url: '<?= $this->Url->build(('/Schemes/ajax/get_subwork_by_worktype_id'), true) ?>',
                type: 'POST',

                data: {work_type_id: work_type_id},
                success: function (data, status) {
                    $('#main_container_subwork_dropdown').html(data);
                    //console.log(data);

                },
                error: function (xhr, desc, err) {
                    console.log("error");

                }
            });


        });
        $(document).on("change", "#district-id", function (event) {

            var district_id = $(this).val();
            $('#upazila-id').html('<option value="">select a upazila</option>');
            $('#municipality-id').html('<option value="">NONE</option>');
            if (district_id) {
                $.ajax({
                    url: '<?= $this->Url->build(('/Schemes/ajax/get_upazila_municpaltiy_by_disctrict_id'), true) ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: {district_id: district_id},
                    success: function (data, status) {
                        $('#main_container_upazila_dropdown').html(data.upazilas);
                        $('#main_container_municipality_dropdown').html(data.municipalities);

                        //$('#main_container_zone_dropdown').show();$('#container_module_id').html(data);
                        //console.log(data);

                    },
                    error: function (xhr, desc, err) {
                        console.log("error");

                    }
                });
            }
        });

        $(document).on('click', '#addMore', function () {
            var html = $('#addMoreNewspaper').html();
            $('#newspaper').append(html)


        });
        $(document).on('click', '#close', function () {


            $(this).parents('.loop').remove();
            $(this).remove();

        });

        $(document).on('focus', '.date_input', function () {

            $(this).removeClass('hasDatepicker').datepicker();
        });
        //        mazba

        $(document).on("change", "#scheme-type-id", function (event) {

            var schemeTypeId = $(this).val();
            $('#sub-scheme-type-id').html('<option value="">Select</option>');
            if (schemeTypeId) {
                $.ajax({
                    url: '<?= $this->Url->build(('/Schemes/ajax/get_sub_scheme_type_by_scheme_type_id'), true) ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: {schemeTypeId: schemeTypeId},
                    success: function (data, status) {
                        var html = '<option value="">Select</option>';
                        $.each(data, function (i, e) {
                            html += '<option value="' + i + '">' + e + '</option>'
                        });
                        $('#sub-scheme-type-id').html(html);

                    },
                    error: function (xhr, desc, err) {
                        console.log("error");

                    }
                });
            }
        });

        $(document).on('change', '#parent-id', function () {
            var parent_id = $(this).val();
            var obj = $(this);
            $.ajax({
                type: 'POST',
                url: '<?= $this->Url->build("/NothiRegisters/getSubNothi")?>',
                data: {parent_id: parent_id},
                success: function (data, status) {
                    obj.closest('.nothi_register').nextAll('.nothi_register').remove();
                    if (data) {
                        obj.closest('.form-group').after(data);
                    }
                }
            });
        });
    });
</script>
