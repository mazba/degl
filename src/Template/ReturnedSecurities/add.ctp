<?php
use Cake\Core\Configure;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>">Dashboard</a></li>
        <li><?= $this->Html->link(__('Returned Securities'), ['action' => 'index']) ?></li>
                    <li class="active">New Returned Security</li>
        
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Returned Securities'), ['action' => 'index']) ?></li>
                    <li class="active"><?= $this->Html->link(__('New Returned Security'), ['action' => 'add']) ?></li>
        

    </ul>
</div>


<?= $this->Form->create($returnedSecurity,['class' => 'form-horizontal','role'=>'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('Add Returned Security') ?>
        </h6></div>
    <div class="panel-body col-sm-6 col-sm-offset-3">
        <?php
                            echo $this->Form->input('scheme_id', ['options' => $schemes]);
        ?>
        <div id="lists"></div>
        <?php
                                 //   echo $this->Form->input('returned_amount');
                        ?>
    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="Save" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

<script>
    $(document).ready(function(){

        $(document).on('change', '#scheme-id', function () {
            var id = $(this).val();
           // console.log(id)
        $.ajax({
            type: 'POST',
            url: '<?= $this->request->webroot ?>ReturnedSecurities/getList',
            data: {id: id},
            success: function (data, status) {
                $('#lists').html(data);
            },
            error: function (xhr, desc, err) {

            }
        })
        });

    });
</script>