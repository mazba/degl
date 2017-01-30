<?php
use Cake\Core\Configure;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Measurement Books') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Measurement'), ['measurement_index' => 'index',$id]) ?></li>
        <?php
        if ($user_roles['add'] == 1)
        {
        ?>
            <li><?= $this->Html->link(__('New Measurement'), ['action' => 'add_measurement',$id]) ?></li>
        <?php
        }
        ?>
    </ul>
</div>

<div class="measurementBooks index panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i> <?= __('List of All Measurement') ?></h6>
    </div>
    <div class="datatable">
        <table class="table">
            <thead>
                <tr>
                    <th><?= __('#') ?></th>
                    <th><?= __('Measurement') ?></th>
                    <?php
                    if ($user_roles['edit'] == 1)
                    {
                        ?>
                        <th class="actions"><?= __('Actions') ?></th>
                    <?php
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach($measurements as $measurement)
                {
                    $i++;
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo 'Measurement '.$measurement['measurement_no']; ?></td>
                        <td>
                            <?php
                            if ($user_roles['edit'] == 1)
                            {
                                echo $this->Html->link('<button class="btn btn-info btn-icon" type="button"><i class="icon-contract"></i></button>', ['action' => 'edit_measurement',$id ,$measurement['measurement_no']
                                ], ['escapeTitle' => false, 'title' => 'Edit Measurement']);
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>