<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Lab Letter Registers'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Lab Letter Register') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Lab Letter Registers'), ['controller' => 'LabLetterRegisters', 'action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1) {
            ?>
            <li><?= $this->Html->link(__('New Lab Letter Register'), ['controller' => 'LabLetterRegisters', 'action' => 'add']) ?></li>
            <?php
        }
        ?>
        <li><?=
            $this->Html->link(__('Details Lab Letter Registert'), ['controller' => 'LabLetterRegisters', 'action' => 'view', $labLetterRegister->id
            ]) ?>
        </li>
        <li class="active"><?=
            $this->Html->link(__('Add Test'), ['action' => 'add', $labLetterRegister->id
            ]) ?>
        </li>

    </ul>
</div>

<div class="hiddenField" style="display: none">
    <div class="col-sm-7 box" style="border: 1px solid #50626D;padding-top:30px;margin-bottom: 20px ">
        <div class="panel-heading"><span id="close">X</span></div>
        <?php
        echo $this->Form->input('lab_test_group_id', ['class'=>'form-control lab_test_group','label'=>__('Item of Works'),'options'=>$labTestGroups,'empty' => __('Select')]);
        echo $this->Form->input('lab_test_list_id[]', ['label' => __('Test List'), 'class' =>'form-control testList', 'options'=>[], 'empty' => 'Select test']);
        ?>

        <div class="form-group input select financialYear" style="display: none">


        </div>
        <input type="hidden" id="financial_year" name="financial_year[]" value="">
        <input type="hidden" id="lab_test_short_name" name="lab_test_short_name[]" value="">
        <input type="hidden" id="lab_test_full_name" name="lab_test_full_name[]" value="">
        <?php
        echo $this->Form->input('rate[]', ['label' => 'Rate', 'id' => 'testRate']);
        echo $this->Form->input('work_done_quantity',['class'=>'form-control work-done-quantity']);
        ?>
        <div class="text-right" style="margin-bottom: 10px;">
            <input type="button" class="btn btn-primary calculate" id="calculate" value="<?= __('Calculate') ?>" >
        </div>
        <?php
        echo $this->Form->input('number_of_test[]', ['class'=>'number_of_test form-control','label' => 'Number Of Test','readonly']);
        ?>
    </div>
</div>

<?= $this->Form->create($labTest, ['class' => 'form-horizontal','id'=>'form', 'role' => 'form']); ?>
<div class="row panel panel-default">
    <input type="hidden" name="lab_letter_registers_id" value="<?= $labLetterRegister->id ?>">
    <input type="hidden" name="scheme_id" value="<?= $labLetterRegister->scheme_id ?>">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Lab Lest') ?>
        </h6></div>

    <div class="panel-body">
        <div id="inputContainer">
            <div id="inputBox">

                <div class="col-sm-7 box" style="border: 1px solid #50626D;padding-top:30px;margin-bottom: 20px ">
                    <?php
                    echo $this->Form->input('lab_test_group_id', ['class'=>'form-control lab_test_group','label'=>__('Item of Works'),'options'=>$labTestGroups,'empty' => __('Select')]);
                    ?>
                    <div class="form-group input select">
                        <div class="col-sm-3 control-label text-right">
                            <label><?= __('Test List') ?></label>
                        </div>
                        <div id="container_lab_test_list_id[]" class="col-sm-9">
                            <select name="lab_test_list_id[]" class="form-control testList">
                                <option selected="selected"><?= __('Select') ?></option>
                                <?php /*foreach ($testLists as $key => $list) { */?><!--
                                    <option value="<?/*= $key */?>"><?/*= $list */?></option>
                                --><?php /*} */?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group input select financialYear" style="display: none">


                    </div>
                    <input type="hidden" id="financial_year" name="financial_year[]" value="">
                    <input type="hidden" id="lab_test_short_name" name="lab_test_short_name[]" value="">
                    <input type="hidden" id="lab_test_full_name" name="lab_test_full_name[]" value="">
                    <?php
                    echo $this->Form->input('rate[]', ['label' => 'Rate', 'id' => 'testRate']);
                    echo $this->Form->input('work_done_quantity',['class'=>'form-control work-done-quantity']);
                    ?>
                    <div class="text-right" style="margin-bottom: 10px;">
                        <input type="button" class="btn btn-primary calculate" id="calculate" value="<?= __('Calculate') ?>" >
                    </div>
                    <?php
                    echo $this->Form->input('number_of_test[]', ['class'=>'form-control number_of_test','label' => 'Number Of Test','readonly']);
                    ?>
                </div>
            </div>
        </div>

        <div class="col-sm-7  text-center" style="margin-top: 20px">
            <span id="addMore" class="btn btn-success">Add More</span>
        </div>

        <div class="col-sm-7 form-actions text-right" style="padding-right: 0">
            <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
        </div>
    </div>
