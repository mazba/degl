<?php
use Cake\Core\Configure;
use Cake\Routing\Router;

?>
<style>
    .panel-body {
        background-color: #DBEAF9;
        color: #0c0c0c;
    }

    #body {
        padding: 10px;
    }
</style>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>">Dashboard</a></li>
        <li><?= $this->Html->link(__('Note Sheet Events'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail Note Sheet Event') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of Note Sheet Events'), ['action' => 'index']) ?> </li>


    </ul>
</div>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading"><h6
                    class="panel-title"><strong>Scheme Name: <?=$scheme_data['name_bn'] ?></strong></h6>
            </div>
            <div class="panel-body">

                <h4 align="center">=নোট সীট=</h4>

                <h1 align="center">নির্বাহী প্রকৌশলী </h1>

                <h2 align="center"> স্থানীয় সরকার প্রকৌশল অধিদপ্তর, গাজীপুর</h2>


                <?php foreach ($val as $row): ?>
                    <div class="col-md-12">

                        <div id="body">
                            <?= $row['text'] ?>
                        </div>
                        <br/>
                        <?php foreach ($row['access'] as $r) { ?>
                            <div class="col-sm-2">
                                <?php if ($r['id'] == $user['designation_id'] && $r['status'] == 'false') {
                                    echo $this->Html->link('<button  class="btn btn-danger" type="button">Approve And Forward</button>', ['action' => 'approve_and_forward', $row['id']
                                        , '_full' => true], ['escapeTitle' => false, 'title' => 'Approve']);

                                } else { ?>

                                       <?php if (isset($r['picture'])){?>
                                        <div>
                                            <img src="<?php echo Router::url('/',true).'img/signature/'.$r['picture']; ?>" height="100" width="100">
                                            <p><?php echo date('d-m-Y',$r['date'])?></p>
                                        </div>
<?php }?>

                                    <?php } ?>

                            </div>



                        <?php } ?>
                        <br/>
                        <br/>
                        <br/>
                        <?php if(isset($row['attachments'])){?>
                            <div class="row">
                                <div class="col-sm-12">

                                    <?php foreach ($row['attachments'] as $attachment){?>

                                        <?php if($attachment['table']=="lab_bills"){
                                            echo $this->Html->link('<button  class="btn btn-success btn-sm" type="button">Lab Bill</button>', ['controller'=>'LabBills','action' => 'labBillDetails', $attachment['id'],'scheme',$row['scheme_id']
                                                , '_full' => true], ['escapeTitle' => false, 'title' => 'Lab Bill','target'=>'_blank']);

                                        }?>

                                        <?php if($attachment['table']=="lab_letter_registers"){
                                            echo $this->Html->link('<button  class="btn btn-success btn-sm" type="button">Lab Letter</button>', ['controller'=>'lab_letter_registers','action' => 'view', $attachment['id']
                                                , '_full' => true], ['escapeTitle' => false, 'title' => 'Lab Bill','target'=>'_blank']);

                                        }?>

                                        <?php if($attachment['table']=="vehicle_hire_letter_registers"){
                                            echo $this->Html->link('<button  class="btn btn-success btn-sm" type="button">Vehicle Letter</button>', ['controller'=>'VehicleHireLetterRegisters','action' => 'view', $attachment['id']
                                                , '_full' => true], ['escapeTitle' => false, 'title' => '','target'=>'_blank']);

                                        }?>

                                        <?php if($attachment['table']=="hire_charges"){
                                            echo $this->Html->link('<button  class="btn btn-success btn-sm" type="button">Hire Charge</button>', ['controller'=>'HireCharges','action' => 'view', $attachment['id']
                                                , '_full' => true], ['escapeTitle' => false, 'title' => '','target'=>'_blank']);

                                        }?>

                                        <?php if($attachment['table']=="proposed_ra_bills"){
                                            echo $this->Html->link('<button  class="btn btn-success btn-sm" type="button">RA Bill</button>', ['controller'=>'proposed_ra_bills','action' => 'view', $attachment['id']
                                                , '_full' => true], ['escapeTitle' => false, 'title' => '','target'=>'_blank']);

                                        }?>
                                    <?php }?>
                                </div>
                            </div>
                        <?php }?>



                    </div>
                <?php endforeach; ?>


            </div>
        </div>

        <div align="center">

        </div>
        </br>
    </div>
</div>