<h1 class="text-center" style="padding-top: 20px"><?=  __('Local Government Engineering Department') ?></h1>
<h2 class="text-center"><?=  __('Lab Letter Registers') ?></h2>
<h3 class="text-center" style=""><?=  $office['name_en'].', '.$office['address'] ?></h3>
<table class="table table-bordered" style="padding: 5px">
    <thead>
        <tr>
            <th><?= __('No') ?></th>
            <th><?= __('Receive Date') ?></th>
            <th><?= __('Letter No') ?></th>
            <th><?= __('Date') ?></th>
            <th><?= __('Receive From') ?></th>
            <th><?= __('Subject') ?></th>
        </tr>

    </thead>
    <tbody>
       <?php
            foreach($labLetterRegisters as $labLetterRegister)
            {
                ?>
                <tr>
                    <td><?= $labLetterRegister['id'];  ?></td>
                    <td><?= $this->System->display_date($labLetterRegister['receive_date']);  ?></td>
                    <td><?= $labLetterRegister['letter_no'];  ?></td>
                    <td><?= $this->System->display_date($labLetterRegister['created_date']);  ?></td>
                    <td><?= $labLetterRegister['received_from'];  ?></td>
                    <td><?= $labLetterRegister['subject'];  ?></td>
                </tr>
                <?php
            }
       ?>
    </tbody>
</table>
