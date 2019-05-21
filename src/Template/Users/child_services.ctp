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
				<h3 class="box-title"><?=__('Services List')?></h3>
            </div>
            <div class="box-body">
				<div class="row">
							<?php 
								if(empty($plandata)){
							?>
								<div class="col-md-3 col-sm-4">
								<!-- <div class="single-plan"> -->
								<h4 class="box-title"><?= __('No Services Taken By Parent')?></h4>	
							<!-- </div> -->
						</div>
								<?php 
									}
									$Currentdate = date("Y-m-d 00:00");
									foreach ($plandata as $key => $value) {
									
									$booked= "";
									// if ($value['expirey_date'] <= $Currentdate) {
	   					// 					//$class="plan-head bg-deep-orange";
									// 	 	//$button="btn bg-deep-orange";
									// 	 	$booked= "booked-plan";
									//  	}
									 	if ($value['expirey_date'] >= $Currentdate && $value['status']=='2') {
	   										//$class="plan-head bg-deep-orange";
										 	//$button="btn bg-deep-orange";
										 	$booked= "booked-plan";
									 	}
									if($value['service_day']== 'monday'){
											$class="plan-head bg-teal";
											$button="btn bg-teal";
										}elseif ($value['service_day']== 'wednesday') {
											$class="plan-head bg-light-blue";
											$button="btn bg-light-blue";
										}elseif ($value['service_day']== 'tuesday') {
											$class="plan-head bg-b-blue";
											$button="btn bg-light-blue";
										}elseif ($value['service_day']== 'thursday') {
											$class="plan-head bg-b-blue";
											$button="btn bg-light-blue";
										}elseif ($value['service_day']== 'friday') {
											$class="plan-head bg-teal";
											$button="btn bg-teal";										
										}else{
											$class="plan-head bg-b-blue";
											$button="btn bg-light-blue";		
											
										}
										//$data = explode(',', $value['add_teacher']);
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
										//echo $value['expirey_date'];die;
											//if ($value['expirey_date'] <= $Currentdate && $value['status'] !=='0') {?>
												<h6  class="<?php //$booked;?>">
	   										<?php //echo (__('Expired')); ?>
	   										
										<?php	//}
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
											<li><span><b><?=__('Child Name')?>:</b></span> <span class="plan-val"><?= $this->Decryption->mc_decrypt($value['user']['firstname'],$value['user']['encryptionkey']). $this->Decryption->mc_decrypt($value['user']['lastname'],$value['user']['encryptionkey']);?></span></li>
											<li><span><b><?=__('Start Time')?> :</b></span> <span class="plan-val"><?= date("H:i:s", strtotime($value['start_time']));?></span></li>
										<li><span><b><?=__('End Time')?> :</b></span> <span class="plan-val"><?= date("H:i:s", strtotime($value['end_time']));?></span></li>
										<li><span><b><?=__('Age Group')?></b></span> <span class="plan-val"></span><br/>
										<span><b><?=__('Min Age')?>:</b></span> <span class="plan-val"><?= $value['min_age'];?></span>
										<span><b><?=__('Max Age')?>:</b></span> <span class="plan-val"><?= $value['max_age'];?></span>
											</li>
											<li>
												<span><b><?=__('No Of Teachers Allotted')?>:</b></span> <span class="plan-val"><?= $value['add_teacher'];?></span>
											</li>
											<li class="plan-divider"><?=__('Price:')?></li>
											<li class="price-info"><?= $GlobalSettings->currency .' '.$GlobalSettings->currency_code.' '.$value['price'];?> <span class="price-type">/<?= $value['plan_type'];?></span></li> 
											<li><?php 
											echo $this->Form->postLink(__('Resume Service'), ['controller' => 'users', 'action' => 'resumeService',$id,$parent_id,$uuid,  'prefix' => false], ['class' => $button, 'confirm' => __('Are you sure you want to Resume Service ?'), 'escape' => false]);
											
											?>
												</li>
										</ul>
									</div>
									
								<?php	}

								else {?>

									<div class="plan-info">
										<ul>
											<li><span><b><?=__('Child Name')?>:</b></span> <span class="plan-val"><?= $this->Decryption->mc_decrypt($value['user']['firstname'],$value['user']['encryptionkey']). $this->Decryption->mc_decrypt($value['user']['lastname'],$value['user']['encryptionkey']);?></span></li>
											<li><span><b><?=__('Start Time')?>:</b></span> <span class="plan-val"><?= date("H:i:s", strtotime($value['start_time']));?></span></li>
										<li><span><b><?=__('End Time')?> :</b></span> <span class="plan-val"><?= date("H:i:s", strtotime($value['end_time']));?></span></li>
										<li><span><b><?=__('Age Group')?></b></span> <span class="plan-val"></span><br/>
												<span><b><?=__('Min Age')?>:</b></span> <span class="plan-val"><?= $value['min_age'];?></span>
												<span><b><?=__('Max Age')?>:</b></span> <span class="plan-val"><?= $value['max_age'];?></span>
											</li>
											<li>
												<span><b><?=__('No Of Teachers Allotted')?>:</b></span> <span class="plan-val"><?= $value['add_teacher'];?></span>
											</li>
											<li class="plan-divider"><?=__('Price')?>:</li>
											<li class="price-info"><?= $GlobalSettings->currency .' '.$GlobalSettings->currency_code.' '.$value['price'];?> <span class="price-type">/<?= $value['plan_type'];?></span></li> 
											<li><?php 
											
											 // if($value['status'] == '0'){
											 // 	echo $this->Form->postLink(__('Make Payment'), ['controller' => 'users', 'action' => 'saveContract', 'prefix' => 'parent'], ['class' => $button, 'escape' => false]);
											 // }else{

											echo $this->Form->postLink(__('Stop Service'), ['controller' => 'users', 'action' => 'stopService',$id,$parent_id,$uuid, 'prefix' => false], ['class' => $button, 'confirm' => __('Are you sure you want to Stop Service ?'), 'escape' => false]);
											//}
												// if($value['expirey_date'] <= $Currentdate && $value['status']!=='0'){
												// echo  $this->Form->button(__('Buy Service'),['class' => $button]);
											
											}

												?>
												</li>
										</ul>
									</div>
									
								</div>
							</div>
						<?php	}?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>