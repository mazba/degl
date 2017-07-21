<?php
use Cake\Routing\Router;
?>
<div class="col-md-12">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="col-sm-12">
    <button style="float: right;margin-top: 5px" onclick="print_rpt()">Print</button>
</div>
<div id="PrintArea">
    <div class="col-sm-12">
        <h2 class="text-center" style="line-height: 14px"><?=

            __('Government of the People\'s Republic of Bangladesh') ?></h2>
        <h4 class="text-center" style="line-height: 14px"><?= __('Local Govt. Engineering Department') ?> </h4>
        <h4 class="text-center" style="line-height: 14px"><?= __('Office of the Executive Engineer') ?></h4>
        <h4 class="text-center" style="line-height: 14px">নলজানী,<?= __('District: Gazipur') ?></h4>
        <h4 class="text-center" style="line-height: 14px"><a>www.lged.gov.bd</a></h4>
        <div class="shek-hasina">
            উন্নয়নের গণতন্ত্র<br/>শেখ হাসিনার মূলমন্ত্র
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="col-sm-8">
                <p>স্মারক নং - <span contenteditable="true">এখানে স্মারক নং লিখুন</span></p>
            </div>
            <div class="col-sm-4">
                <p style="float: right">তারিখ: <span contenteditable="true"><?= $this->Common->EngToBanglaNum(date('d-m-Y')). ' ইং' ?></span></p>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="text-center" style="margin-top: 2em; margin-bottom: 3em" >
            <h3><u>"কার্য সম্পাদন সনদ"</u></h3>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12" style="line-height: 45px">
                এই মর্মে প্রত্যয়ন করা যাচ্ছে যে, <?= $result['contractor_title']?$result['contractor_title'].', ':''?>
                <?= $result['contractor_person_name']?$result['contractor_person_name'].', ':''?>
                <?= $result['contractor_address']?$result['contractor_address']:'' ?>
                <?= $result['contractor_tin_no']?'(TIN '.$result['contractor_tin_no'].' )':''?> থেকে তিনি <?= $result['fiscal_year']?>
                অর্থ বছরে গাজীপুর জেলায় এলজিইডি'র আওতায় নিম্নেবর্ণিত কাজটি যথাযথ ভাবে সম্পাদন  করেছেন ।
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered show-grid">
                    <thead>
                    <tr>
                        <th><?= __('ক্রমিক নং') ?></th>
                        <th><?= __('কাজের নাম') ?></th>
                        <th><?= __('চুক্তিমূল্য   ') ?></th>
                        <th><?= __('পরিশোধিত মূল্য') ?></th>
                        <th><?= __('মন্তব্য') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>১</td>
                        <td><?= $result['scheme_name'] ?></td>
                        <td><?= $result['contract_amount'] ?></td>
                        <td>
                            <?php if(!empty(trim($result['serve_amount']))): ?>
                                <?= $result['serve_amount'] ?>
                            <?php else: ?>
                                <span contenteditable="true">পরিশোধিত মূল্য লিখুন</span>
                            <?php endif; ?>
                        </td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div style="margin-top: 40px; width: 100% !important;">
                <img style="padding-left: 20px !important;" src="<?php echo Router::url('/', true) . 'img/qr_code/' . $result['qr_image']; ?>" alt="" height="150px" width="170px">
                <p class="text-center" style="float: right;font-size:15px; padding-right: 20px">
                    (মো: আমিরুল ইসলাম খান)<br>
                    নির্বাহী প্রকৌশলী<br>
                    এলজিইডি, গাজীপুর<br>
                    ফোনঃ ৯২৬৩৯৮৯, ফ্যাক্সঃ ৯২৬৪১২৮<br>
                    Email: xen.gazipur@lged.gov.bd<br>
                </p>
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
            font-family: 'SutonnyOMJ' !important;;
        }

        table tr thead th {

            font-family: 'SutonnyOMJ' !important;;
        }

        table tr td {
            font-family: 'SutonnyOMJ' !important;;
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