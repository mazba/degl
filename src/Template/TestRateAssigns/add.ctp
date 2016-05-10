<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('List of Test Rate') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Test Rate'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('Add Test Rate'), ['action' => 'add']) ?></li>
    </ul>
</div>

<?= $this->Form->create($testRateAssign, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Lab Lest') ?>
        </h6></div>
    </h6></div>
<div class="panel-body col-sm-7">
    <?php
    echo $this->Form->input('lab_test_group_id', ['options' => $labTestGroup, 'empty' => 'Select']);
    echo $this->Form->input('lab_test_list_id', ['options' => [], 'empty' => 'Select']);
    echo $this->Form->input('financial_year_estimate_id', ['options' => $financialYear, 'empty' => 'Select Financial year']);
    echo $this->Form->input('rate');
    ?>

    <div class="col-sm-12 form-actions text-right" style="padding-right: 0">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

<script>
    $(document).on('change', '#lab-test-group-id', function () {
        var group_id = $(this).val();
        $.ajax({
            type: 'POST',
            url: '<?= $this->request->webroot ?>DetermineTestNumber/getTestList',
            dataType: "JSON",
            data: {group_id: group_id},
            success: function (data, status) {
//                    console.log(data)
                var html = '<option value="">নির্বাচন করুন</option>';
                $.each(data, function (key, value) {
                    html = html + '<option value="' + key + '">' + value + '</option>';
                })

                $('#lab-test-list-id').html(html);
            },
            error: function (xhr, desc, err) {

            }
        });
    });
</script>