</div>
<?= $this->Form->end() ?>

<script>
    $(document).ready(function () {

        $(document).on('click', '.calculate', function () {
            var lab_test_group = $(this).closest('.box').find('.lab_test_group').val();
            var testList = $(this).closest('.box').find('.testList').val();
            var work_done_quantity = $(this).closest('.box').find('.work-done-quantity').val();
            var test=$(this);

            $.ajax({
                type: 'POST',
                url: '<?= $this->request->webroot ?>AddNewLabTests/getTestNumber',
                data: {
                    lab_test_group :lab_test_group,
                    testList:testList,
                    work_done_quantity:work_done_quantity
                },
                success: function (data, status) {
                    data = JSON.parse(data);
                    console.log();
                    if (data.test_no_type == 0) {
                        test.closest('.box').find('.number_of_test').val(data.test_needed);

                    } else if (data.test_no_type == 1) {
                        test.val(data.test_needed);


                    }


                },
                error: function (xhr, desc, err) {

                }

            });
        });


        var lab_test_id="";
        $(document).on("change", ".testList", function (event) {
            var test_id = $(this).val();
            lab_test_id=test_id;
            var obj = $(this);
            $.ajax({
                url: '<?=$this->Url->build(('/AddNewLabTests/getFinancialYear'), true)?>',
                type: 'POST',
                data: {
                    test_id: test_id
                },
                success: function (data, status) {

                    var html = '<label class="col-sm-3 control-label text-right"><?= __("Financial Year") ?></label>'
                        + '<div class="col-sm-9">'
                        + '<select class="form-control getRate" name="">'
                        + '<option value="">Select financial year</option>';

                    $.each(JSON.parse(data), function (key, value) {
                        html = html + '<option value=" ' + value.id + ' "> ' + value.name + ' </option>';
                    });

                    html = html + '</select>';

                    obj.closest('.box').find('.financialYear').show();
                    obj.closest('.box').find('.financialYear').html(html);
                }

            });
        });

        $(document).on('change', '.getRate', function () {
            var financial_year_id = $(this).val();
            var obj = $(this);
            $.ajax({
                url: '<?=$this->Url->build(('/AddNewLabTests/getRate'), true)?>',
                type: 'POST',
                data: {
                    financial_year_id: financial_year_id,
                    lab_test_id: lab_test_id
                },
                success: function (data, status) {
                    data = JSON.parse(data)
                    //console.log(data)
                    obj.closest('.col-sm-7').find('#testRate').val(data.rate)
                    obj.closest('.col-sm-7').find('#lab_test_short_name').val(data.lab_test_lists.test_short_name_en)
                    obj.closest('.col-sm-7').find('#lab_test_full_name').val(data.lab_test_lists.test_full_name_en)
                    obj.closest('.col-sm-7').find('#financial_year').val(data.financial_year_estimates.name)
                }

            });
        });

        $('#addMore').click(function (e) {
            var html = $('.hiddenField').html();
            $('#inputContainer').append(html)
        })

        $(document).on('click', '#close', function () {
            $(this).parents('.box').remove()
        });

        $(document).on('change', '.lab_test_group', function () {
            var group_id=$(this).val();
            var obj=$(this);

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

                    obj.closest('.box').find('.testList').html(html);
                },
                error: function (xhr, desc, err) {

                }
            });
        }) ;


    });


</script>


<style>
    .panel-heading span {
        background: #DA6C61 none repeat scroll 0 0;
        cursor: pointer;
        float: right;
        left: 15px;
        margin: -30px 0 0;
        padding: 3px 10px;
        position: relative;
    }
</style>
