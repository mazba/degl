<link href="https://fonts.googleapis.com/css?family=Asap" rel="stylesheet">
<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyDm0DLjHrJ0j56M4Od2ch81kP0wIIhDpzk"></script>

<div class="panel-body" align="center" style="background-color: #DBEAF9;color: #0c0c0c;">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 align="center">=নোট সীট=</h4>

        <h1 align="center">নির্বাহী প্রকৌশলী </h1>

        <h2 align="center"> স্থানীয় সরকার প্রকৌশল অধিদপ্তর, গাজীপুর</h2>
 	<br/> <br/>
	 <div  style="width:100%; text-align: center;">       
		<table style="width:100%">
		  <tr>
		    <td width="50%"><b>নথি নং: </b> এলজিইডি/নিঃপ্রঃ/গাজী/ওজওউচ-২/এঅত/উড-৭৬/২০১৭/   </td>
		    <td width="50%"><b>তারিখঃ </b> <?php echo date('d-m-Y', $result[0]['work_order_date']); ?>  </td>  
		    
		  </tr>
		</table>
		<br/><br/><br/>
		
	 	<div  style="width:100%; text-align: left; margin-left:3%; padding-right:3%;">	
		<b>১। বিষয়: Contract Agreement (চুক্তিপত্র) সহ কার্যাদেশ প্রদান প্রসঙ্গে। </b>
		
		<br/><br/>
		<b>ক) প্রকল্পের নাম:</b>
		<br/><br/>
		<b>খ) কাজের নাম:</b> <?php echo $result[0]['name_en']; ?>
		<br/><br/>
		<b>e-Tender ID No:</b><?php echo $result[0]['etender_no'];  ?>
		<br/><br/>
		
		<table style="width:100%">
		  <tr>
		    <td width="33%"><b>(গ)বরাদ্দ নং:</b>  <?php echo $result[0]['allotment_no'];  ?></td>
		    <td width="33%"><b>তারিখ:</b> <?php echo date('d-m-Y', $result[0]['allotment_date']); ?>  </td>    
		    <td width="33%"><b>	টাকা:</b> <?php echo $result[0]['allotment_bill']; ?></td> 
		  </tr>
		</table>
		<br/><br/>
		<table style="width:100%">
		  <tr>
		    <td width="50%"><b>(ঘ) e-Tender দরপত্র বিজ্ঞপ্তি নং: </b> <?php echo $result[0]['etender_no'];  ?></td>
		    <td width="50%"><b>তারিখঃ </b>  <?php echo date('d-m-Y', $result[0]['etender_date']); ?> </td>    
		  </tr>
		</table>
		<br/><br/>
		<b>(ঙ) বিজ্ঞপ্তি প্রকাশিত পত্রিকার নামঃ </b>
		<br/><br/>
		<b>(চ) দরপত্র গ্রহণের তারিখঃ </b>
		<br/><br/>
		<table style="width:100%">
		  <tr>
		    <td width="50%"><b>(ছ) প্রাপ্ত দরপত্র সংখ্যা :   </b> <?php echo $result[0]['number_of_tender'];  ?> টি</td>
		    <td width="50%"><b> রীতিসিদ্ধ দরপত্র সংখ্যা :	</b>  <?php echo $result[0]['habitual_number_of_tender'];  ?> টি </td>    
		  </tr>
		</table>
		<br/><br/>
		<b>(জ) দাখিলকৃত দরপত্র মূল্য:  </b> <?php echo $result[0]['applied_tender_price'];  ?>
		<br/><br/>
		<b>(ঝ) 14% Performance Security:</b> <?php echo $result[0]['performance_security'];  ?>
		<br/><br/>
		<b>(ঞ)নির্বাচিত ঠিকাদার :</b> ... এর নামে e-GP  এর মাধ্যমে  NOA  প্রদান করা হয় (কপি নথিতে সংরক্ষিত) ।  NOA প্রাপ্তির পর ঠিকাদার ...  চুক্তি সম্পাদনের নিমিত্তে P/S ...বাবদ ।  টাকার ব্যাংক গ্যারান্টি (ব্যাংক:..., ব্যাংক গ্যারান্টি নং:..., তারিখঃ..., মেয়াদঃ ...)।
		
		<br/><br/>
		 এমতাবস্থায়, চাহিত ব্যাংক গ্যারান্টি দাখিল করায় .... এর দাখিলকৃত দর- ...( )  টাকার Contract Agreement  (চুক্তিপত্র স্বাক্ষরের নিমিত্তে নথি পেশ করা হলো। সদয় অনুমোদিত হলে চুক্তিপত্রসহ প্রস্তুতকৃত Letter of Proceed  স্বাক্ষর করা যেতে পারে।
		 
		 
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
<?php
//echo "<pre>";
//print_r($result);
//echo "</pre>";

?>