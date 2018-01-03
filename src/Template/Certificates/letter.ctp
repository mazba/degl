<?php
use Cake\Routing\Router;
//pr($result['original_commencemen']);die;
?>
<div class="col-md-12">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="col-sm-12">
    <button style="float: right;margin-top: 5px" onclick="print_rpt()">Print</button>
</div>
<div id="PrintArea">
    <div class="col-sm-12">
        <h2 class="text-center" style="line-height: 10px;font-size: 20px;"><?php echo('Government of the People\'s Republic of Bangladesh'); ?></h2>
        <h4 class="text-center" style="line-height: 10px"><?php echo('Local Govt. Engineering Department'); ?> </h4>
        <h4 class="text-center" style="line-height: 10px"><?php echo('Office of the Executive Engineer'); ?></h4>
        <h4 class="text-center" style="line-height: 10px">Naljani, <?php echo('District: Gazipur'); ?></h4>
        <h4 class="text-center" style="line-height: 10px"><a>www.lged.gov.bd</a></h4>
        <div class="shek-hasina" style="display: inline-block;
    position: absolute;
    right: 21px;
    top: 30px;
    border: 1px solid #ccc;
    padding: 5px 10px;
    text-align: center;
    color: #ccc;
    font-size: 15px;
    width: 180px;">
            উন্নয়নের গণতন্ত্র<br/>শেখ হাসিনার মূলমন্ত্র
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="col-sm-8">
                <p>Memo No:  <span contenteditable="true"></span></p>
            </div>
            <div class="col-sm-4">
                <p style="float: right">Date: <span contenteditable="true"></span></p>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="text-center" style="margin-top: -25px !important;; margin-bottom: 5px !important;" >
            <h3 style="margin-top: -22px !important;"><u>COMPLETION CERTIFICATE</u></h3>
        </div>
    </div>
    <div class="panel-body">

        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered show-grid" style="width:100%;">

                    <tr>
                        <td colspan="4" style="padding:0px !important; margin:0px !important;">
                            <table class="table table-bordered show-grid" style="width:100%;    margin: 0px;">
                                <tr>
                                    <td width="5%">01</td>
                                    <td colspan="3">Procuring Entry Details</td>

                                </tr>
                                <tr>
                                    <td width="5%"></td>
                                    <td width="29.9%">(a) District</td>
                                    <td width="5%">:</td>
                                    <td width="60%">
                                        <?= $result['district']?$result['district']:''?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="5%"></td>
                                    <td width="29.9%">(b) Circle/Directorate</td>
                                    <td width="5%">:</td>
                                    <td width="60%">
                                        <span contenteditable="true">Write Here</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="5%"></td>
                                    <td width="29.9%">(c) Zone/Region</td>
                                    <td width="5%">:</td>
                                    <td width="60%">
                                        <?= $result['upazila']?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="5%"></td>
                                    <td width="29.9%">(d) Others (Specify)</td>
                                    <td width="5%">:</td>
                                    <td width="60%">
                                        <span contenteditable="true">Write Here</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td width="5.1%">02</td>
                        <td width="30%">Name of Works</td>
                        <td width="5%">:</td>
                        <td width="60%">
                            <?= $result['scheme_name']?$result['scheme_name']:'' ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="5.1%">03</td>
                        <td width="30%">Contractor No</td>
                        <td width="5%">:</td>
                        <td width="60%">
                            <?= $result['contractor_phone']?$result['contractor_phone']:'' ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="5.1%">04</td>
                        <td width="30%">Contractor’s Legal Title</td>
                        <td width="5%">:</td>
                        <td width="60%">
                            <?= $result['contractor_title']?$result['contractor_title']:''?>
                        </td>
                    </tr>

                    <tr>
                        <td width="5.1%">05</td>
                        <td width="30%">Contractor’s Contract Details</td>
                        <td width="5%">:</td>
                        <td width="60%">
                            <?= $result['contractor_person_name']?$result['contractor_person_name']:''?>
                            <br/>
                            <?= $result['contractor_address']?$result['contractor_address']:'' ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="5.1%">06</td>
                        <td width="30%">Contractor’s Trade License/Enlistment/Registration Details</td>
                        <td width="5%">:</td>
                        <td width="60%">
                            <?= $result['trade_licence_no']?$result['trade_licence_no']:'' ?>
                        </td>
                    </tr>

                    <tr>
                        <td width="5.1%">07</td>
                        <td width="30%">Reference to NOA with Date</td>
                        <td width="5%">:</td>
                        <td width="60%">
                            <?= $result['noa_date']?date('d-m-Y', $result['noa_date']):' '?>
                        </td>
                    </tr>
                    <tr>
                        <td width="5.1%">08</td>
                        <td width="30%">Original Contract Price as in NOA</td>
                        <td width="5%">:</td>
                        <td width="60%">
                            <?= $result['contract_amount']?$result['contract_amount']:'' ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="5.1%">09</td>
                        <td width="30%">Final Contract Price as Executed</td>
                        <td width="5%">:</td>
                        <td width="60%">
                            <?= $result['serve_amount']?$result['serve_amount']:''  ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="padding:0px !important; margin:0px !important;">
                            <table class="table table-bordered show-grid" style="width:100%;    margin: 0px;">
                                <tr>
                                    <td width="5%">10</td>
                                    <td colspan="3">Original Contract Period</td>

                                </tr>
                                <tr>
                                    <td width="5%"></td>
                                    <td width="29.9%">(a) Date of Commencement </td>
                                    <td width="5%">:</td>
                                    <td width="60%">
                                        <?= $result['original_commencemen']? date('d-m-Y', $result['original_commencemen']): ' '?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="5%"></td>
                                    <td width="29.9%">(b) Date of Completion </td>
                                    <td width="5%">:</td>
                                    <td width="60%">
                                        <?= $result['original_completion']? date('d-m-Y', $result['original_completion']): ' '?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="padding:0px !important; margin:0px !important;">
                            <table class="table table-bordered show-grid" style="width:100%;    margin: 0px;">
                                <tr>
                                    <td width="5%">11</td>
                                    <td colspan="3">Actual Implementation Period</td>
                                </tr>
                                <tr>
                                    <td width="5%"></td>
                                    <td width="29.9%">(a) Date of Actual Commencement  </td>
                                    <td width="5%">:</td>
                                    <td width="60%">
                                        <?= $result['actual_commencemen']? date('d-m-Y', $result['actual_commencemen']): ' '?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="5%"></td>
                                    <td width="29.9%">(b) Date of Actual Completion  </td>
                                    <td width="5%">:</td>
                                    <td width="60%">
                                        <?= $result['actual_completion']? date('d-m-Y', $result['actual_completion']): ' '?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td width="5.1%">12</td>
                        <td width="30%">Days/Months Contract Period Extended</td>
                        <td width="5%">:</td>
                        <td width="60%">
                            <span contenteditable="true">Write Here</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="5.1%">13</td>
                        <td width="30%">Amount of Bonus for Early Completion</td>
                        <td width="5%">:</td>
                        <td width="60%">
                            <span contenteditable="true">Write Here</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="5.1%">14</td>
                        <td width="30%">Amount of LD for Delayed Completion</td>
                        <td width="5%">:</td>
                        <td width="60%">
                            <span contenteditable="true">Write Here</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="5.1%">15</td>
                        <td width="30%">Defect Liblities Period </td>
                        <td width="5%">:</td>
                        <td width="60%">
                            <span contenteditable="true">Write Here</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="5.1%">16</td>
                        <td width="30%">Physical Progress In Percent (In terms of value)</td>
                        <td width="5%">:</td>
                        <td width="60%">
                            <span contenteditable="true">Write Here</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="5.1%">17</td>
                        <td width="30%">Financial Progress In Amount (In terms of payment)</td>
                        <td width="5%">:</td>
                        <td width="60%">
                            <span contenteditable="true">Write Here</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="5.1%">18</td>
                        <td width="30%">Special Note (If any)</td>
                        <td width="5%">:</td>
                        <td width="60%">
                            <span contenteditable="true">Write Here</span>
                        </td>
                    </tr>


                </table>
                <p style="text-align:justify">
                    Certificate that the works under the contract has been executed and completed in all respects in strict compliance with the provisions of the contract including all plans, designs, drawings, specifications and all modification there of as per direction and satisfaction of the project Manager/Engineer-in Charge/Other(specify). All defects in workmanship and materials reported during construction have been duly corrected.
                </p>

            </div>
        </div>
        <div class="row">
            <div style="margin-top: 50px; width: 100% !important;">

