<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Lab Bills') ?></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs" style="margin-bottom: 5px">
        <li><?= $this->Html->link(__('Generate Lab Bills'), ['action' => 'index']) ?></li>
        <li class="active"><?= $this->Html->link(__('List of Lab Bills'), ['action' => 'lists']) ?></li>
    </ul>
</div>
<?= $this->Form->create(null, ['class' => 'form-horizontal', 'role' => 'form']); ?>
<div class="row " style="margin-top: 40px">
    <div class="col-sm-offset-2 col-sm-7">
        <?= $this->Form->input('related_to', ['options' => ['letter' => __('Letter'), 'scheme' => __('Scheme')]]); ?>
    </div>
    <div class="col-sm-offset-2 col-sm-7">
        <div class="lists">
            <?= $this->Form->input('letter_id', ['options' => $labLetterRegisters, 'empty' => __('Select'), 'id' => 'scheme-id']); ?>
        </div>
    </div>
    <div class="col-sm-offset-2 col-sm-7 text-center">
        <span id="submit" class="btn btn-primary"><?= __('Search') ?></span>
    </div>

</div>
<?= $this->Form->end() ?>


<div class="row" style="margin-top: 60px">

    <div class="col-md-12 test_list">

    </div>

    <div class="modal_view"></div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('click', '#submit', function (event) {
            event.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?= $this->Url->build('/LabBills/getLabBillLists') ?>',
                data: $('form').serialize(),
                success: function (data, status) {
                    $('.test_list').html(data);
                },
                error: function (xhr, desc, err) {

                }
            })
        });

        $(document).on('change', '#related-to', function () {
            var type = $(this).val();

            $.ajax({
                type: 'POST',
                url: '<?= $this->request->webroot ?>LabBills/getSchemeLists',
                data: {type: type},
                success: function (data, status) {
                    $('.lists').html(data);
                },
                error: function (xhr, desc, err) {

                }
            })
        });

        $(document).on('click', '.view_detail', function () {
            var obj = $(this);
            var bill_id = obj.closest('tr').find('.bill_id').val();
            var type = obj.closest('tr').find('.type').val();
            var reference_id = obj.closest('tr').find('.reference_id').val();

            $.ajax({
                type: 'POST',
                url: '<?= $this->request->webroot ?>LabBills/getLabBillDetails',
                data: {bill_id: bill_id, type: type, reference_id: reference_id},
                success: function (data, status) {
                    $('.modal_view').html(data)
                    $('#myModal').modal('show');
                },
                error: function (xhr, desc, err) {

                }
            })
        });


    });
</script>

<script>
    function print_rpt() {
        URL = "<?php echo $this->request->webroot; ?>page/Print_a4_Eng.php?selLayer=PrintArea";
        day = new Date();
        id = day.getTime();
        eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=yes,scrollbars=yes ,location=0,statusbar=0 ,menubar=yes,resizable=1,width=880,height=600,left = 20,top = 50');");
    }
</script>
