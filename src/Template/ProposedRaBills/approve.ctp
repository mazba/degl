<?php
use Cake\Routing\Router;
use Cake\Core\Configure;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Proposed Ra Bills'), ['action' => 'index']) ?></li>
        <li class="active"><?= __('New Proposed Ra Bill') ?></li>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Proposed Ra Bills'), ['action' => 'index']) ?></li>
    </ul>
</div>


<form class="form-horizontal" role="role" method="post" action="<?php echo Router::url('/',true); ?>proposed_ra_bills/approve/<?php echo $id; ?>">
<div class="row panel panel-default">
    <div class="panel-heading">
        <h6 class="panel-title">
            <i class="icon-paragraph-right2"></i><?= __('Approve Ra Bill') ?>
        </h6>
    </div>
    <div class="panel-body col-sm-12">
        <div class="form-group input">
            <label class="col-sm-4 control-label text-right"><?= __('Scheme') ?></label>
            <div class="col-sm-5">
                <label class="form-control"><?php echo $ra_bills['schemes']['name_en']; ?></label>
            </div>
        </div>
        <div class="form-group input">
            <label class="col-sm-4 control-label text-right"><?= __('Lead Contractors') ?></label>
            <div class="col-sm-5">
                <label class="form-control"><?php echo $ra_bills['contractors']['contractor_title']; ?></label>
            </div>
        </div>
        <div class="form-group input">
            <label class="col-sm-4 control-label text-right"><?= __('Total RA Bills') ?></label>
            <div class="col-sm-5">
                <label class="form-control"><?php echo $ra_bills['bill_amount']; ?></label>
            </div>
        </div>

        <hr>

        <div class="form-group input">
            <label class="col-sm-4 control-label text-right"><?= __('Is Final') ?></label>
            <div class="col-sm-5">
                <input type="checkbox" class="form-control" value="1" name="is_final">
            </div>
        </div>
        <div class="form-group input">
            <label class="col-sm-4 control-label text-right"><?= __('Part No') ?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="part_no" required="required">
            </div>
        </div>
        <div class="form-group input">
            <label class="col-sm-4 control-label text-right"><?= __('Approve Quantity') ?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="approve_quantity" name="approved_quantity" required="required">
            </div>
        </div>
        <div class="form-group input">
            <label class="col-sm-4 control-label text-right"><?= __('Security Money') ?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control on_change" name="security_money">
            </div>
        </div>
        <div class="form-group input">
            <label class="col-sm-4 control-label text-right"><?= __('Roller Fee') ?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control on_change" name="roller_fee">
            </div>
        </div>
        <div class="form-group input">
            <label class="col-sm-4 control-label text-right"><?= __('Lab fee') ?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control on_change" name="lab_fee">
            </div>
        </div>
        <div class="form-group input">
            <label class="col-sm-4 control-label text-right"><?= __('Fine') ?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control on_change" name="fine">
            </div>
        </div>
        <div class="form-group input">
            <label class="col-sm-4 control-label text-right"><?= __('ETC') ?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control on_change" name="etc">
            </div>
        </div>
        <div class="form-group input">
            <label class="col-sm-4 control-label text-right"><?= __('Net Bill') ?></label>
            <div class="col-sm-5">
                <label class="form-control" id="net_fee"></label>
            </div>
        </div>
        <div class="form-group input">
            <label class="col-sm-4 control-label text-right"><?= __('Remarks') ?></label>
            <div class="col-sm-5">
                <textarea rows="2" class="form-control" name="remarks"></textarea>
            </div>
        </div>

    </div>
    <div class="col-md-5  col-md-offset-6 form-actions">
        <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>
<script type="text/javascript">
    jQuery(document).ready(function()
    {
        $(document).on("change", ".on_change", function(event)
        {
            get_net_fee(this);

        });
    });
    function get_net_fee(event)
    {
        var approve_quantity = parseInt($('#approve_quantity').val());
        var others_bills = $('.on_change');
        var total = 0;
        var item =0;
        $.each(others_bills,function()
        {
            if(parseInt($(this).val()))
            {
                total+=parseInt($(this).val());
            }
        });
        var net_fee = approve_quantity-total;
        if((net_fee > 0) && (total<approve_quantity))
        {
            $('#net_fee').html(net_fee);
        }
        else
        {
            alert('Other fee larger then the Approve Amount!!');
            $(event).val('');
            $('#net_fee').html('');
        }

    }
</script>