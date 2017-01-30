<?php use Cake\Routing\Router;?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>LGED</title>

        <link href="<?php echo Router::url('/',true); ?>bs3admin/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo Router::url('/',true); ?>bs3admin/css/londinium-theme.css" rel="stylesheet" type="text/css">
        <link href="<?php echo Router::url('/',true); ?>bs3admin/css/styles.css" rel="stylesheet" type="text/css">
        <link href="<?php echo Router::url('/',true); ?>bs3admin/css/icons.css" rel="stylesheet" type="text/css">

        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">

        <script type="text/javascript" src="<?php echo Router::url('/',true); ?>bs3admin/js/jquery-2.1.1.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>

        <script type="text/javascript" src="<?php echo Router::url('/',true); ?>bs3admin/js/plugins/charts/sparkline.min.js"></script>
        <script type="text/javascript" src="<?php echo Router::url('/',true); ?>bs3admin/js/plugins/forms/uniform.min.js"></script>
        <script type="text/javascript" src="<?php echo Router::url('/',true); ?>bs3admin/js/plugins/forms/select2.min.js"></script>
        <script type="text/javascript" src="<?php echo Router::url('/',true); ?>bs3admin/js/plugins/forms/inputmask.js"></script>
        <script type="text/javascript" src="<?php echo Router::url('/',true); ?>bs3admin/js/plugins/forms/autosize.js"></script>
        <script type="text/javascript" src="<?php echo Router::url('/',true); ?>bs3admin/js/plugins/forms/inputlimit.min.js"></script>
        <script type="text/javascript" src="<?php echo Router::url('/',true); ?>bs3admin/js/plugins/forms/listbox.js"></script>
        <script type="text/javascript" src="<?php echo Router::url('/',true); ?>bs3admin/js/plugins/forms/multiselect.js"></script>
        <script type="text/javascript" src="<?php echo Router::url('/',true); ?>bs3admin/js/plugins/forms/validate.min.js"></script>
        <script type="text/javascript" src="<?php echo Router::url('/',true); ?>bs3admin/js/plugins/forms/tags.min.js"></script>
        <script type="text/javascript" src="<?php echo Router::url('/',true); ?>bs3admin/js/plugins/forms/switch.min.js"></script>
        <script type="text/javascript" src="<?php echo Router::url('/',true); ?>bs3admin/js/plugins/forms/uploader/plupload.full.min.js"></script>
        <script type="text/javascript" src="<?php echo Router::url('/',true); ?>bs3admin/js/plugins/forms/uploader/plupload.queue.min.js"></script>
        <script type="text/javascript" src="<?php echo Router::url('/',true); ?>bs3admin/js/plugins/forms/wysihtml5/wysihtml5.min.js"></script>
        <script type="text/javascript" src="<?php echo Router::url('/',true); ?>bs3admin/js/plugins/forms/wysihtml5/toolbar.js"></script>
        <script type="text/javascript" src="<?php echo Router::url('/',true); ?>bs3admin/js/plugins/interface/daterangepicker.js"></script>
        <script type="text/javascript" src="<?php echo Router::url('/',true); ?>bs3admin/js/plugins/interface/fancybox.min.js"></script>
        <script type="text/javascript" src="<?php echo Router::url('/',true); ?>bs3admin/js/plugins/interface/moment.js"></script>
        <script type="text/javascript" src="<?php echo Router::url('/',true); ?>bs3admin/js/plugins/interface/jgrowl.min.js"></script>
        <script type="text/javascript" src="<?php echo Router::url('/',true); ?>bs3admin/js/plugins/interface/datatables.min.js"></script>
        <script type="text/javascript" src="<?php echo Router::url('/',true); ?>bs3admin/js/plugins/interface/colorpicker.js"></script>
        <script type="text/javascript" src="<?php echo Router::url('/',true); ?>bs3admin/js/plugins/interface/fullcalendar.min.js"></script>
        <script type="text/javascript" src="<?php echo Router::url('/',true); ?>bs3admin/js/plugins/interface/timepicker.min.js"></script>
        <script type="text/javascript" src="<?php echo Router::url('/',true); ?>bs3admin/js/plugins/interface/collapsible.min.js"></script>

        <script type="text/javascript" src="<?php echo Router::url('/',true); ?>bs3admin/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo Router::url('/',true); ?>bs3admin/js/application.js"></script>

    </head>

<body class="full-width page-condensed">

	<!-- Navbar -->
	<div class="navbar navbar-inverse" role="navigation">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-right">
				<span class="sr-only">Toggle navbar</span>
				<i class="icon-grid3"></i>
			</button>
			<a class="navbar-brand" href="#"><img width="75" height="35" src="<?= $this->request->webroot; ?>img/bangladesh_govt_logo_0.gif" ><?= __('Local Government Engineering Department (LGED)') ?></a>
		</div>

		<ul class="nav navbar-nav navbar-right collapse">

		</ul>
	</div>
	<!-- /navbar -->


	<!-- Login wrapper -->
	<div class="login-wrapper">
        <?php echo $this->fetch('content'); ?>
	</div>
	<!-- /login wrapper -->


    <!-- Footer -->
    <div class="footer ">
        <div class="pull-left">&copy; 2007-2015 Developed by <a href="http://softbdltd.com">Softbd</a></div>
    	<div class="pull-right icons-group">
            <p style="color: #cf2a0e"><?= __('তদন্ত প্রতিবেদন দাখিলের জন্য অ্যাপস') ?> <a class="btn btn-warning" style="float: none;color: #ffffff;padding: 3px 10px" href="<?= $this->request->webroot; ?>LGED_APK_SOFTBD.apk"><i style="color: #008a00" class="icon-android"></i>Download </a></p>
    	</div>
    </div>
    <!-- /footer -->


</body>
</html>