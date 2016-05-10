<h1 class="text-center" style="padding-top: 20px"><?=  __('Local Government Engineering Department') ?></h1>
<h3 class="text-center" style=""><?=  $office['name_en'].', '.$office['address'] ?></h3>
<h4 class="text-center" style=""><?= __('Mechanical Bill') ?></h4>
<?php
$assigned_bills =array();
$bills = array();
foreach($mechanical_bills as $mechanical_bill)
{
    if(isset($assigned_bills[$mechanical_bill['schemes']['id']]))
    {
        $bills[] = [
            'id'=>$mechanical_bill['id'],
            'contractor'=>$mechanical_bill['contractors']['contractor_title'],
            'scheme'=>$mechanical_bill['schemes']['name_en'],
            'deduction_on_bill'=>$mechanical_bill['deduction'],
            'total_deduction'=>$mechanical_bill['deduction'] + $assigned_bills[$mechanical_bill['schemes']['id']],
        ];
        $total_deduction = $mechanical_bill['deduction'] + $assigned_bills[$mechanical_bill['schemes']['id']];
    }
    else
    {
        $bills[] = [
            'id'=>$mechanical_bill['id'],
            'contractor'=>$mechanical_bill['contractors']['contractor_title'],
            'scheme'=>$mechanical_bill['schemes']['name_en'],
            'deduction_on_bill'=>$mechanical_bill['deduction'],
            'total_deduction'=>$mechanical_bill['deduction']
        ];
        $total_deduction = $mechanical_bill['deduction'];
    }
    $assigned_bills[$mechanical_bill['schemes']['id']] = $total_deduction;
}
?>
<table class="table table-bordered" style="padding: 5px">
    <thead>
        <tr>
            <th><?= __('No') ?></th>
            <th><?= __('Contractors') ?></th>
            <th><?= __('Schemes') ?></th>
            <th><?= __('Total Deduction') ?></th>
            <th><?= __('Deduction on this bill') ?></th>
        </tr>

    </thead>
    <tbody>
       <?php
            foreach($bills as $bill)
            {
                ?>
                <tr>
                    <td><?= $bill['id'];  ?></td>
                    <td><?= $bill['contractor'];  ?></td>
                    <td><?= $bill['scheme'];  ?></td>
                    <td><?= $bill['total_deduction'];  ?></td>
                    <td><?= $bill['deduction_on_bill'];  ?></td>
                </tr>
                <?php
            }
       ?>
    </tbody>
</table>
