<h1 class="text-center" style="padding-top: 20px"><?=  __('Local Government Engineering Department') ?></h1>
<h3 class="text-center" style=""><?=  $office['name_en'].', '.$office['address'] ?></h3>
<table class="table table-bordered" style="padding: 5px">
    <thead>
        <tr>
            <th><?= __('No') ?></th>
            <th><?= __('Issue Date') ?></th>
            <th><?= __('Receiver Name & Designation') ?></th>
            <th><?= __('Subject') ?></th>
            <th><?= __('Remarks') ?></th>
        </tr>

    </thead>
    <tbody>
       <?php
            foreach($letterIssueRegisters as $letterIssueRegister)
            {
                ?>
                <tr>
                    <td><?= $letterIssueRegister['id'];  ?></td>
                    <td><?= $this->System->display_date($letterIssueRegister['issue_date']);  ?></td>
                    <td><?= $letterIssueRegister['receiver_name'].'<br><span class="label label-info">'.$letterIssueRegister['receiver_designation'].'</span>';  ?></td>
                    <td><?= $letterIssueRegister['subject'];  ?></td>
                    <td><?= $letterIssueRegister['remarks'];  ?></td>
                </tr>
                <?php
            }
       ?>
    </tbody>
</table>
