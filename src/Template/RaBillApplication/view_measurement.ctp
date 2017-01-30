<?php
use Cake\Core\Configure;

Configure::load('config_receive_file_registers', 'default');
use Cake\Routing\Router;

?>

<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Messages'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('View') ?></li>

    </ul>
</div>


<div class="row panel panel-default">
    <div class="panel-heading">
        <h6 class="panel-title">
            <i class="icon-paragraph-right2"></i><?= __('Details Measurement') ?>
        </h6>
    </div>
    <div class="panel-body col-sm-12">

        <table class="table table-bordered">
            <tr>
                <td>Measured By</td>
                <td>Item Code</td>
                <td>Description</td>
                <td>Unit</td>
                <td>Work done</td>

            </tr>
            <?php foreach ($measurement_info as $row): ?>
                <tr>
                    <td><?= $row['measured_by']?></td>
                    <td><?= $row['item_display_code']?></td>
                    <td><?= substr($row['description'],0,25) ?></td>
                    <td><?= $row['unit']?></td>
                    <td><?= $row['quantity_of_work_done']?></td>

                </tr>
            <?php endforeach; ?>

        </table>



    </div>





</div>

<script>
    $(document).on('click', '#forward_btn', function (event) {
        $('#forward').show();
        $('#reply').hide();
    })

    $(document).on('click', '#reply_btn', function (event) {
        $('#forward').hide();
        $('#reply').show();
    })

</script>