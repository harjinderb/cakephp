<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    	<?php 
    	//pr($plandata);die;
								foreach ($plandata as $key => $value) {}?>
      <h1><?=__("Plan's Of "). $this->Decryption->mc_decrypt($value['user']['firstname'],$value['user']['encryptionkey']).' '.$this->Decryption->mc_decrypt($value['user']['lastname'],$value['user']['encryptionkey'])?></h1>
      <?= $this->Flash->render() ?>
    </section>
    <?= $this->Flash->render() ?>

    <!-- Main content -->
    <section class="content">
		<div class="box box-primary">
            <div class="box-header bso-box-header">
				<h3 class="box-title"><?=__('My Services List')?></h3>
            </div>
            <div class="box-body">
				<div class="row">
							<?php 
								foreach ($plandata as $key => $value) {
										if($value['service_day']== __('monday')){
											$class="plan-head bg-teal";
											$button="btn bg-teal";
										}elseif ($value['service_day']== __('wednesday')) {
											$class="plan-head bg-light-blue";
											$button="btn bg-light-blue";
										}elseif ($value['service_day']== __('tuesday')) {
											$class="plan-head bg-b-blue";
											$button="btn bg-light-blue";
										}elseif ($value['service_day']== __('thursday')) {
											$class="plan-head bg-b-blue";
											$button="btn bg-light-blue";
										}elseif ($value['service_day']== __('friday')) {
											$class="plan-head bg-teal";
											$button="btn bg-teal";										
										}else{
											$class="plan-head bg-b-blue";
											
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
											<li><span><b><?=__('Child Name :')?></b></span> <span class="plan-val"><?= $this->Decryption->mc_decrypt($value['user']['firstname'],$value['user']['encryptionkey']). $this->Decryption->mc_decrypt($value['user']['lastname'],$value['user']['encryptionkey']);?></span></li>
											<li><span><b><?=__('Start Time :')?></b></span> <span class="plan-val"><?= date("H:i:s", strtotime($value['start_time']));?></span></li>
										<li><span><b><?=('End Time :')?></b></span> <span class="plan-val"><?= date("H:i:s", strtotime($value['end_time']));?></span></li>
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
												
												echo $this->Form->postLink(__('Shift Plan'), ['controller' => 'users', 'action' => 'buyServices','child_id' => $value['user']['uuid'],'service_id' => base64_encode($value['id']),'prefix' => false], ['class' => $button, 'escape' => false]);
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