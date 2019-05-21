<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?=__('Services')?></h1>
      <?= $this->Flash->render() ?>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="box box-primary">
            <div class="box-header bso-box-header">
				<h3 class="box-title"><?=__('My Services List')?></h3>
            </div>
            <div class="box-body">
					<div class="body">
						<div class="row">
							<?php 
								$Currentdate = date("Y-m-d");
								foreach ($plandata as $key => $value) {
									//pr($value);die;
									$booked= "";
									if (date('Y-m-d', strtotime($value['expirey_date'])) <= $Currentdate) {
	   										//$class="plan-head bg-deep-orange";
										 	//$button ="btn bg-deep-orange";
										 	$booked = "custom-expire";
									 	}
									 	if (date('Y-m-d', strtotime($value['expirey_date'])) >= $Currentdate && $value['status']=='2') {
	   										//$class="plan-head bg-deep-orange";
										 	//$button ="btn bg-deep-orange";
										 	$booked = "custom-expire";
									 	}
									 	 $booked;
									 	if($value['service_day']== __('monday')){
											$class="plan-head bg-teal";
											$button="btn bg-teal btn-round-md";
										}elseif ($value['service_day']== __('wednesday')) {
											$class="plan-head bg-light-blue";
											$button="btn bg-light-blue";
										}elseif ($value['service_day']== __('tuesday')) {
											$class="plan-head bg-b-blue";
											$button="btn bg-light-blue btn-round-md";
										}elseif ($value['service_day']== __('thursday')) {
											$class="plan-head bg-b-blue";
											$button="btn bg-light-blue btn-round-md";
										}elseif ($value['service_day']== __('friday')) {
											$class="plan-head bg-teal";
											$button="btn bg-teal btn-round-md";										
										}else{
											$class="plan-head bg-b-blue";
											
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
											if (date('Y-m-d', strtotime($value['expirey_date'])) <= $Currentdate && $value['status'] !=='0') {?>
												<h6  class="<?=$booked;?>">
	   										<?php echo (__('Expired')); ?>
	   										</h6>
										<?php	}
											 ?>

											<?php 
											if (date('Y-m-d', strtotime($value['expirey_date'])) >= $Currentdate && $value['status']=='2') {?>
												 <h6  class="<?=$booked;?>" style="color:red;"> 
	   										<?php echo (__('Stoped')); ?>
	   										</h6>
										<?php	}
											 ?>
											 <!-- <h6  class="custom-expire"><?php //echo (__('Expired')); ?></h6> -->

											
											
									</div>
									<?php 
									$id = $value['id'];
									$service_type = $value['service_type'];
									$parent_id = $value['parent_id'];
									
									?>
									<?php  if ($value['expirey_date'] >= $Currentdate && $value['status']=='2') {?>

									<div class="plan-info">
										<ul>
											<li><span><b><?=__('Child Name :')?></b></span> <span class="plan-val"><?= $this->Decryption->mc_decrypt($value['user']['firstname'],$value['user']['encryptionkey']). $this->Decryption->mc_decrypt($value['user']['lastname'],$value['user']['encryptionkey']);?></span></li>
											<li><span><b><?=__('Start Time :')?></b></span> <span class="plan-val"><?= date("H:i:s", strtotime($value['start_time']));?></span></li>
										<li><span><b><?=__('End Time :')?></b></span> <span class="plan-val"><?= date("H:i:s", strtotime($value['end_time']));?></span></li>
												<li><span><b><?=__('Age Group')?></b></span> <span class="plan-val"></span><br/>
												<span><b><?=__('Min Age:')?></b></span> <span class="plan-val"><?= $value['min_age'];?></span>
												<span><b><?=__('Max Age:')?></b></span> <span class="plan-val"><?= $value['max_age'];?></span>
											</li>
											<li>
												<span><b><?=__('No Of Teachers Allotted:')?></b></span> <span class="plan-val"><?= $value['add_teacher'];?></span>
											</li>
											<li class="plan-divider"><?=__('Price:')?></li>
											<li class="price-info"><?= '('.$GlobalSettings->currency .' '.$GlobalSettings->currency_code.')'?><?= $value['price'];?> <span class="price-type">/<?= $value['plan_type'];?></span></li> 
											<li><?php 
											// echo $this->Form->postLink(__('Resume Service'), ['controller' => 'users', 'action' => 'resumeService',$id,$parent_id,  'prefix' => 'parent'], ['class' => $button, 'confirm' => __('Are you sure you want to Resume Service ?'), 'escape' => false]);
											
											?>
												</li>
										</ul>
									</div>
								<?php	}

								else {?>
								<div class="plan-info">
										<ul>
											
											<li><span><b><?=__('Child Name :')?></b></span> <span class="plan-val"><?=$this->Decryption->mc_decrypt($value['user']['firstname'],$value['user']['encryptionkey']). $this->Decryption->mc_decrypt($value['user']['lastname'],$value['user']['encryptionkey']);?></span></li>
											<li><span><b><?=__('Start Time :')?></b></span> <span class="plan-val"><?= date("H:i:s", strtotime($value['bso_service']['start_time']));?></span></li>
										<li><span><b><?=__('End Time :')?></b></span> <span class="plan-val"><?= date("H:i:s", strtotime($value['bso_service']['end_time']));?></span></li>
										<li><span><b><?=__('Age Group')?></b></span> <span class="plan-val"></span><br/>
												<span><b><?=__('Min Age:')?></b></span> <span class="plan-val"><?= $value['min_age'];?></span>
												<span><b><?=__('Max Age:')?></b></span> <span class="plan-val"><?= $value['max_age'];?></span>
											</li>
											<li>
												<span><b><?=__('No Of Teachers Allotted:')?></b></span> <span class="plan-val"><?= $value['add_teacher'];?></span>
											</li>
											<li class="plan-divider"><?=__('Price:')?></li>
											<li class="price-info"><?= '('.$GlobalSettings->currency .' '.$GlobalSettings->currency_code.')'?><?php if($value['plan_type'] == 'Day'){ echo $value['bso_service']['price_weekly'];}
																	if($value['plan_type'] == 'Month'){ echo $value['bso_service']['price_monthly'];}
																	if($value['plan_type'] == 'Year'){ echo $value['bso_service']['price_yearly'];}
											?> <span class="price-type">/<?= $value['plan_type'];?></span></li>
											<?php echo $this->Form->create('service',['class'=>'','type'=>'GET','controller' => 'users', 'action' => 'buyPlan','child_id' => $value['user']['uuid'],'day' =>$value['service_day'],'prefix' => 'parent']); ?>

											<?= $this->Form->control('plan_type', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $value['plan_type']]);?>
											<?= $this->Form->control('services', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> 'PreviousServices']);?>
											<?= $this->Form->control('plan_id', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $value['bso_service']['uuid']]);?>
											<?= $this->Form->control('user_id', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $value['user']['id']]);?>
											<?php 
												echo $this->Form->control('day', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $value['service_day']]);
						  						echo $this->Form->control('child_id', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $value['user']['uuid']]);
											?>
											<li><?php 
											
											// if($value['status'] == '0'){
											// 	echo  $this->Form->button('Make Payment',['class' => $button]);
												
											// }
											
											if(date('Y-m-d', strtotime($value['expirey_date'])) <= $Currentdate && $value['status']!=='0'){
												echo  $this->Form->button('Make Payment',['class' => $button]);
											
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