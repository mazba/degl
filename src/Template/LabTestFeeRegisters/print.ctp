<h1 class="text-center" style="padding-top: 20px"><?=  __('Local Government Engineering Department') ?></h1>
<h3 class="text-center" style=""><?=  $office['name_en'].', '.$office['address'] ?></h3>
<table class="table table-bordered" style="padding: 5px">
    <thead>
        <tr>
            <th><?= __('No') ?></th>
            <th><?= __('Scheme/Work Description') ?></th>
            <th><?= __('Taka') ?></th>
            <th><?= __('Description') ?></th>
            <th><?= __('Date') ?></th>
            <th><?= __('Signature LT') ?></th>
            <th><?= __('Signature HR') ?></th>
            <th><?= __('Signature Sr.AE') ?></th>
        </tr>

    </thead>
    <tbody>
       <?php
            foreach($labTestFeeRegisters as $labTestFeeRegister)
            {
                ?>
                <tr>
                    <td><?= $labTestFeeRegister['id'];  ?></td>
                    <td><?= (!empty($labTestFeeRegister['lab_letter_registers']['work_description']) ? $labTestFeeRegister['lab_letter_registers']['work_description'] : $labTestFeeRegister['schemes']['name_en']);  ?></td>
                    <td><?= $labTestFeeRegister['lab_fee'];  ?></td>
                    <td><?= $labTestFeeRegister['pay_details'];  ?></td>
                    <td><?= $this->System->display_date($labTestFeeRegister['payment_date']);  ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <?php
            }
       ?>
    </tbody>
</table>
