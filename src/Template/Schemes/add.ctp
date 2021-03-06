<?php
use Cake\Core\Configure;

Configure::load('config_offices', 'default');

?>
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

</style>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Schemes'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('New Scheme') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Schemes'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('New Scheme'), ['action' => 'add']) ?></li>


    </ul>
</div>
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
    .nav-tabs a{
        padding: 17px 19px!important;
    }
</style>
<div class="panel panel-default">
    <div class="panel-heading">
        <h6 class="panel-title">
            <i class="icon-paragraph-right2"></i><?= __('Add Scheme') ?>
        </h6>
    </div>
    <?= $this->Form->create($scheme, ['class' => 'form-horizontal', 'role' => 'form']); ?>
    <div class="panel-body col-sm-12" style="padding: 0px!important;">
        <div class="panel-body" style="padding: 0px!important;">
            <div class="tabbable tabs-left">
                <div class="row" style="margin: 0px">
                    <div class="col-md-3" style="padding-left: 0px!important;">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#general"></i>Scheme Info</a></li>
                            <li><a data-toggle="tab" href="#nothi_register"></i>Nothi</a></li>
                            <li><a data-toggle="tab" href="#quantity"></i>Scheme Quantity</a></li>
                            <li><a data-toggle="tab" href="#nature_of_job">Nature of Job</a></li>
                            <li><a data-toggle="tab" href="#tender"> Tender</a></li>
                            <li><a data-toggle="tab" href="#app_tender">App Tender</a></li>
                            <li><a data-toggle="tab" href="#contract_sign">Contract Sign</a></li>
                            <li><a data-toggle="tab" href="#approval_allotment">Approval Allotment</a></li>
                            <li><a data-toggle="tab" href="#">Contractor</a></li>
                            <li><a data-toggle="tab" href="#estimated">Estimated Cost</a></li>
                            <li><a data-toggle="tab" href="#payment">Payment</a></li>
                            <li><a data-toggle="tab" href="#">Item & BOQ</a></li>

                        </ul>
                    </div>

                    <div class="col-md-9">
                        <div class="tab-content pill-content">
                            <div id="general" class="tab-pane fade active in">
                                <div class="col-sm-6">
                                    <?php
                                    if (in_array($office_type, ['HEAD_QUARTER', 'DIVISION', 'ZONAL'])) {
                                        echo $this->Form->input('district_id', ['options' => $districts, 'empty' => 'Select a district', 'required' => 'required']);
                                    } else {
                                        echo $this->Form->input('district_id', ['options' => $districts, 'required' => 'required']);
                                    } ?>
                                    <div id="main_container_municipality_dropdown">
                                        <?php
                                        echo $this->Form->input('municipality_id', ['options' => $municipalities, 'empty' => 'Select', 'required' => 'required']);
                                        ?>
                                    </div>

                                    <?php
                                    echo $this->Form->input('financial_year_estimate_id', ['options' => $financialYearEstimates, 'empty' => __('Select'), 'required' => 'required']);
                                    echo $this->Form->input('name_bn', ['label' => __('NAME_BN'), 'type' => 'text', 'required' => 'required']);

                                    echo $this->Form->input('scheme_code',['required' => 'required']);

                                    ?>

                                    <?php

                                    ?>

                                    <?php
                                    echo $this->Form->input('pic_flag', ['options' => ['1' => 1, '2' => 2], 'empty' => __('Select'), 'required' => 'required']);
                                    // echo $this->Form->input('proposed_start_date', ['type' => 'text', 'value' => $this->System->display_date($scheme->proposed_start_date), 'class' => 'form-control hasdatepicker']);
                                    //echo $this->Form->input('tender_date', ['type' => 'text', 'value' => $this->System->display_date($scheme->tender_date), 'class' => 'form-control hasdatepicker']);
                                    //echo $this->Form->input('expected_complete_date', ['type' => 'text', 'value' => $this->System->display_date($scheme->expected_complete_date), 'class' => 'form-control hasdatepicker']);
                                    ?>
                                    <div class="form-group input text">
                                        <label
                                            class="col-sm-3 control-label text-right"><?= __('Estimated Cost') ?></label>

                                        <div class="col-sm-9 estimated_cost_wrp">
                                            <input type="text" name="estimated_cost" class="form-control"
                                                   id="estimated_cost">
                                        </div>
                                    </div>
                                    <div class="form-group input number">
                                        <label
                                            class="col-sm-3 control-label text-right"><?= __('Work Order Date') ?></label>

                                        <div class="col-sm-9">
                                            <input type="text" name="work_order_date" class="form-control hasdatepicker"
                                                   id="work_order_date">
                                        </div>
                                    </div>

                                    <div class="form-group input number">
                                        <label
                                            class="col-sm-3 control-label text-right"><?= __('Sub Assistant Engineer') ?></label>

                                        <div class="col-sm-9">
                                            <input type="text" name="sub_engineer_name" class="form-control"
                                                   id="sub_engineer_name">
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

                                <div class="col-sm-6">
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
                                    echo $this->Form->input('project_id', ['options' => $projects, 'empty' => __('Select'), 'required' => 'required']);
                                    echo $this->Form->input('name_en', ['label' => __('NAME_EN'), 'type' => 'text', 'required' => 'required']);
                                    echo $this->Form->input('package_id', ['options' => $packages, 'empty' => __('Select'), 'required' => 'required']);

                                    ?>

                                    <?php
                                    echo $this->Form->input('category_name', ['options' => Configure::read('scheme_category'), 'empty' => __('Select')]);
                                    echo $this->Form->input('contract_amount', ['label' => __('Contract Amount'), 'type' => 'text']);
                                    echo $this->Form->input('scheme_type_id', ['options' => $scheme_types, 'empty' => 'Select', 'required' => 'required']);
                                    ?>
                                    <div class="form-group input number">
                                        <label
                                            class="col-sm-3 control-label text-right"><?= __('Sub Scheme Type') ?></label>

                                        <div class="col-sm-9">
                                            <select id="sub_scheme_id" name="sub_scheme_type_id"
                                                    class="form-control sub_scheme_type_id">
                                            </select>
                                        </div>
                                    </div>


                                    <?php
                                    //echo $this->Form->input('actual_start_date', ['type' => 'text', 'value' => $this->System->display_date($scheme->actual_start_date), 'class' => 'form-control hasdatepicker']);
                                    //echo $this->Form->input('actual_complete_date', ['type' => 'text', 'value' => $this->System->display_date($scheme->actual_complete_date), 'class' => 'form-control hasdatepicker']);
                                    echo $this->Form->input('performance_security');
                                    ?>

                                    <div class="form-group input number">
                                        <label class="col-sm-3 control-label text-right"><?= __('Sarok No') ?></label>

                                        <div class="col-sm-9">
                                            <input type="text" name="sarok_no" class="form-control" id="sarok_no">
                                        </div>
                                    </div>

                                    <div class="form-group input number">
                                        <label
                                            class="col-sm-3 control-label text-right"><?= __('Work Assistant') ?></label>

                                        <div class="col-sm-9">
                                            <input type="text" name="assistant_worker" class="form-control"
                                                   id="assistant_worker">
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
                                    <?php
                                    echo $this->Form->input('parent_id', ['required', 'options' => $nothiRegisters, 'empty' => __('Select'), 'templates' => ['inputContainer' => '<div class="form-group nothi_register {{type}}{{required}}">{{content}}</div>']]);
                                    ?>
                                </div>
                            </div>

                            <div id="quantity" class="tab-pane fade">
                                <div class="col-sm-6">
                                    <?= $this->Form->input('roadid'); ?>
                                    <?= $this->Form->input('structure_length', ['label' => __('Bridge/Culvert Length')]); ?>
                                </div>
                                <div class="col-sm-6">
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

                                            <div class="col-sm-8 container_etender_no"><input type="text"
                                                                                              name="etender_no"
                                                                                              class="form-control"
                                                                                              id="etender-no"
                                                                                              maxlength="100">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group input text">
                                            <label for="etender-date"
                                                   class="col-sm-4 control-label text-right"><?= __('e-Tender Date') ?></label>

                                            <div class="col-sm-8 container_etender_date"><input type="text"
                                                                                                name="etender_date"
                                                                                                id="etender-date"
                                                                                                maxlength="11"
                                                                                                class="form-control hasdatepicker">
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
                                                       id="number-of-tender">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group input number">
                                            <label for="habitual-number-of-tender"
                                                   class="col-sm-4 control-label text-right"><?= __('রীতিসিদ্ধ দরপত্র সংখ্যা') ?></label>

                                            <div class="col-sm-8 container_habitual_number_of_tender">
                                                <input type="number" name="habitual_number_of_tender"
                                                       class="form-control"
                                                       id="habitual-number-of-tender">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-5">
                                        <div class="form-group input number">
                                            <label for="applied-tender-price"
                                                   class="col-sm-4 control-label text-right"><?= __('দাখিলকৃত দরপত্র মূল্য') ?></label>

                                            <div class="col-sm-8 container_applied_tender_price">
                                                <input type="number" name="applied_tender_price" class="form-control"
                                                       id="applied-tender-price">
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>

                            <div id="app_tender" class="tab-pane fade">
                                <div class="col-sm-6">
                                    <?php
                                    echo $this->Form->input('app_tender_id', ['label' => __('APP Tender ID'),'type' => 'text']);
                                    echo $this->Form->input('tender_id', ['label' => __('Tender ID'),'type' => 'text']);
                                    ?>
                                </div>
                                <div class="col-sm-6">

                                        <?php

                                        echo $this->Form->input('app_sent', ['label' => __('APP Sent'),'type' => 'text','value' => $this->System->display_date($scheme->app_sent),'class' => 'form-control hasdatepicker']);
                                        echo $this->Form->input('app_approved', ['label' => __('APP Approved'),'type' => 'text','value' => $this->System->display_date($scheme->app_approved),'class' => 'form-control hasdatepicker']);
                                        ?>


                                </div>
                            </div>


                            <div id="contract_sign" class="tab-pane fade">

                                <div class="col-sm-6">
                                    <?php
                                    echo $this->Form->input('proposed_start_date', ['type' => 'text', 'value' => $this->System->display_date($scheme->proposed_start_date), 'class' => 'form-control hasdatepicker']);
                                    echo $this->Form->input('contract_date', ['type' => 'text', 'value' => $this->System->display_date($scheme->contract_date), 'class' => 'form-control hasdatepicker']);
                                    echo $this->Form->input('noa_date', ['label' => __('NOA Date'),'type' => 'text', 'value' => $this->System->display_date($scheme->noa_date), 'class' => 'form-control hasdatepicker']);
                                    echo $this->Form->input('insurance_date', ['label' => __('Insurance Date'),'type' => 'text', 'value' => $this->System->display_date($scheme->insurance_date), 'class' => 'form-control hasdatepicker']);

                                    ?>
                                    </div>
                                <div class="col-sm-6">
                                    <?php
                                    //echo $this->Form->input('tender_date', ['type' => 'text', 'value' => $this->System->display_date($scheme->tender_date), 'class' => 'form-control hasdatepicker']);
                                    echo $this->Form->input('expected_complete_date', ['type' => 'text', 'value' => $this->System->display_date($scheme->expected_complete_date), 'class' => 'form-control hasdatepicker']);
                                    echo $this->Form->input('actual_start_date', ['type' => 'text', 'value' => $this->System->display_date($scheme->actual_start_date), 'class' => 'form-control hasdatepicker']);
                                    echo $this->Form->input('noa_subject', ['label' => __('NOA Subject'),'type' => 'text']);

                                    ?>
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
                                                       id="allotment-no">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body col-sm-4">
                                        <div class="form-group input text">
                                            <label for="allotment-date"
                                                   class="col-sm-4 control-label text-right"><?= __('Allotment Date'); ?></label>

                                            <div class="col-sm-8 container_allotment_date">
                                                <input type="text" name="allotment_date" value="" id="allotment-date"
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
                                                       id="eve-approval-sarok-no">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="panel-body col-sm-4">
                                        <div class="form-group input text">
                                            <label for="eve-approval-date"
                                                   class="col-sm-4 control-label text-right"><?= __('Approval Date') ?></label>

                                            <div class="col-sm-8 container_eve_approval_date">
                                                <input type="text" name="eve_approval_date" value=""
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
                                                       id="eve-approval-bill" step="any">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div id="estimated" class="tab-pane fade">
                                <div class="col-sm-6">
                                    <?php
                                    echo $this->Form->input('estimated_road');
                                    echo $this->Form->input('estimated_structure');
                                    ?>
                                </div>
                            </div>
                            <div id="payment" class="tab-pane fade">
                                <div class="col-sm-6">

                                    <?php
                                    echo $this->Form->input('payment_road');
                                    echo $this->Form->input('payment_structure');
                                    ?>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-actions text-right" style="margin-right: 45px;margin-bottom: 10px">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
    <?= $this->Form->end() ?>
</div>

<script type="text/javascript">
    jQuery(document).ready(function () {
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
            $('#sub_scheme_id').html('<option value="">Select</option>');
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
                        $('#sub_scheme_id').html(html);

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

<style>
    #approval .control-label {
        display: block
    }
</style>