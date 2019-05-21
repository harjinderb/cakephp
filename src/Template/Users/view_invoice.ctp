  <div class="content-wrapper">
     <section class="content-header">
      <h1><?=__('Invoice')?></h1>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="box">
            <div class="box-header invoice-header">
				<div class="row">
					<div class="col-md-6">
						<?php 
							//pr($invoives);
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
                        	//pr($users);
                        	//echo $users['contracts'][0]['plan_type'];
                        	//die;
                        	$createddate = date("Y-m-d");
                        	$start_date = date("d-m-Y");
							$time = strtotime($start_date);
							$final = DUE_DATE;
                        ?>
						<h3 class="box-title"><?=$name?> </h3>
					</div>
					<div class="col-md-6 text-right">
						<!-- <a href="javascript:void(0)" class="btn btn-white-round">Send Invoice</a> -->
				<?php 
					echo $this->Html->link(
					'Send Invoice',
					['controller' => 'users', 'action' => 'sendInvoice',$users->uuid],
					['class' => 'btn btn-white-round','escape' => false]);
				?>

						
													
				<?php
					//echo $this->Form->button(__('Send Invoice'),['class' => 'btn btn-white-round','escape' => false]);
					//pr($school);die('school');
					//echo $this->Form->end();
						$test_final = ''; 
				?>
					</div>
				</div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
				<div class="invoice-info">
					<div class="row">
						<div class="col-md-6">
							<div class="invoice-info__border invoice-info__child">
								<p><span class="w-180-in-blk"><b><?=__('Child Name :')?> </b></span><?= $this->Decryption->mc_decrypt($users['firstname'],$users['encryptionkey']).$this->Decryption->mc_decrypt($users['lastname'],$users['encryptionkey'])?></p>
								<p><span class="w-180-in-blk"><b><?=__('DOB :')?> </b></span><?= date('d-m-Y', strtotime($this->Decryption->mc_decrypt($users['dob'],$users['encryptionkey'])))?></p>
								<p><span class="w-180-in-blk"><b><?=__('Parent Name :')?> </b></span><?= $this->Decryption->mc_decrypt($parent['firstname'],$parent['encryptionkey']).$this->Decryption->mc_decrypt($parent['lastname'],$parent['encryptionkey'])?></p>
								<p><span class="w-180-in-blk"><b><?=__('REGD ID :')?> </b></span>REG-ID <?=$users['registration_id']?></p>
								<p><span class="w-180-in-blk"><b><?=__('Registration Date :')?> </b></span><?=date('Y-m-d', strtotime($users['created']))?></p>
								<p><span class="w-180-in-blk"><b><?=__('School Name :')?> </b></span><?= $school->name?></p>
							</div>
						</div>
						<div class="col-md-6">
							<div class="invoice-info__border invoice-info__invoice">
								<p><span class="w-180-in-blk"><b><?=__('Invoice Number')?>:</b></span><?php echo $users['bso_id'].'-'.$users['id'].'-'.date('Ymd', strtotime($createddate)).'-'.'0';?></p>
								<p><span class="w-180-in-blk"><b><?=__('Invoice Date :')?> </b></span><?=$createddate?></p>
								<p><span class="w-180-in-blk"><b><?=__('Relief Time Before Class :')?> </b></span><?=$Setting['relieftimebeforeclass']?></p>
								<p><span class="w-180-in-blk"><b><?=__('Relief Time After Class :')?> </b></span><?=$Setting['relieftimeafterclass']?></p>
								<p><span class="w-180-in-blk"><b><?=__('Pay by Date :')?> </b> </span> <?=$final?></p>
								<p><span class="w-180-in-blk"><b><?=__('Calendet Type :')?> </b> </span> <?= $Setting['calendarfrmt']?></p>
							</div>
						</div>
					</div>
					<?php 
						
								//pr($users);die;	
						foreach ($users['contracts'] as $key => $plan) {
							$alldates = [];
							$invodata = array_values($invoives);
							//$invodata = $invoives;
							//pr($plan);die;
								if(!empty($invoives)){
										$plandate = date('Y-m-d',strtotime($invodata[$key]['invoicestart']));
										$planday = $plan['service_day'];
										$getplanday[] = $planday;
								}else{
										$plandate = date('Y-m-d',strtotime($plan['start_date']));
										$planday = $plan['service_day'];
										$getplanday[] = $planday;
									
								}
								//echo $plandate;
										$month = date('m', strtotime($plandate));
										$next = 'next'.' '.$planday;
										$nextdate = date('Y-m-d', strtotime($next , strtotime($plandate)));
										$nextdatemonth = date('m', strtotime($nextdate));
										$date1 = date('Y-m-d', strtotime($nextdate));
										$date = new DateTime($date1);
										
										if($Setting['invoicetype'] == 'weekly'){
											//$thisMonth = $date->format('m');
											if($date->format('m') === $month){
												$alldates[] = strtotime($date->format('Y-m-d'));
											}
										}
										if($Setting['invoicetype'] == 'monthly'){
											//pr($date);die;
											 // $thisMonth = $date->format('m');
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

											//array_push($alldates, $stmplandate);
										}
										//pr($alldates);
											 $keyc = $key;
									?>
						<div class="single-paln-info-warp">
						<div class="invoice-info__plan">
							<div class="invoice-info__plan-header">
								<h3><?=__('Your plan info')?></h3>
							</div>

							<div class="table-responsive">
								<table class="table table-bordered table-striped table-hover v-center cell-pd-15">
									<tr>
										<th><?=__('Plan Name')?></th>
										<th><?=__('No Of Teachers Allotted')?></th>
										<th><?=__('Start Time')?></th>
										<th><?=__('End Time')?></th>
										<th><?=__('Age Group')?></th>
										<th><?=__('Plan Price')?></th>
									</tr>
									
									<tr>
										<td><?= $plan['service_type']?><br><span class="small" style="color:#0d417d !important;"><?='('. $plan['service_day'].')'?></span></td>
										<td><?=$plan['add_teacher']?></td>
										<td><?= date('H:i:s', strtotime($plan['start_time']))?></td>
										<td><?= date('H:i:s', strtotime($plan['end_time']))?></td>
								<td><?=__('Min Age:')?> <?= $plan['min_age']?> <?=__('Max Age:')?> <?= $plan['max_age']?></td>
								<td><?= '('.$GlobalSettings->currency_code.')'?><?= $plan['price']?>/<?= str_replace('_', ' ', $plan['plan_type']);?></td>
									</tr>
								</table>
							</div>
						</div>
						<div class="invoice-info__plan mt_0">
							
							<div class="invoice-info__plan-header bg-grey">
								<h3><?=__('This Month Charges for')?> <b><?= $plan['service_type']?></b> <span class="small"><?='('. $plan['service_day'].')'?></span> Plan</h3>
							</div>
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-hover v-center cell-pd-15">
									<tr>
										<th><?=__('Date')?></th>
										<th><?=__('No Of Teachers Allotted')?></th>
										<th><?=__('Attendance Start Time')?></th>
										<th><?=__('Attendance End Time ')?></th>
										<th><?=__('Overtime ')?></th>
										<th><?=__('Absent')?></th>
										<th><?=__('Overtime Charges ')?></th>
										<th><?=__('Plan Charges')?></th>
										<th><?=__('Total Charges')?></th>
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
									//pr($users);die;
								if(!empty($users['contracts'][$keyc]['attendances'])){
									foreach ($users['contracts'][$keyc]['attendances'] as $key => $attendtt) {

										$dateday =	date('l', strtotime($attendtt['date_time']));
										
										//$alldates = [];
										if($attendtt['type'] == 'Auth'){
											$childAttandance[] = strtotime(date('Y-m-d', strtotime($attendtt['date_time'])));
										}

										$childAttandanceDatesheet[strtotime(date('Y-m-d', strtotime($attendtt['date_time'])))][] = $attendtt;
									}
									//pr($Setting['invoicetype']);die;
									if($Setting['invoicetype'] == 'weekly'){
										//$thisMonth = $date->format('w');
										 $dateweek = date('w',$alldates[0]);
										$childAttandanceed = $childAttandance[$key];
										  $week=date("w",$childAttandanceed);
										if($dateweek == $week){
											$childAttandance = $childAttandance;
											$result = array_diff($alldates,$childAttandance);
										}else{
											$childAttandance = [];
											$result = $alldates;
										}
									}
									//
									if($Setting['invoicetype'] == 'monthly'){
										  //$thisMonth = $date->format('m');
										  $datemonth = date('m',$alldates[0]);
										  $childAttandanceed = $childAttandance[$key];
										  $month = date('m',$childAttandanceed);
										//die;
										if($datemonth == $month){
											$childAttandance = $childAttandance;
											$result = array_diff($alldates,$childAttandance);
											// $alldates[] = strtotime($date->format('Y-m-d'));
											// $date->modify($next);
										}else{
											$childAttandance = [];
											$result = $alldates;
										}
									}
									//pr($childAttandance);
									//echo $childAttandance;die;
									//$result = array_diff($alldates,$childAttandance);
									//pr($result);die;
									$resultmerge = array_merge($result,$childAttandance);
									$finalAttendanceArray = array_unique($resultmerge);
								
									sort($finalAttendanceArray);
									$currentdate = strtotime($createddate);

									$thisMonthcharges = 0;

									//pr($finalAttendanceArray);
								

								
								//pr('===================After loop================');
									
									$fullcharges = '';
									$Overtime1 = '00:00:00';
									$Overtime2 = '00:00:00';
								foreach ($finalAttendanceArray as $key => $finalData) {
									 $plandaydate = date('Y-m-d', $finalData);
									//pr($finalData.'pp');
									$dateday =	date('l', strtotime($plandaydate));

									if($plan['service_day'] == strtolower($dateday)){
										 
										 //pr($childAttandanceDatesheet[$finalData][0]);
										if (isset($childAttandanceDatesheet[$finalData])) {
											$checkin_time = date('h:i:s', strtotime($childAttandanceDatesheet[$finalData][0]['date_time']));
											if(!empty($childAttandanceDatesheet[$finalData][0]['date_time_end'])){
										 	 $checkout_time = date('h:i:s', strtotime($childAttandanceDatesheet[$finalData][0]['date_time_end']));
											}
										} else {
											$checkin_time = '00:00:00';
										 	$checkout_time = '00:00:00';
										}

										$planestart_time = date('h:i:s', strtotime($plan['start_time']));
										$planend_time = date('h:i:s', strtotime($plan['end_time']));
										$workingcheckout_time = (strtotime($checkout_time));
										$workingplanend_time = (strtotime($planend_time));
										 $workingcheckin_time = (strtotime($checkin_time));
										 $workingplanstart_time = (strtotime($planestart_time));
										$a = new DateTime($checkout_time);
										$b = new DateTime($planend_time);
										$e =  new DateTime($checkin_time);
										$f =  new DateTime($planestart_time);

										// pr($e);
										// pr($f);
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
												 $Overtime_charges = $persec_charges * $time_seconds;
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
										//pr($childAttandanceDatesheet[$finalData][0]['date_time']);die;
											
											// $attenstart_timey = $dateattenstart->format('H:i:s');
										 // $attenstart_time = strtotime($attenstart_timey); 

											// $tp = new \DateTimeZone($GlobalSettings->timezone);
											// $dateattenend = new \DateTime($childAttandanceDatesheet[$finalData][0]['date_time_end']);
											// $dateattenend->setTimezone($tp);
											// $attenend_timey = $dateattenstart->format('H:i:s');
											// $attenend_time = strtotime($attenend_timey);

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
											
										 	//echo $checkout_time;	
											?>

												<tr>
													<td><?= date('d-m-Y', strtotime($childAttandanceDatesheet[$finalData][0]['date_time']));?></td>
													<td><?=$plan['add_teacher']?></td>
													<td><?= $attenstart_timey ?></td>
													<td><?php
														if(!empty($childAttandanceDatesheet[$finalData][0]['date_time_end'])){
													 	echo $attenend_timey; 
														}else{
															echo '00:00:00';
														}

													 ?></td>
													<td><?= $Overtime ?></td>
													<td><?= "Present"?></td>
													<td><?= '('.$GlobalSettings->currency_code.')'?><?= round($Overtime_charges)?></td>
													<td><?= '('.$GlobalSettings->currency_code.')'?><?=$daycharges?></td>
													<td><?= '('.$GlobalSettings->currency_code.')'?> <?= round($fullcharges) ?></td>
												</tr>
											<?php		
										} else {
											//echo $daycharges;
											$fullcharges = $daycharges;
											?>
											<tr>
												<td><?= date('d-m-Y', $finalData);?></td>
												<td><?=$plan['add_teacher']?></td>
												<td><?php echo '--';// date('H:i:s', strtotime($planestart_time)) ?></td>
												<td><?php echo '--';//date('H:i:s', strtotime($planend_time)) ?></td>
												<td><?= '00:00:00' ?></td>
												<td><?php if($finalData < $currentdate){echo __('Absent');}else{ echo __('N/A') ;}  ?></td>
												<td><?= '('.$GlobalSettings->currency_code.')'?><?='00:00'?></td>
												<td><?= '('.$GlobalSettings->currency_code.')'?><?=$daycharges?></td>
												<td><?= '('.$GlobalSettings->currency_code.')'?> <?= round($fullcharges) ?></td>
											</tr>											
											<?php 
										}
										 $total += $fullcharges;
										
									}

								}
							}	else {
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
											//pr($alldates);die;
										$alldates = array_unique($alldates);
											$fullcharges = $daycharges;
											foreach ($alldates as $key => $finalData) {
												 $plandaydate = date('Y-m-d', $finalData);
												 $dateday =	date('l', strtotime($plandaydate));
											if($plan['service_day'] == strtolower($dateday)){
											?>
											<tr>
												<td><?= date('d-m-Y', $finalData);?></td>
												<td><?=$plan['add_teacher']?></td>
												<td><?php echo '--';// date('H:i:s', strtotime($planestart_time)) ?></td>
												<td><?php echo '--';// date('H:i:s', strtotime($planend_time)) ?></td>
												<td><?= '00:00:00' ?></td>
												<td><?php if($finalData < $currentdate){echo __('Absent');}else{ echo ('N/A') ;}  ?></td>
												<td><?= '('.$GlobalSettings->currency_code.')'?><?='00:00'?></td>
												<td><?= '('.$GlobalSettings->currency_code.')'?><?=$daycharges?></td>
												<td><?= '('.$GlobalSettings->currency_code.')'?> <?= round($fullcharges) ?></td>
											</tr>											
											<?php 
											$total += $fullcharges;		
											}
										}

										if (!empty($invoices)) {
											//$previousinvoice = $invoices['invoiceend'];
										} else {
											//$previousinvoice = $users['contracts'][0]['start_date'];
										}	
									}
																	
							?>
										<tr>
										<td colspan="8"><b>Total</b>
										<td><b><?= '('.$GlobalSettings->currency_code.')'?> <?= round($total) ?></b></td>
									</tr>
								</table>
							</div>
						
						</div>
					</div>
					<?php 
						  $test_final += $total;
					
						//}
					}
					///pr($final_charges);
					//die();
					?>
				


					<div class="single-paln-info-warp">
						<div class="row">
							<div class="col-md-6 pull-right">

								<div class="invoice-info__plan">
									<div class="invoice-info__plan-header">
										<h3><?=__('Your Invoice Summary')?></h3>
									</div>
									<div class="table-responsive">
										<table class="table table-bordered table-striped table-hover v-center cell-pd-15">

											<tr>
												<td><?=__('This Month Charges')?></td>
												<td><b><?= '('.$GlobalSettings->currency_code.')'?> <?= round($test_final) ?></b></td>
											</tr>
											<tr>
												<td><?=__('Previous payment')?></td>
												<td><b><?= '('.$GlobalSettings->currency_code.')'?> 00,00</b></td>
											</tr>
											<tr>
												<td><?=__('Adjustment')?></td>
												<td><b> <?= '('.$GlobalSettings->currency_code.')'?> 0,00</b></td>
											</tr>
											<tr>
												<td><b class="text-danger"><?=__('Total Payable Amount')?></b></td>
												<td><b class="text-danger"><?= '('.$GlobalSettings->currency_code.')'?> <?= round($test_final) ?></b></td>
											</tr>
											<tr>
												<td><?=__('Invoice Period')?></b></td>
												<td><b><?php //date('d-m-Y', strtotime($previousinvoice)).' '.'-'.' '.date('d-m-Y', strtotime( $start_date));?></td>
											</tr>
											<tr>
												<td><?=__('Pay by Date')?></b></td>
												<td><b><?=$final?></b></td>
											</tr>

										</table>

									</div>
								</div>
							</div>
							<div class="col-md-6">

									<div class="invoice-terms">
										<h3>Important Notes</h3>
										<p><span class="text-danger">*</span> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries</p>
										<p><span class="text-danger">*</span> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries</p>
										<p><span class="text-danger">*</span> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries</p>

									</div>

							</div>
						</div>




					</div>

					<div class="footer-invoice">
						<div class="invoice-sign-wrap">
							<img src="dist/img/sign.jpg" alt="Signature">
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