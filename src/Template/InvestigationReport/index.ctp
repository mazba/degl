<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Cashbooks') ?> </li>
    </ul>
</div>
<script type="text/javascript" src="http://maps.google.com/maps/api/js">
</script>
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title"><i class="icon-page-break"></i><?= __('Investigation Report') ?></h6>
        </div>
        <div class="panel-body">
            <div class="col-md-6 col-md-offset-3">
                <?= $this->Form->input('project_id',['empty'=>'Select']) ?>
                <br/>
                <br/>
                <div class="form-group input select" id="scheme_wrp" style="display: none; margin-top: 10px;">
                    <label for="scheme_id" class="col-sm-3 control-label text-right" ><?= __('Scheme') ?></label>
                    <div class="col-sm-9" id="container_project_id">
                        <select id="scheme_id" name="scheme_id" class="form-control">

                        </select>
                    </div>
                </div>
                <button id="load" style="margin-top: 10px" class="btn btn-warning pull-right" type="button"><i class="icon-globe"></i><?= __('Load') ?></button>
            </div>
            <div class="col-md-12" id="report_wrp">

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on("click", "#reset", function(event){

        });
        $(document).on("change", "#project-id", function(event)
        {
            var project_id = $(this).val();
            $('#scheme_id').html('');
            $('#scheme_wrp').hide();
            if(project_id)
            {
                //$('#loader').show();
                $.ajax({
                    url: '<?=$this->Url->build(('/InvestigationReport/ajax/get_scheme_by_project'), true)?>',
                    type: 'POST',
                    data:{project_id:project_id},
                    success: function (data, status)
                    {
                        var obj = JSON.parse(data);
                        $('#scheme_id')
                            .append($('<option>', { value: '' })
                                .text('Select'));
                        $.each(obj, function (key, value) {
                            $('#scheme_id')
                                .append($('<option>', { value: key })
                                    .text(value));
                        });
                        $('#scheme_wrp').show();
                        $("#scheme_id").chosen()
                        $("#scheme_id").trigger("chosen:updated");
                       // $('#loader').hide();
                    },
                    error: function (xhr, desc, err)
                    {
                        console.log("error");
                    }
                });

            }
        });
        $(document).on("click", "#load", function(event)
        {
            var scheme_id = $('#scheme_id').val();
            var project_id = $('#project-id').val();

            if(project_id)
            {
                //$('#loader').show();
                $.ajax({
                    url: '<?=$this->Url->build(('/InvestigationReport/ajax/load_investigation_report'), true)?>',
                    type: 'POST',
                    data:{project_id:project_id,scheme_id:scheme_id},
                    success: function (data, status)
                    {
                        $('#report_wrp').html(data);
                        //$('#loader').hide();
                    },
                    error: function (xhr, desc, err)
                    {
                        console.log("error");
                    }
                });
            }
        });
    });
</script>
