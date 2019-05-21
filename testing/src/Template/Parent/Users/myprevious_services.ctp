<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>My Previous Services</h2>
		</div>
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>
							My Service List
						</h2>
					</div>
					<div class="body">
						<div class="row">
							<?php 
								$Currentdate = date("Y-m-d");
								foreach ($plandata as $key => $value) {
									//pr($value);die;
									$booked= "";
									if ($value['expirey_date'] <= $Currentdate) {
	   										//$class="plan-head bg-deep-orange";
										 	//$button="btn bg-deep-orange";
										 	$booked= "booked-plan";
									 	}
									 	if ($value['expirey_date'] >= $Currentdate && $value['status']=='2') {
	   										//$class="plan-head bg-deep-orange";
										 	//$button="btn bg-deep-orange";
										 	$booked= "booked-plan";
									 	}
									 	if($value['service_type']== 'voorschoolse'){
											$class="plan-head bg-teal";
											$button="btn bg-teal";
											
										}elseif ($value['service_type']== 'tussenschoolse') {
											$class="plan-head bg-light-blue";
											$button="btn bg-light-blue";
											
										}else{
											$class="plan-head bg-cyan";
											$button="btn bg-cyan";
											
										}
							?>
							<div class="col-md-3 col-sm-4">
								<div class="single-plan">
									<div class="<?= $class; ?>">
										<h1 class="plan-name">
											<?= $value['service_type'];?>
											
										</h1>
										<h3 class="plan-day">
											
											<?= $value['service_day'];?>
										</h3>
										
										<?php 
											if ($value['expirey_date'] <= $Currentdate && $value['status'] !=='0') {?>
												<h6  class="<?=$booked;?>">
	   										<?php echo (__('Expired')); ?>
	   										</h6>
										<?php	}
											 ?>

											<?php 
											if ($value['expirey_date'] >= $Currentdate && $value['status']=='2') {?>
												<h6  class="<?=$booked;?>" style="color:red;">
	   										<?php echo (__('Stoped')); ?>
	   										</h6>
										<?php	}
											 ?>
											
									</div>
									<?php 
									$id = $value['id'];
									$service_type = $value['service_type'];
									$parent_id = $value['parent_id'];
									
									?>
									<?php  if ($value['expirey_date'] >= $Currentdate && $value['status']=='2') {?>
									<div class="plan-info">
										<ul>
											<li><span><b>Child Name :</b></span> <span class="plan-val"><?= $this->Decryption->mc_decrypt($value['user']['firstname'],$value['user']['encryptionkey']). $this->Decryption->mc_decrypt($value['user']['lastname'],$value['user']['encryptionkey']);?></span></li>
											<li><span><b>Start Time :</b></span> <span class="plan-val"><?= date("H:i:s", strtotime($value['start_time']));?></span></li>
										<li><span><b>End Time :</b></span> <span class="plan-val"><?= date("H:i:s", strtotime($value['end_time']));?></span></li>
																				<li><span><b>Age Group</b></span> <span class="plan-val"></span><br/>
												<span><b>Min Age:</b></span> <span class="plan-val"><?= $value['min_age'];?></span>
												<span><b>Max Age:</b></span> <span class="plan-val"><?= $value['max_age'];?></span>
											</li>
											<li>
												<span><b>No Of Teachers Allotted:</b></span> <span class="plan-val"><?= $value['add_teacher'];?></span>
											</li>
											<li class="plan-divider">Price:</li>
											<li class="price-info">€<?= $value['price'];?> <span class="price-type">/<?= $value['plan_type'];?></span></li> 
											<li><?php 
											echo $this->Form->postLink(__('Resume Service'), ['controller' => 'users', 'action' => 'resumeService',$id,$parent_id,  'prefix' => 'parent'], ['class' => $button, 'confirm' => __('Are you sure you want to Resume Service ?'), 'escape' => false]);
											
											?>
												</li>
										</ul>
									</div>
								<?php	}

								else {?>
								<div class="plan-info">
										<ul>
											<li><span><b>Child Name :</b></span> <span class="plan-val"><?= $value['user']['firstname']. $value['user']['lastname'];?></span></li>
											<li><span><b>Start Time :</b></span> <span class="plan-val"><?= date("H:i:s", strtotime($value['bso_service']['start_time']));?></span></li>
										<li><span><b>End Time :</b></span> <span class="plan-val"><?= date("H:i:s", strtotime($value['bso_service']['end_time']));?></span></li>
										<li><span><b>Age Group</b></span> <span class="plan-val"></span><br/>
												<span><b>Min Age:</b></span> <span class="plan-val"><?= $value['min_age'];?></span>
												<span><b>Max Age:</b></span> <span class="plan-val"><?= $value['max_age'];?></span>
											</li>
											<li>
												<span><b>No Of Teachers Allotted:</b></span> <span class="plan-val"><?= $value['add_teacher'];?></span>
											</li>
											<li class="plan-divider">Price:</li>
											<li class="price-info">€<?php if($value['plan_type'] == 'Day'){ echo $value['bso_service']['price_weekly'];}
																	if($value['plan_type'] == 'Month'){ echo $value['bso_service']['price_monthly'];}
																	if($value['plan_type'] == 'Year'){ echo $value['bso_service']['price_yearly'];}
											?> <span class="price-type">/<?= $value['plan_type'];?></span></li>
											<?php echo $this->Form->create('service',['class'=>'','type'=>'file','controller' => 'users', 'action' => 'buyPlan', 'prefix' => 'parent']); ?> 
											<?= $this->Form->control('plan_type', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $value['plan_type']]);?>
											<?= $this->Form->control('services', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> 'PreviousServices']);?>
											<?= $this->Form->control('plan_id', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $value['bso_service']['uuid']]);?>
											<?= $this->Form->control('user_id', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $value['user']['id']]);?>
											<li><?php 
											
											if($value['status'] == '0'){
												echo  $this->Form->button('Make Payment',['class' => $button]);
												
											}
											
											if($value['expirey_date'] <= $Currentdate && $value['status']!=='0'){
												echo  $this->Form->button('Buy Service',['class' => $button]);
											
											}

												?>
												</li>
											<?php echo $this->Form->end(); ?>	
										</ul>

									</div>
									<?php	}?>

								</div>
							</div>
							<?php }?>
						
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>