<?php
use Cake\Routing\Router;
?>
<div class="row">
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
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="col-sm-8">
            <p>স্মারক নং - <span contenteditable="true">এখানে স্মারক নং লিখুন</span></p>
        </div>
        <div class="col-sm-4">
            <p style="float: right">তারিখ: <?= $this->Common->EngToBanglaNum(date('d-m-Y')). ' ইং' ?></p>
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
            <p><?= __('কাজের নাম') ?> : <?= $result['scheme_name'] ?></p>
            <p><?= __('চুক্তিমূল্য   ') ?> : <?= $result['contract_amount'] ?></p>
            <p><?= __('পরিশোধিত মূল্য') ?> : <?= $result['serve_amount'] ?></p>

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