<table style="width:100%">
  
  <tr>
    <td width="20%" valign="top" style="text-align:center;"> <img style="padding-left: 20px !important;" src="<?php echo Router::url('/', true) . 'img/qr_code/' . $result['qr_image']; ?>" alt="" height="90px" width="100px"> <br/>
    <span >
                Authenticity of this page is <br/>
verifiable from 
http://www.lgedgazipur.gov.bd <br/>
With the QR Code.
    </span>
</td>
    <td width="50%" valign="top"><p class="text-center" style="float: right;font-size:15px; padding-right: 20px">
                    Md. Amirul Islam Khan<br>
                    Executive Engineer<br>
                    LGED, Gazipur<br>
                    Phone:9263989, Faz:9264128 <br>
                    Email: xen.gazipur@lged.gov.bd<br>
                </p></td> 
   
  </tr>
</table>
               


                
                
                
            </div>

        </div>
    </div>
    <style type="text/css">
        .shek-hasina {
            display: inline-block;
            position: absolute;
            right: 73px;
            top: 30px;
            border: 1px solid #ccc;
            padding: 5px;
            text-align: center;
            color: #ccc;
            font-size: 13px;
        }
        th{
            font-weight: normal !important;
        }
        p{
            font-size: 15px;
        }
        .table td:nth-child(2) { width: 293px; }
        @media print {
            .shek-hasina {
                display: inline-block;
                position: absolute;
                right: 50px;
                top: 10px;
                border: 1px solid #ccc;
                padding: 5px;
                text-align: center;
                color: #ccc;
                font-size: 13px;
            }
        }
        body{
            font-family: 'SutonnyOMJ' !important;

        }
        .tablesorter {
            font-family: 'SutonnyOMJ' !important;
        }

        table tr thead th {

            font-family: 'SutonnyOMJ' !important;
        }

        table tr td {
            font-family: 'SutonnyOMJ' !important;
        }
        .table>tbody>tr>td
        {
            padding: 0px 0px 0px 10px !important;
            font-size:12px !important;
        }
    </style>
</div>

<script>
    function print_rpt() {
        URL = "<?php echo $this->request->webroot; ?>page/Print_a4_Eng.php?selLayer=PrintArea";
        day = new Date();
        id = day.getTime();
        eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=yes,scrollbars=yes ,location=0,statusbar=0 ,menubar=yes,resizable=1,width=880,height=600,left = 20,top = 50');");
    }
</script>