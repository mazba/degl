<div id="PrintArea" style="margin-top: 16px">
    <button id="print_button" class="btn btn-warning pull-left" onclick="print_rpt('PrintArea')">
        <i class="icon-print2"></i><?= __('Print') ?>
    </button>
    <br/>
    <br/>
    <h1 style="text-align: center">গনপ্রজাতন্ত্রী বাংলাদেশ সরকার</h1>
    <h5 style="text-align: center">স্থানীয় সরকার প্রকৌশল অধিদপ্তর</h5>
    <h5 style="text-align: center"><?=  $user_office['name_en']; ?></h5>
    <h4 style="text-align: center; text-decoration: underline">উন্নয়ন মূলক প্রকল্পের কাজ সমাপ্তির প্রতিবেদন</h4>
    <table class="table table-bordered">
        <tr>
            <th>খাত</th><td><?= $scheme->development_partners['name_bn'] ?></td>
        </tr>
        <tr>
            <th>প্রকল্পের নাম</th><td><?= $scheme->name_bn ?></td>
        </tr>
        <tr>
            <th>টিকাদারের নাম</th><td><?= $scheme->contractors['contractor_title'] ?></td>
        </tr>
        <tr>
            <th>প্রাক্কলিত ব্যয়</th><td><?= $this->Number->Format($scheme->estimated_cost) ?></td>
        </tr>
        <tr>
            <th>কার্যাদেশ মোতাবেক অনুমোদিত ব্যয়</th><td><?= $this->Number->Format($scheme->contract_amount) ?>    </td>
        </tr>
        <tr>
            <th>কার্যাদেশের তারিখ ও স্মারক নং</th><td><?= $scheme->sarok_no.'&nbsp তারিখ: '.$this->System->display_date($scheme->work_order_date) ?></td>
        </tr>
        <tr>
            <th>কার্যাদেশে অনুযায়ী কাজ আরম্ভের তারিখ</th><td><?= $this->System->display_date($scheme->proposed_start_date) ?></td>
        </tr>
        <tr>
            <th>কাজ আরম্ভের প্রকৃত তারিখ</th><td><?= $this->System->display_date($scheme->actual_start_date) ?></td>
        </tr>
        <tr>
            <th>নিয়োজিত উপ-সহকারী প্রকৌশলীর নাম</th><td><?= $scheme->sub_engineer_name ?></td>
        </tr>
        <tr>
            <th>নিয়োজিত কার্য-সহকারীর নাম</th><td><?= $scheme->assistant_worker ?></td>
        </tr>
        <tr>
            <th>কার্যাদেশে অনুযায়ী কাজ সমাপ্তির তারিখ</th><td><?= $this->System->display_date($scheme->expected_complete_date) ?></td>
        </tr>
        <tr>
            <th>কাজ সমাপ্তির প্রকৃত তারিখ</th><td><?= $this->System->display_date($scheme->actual_complete_date) ?></td>
        </tr>
        <tr>
            <th>অনুমোদিত বর্ধিত সময়</th><td><?= $this->System->display_date($scheme->approve_extended_date) ?></td>
        </tr>
        <tr>
            <th>কাজের মান সম্পর্কিত মন্তব্য</th><td><?= $scheme->work_remarks ?></td>
        </tr>
    </table>
</div>