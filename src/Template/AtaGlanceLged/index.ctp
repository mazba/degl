<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Cashbooks') ?> </li>
    </ul>
</div>
<div class="col-md-12" id="print_wrp">
    <button id="print_button" onclick="print_rpt('print_wrp')" class="btn btn-right-icon btn-info" type="button" style="margin: 10px 0; float: right"><i class="icon-print"></i><?= __('Print') ?></button>
    <h3 class="text-center">
        এক নজরে এলজিইডি এলজিইডি,উন্নয়নমূলক কাজের তথ্যাদি
    </h3>
    <table class="table table-bordered table-responsive" style="border: 0 !important; outline: 0px !important;">
        <thead>
        <tr style="border: 0 !important;">
            <th>ক্রমিক নং</th>
            <th>কৃত কাজের বিবরণ </th>
            <th>বিবরণ অনুযায়ী জবাব</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>১</td>
            <td><?= $pre_financial_year['name'] ?>  অর্থ বছরে কত কিঃমিঃ রাস্তা পাকা করা হয়েছে এবং ব্যয় কত?</td>
            <td><?= $pre_financial_year_data['concrete_road'] ?>   কিঃমিঃ রাস্তা পাকা করা হয়েছে এবং যার ব্যয়  <?= $pre_financial_year_data['concrete_road_contract_amount']/10000000 ?> কোটি টাকা ।</td>
        </tr>
        <tr>
            <td>২</td>
            <td><?= $pre_financial_year['name'] ?> অর্থ বছরে কত কিঃমিঃ রাস্তা মেরামত করা হয়েছে এবং ব্যয় কত?</td>
            <td><?= $pre_financial_year_data['maintenance_road'] ?> কিঃমিঃ রাস্তা মেরামত করা হয়েছে এবং যার ব্যয়  <?= $pre_financial_year_data['maintenance_road_contract_amount']/10000000 ?> কোটি টাকা ।</td>
        </tr>
        <tr>
            <td>৩</td>
            <td><?= $current_financial_year['name'] ?>  অর্থ বছরে কত কিঃমিঃ রাস্তা পাকা করা হবে  এবং ব্যয় কত?</td>
            <td><?= $current_financial_year_data['concrete_road'] ?>   কিঃমিঃ রাস্তা পাকা করা হবে  এবং যার ব্যয়  <?= $current_financial_year_data['concrete_road_contract_amount']/10000000 ?> কোটি টাকা ।</td>
        </tr>
        <tr>
            <td>৪</td>
            <td><?= $current_financial_year['name'] ?> অর্থ বছরে কত কিঃমিঃ রাস্তা মেরামত করা হবে এবং ব্যয় কত?</td>
            <td><?= $current_financial_year_data['maintenance_road'] ?> কিঃমিঃ রাস্তা মেরামত করা হবে  এবং যার ব্যয়  <?= $current_financial_year_data['maintenance_road_contract_amount']/10000000 ?> কোটি টাকা ।</td>
        </tr>
        <tr>
            <td>৫</td>
            <td>RERMP এর তথ্য</td>
            <td></td>

        </tr>
        <tr>
            <td>৬</td>
            <td>কইটি প্রকল্প চলমান আছে নামসহ ?</td>
            <td>
                <?= $projects->count() ?>  টি । যথা -
                <?php
                foreach($projects as $project){
                    echo $project['projects']['short_code'].', ';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>৭</td>
            <td><?= $pre_financial_year['name'] ?> অর্থ বছরে কতটি ব্রীজ শেষ হয়েছে?</td>
            <td><?= $pre_financial_year_data['bridge'] ?> </td>
        </tr>
        <tr>
            <td>৮</td>
            <td><?= $current_financial_year['name'] ?> অর্থ বছরে কতটি ব্রীজ চলমান আছে?</td>
            <td><?= $current_financial_year_data['bridge'] ?> </td>
        </tr>
        <tr>
            <td>৯</td>
            <td>Road Invertory তে রাস্তার তথ্য</td>
            <td></td>

        </tr>
        <tbody/>
    </table>
</div>
<script type="text/javascript">
    $(document).ready(function(){

    });
    function print_rpt($printArea){
        URL="<?php echo $this->request->webroot; ?>page/Print_a4_Eng.php?selLayer="+$printArea;
        day = new Date();
        id = day.getTime();
        eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=yes,scrollbars=yes ,location=0,statusbar=0 ,menubar=yes,resizable=1,width=880,height=600,left = 20,top = 50');");
    }
</script>