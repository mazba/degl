<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Vehicle Hire'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('Details Vehicle Hire') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of hired Vehicles'), ['action' => 'index']) ?></li>

        <li><?=
            $this->Html->link(__('Edit Vehicle Hire'), ['action' => 'edit', $id
            ]) ?>
        </li>
        <li class="active"><?=
            $this->Html->link(__('Details Vehicle Hire'), ['action' => 'view', $id
            ]) ?>
        </li>



    </ul>
</div>

    <table class="table table-bordered">
        <tr>
            <td><?= __('Vehilce Title') ?></td>
        </tr>
        <?php
        foreach($vehicles as $vehicle)
        {

            ?>
            <tr>
                <td><?=$vehicle['title']?></td>
            </tr>
            <?php
        }
        ?>
    </table>