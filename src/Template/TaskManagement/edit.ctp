<?php
use Cake\Core\Configure;

?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Task Management'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('Edit Task Management') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Task Management'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1) {
            ?>
            <li><?= $this->Html->link(__('New Task Management'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <li class="active"><?=
            $this->Html->link(__('Edit Task Management'), ['action' => 'edit', $taskManagement->id
            ]) ?>
        </li>
        <?php
        if ($user_roles['delete'] == 1) {
            ?>
            <li><?=
                $this->Form->postLink(
                    __('Delete Task Management'),
                    ['action' => 'delete', $taskManagement->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $taskManagement
                        ->id)]
                )
                ?>
            </li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['view'] == 1) {
            ?>
            <li><?=
                $this->Html->link(__('Details Task Management'), ['action' => 'view', $taskManagement->id])
                ?>
            </li>
        <?php
        }
        ?>


    </ul>
</div>


<?= $this->Form->create($taskManagement, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Edit Task Management') ?>
        </h6></div>
    <div class="panel-body col-sm-6">
        <?php
        echo $this->Form->input('type',['id'=>'type','options'=>['Meeting'=>'Meeting','Appointment'=>'Appointment','Visit'=>'Visit','Other'=>'Other']]);
        echo $this->Form->input('media_type',['id'=>'type','options'=>Configure::read('task_media_type')]);
        echo $this->Form->input('title');
        echo $this->Form->input('priority',['options'=>['High'=>'High','Medium'=>'Medium','Normal'=>'Normal']]);
        ?>
        <div class="form-group" id="name" style="display: <?php echo($taskManagement['type'] != 'Appointment' ? 'none' : ''); ?>">
            <label class="col-sm-3 control-label text-right"><?= __('Name: ') ?></label>
            <div class="col-sm-9">
                <input class="form-control" type="text" value="<?php echo $taskManagement['name'];  ?>" name="name">
            </div>
        </div>
        <div class="form-group" id="phone" style="display: <?php echo($taskManagement['type'] != 'Appointment' ? 'none' : ''); ?>">
            <label class="col-sm-3 control-label text-right"><?= __('Phone:') ?> </label>
            <div class="col-sm-9">
                <input class="form-control" type="text" value="<?php echo $taskManagement['phone'];  ?>" name="phone">
            </div>
        </div>
        <?php
        echo $this->Form->input('venue');
        ?>
        <div class="form-group">
            <label class="col-sm-3 control-label text-right"><?= __('Reminder by sms:') ?> </label>
            <div class="col-sm-9">
                <input id="reminder_by_sms" type="checkbox" value="1" <?php echo ($taskManagement['reminder_by_sms'] ? 'checked' :''); ?> name="reminder_by_sms">
            </div>
        </div>
        <div class="form-group" id="reminder_wrp" style="<?php echo ($taskManagement['reminder_by_sms'] ? '' :'display: none'); ?>" >
            <label class="col-sm-3 control-label text-right"><?= __('Reminder Date: ') ?></label>
            <div class="col-sm-9">
                <input type="text" class="form-control" value="<?= date('m/d/Y H:i:s',$taskManagement['reminder_date']); ?>" name="reminder_date" id="reminder_date">
            </div>
        </div>
    </div>
    <div class="panel-body col-sm-6">
        <div class="form-group">
            <label class="col-sm-3 control-label text-right"><?= __('Start Date Time: ') ?></label>
            <div class="col-sm-9">
                <div class='input-group date' id='datetimepicker6'>
                    <input type='text' class="form-control" name="start_date_time" value="<?= date('m/d/Y H:i:s',$taskManagement['start_date_time']); ?>"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label text-right"><?= __('End Date Time: ') ?></label>
            <div class="col-sm-9">
                <div class='input-group date' id='datetimepicker7'>
                    <input type='text' class="form-control" name="end_date_time" value="<?= date('m/d/Y H:i:s',$taskManagement['end_date_time']); ?>"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        <?php
        echo $this->Form->input('description');
        echo $this->Form->input('status', ['options' => [1=>'Incomplete',0=>'Complete']]);
        ?>
    </div>
    <div class="col-sm-12 form-actions text-center">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>
<script type="text/javascript" src="<?php echo $this->request->webroot; ?>js/bootstrap/moment.js"></script>
<script type="text/javascript" src="<?php echo $this->request->webroot; ?>js/bootstrap/collapse.js"></script>
<script type="text/javascript" src="<?php echo $this->request->webroot; ?>js/bootstrap/transition.js"></script>
<script type="text/javascript" src="<?php echo $this->request->webroot; ?>js/bootstrap/bootstrap-datetime-picker.js"></script>
<script type="text/javascript" src="<?php echo $this->request->webroot; ?>js/bootstrap/bootstrap-datetime-picker.js"></script>
<link type="text/css" rel="stylesheet"  href="<?php echo $this->request->webroot; ?>js/bootstrap/bootstrap-datetime-picker.css"/>
<script>
    jQuery(document).ready(function()
    {
        $('#reminder_date').datetimepicker();
        $('#datetimepicker6').datetimepicker();
        $('#datetimepicker7').datetimepicker({
            useCurrent: false //Important! See issue #1075
        });
        $("#datetimepicker6").on("dp.change", function (e) {
            $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimepicker7").on("dp.change", function (e) {
            $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
        });

        $(document).on("change", "#type", function(event)
        {
            $('#name').find('input').val('');
            $('#phone').find('input').val('');
            var type = $(this).val();
            if(type == 'Appointment')
            {
                $('#name').show();
                $('#phone').show();
            }
            else
            {
                $('#name').hide();
                $('#phone').hide();
            }
        });
        $(document).on('click','#reminder_by_sms',function(e){
            $('#reminder_date').val('');
            if($(this).is(':checked'))
            {
                $('#reminder_wrp').show();
            }
            else
            {
                $('#reminder_wrp').hide();
            }
        });
    });
</script>