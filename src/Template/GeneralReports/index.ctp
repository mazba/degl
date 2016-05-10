<?php
use Cake\Core\Configure;

?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('General Reports'), ['action' => 'index']) ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('General Reports'), ['action' => 'index']) ?></li>
    </ul>
</div>

<div class="duplicate" style="display: none">
    <div style="margin-top: 15px" class="col-sm-offset-2 col-sm-6">
        <div class="form-group input select">
            <label for="sort-by1" class="col-sm-3 control-label text-right"><?= __('Sort By') ?></label>
            <div class="col-sm-6" id="container_sort_by1">
                <select id="sort-by1" name="sort_by[]" class="form-control">
                    <option value=""><?= __('নির্বাচন করুন') ?></option>
                    <?php foreach (Configure::read('general_report_sort_by') as $key => $item): ?>
                        <option value="<?= $key ?>"><?= $item ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-sm-3" id="container_order_by1">
                <select id="order_by1" name="order_by[]" class="form-control">
                    <option value="asc"><?= __('Ascending') ?></option>
                    <option value="desc"><?= __('Descending') ?></option>
                </select>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <?= $this->Form->create() ?>
    <div class="col-sm-offset-2 col-sm-6">
        <?= $this->Form->input('form_date', ['type' => 'text', 'class' => 'form-control hasdatepicker']) ?>
    </div>
    <div class="col-sm-offset-2 col-sm-6" style="margin-top: 15px">
        <?= $this->Form->input('to_date', ['type' => 'text', 'class' => 'form-control hasdatepicker']) ?>
    </div>
    <div class="col-sm-offset-2 col-sm-6" style="margin-top: 15px">
        <?= $this->Form->input('project_id', ['options' => $projects, 'empty' => __('Select')]) ?>
    </div>
    <!--<div class="col-sm-offset-2 col-sm-6" style="margin-top: 15px">
        <? /*= $this->Form->input('group_by', ['options' => Configure::read('general_report_group_by'), 'empty' => __('Select')]) */ ?>
    </div>-->
    <div class="sort">
        <div style="margin-top: 15px" class="col-sm-offset-2 col-sm-6">
            <div class="form-group input select">
                <label for="sort-by1" class="col-sm-3 control-label text-right"><?= __('Sort By') ?></label>
                <div class="col-sm-6" id="container_sort_by1">
                    <select id="sort-by1" name="sort_by[]" class="form-control">
                        <option value=""><?= __('নির্বাচন করুন') ?></option>
                        <?php foreach (Configure::read('general_report_sort_by') as $key => $item): ?>
                            <option value="<?= $key ?>"><?= $item ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-sm-3" id="container_order_by1">
                    <select id="order_by1" name="order_by[]" class="form-control">
                        <option value="asc"><?= __('Ascending') ?></option>
                        <option value="desc"><?= __('Descending') ?></option>

                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-1" style="margin-top: 15px">
        <span id="add_sort" class="btn btn-danger">+</span>
    </div>
    <div class="col-sm-offset-2 col-sm-6" style="margin-top: 15px">

        <div class="form-group input text">
            <label class="col-sm-3 control-label text-right" for="summery"><?= __('Summery') ?></label>
            <div class="col-sm-1 container_summery">
                <input class="form-control" id="summery" name="summery" type="checkbox" value="1">
            </div>
        </div>
    </div>
    <div class="col-sm-12" style="margin-top: 40px">
        <div class="row">
            <ul id="sortable" style="overflow: scroll">
                <?php foreach (Configure::read('general_report_fields') as $key => $item): ?>
                    <li class="ui-state-default">
                        <?= __($item) ?>
                        <input type="hidden" name="field[<?= $item ?>]" value="<?= $key ?>">
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="col-sm-offset-5 col-sm-3" style="margin-top: 15px">
        <?= $this->Form->submit(__('Generate Report'), ['class' => 'btn btn-warning']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>

<?php if (!empty($schemes)): ?>

    <div class="row" style="margin-top: 60px">
        <div class="col-sm-12">
            <button class="btn btn-xs btn-warning icon-print2" style="float: right;margin-bottom: 10px"
                    onclick="print_rpt()">&nbsp;Print
            </button>
        </div>
        <div id="PrintArea">
            <div class="col-sm-12">
                <h4 class="text-center"><?= $project['name_bn'] ?></h4>
                <h5 class="text-center"><?= __('Local Govt. Engineering Department') ?></h5>
            </div>
            <div class="col-sm-6">
                <p class="text-left"><?= __('District: Gazipur') ?></p>
            </div>
            <div class="col-sm-6">
                <p class="text-right"><?= __('Month: ') . date('M/Y') ?></p>
            </div>
            <div class="col-sm-12 report-table">
                <table  class="table table-bordered">
                    <thead>
                    <tr style="border-top: 5px solid #ddd">
                        <th contenteditable="true"><?= __('SL No.') ?></th>
                        <?php foreach ($fields as $key => $field): ?>
                            <?php if ($key == 'total_fund_received') {
                                ?>
                                <th contenteditable="true"><?= __('Total Fund Receive') ?></th>
                                <?php continue;
                            } ?>
                            <?php if (array_key_exists($key, $schemes[0])): ?>
                                <th contenteditable="true"><?= $field ?></th>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <th contenteditable="true"><?= __('Remarks') ?></th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php $i = 1;
                    $count = 1;
                    foreach ($schemes as $scheme): ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <?php
                            foreach ($fields as $key => $value): ?>
                                <?php if ($key == 'total_fund_received' && $count == 1) {
                                    ?>
                                    <td rowspan="<?= sizeof($schemes) ?>"><?= $total_fund_receive[0]['total_fund_receive'] ?></td>
                                    <?php $count = 0;
                                    continue;
                                } ?>
                                <?php if (array_key_exists($key, $schemes[0])): ?>
                                    <td><?= $scheme[$key] ?></td>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <th>&nbsp;</th>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td><?= $i ?></td>
                        <?php
                        foreach ($fields as $key => $value): ?>

                            <?php if ($key == 'contract_amount') { ?>
                                <td><?= array_sum(array_column($schemes, $key)); ?></td>
                            <?php } elseif ($key == 'eve_approval_bill') { ?>
                                <td><?= array_sum(array_column($schemes, $key)); ?></td>
                            <?php } elseif ($key == 'road_length') { ?>
                                <td><?= array_sum(array_column($schemes, $key)); ?></td>
                            <?php } elseif ($key == 'structure_length') { ?>
                                <td><?= array_sum(array_column($schemes, $key)); ?></td>
                            <?php } elseif ($key == 'building_quantity') { ?>
                                <td><?= array_sum(array_column($schemes, $key)); ?></td>
                            <?php } elseif ($key == 'estimated_cost') { ?>
                                <td><?= array_sum(array_column($schemes, $key)); ?></td>
                            <?php } elseif ($key == 'estimated_road') { ?>
                                <td><?= array_sum(array_column($schemes, $key)); ?></td>
                            <?php } elseif ($key == 'estimated_structure') { ?>
                                <td><?= array_sum(array_column($schemes, $key)); ?></td>
                            <?php } elseif ($key == 'total_fund_spend') { ?>
                                <td><?= array_sum(array_column($schemes, $key)); ?></td>
                            <?php } elseif ($key == 'fund_spend_this_year') { ?>
                                <td><?= array_sum(array_column($schemes, $key)); ?></td>
                            <?php } elseif ($key == 'fund_spend_this_month') { ?>
                                <td><?= array_sum(array_column($schemes, $key)); ?></td>
                            <?php } elseif ($key == 'total_fund_received') { ?>
                                <td><?= array_sum(array_column($schemes, $key)); ?></td>
                            <?php } elseif ($key == 'fund_received_this_year') { ?>
                                <td><?= array_sum(array_column($schemes, $key)); ?></td>
                            <?php } elseif ($key == 'payment_road') { ?>
                                <td><?= array_sum(array_column($schemes, $key)); ?></td>
                            <?php } elseif ($key == 'payment_structure') { ?>
                                <td><?= array_sum(array_column($schemes, $key)); ?></td>
                            <?php } elseif ($key == 'allotted_amount') { ?>
                                <td><?= array_sum(array_column($schemes, $key)); ?></td>
                            <?php } else { ?>
                                <td>&nbsp;</td>
                            <?php } ?>
                        <?php endforeach; ?>
                    </tr>
                    </tbody>
                </table>
            </div>
            <?php if (isset($summery)): ?>
                <div class="col-sm-4" style="width: 35% !important;">
                    <table class="table table-bordered">
                        <tr>
                            <th><?= __('Upazila Name') ?></th>
                            <th><?= __('Category-1') ?></th>
                            <th><?= __('Category-2') ?></th>
                            <th><?= __('Category-3') ?></th>
                            <th><?= __('Category-4') ?></th>
                        </tr>
                        <?php foreach ($summery as $key => $item): ?>
                            <tr>
                                <td><?= $key ?></td>
                                <td><?= isset($item['category_1']) ? $item['category_1'] : 0 ?></td>
                                <td><?= isset($item['category_2']) ? $item['category_2'] : 0 ?></td>
                                <td><?= isset($item['category_3']) ? $item['category_3'] : 0 ?></td>
                                <td><?= isset($item['category_4']) ? $item['category_4'] : 0 ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>

            <?php endif; ?>

            <div class="row">
                <div class="col-sm-12" style="margin-top: 60px">
                    <table class="table border-less text-center">
                        <tr>
                            <td><?= __('UDA') ?></td>
                            <td><?= __('Accountant') ?></td>
                            <td><?= __('Sub-Asst. Engineer') ?></td>
                            <td><?= __('Asst. Engineer') ?></td>
                            <td><?= __('Senior Asst. Engineer') ?></td>
                            <td><?= __('Executive Engineer') ?></td>
                        </tr>
                        <tr>
                            <td><?= __('LGED, Gazipur') ?></td>
                            <td><?= __('LGED, Gazipur') ?></td>
                            <td><?= __('LGED, Gazipur') ?></td>
                            <td><?= __('LGED, Gazipur') ?></td>
                            <td><?= __('LGED, Gazipur') ?></td>
                            <td><?= __('LGED, Gazipur') ?></td>
                        </tr>
                    </table>
                </div>
                <style>
                    .table.top-table td {
                        padding: 0px 3px;
                        border: 0px solid;
                        min-width: 150px;
                    }

                    .table.top-table .col-sm-9 {
                        width: 100% !important;
                        padding: 0px
                    }

                    #summery {
                        margin: -7px 0 0;
                    }

                    .border-less td, .border-less tr {
                        border: 0px solid !important;
                        padding: 2px 12px !important;
                    }
                </style>
                

            </div>
        </div>
    </div>

