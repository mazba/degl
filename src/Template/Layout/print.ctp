<?php
/**
** mazba
** 29-08-15
 */
?>
    <html>
    <head>
        <link href="<?php echo $this->request->webroot; ?>bs3admin/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="<?php echo $this->request->webroot; ?>bs3admin/js/jquery-2.1.1.js"></script>
        <style type="text/css" media="all">

            page[size="A4"] {
                background: white;
                width: 21cm;
                height: 29.7cm;
                display: block;
                margin: 0 auto;
                margin-bottom: 0.5cm;
                box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
            }
            @media print {
                body, page[size="A4"] {
                    margin: 0;
                    box-shadow: 0;
                }
            }
        </style>
    </head>
    <body>
        <?= $this->fetch('content') ?>
    </body>
    </html>
