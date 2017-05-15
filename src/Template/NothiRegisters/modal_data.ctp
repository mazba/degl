<div class="modal-body">
    <div class="row panel panel-default">
        <div class="panel-body col-sm-12">
            <p><b> <?= __('বিষয়ঃ') ?> </b> <?= $letter_data['subject'] ?></p>
            <p><b> <?= __('স্মারক নং-') ?> </b> <?= $letter_data['reminder_number'] ?><span style="`margin-left: 2em"><b> <?= __('তারিখঃ') ?> </b><?= $this->Common->EngToBanglaNum(date('d-m-y',$letter_data['created_date'])) ?></span></p>
            <p><b> <?= __('বর্ণনাঃ') ?> </b> <?= $letter_data['description'] ?></p>
        </div>
        <div class="col-md-12">
            <div class="col-md-12 text-center">
                <button style="margin-bottom: 1em" class="modal-close btn btn-sm btn-warning" data-dismiss="modal" aria-hidden="true"><?= __('বন্ধ করুন ') ?></button>
            </div>
        </div>
    </div>
</div>