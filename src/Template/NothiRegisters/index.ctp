<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Nothi') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of Nothi'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1) {
            ?>
            <li><?= $this->Html->link(__('New Nothi'), ['action' => 'add']) ?></li>
            <?php
        }
        ?>

    </ul>
</div>
<div class="well text-center" style="margin-bottom: 10px">
    <?php
    if ($user_roles['print_it']) {
        ?>
        <a data-toggle="modal" role="button" href="#small_modal">
            <button class="btn btn-success" type="button"><i class="icon-print"></i><?= __('Print By Date Range') ?>
            </button>
        </a>
        <?php
    }
    ?>
    <div id="dataTable" style="margin-top:5px ">

    </div>
</div>
<!-- Small modal -->
<div id="small_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-accessibility"></i><?= __('Print By Date Range') ?></h4>
            </div>
            <div class="modal-body with-padding form-inline">
                <div class="form-group input text">
                    <label for="birth-date" class="col-sm-3 control-label"><?= __('Start Date') ?></label>
                    <div class="col-sm-9 container_birth_date">
                        <input type="text" required="required" name="start_date" id="start_date"
                               class="form-control hasdatepicker">
                    </div>
                </div>
                <div class="form-group input text">
                    <label for="birth-date" class="col-sm-3 control-label"><?= __('End Date') ?></label>
                    <div class="col-sm-9 container_birth_date">
                        <input type="text" required="required" name="end_date" id="end_date"
                               class="form-control hasdatepicker">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-warning" data-dismiss="modal"><?= __('Close') ?></button>
                <button class="print btn btn-danger" data-print="by_date"><?= __('Submit') ?></button>
            </div>
        </div>
    </div>
</div>
<!-- /small modal -->
<div class="nothiRegisters index panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i> <?= __('List of Nothi') ?>
        </h6>
    </div>
    <div class="datatable">
        <table class="table">
            <thead>
            <tr>
                <th><?= __('id') ?></th>
                <th><?= __('Nothi No') ?></th>
                <th><?= __('Nothi Date') ?></th>
                <th><?= __('Nothi Label') ?></th>
                <?php
                if (($user_roles['view'] == 1) || ($user_roles['edit'] == 1) || ($user_roles['delete'] == 1)) {
                    ?>
                    <th class="actions"><?= __('Actions') ?></th>
                    <?php
                }
                ?>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($nothiRegisters as $key => $nothiRegister) {
                ?>
                <tr>
                    <td><?= $this->Number->format($key + 1) ?></td>
                    <td><?= h($nothiRegister->nothi_no) ?></td>
                    <td><?= $this->System->display_date($nothiRegister->nothi_date) ?></td>
                    <td><?= h($nothiRegister->remarks) ?></td>
                    <td class="actions">
                        <?php
                        if ($user_roles['view'] == 1) {
                            echo $this->Html->link('<button class="btn btn-primary btn-icon" type="button"><i class="icon-newspaper"></i></button>', ['action' => 'view_sub_nothi', $nothiRegister->id
                                , '_full' => true], ['escapeTitle' => false, 'title' => 'Details']);
                        }

                        ?>
                        <?php
                        if ($user_roles['edit'] == 1) {
                            echo $this->Html->link('<button class="btn btn-info btn-icon" type="button"><i class="icon-pencil3"></i></button>', ['action' => 'edit', $nothiRegister->id
                            ], ['escapeTitle' => false, 'title' => 'edit']);
                        }
                        ?>
                        <?php
                        if ($user_roles['delete'] == 1) {
                            echo $this->Form->postLink('<button class="btn btn-danger btn-icon" type="button"><i class="icon-close"></i></button>', ['action' => 'delete', $nothiRegister->id],
                                ['confirm' => __('Are you sure you want to delete # {0}?', $nothiRegister->id), 'escapeTitle' => false,
                                    'title' => 'delete']);
                        }

                        ?>
                    </td>
                </tr>

            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function () {
        $(document).on("click", ".print", function (event) {
            var newWin = window.open('', '', 'height=700,width=700,toolbar=yes,scrollbars=yes');
            $.ajax({
                url: '<?=$this->Url->build(('/NothiRegisters/print_it'), true)?>',
                type: 'POST',
                data: {
                    start_date: $('[name=start_date]').val(),
                    end_date: $('[name=end_date]').val()
                },
                success: function (data, status) {
                    if (data) {
                        newWin.document.write(data);
                        newWin.document.close();
                        newWin.focus();

                    }
                    else {
                        alert('NO DATA FOUND');
                    }
                },
                error: function (xhr, desc, err) {
                    console.log("error");

                }
            });
        });
    });
</script>