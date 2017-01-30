<?php use Cake\Routing\Router; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>LGED</title>
    <link href="<?php echo Router::url('/', true); ?>css/lightbox.css" rel="stylesheet" type="text/css">
    <!--        <link href="-->
    <?php //echo Router::url('/',true); ?><!--bs3admin/css/cake.css" rel="stylesheet" type="text/css">-->
    <link href="<?php echo Router::url('/', true); ?>bs3admin/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Router::url('/', true); ?>bs3admin/css/londinium-theme.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Router::url('/', true); ?>bs3admin/css/styles.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Router::url('/', true); ?>bs3admin/css/icons.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Router::url('/', true); ?>css/common.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Router::url('/', true); ?>fullcalendar/fullcalendar.css" rel='stylesheet' />
    <link href="<?php echo Router::url('/', true); ?>fullcalendar/fullcalendar.print.css" rel='stylesheet' media='print' />
    <!-- autocomplete-->
    <?php
    echo $this->Html->css('bootstrap-chosen.css');
    ?>
    <!--        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">-->

    <script type="text/javascript" src="<?php echo Router::url('/', true); ?>bs3admin/js/jquery-2.1.1.js"></script>
    <script type="text/javascript" src="<?php echo Router::url('/', true); ?>bs3admin/js/jquery-ui.min.js"></script>
    <!--        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>-->

    <script type="text/javascript"
            src="<?php echo Router::url('/', true); ?>bs3admin/js/plugins/charts/sparkline.min.js"></script>
    <script type="text/javascript"
            src="<?php echo Router::url('/', true); ?>bs3admin/js/plugins/forms/uniform.min.js"></script>
    <script type="text/javascript"
            src="<?php echo Router::url('/', true); ?>bs3admin/js/plugins/forms/select2.min.js"></script>
    <script type="text/javascript"
            src="<?php echo Router::url('/', true); ?>bs3admin/js/plugins/forms/inputmask.js"></script>
    <script type="text/javascript"
            src="<?php echo Router::url('/', true); ?>bs3admin/js/plugins/forms/autosize.js"></script>
    <script type="text/javascript"
            src="<?php echo Router::url('/', true); ?>bs3admin/js/plugins/forms/inputlimit.min.js"></script>
    <script type="text/javascript"
            src="<?php echo Router::url('/', true); ?>bs3admin/js/plugins/forms/listbox.js"></script>
    <script type="text/javascript"
            src="<?php echo Router::url('/', true); ?>bs3admin/js/plugins/forms/multiselect.js"></script>
    <script type="text/javascript"
            src="<?php echo Router::url('/', true); ?>bs3admin/js/plugins/forms/validate.min.js"></script>
    <script type="text/javascript"
            src="<?php echo Router::url('/', true); ?>bs3admin/js/plugins/forms/tags.min.js"></script>
    <script type="text/javascript"
            src="<?php echo Router::url('/', true); ?>bs3admin/js/plugins/forms/switch.min.js"></script>
    <script type="text/javascript"
            src="<?php echo Router::url('/', true); ?>bs3admin/js/plugins/forms/uploader/plupload.full.min.js"></script>
    <script type="text/javascript"
            src="<?php echo Router::url('/', true); ?>bs3admin/js/plugins/forms/uploader/plupload.queue.min.js"></script>
    <script type="text/javascript"
            src="<?php echo Router::url('/', true); ?>bs3admin/js/plugins/forms/wysihtml5/wysihtml5.min.js"></script>
    <script type="text/javascript"
            src="<?php echo Router::url('/', true); ?>bs3admin/js/plugins/forms/wysihtml5/toolbar.js"></script>
    <script type="text/javascript"
            src="<?php echo Router::url('/', true); ?>bs3admin/js/plugins/interface/daterangepicker.js"></script>
    <script type="text/javascript"
            src="<?php echo Router::url('/', true); ?>bs3admin/js/plugins/interface/fancybox.min.js"></script>
    <script type="text/javascript"
            src="<?php echo Router::url('/', true); ?>bs3admin/js/plugins/interface/moment.js"></script>
    <script type="text/javascript"
            src="<?php echo Router::url('/', true); ?>bs3admin/js/plugins/interface/jgrowl.min.js"></script>
    <script type="text/javascript"
            src="<?php echo Router::url('/', true); ?>bs3admin/js/plugins/interface/datatables.min.js"></script>
    <script type="text/javascript"
            src="<?php echo Router::url('/', true); ?>bs3admin/js/plugins/interface/colorpicker.js"></script>
    <script type="text/javascript"
            src="<?php echo Router::url('/', true); ?>bs3admin/js/plugins/interface/fullcalendar.min.js"></script>
    <script type="text/javascript"
            src="<?php echo Router::url('/', true); ?>bs3admin/js/plugins/interface/timepicker.min.js"></script>
    <script type="text/javascript"
            src="<?php echo Router::url('/', true); ?>bs3admin/js/plugins/interface/collapsible.min.js"></script>

    <script type="text/javascript" src="<?php echo Router::url('/', true); ?>bs3admin/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo Router::url('/', true); ?>bs3admin/js/application.js"></script>

    <script src="<?php echo Router::url('/', true); ?>fullcalendar/lib/moment.min.js"></script>
    <script src="<?php echo Router::url('/', true); ?>fullcalendar/fullcalendar.min.js"></script>


    <!--  autocomplete-->
    <?php
    echo $this->Html->script('chosen.jquery.js');
    ?>
    <script>
        $(function () {
            $('.chosen-select').chosen();
            $('#scheme-id').chosen();//for all schemes
            $('.chosen-select-deselect').chosen({allow_single_deselect: true});
        });
    </script>
    <!-- datepicker-->
    <script type="text/javascript">
        var display_date_format = "dd-M-yy";
        jQuery(document).ready(function () {
            $(".hasdatepicker").datepicker({
                dateFormat: display_date_format,
                changeMonth: true,
                changeYear: true,
                yearRange: "-50:+10"
            });
        });
    </script>

    <!-- JQ Grid -->
    <script src="<?php echo $this->request->webroot; ?>js/jq/jqxcore.js" type="text/javascript"></script>
    <script src="<?php echo $this->request->webroot; ?>js/jq/jqxgrid.js" type="text/javascript"></script>
    <script src="<?php echo $this->request->webroot; ?>js/jq/jqxscrollbar.js" type="text/javascript"></script>
    <script src="<?php echo $this->request->webroot; ?>js/jq/jqxdropdownlist.js" type="text/javascript"></script>
    <script src="<?php echo $this->request->webroot; ?>js/jq/jqxgrid.edit.js" type="text/javascript"></script>
    <script src="<?php echo $this->request->webroot; ?>js/jq/jqxgrid.sort.js" type="text/javascript"></script>
    <script src="<?php echo $this->request->webroot; ?>js/jq/jqxgrid.pager.js" type="text/javascript"></script>
    <script src="<?php echo $this->request->webroot; ?>js/jq/jqxbuttons.js" type="text/javascript"></script>
    <script src="<?php echo $this->request->webroot; ?>js/jq/jqxcheckbox.js" type="text/javascript"></script>
    <script src="<?php echo $this->request->webroot; ?>js/jq/jqxlistbox.js" type="text/javascript"></script>
    <script src="<?php echo $this->request->webroot; ?>js/jq/jqxdropdownlist.js" type="text/javascript"></script>
    <script src="<?php echo $this->request->webroot; ?>js/jq/jqxmenu.js" type="text/javascript"></script>
    <script src="<?php echo $this->request->webroot; ?>js/jq/jqxgrid.sort.js" type="text/javascript"></script>
    <script src="<?php echo $this->request->webroot; ?>js/jq/jqxlistbox.js" type="text/javascript"></script>
    <script src="<?php echo $this->request->webroot; ?>js/jq/jqxmenu.js" type="text/javascript"></script>
    <script src="<?php echo $this->request->webroot; ?>js/jq/jqxgrid.filter.js" type="text/javascript"></script>
    <script src="<?php echo $this->request->webroot; ?>js/jq/jqxgrid.selection.js" type="text/javascript"></script>
    <script src="<?php echo $this->request->webroot; ?>js/jq/jqxgrid.columnsresize.js" type="text/javascript"></script>
    <script src="<?php echo $this->request->webroot; ?>js/jq/jqxdata.js" type="text/javascript"></script>
    <script src="<?php echo $this->request->webroot; ?>js/jq/jqxdatatable.js" type="text/javascript"></script>
    <link href="<?php echo $this->request->webroot; ?>css/jq/jqx.base.css" rel="stylesheet" type="text/css">

    <script src="<?php echo $this->request->webroot; ?>js/common.js" type="text/javascript"></script>

    <!-- END JQ Grid -->

    <!--CK Editor Add-->

    <script src="<?php echo $this->request->webroot; ?>ckeditor/ckeditor.js" type="text/javascript"></script>


</head>
    <body class="sidebar-wide">

    <div class="navbar navbar-inverse" role="navigation">
        <?php echo $this->element('header'); ?>
        <?php echo $this->element('top_menu'); ?>
    </div>
    <div class="page-container">


        <!-- Page content -->

        <div class="page-content col-md-12">
            <?php echo $this->element('left_menu'); ?>
            <?= $this->Flash->render() ?>

            <div style="min-height: 530px;">
                <?php echo $this->fetch('content'); ?>
            </div>

            <?php echo $this->element('footer'); ?>

        </div>

        <!-- /page content -->

    </div>
    <div id="loader">
        <img src="<?php echo Router::url('/', true); ?>img/loading-spinner-default.gif">
    </div>
    <!-- /page container -->
    <script type="text/javascript" src="<?php echo Router::url('/', true); ?>js/lightbox.js"></script>
    <script>
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'fitImagesInViewport': true
        })
    </script>
</body>

</html>