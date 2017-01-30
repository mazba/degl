<script src="<?php echo $this->request->webroot; ?>js/canvasjs.min.js" type="text/javascript"></script>

<div>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#work_schedule" aria-controls="work_schedule" role="tab"
                                                  data-toggle="tab">Work Schedule</a></li>
        <li role="presentation"><a href="#actual_progress" aria-controls="actual_progress" role="tab" data-toggle="tab">Actual
                Progress</a></li>
        <li role="presentation"><a href="#report" aria-controls="report" role="tab" data-toggle="tab" id="report-chart">Report</a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane  active" id="work_schedule">
            <div class="panel panel-default">
                <div class="panel-heading">

                    <h6 class="panel-title"><i class="icon-table2"></i>Add new scheme progress plan </h6>


                </div>
                <div class="panel-body">

                    <form class="form-horizontal" id="progress_plan_form" method="post">
                        <?php echo $this->Form->input('scheme_id', ['id' => '', 'type' => 'hidden', 'value' => $id]);
                        $this->Form->input('scheme_id', ['id' => '', 'type' => 'hidden', 'value' => $id]); ?>
                        <div id="file_wrapper" class="file_wrapper" class="" data-index_no="0">
                            <div class="file_container">
                                <div class="row">
                                    <div class="col-md-5">
                                        <?php
                                        echo $this->Form->input('proggress_plan.0.date', ['id' => '', 'type' => 'text', 'class' => 'form-control hasdatepicker', 'required' => true]);
                                        ?>
                                    </div>
                                    <div class="col-md-5">
                                        <?php
                                        echo $this->Form->input('proggress_plan.0.progress', ['id' => '', 'type' => 'number', 'max' => '100', 'class' => 'form-control', 'required' => true]);
                                        ?>

                                    </div>
                                    <div class="col-md-2">
                                        <input type="button" class="btn add_file green " value="+"/>
                                        <input type="button" class="btn remove_file btn-danger" value="X"/>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-12">
                            <input type="submit" id="progress-plan-post" class="btn btn-default" value="Submit">
                        </div>
                    </form>


                </div>

            </div>
            <br/>

            <div class="panel panel-default">
                <div class="panel-heading">

                    <h6 class="panel-title"><i class="icon-table2"></i>Add new scheme progress plan </h6>


                </div>
                <div class="panel-body">

                   <?php if($previous_scheme_progress_plans){?>
                    <table class="table table-bordered" id="progress_plan_list">
                        <thead>
                        <tr>
                            <td>Date</td>
                            <td>Progress</td>
                        </tr>
                        </thead>
                        <tbody>
                       <?php foreach($previous_scheme_progress_plans as $row): ?>
                           <tr>
                               <td><?= $this->System->display_date($row->date)?></td>
                               <td><?= $row->progress.'%'?></td>
                           </tr>
                           <?php endforeach;?>
                        </tbody>
                    </table>
                    <?php } else{?>
                       <p>Sorry!</p>
                        <?php }?>

                </div>

            </div>

        </div>
        <div role="tabpanel" class="tab-pane fade" id="actual_progress">

            <div class="panel panel-default">
                <div class="panel-heading">

                    <h6 class="panel-title"><i class="icon-table2"></i>Add new progress </h6>


                </div>
                <div class="panel-body">

                    <form class="form-horizontal" id="progress_form" method="post">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Last Progress</label>
                                <input type="hidden" name="scheme_id" value="<?= $id ?>">
                                <input type="text" class="form-control" id=""
                                       value="<?php echo $previous_scheme_progresses ['progress_value'] ? $previous_scheme_progresses ['progress_value'] : 0 ?>"
                                       readonly>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">New Progress</label>
                                <input type="number" class="form-control" id="" placeholder="" name="progress_value"
                                       max="100" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-5 col-md-offset-1">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Date</label>
                                <input type="text" id="" class="form-control hasdatepicker" name="created_date"
                                       required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Remarks</label>
                                <textarea class="form-control" rows="2" name="remarks"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <input type="submit" id="progress-post" class="btn btn-default" value="Submit">
                        </div>
                    </form>


                </div>

            </div>


        </div>
        <div role="tabpanel" class="tab-pane fade" id="report">


            <div id="chartContainer" style="height: 400px; width: 100%;">
            </div>

        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        var display_date_format = "dd-M-yy";

        $(".hasdatepicker").datepicker({
            dateFormat: display_date_format,
            changeMonth: true,
            changeYear: true,
            yearRange: "-50:+10"
        });

        $('#progress_form').submit(function (event) {
            event.preventDefault();
            $.ajax({
                type: "POST",
                url: '<?= $this->Url->build("/Schemes/edit_scheme_progress/save")?>',
                data: $(this).serialize(),
                timeout: 3000,
                success: function (data, status) {
                    $('#scheme_progress_wrp').html('<div class="alert alert-success" role="alert">' + data + '</div>');
                    $('#scheme_progress').trigger('click');
                }
            });
        });

        $('#progress_plan_form').submit(function (event) {
            event.preventDefault();
            $.ajax({
                type: "POST",
                url: '<?= $this->Url->build("/Schemes/save_scheme_progress_plan")?>',
                data: $(this).serialize(),
                timeout: 3000,
                success: function (data, status) {
                    $('#scheme_progress_wrp').html('<div class="alert alert-success" role="alert">' + data + '</div>');

                    $('#scheme_progress').trigger('click');
                }
            });
        });


        //For add new progress
        $(document).on('click', '.add_file', function () {

            var qq = $('#file_wrapper').attr('data-index_no');
            var index = parseInt(qq);

            $('#file_wrapper').attr('data-index_no', index + 1);
            $(document).on('focus', '.hasDatepicker', function () {

                $(this).removeClass('hasDatepicker').datepicker({
                    dateFormat: display_date_format,
                    changeMonth: true,
                    changeYear: true,
                    yearRange: "-50:+10"
                });
            });
            var html = $('.file_container:last').clone().find('.form-control').each(function () {
                this.name = this.name.replace(/\d+/, index + 1);
                this.id = this.id.replace(/\d+/, index + 1);
                this.value = '';
            }).end();
            $('#file_wrapper').append(html);

        });
        // Remove progress
        $(document).on('click', '.remove_file', function () {
            var obj = $(this);
            var count = $('.file_container').length;
            if (count > 1) {
                obj.closest('.file_container').remove();
            }
        });
    });
