<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?>
            </a></li>
        <li class="active"><?= __('Allotment Registers') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Allotment Registers'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('Report'), ['action' => 'report']) ?></li>
    </ul>
</div>

<div class="row">
    <div class="col-sm-12">
        <?= $this->Form->create(null, ['action' => 'report', 'role' => 'form']) ?>
        <div class="col-sm-5 ">
            <label class="control-label text-right" for="project-id"><?= __('Project') ?></label>

            <div id="container_project_id">
                <select id="project-id" class="form-control" name="project_id">
                    <option value=""><?= __('Select a project') ?></option>
                    <?php foreach ($projects as $key => $value) { ?>
                        <option value="<?= $key ?>"><?= $value ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-sm-4">
            <label class="control-label text-right" for="financial-year-id"><?= __('Financial Year') ?></label>

            <div id="container_financial_year_id">
                <select id="financial-year-id" class="form-control" name="financial_year_id">
                    <option value=""><?= __('Select a Financial Year') ?></option>
                    <?php foreach ($financial_years as $key => $value) { ?>
                        <option value="<?= $key ?>"><?= $value ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-sm-3">
            <label class="control-label text-right" for="">&nbsp;</label>

            <div id="container_submit">
                <input class="btn btn-info" type="submit" value="<?= __('Generate Report') ?>">
            </div>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>
<div style="clear: both"></div>

<?php if(!empty($allotment_registers)) { ?>
<div class="row" style="margin-top: 40px">
    <div class="col-sm-12">
        <h5 class="text-center"><?= __('LOCAL GOVERNMENT ENGINEERING DEPARTMENT') ?></h5>

        <h3 class="text-center"><?= __('ALLOTMENT REGISTER') ?></h3>

        <p style="text-align: center"><?= __('Month/Year: ') ?><?= $info['financial_year_name'] ?></p>

        <p><strong>Name of the Office:</strong> <?= $info['office_name'] ?></p>

        <p><strong>Name of the Project/Fund:</strong> <?= $info['project_name'] ?></p>

        <table class="table table-bordered">
            <tr>
                <th>Date</th>
                <th>Particulars of Allotment</th>
                <th>Page No.</th>
                <th>Dr.(TK)</th>
                <th>Cr.(TK)</th>
                <th>Remarks</th>
            </tr>
            <?php foreach ($allotment_registers as $allotment_register) { ?>
                <tr>
                    <td><?= date('d-m-Y', $allotment_register['allotment_date']) ?></td>
                    <td><?php if (!empty($allotment_register['scheme_id'])) {
                            echo $allotment_register['schemes']['name_bn'];
                        }else {
                            echo $allotment_register['projects']['name_bn'];
                        } ?></td>
                    <td></td>
                    <td><?php if ($allotment_register['dr_cr'] == "Debit") {
                            echo $allotment_register['allotment_amount'];
                        } ?></td>
                    <td><?php if ($allotment_register['dr_cr'] == "Credit") {
                            echo $allotment_register['allotment_amount'];
                        } ?></td>
                    <td></td>
                </tr>
            <?php } ?>

        </table>
    </div>
</div>


<?php } ?>