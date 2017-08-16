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
        <div class="col-md-12">
            <h3 class="text-center">এলজিইডি, গাজীপুর জেলার <?= $this->Common->eng_to_bn_month(date('M')); ?> / <?= $this->Common->eng_to_bn(date('Y')); ?> ইং মাসের অগ্রগতি প্রতিবেদন</h3>
        </div>
        <div class="col-sm-12">
            <table class="table table-bordered" style="border: 1px solid #eee; margin-bottom: 10px;">
                <thead>
                <tr>
                    <th><?= __('id') ?></th>
                    <th><?= __('Project Name') ?></th>
                    <th><?= __('0-20(%) Progress') ?></th>
                    <th><?= __('21-30(%) Progress') ?></th>
                    <th><?= __('31-40(%) Progress') ?></th>
                    <th><?= __('41-50(%) Progress') ?></th>
                    <th><?= __('51-60(%) Progress') ?></th>
                    <th><?= __('61-70(%) Progress') ?></th>
                    <th><?= __('71-80(%) Progress') ?></th>
                    <th><?= __('81-90(%) Progress') ?></th>
                    <th><?= __('91-100(%) Progress') ?></th>
                    <th><?= __('Total Scheme') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($results as $key => $result)
                { $sum = 0;
                    ?>
                    <tr>
                        <td><?= $this->Number->format($key+1); ?></td>
                        <td><?= $result['project'] ?></td>
                        <td><?= $result['0to20'] ?></td>
                        <td><?= $result['21to30'] ?></td>
                        <td><?= $result['31to40'] ?></td>
                        <td><?= $result['41to50'] ?></td>
                        <td><?= $result['51to60'] ?></td>
                        <td><?= $result['61to70'] ?></td>
                        <td><?= $result['71to80'] ?></td>
                        <td><?= $result['81to90'] ?></td>
                        <td><?= $result['91to100'] ?></td>
                        <td><?= $sum = $result['0to20'] + $result['21to30'] + $result['31to40'] + $result['41to50'] + $result['51to60'] + $result['61to70'] + $result['71to80'] + $result['81to90'] + $result['91to100'] ?></td>
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