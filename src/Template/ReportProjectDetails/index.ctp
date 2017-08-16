<?php
//pr($scheme_statuses);die;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Project Report') ?></li>
    </ul>
</div>

<div class="row">
    <div class="col-md-12">
        <button style="margin-right: 5px; margin-bottom: 1em" class="btn btn-info pull-right" id="print_button" onclick="print_rpt()"><?= __('Print') ?></button>
    </div>
    <div id="PrintArea" style="margin-top: 10px; padding: 5px; margin-bottom: 10px">
        <div class="col-sm-12">
            <table class="table table-bordered" style="border: 1px solid #eee; margin-bottom: 10px;">
                <thead>
                <tr>
                    <th><?= __('id') ?></th>
                    <th><?= __('Project Name') ?></th>
                    <th><?= __('No of Schemes') ?></th>
                    <th><?= __('Ongoing Schemes') ?></th>
                    <th><?= __('Completed Schemes') ?></th>

                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($scheme_statuses as $key => $project)
                {
                    ?>
                    <tr>
                        <td><?= $this->Number->format($key+1); ?></td>
                        <td><?= isset($project['title'])?$project['title']:'' ?></td>
                        <td><?= isset($project['number_of_scheme'])?$this->Number->format($project['number_of_scheme']):''; ?></td>
                        <td><?= isset($project['deactive'])?$this->Number->format($project['number_of_scheme']-$project['deactive']):$this->Number->format($project['number_of_scheme']); ?></td>
                        <td><?= isset($project['deactive'])?$this->Number->format($project['deactive']):'0'; ?></td>
                    </tr>

                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<script>
    function print_rpt(){
        URL="<?php echo $this->request->webroot; ?>page/Print_a4_Eng.php?selLayer=PrintArea";
        day = new Date();
        id = day.getTime();
        eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=yes,scrollbars=yes ,location=0,statusbar=0 ,menubar=yes,resizable=1,width=880,height=600,left = 20,top = 50');");
    }
</script>