<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Contract</h2>
		</div>
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<div class="row">
							<div class="col-sm-6">
								<h2>
									Contract
								</h2>
							</div>
						</div>
					</div>
					<div class="body">
						<div class="bso-aggrement">
							<h4>Contract voor buitenschoolse opvang tussen Stichting BSO Bolderburen en ouder(s) van</h4>
							<div class="user-info-row">
								<div class="row">
									<div class="col-sm-3">
										<label>Gegevens Kind:</label>
									</div>
									<?php //pr($bso);die; ?>

									<div class="col-sm-9">
										<p>Name:<?=$this->Decryption->mc_decrypt($user['firstname'],$user['encryptionkey']).$this->Decryption->mc_decrypt($user['lastname'],$user['encryptionkey']);?></p>
										<p>Geboortedatum: <?= date('d-m-Y', strtotime($this->Decryption->mc_decrypt($user['dob'],$user['encryptionkey']))) ;?></p>
										<p>Contractnummer: <?=$this->Decryption->mc_decrypt($parent['mobile_no'],$user['encryptionkey']);?></p>
									</div>
								</div>
							</div>
							<div class="user-info-row">
								<div class="row">
									<div class="col-sm-3">
										<label>Opvangsoort:</label>
									</div>
									<div class="col-sm-9">
										<p><?= RECEPTION_TYPE;  ?></p>
									</div>
								</div>
							</div>
							<div class="user-info-row">
								<div class="row">
									<div class="col-sm-3">
										<label>Opvangorganisatie:</label>
									</div>
									<div class="col-sm-9">
										<p><?=$this->Decryption->mc_decrypt($bso['firstname'],$bso['encryptionkey']).$this->Decryption->mc_decrypt($bso['lastname'],$bso['encryptionkey']);?></p>
										<label>Locatie:</label>
										<p><?=$this->Decryption->mc_decrypt($parent['address'],$parent['encryptionkey']);?><br>
											<?=$this->Decryption->mc_decrypt($parent['residence'],$parent['encryptionkey']);?><br>
											<?=$this->Decryption->mc_decrypt($parent['post_code'],$parent['encryptionkey']);?>
										</p>
									</div>
								</div>
							</div>
							<div class="user-info-row">
								<div class="row">
									<div class="col-sm-3">
										<label>Registratienummer:</label>
									</div>
									<div class="col-sm-9">
										<p>____</p>
									</div>
								</div>
							</div>
							<div class="user-info-row">
								<div class="row">
									<div class="col-sm-3">
										<label>Ingangsdatum:</label>
									</div>
									<?php 
									//pr($price);die;
									$start_date = date("d-m-Y");
									$time = strtotime($start_date);
									if($price == "price_weekly"){
										$amt =$amount;
										$month ='';
										$hours = round($difference / 3600* CONTRACT_WEEK);
										$amtpersec = $amt / $difference;
										$rate = $amtpersec * 3600;
										$final = date("d-m-Y", strtotime("+7 days", $time));
									}elseif($price == "price_monthly"){
										
										 $amt =$amount ;
										 $month ='Month';
										 $hours = round($difference / 3600* CONTRACT_MONTH);
										$amtpersec = $amt / $difference;
										$rate = $amtpersec * 3600;
										 $final = date("d-m-Y", strtotime("+1 month", $time)); 
									}elseif ($price == "price_yearly") {
										$amt =$amount;
										$month ='Year';
										$hours = round($difference / 3600 *CONTRACT_YEAR);
										$amtpersec = $amt / $difference;
										$rate = $amtpersec * 3600 ;
										$final = date("d-m-Y", strtotime("+1 year", $time));
									}
									
									?>
									<div class="col-sm-9">
										<p><?= $start_date ;?></p>
									</div>
								</div>
							</div>
							<div class="user-info-row">
								<div class="row">
									<div class="col-sm-3">
										<label>Einddatum:</label>
									</div>
									<div class="col-sm-9">
										<p><?= $final ;?></p>
									</div>
								</div>
							</div>
							<div class="user-info-row">
								<div class="row">
									<div class="col-sm-3">
										<label>Kosten  <?= $month ;?>  (2018):</label>
									</div>
									<div class="col-sm-9">
										<p>&euro; <?= $amt ;?></p>
									</div>
								</div>
							</div>
							<div class="user-info-row">
								<div class="row">
									<div class="col-sm-3">
										<label>Aantal uren  <?= $month ;?>:</label>
									</div>
									<div class="col-sm-9">
										<p><?= $hours ;?></p>
									</div>
								</div>
							</div>
							<div class="user-info-row">
								<div class="row">
									<div class="col-sm-3">
										<label>Gemiddeld uurtarief:</label>
									</div>
									<div class="col-sm-9">
										<p>&euro; <?= $rate ;?></p>
										<p class="text-small text-danger">*prijswijziging voorbehouden</p>
									</div>
								</div>
							</div>
							<div class="user-info-row">
								<div class="row">
									<div class="col-sm-3">
										<p class="m-t-70"><b>datum:- </b><?= $start_date; ?></p>
									</div>
									<div class="col-sm-9">
										<?php echo $this->Form->create('payment',['class'=>'','type'=>'file','url' => ['controller'=>'Users', 'action' => 'saveContract']]); ?>
										<div class="row">
											<div class="col-sm-6">
												<div class="ulpd-signature m-t-15">
													<label>handtekening ouder(s), verzorger(s):</label>
													<div class="upload-img">
														<div class="input-file-outer">
															<div class="input-file-in">
																<?php
																//$parentid = $user['parent_id'];
																
																 if(!empty($parent['clint_sign'])){
																echo $this->Html->link($this->Html->image(USER_PICTURE_FOLDER_URL_PATH.$parent['uuid'].'/'.$parent['clint_sign'], ['alt' => 'John','class' => 'img-responsive max-width-user-pic','id'=>'UplodImg']),'',['escapeTitle' => false,]);
															}else{ ?>
															
																<img id="UplodImg" src ='<?php echo $this->request->webroot.'img/no-img.jpg';?>' alt="Image Name" />
															<?php }
												?>
												</div>
													<input type="file" class="input-file" id="" onchange="readURL(this);">
													<?= $this->Form->control('clint_sign', ['label' => false,'onchange'=>'readURL(this);','class'=>'input-file','type' => 'file']);?>
													<button class="btn bg-blue input-file-btn"> Upload image</button>
													<?php // $this->Form->control('parentid', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $parentid]);?>
									<?php 
									foreach ($plan as $key => $value)
											{
												$planid[]= $value['id'];
										 	}
										$bsoid = $plan[0]['bso_id'];
									?>
												<?= $this->Form->control('parent_id', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $parent['id']]);?>
												<?= $this->Form->control('child_id', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=>$user['id']]);?>
												<?= $this->Form->control('bso_id', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $bsoid]);?>
												<?= $this->Form->control('plan_type', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $month]);?>
												<?= $this->Form->control('planid[]', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> json_encode($planid)]);?>
														</div>
													</div>
												</div>
											</div>
											
										</div>
									</div>
								</div>
							</div>
							<div class="text-right m-t-20">
								<?= $this->Form->button('Continue',['class' => 'btn btn-lg bg-teal']);
								?>
							</div>
							<?php echo $this->Form->end(); ?>	
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>