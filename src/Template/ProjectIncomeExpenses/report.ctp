<div class="col-md-12" style="margin-top: 20px; border: 1px solid #eee">
    <button onclick="print_rpt('received_print_wrp')" class="btn btn-right-icon btn-info" type="button" style="margin-top: 10px; float: right"><i class="icon-print"></i><?= __('Print') ?></button>
    <div id="received_print_wrp">
        <h1 style="text-align: center"><?= $financial_yr_text;  ?> প্রকল্পপ অনুকুলে প্রাপ্ত অর্থ ও ব্যয়ের হিসাব , <?= $user_office['name_bn'] ?></h1>
        <hr>
        <span class="pull-right">তারিখ : <?= date('d-m-Y') ?></span>
        <table class="table table-bordered" style="border: 1px solid #eee;margin-top: 25px;">
            <thead>
                <tr>
                    <th class="text-center">ক্রমিক নং </th>
                    <th class="text-center">প্রকল্পের নাম</th>
                    <th class="text-center">প্রাপ্ত অর্থ  (লক্ষ টাকা)</th>
                    <th class="text-center">ব্যয়িত অর্থ (লক্ষ টাকা)</th>
                    <th class="text-center">অব্যয়িত অর্থ (লক্ষ টাকা)</th>
                    <th class="text-center" style="width: 120px"></th>
                </tr>
            <tr>
                <td class="text-center">১</td>
                <td class="text-center">২</td>
                <td class="text-center">৩</td>
                <td class="text-center">৪</td>
                <td class="text-center">৫</td>
                <td class="text-center">৬</td>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 0;
            $total_debit = 0;
            $total_credit = 0;
            $total_extra = 0;
            foreach($data as $dd)
            {
                $i++;
                $dd['Credit'] = isset($dd['Credit']) ? $dd['Credit'] : 0;
                $dd['Debit'] = isset($dd['Debit']) ? $dd['Debit'] : 0;
                ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= $dd['name'] ?></td>
                    <td><?= $dd['Debit'] ?></td>
                    <td><?= $dd['Credit'] ?></td>
                    <td><?= ($dd['Debit'] - $dd['Credit']) ?></td>
                    <td></td>
                </tr>
                <?php
                $total_debit+= $dd['Debit'];
                $total_credit+= $dd['Credit'];
                $total_extra+= ($dd['Debit'] - $dd['Credit']);
            }
            ?>
            </tbody>
            <tfoot>
            <tr>
                <td></td>
                <td style="text-align:right;font-weight: bold">সর্বমোট</td>
                <td style="text-align: center; font-weight: bold"><?= $total_debit ?></td>
                <td style="text-align: center; font-weight: bold"><?= $total_credit ?></td>
                <td style="text-align: center; font-weight: bold"><?= $total_extra ?></td>
                <td></td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>