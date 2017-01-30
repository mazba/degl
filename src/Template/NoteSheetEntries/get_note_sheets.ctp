<?php
use Cake\Core\Configure;
use Cake\Routing\Router;

?>
<style>
    .body {
        background-color: #DBEAF9;
        color: #0c0c0c;
    }

    .inner_body {
        padding: 10px;
    }
</style>

<?php if ($val) { ?>
    <div id="body" class="body">
     <div class="row">
         <h4 align="center">=নোট সীট=</h4>

         <h1 align="center">নির্বাহী প্রকৌশলী </h1>

         <h2 align="center"> স্থানীয় সরকার প্রকৌশল অধিদপ্তর, গাজীপুর</h2>
         <?php foreach ($val as $row): ?>

             <div class=" col-sm-12">
                 <div class="inner_body">
                     <?= $row['text'] ?>
                     <?php foreach ($row['access'] as $r) { ?>
                         <div class="col-sm-2">
                             <?php if (isset($r['picture'])) { ?>
                                 <div>
                                     <img src="<?php echo Router::url('/', true) . 'img/signature/' . $r['picture']; ?>"
                                          height="100" width="100">

                                     <p><?php echo date('d-m-Y', $r['date']) ?></p>
                                 </div>
                             <?php } ?>


                         </div>
                     <?php } ?>


                 </div>
                 <br/>

                 <?php if (isset($row['attachments'])){?>
                 <div class="row">
                     <div class="col-sm-12">
                         <div class="col-sm-1">
                             <p><strong>Attachments:</strong></p>
                         </div>
                         <?php foreach ($row['attachments'] as $attachment){?>
                             <?php if($attachment['table']=="lab_bills"){
                                 echo $this->Html->link('<button  class="btn btn-success" type="button">Lab Bill</button>', ['controller'=>'LabBills','action' => 'labBillDetails', $attachment['id'],'scheme',$row['scheme_id']
                                     , '_full' => true], ['escapeTitle' => false, 'title' => 'Lab Bill','target'=>'_blank']);

                             }?>

                             <?php if($attachment['table']=="lab_letter_registers"){
                                 echo $this->Html->link('<button  class="btn btn-success" type="button">Lab Letter</button>', ['controller'=>'lab_letter_registers','action' => 'view', $attachment['id']
                                     , '_full' => true], ['escapeTitle' => false, 'title' => 'Lab Bill','target'=>'_blank']);

                             }?>

                             <?php if($attachment['table']=="vehicle_hire_letter_registers"){
                                 echo $this->Html->link('<button  class="btn btn-success" type="button">Vehicle Letter</button>', ['controller'=>'VehicleHireLetterRegisters','action' => 'view', $attachment['id']
                                     , '_full' => true], ['escapeTitle' => false, 'title' => '','target'=>'_blank']);

                             }?>

                             <?php if($attachment['table']=="hire_charges"){
                                 echo $this->Html->link('<button  class="btn btn-success" type="button">Hire Charge</button>', ['controller'=>'HireCharges','action' => 'view', $attachment['id']
                                     , '_full' => true], ['escapeTitle' => false, 'title' => '','target'=>'_blank']);

                             }?>

                             <?php if($attachment['table']=="proposed_ra_bills"){
                                 echo $this->Html->link('<button  class="btn btn-success" type="button">RA Bill</button>', ['controller'=>'proposed_ra_bills','action' => 'view', $attachment['id']
                                     , '_full' => true], ['escapeTitle' => false, 'title' => '','target'=>'_blank']);

                             }?>
                         <?php }?>
                     </div>
                 </div>
                 </br>


                 <?php };?>
             </div>
             <br/><hr/><br/>


         <?php endforeach; ?>
     </div>


    </div>
<?php } ?>
</br>
</br>
</br>