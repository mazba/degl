<div class="col-md-12" style="overflow: scroll; margin-top: 10px" id="PrintArea">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th rowspan="2">তারিখ</th>
            <th rowspan="2">ক্যাশ বইয়ের পাতা নং</th>
            <th rowspan="2">মোট বিল</th>
            <th rowspan="2">পূর্বের বিল সহ, মোট বিলের পরিমান </th>
            <th colspan="10">বিল হইতে সমন্বয় </th>
            <th rowspan="2">নীট পরিশোধ</th>
            <th colspan="3">প্রত্যাপর্ণ</th>
            <th rowspan="2">মন্তব্য</th>
        </tr>
        <tr>
            <th>জামানত</th>
            <th>ভ্যাট</th>
            <th>আয়কর</th>
            <th>পূর্বের বিল সহ মোট আয়কর</th>
            <th>বিভাগীয় উদ্ধারকৃত মালামালের আয়কর</th>
            <th>বিভাগীয় উদ্ধারকৃত মালামালের ভ্যাট</th>
            <th>রোলারের ভাড়া</th>
            <th>ল্যাব টেস্ট</th>
            <th>মালামালের মূল্য</th>
            <th>অন্যান্য</th>
            <th>বায়নার টাকা</th>
            <th>জামানত</th>
            <th>মোট</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($scheme_contractors as $scheme_contractor)
        {
            ?>
            <tr>
                <td><?= $this->System->display_date($scheme_contractor['allotment_date']); ?></td>
                <td></td>
                <td><?= $this->Number->format($scheme_contractor['purto_bills']['gross_bill']) ?></td>
                <td></td>
                <td><?= $this->Number->format($scheme_contractor['purto_bills']['security']) ?></td>
                <td><?= $this->Number->format($scheme_contractor['purto_bills']['vat']) ?></td>
                <td><?= $this->Number->format($scheme_contractor['purto_bills']['income_taxes']) ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td><?= $this->Number->format($scheme_contractor['purto_bills']['roller_charge']) ?></td>
                <td><?= $this->Number->format($scheme_contractor['purto_bills']['lab_fee']) ?></td>
                <td></td>
                <td></td>
                <td><?= $this->Number->format($scheme_contractor['purto_bills']['net_taka']) ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        <?php
        }
        ?>
        </tbody>
    </table>
    <style>
        table tr th{
            text-align: center;
        }
    </style>
</div>