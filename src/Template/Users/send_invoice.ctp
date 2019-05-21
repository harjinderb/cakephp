<!-- Content Wrapper. Contains page content -->
  <div style="width:800px; margin:50px auto;">
    <!-- Main content -->
    <section class="content" style="font-size:14px; font-family:arial">
		<div class="box">
            <div style="background-color:#4099ff; color:#fff; padding:10px 0; width:800px; float:left;">
				<div style="width:47%; padding:0; float:left; margin-right: 3%;">
					
					<?php 	
							if($Setting['calendarfrmt'] == 'School calendar'){
								$date1 = date('Y-m-d', strtotime($Setting['schooldatestart']));
								$date2 = date('Y-m-d', strtotime($Setting['schooldateend']));
								$diff = abs(strtotime($date2) - strtotime($date1));
								$years = floor($diff / (365*60*60*24));
								$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
								$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
							}else{
								$months = 12;
							}

							$encryptionkey=$this->request->getSession()->read('Auth.User.encryptionkey');
                       	 	$dataimage=$this->request->getSession()->read('Auth.User.image');
                        	$name = $this->Decryption->mc_decrypt($this->request->getSession()->read('Auth.User.firstname'),$encryptionkey).' '.$this->Decryption->mc_decrypt($this->request->getSession()->read('Auth.User.lastname'),$encryptionkey);
                        	$createddate = date("Y-m-d");
                        	$test_final = '';
                        	$start_date = date("d-m-Y");
							$time = strtotime($start_date);
                        	$final = DUE_DATE;
                        ?>
                        <h3 style="font-size:24px; margin:0;"><?=$name?></h3>
				</div>
				<div style="width:47%; padding:0; float:left; text-align:right; margin-left: 3%;">
					<h3 style="font-size:22px;margin:0;"> Invoice </h3>
				</div>
			</div>

            <!-- /.box-header -->
            <div class="box-body">
				<div class="invoice-info" style="width:800px; float:left; margin-top:30px; font-size:13px">
					<div style="width:47%; padding:0; float:left; margin-right: 3%;">
						<div style="padding:20px; border: 1px solid #4099ff;">
							<p><span style="width:160px; display:inline-block"><b><?=__('DOB : ')?></b></span><?= date('d-m-Y', strtotime($this->Decryption->mc_decrypt($users['dob'],$users['encryptionkey'])))?></p>
							<p><span style="width:160px; display:inline-block"><b><?=__('Father Name : ')?></b></span><?= $this->Decryption->mc_decrypt($parent['firstname'],$parent['encryptionkey']).$this->Decryption->mc_decrypt($parent['lastname'],$parent['encryptionkey'])?></p>
							<p><span style="width:160px; display:inline-block"><b><?=__('REGD ID : ')?></b></span>REG-ID 00234</p>
							<p><span style="width:160px; display:inline-block"><b><?=__('Registration Date : ')?></b></span>12 July 2018</p>
							<p><span style="width:160px; display:inline-block"><b><?=__('School Name : ')?></b></span><?= $school->name?></p>
						</div>
					</div><div style="width:47%; padding:0; float:left; margin-left: 3%;">
						<div style="padding:20px; border: 1px solid #4099ff;">
							<p><span style="width:160px; display:inline-block"><b><?=__('Invoice Number:')?></b></span> <?php echo $users['bso_id'].'-'.$users['id'].'-'.date('Ymd', strtotime($createddate)).'-'.'0';?></p>
							<p><span style="width:160px; display:inline-block"><b><?=__('Invoice Date : ')?></b></span> <?=$createddate?></p>
							<p><span style="width:160px; display:inline-block"><b><?=__('Relief Time Before Class : ')?></b></span><?=$Setting['relieftimebeforeclass']?></p>
							<p><span style="width:160px; display:inline-block"><b><?=__('Relief Time After Class : ')?></b></span><?=$Setting['relieftimeafterclass']?></p>
							<p><span style="width:160px; display:inline-block"><b><?=__('Pay by Date : ')?></b></span><?=$final?></p>
							<p><span style="width:160px; display:inline-block"><b><?=__('Payable Amount : ')?></b></span><?= $Setting['calendarfrmt']?></p>
						</div>
					</div>
					<?php 
						$final_charges = '';
						foreach ($users['contracts'] as $key => $plan) {
							$invodata = array_values($invoives);
							if(!empty($invoives)){
										$plandate = date('Y-m-d',strtotime($invodata[$key]['invoicestart']));
										$planday = $plan['service_day'];
										$getplanday[] = $planday;
								}else{
										$plandate = date('Y-m-d',strtotime($plan['start_date']));
										$planday = $plan['service_day'];
										$getplanday[] = $planday;
									
								}
								$month = date('m', strtotime($plandate));
								$next = 'next'.' '.$planday;
								$nextdate = date('Y-m-d', strtotime($next , strtotime($plandate)));
								$date1 = date('Y-m-d', strtotime($nextdate));
								$date = new DateTime($date1);
								if($Setting['invoicetype'] == 'weekly'){
											//$thisMonth = $date->format('w');
											if($date->format('w') === $month){
												$alldates[] = strtotime($date->format('Y-m-d'));
											}
								}
								if($Setting['invoicetype'] == 'monthly'){
									//$thisMonth = $date->format('m');
									while ($date->format('m') === $month) {
										$alldates[] = strtotime($date->format('Y-m-d'));
										$date->modify($next);
									}
									
								}

								$pday = date('l', strtotime($plandate));
											$plandateday = strtolower($pday);
										if ($plandateday == $planday) {
											$stmplandate = strtotime($plandate);
											array_unshift($alldates, $stmplandate);
								}
							$keyc = $key;
					?>
						
					<div class="invoice-info__plan" style="width:770px; padding:15px; float:left; margin-top:30px; background-color:#ecf0f5;">
						<div style="width:770px; float:left; background:#fff;">
							<div class="invoice-plane-info">
								<div class="invoice-info__plan-header" style="background-color:#4099ff; color:#fff; padding:10px 15px;">
									<h3 style="margin:0; font-size:16px;">Your plan info</h3>
								</div>
								<div class="table-responsive">
									<table Style="border:1px solid #ccc; width:770px;" cellpadding="0" cellspacing="0">
										<tr>	
											<th style="font-size:13px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?=__('Plan Name')?></th>
											<th style="font-size:13px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?=__('No Of Teachers Allotted')?></th>
											<th style="font-size:13px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?=__('Start Time')?></th>
											<th style="font-size:13px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?=__('End Time ')?></th>
											<th style="font-size:13px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?=__('Age Group')?></th>
											<th style="font-size:13px; padding:10px; border-bottom:1px solid #ccc;"><?=__('Price')?></th>
										</tr>
										<tr>
											<td style="font-size:13px; padding:10px; border-right:1px solid #ccc;"><?= $plan['service_type']?><br><span style="font-size:12px;"><?='('. $plan['service_day'].')'?></span></br></td>
											<td style="font-size:13px; padding:10px; border-right:1px solid #ccc;"><?=$plan['add_teacher']?></td>
											<td style="font-size:13px; padding:10px; border-right:1px solid #ccc;"><?= date('H:i:s', strtotime($plan['start_time']))?></td>
											<td style="font-size:13px; padding:10px; border-right:1px solid #ccc;"><?= date('H:i:s', strtotime($plan['end_time']))?></td>
											<td style="font-size:13px; padding:10px; border-right:1px solid #ccc;">Min Age: <?= $plan['min_age']?> Max Age: <?= $plan['max_age']?></td>
											<td style="font-size:13px; padding:10px;"><?= '('.$GlobalSettings->currency_code.')'?> <?= $plan['price']?>/<?= str_replace('_', ' ', $plan['plan_type']);?></td>
										</tr>
										
										
									</table>
								</div>
							</div>
							<div class="invoice-plane-info" style="margin-top:20px">
								<div class="invoice-info__plan-header" style="background-color:#bdc9d7; color:#fff; padding:10px 15px;">
									<h3 style="margin:0; font-size:15px;"><?=__('This Month Charges for')?><b><?= $plan['service_type']?></b> <span style="font-size:13px;"><?='('. $plan['service_day'].')'?></span> Plan</h3>
								</div>
								<div class="table-responsive">
									<table Style="border:1px solid #ccc; width:770px;" cellpadding="0" cellspacing="0">
										<tr>	
											<th style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?=__('Date')?></th>
											<th style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?=__('No Of Teachers Allotted')?></th>
											<th style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?=__('Attendance Start Time')?></th>
											<th style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?=__('Attendance End Time ')?></th>
											<th style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?=__('Overtime')?></th>
											<th style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?=__('Absent')?></th>
											<th style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?=__('Overtime Charges')?></th>
											<th style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?=__('Plan Charges')?></th>
											<th style="font-size:12px; padding:10px; border-bottom:1px solid #ccc;">Total Charges')?></th>
										</tr>
										<?php 
									$att = [];
									$final_charges = '';
									$total = '';
									$checkin_time = '';
									$checkout_time = '';
									$finalAttendanceArray = [];
										$childAttandance =[];
										$childAttandanceDatesheet = [];
									$i = 1;
									//$nextdate = date('Y-m-d', strtotime($next , strtotime($plan['start_date'])));

							if(!empty($users['contracts'][$keyc]['attendances'])){
									foreach ($users['contracts'][$keyc]['attendances'] as $key => $attendtt) {

										$dateday =	date('l', strtotime($attendtt['date_time']));
										
										//$alldates = [];
										if($attendtt['type'] == 'Auth'){
											$childAttandance[] = strtotime(date('Y-m-d', strtotime($attendtt['date_time'])));
										}

										$childAttandanceDatesheet[strtotime(date('Y-m-d', strtotime($attendtt['date_time'])))][] = $attendtt;
									}
								if ($Setting['invoicetype'] == 'weekly') {
									//$thisMonth = $date->format('w');
									$dateweek = date('w', $alldates[0]);
									$childAttandanceed = $childAttandance[$key];
									$week = date("W", $childAttandanceed);
									if ($dateweek == $week) {
										$childAttandance = $childAttandance;
										$result = array_diff($alldates, $childAttandance);
									} else {
										$childAttandance = [];
										$result = $alldates;
									}
								}
								//pr($childAttandance);
								if ($Setting['invoicetype'] == 'monthly') {
									//$thisMonth = $date->format('m');
									$datemonth = date('m', $alldates[0]);
									$childAttandanceed = $childAttandance[$key];
									$month = date('m', $childAttandanceed);
									//die;
									if ($datemonth == $month) {
										$childAttandance = $childAttandance;
										$result = array_diff($alldates, $childAttandance);
										// $alldates[] = strtotime($date->format('Y-m-d'));
										// $date->modify($next);
									} else {
										$childAttandance = [];
										$result = $alldates;
									}
								}
									$resultmerge = array_merge($result,$childAttandance);
									$finalAttendanceArray = array_unique($resultmerge);
								//pr($finalAttendanceArray);
									sort($finalAttendanceArray);
									$currentdate = strtotime($createddate);

									$thisMonthcharges = 0;
									//pr($result);die;
								

								
								//pr('===================After loop================');
							
									$fullcharges = '';
								foreach ($finalAttendanceArray as $key => $finalData) {
									$plandaydate = date('Y-m-d', $finalData);
									$dateday =	date('l', strtotime($plandaydate));

									if($plan['service_day'] == strtolower($dateday)){
										 
										// pr($childAttandanceDatesheet[$finalData]);
										if (isset($childAttandanceDatesheet[$finalData])) {
											//if($attendtt['type'] == 'Auth' && $attendtt['status'] == '1'){
												$checkin_time = date('H:i:s', strtotime($childAttandanceDatesheet[$finalData][0]['date_time']));
											//}
											if(!empty($childAttandanceDatesheet[$finalData][0]['date_time_end'])){
										 	 $checkout_time = date('h:i:s', strtotime($childAttandanceDatesheet[$finalData][0]['date_time_end']));
											}
										} else {
											$checkin_time = '00:00:00';
										 	$checkout_time = '00:00:00';
										}
										$planestart_time = date('H:i:s', strtotime($plan['start_time']));
										$planend_time = date('H:i:s', strtotime($plan['end_time']));
										$workingcheckout_time = (strtotime($checkout_time));
										$workingplanend_time = (strtotime($planend_time));
										$workingcheckin_time = (strtotime($checkin_time));
										$workingplanstart_time = (strtotime($planestart_time));
										$a = new DateTime($checkout_time);
										$b = new DateTime($planend_time);
										$e =  new DateTime($checkin_time);
										$f =  new DateTime($planestart_time);

										if($workingcheckout_time > $workingplanend_time){
											 $Overtimes  = $a->diff($b);
											 $ovaf =  new DateTime($Overtimes->format("%H:%I:%S"));
											 $ralaf =  new DateTime($Setting['relieftimeafterclass']);
											 $Overtime  = $ovaf->diff($ralaf);
											 //$Overtime = $Overtime->diff($Setting['relieftimeafterclass']);
											$Overtime1 = $Overtime->format("%H:%I:%S");
										} 
										if($workingcheckin_time < $workingplanstart_time){
											 $Overtimebf  = $f->diff($e);
											 $ovbf =  new DateTime($Overtimebf->format("%H:%I:%S"));
											 $ralbf =  new DateTime($Setting['relieftimebeforeclass']);
											 $Overtime  = $ovbf->diff($ralbf);
											 $Overtime2 = $Overtime->format("%H:%I:%S");
										}
										else{
											$Overtime ='00:00:00';
										}
										$time = $Overtime1;
										$time2 = $Overtime2;
										$secs = strtotime($time2)-strtotime("00:00:00");
										$Overtime = date("H:i:s",strtotime($time)+$secs);

										$c = new DateTime($planend_time);
										$d = new DateTime($planestart_time);
										$classtime = $c->diff($d);
										$classtimehr = $classtime->format("%H");
										$classtimemin = $classtime->format("%I");
										$classtimehr = $classtimehr *60*60;
										$classtimemin = $classtimemin *60;
										$totaltimesec = $classtimehr + $classtimemin;

										if($plan['plan_type'] == 'price_yearly'){
											 $year = $plan['price'];
											$month = round($year/$months);
											$daycharges = round($month/4);
											$persec_charges = $daycharges/$totaltimesec;
											$persec_overtimcharges = $Setting['overtimecost']/ 3600;
											if($workingcheckout_time > $workingplanend_time){
												$str_time = $Overtime;

												$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

												sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

												 $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
												 if(!empty($Setting['overtimecost'])){
												 	$Overtime_charges = $persec_overtimcharges * $time_seconds;
												 }else{
													$Overtime_charges = $persec_charges * $time_seconds;
												 }
											}
											 elseif($workingcheckin_time < $workingplanstart_time){
											 	//echo $str_time = $Overtime;die('awe');
											 	$str_time = $Overtime;
												$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

												sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

												 $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
												 if(!empty($Setting['overtimecost'])){
												 	$Overtime_charges = $persec_overtimcharges * $time_seconds;
												 }else{
													$Overtime_charges = $persec_charges * $time_seconds;
												 }
											 }
											else{
												$Overtime_charges = "00,00";
											}
										}
										if($plan['plan_type'] == 'price_monthly'){
											$month = round($plan['price']);
											$daycharges = round($month/4);
											$persec_charges = $daycharges/$totaltimesec;
											$persec_overtimcharges = $Setting['overtimecost']/ 3600;
											if($workingcheckout_time > $workingplanend_time){
												$str_time = $Overtime;

												$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

												sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

												 $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
												 if(!empty($Setting['overtimecost'])){
												 	$Overtime_charges = $persec_overtimcharges * $time_seconds;
												 }else{
													$Overtime_charges = $persec_charges * $time_seconds;
												 }
											}
											 elseif($workingcheckin_time < $workingplanstart_time){
											 	//echo $str_time = $Overtime;die('awe');
											 	$str_time = $Overtime;
												$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

												sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

												 $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
												 if(!empty($Setting['overtimecost'])){
												 	$Overtime_charges = $persec_overtimcharges * $time_seconds;
												 }else{
													$Overtime_charges = $persec_charges * $time_seconds;
												 }
											 }
											else{
												$Overtime_charges = "00,00";
											}
										}
										if($plan['plan_type'] == 'price_weekly'){
											$daycharges = round($plan['price']);
											$persec_charges = $daycharges/$totaltimesec;
											$persec_overtimcharges = $Setting['overtimecost']/ 3600;
											if($workingcheckout_time > $workingplanend_time){
												$str_time = $Overtime;

												$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

												sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

												 $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
												 if(!empty($Setting['overtimecost'])){
												 	$Overtime_charges = $persec_overtimcharges * $time_seconds;
												 }else{
													$Overtime_charges = $persec_charges * $time_seconds;
												 }
											}
											 elseif($workingcheckin_time < $workingplanstart_time){
											 	//echo $str_time = $Overtime;die('awe');
											 	$str_time = $Overtime;
												$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

												sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

												 $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
												 if(!empty($Setting['overtimecost'])){
												 	$Overtime_charges = $persec_overtimcharges * $time_seconds;
												 }else{
													$Overtime_charges = $persec_charges * $time_seconds;
												 }
											 }
											else{
												$Overtime_charges = "00,00";
											}
										}
										$fullcharges = $daycharges + $Overtime_charges;
										
										 if (in_array($finalData, $childAttandance)) {

										 	$atstartdate = $childAttandanceDatesheet[$finalData][0]['date_time'];
											$tz = new \DateTimeZone($GlobalSettings->timezone);
											$dateattenstart = new \DateTime($atstartdate);
											$dateattenstart->setTimezone($tz);
											$attenstart_timey = $dateattenstart->format('H:i:s');
											$atenddate = $childAttandanceDatesheet[$finalData][0]['date_time_end'];
											$dateattenend = new \DateTime($atenddate);
											$dateattenend->setTimezone($tz);
											$attenend_timey = $dateattenend->format('H:i:s');		
										?>
										<tr>
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?= date('d-m-Y', strtotime($childAttandanceDatesheet[$finalData][0]['date_time']));?></td>
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?=$plan['add_teacher']?></td>
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?= $attenstart_timey?></td>
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?php
														if(!empty($childAttandanceDatesheet[$finalData][0]['date_time_end'])){
													 	echo $attenend_timey;
														}else{
															echo '00:00:00';
														}

													 ?></td>
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?=$Overtime ?></td>
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?= "Present"?></td>
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?= '('.$GlobalSettings->currency_code.')'?> <?= round($Overtime_charges)?></td>
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?= '('.$GlobalSettings->currency_code.')'?> <?=$daycharges?></td>
											<td style="font-size:12px; padding:10px; border-bottom:1px solid #ccc;"><?= '('.$GlobalSettings->currency_code.')'?><?= round($fullcharges) ?></td>
										</tr>
										<?php		
										} else {
											$fullcharges =$daycharges;
										?>
										<tr>
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?= date('d-m-Y', $finalData);?></td>
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?=$plan['add_teacher']?></td>
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?php echo '--';// date('H:i:s', strtotime($planestart_time))?></td>
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?php echo '--';// date('H:i:s', strtotime($planend_time)) ?></td>
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?= '00:00:00' ?> Hours</td>
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?php if($finalData < $currentdate){echo "Absent";}else{ echo "N/A" ;}  ?></td>
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?= '('.$GlobalSettings->currency_code.')'?><?='00:00'?></td>
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?= '('.$GlobalSettings->currency_code.')'?><?=$daycharges?></td>
											<td style="font-size:12px; padding:10px; border-bottom:1px solid #ccc;"><?= '('.$GlobalSettings->currency_code.')'?> <?= round($fullcharges) ?></td>
										</tr>
										<?php 
										}
									 		$total += $fullcharges;
									}
								}
							}else {
										$planestart_time = date('H:i:s', strtotime($plan['start_time']));
										$planend_time = date('H:i:s', strtotime($plan['end_time']));
										$c = new DateTime($planend_time);
										$d = new DateTime($planestart_time);
										$classtime = $c->diff($d);
										$classtimehr = $classtime->format("%H");
										$classtimemin = $classtime->format("%I");
										$classtimehr = $classtimehr *60*60;
										$classtimemin = $classtimemin *60;
										$totaltimesec = $classtimehr + $classtimemin;
										$currentdate = strtotime($createddate);

										if($plan['plan_type'] == 'price_yearly'){
											 $year = $plan['price'];
											$month = round($year/$months);
											$daycharges = round($month/4);
											$persec_charges = $daycharges/$totaltimesec;
											// if($workingcheckout_time > $workingplanend_time){
											// 	$str_time = $Overtime;

											// 	$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

											// 	sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

											// 	 $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
											// 	 $Overtime_charges = $persec_charges * $time_seconds;
											// }
											//  elseif($workingcheckin_time < $workingplanstart_time){
											//  	//echo $str_time = $Overtime;die('awe');
											//  	$str_time = $Overtime;
											// 	$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

											// 	sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

											// 	 $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
											// 	 $Overtime_charges = $persec_charges * $time_seconds;
											//  }
											// else{
												$Overtime_charges = "00,00";
											//}
										}
										if($plan['plan_type'] == 'price_monthly'){
											$month = round($plan['price']);
											$daycharges = round($month/4);
											$persec_charges = $daycharges/$totaltimesec;
											// if($workingcheckout_time > $workingplanend_time){
											// 	$str_time = $Overtime;

											// 	$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

											// 	sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

											// 	 $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
											// 	 $Overtime_charges = $persec_charges * $time_seconds;
											// }
											//  elseif($workingcheckin_time < $workingplanstart_time){
											//  	//echo $str_time = $Overtime;die('awe');
											//  	$str_time = $Overtime;
											// 	$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

											// 	sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

											// 	 $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
											// 	 $Overtime_charges = $persec_charges * $time_seconds;
											//  }
											// else{
												$Overtime_charges = "00,00";
											//}
										}
										if($plan['plan_type'] == 'price_weekly'){
											$daycharges = round($plan['price']);
											$persec_charges = $daycharges/$totaltimesec;
											// if($workingcheckout_time > $workingplanend_time){
											// 	$str_time = $Overtime;

											// 	$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

											// 	sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

											// 	 $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
											// 	 $Overtime_charges = $persec_charges * $time_seconds;
											// }
											//  elseif($workingcheckin_time < $workingplanstart_time){
											//  	//echo $str_time = $Overtime;die('awe');
											//  	$str_time = $Overtime;
											// 	$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

											// 	sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

											// 	 $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
											// 	 $Overtime_charges = $persec_charges * $time_seconds;
											//  }
											// else{
												$Overtime_charges = "00,00";
											// }
										}
											//echo $daycharges;
										$alldates = array_unique($alldates);
											$fullcharges = $daycharges;
											foreach ($alldates as $key => $finalData) {
											$plandaydate = date('Y-m-d', $finalData);
											$dateday =	date('l', strtotime($plandaydate));
											if($plan['service_day'] == strtolower($dateday)){
									?>
									<tr>
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?= date('d-m-Y', $finalData);?></td>
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?=$plan['add_teacher']?></td>
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?php echo '--';//date('H:i:s', strtotime($planestart_time))?></td>
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?php echo '--';// date('H:i:s', strtotime($planend_time)) ?></td>
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?= '00:00:00' ?> Hours</td>
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?php if($finalData < $currentdate){echo "Absent";}else{ echo "N/A" ;}  ?></td>
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?= '('.$GlobalSettings->currency_code.')'?><?='00:00'?></td>
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?= '('.$GlobalSettings->currency_code.')'?><?=$daycharges?></td>
											<td style="font-size:12px; padding:10px; border-bottom:1px solid #ccc;"><?= '('.$GlobalSettings->currency_code.')'?> <?= round($fullcharges) ?></td>
									</tr>
																				
									<?php 
									$total += $fullcharges;		
											}
										}

										if (!empty($invoices)) {
											$previousinvoice = $invoices['invoiceend'];
										} else {
											$previousinvoice = $users['contracts'][0]['start_date'];
										}
									}	
										//$total += $fullcharges;									
									?>
										<tr>
											<td colspan="8" style="font-size:13px; padding:10px; border-right:1px solid #ccc; text-align:right"><b>Total</b>
											<td style="font-size:13px; padding:10px;"><b><?= '('.$GlobalSettings->currency_code.')'?> <?= round($total) ?></b></td>
										</tr>
										
										
									</table>
								</div>
							</div>
						</div>
					</div>
						<?php 
						  $test_final += $total;

						}
					?>
					
					<div class="invoice-info__plan" style="width:770px; padding:15px; float:left; margin-top:30px; background-color:#ecf0f5;">
						<div style="width:770px; float:left;">
							<div style="width:47%; float:left; padding-right:0; margin-right:3%;">
								<div class="invoice-terms">
									<h3 style="font-size:15px; margin-top:0;">Important Notes</h3>
									<p style="font-size:13px"><span style="color:a94442">*</span> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer.</p>
									<p style="font-size:13px"><span style="color:a94442">*</span> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer.</p>
									<p style="font-size:13px"><span style="color:a94442">*</span> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
								</div>
							</div>
							<div style="width:47%; float:left; padding-left:0; margin-left: 3%;">
								<div style="background-color:#fff">
									<div class="invoice-info__plan-header" style="background-color:#73b4ff; color:#fff; padding:10px 15px;">
										<h3 style="margin:0; font-size:15px;"><?=__('Your Invoice Summary')?></h3>
									</div>
									<table Style="border:1px solid #ccc; width:370px;" cellpadding="0" cellspacing="0">
										<tr>	
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?=__('This Month Charges')?></td>
											<td style="font-size:12px; padding:10px; border-bottom:1px solid #ccc;"><b><?= '('.$GlobalSettings->currency_code.')'?> <?= round($test_final) ?></b></td>
										</tr>
										<tr>	
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?=__('Previous payment')?></td>
											<td style="font-size:12px; padding:10px; border-bottom:1px solid #ccc;"><b><?= '('.$GlobalSettings->currency_code.')'?> 00,00</b></td>
										</tr>
										<tr>	
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?=__('Adjustment')?></td>
											<td style="font-size:12px; padding:10px; border-bottom:1px solid #ccc;"><b>- <?= '('.$GlobalSettings->currency_code.')'?> 0,00</b></td>
										</tr>
										<tr>	
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc; color:a94442"><?=__('Total Payable Amount')?></td>
											<td style="font-size:12px; padding:10px; border-bottom:1px solid #ccc; color:a94442"><b><?= '('.$GlobalSettings->currency_code.')'?> <?= round($test_final) ?></b></td>
										</tr>
										<tr>	
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?=__('Invoice Period')?></td>
											<td style="font-size:12px; padding:10px; border-bottom:1px solid #ccc;"><b><?= date('d-m-Y', strtotime($previousinvoice)).' '.'-'.' '.date('d-m-Y', strtotime( $start_date));?></b></td>
										</tr>
										<tr>	
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc;"><?=__('Pay by Date')?></td>
											<td style="font-size:12px; padding:10px;"><b><?=$final?></b></td>
										</tr>
										
									</table>
								</div>
							</div>
						</div>
					</div>
					
					
					
					<div class="footer-invoice" style="width:770px; padding:0 15px; float:left; margin-top:30px;">
						<div class="invoice-sign-wrap" style="width:100px; height:100px; float:right; border:1px solid #ccc;">
							<img src="dist/img/sign.jpg" alt="Signature" style="width:100px; height:100px;">
						</div>
					</div>
					
				</div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>

