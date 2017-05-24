<link href="https://fonts.googleapis.com/css?family=Asap" rel="stylesheet">
<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyDm0DLjHrJ0j56M4Od2ch81kP0wIIhDpzk"></script>
<div class="col-sm-12">
    <button style="float: right;margin-top: 5px" onclick="print_rpt()">Print</button>
</div>
<div id="PrintArea">
    <div class="panel-body" align="center" style="background-color: #DBEAF9;color: #0c0c0c;">

        <h1 align="center">নির্বাহী প্রকৌশলী </h1>

        <h2 align="center"> স্থানীয় সরকার প্রকৌশল অধিদপ্তর, গাজীপুর</h2>
        <br/> <br/>
        <div  style="width:100%; text-align: center;">
            <table style="width:100%">
                <tr>
                    <td width="50%"><b>স্কিমের নাম: </b> <?= $letter_data['scheme']['name_en'] ?>   </td>
                    <td width="50%"><b>তারিখঃ </b> <?= date('d-m-Y', $letter_data['created_date']) ?>  </td>

                </tr>
            </table>
            <br/><br/>

            <div  style="width:100%; text-align: left; margin-left:3%; padding-right:3%;">
                <b> স্মারক নম্বর: । <?= $letter_data['sarok_no'] ?></b><br>
                <b> বিষয়: । <?= $letter_data['subject'] ?></b>

                <br/><br/>

                <table style="width:100%" align="left">
                    <tr>
                        <td width="100%" style="padding-left: 1em">
                            <?= $letter_data['description'] ?>
                        </td>
                    </tr>
                </table>
                <br/><br/><br/>
            </div>
        </div>
    </div>
</div>
<script>
    function print_rpt() {
        URL = "<?php echo $this->request->webroot; ?>page/Print_a4_Eng.php?selLayer=PrintArea";
        day = new Date();
        id = day.getTime();
        eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=yes,scrollbars=yes ,location=0,statusbar=0 ,menubar=yes,resizable=1,width=880,height=600,left = 20,top = 50');");
    }
</script>