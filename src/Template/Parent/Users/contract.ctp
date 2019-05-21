<div class="buy-content buy-content-full">
	<section class="content">
		<div class="buy-plan">
			<h3 class="buy-plan-title"><?=__('Contract')?></h3>
			<div class="row clearfix">
				<div class="col-md-4">
					<div class="plan-info-agrement mb_20">
						<h4 class="mb_20"><?=__('Decrease after-school care:')?></h4>
						<?php
							//pr($parent);die;
							
							$planinfo =$this->request->getSession()->read('plan.plandata');
							//pr($planinfo);die;
								foreach ($BsoServices as $key => $value) {
								//pr($value);
								$costvalue = explode('-', $value[0]['cost']);
								//pr($costvalue);
								//}
								//die;	str_replace("‐",",",$string);
							
							?>
						<div class="service-content">
							<div class="service-header text-center bg-b-blue">
								<h4 class="service-name"><?=__('Plan')?>  </h4>
								<p class="service-day"><?= $day;?> </p>
							</div>
							<div class="service-content-body">
								<div class="service-info">
									<div class="service-info-row">
										<p> <b><?=__('Start time:')?> </b> <span><?= date("H:i:s", strtotime($value[0]['start_time']))?> </span></p>
									</div>
									<div class="service-info-row">
										<p><b> <?=__('End time:')?></b> <span><?= date("H:i:s", strtotime($value[0]['end_time']))?></span></p>
									</div>
									<div class="service-info-row">
										<p class="text-center"><b><?=__('Price')?></b></p>
										<p> <b><?= str_replace("_"," ",$costvalue[1]);?>: </b> <span><?= '('.$GlobalSettings->currency .' '.$GlobalSettings->currency_code.')'?> <?= $costvalue[0]?> </span></p>
									</div>
								</div>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
				<!-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> -->
				<div class="col-md-8">
					<div class="card">
						<div class="body">
							<div class="bso-aggrement">
								<h4><?=__('Contract for after school care between Stichting BSO Bolderburen and parent (s) of')?></h4>
								<div class="user-info-row">
									<div class="row">
										<div class="col-sm-3">
											<label><?=__('Child data:')?></label>
										</div>
										<?php //pr($bso);die; ?>
										<div class="col-sm-9">
											<p><?=__('Name:')?><?=$this->Decryption->mc_decrypt($user['firstname'],$user['encryptionkey']).$this->Decryption->mc_decrypt($user['lastname'],$user['encryptionkey']);?></p>
											<p><?=__('Date of birth:')?> <?= date('d-m-Y', strtotime($this->Decryption->mc_decrypt($user['dob'],$user['encryptionkey']))) ;?></p>
											<p><?=__('Contractnummer:')?><?=$this->Decryption->mc_decrypt($parent['mobile_no'],$user['encryptionkey']);?></p>
										</div>
									</div>
								</div>
								<div class="user-info-row">
									<div class="row">
										<div class="col-sm-3">
											<label><?=__('Childcare type:')?></label>
										</div>
										<div class="col-sm-9">
											<p><?= RECEPTION_TYPE;  ?></p>
										</div>
									</div>
								</div>
								<div class="user-info-row">
									<div class="row">
										<div class="col-sm-3">
											<label><?=__('Reception organization:')?></label>
										</div>
										<div class="col-sm-9">
											<p><?=$this->Decryption->mc_decrypt($bso['firstname'],$bso['encryptionkey']).$this->Decryption->mc_decrypt($bso['lastname'],$bso['encryptionkey']);?></p>
											<label>Locatie:</label>
											<p><?=$this->Decryption->mc_decrypt($bso['address'],$bso['encryptionkey']);?><br>
												<?=$this->Decryption->mc_decrypt($bso['residence'],$bso['encryptionkey']);?><br>
												<?=$this->Decryption->mc_decrypt($bso['post_code'],$bso['encryptionkey']);?>
											</p>
										</div>
									</div>
								</div>
								<div class="user-info-row">
									<div class="row">
										<div class="col-sm-3">
											<label><?=__('Registration Number:')?></label>
										</div>
										<div class="col-sm-9">
											<p>____</p>
										</div>
									</div>
								</div>
								<div class="user-info-row">
									<div class="row">
										<div class="col-sm-3">
											<label><?=__('starting date:')?></label>
										</div>
										<?php 
											//pr($price);die;
											$start_date = date('d-m-Y', strtotime($joiningdate));
											$time = strtotime($start_date);
											// if($price == "price_weekly"){
											// 	$amt =$amount;
											// 	$month ='';
											// 	$hours = round($difference / 3600* CONTRACT_WEEK);
											// 	$amtpersec = $amt / $difference;
											// 	$rate = $amtpersec * 3600;
											// 	$final = date("d-m-Y", strtotime("+7 days", $time));
											// }elseif($price == "price_monthly"){
												
											// 	 $amt =$amount ;
											// 	 $month ='Month';
											// 	 $hours = round($difference / 3600* CONTRACT_MONTH);
											// 	$amtpersec = $amt / $difference;
											// 	$rate = $amtpersec * 3600;
											// 	 $final = date("d-m-Y", strtotime("+1 month", $time)); 
											// }elseif ($price == "price_yearly") {
											// 	$amt =$amount;
											// 	$month ='Year';
											// 	$hours = round($difference / 3600 *CONTRACT_YEAR);
											// 	$amtpersec = $amt / $difference;
											// 	$rate = $amtpersec * 3600 ;
											// 	$final = date("d-m-Y", strtotime("+1 year", $time));
											// }
											
											?>
										<div class="col-sm-9">
											<p><?= $start_date ;?></p>
										</div>
									</div>
								</div>
								<!-- <div class="user-info-row">
									<div class="row">
										<div class="col-sm-3">
											<label>Einddatum:</label>
										</div>
										<div class="col-sm-9">
											<p><?php //$final ;?></p>
										</div>
									</div>
									</div>
									<div class="user-info-row">
									<div class="row">
										<div class="col-sm-3">
											<label>Kosten  <?= $month ;?>  (2018):</label>
										</div>
										<div class="col-sm-9">
											<p>&euro; <?php// $amt ;?></p>
										</div>
									</div>
									</div>
									<div class="user-info-row">
									<div class="row">
										<div class="col-sm-3">
											<label>Aantal uren  <?= $month ;?>:</label>
										</div>
										<div class="col-sm-9">
											<p><?php// $hours ;?></p>
										</div>
									</div>
									</div>
									<div class="user-info-row">
									<div class="row">
										<div class="col-sm-3">
											<label>Gemiddeld uurtarief:</label>
										</div>
										<div class="col-sm-9">
											<p>&euro; <?php// $rate ;?></p>
											<p class="text-small text-danger">*prijswijziging voorbehouden</p>
										</div>
									</div>
									</div> -->
								<div class="user-info-row">
									<div class="row">
										<div class="col-sm-3">
											<p class="m-t-70"><b><?=__('date:-')?> </b><?= $start_date; ?></p>
										</div>
										<div class="col-sm-9">
											<?php 
											$child_id = $this->request->query('child_id');
											$day = $this->request->query('day');
											$service_id = $this->request->query('service_id');
											echo $this->Form->create('payment',['class'=>'','type'=>'file','url' => ['controller'=>'Users', 'action' => 'saveContract','day'=> $day,'child_id'=> $child_id,'service_id'=> $service_id]]); ?>
											<div class="row">
												<div class="col-sm-6">
													<div class="ulpd-signature m-t-15">
														<label><?=__('signature parent (s), caregiver (s)')?>:</label>
														<div class="upload-img">
															<div class="input-file-outer profile-input-file">
																<div class="input-file-in">
															<?php
																		 $chlid_id = $user['id'];
																		 $price;
																		 // $planid = $plan['id'];
																		 if(!empty($parent['clint_sign'])){
																		echo $this->Html->link($this->Html->image(USER_PICTURE_FOLDER_URL_PATH.$parent['uuid'].'/'.$parent['clint_sign'], ['alt' => 'John','class' => 'img-responsive max-width-user-pic','id'=>'UplodImg']),'',['escapeTitle' => false,]);
																	}else{ ?>
																	
																		<img id="UplodImg" src ='<?php echo $this->request->webroot.'img/no-img.jpg';?>' alt="Image Name"/>
														<?php }
														?>
														</div>
														<input type="file" class="input-file" id="" onchange="readURL(this);">
														<?= $this->Form->control('clint_sign', ['label' => false,'onchange'=>'readURL(this);','class'=>'input-file clintsign','type' => 'file']);?>
														<button class="btn btn-change-profile input-file-btn clintsign">  <?=__('Upload Signature...')?></button>
																<?php // $this->Form->control('parentid', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $parentid]);?>
																<?php
																echo $this->Form->control('joiningdate', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $joiningdate]);
																	echo $this->Form->control('day', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $day]);
																	echo $this->Form->control('child_id', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $child_id]);
				   													echo $this->Form->control('service_id', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $service_id]);
																?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="buy-plan-footer">
									<div class="row">
										<div class="col-xs-5">
											<a href="#" class="btn btn-default btn-round-lg back"><?=__('Back')?></a>
											<!-- <a href="select-joiningdate.php" class="btn btn-default btn-round-lg"> Back</a> -->
											<?php 
											/*echo $this->Html->link(
												__('Back'),
												['controller' => 'users', 'action' => 'selectChild','day'=> $day],
												['class' => 'btn btn-default btn-round-lg','escape' => false]);*/ 
												
												?>
										</div>
										<div class="col-xs-7 text-right">
											<!-- <a href="contract.php" class="btn btn-theme btn-round-lg"> Continue</a> -->
											<?php 
												if(empty($parent['clint_sign'])){
													$desabled = 'disabled';
												}else{
													$desabled = '';
												}
												
													echo $this->Form->button(__('Continue'),['class' => 'btn btn-theme btn-round-lg aggrement','id'=>'planselect','disabled'=> $desabled,'escape' => false]);
													echo $this->Form->end(); 
												     ?>
										</div>
									</div>
								</div>
								<?php echo $this->Form->end(); ?>	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>