<?php endif; ?>

<style>

    #sortable {
        list-style-type: none;
        margin: 0;
        padding: 0;
        width: 100%;
        overflow: auto;
        white-space: nowrap
    }

    #sortable li {
        display: inline-block;
        background: #0a73a7;
        padding: 8px 10px;
        margin-left: 5px;
        color: #f9fdff;
    }

    .report-table {
        overflow: scroll
    }

</style>
<script>

    $(document).ready(function () {
        $(document).on('click', '#add_sort', function () {
            var html = $('.duplicate').html();
            $('.sort').append(html);
        });

        var timeoutID;
        $('[contenteditable]').bind('DOMCharacterDataModified', function () {
            clearTimeout(timeoutID);
            $that = $(this);
            timeoutID = setTimeout(function () {
                $that.trigger('change')
            }, 50)
        });
        $('[contentEditable]').bind('change', function () {
            console.log($(this).text());
        });


    });
    function print_rpt() {

        URL = "<?php echo $this->request->webroot; ?>page/Print_a4_Eng.php?selLayer=PrintArea";
        day = new Date();
        id = day.getTime();
        eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=yes,scrollbars=yes ,location=0,statusbar=0 ,menubar=yes,resizable=1,width=880,height=600,left = 20,top = 50');");
    }
    $(function () {
        var removeIntent = false;
        $("#sortable").sortable({
            over: function () {
                removeIntent = false;
            },
            out: function () {
                removeIntent = true;
            },
            beforeStop: function (event, ui) {
                if (removeIntent == true) {
                    ui.item.remove();
                }
            }
        });
        $("#sortable").disableSelection();
    });
</script>