    <?php

    if (isset($error)) {
        echo "<p class='bg-danger'>$error</p>";
    }elseif(!$preconditions){
        echo "<p class='bg-danger'>Pre condition failed</p>";
    } else {




        foreach ($attachments as $row) {
            if ($row['attachment_id'] == 1) {
                ?>
                <input type="hidden" name="attachments[0][table]" value="hire_charges">
                <div class="form-group input select">
                    <label class="col-sm-3 control-label text-right" for="entry-definition-id">Vehicle hire charge</label>

                    <div id="container_entry_definition_id" class="col-sm-9">
                        <select id="" class="form-control "
                                name="attachments[0][id]" <?php echo $row['is_require'] ? 'required' : '' ?>>
                            <option value="">--select--</option>
                            <?php foreach ($hire_charges as $row): ?>
                                <option
                                    value="<?= $row['id'] ?>"><?php echo $row['net_payable'] . ' (' . date('d-m-Y', $row['created_date']) . ')' ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

            <?php } ?>

           <?php if ($row['attachment_id'] == 2) {
                ?>
                <input type="hidden" name="attachments[1][table]" value="lab_bills">

                <div class="form-group input select">
                    <label class="col-sm-3 control-label text-right" for="entry-definition-id">Lab Bills</label>

                    <div id="container_entry_definition_id" class="col-sm-9">
                        <select id="" class="form-control "
                                name="attachments[1][id]" <?php echo $row['is_require'] ? 'required' : '' ?>>
                            <option value="">--select--</option>
                            <?php foreach ($lab_bills as $row): ?>
                                <option
                                    value="<?= $row['id'] ?>"><?php echo $row['net_payable'] . ' (' . date('d-m-Y', $row['created_date']) . ')' ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

            <?php } ?>

            <?php if ($row['attachment_id'] == 3) {
                ?>
                <input type="hidden" name="attachments[2][table]" value="lab_letter_registers">

                <div class="form-group input select">
                    <label class="col-sm-3 control-label text-right" for="entry-definition-id">Lab letter</label>

                    <div id="container_entry_definition_id" class="col-sm-9">
                        <select id="" class="form-control "
                                name="attachments[2][id]" <?php echo $row['is_require'] ? 'required' : '' ?>>
                            <option value="">--select--</option>
                            <?php foreach ($lab_letters as $row): ?>
                                <option
                                    value="<?= $row['id'] ?>"><?php echo $row['subject']  ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

            <?php } ?>

            <?php if ($row['attachment_id'] == 4) {
                ?>
                <input type="hidden" name="attachments[3][table]" value="vehicle_hire_letter_registers">

                <div class="form-group input select">
                    <label class="col-sm-3 control-label text-right" for="entry-definition-id">Vehicle hire letter</label>

                    <div id="container_entry_definition_id" class="col-sm-9">
                        <select id="" class="form-control "
                                name="attachments[3][id]" <?php echo $row['is_require'] ? 'required' : '' ?>>
                            <option value="">--select--</option>
                            <?php foreach ($hire_charge_letters as $row): ?>
                                <option
                                    value="<?= $row['id'] ?>"><?php echo $row['subject']  ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

            <?php } ?>


            <?php if ($row['attachment_id'] == 5) {
                ?>
                <input type="hidden" name="attachments[4][table]" value="proposed_ra_bills">

                <div class="form-group input select">
                    <label class="col-sm-3 control-label text-right" for="entry-definition-id">RA bill application</label>

                    <div id="container_entry_definition_id" class="col-sm-9">
                        <select id="" class="form-control "
                                name="attachments[4][id]" <?php echo $row['is_require'] ? 'required' : '' ?>>
                            <option value="">--select--</option>
                            <?php foreach ($messages as $row): ?>
                                <option
                                    value="<?= $row['resource_id'] ?>"><?php echo $row['subject']  ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

            <?php } ?>

            <?php
        }
        ?>

        <div class="form-group">
            <label class="col-sm-3 control-label text-right"><?= __('Description') ?></label>
            <div class="col-sm-9">
                <textarea name="text" id="ckeditor"></textarea>
            </div>
        </div>
<!--        <input type="hidden" name="approval_sequence[0][id]" value="--><?php //if(isset($approval_sequence))echo $approval_sequence?><!--">-->
<!--        <input type="hidden" name="approval_sequence[0][status]" value="--><?php //if(isset($approval_sequence))echo 'true'?><!--">-->
<!--        <input type="hidden" name="approval_sequence[0][date]" value="--><?php //echo time()?><!--">-->
    <input type="hidden" name="entry_serial_no" value="<?php if(isset($entry_serial_no)){echo $entry_serial_no->entry_serial_no+1;}else{echo 1;}?>">


        <script>
            CKEDITOR.replace( 'ckeditor' );

        </script>
        <?php } ?>


