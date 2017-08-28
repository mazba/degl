<?php
use Cake\Routing\Router;
?>
<?php
//pr($processRaBills);die;
if(!empty($processRaBills)){
    $year = '';
    $temp = count($finalYears);
    if(count($finalYears) > 1){
        foreach($finalYears as $key => $finalYear){
            if($key+1 ==  $temp){
                $year .= $this->Common->EngToBanglaNum($finalYear['fiscal_year']).' ইং';
            }else{
                $year .= $this->Common->EngToBanglaNum($finalYear['fiscal_year']).' ও ';
            }
        }
    }else{
        $year = $this->Common->EngToBanglaNum($finalYears[0]['fiscal_year']).' ইং';
    }
}
if(isset($fiscal) && !empty($fiscal)){
    $fiscal = $this->Common->EngToBanglaNum($fiscal['name']).' ইং';
}
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>"><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('ঠিকাদার প্রত্যয়ন পত্র') ?></li>
    </ul>
</div>
<div class="row">
    <?= $this->Form->create(null, ['class' => 'form-horizontal', 'role' => 'form']); ?>
    <div class="col-md-8">
        <div class="form-group input" >
            <label class="col-sm-3 control-label text-right"><?= __('ঠিকাদার') ?></label>
            <div class="col-sm-9 actual_complete_date" >
                <select class="form-control" name="contractor_id" id="scheme-id" required>
                    <option value=""><?= __('Select') ?></option>
                    <?php
                    foreach ($contractors as $contractors_id => $contractor) {
                        ?>
                        <option value="<?php echo $contractors_id; ?>"><?php echo $contractor; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <?php echo $this->Form->input('financial_year_estimate_id', ['options' => $finalcialYears, 'empty' => __('Select')]); ?>
        <div class="text-center">
            <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary">
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>

<?php if(isset($processRaBills)): ?>

    <div class="col-sm-12">
        <a href="#contractor-qr" data-contractor-id="<?= $qr_image['contractor_id']?>" style="background: green;color: #fff;font-weight: bold;font-size: 14px; float: right; margin-left: 1em" data-toggle="modal" class="ans-btn btn purple"><?= __('আপলোড করুন') ?></a>
        <button style="float: right;margin-top: 5px" onclick="print_rpt()">Print</button>
    </div>
        <div id="PrintArea">
		<div style="padding:20px 50px;">
            <div class="col-sm-12">
                <h2 class="text-center" style="line-height: 14px"><?= __('Government of the People\'s Republic of Bangladesh') ?></h2>
                <h4 class="text-center" style="line-height: 14px"><?= __('Local Govt. Engineering Department') ?> </h4>
                <h4 class="text-center" style="line-height: 14px"><?= __('Office of the Executive Engineer') ?></h4>
                <h4 class="text-center" style="line-height: 14px">নলজানী,<?= __('District: Gazipur') ?></h4>
                <h4 class="text-center" style="line-height: 14px"><a>www.lged.gov.bd</a></h4>
                <div class="shek-hasina">
                    উন্নয়নের গণতন্ত্র<br/>শেখ হাসিনার মূলমন্ত্র
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
				<table style="width:100%">
				  <tr>
					<th valign="top">  <div class="col-sm-8">
                        <p>স্মারক নং - <span contenteditable="true">এখানে স্মারক নং লিখুন</span></p>
                    </div></th>
					<th valign="top"><div class="col-sm-4" >
                        <p style="float: right">তারিখ: <span contenteditable="true">এখানে স্মারক নং লিখুন</span></p>
                    </div></th> 
				  </tr>
				  </table>
                  
                    
                </div>
            </div>
            <div class="col-sm-12">
                <div class="text-center" style="margin-top: -4px; margin-bottom: 0px;" >
                    <h3><u>"প্রত্যয়ন পত্র"</u></h3>
                </div>
            </div>
            <div class="panel-body">
                <?php if(isset($processRaBills) && !empty($processRaBills)):?>
                <div class="row">
                    <div class="col-sm-12" style="line-height: 20px;margin-bottom:10px;    text-align: justify;">
					<span style="line-height: 20px;padding-left:20px;">&nbsp;</span>
                        এই মর্মে প্রত্যয়ন করা যাচ্ছে যে, <?= $processRaBills[0]['contractor_title']?$processRaBills[0]['contractor_title'].', ':''?>
                        <?= $processRaBills[0]['contractor_person_name']?$processRaBills[0]['contractor_person_name'].', ':''?>
                        <?= $processRaBills[0]['contractor_address']?$processRaBills[0]['contractor_address']:'' ?>
                        <?= $processRaBills[0]['contractor_tin_no']?'(TIN '.$processRaBills[0]['contractor_tin_no'].' )':''?> থেকে তিনি <?= $year ?>
                        অর্থ বছরে নিম্নস্বাক্ষরকারীর দপ্তর হতে পরিশোধিত বিলের বিপরীতে সরকারি বিধি মোতাবেক ভ্যাট এবং আয়কর কর্তন করেছে, যার বিবরণ নিম্নরূপ:
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-bordered show-grid">
                            <thead>
                            <tr>
                                <th width="5%"><?= __('ক্রমিক নং') ?></th>
                                <th width="20%"><?= __('অর্থ বছর') ?></th>
                                <th width="25%"><?= __('মোট পরিশোধিত বিল') ?></th>
                                <th width="20%"><?= __('ভ্যাট কর্তন') ?></th>
                                <th width="20%"><?= __('আয়কর কর্তন') ?></th>
                                <th width="15%"><?= __('মন্তব্য') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $sum_bill_amount = 0; $sum_vat = 0; $sum_income_tex = 0; foreach($processRaBills as $key => $processRaBill):?>
                                <tr>
                                    <td><?= $this->Number->format($key+1); ?></td>
                                    <td><?= $this->Common->EngToBanglaNum($processRaBill['fiscal_year']); ?></td>
                                    <td><?= $this->Number->format($processRaBill['bill_amount']); ?></td>
                                    <td><?= $this->Number->format($processRaBill['vat']); ?></td>
                                    <td><?= $this->Number->format($processRaBill['income_tex']); ?></td>
                                    <td></td>
                                    <?php $sum_bill_amount += $processRaBill['bill_amount']; $sum_vat += $processRaBill['vat']; $sum_income_tex += $processRaBill['income_tex'] ?>
                                </tr>

                            <?php endforeach; ?>
                            <tr>
                                <td colspan="2"></td>
                                <td><?= $this->Number->format($sum_bill_amount); ?></td>
                                <td><?= $this->Number->format($sum_vat); ?></td>
                                <td><?= $this->Number->format($sum_income_tex); ?></td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif; if(isset($processRaBills) && !empty($NotFoundProcessRaBills)): ?>
                    এই মর্মে প্রত্যয়ন করা যাচ্ছে যে, <?= $NotFoundProcessRaBills['contractor_title']?$NotFoundProcessRaBills['contractor_title'].', ':''?>
                    <?= $NotFoundProcessRaBills['contractor_person_name']?$NotFoundProcessRaBills['contractor_person_name'].', ':''?>
                    <?= $NotFoundProcessRaBills['contractor_address']?$NotFoundProcessRaBills['contractor_address']:'' ?>
                    <?= $NotFoundProcessRaBills['tin_no']?'(TIN '.$NotFoundProcessRaBills['tin_no'].' )':''?> থেকে তিনি <?= $fiscal ?>
                    অর্থ বছরে অত্র দপ্তরে কোন উন্নয়ন মূলক কাজ করেন নাই এবং কোন প্রকার বিল পরিশোধ করা হয় নাই।
                <?php endif; ?>
                <div class="row">
                    <div class="col-sm-12" style="margin-top: 40px;">
                        <img style="padding-left: 20px !important;" src="<?php echo Router::url('/', true) . 'img/qr_contractor/' . $qr_image['qr_image']; ?>" alt="" height="90px" width="100px">
                        <br/>
					 <span>
                Authenticity of this page is <br>
					verifiable from 
			http://www.lgedgazipur.gov.bd <br>
					With the QR Code.
					</span>
						
						<p class="text-center" style="float: right;font-size:15px;    margin-top: -90px;">
                            (মো: আমিরুল ইসলাম খান)<br>
                            নির্বাহী প্রকৌশলী<br>
                            এলজিইডি, গাজীপুর<br>
                            ফোনঃ ৯২৬৩৯৮৯, ফ্যাক্সঃ ৯২৬৪১২৮<br>
                            Email: xen.gazipur@lged.gov.bd<br>

                        </p>
                    </div>
                </div>
            </div>
            <style type="text/css">
                .shek-hasina {
                    display: inline-block;
                    position: absolute;
                    right: 73px;
                    top: 30px;
                    border: 1px solid #ccc;
                    padding: 5px;
                    text-align: center;
                    color: #ccc;
                    font-size: 13px;
                }
                th{
                    font-weight: normal !important;
                }
                p{
                    font-size: 15px;
                }
                .table td:nth-child(2) { width: 293px; }
                @media print {
                    .shek-hasina {
                        display: inline-block;
                        position: absolute;
                        right: 50px;
                        top: 10px;
                        border: 1px solid #ccc ;
                        padding: 5px ;
                        text-align: center ;
                        color: #ccc ;
                        font-size: 13px ;
                    }
                }
                body{
                    font-family: 'SutonnyOMJ' !important;

                }
                .tablesorter {
                    font-family: 'SutonnyOMJ' !important;;
                }

                table tr thead th {

                    font-family: 'SutonnyOMJ' !important;;
                }

                table tr td {
                    font-family: 'SutonnyOMJ' !important;;
                }
				.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td
				{
					    vertical-align: middle;
						padding: 0px 12px !important;
				
				}
				.table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, 
				.table-bordered>thead>tr>td,
				.table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td
				{
				    border: 1px solid #000 !important;
				}
				
				.table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td
				{
				
						border-top: 1px solid #000 !important;
				}
            </style>
        </div>

        <!-- modal -->
        <div id="contractor-qr" class="modal fade" tabindex="-1" aria-hidden="true">
            <div class="col-md-6 panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title">
                        <i class="icon-paragraph-right2"></i><?= __('Upload scan document') ?>
                    </h6>
                </div>
                <?= $this->Form->create(null, ['action' => 'upload', 'class' => 'form-horizontal', 'role' => 'form', 'type' => 'file']); ?>
                <div class="panel-body col-sm-12">
                    <?php
                    echo $this->Form->input('document', ['type' => 'file', 'data-preview-container' => '#profile_image_preview']);
                    ?>
                    <input type="hidden" value="" name="contractor_id" id="modal-contractor-id">
                </div>
                <div class="col-sm-6 form-actions text-right">
                    <input type="submit" value="<?= __('Save') ?>" class="btn btn-primary ans-btn">
                </div>
            </div>
                <?= $this->Form->end() ?>
        </div>

    <script>
        //  modal contractor_id pass
        $(document).ready(function(){
            $(document).on('click','.ans-btn',function(){
                $('#modal-contractor-id').val($(this).data('contractor-id'));
            });
        });

        function print_rpt() {
            URL = "<?php echo $this->request->webroot; ?>page/Print_a4_Eng.php?selLayer=PrintArea";
            day = new Date();
            id = day.getTime();
            eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=yes,scrollbars=yes ,location=0,statusbar=0 ,menubar=yes,resizable=1,width=880,height=600,left = 20,top = 50');");
        }
    </script>
<?php endif; ?>
