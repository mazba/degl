<?php
$newspapers = json_decode($result['newspaper'], true);
//pr(date('d-m-Y',$result['applied_etender_date']));die;
?>

<link href="https://fonts.googleapis.com/css?family=Asap" rel="stylesheet">
<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyDm0DLjHrJ0j56M4Od2ch81kP0wIIhDpzk"></script>
<div class="col-md-12">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="col-sm-12">
	<button style="float: right;margin-top: 5px" onclick="print_rpt()">Print</button>
</div>
<div id="PrintArea">
	<div class="panel-body font-size-work" align="center" style="background-color: #DBEAF9;color: #0c0c0c;padding:0px 30px;">
		<h4 align="center" style="line-height: 16px">=নোট সীট=</h4>
		<h1 align="center" style="line-height: 16px">নির্বাহী প্রকৌশলী </h1>
		<h2 align="center" style="line-height: 16px"> স্থানীয় সরকার প্রকৌশল অধিদপ্তর, গাজীপুর</h2>
		<br/> <br/>
		<div  style="width:100%; text-align: center;">
			<table style="width:100%; font-size: 15px" >
				<tr>
					<td width="80%" style="text-align: left; padding-left: 1.7em;">নথি নং-  <?= $result['nothi_name']?$result['nothi_name']:'....' ?></td>
					<td width="20%" style="text-align: right;">তারিখঃ-  <?= $result['work_order_date']?$this->Common->EngToBanglaNum(date('d-m-Y', $result['work_order_date'])). ' ইং':'....'; ?>  </td>

				</tr>
			</table>
			<br/>

			<div  style="width:100%; text-align: left; margin-left:3%; padding-right:3%;">
				<b>১। বিষয়: Contract Agreement (চুক্তিপত্র) সহ কার্যাদেশ প্রদান প্রসঙ্গে। </b>

				<br/><br/>
				<table style="width: 100%; margin-left: 15px">
					<tr>
						<td style="width: 96px !important; vertical-align: top"><b>ক) প্রকল্পের নাম: </b></td>
						<td><?= $result['project_name']?$result['project_name']:'....' ?></td>
					</tr>
				</table>
				<br/>
				<table style="width:100%; margin-left: 15px">
					<tr>
						<td style="width: 91px !important; vertical-align: top"><b>খ) কাজের নাম: </b></td>
						<td><?= $result['work_name']?$result['work_name']:'....' ;?><?php echo " (Contract Package No: ".$result['name_en'].")";?></td>
					</tr>
				</table>
				<br/>
				<b><span style="margin-left: 35px">e-Tender ID No:</span></b>&nbsp;<?= $result['etender_no']?$result['etender_no']:'....';  ?>
				<br/><br/>

				<table style="width:100%; margin-left: 15px">
					<tr>
						<td width="45%"><b>(গ) প্রাক্কলন অনুমোদনের স্মারক নং:</b>  <?= $result['estimation_sarok_no']?$result['estimation_sarok_no']:'....';  ?></td>
						<td width="25%">তারিখ:
							<?php ?>
							<?= $result['estimation_date']?$this->Common->EngToBanglaNum(date('d-m-Y', $result['estimation_date'])). ' ইং':'....'; ?>  </td>
						<td width="30%">টাকা: <?= $result['estimation_taka']?number_format($result['estimation_taka'],2):'....'; ?></td>
					</tr>
				</table>
				<br/>
				<table style="width:100%;margin-left: 15px">
					<tr>
						<td style="width: 50%; vertical-align: top"><b>(ঘ) e-Tender দরপত্র বিজ্ঞপ্তি নং: </b><?= $result['etender_notice']?$result['etender_notice']:'....';  ?> </td>
						<td width="50%">তারিখঃ   <?= $result['e_tender_date']?$this->Common->EngToBanglaNum(date('d-m-Y', $result['e_tender_date'])). ' ইং':'....'; ?> </td>
					</tr>
				</table>
				<br/>
				<table style="width:100%; font-size: 15px; margin-left: 15px">
					<tr>
						<td style="margin-bottom: 5px" colspan="5"><b>(ঙ) বিজ্ঞপ্তি প্রকাশিত পত্রিকার নামঃ </b> </td>
					</tr>
					<?php if(!empty($newspapers)){
						//								pr($newspapers);die;
						$i=0;
						foreach($newspapers as $newspaper){
							?>
							<tr>
								<td><?php
									echo '<td width="33%">'.$this->Common->EngToBanglaNum(++$i).') '.$newspaper['name'].' '.'</td>'
										.'<td width="15%"></span>'.'প্রকাশের তারিখঃ'.'</td>'
										.'<td width="33%">'.$this->Common->EngToBanglaNum(date('d-m-Y', strtotime($newspaper['date']))).'ইং'.'</td>';
									?>
								</td></tr>
							<?php
						}
					}
					?>

				</table>
				<br/>
				<table style="width:100%; margin-left: 15px">
					<tr>
						<td width="33%"><b>(চ) দরপত্র গ্রহণের তারিখঃ </b><?= $result['applied_etender_date']?$this->Common->EngToBanglaNum(date('d-m-Y',$result['applied_etender_date'])).'ইং':'.....'?></td>
						<td width="33%"> প্রাপ্ত দরপত্র সংখ্যা :    <?= $result['obtain_tender_no']?sprintf("%02d", $result['obtain_tender_no']).'টি':'....';  ?> </td>
						<td width="33%"> রীতিসিদ্ধ দরপত্র সংখ্যা :  <?= $result['customary_tender_no']?sprintf("%02d",$result['customary_tender_no']).'টি':'.....';  ?></td>
					</tr>
				</table>
				<br/>
				<table style="width: 100%; margin-left: 15px">
					<tr>
						<td style="width: 149px !important; vertical-align: top"><b>(ছ) দাখিলকৃত দরপত্র মূল্য: </b></td>
						<td>
							<?php if($result['applied_tender_price']): ?>
								<?=  number_format($result['applied_tender_price']) ?>;
								(
								<?php $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
								echo $f->format($result['applied_tender_price']); ?>
								)
							<?php else: ?>
								<span>.....</span>
							<?php endif ?>
						</td>
					</tr>
				</table>
				<br/>
				<table style=" margin-left: 15px">
					<tr>
						<td style="width: 230px; vertical-align: top"><b>(জ) <?= $result['performance_security']?(int)$result['performance_security']:'....' ?>% Performance Security:</b></td>
						<td><?= $result['applied_tender_price']?number_format(($result['applied_tender_price']*$result['performance_security'])/100):'....';  ?> টাকা</td>
					</tr>
				</table>
				<br/>
				<table style="margin-left: 15px">
					<tr>
						<td style="vertical-align: top"><b>(ঝ) </b></td>
						<td style="text-align: justify !important"><b>&nbsp;নির্বাচিত ঠিকাদার :</b><?= $result['contractor_title']?$result['contractor_title']:'....' ?> এর নামে e-GP  এর মাধ্যমে  NOA  প্রদান করা হয় (কপি নথিতে সংরক্ষিত) ।
							NOA প্রাপ্তির পর ঠিকাদার <?= $result['contractor_title']?$result['contractor_title']:'.....' ?>  চুক্তি সম্পাদনের নিমিত্তে P/S হিসাবে <?= $result['applied_tender_price']?number_format(($result['applied_tender_price']*$result['performance_security'])/100):'....'; ?>
							টাকার  পে অর্ডার (পে অর্ডার নং <?= $result['order_number']?$result['order_number']:'....' ?> তারিখ <?= $result['initial_date']?$this->Common->EngToBanglaNum(date('d-m-Y', $result['initial_date'])):'....' ?>
							মেয়াদ <?= $result['expire_date']?$this->Common->EngToBanglaNum(date('d-m-Y',$result['expire_date'])):'....'?> <?= $result['order_medium']?$result['order_medium']:'....'?> ) e-GP এর মাধ্যমে গত
							<?= $result['submit_date']?$this->Common->EngToBanglaNum(date('d-m-Y',$result['submit_date'])):'....'?> তারিখে <?= $result['order_branch']?$result['order_branch']:'....'?> শাখায় দাখিল করেছেন
							(কপি নথিতে সংরক্ষিত)।
							<br/><br/>
							<b>The Particulars of the Bank Account Nominated.</b>
							<br/><br/>
							এমতাবস্থায়, চাহিত ব্যাংক গ্যারান্টি দাখিল করায় <?= $result['contractor_title']?$result['contractor_title']:'....' ?> এর দাখিলকৃত দর- <?= $result['applied_tender_price']?number_format($result['applied_tender_price']):'....';  ?>  টাকার Contract Agreement  (চুক্তিপত্র স্বাক্ষরের নিমিত্তে নথি পেশ করা হলো।
							সদয় অনুমোদিত হলে চুক্তিপত্রসহ প্রস্তুতকৃত Letter of Proceed  স্বাক্ষর করা যেতে পারে।</td>

					</tr>
				</table>

				<br/><br/><br/><br/>

				<table style="width:100%;  font-size: 15px; margin-bottom: -15px; margin-top: 15px ; margin-left: 15px"  align="center" >
					<tr>
						<td width="20%" align="center">উচ্চমান সহকারী<br/>
							এলজিইডি, গাজীপুর    </td>
						<td width="20%" align="center">	উপ-সহকারী প্রকৌশলী <br/>
							এলজিইডি, গাজীপুর   </td>
						<td width="20%" align="center">
							সহকারী প্রকৌশলী <br/>
							এলজিইডি, গাজীপুর
						</td>
						<td width="20%" align="center">
							সিনিয়র সহকারী প্রকৌশলী <br/>
							এলজিইডি, গাজীপুর
						</td>
						<td width="20%" align="center">

							নির্বাহী প্রকৌশলী <br/>
							এলজিইডি, গাজীপুর
						</td>
					</tr>
				</table>
				<br/><br/><br/>
			</div>
		</div>
	</div>
	<style>
		.font-size-work{
			font-size: 17px;
		}
		.news{
			margin-right: 4em;
		}
		table tr td {
			font-size: 17px !important;
			text-align: left !important;
		}
	</style>
</div>
<style>
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
		font-family: 'SutonnyOMJ' !important;
		text-align: left !important;;
	}
</style>
<script>
	function print_rpt() {
		URL = "<?php echo $this->request->webroot; ?>page/Print_a4_Eng.php?selLayer=PrintArea";
		day = new Date();
		id = day.getTime();
		eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=yes,scrollbars=yes ,location=0,statusbar=0 ,menubar=yes,resizable=1,width=880,height=600,left = 20,top = 50');");
	}
</script>
