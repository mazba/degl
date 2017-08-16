<?php
use Cake\Core\Configure;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?=

            $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Contractors'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Contractor') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Contractors'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Contractor'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['edit'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('Edit Contractor'), ['action' => 'edit', $contractor->id]) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['delete'] == 1)
        {
            ?>
            <li><?=
                $this->Form->postLink(__('Delete Contractor'), ['action' => 'delete', $contractor->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $contractor->id)]) ?>
            </li>
        <?php
        }
        ?>

        <li class="active"><?=
            $this->Html->link(__('Details Contractor'), ['action' => 'view', $contractor->id
            ]) ?>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <?php
            $con_img = $this->request->webroot.'img/'.$contractor->picture;
            $con_img = !empty($contractor->picture)?$con_img:$this->request->webroot.Configure::read('no_img_path');
            ?>
            <img width="280px" height="280px" src="<?php echo $con_img; ?>" />
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Contractor Class Title') ?></h6></div>
            <div class="panel-body"><?= h($contractor->contractor_class_title) ?></div>
        </div>
        
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Contractor Title') ?></h6></div>
            <div class="panel-body"><?= h($contractor->contractor_title) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Contact Person Name') ?></h6></div>
            <div class="panel-body"><?= h($contractor->contact_person_name) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Contractor Phone') ?></h6></div>
            <div class="panel-body"><?= h($contractor->contractor_phone) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Contractor Email') ?></h6></div>
            <div class="panel-body"><?= h($contractor->contractor_email) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Contractor Address') ?></h6></div>
            <div class="panel-body"><?= h($contractor->contractor_address) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Mobile') ?></h6></div>
            <div class="panel-body"><?= h($contractor->mobile) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Fax') ?></h6></div>
            <div class="panel-body"><?= h($contractor->fax) ?></div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Vat No') ?></h6></div>
            <div class="panel-body"><?= h($contractor->vat_no) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Tin No') ?></h6></div>
            <div class="panel-body"><?= h($contractor->tin_no) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('জাতীয় পরিচয়পত্র') ?></h6></div>
            <div class="panel-body"><?= h($contractor->nid) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Trade Licence No') ?></h6></div>
            <div class="panel-body"><?= h($contractor->trade_licence_no) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Created User') ?></h6>
            </div>
            <div class="panel-body"><?=
                $contractor->has('created_user') ?
                    $this->Html->link($contractor->created_user
                        ->name_en, ['controller' => 'Users',
                        'action' => 'view', $contractor->created_user
                            ->id]) : '' ?>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Updated User') ?></h6>
            </div>
            <div class="panel-body"><?=
                $contractor->has('updated_user') ?
                    $this->Html->link($contractor->updated_user
                        ->name_en, ['controller' => 'Users',
                        'action' => 'view', $contractor->updated_user
                            ->id]) : '' ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Id') ?></h6></div>
            <div class="panel-body"><?= $this->Number->format($contractor->id) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Created Date') ?></h6></div>
            <div class="panel-body"><?=
                $this->System->display_date_time($contractor->created_date)
                ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Updated Date') ?></h6></div>
            <div class="panel-body"><?=
                $this->System->display_date_time($contractor->updated_date)
                ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Status') ?></h6></div>
            <?php
            if ($contractor->status == 1)
            {
                ?>
                <div class="panel-body"><?= __('Active') ?></div>
            <?php
            }
            elseif ($contractor->status == 0)
            {
                ?>
                <div class="panel-body"><?= __('In-Active') ?></div>
            <?php
            }
            else
            {
                ?>
                <div class="panel-body"><?php echo $contractor->status; ?></div>
            <?php

            }
            ?>
        </div>
    </div>
</div>