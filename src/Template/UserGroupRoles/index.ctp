<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('User Group Roles') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of User Group Roles'), ['action' => 'index']) ?></li>

    </ul>
</div>

<div class="userGroupRoles index panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i> <?= __('List of User Group Roles') ?></h6>
    </div>
    <div class="datatable">
        <table class="table">
            <thead>
            <tr>
                <th><?= __('User Group') ?></th>
                <th><?= __('Total Component') ?></th>
                <th><?= __('Total Module') ?></th>
                <th><?= __('Total Task') ?></th>
                <th><?= __('Last Modified') ?></th>
                <?php
                if (($user_roles['edit'] == 1))
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

            foreach ($userGroupRoles as $userGroupRole)
            {
                ?>
                <tr>
                    <td><?= $userGroupRole->name_bn; ?></td>
                    <td><?= $this->Number->format($userGroupRole->ugr['total_component']) ?></td>
                    <td><?= $this->Number->format($userGroupRole->ugr['total_module']) ?></td>
                    <td><?= $this->Number->format($userGroupRole->ugr['total_task']) ?></td>
                    <td>
                        <?php
                        $modified='';
                        if(($userGroupRole->ugr['last_created_date'])>0 || ($userGroupRole->ugr['last_updated_date'])>0)
                        {
                            if($userGroupRole->ugr['last_created_date']>$userGroupRole->ugr['last_updated_date'])
                            {
                                $modified=$this->System->display_date_time($userGroupRole->ugr['last_created_date']);
                            }
                            else
                            {
                                $modified=$this->System->display_date_time($userGroupRole->ugr['last_updated_date']);
                            }

                        }
                        echo $modified;
                        ?>
                    </td>

                    <td class="actions">
                        <?php
                        if ($user_roles['edit'] == 1)
                        {
                            echo $this->Html->link('<button class="btn btn-info btn-icon" type="button"><i class="icon-pencil3"></i></button>', ['action' => 'edit', $userGroupRole->id
                            ], ['escapeTitle' => false, 'title' => 'edit']);
                        }
                        ?>
                    </td>
                </tr>

            <?php } ?>
            </tbody>
        </table>
    </div>
</div>