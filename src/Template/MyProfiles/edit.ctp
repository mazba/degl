<?php
use Cake\Core\Configure;
use Cake\Routing\Router;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('My Profile'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('Edit Profile') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class=""><?= $this->Html->link(__('My Profile'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('Edit Profile'), ['action' => 'edit']) ?></li>
    </ul>
</div>
<?= $this->Form->create($user, ['class' => 'form-horizontal', 'role' => 'form', 'type' => 'file']); ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h6 class="panel-title">
            <i class="icon-paragraph-right2"></i><?= __('Edit Profile') ?>
        </h6>
    </div>
    <div class="panel-body col-sm-6">
        <?php
            echo $this->Form->input('username');
            echo $this->Form->input('password');
            echo $this->Form->input('name_en', ['label' => __('NAME_EN')]);
            echo $this->Form->input('name_bn', ['label' => __('NAME_BN')]);
            echo $this->Form->input('birth_date',['type'=>'text','value'=>$this->System->display_date($user->birth_date),'class'=>'form-control hasdatepicker']);
            echo $this->Form->input('gender', ['options' => Configure::read('gender')]);
            echo $this->Form->input('email');
            echo $this->Form->input('mobile');
            echo $this->Form->input('phone');
        ?>
    </div>
    <div class="panel-body col-sm-6">
        <?php
            echo $this->Form->input('office_phone');
            echo $this->Form->input('national_id_no');
            echo $this->Form->input('present_address');
            echo $this->Form->input('permanent_address');
            echo $this->Form->input('picture', ['type' => 'file','data-preview-container'=>'#profile_image_preview']);
        ?>
        <div id="profile_image_preview" class="col-sm-offset-3">
            <?php
                if($user['picture'])
                {
                    ?>
                        <img src="<?php echo Router::url('/',true).'img/'.$user['picture']; ?>" height="200">
                    <?php
                }
            ?>
        </div>
    </div>
    <div class="form-actions text-right" style="margin-right: 600px">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>
