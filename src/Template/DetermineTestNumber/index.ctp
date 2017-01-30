<div class="breadcrumb-line" xmlns="http://www.w3.org/1999/html">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Determine Test Number'), ['action' => 'index']) ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('Determine Test Number'), ['action' => 'index']) ?></li>


    </ul>
</div>


<?= $this->Form->create(null, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Determine Test Number') ?>
        </h6></div>
    <div class="panel-body">
        <div class="col-sm-8">
            <?php
            echo $this->Form->input('lab_test_group_id', ['label' => __('Item of Works'), 'empty' => __('Select')]);
            echo $this->Form->input('lab_test_list_id', ['empty' => __('Select')]);
            echo $this->Form->input('work_done_quantity');
            ?>
            <div class="form-group input select">
                <label for="lab-test-group-id" class="col-sm-3 control-label text-right"><?= __('Unit Type') ?></label>
                <div class="col-sm-9" id="container_unit_type">
                    <select id="unit_type" name="" class="form-control" disabled>

                    </select>
                    <input id="unit_type_value" type="hidden" name="unit_type">
                </div>
            </div>
        </div>
        <div class="col-sm-4 result text-center"
             style="border: 1px dashed #6e87ff; height: 200px;padding-top: 20px"></div>
    </div>


    <div class="col-sm-12 form-actions text-center">
        <input type="submit" value="<?= __('Calculate') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

<script>
    $(document).ready(function () {
        $(document).on('submit', 'form', function (e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: '<?= $this->request->webroot ?>DetermineTestNumber/getTestNumber',
                data: $(this).serialize(),
                success: function (data, status) {
                    data = JSON.parse(data);
                    var html = '<h2 style="color: red">No data found. Please input correct information.</h2>';
                    if (data.test_no_type == 0) {
                        html = '<h2 style="color: green">Test Required ' + data.test_needed + '</h2>';
                    } else if (data.test_no_type == 1) {
                        html = '<h2 style="color: green">Test Required ' + data.test_needed + ' Set</h2>';
                    }

                    $('.result').html(html);
                },
                error: function (xhr, desc, err) {

                }

            });
        });

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

        $(document).on('change', '#lab-test-list-id', function () {
            var group_id = $('#lab-test-group-id option:selected').val();
            var test_id = $(this).val();
            $.ajax({
                type: 'POST',
                url: '<?= $this->request->webroot ?>DetermineTestNumber/getTestUnitType',
                dataType: "JSON",
                data: {group_id: group_id, test_id: test_id},
                success: function (data, status) {
                    var html= '<option value="'+ data.id +'">'+ data.unit_type +'</option>';
                    $('#unit_type').html(html);
                    $('#unit_type_value').val(data.id)
                },
                error: function (xhr, desc, err) {

                }
            });
        });
    });
</script>
