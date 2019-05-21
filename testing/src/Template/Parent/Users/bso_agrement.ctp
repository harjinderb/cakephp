<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Overeenkomst BSO</h2>
		</div>
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<div class="row">
							<div class="col-sm-6">
								<h2>
									Overeenkomst BSO
								</h2>
							</div>
						</div>
					</div>
					<div class="body">
						<div class="bso-aggrement">
							<div class="row">
								<?php
								$amt='';
								$month='';
								if($price == "price_weekly"){
									$month ='PerDay';
								}elseif($price == "price_monthly"){
									$month ='Monthly';
								}elseif ($price == "price_yearly") {
									$month ='Yearly';
								}
								//pr($plan);die;
								
									# code...
								
								?>
								
								<div class="col-ms-4 col-sm-4">
									<label>Afname buitenschoolse opvang:</label>
									<?php foreach ($plan as $key => $value) {

										//pr($value);die;
										$planid[]= $value['id'];
											if($value['service_type']== 'voorschoolse'){
										$class="plan-head bg-teal";
										//$button="btn bg-teal";
										}elseif ($value['service_type']== 'tussenschoolse') {
											$class="plan-head bg-light-blue";
											//$button="btn bg-light-blue";
										}else{
											$class="plan-head bg-cyan";
											//$button="btn bg-cyan";
										}
										$data = explode(',', $value['add_teacher']);
									?>
									<div class="single-plan">
										<div class="<?= $class ;?>">
											<h1 class="plan-name">
												<?= $value['service_type'];?>
											</h1>
											<h3 class="plan-day">
												<?= $value['service_day'];?>
											</h3>
										</div>
										<?php 
										 	$stime = explode(",", $value->start_time);
										 	$etime = explode(",", $value->end_time);
										
										?> 
										<div class="plan-info">
											<ul>
												<li><span><b>Start Time :</b></span> <span class="plan-val"><?= $stime[1];?></span></li>
											<li><span><b>End Time :</b></span> <span class="plan-val"><?= $etime[1];?></span></li>
											<li><span><b>Age Group</b></span> <span class="plan-val"></span><br/>
												<span><b>Min Age:</b></span> <span class="plan-val"><?= $value['min_age'];?></span>
												<span><b>Max Age:</b></span> <span class="plan-val"><?= $value['max_age'];?></span>
											</li>
											<li>
												<span><b>No Of Teachers Allotted:</b></span> <span class="plan-val"><?= count($data);?></span>
											</li>
												<li class="plan-divider">Price:</li>
												<li class="price-info">€ <?= $value[$price];?> <span class="price-type">/<?= $month;?></span></li>
											</ul>
										</div>
									</div>
									<?php }
									$bsoid = $plan[0]['bso_id'];
									?>
								</div>
								
								<?php 
								//pr($school);die;
								$dobnew = date('d-m-Y', strtotime($this->Decryption->mc_decrypt($user['dob'],$user['encryptionkey']) ));

								?>
								<div class="col-md-8 col-sm-4">
									<div class="user-info-row">
										<div class="row">
											<div class="col-sm-3">
												<label>Naam kind</label>
											</div>
											<div class="col-sm-9">
												<p><?=$this->Decryption->mc_decrypt($user['firstname'],$user['encryptionkey']).$this->Decryption->mc_decrypt($user['lastname'],$user['encryptionkey']);?></p>
											</div>
										</div>
									</div>
									<div class="user-info-row">
										<div class="row">
											<div class="col-sm-3">
												<label>Geboortedatum</label>
											</div>
											<div class="col-sm-9">
												<p><?= $dobnew;?></p>
											</div>
										</div>
									</div>
									<div class="user-info-row">
										<div class="row">
											<div class="col-sm-3">
												<label>Address</label>
											</div>
											<div class="col-sm-9">
												<p><?= $this->Decryption->mc_decrypt($user['address'],$user['encryptionkey']);?></p>
											</div>
										</div>
									</div>
									<div class="user-info-row">
										<div class="row">
											<div class="col-sm-3">
												<label>Postcode</label>
											</div>
											<div class="col-sm-9">
												<p><?= $this->Decryption->mc_decrypt($user['post_code'],$user['encryptionkey']);?></p>
											</div>
										</div>
									</div>
									<div class="user-info-row">
										<div class="row">
											<div class="col-sm-3">
												<label>Woonplaats</label>
											</div>
											<div class="col-sm-9">
												<p><?= $this->Decryption->mc_decrypt($user['residence'],$user['encryptionkey']);?></p>
											</div>
										</div>
									</div>
									<div class="user-info-row">
										<div class="row">
											<div class="col-sm-3">
												<label>Telefoonnummer</label>
											</div>
											<div class="col-sm-9">
												<p><?= $this->Decryption->mc_decrypt($user['residence'],$user['encryptionkey']);?></p>
											</div>
										</div>
									</div>
									<div class="user-info-row">
										<div class="row">
											<div class="col-sm-3">
												<label>School</label>
											</div>
											<div class="col-sm-9">
												<p><?= $school['name'];?></p>
											</div>
										</div>
									</div>
									<div class="user-info-row">
										<div class="row">
											<div class="col-sm-3">
												<label>Naam ouders/verzorgers</label>
											</div>

											<div class="col-sm-9">
												<p>1. <?= $this->Decryption->mc_decrypt($parent['firstname'],$parent['encryptionkey']).$this->Decryption->mc_decrypt($parent['lastname'],$parent['encryptionkey']); ?></p>
												<?php $i= 2;
												foreach ($guardian as $key => $value) {
												 ?>
												<p><?= $i.'.'.''. $this->Decryption->mc_decrypt($value['firstname'],$value['encryptionkey']).$this->Decryption->mc_decrypt($value['lastname'],$value['encryptionkey']); ?></p>
												<?php $i++ ;} ?>
											</div>
										</div>
									</div>
									<div class="user-info-row">
										<div class="row">
											<div class="col-sm-3">
												<label>Datum inschrijving</label>
											</div>
											<div class="col-sm-9">
												<p><?=date('d-m-Y');?></p>
											</div>
										</div>
									</div>
									<div class="user-info-row">
										<div class="row">
											<div class="col-sm-3">
												<label>Datum ingang:</label>
											</div>
											<div class="col-sm-9">
												<p><?= date('d-m-Y', strtotime($user['created']));?></p>
											</div>
										</div>
									</div>
									<div class="user-info-row">
										<div class="row">
											<div class="col-sm-3">
												<label>Opvang op de volgende dagen</label>
											</div>
											<div class="col-sm-9">
												<p><b>maandag:- </b>20-08-2018</p>
												<p><b>dinsdag:- </b>21-08-2018</p>
											</div>
										</div>
									</div>
									<div class="user-info-row">
										<label>hierbij verklaart ondergetekende zich te houden aan de hieraan gekoppelde verplichtingen</label>
										<div class="row">
											<div class="col-sm-6">
												<p class="m-t-70"><b>datum:- </b><?=date('d-m-Y');?></p>
											</div>
											<div class="col-sm-6">
									<?php 
									$parentid = $parent['uuid'];
									echo $this->Form->create($user,['class'=>'','type'=>'file','url' => ['controller'=>'Users', 'action' => 'contract',$parentid]]); ?>
												<div class="ulpd-signature m-t-15">
													<label>handtekening opdrachtgever:</label>
													<div class="upload-img">
														<div class="input-file-outer">
															<div class="input-file-in">
																<?php
																 $chlid_id = $user['id'];
																 $price;
																 // $planid = $plan['id'];
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
												<?= $this->Form->control('parentid', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $parentid]);?>
												<?= $this->Form->control('chlid_id', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $chlid_id]);?>
												<?= $this->Form->control('price', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $price]);?>
												<?= $this->Form->control('bso_id', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $bsoid]);?>
												<?= $this->Form->control('planid[]', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> json_encode($planid)]);?>
														</div>
													</div>
												</div>
												
											</div>
										</div>
									</div>
									<div class="user-info-row">
										<div class="row">
											<div class="col-sm-6">
												<p class=""><b>plaats:- </b>Sint-Michielsgestel</p>
											</div>
											
										</div>
									</div>
									<div class="text-right m-t-20">
										<?= $this->Form->button('Continue',['class' => 'btn bg-deep-orange']);
											?>
										
									</div>
									<?php echo $this->Form->end(); ?>	
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
	function readURL(input) {
	          if (input.files && input.files[0]) {
	              var reader = new FileReader();
	
	              reader.onload = function (e) {
	                  $('#UplodImg')
	                      .attr('src', e.target.result)
	                      .width(150)
	                      .height(150);
	              };
	
	              reader.readAsDataURL(input.files[0]);
	          }
	      }
</script>