</script>

<script type="text/javascript">

    $(document).on('click','#report-chart',function () {
        var chart = new CanvasJS.Chart("chartContainer",
            {
                zoomEnabled: false,
                animationEnabled: true,
                title:{
                    text: "Plan vs Reality report"
                },
                axisY2:{
                    valueFormatString:"0",

                    maximum: 100,
                    interval: 10,
                    interlacedColor: "#F5F5F5",
                    gridColor: "#D7D7D7",
                    tickColor: "#D7D7D7"
                },
                theme: "theme2",
                toolTip:{
                    shared: true
                },
                legend:{
                    verticalAlign: "bottom",
                    horizontalAlign: "center",
                    fontSize: 15,
                    fontFamily: "Lucida Sans Unicode"

                },
                data: [
                    {
                        type: "line",
                        lineThickness:3,
                        axisYType:"secondary",
                        showInLegend: true,
                        name: "Work Plan",

                        dataPoints: [
                        <?php foreach($previous_scheme_progress_plans as $row): ?>
                            { x: new Date(<?= date('Y',$row->date)?>, <?= date('m',$row->date)?>), y: parseInt( <?= $row->progress?>) },

                        <?php endforeach;?>
                        ]
                    },

                    {
                        type: "line",
                        lineThickness:3,
                        axisYType:"secondary",
                        showInLegend: true,
                        name: "Work Plan -20%",

                        dataPoints: [
                        <?php foreach($previous_scheme_progress_plans as $row): ?>
                            { x: new Date(<?= date('Y',$row->date)?>, <?= date('m',$row->date)?>), y: parseInt( <?= $row->progress?>-20) },

                        <?php endforeach;?>
                        ]
                    }, {
                        type: "line",
                        lineThickness:3,
                        axisYType:"secondary",
                        showInLegend: true,
                        name: "Proggress",

                        dataPoints: [
                        <?php foreach($actually_scheme_progress as $row): ?>
                            { x: new Date(<?= date('Y',$row->created_date)?>, <?= date('m',$row->created_date)?>), y:  parseInt(<?= $row->progress_value?>) },

                        <?php endforeach;?>




                        ]
                    }



                ],
                legend: {
                    cursor:"pointer",
                    itemclick : function(e) {
                        if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                            e.dataSeries.visible = false;
                        }
                        else {
                            e.dataSeries.visible = true;
                        }
                        chart.render();
                    }
                }
            });

        chart.render();
    });
</script>
