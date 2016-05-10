<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('My Profile') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('My Profile'), ['action' => 'index']) ?></li>
        <li class=""><?= $this->Html->link(__('Edit Profile'), ['action' => 'edit']) ?></li>
    </ul>
</div>

<div class="panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-table2"></i> <?= __('My Profile') ?></h6></div>
    <div class="table-responsive">
        <table class="table table-striped">
            <tbody>
                <tr><th><?= __('Name English') ?></th> <td><?= $user->name_en; ?></td></tr>
                <tr><th><?= __('Name Bangla') ?></th> <td><?= $user->name_bn; ?></td></tr>
                <tr><th><?= __('Username') ?></th> <td><?= $user->username; ?></td></tr>
                <tr><th><?= __('Designations') ?></th> <td><?= $user->designation->name_en; ?></td></tr>
                <tr><th><?= __('Office') ?></th> <td><?= $user->office->name_en; ?></td></tr>
                <tr><th><?= __('Gender') ?></th> <td><?= $user->gender; ?></td></tr>
                <tr><th><?= __('Phone office') ?></th> <td><?= $user->office_phone; ?></td></tr>
                <tr><th><?= __('Mobile') ?></th> <td><?= $user->mobile; ?></td></tr>
                <tr><th><?= __('Email') ?></th> <td><?= $user->email; ?></td></tr>
                <tr><th><?= __('National ID') ?></th> <td><?= $user->national_id_no; ?></td></tr>
                <tr><th><?= __('Present Address') ?></th> <td><?= $user->present_address; ?></td></tr>
                <tr><th><?= __('Permanent Address') ?></th> <td><?= $user->permanent_address; ?></td></tr>
                <tr><th><?= __('Birth Date') ?></th> <td><?= date('d/m/Y',$user->birth_date); ?></td></tr>
                <tr><th><?= __('Photo') ?></th> <td><img class="thumbnail" src="<?= $this->request->webroot.'img/'.$user->picture; ?>" alt=""/></td></tr>
            </tbody>
        </table>
    </div>
</div>