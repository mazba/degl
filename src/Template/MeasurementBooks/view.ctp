<?php
use Cake\Core\Configure;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Measurement Books'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Measurement Book') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Measurement Books'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Measurement Book'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['edit'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('Edit Measurement Book'), ['action' => 'edit', $measurementBook->id]) ?></li>
        <?php
        }
        ?>
        <li class="active"><?=
            $this->Html->link(__('Details Measurement Book'), ['action' => 'view', $measurementBook->id
            ]) ?>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-6">

        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Office') ?></h6>
            </div>
            <div class="panel-body"><?=
                $measurementBook->has('office') ?$measurementBook->office
                    ->name_en: '' ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Scheme') ?></h6>
            </div>
            <div class="panel-body"><?=
                $measurementBook->has('scheme') ?$measurementBook->scheme
                    ->name_en : '' ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Contractor') ?></h6>
            </div>
            <div class="panel-body"><?=
                $measurementBook->has('contractor') ?$measurementBook->contractor
                    ->contractor_title : '' ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Work Status') ?></h6></div>
            <div class="panel-body"><?= h(Configure::read('books_work_status')[$measurementBook->work_status]) ?></div>

        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Book No') ?></h6></div>
            <div class="panel-body"><?= h($measurementBook->book_no) ?></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Work Commencement Date') ?></h6></div>
            <div class="panel-body"><?=
                $this->System->display_date($measurementBook->work_commencement_date)
                ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><?= __('Work Completion Date') ?></h6></div>
            <div class="panel-body"><?=
                $this->System->display_date($measurementBook->work_completion_date)
                ?>
            </div>
        </div>
    </div>
</div>