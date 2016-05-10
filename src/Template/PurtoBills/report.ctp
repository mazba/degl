<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li><?= $this->Html->link(__('Purto Bills'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Reports Purto Bill') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Purto Bills'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New Purto Bill'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <li class="active"><?= $this->Html->link(__('Reports of Purto Bill'), ['action' => 'report']) ?></li>
    </ul>
</div>
<?= $this->Form->create('report',['class' => 'form-horizontal','role'=>'form']); ?>
<div class="row panel panel-success">
    <div class="panel-heading">
        <h6 class="panel-title"><i class="icon-paragraph-right2"></i><?= __('Add Purto Bill') ?></h6>
    </div>
    <div class="panel-body col-sm-6 col-md-offset-2">
        <?php
        echo $this->Form->input('project_id');
        echo $this->Form->input('financial_year_estimate_id');
        ?>
    </div>
    <div class="col-sm-3 col-md-offset-6  form-actions">
        <input type="submit" value="<?= __('Show Reports') ?>" class="btn btn-warning">
    </div>
    <div class="col-md-12" id="reports_wrp">

    </div>
</div>
<?= $this->Form->end() ?>
<script>
    $(document).ready(function(){
        $(document).on("submit", "form", function (event) {
            event.preventDefault();
            var project_id = $('#project-id').val();
            var financial_id = $('#financial-year-estimate-id').val();
            if (project_id && financial_id) {
                $.ajax({
                    url: '',
                    type: 'POST',
                    data: {project_id: project_id,financial_id:financial_id},
                    success: function (data, status) {
                        console.log(data)
                        $('#reports_wrp').html(data);
                    },
                    error: function (xhr, desc, err) {
                        console.log("error");

                    }
                });
            }
        });
    });
    function print_rpt(){
        URL="<?php echo $this->request->webroot; ?>page/Print_a4_Eng.php?selLayer=PrintArea";
        day = new Date();
        id = day.getTime();
        eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=yes,scrollbars=yes ,location=0,statusbar=0 ,menubar=yes,resizable=1,width=880,height=600,left = 20,top = 50');");
    }

</script>
</script>