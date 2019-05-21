<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Services</h2>
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
								//pr($plandata);die;
								foreach ($plandata as $key => $value) {
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
									</div>
									<?php 
									$id = $value['id'];
									$service_type = $value['service_type'];
									$parent_id = $value['parent_id'];
									
									?>
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
											
											// if($value['status'] == '0'){
											// 	echo $this->Form->postLink(__('Make Payment'), ['controller' => 'users', 'action' => 'saveContract', 'prefix' => 'parent'], ['class' => $button, 'escape' => false]);
											// }else{

												/*echo $this->Form->postLink(__('Stop Service'), ['controller' => 'users', 'action' => 'stopService',$id,$parent_id, 'prefix' => 'parent'], ['class' => $button, 'confirm' => __('Are you sure you want to Stop Service ?'), 'escape' => false]);*/
											// }

												?>
												</li>
										</ul>
									</div>
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