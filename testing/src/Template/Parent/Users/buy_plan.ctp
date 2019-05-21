<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Select Plan</h2>
		</div>
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<div class="row">
							<div class="col-sm-6">
								<h2>
									Select Plan
								</h2>
							</div>
						</div>
					</div>
					<div class="body">
						<div class="select-plan">
							<div class="row">
								<div class="col-sm-8">
									<div class="form-common">
										
										<?php 
											//echo $plan_type;die;
										foreach ($plan as $key => $value1) {
											//pr($plan);die;
													$planid[]= $value1['id'];
													
												}
										echo $this->Form->create('plan',['type'=>'post', 'url' => ['controller'=>'Users', 'action' => 'bsoAgrement']]);
							?>
											<div class="form-group">
												<label>Select child *</label>
												<?php 
												if(empty($plan_type)){
													$option= array(''=>'Plese Select');
												}else{
													$option= array();
												}
												foreach ($user as $key => $value) {
													$option[$value['uuid']]= $this->Decryption->mc_decrypt($value['firstname'],$value['encryptionkey']).' '.' '.$this->Decryption->mc_decrypt($value['lastname'],$value['encryptionkey']);
												}
											$bsoid = $plan[0]['bso_id'];

											
											
											?>
																	
									<?= $this->Form->input('name', array('type'=>'select','label'=>false, 'class'=>'form-control show-tick serviceday', 'options'=>$option));

									 // $this->Form->select(
										//     'name',
										//     $option,
										//     [
										//         'multiple' => true,
										//         'class'=>'form-control show-tick serviceday',
										//         'label'=>false,
										        
										//     ]
										// );
										 ?>

											</div>
											

											<div class="form-group">
												<label>Select Contract For Your Child</label><br>
			<input name="price" id="radio_48" class="with-gap radio-col-blue-grey" value="price_weekly" type="radio" <?php  if($plan_type == 'Day'){echo "checked";}?>> 
												<label for="radio_48">Contract for Per-Day</label><br>
			<input name="price" id="radio_49" class="with-gap radio-col-blue-grey" value="price_monthly" type="radio" <?php  if($plan_type == 'Month'){echo "checked";}?>> 
												<label for="radio_49">Contract for Month</label><br>
			<input name="price" id="radio_50" class="with-gap radio-col-blue-grey" value="price_yearly" type="radio" <?php  if($plan_type == 'Year'){echo "checked";}?>> 
												<label for="radio_50">Contract for Year</label>
											</div>
											<div class="form-group">
											<!--  -->
											<?= $this->Form->control('bso_id', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $bsoid]);?>
											<?= $this->Form->control('planid[]', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> json_encode($planid)]);?>
											
											</div>
													
												
											<div class="m-t-20">
												<?= $this->Form->button('Continue',['class' => 'btn bg-deep-orange']);?>
												
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
	</div>
</section>
<script src="../plugins/autosize/autosize.js"></script>
<!-- Moment Plugin Js -->
<script src="../plugins/momentjs/moment.js"></script>