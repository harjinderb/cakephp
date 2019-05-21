<!-- Content Wrapper. Contains page content -->
  <div style="width:800px; margin:50px auto;">
    <!-- Main content -->
    <section class="content" style="font-size:14px; font-family:arial">
		<div class="box">
            <div style="background-color:#4099ff; color:#fff; padding:10px 0; width:800px; float:left;">
				<div style="width:370px; padding:0 15px; float:left;">
					
					<?php 
							$encryptionkey=$this->request->getSession()->read('Auth.User.encryptionkey');
                       	 	$dataimage=$this->request->getSession()->read('Auth.User.image');
                        	$name = $this->Decryption->mc_decrypt($this->request->getSession()->read('Auth.User.firstname'),$encryptionkey).' '.$this->Decryption->mc_decrypt($this->request->getSession()->read('Auth.User.lastname'),$encryptionkey);
                        	$createddate = date("Y-m-d");
                        	$test_final = '';
                        	//pr($school);die;
                        ?>
                        <h3 style="font-size:24px; margin:0;"><?=$name?></h3>
				</div>
				<div style="width:370px; padding:0 15px; float:left; text-align:right">
					<h3 style="font-size:22px;margin:0;"> Invoice </h3>
				</div>
			</div>

            <!-- /.box-header -->
            <div class="box-body">
				<div class="invoice-info" style="width:800px; float:left; margin-top:30px; font-size:13px">
					<div style="width:370px; padding:0 15px; float:left;">
						<div style="padding:20px; border: 1px solid #4099ff;">
							<p><span style="width:160px; display:inline-block"><b>Child Name : </b></span><?= $this->Decryption->mc_decrypt($users['firstname'],$users['encryptionkey']).$this->Decryption->mc_decrypt($users['lastname'],$users['encryptionkey'])?></p>
							<p><span style="width:160px; display:inline-block"><b>Father Name : </b></span><?= $this->Decryption->mc_decrypt($parent['firstname'],$parent['encryptionkey']).$this->Decryption->mc_decrypt($parent['lastname'],$parent['encryptionkey'])?></p>
							<p><span style="width:160px; display:inline-block"><b>REGD ID : </b></span>REG-ID 00234</p>
							<p><span style="width:160px; display:inline-block"><b>Registration Date : </b></span>12 July 2018</p>
							<p><span style="width:160px; display:inline-block"><b>School Name : </b></span><?= $school->name?></p>
						</div>
					</div>
					<div style="width:370px; padding:0 15px; float:left;">
						<div style="padding:20px; border: 1px solid #4099ff;">
							<p><span style="width:160px; display:inline-block"><b>Invoice Number:</b></span> <?php echo $users['bso_id'].'-'.$users['id'].'-'.date('Ymd', strtotime($createddate)).'-'.'0';?></p>
							<p><span style="width:160px; display:inline-block"><b>Invoice Date : </b></span> <?=$createddate?></p>
							<p><span style="width:160px; display:inline-block"><b>Previous Invoice : </b></span> &euro; 795,00</p>
							<p><span style="width:160px; display:inline-block"><b>Pay by Date : </b></span> 22 Sept 2018</p>
							<p><span style="width:160px; display:inline-block"><b>Payable Amount : </b></span> &euro; 765,20</p>
						</div>
					</div>
							<?php 
								$final_charges = '';
								foreach ($users['contracts'] as $key => $plan) {
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
											<th style="font-size:13px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">Plan Name</th>
											<th style="font-size:13px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">No Of Teachers Allotted</th>
											<th style="font-size:13px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">Start Time</th>
											<th style="font-size:13px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">End Time </th>
											<th style="font-size:13px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">Age Group</th>
											<th style="font-size:13px; padding:10px; border-bottom:1px solid #ccc;">Price</th>
										</tr>
										<tr>
											<td style="font-size:13px; padding:10px; border-right:1px solid #ccc;"><?= $plan['service_type']?><br><span style="font-size:12px;"><?='('. $plan['service_day'].')'?></span></br></td>
											<td style="font-size:13px; padding:10px; border-right:1px solid #ccc;"><?=$plan['add_teacher']?></td>
											<td style="font-size:13px; padding:10px; border-right:1px solid #ccc;"><?= date('H:i:s', strtotime($plan['start_time']))?></td>
											<td style="font-size:13px; padding:10px; border-right:1px solid #ccc;"><?= date('H:i:s', strtotime($plan['end_time']))?></td>
											<td style="font-size:13px; padding:10px; border-right:1px solid #ccc;">Min Age: <?= $plan['min_age']?> Max Age: <?= $plan['max_age']?></td>
											<td style="font-size:13px; padding:10px;">&euro; <?= $plan['price']?>/<?= $plan['plan_type']?></td>
										</tr>
										
										
									</table>
								</div>
							</div>
							<div class="invoice-plane-info" style="margin-top:20px">
								<div class="invoice-info__plan-header" style="background-color:#bdc9d7; color:#fff; padding:10px 15px;">
									<h3 style="margin:0; font-size:15px;">This Month Charges for <b>Voorschoolse</b> <span style="font-size:13px;">(maandag)</span> Plan</h3>
								</div>
								<div class="table-responsive">
									<table Style="border:1px solid #ccc; width:770px;" cellpadding="0" cellspacing="0">
										<tr>	
											<th style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">Date</th>
											<th style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">No Of Teachers Allotted</th>
											<th style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">Start Time</th>
											<th style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">End Time </th>
											<th style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">Overtime</th>
											<th style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">Absent</th>
											<th style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">Overtime Charges</th>
											<th style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">Plan Charges</th>
											<th style="font-size:12px; padding:10px; border-bottom:1px solid #ccc;">Total Charges</th>
										</tr>
										<?php 
									$att = [];
									$att = [];
									$final_charges = '';
									$total = '';
									$checkin_time = '';
									$checkout_time = '';
									$i = 1;
									foreach ($users['contracts'][$keyc]['attendances'] as $key => $attend) {
										$att[date('Y-m-d', strtotime($attend['date_time']))][$attend['status']] = $attend;
									$days = ['Sunday' => 'zondag', 'Monday' => 'maandag', 'Tuesday' => 'dinsdag', 'Wednesday' => 'woensdag', 'Thursday' => 'donderdag', 'Friday' => 'vrijdag', 'Saturday' => 'zaterdag'];
									$dateday =	date('l', strtotime($attend['date_time']));

									// if($attend['type'] == 'Auth' && $attend['status'] == '1'){
									// 	 $checkin_time = date('H:i:s', strtotime($attend['date_time']));
									// 	 $checkindate_time = date('Y-m-d H:i:s', strtotime($attend['date_time']));
									// }
									// if($attend['type'] == 'Auth' && $attend['status'] == '0'){
									// 	$checkout_time = date('H:i:s', strtotime($attend['date_time']));
									// }

									// $planestart_time = date('H:i:s', strtotime($plan['start_time']));
									// $planend_time = date('H:i:s', strtotime($plan['end_time']));
									// $workingcheckout_time = (strtotime($checkout_time));
									// $workingplanend_time = (strtotime($planend_time));
									// $workingcheckin_time = (strtotime($checkin_time));
									// $workingplanstart_time = (strtotime($planestart_time));

									// $a = new DateTime($checkout_time);
									// $b = new DateTime($planend_time);
									// $e =  new DateTime($checkin_time);
									// $f =  new DateTime($planestart_time);

									// if($workingcheckout_time > $workingplanend_time){
									// 	$Overtime  = $a->diff($b);
									// 	$Overtime = $Overtime->format("%H:%I:%S");
									// } elseif($workingcheckin_time < $workingplanstart_time){
									// 	$Overtime  = $f->diff($e);
									// 	$Overtime = $Overtime->format("%H:%I:%S");
									// }
									// else{
									// 	$Overtime ='00:00:00';
									// }
									

									// $c = new DateTime($planend_time);
									// $d = new DateTime($planestart_time);
									// $classtime = $c->diff($d);
									// $classtimehr = $classtime->format("%H");
									// $classtimemin = $classtime->format("%I");
									// $classtimehr = $classtimehr *60*60;
									// $classtimemin = $classtimemin *60;
									// $totaltimesec = $classtimehr + $classtimemin;
								

									// if($plan['plan_type'] == 'Year'){
									// 	$year = $plan['price'];
									// 	$month = round($year/12);
									// 	$daycharges = round($month/4);
									// 	$persec_charges = $daycharges/$totaltimesec;
									// 	if($workingcheckout_time > $workingplanend_time){
									// 		$str_time = $Overtime;

									// 		$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

									// 		sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

									// 		 $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
									// 		 $Overtime_charges = $persec_charges * $time_seconds;
									// 	}
									// 	 elseif($workingcheckin_time < $workingplanstart_time){
									// 	 	//echo $str_time = $Overtime;die('awe');
									// 	 	$str_time = $Overtime;
									// 		$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

									// 		sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

									// 		 $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
									// 		 $Overtime_charges = $persec_charges * $time_seconds;
									// 	 }
									// 	else{
									// 		$Overtime_charges = "00,00";
									// 	}
									// }
									// if($plan['plan_type'] == 'Month'){
									// 	$month = round($plan['price']);
									// 	$daycharges = round($month/4);
									// 	$persec_charges = $daycharges/$totaltimesec;
									// 	if($workingcheckout_time > $workingplanend_time){
									// 		$str_time = $Overtime;

									// 		$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

									// 		sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

									// 		 $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
									// 		 $Overtime_charges = $persec_charges * $time_seconds;
									// 	}
									// 	 elseif($workingcheckin_time < $workingplanstart_time){
									// 	 	//echo $str_time = $Overtime;die('awe');
									// 	 	$str_time = $Overtime;
									// 		$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

									// 		sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

									// 		 $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
									// 		 $Overtime_charges = $persec_charges * $time_seconds;
									// 	 }
									// 	else{
									// 		$Overtime_charges = "00,00";
									// 	}
									// }
									// if($plan['plan_type'] == 'Per-Day'){
									// 	$daycharges = round($plan['price']);
									// 	$persec_charges = $daycharges/$totaltimesec;
									// 	if($workingcheckout_time > $workingplanend_time){
									// 		$str_time = $Overtime;

									// 		$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

									// 		sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

									// 		 $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
									// 		 $Overtime_charges = $persec_charges * $time_seconds;
									// 	}
									// 	 elseif($workingcheckin_time < $workingplanstart_time){
									// 	 	//echo $str_time = $Overtime;die('awe');
									// 	 	$str_time = $Overtime;
									// 		$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

									// 		sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

									// 		 $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
									// 		 $Overtime_charges = $persec_charges * $time_seconds;
									// 	 }
									// 	else{
									// 		$Overtime_charges = "00,00";
									// 	}
									// }

									$finalAttendanceArray = [];
									$childAttandance =[];
									$childAttandanceDatesheet = [];
									$alldates = [];
									
									//$nextdate = date('Y-m-d', strtotime($next , strtotime($plan['start_date'])));
									foreach ($users['contracts'][$keyc]['attendances'] as $key => $attendtt) {
										if($attendtt['type'] == 'Auth' && $attendtt['status'] == '1'){
											$childAttandance[] = strtotime(date('Y-m-d', strtotime($attendtt['date_time'])));
										}

										$childAttandanceDatesheet[strtotime(date('Y-m-d', strtotime($attendtt['date_time'])))][] = $attendtt;
									}
									//pr($childAttandance);
									foreach ($users['contracts'] as $key => $contracts) {
										//pr($contracts);
										$plandate = date('Y-m-d',strtotime($contracts['start_date']));
										$planday = $contracts['service_day'];
										$day = array_search($planday,$days);
										$getplanday[] = array_search($planday,$days);

										$next = 'next'.' '.$day;
										$nextdate = date('Y-m-d', strtotime($next , strtotime($plandate)));
										$date1 = date('Y-m-d', strtotime($nextdate));
										$date = new DateTime($date1);
										$thisMonth = $date->format('m');
										
										while ($date->format('m') === $thisMonth) {
											$alldates[] = strtotime($date->format('Y-m-d'));
											$date->modify($next);
										}
										//pr(date('Y-m-d', strtotime($date->format('Y-m-d'))));
									}
									
									//pr($alldates);echo 'alldates';
									$result = array_diff($alldates,$childAttandance);
									$resultmerge = array_merge($result,$childAttandance);
									$finalAttendanceArray = array_unique($resultmerge);

									sort($finalAttendanceArray);
									$currentdate = strtotime($createddate);

									$thisMonthcharges = 0;
									//pr($result);die;
								}

								
								//pr('===================After loop================');

								foreach ($finalAttendanceArray as $key => $finalData) {
									$plandaydate = date('Y-m-d', $finalData);
									$dateday =	date('l', strtotime($plandaydate));

									if($plan['service_day'] == $days[$dateday]){
											if (isset($childAttandanceDatesheet[$finalData])) {
												$checkin_time = date('H:i:s', strtotime($childAttandanceDatesheet[$finalData][0]['date_time']));
										 		$checkout_time = date('H:i:s', strtotime($childAttandanceDatesheet[$finalData][1]['date_time']));
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
													$Overtime  = $a->diff($b);
													$Overtime = $Overtime->format("%H:%I:%S");
												} elseif($workingcheckin_time < $workingplanstart_time){
													$Overtime  = $f->diff($e);
													$Overtime = $Overtime->format("%H:%I:%S");
												}
												else{
													$Overtime ='00:00:00';
												}

												$c = new DateTime($planend_time);
												$d = new DateTime($planestart_time);
												$classtime = $c->diff($d);
												$classtimehr = $classtime->format("%H");
												$classtimemin = $classtime->format("%I");
												$classtimehr = $classtimehr *60*60;
												$classtimemin = $classtimemin *60;
												$totaltimesec = $classtimehr + $classtimemin;

												if($plan['plan_type'] == 'Year'){
													$year = $plan['price'];
													$month = round($year/12);
													$daycharges = round($month/4);
													$persec_charges = $daycharges/$totaltimesec;
													if($workingcheckout_time > $workingplanend_time){
														$str_time = $Overtime;

														$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

														sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

														 $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
														 $Overtime_charges = $persec_charges * $time_seconds;
													}
													 elseif($workingcheckin_time < $workingplanstart_time){
													 	//echo $str_time = $Overtime;die('awe');
													 	$str_time = $Overtime;
														$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

														sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

														 $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
														 $Overtime_charges = $persec_charges * $time_seconds;
													 }
													else{
														$Overtime_charges = "00,00";
													}
												}
												if($plan['plan_type'] == 'Month'){
													$month = round($plan['price']);
													$daycharges = round($month/4);
													$persec_charges = $daycharges/$totaltimesec;
													if($workingcheckout_time > $workingplanend_time){
														$str_time = $Overtime;

														$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

														sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

														 $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
														 $Overtime_charges = $persec_charges * $time_seconds;
													}
													 elseif($workingcheckin_time < $workingplanstart_time){
													 	//echo $str_time = $Overtime;die('awe');
													 	$str_time = $Overtime;
														$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

														sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

														 $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
														 $Overtime_charges = $persec_charges * $time_seconds;
													 }
													else{
														$Overtime_charges = "00,00";
													}
												}
												if($plan['plan_type'] == 'Per-Day'){
													$daycharges = round($plan['price']);
													$persec_charges = $daycharges/$totaltimesec;
													if($workingcheckout_time > $workingplanend_time){
														$str_time = $Overtime;

														$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

														sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

														 $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
														 $Overtime_charges = $persec_charges * $time_seconds;
													}
													 elseif($workingcheckin_time < $workingplanstart_time){
													 	//echo $str_time = $Overtime;die('awe');
													 	$str_time = $Overtime;
														$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

														sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

														 $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
														 $Overtime_charges = $persec_charges * $time_seconds;
													 }
													else{
														$Overtime_charges = "00,00";
													}
												}
													$fullcharges = $daycharges + $Overtime_charges;
										if (in_array($finalData, $childAttandance)) {
										
										 		
										?>
										<tr>
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?= date('d-m-Y', strtotime($childAttandanceDatesheet[$finalData][0]['date_time']));?></td>
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?=$plan['add_teacher']?></td>
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?= date('d-m-Y', strtotime($childAttandanceDatesheet[$finalData][0]['date_time']))?></td>
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?= date('H:i:s', strtotime($childAttandanceDatesheet[$finalData][1]['date_time'])) ?></td>
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?=$Overtime ?></td>
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?= "Present"?></td>
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">&euro; <?= round($Overtime_charges)?></td>
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">&euro; <?=$daycharges?></td>
											<td style="font-size:12px; padding:10px; border-bottom:1px solid #ccc;">&euro;<?= round($fullcharges) ?></td>
										</tr>
										<?php		
									} else {
										$fullcharges =$daycharges;
										?>
										<tr>
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?= date('d-m-Y', $finalData);?></td>
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?=$plan['add_teacher']?></td>
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?= date('H:i:s', strtotime($planestart_time))?></td>
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?= date('H:i:s', strtotime($planend_time)) ?></td>
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?= '00:00:00' ?> Hours</td>
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;"><?php if($finalData < $currentdate){echo "Absent";}else{ echo "N/A" ;}  ?></td>
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">&euro;<?='00:00'?></td>
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">&euro;<?=$daycharges?></td>
											<td style="font-size:12px; padding:10px; border-bottom:1px solid #ccc;">&euro; <?= round($fullcharges) ?></td>
										</tr>
										<?php 
									}
									 $total += $fullcharges;
							
								}
							}
							

						?>
										<tr>
											<td colspan="8" style="font-size:13px; padding:10px; border-right:1px solid #ccc; text-align:right"><b>Total</b>
											<td style="font-size:13px; padding:10px;"><b>&euro; <?= round($total) ?></b></td>
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
							<div style="width:370px; float:left; padding-right:15px">
								<div class="invoice-terms">
									<h3 style="font-size:15px">Important Notes</h3>
									<p style="font-size:13px"><span style="color:a94442">*</span> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer./p>
									<p style="font-size:13px"><span style="color:a94442">*</span> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer.</p>
									<p style="font-size:13px"><span style="color:a94442">*</span> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
								</div>
							</div>
							<div style="width:370px; float:left; padding-left:15px">
								<div style="background-color:#fff">
									<div class="invoice-info__plan-header" style="background-color:#73b4ff; color:#fff; padding:10px 15px;">
										<h3 style="margin:0; font-size:15px;">Your Invoice Summary</h3>
									</div>
									<table Style="border:1px solid #ccc; width:370px;" cellpadding="0" cellspacing="0">
										<tr>	
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">This Month Charges</td>
											<td style="font-size:12px; padding:10px; border-bottom:1px solid #ccc;"><b>&euro; <?= round($test_final) ?></b></td>
										</tr>
										<tr>	
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">Previous payment</td>
											<td style="font-size:12px; padding:10px; border-bottom:1px solid #ccc;"><b>&euro; 800,00</b></td>
										</tr>
										<tr>	
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">Adjustment</td>
											<td style="font-size:12px; padding:10px; border-bottom:1px solid #ccc;"><b>- &euro; 5,00</b></td>
										</tr>
										<tr>	
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc; color:a94442">Total Payable Amount</td>
											<td style="font-size:12px; padding:10px; border-bottom:1px solid #ccc; color:a94442"><b>&euro; 765,20</b></td>
										</tr>
										<tr>	
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc; border-bottom:1px solid #ccc;">Invoice Period</td>
											<td style="font-size:12px; padding:10px; border-bottom:1px solid #ccc;"><b>12 Aug 2018 - 12 Sept 2018</b></td>
										</tr>
										<tr>	
											<td style="font-size:12px; padding:10px; border-right:1px solid #ccc;">Pay by Date</td>
											<td style="font-size:12px; padding:10px;"><b>22 Sept 2018</b></td>
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

