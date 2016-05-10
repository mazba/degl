<h1 class="text-center" style="padding-top: 20px"><?=  __('Local Government Engineering Department') ?></h1>
<h3 class="text-center" style=""><?=  $office['name_en'].', '.$office['address'] ?></h3>
<h4 class="text-center" style="font-weight: bold"><?= __('Register Of Letters Received') ?></h4>
<h4 class="text-center" style="font-weight: bold"><?= __('পত্র প্রাপ্তির রেজিস্টার') ?></h4>
<table class="table table-bordered" style="padding: 5px">
    <thead>
        <tr>
            <th><?= __('Register No') ?></th>
            <th><?= __('Receive Date') ?></th>
            <th><?= __('Sarok No') ?></th>
            <th><?= __('Letter Date') ?></th>
            <th><?= __('From Whom Received(Name & Designation)') ?></th>
            <th><?= __('Subject') ?></th>
        </tr>

    </thead>
    <tbody>
       <?php
            foreach($receiveFileRegisters as $receiveFileRegister)
            {
                ?>
                <tr>
                    <td><?= $receiveFileRegister['letter_no'];  ?></td>
                    <td><?= $this->System->display_date($receiveFileRegister['receive_date']);  ?></td>
                    <td><?= $receiveFileRegister['sarok_no'];  ?></td>
                    <td><?= $this->System->display_date($receiveFileRegister['letter_date']);  ?></td>
                    <td><?= $receiveFileRegister['sender_name'].'<br><span class="label label-info">'.$receiveFileRegister['sender_designation'].'</span>';  ?></td>
                    <td><?= $receiveFileRegister['subject'];  ?></td>
                </tr>
                <?php
            }
       ?>
    </tbody>
</table>
