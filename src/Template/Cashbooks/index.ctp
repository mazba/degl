<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Cashbooks') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('Cashbooks'), ['action' => 'index']) ?> </li>
    </ul>
</div>
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title"><i class="icon-page-break"></i><?= __('Cashbook') ?></h6>
        </div>
        <div class="panel-body">
            <div class="col-md-6 col-md-offset-3">
                <div class="alert alert-block alert-success fade in">
                    <h6><i class="icon-command"></i><?= __('Pick a month generate the Cashbook') ?></h6>
                    <hr>

                        <?= $this->Form->input('project_id') ?>
                    <br/>
                    <br/>
                        <div class="form-group input select" style="margin-top: 10px">
                            <label for="project-id" class="col-sm-3 control-label text-right">মাস</label>
                            <div class="col-sm-9" id="container_project_id">
                                <select id='month' class="form-control">
                                    <option value=''>--Select Month--</option>
                                    <option value='01'>Janaury</option>
                                    <option value='02'>February</option>
                                    <option value='03'>March</option>
                                    <option value='04'>April</option>
                                    <option value='05'>May</option>
                                    <option value='06'>June</option>
                                    <option value='07'>July</option>
                                    <option value='08'>August</option>
                                    <option value='09'>September</option>
                                    <option value='10'>October</option>
                                    <option value='11'>November</option>
                                    <option value='12'>December</option>
                                </select>
                            </div>
                        </div>
                    <br/>
                    <br/>
                    <div class="form-group input select" style="margin-top: 10px">
                        <label for="project-id" class="col-sm-3 control-label text-right">বছর</label>
                        <div class="col-sm-9">
                            <input type="text" id="year" class="form-control" name="year"/>
                        </div>
                    </div>

                    <div class="text-right">
                        <button id="reset" class="btn btn-warning"><i class="icon-spinner8"></i><?= __('Reset') ?></button>
                        <button id="submit" class="btn btn-info"><i class="icon-arrow-down9"></i> <?= __('Submit') ?></button>
                    </div>
                </div>
            </div>
            <div class="col-md-12" id="report_wrp">

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on("click", "#reset", function(event){
            $('#report_wrp').html('');
            $('#month').val('');
            $('#project-id').val('');
            $('#year').val('');
        });
        $(document).on("click", "#submit", function(event)
        {
            var month = $('#month').val();
            var project = $('#project-id').val();
            var year = $('#year').val();
            if(month)
            {
                $.ajax({
                    url: '<?=$this->Url->build(('/Cashbooks/ajax/get_cashbook_by_month'), true)?>',
                    type: 'POST',
                    data:{month:month,project:project,year:year},
                    success: function (data, status)
                    {
                        $('#report_wrp').html(data);
//                        if(data.trim() != 'NOT_FOUND')
//                        {
//                            $('#report_wrp').html(data);
//
//                        }
//                        else
//                        {
//                            $('#add_item_noti').show()
//                        }
                    },
                    error: function (xhr, desc, err)
                    {
                        console.log("error");
                    }
                });
            }
        });
    });
    function print_rpt($printArea){
        URL="<?php echo $this->request->webroot; ?>page/Print_a4_Eng.php?selLayer="+$printArea;
        day = new Date();
        id = day.getTime();
        eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=yes,scrollbars=yes ,location=0,statusbar=0 ,menubar=yes,resizable=1,width=880,height=600,left = 20,top = 50');");
    }
</script>