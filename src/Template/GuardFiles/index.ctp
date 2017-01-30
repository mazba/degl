<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= $this->Html->link(__('Guard Files'), ['action' => 'index']) ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Guard Files'), ['action' => 'index']) ?> </li>

    </ul>
</div>


<div class="datatable">
    <table class="table">
        <thead>
        <tr>
            <th><?= __('id') ?></th>
            <th><?= __('Sender Name') ?></th>
            <th><?= __('Sender Office Address') ?></th>
            <th><?= __('Subject') ?></th>
            <th><?= __('Receive Date') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $i=1;
        foreach ($files as $file) {
            ?>
            <tr>
                <td><?= $this->Number->format($i++); ?></td>
                <td><?= h($file['sender_name']); ?></td>
                <td><?= h($file['sender_office_name']); ?></td>
                <td><?= h($file['subject']); ?></td>
                <td><?= date('d/m/Y', $file['receive_date']); ?></td>

                <td class="actions">
                    <?php
                    //if ($user_roles['view'] == 1)
                    {
                        echo $this->Html->link('<button class="btn btn-primary btn-icon" type="button"><i class="icon-newspaper"></i></button>', ['controller' => 'GuardFiles', 'action' => 'view', $file['id']
                            , '_full' => true], ['escapeTitle' => false, 'title' => 'Guard File Details']);
                    }

                    ?>
                </td>
            </tr>

        <?php } ?>
        </tbody>
    </table>
</div>
