<?php
$newspapers = json_decode($result['newspaper'], true);
//pr($newspapers);die;
?>

<link href="https://fonts.googleapis.com/css?family=Asap" rel="stylesheet">
<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyDm0DLjHrJ0j56M4Od2ch81kP0wIIhDpzk"></script>
<div class="col-sm-12">
	<button style="float: right;margin-top: 5px" onclick="print_rpt()">Print</button>
</div>
<div id="PrintArea">
	<div class="panel-body" align="center" style="background-color: #DBEAF9;color: #0c0c0c;">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
		<h4 align="center">=নোট সীট=</h4>

		<h1 align="center">নির্বাহী প্রকৌশলী </h1>

		<h2 align="center"> স্থানীয় সরকার প্রকৌশল অধিদপ্তর, গাজীপুর</h2>
		<br/> <br/>
		<div  style="width:100%; text-align: center;">
			<table style="width:100%">
				<tr>
					<td width="50%"><b>নথি নং: </b> <?= $result['nothi_name']?>   </td>
					<td width="50%"><b>তারিখঃ </b> <?= $this->Common->EngToBanglaNum(date('d-m-Y', $result['work_order_date'])). ' ইং'; ?>  </td>

				</tr>
			</table>
			<br/><br/><br/>

			<div  style="width:100%; text-align: left; margin-left:3%; padding-right:3%;">
				<b>১। বিষয়: Contract Agreement (চুক্তিপত্র) সহ কার্যাদেশ প্রদান প্রসঙ্গে। </b>

				<br/><br/>
				<b>ক) প্রকল্পের নাম:</b> <?= $result['project_name'] ?>
				<br/><br/>
				<b>খ) কাজের নাম:</b> <?= $result['work_name']; ?>
				<br/><br/>
				<b>e-Tender ID No:</b><?= $result['etender_no'];  ?>
				<br/><br/>

				<table style="width:100%">
					<tr>
						<td width="33%"><b>(গ)প্রাক্কলন অনুমোদনের স্মারক নং:</b>  <?= $result['estimation_sarok_no'];  ?></td>
						<td width="33%"><b>তারিখ:</b> <?= $this->Common->EngToBanglaNum(date('d-m-Y', $result['estimation_date'])). ' ইং'; ?>  </td>
						<td width="33%"><b>	টাকা:</b> <?= $result['estimation_taka']; ?></td>
					</tr>
				</table>
				<br/>
				<table style="width:100%">
					<tr>
						<td width="50%"><b>(ঘ) e-Tender দরপত্র বিজ্ঞপ্তি নং: </b> <?= $result['e_tender_no'];  ?></td>
						<td width="50%"><b>তারিখঃ </b>  <?= $this->Common->EngToBanglaNum(date('d-m-Y', $result['e_tender_date'])). ' ইং'; ?> </td>
					</tr>
				</table>
				<br/><br/>
				<table style="width:100%">
					<tr>
						<td width=""><b>(ঙ) বিজ্ঞপ্তি প্রকাশিত পত্রিকার নামঃ </b>
							<?php if(!empty($newspapers)){
								$i=0;
								foreach($newspapers as $newspaper){
									echo $this->Common->EngToBanglaNum(++$i).') '.$newspaper['name'].' ';
								}
							}
							?>
						</td>
					</tr>
				</table>
				<br/>
				<table style="width:100%">
					<tr>
						<td width=""><b>(চ) বিজ্ঞপ্তি প্রকাশের তারিখঃ </b>
							<?php if(!empty($newspapers)){
								$i=0;
								foreach($newspapers as $newspaper){
									echo $this->Common->EngToBanglaNum(++$i).') '.$this->Common->EngToBanglaNum(date('d-m-Y', strtotime($newspaper['date']))).' ইং ';
								}
							}
							?>
						</td>
					</tr>
				</table>
				<br/><br/>
				<b>(চ) দরপত্র গ্রহণের তারিখঃ </b>
				<br/><br/>
				<table style="width:100%">
					<tr>
						<td width="50%"><b>(ছ) প্রাপ্ত দরপত্র সংখ্যা :   </b> <?= $result['obtain_tender_no']?$result['obtain_tender_no']:'0';  ?> টি</td>
						<td width="50%"><b> রীতিসিদ্ধ দরপত্র সংখ্যা :	</b>  <?= $result['customary_tender_no']?$result['customary_tender_no']:'0';  ?> টি </td>
					</tr>
				</table>
				<br/>
				<b>(জ) দাখিলকৃত দরপত্র মূল্য:  </b> <?= $result['applied_tender_price']?$result['applied_tender_price']:'0';  ?> টাকা
				<br/><br/>
				<b>(ঝ) 14% Performance Security:</b> <?= $result['applied_tender_price']?($result['applied_tender_price']*10)/100:'0';  ?> টাকা
				<br/><br/>

				<b>(ঞ)নির্বাচিত ঠিকাদার :</b> <?= $result['contractor_title'] ?> এর নামে e-GP  এর মাধ্যমে  NOA  প্রদান করা হয় (কপি নথিতে সংরক্ষিত) ।
				NOA প্রাপ্তির পর ঠিকাদার <?= $result['contractor_title'] ?>  চুক্তি সম্পাদনের নিমিত্তে P/S হিসাবে <?= $result['applied_tender_price'];?>
				টাকার  পে অর্ডার (পে অর্ডার নং <?= $result['order_number'] ?> তারিখ <?= $this->Common->EngToBanglaNum(date('d-m-Y', $result['initial_date'])) ?>
				মেয়াদ <?= $this->Common->EngToBanglaNum(date('d-m-Y',$result['expire_date']))?> <?= $result['order_medium']?> ) e-GP এর মাধ্যমে গত
				<?= $this->Common->EngToBanglaNum(date('d-m-Y',$result['submit_date']))?> তারিখে <?= $result['order_medium']?> শাখায় দাখিল করেছেন
				(কপি নথিতে সংরক্ষিত)।
				<br/><br/>
				এমতাবস্থায়, চাহিত ব্যাংক গ্যারান্টি দাখিল করায় <?= $result['contractor_title'] ?> এর দাখিলকৃত দর- <?= $result['applied_tender_price'];  ?>  টাকার Contract Agreement  (চুক্তিপত্র স্বাক্ষরের নিমিত্তে নথি পেশ করা হলো।
				সদয় অনুমোদিত হলে চুক্তিপত্রসহ প্রস্তুতকৃত Letter of Proceed  স্বাক্ষর করা যেতে পারে।


				<br/><br/><br/> <br/><br/><br/>

				<table style="width:100%" align="center">
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
</div>
<?php
//echo "<pre>";
//print_r($result);
//echo "</pre>";

?>
<script>
	function print_rpt() {
		URL = "<?php echo $this->request->webroot; ?>page/Print_a4_Eng.php?selLayer=PrintArea";
		day = new Date();
		id = day.getTime();
		eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=yes,scrollbars=yes ,location=0,statusbar=0 ,menubar=yes,resizable=1,width=880,height=600,left = 20,top = 50');");
	}
</script>
