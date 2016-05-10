<?php
use Cake\Core\Configure;

?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Lab Test Frequency'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('Edit Lab Test Frequency') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Lab Test Frequency'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1) {
            ?>
            <li><?= $this->Html->link(__('New Lab Test Frequency'), ['action' => 'add']) ?></li>
            <?php
        }
        ?>
        <li class="active"><?= $this->Html->link(__('Edit Lab Test Frequency'), ['action' => 'edit', $labTestFrequency->id
            ]) ?>
        </li>
        <?php
        if ($user_roles['delete'] == 1) {
            ?>
            <li><?=
                $this->Form->postLink(
                    __('Delete Lab Test Frequency'),
                    ['action' => 'delete', $labTestFrequency->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $labTestFrequency
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
            <li><?= $this->Html->link(__('Details Lab Test Frequency'), ['action' => 'view', $labTestFrequency->id])
                ?>
            </li>
            <?php
        }
        ?>


    </ul>
</div>


<?= $this->Form->create($labTestFrequency, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Edit Lab Test Frequency') ?>
        </h6></div>
    <div class="panel-body col-sm-6">
        <?php
        echo $this->Form->input('lab_test_group_id',['label' => __('Item of Works')]);
        echo $this->Form->input('lab_test_list_id', ['empty' => __('Select')]);
        echo $this->Form->input('test_no');
        echo $this->Form->input('test_no_type', ['options' => Configure::read('test_no_type')]);
        echo $this->Form->input('per_unit');
        ?>
        <div class="form-group input select">
            <label for="lab-test-group-id" class="col-sm-3 control-label text-right"><?= __('Unit Type') ?></label>
            <div class="col-sm-9" id="container_unit_type">
                <select id="unit_type" name="unit_type" class="form-control">
                    <option value="1">m<sup>3</sup> </option>
                    <option value="2">m<sup>2</sup> </option>
                    <option value="3">m</option>
                    <option value="4">kg</option>
                </select>
            </div>
        </div>
        <?php
        echo $this->Form->input('status', ['options' => Configure::read('status_options')]);
        ?>
    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

<script>
    $(document).ready(function () {
        $(document).on('change', '#lab-test-group-id', function () {
            var group_id=$(this).val();

            $.ajax({
                type: 'POST',
                url: '<?= $this->request->webroot ?>DetermineTestNumber/getTestList',
                dataType: 'JSON',
                data: { group_id:group_id},
                success: function (data, status) {
                    var html = '<option value="">নির্বাচন করুন</option>';
                    $.each(data, function (key, value) {
                        html = html + '<option value="' + key + '">' + value + '</option>';
                    })

                    $('#lab-test-list-id').html(html);
                },
                error: function (xhr, desc, err) {

                }
            });
        }) ;
    });
</script>

