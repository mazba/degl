<h1 class="text-center" style="padding-top: 20px"><?=  __('Local Government Engineering Department') ?></h1>
<h3 class="text-center" style=""><?=  $office['name_en'].', '.$office['address'] ?></h3>
<table class="table table-bordered" style="padding: 5px">
    <thead>
        <tr>
            <th><?= __('#') ?></th>
            <th><?= __('Sample By') ?></th>
            <th><?= __('Name of Client') ?></th>
            <th><?= __('Name of Work') ?></th>
            <th><?= __('Date of Sample') ?></th>
            <th><?= __('Date of Delivery') ?></th>
            <th><?= __('Signature of Client') ?></th>
            <th><?= __('Remarks') ?></th>
        </tr>

    </thead>
    <tbody>
       <?php
            foreach($deliveryReports as $deliveryReport)
            {
                ?>
                <tr>
                    <td><?= $deliveryReport['id'];  ?></td>
                    <td><?= $deliveryReport['sample_by'];  ?></td>
                    <td><?= $deliveryReport['client_name'];  ?></td>
                    <td><?= $deliveryReport['work_description'];  ?></td>
                    <td><?= $this->System->display_date($deliveryReport['sample_date']);  ?></td>
                    <td><?= $this->System->display_date($deliveryReport['date_of_delivery']);  ?></td>
                    <td></td>
                    <td><?= $deliveryReport['remarks'];  ?></td>
                </tr>
                <?php
            }
       ?>
    </tbody>
</table>
