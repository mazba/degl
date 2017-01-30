<link href="https://fonts.googleapis.com/css?family=Asap" rel="stylesheet">

<style>



    *{
        font-family: 'Asap', sans-serif;
    }
    /* custom inclusion of right, left and below tabs */

    /*******************************************
    *   CHANGED BY SHAMIM
    *******************************************/

    .col-md-3 > .nav.nav-tabs{
       background-color: #efefef!important;
    }

    .col-md-3 >.nav.nav-tabs li {
        width: 100% !important;
    }

    .modal-header h4{
        font-size: 17px;
    }

    .col-md-3 > .nav.nav-tabs a {
        padding: 5px 20px;
        border:0;
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

    .tabs-left >.row>.col-md-3> .nav-tabs > li > a {
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

    div.bhoechie-tab-container{
        z-index: 10;
        background-color: #ffffff;
        padding: 0 !important;
        border-radius: 4px;
        -moz-border-radius: 4px;
        border:1px solid #ddd;
        margin-top: 20px;
        margin-left: 50px;
        -webkit-box-shadow: 0 6px 12px rgba(0,0,0,.175);
        box-shadow: 0 6px 12px rgba(0,0,0,.175);
        -moz-box-shadow: 0 6px 12px rgba(0,0,0,.175);
        background-clip: padding-box;
        opacity: 0.97;
        filter: alpha(opacity=97);
    }

</style>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="gridSystemModalLabel">Modal title</h4>
</div>
<div class="modal-body">
    <div class="">

        <div class="">

            <!-- tabs left -->
            <div class="tabbable tabs-left">
                <div class="row">
                    <div class="col-md-3 ">


                <ul class="nav nav-tabs ">
                    <li class="active"><a href="#a" data-toggle="tab">Summary of Scheme</a></li>
                    <li><a href="#b" data-toggle="tab">Scheme Info</a></li>
                    <li><a href="#c" data-toggle="tab">Scheme Quantity</a></li>
                    <li><a href="#d" data-toggle="tab">Nature of Job</a></li>
                    <li><a href="#e" data-toggle="tab">App Tender</a></li>
                    <li><a href="#f" data-toggle="tab">Contract Sign</a></li>
                    <li><a href="#g" data-toggle="tab">Contractor</a></li>
                    <li><a href="#h" data-toggle="tab">Item & BOQ</a></li>
                    <li><a href="#i" data-toggle="tab">Lab</a></li>
                    <li><a href="#j" data-toggle="tab">Vehicles</a></li>
                    <li><a href="#k" data-toggle="tab">Account</a></li>
                    <li><a href="#l data-toggle=" tab">Picture & Files</a></li>
                </ul>
                    </div>
                    <div class="col-md-9">

                    <div class="tab-content">
                    <div class="tab-pane active" id="a">


                        <div class="">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><?= __('Scheme English Name') ?></label>
                                    <input value="<?= h($scheme->name_en) ?>" class="form-control" type="text"
                                           disabled>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><?= __('Scheme Bangla Name') ?></label>
                                    <input value="<?= h($scheme->name_bn) ?>" class="form-control" type="text"
                                           disabled>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><?= __('Scheme Code') ?></label>
                                    <input value="<?= h($scheme->scheme_code) ?>" class="form-control"
                                           type="text" disabled>

                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label><?= __('Project') ?></label>
                                    <input
                                        value="<?= $scheme->has('project') ? $scheme->project->name_en : '' ?>"
                                        class="form-control" type="text" disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><?= __('District') ?></label>
                                    <input
                                        value="<?= $scheme->has('district') ? $scheme->district->name_en : '' ?>"
                                        class="form-control" type="text" disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><?= __('Financial Year Estimate') ?></label>
                                    <input
                                        value="<?= $scheme->has('financial_year_estimate') ? h($scheme->financial_year_estimate->name) : '' ?>"
                                        class="form-control" type="text" disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><?= __('Upazila') ?></label>
                                    <input
                                        value="<?= $scheme->has('upazila') ? h($scheme->upazila->name_en) : '' ?>"
                                        class="form-control" type="text" disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><?= __('Municipality') ?></label>
                                    <input
                                        value="<?= $scheme->has('municipality') ? h($scheme->municipality->name_en) : '' ?>"
                                        class="form-control" type="text" disabled>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane" id="b">Secondo sed ac orci quis tortor imperdiet venenatis. Duis elementum
                        auctor accumsan.
                        Aliquam in felis sit amet augue.
                    </div>
                    <div class="tab-pane" id="c">Thirdamuno, ipsum dolor sit amet, consectetur adipiscing elit. Duis
                        pharetra varius quam sit amet vulputate.
                        Quisque mauris augue, molestie tincidunt condimentum vitae.
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
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>