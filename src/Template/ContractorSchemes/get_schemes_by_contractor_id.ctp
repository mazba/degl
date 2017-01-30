<?php if (!empty($schemes)): ?>

    <div id="PrintArea" style="margin-top: 10px; padding: 5px; margin-bottom: 10px">
        <button class="btn btn-info pull-right" id="print_button" onclick="print_rpt()"><?= __('Print') ?></button>
        <h1 class="text-center"><?= $schemes[0]['contractors']['contractor_title'] ?> </h1>
        <div id="report_table">
        <table class="table table-bordered" style="border: 1px solid #eee; margin-bottom: 10px;">
            <thead>
            <tr>
                <th rowspan="2"><?= __('Scheme Name') ?></th>
                <th rowspan="2"><?= __('Package Name') ?></th>
                <th rowspan="2"><?= __('Contract Amount') ?></th>
                <th rowspan="2"><?= __('Contract Date') ?></th>
                <th rowspan="2"><?= __('Completion Date') ?></th>
                <th rowspan="2"><?= __('Progress') ?></th>
                <th rowspan="2"><?= __('Road Length') ?></th>
                <th rowspan="2"><?= __('Structure Length') ?></th>
                <th rowspan="2"><?= __('Building Quantity') ?></th>
                <th colspan="3" class="text-center"><?= __('Payment') ?></th>
            </tr>
            <tr>
                <th><?= __('Road') ?></th>
                <th><?= __('Structure') ?></th>
                <th><?= __('Building') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $total_amount = 0;
            $total_progress = 0;
            $total_road_length = 0;
            $total_structure_length = 0;
            $total_building = 0;
            $total_road_payment = 0;
            $total_structure_payment = 0;
            foreach ($schemes as $scheme) {
                $total_amount += $scheme['schemes']['contract_amount'];
                $total_progress += $scheme['scheme_progresses']['progress_value'];
                $total_road_length += $scheme['schemes']['road_length'];
                $total_structure_length += $scheme['schemes']['structure_length'];
                $total_building += $scheme['schemes']['building_quantity'];
                $total_road_payment += $scheme['schemes']['payment_road'];
                $total_structure_payment += $scheme['schemes']['payment_structure'];
                ?>
                <tr>
                    <td><?= $scheme['schemes']['name_bn'] ?></td>
                    <td><?= $scheme['packages']['name_bn'] ?></td>
                    <td><?= $scheme['schemes']['contract_amount'] ?></td>
                    <td><?= date('d-m-Y', $scheme['schemes']['contract_date']) ?></td>
                    <td><?= date('d-m-Y', $scheme['schemes']['completion_date']) ?></td>
                    <td><?= $scheme['scheme_progresses']['progress_value'] ?></td>
                    <td><?= $scheme['schemes']['road_length'] ?></td>
                    <td><?= $scheme['schemes']['structure_length'] ?></td>
                    <td><?= $scheme['schemes']['building_quantity'] ?></td>
                    <td><?= $scheme['schemes']['payment_road'] ?></td>
                    <td><?= $scheme['schemes']['payment_structure'] ?></td>
                    <td>&nbsp;</td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td><?= __('Total') ?></td>
                <td>&nbsp;</td>
                <td><?= $total_amount ?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><?= $total_progress ?></td>
                <td><?= $total_road_length ?></td>
                <td><?= $total_structure_length ?></td>
                <td><?= $total_building ?></td>
                <td><?= $total_road_payment ?></td>
                <td><?= $total_structure_payment ?></td>
                <td>&nbsp;</td>
            </tr>
            </tbody>
        </table>
        </div>
    </div>

<?php else: ?>
    <h4 class="text-center text-warning"><?= __('No data found') ?></h4>
<?php endif; ?>

<style>
#report_table{ overflow: scroll}
</style>
