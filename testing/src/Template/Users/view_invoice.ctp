  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Invoice</h1>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="box">
            <div class="box-header invoice-header">
				<div class="row">
					<div class="col-md-6">
						<?php 
							$encryptionkey=$this->request->getSession()->read('Auth.User.encryptionkey');
                       	 	$dataimage=$this->request->getSession()->read('Auth.User.image');
                        	$name = $this->Decryption->mc_decrypt($this->request->getSession()->read('Auth.User.firstname'),$encryptionkey).' '.$this->Decryption->mc_decrypt($this->request->getSession()->read('Auth.User.lastname'),$encryptionkey);
                        	//pr($users);
                        	//echo $users['contracts'][0]['plan_type'];
                        	//die;
                        	$createddate = date("Y-m-d");
                        	$start_date = date("d-m-Y");
							$time = strtotime($start_date);
							$final = date("d-m-Y", strtotime("+10 days", $time));
                        ?>
						<h3 class="box-title"><?=$name?> </h3>
					</div>
					<div class="col-md-6 text-right">
						<!-- <a href="javascript:void(0)" class="btn btn-white-round">Send Invoice</a> -->
						<?php echo $this->Html->link(
									                'Send Invoice',
									                ['controller' => 'users', 'action' => 'sendInvoice',$users->uuid],
									                ['class' => 'btn btn-white-round','escape' => false]); 
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
								<p><span class="w-180-in-blk"><b>Child Name : </b></span><?= $this->Decryption->mc_decrypt($users['firstname'],$users['encryptionkey']).$this->Decryption->mc_decrypt($users['lastname'],$users['encryptionkey'])?></p>
								<p><span class="w-180-in-blk"><b>Parent Name : </b></span><?= $this->Decryption->mc_decrypt($parent['firstname'],$parent['encryptionkey']).$this->Decryption->mc_decrypt($parent['lastname'],$parent['encryptionkey'])?></p>
								<p><span class="w-180-in-blk"><b>REGD ID : </b></span>REG-ID <?=$users['registration_id']?></p>
								<p><span class="w-180-in-blk"><b>Registration Date : </b></span><?=date('Y-m-d', strtotime($users['created']))?></p>
								<p><span class="w-180-in-blk"><b>School Name : </b></span><?= $school->name?></p>
							</div>
						</div>
						<div class="col-md-6">
							<div class="invoice-info__border invoice-info__invoice">
								<p><span class="w-180-in-blk"><b>Invoice Number:</b></span><?php echo $users['bso_id'].'-'.$users['id'].'-'.date('Ymd', strtotime($createddate)).'-'.'0';?></p>
								<p><span class="w-180-in-blk"><b>Invoice Date : </b></span><?=$createddate?></p>
								<p><span class="w-180-in-blk"><b>Previous Invoice : </b></span> &euro;00,00</p>
								<p><span class="w-180-in-blk"><b>Pay by Date : </b> </span> <?=$final?></p>
								<p><span class="w-180-in-blk"><b>Payable Amount : </b> </span> &euro;00,00</p>
							</div>
						</div>
					</div>
					<?php 
									//die;
						// pr($users['contracts']);die;
						foreach ($users['contracts'] as $key => $plan) {
								//	pr($plan);
							$days = ['Sunday' => 'zondag', 'Monday' => 'maandag', 'Tuesday' => 'dinsdag', 'Wednesday' => 'woensdag', 'Thursday' => 'donderdag', 'Friday' => 'vrijdag', 'Saturday' => 'zaterdag'];
										$plandate = date('Y-m-d',strtotime($plan['start_date']));
										$planday = $plan['service_day'];
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
										//($alldates);
											 $keyc = $key;
									?>
					<div class="single-paln-info-warp">
						<div class="invoice-info__plan">
							<div class="invoice-info__plan-header">
								<h3>Your plan info</h3>
							</div>

							<div class="table-responsive">
								<table class="table table-bordered table-striped table-hover v-center cell-pd-15">
									<tr>
										<th>Plan Name</th>
										<th>No Of Teachers Allotted</th>
										<th>Start Time</th>
										<th>End Time </th>
										<th>Age Group</th>
										<th>Plan Price</th>
									</tr>
									
									<tr>
										<td><?= $plan['service_type']?><br><span class="small" style="color:#0d417d !important;"><?='('. $plan['service_day'].')'?></span></td>
										<td><?=$plan['add_teacher']?></td>
										<td><?= date('H:i:s', strtotime($plan['start_time']))?></td>
										<td><?= date('H:i:s', strtotime($plan['end_time']))?></td>
										<td>Min Age: <?= $plan['min_age']?> Max Age: <?= $plan['max_age']?></td>
										<td>&euro; <?= $plan['price']?>/<?= $plan['plan_type']?></td>
									</tr>
								</table>
							</div>
						</div>
						<div class="invoice-info__plan mt_0">
							
							<div class="invoice-info__plan-header bg-grey">
								<h3>This Month Charges for <b><?= $plan['service_type']?></b> <span class="small"><?='('. $plan['service_day'].')'?></span> Plan</h3>
							</div>
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-hover v-center cell-pd-15">
									<tr>
										<th>Date</th>
										<th>No Of Teachers Allotted</th>
										<th>Start Time</th>
										<th>End Time </th>
										<th>Overtime </th>
										<th>Absent</th>
										<th>Overtime Charges </th>
										<th>Plan Charges</th>
										<th>Total Charges</th>
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
										if($attendtt['type'] == 'Auth' && $attendtt['status'] == '1'){
											$childAttandance[] = strtotime(date('Y-m-d', strtotime($attendtt['date_time'])));
										}

										$childAttandanceDatesheet[strtotime(date('Y-m-d', strtotime($attendtt['date_time'])))][] = $attendtt;
									}
										
									$result = array_diff($alldates,$childAttandance);
									$resultmerge = array_merge($result,$childAttandance);
									$finalAttendanceArray = array_unique($resultmerge);
								
									sort($finalAttendanceArray);
									$currentdate = strtotime($createddate);

									$thisMonthcharges = 0;
									//pr($result);die;
								

								
								//pr('===================After loop================');
							
									$fullcharges = '';
								foreach ($finalAttendanceArray as $key => $finalData) {
									$plandaydate = date('Y-m-d', $finalData);
									$dateday =	date('l', strtotime($plandaydate));

									if($plan['service_day'] == $days[$dateday]){
										 
										// pr($childAttandanceDatesheet[$finalData]);
										if (isset($childAttandanceDatesheet[$finalData])) {
											//if($attendtt['type'] == 'Auth' && $attendtt['status'] == '1'){
												$checkin_time = date('H:i:s', strtotime($childAttandanceDatesheet[$finalData][0]['date_time']));
											//}
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
													<td><?= date('d-m-Y', strtotime($childAttandanceDatesheet[$finalData][0]['date_time']));?></td>
													<td><?=$plan['add_teacher']?></td>
													<td><?= date('H:i:s', strtotime($childAttandanceDatesheet[$finalData][0]['date_time'])); ?></td>
													<td><?= date('H:i:s', strtotime($childAttandanceDatesheet[$finalData][1]['date_time'])); ?></td>
													<td><?= $Overtime ?></td>
													<td><?= "Present"?></td>
													<td>&euro;<?= round($Overtime_charges)?></td>
													<td>&euro;<?=$daycharges?></td>
													<td>&euro; <?= round($fullcharges) ?></td>
												</tr>
											<?php		
										} else {
											//echo $daycharges;
											$fullcharges = $daycharges;
											?>
											<tr>
												<td><?= date('d-m-Y', $finalData);?></td>
												<td><?=$plan['add_teacher']?></td>
												<td><?= date('H:i:s', strtotime($planestart_time)) ?></td>
												<td><?= date('H:i:s', strtotime($planend_time)) ?></td>
												<td><?= '00:00:00' ?></td>
												<td><?php if($finalData < $currentdate){echo "Absent";}else{ echo "N/A" ;}  ?></td>
												<td>&euro;<?='00:00'?></td>
												<td>&euro;<?=$daycharges?></td>
												<td>&euro; <?= round($fullcharges) ?></td>
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

								if($plan['plan_type'] == 'Year'){
											 $year = $plan['price'];
											$month = round($year/12);
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
										if($plan['plan_type'] == 'Month'){
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
										if($plan['plan_type'] == 'Per-Day'){
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
											$fullcharges = $daycharges;
											foreach ($alldates as $key => $finalData) {
											?>
											<tr>
												<td><?= date('d-m-Y', $finalData);?></td>
												<td><?=$plan['add_teacher']?></td>
												<td><?= date('H:i:s', strtotime($planestart_time)) ?></td>
												<td><?= date('H:i:s', strtotime($planend_time)) ?></td>
												<td><?= '00:00:00' ?></td>
												<td><?php if($finalData < $currentdate){echo "Absent";}else{ echo "N/A" ;}  ?></td>
												<td>&euro;<?='00:00'?></td>
												<td>&euro;<?=$daycharges?></td>
												<td>&euro; <?= round($fullcharges) ?></td>
											</tr>											
											<?php 
											}
										}
										$total += $fullcharges;									
							?>
										<tr>
										<td colspan="8"><b>Total</b>
										<td><b>&euro; <?= round($total) ?></b></td>
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
										<h3>Your Invoice Summary</h3>
									</div>
									<div class="table-responsive">
										<table class="table table-bordered table-striped table-hover v-center cell-pd-15">

											<tr>
												<td>This Month Charges</td>
												<td><b>&euro; <?= round($test_final) ?></b></td>
											</tr>
											<tr>
												<td>Previous payment</td>
												<td><b>&euro; 00,00</b></td>
											</tr>
											<tr>
												<td>Adjustment</td>
												<td><b>- &euro; 0,00</b></td>
											</tr>
											<tr>
												<td><b class="text-danger">Total Payable Amount</b></td>
												<td><b class="text-danger">&euro; <?= round($test_final) ?></b></td>
											</tr>
											<tr>
												<td>Invoice Period</b></td>
												<td><b>12 Aug 2018 - 12 Sept 2018</td>
											</tr>
											<tr>
												<td>Pay by Date</b></td>
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