<!-- Content Wrapper. Contains page content -->
  <div class="buy-content buy-content-full">
    <!-- Main content -->
    <section class="content">
		
		<?php 
			$day = $this->request->query('day');
			$cost = $this->request->query('cost');
			//pr($cost);die;
			echo $this->Form->create('',['class'=>'','type'=>'GET','url' => ['controller'=>'Users', 'action' => 'contract']]);

		?>
			<div class="buy-plan">
				<h3 class="buy-plan-title"><?=__('BSO agreement')?></h3>
				
				<div class="row">
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
									<h4 class="service-name"><?=__('Plan')?></h4>
									<p class="service-day"><?= $day;?> </p>
								 </div>
								 <div class="service-content-body">
									<div class="service-info">
										<div class="service-info-row">
											<p> <b><?=__('Start time:')?> </b> <span><?= date("H:i:s", strtotime($value[0]['start_time']))?> </span></p>
										</div>
										<div class="service-info-row">
											<p><b><?=__('End time:')?></b> <span><?= date("H:i:s", strtotime($value[0]['end_time']))?></span></p>
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
					<?php 
						$dobnew = date('d-m-Y', strtotime($this->Decryption->mc_decrypt($user['dob'],$user['encryptionkey']) ));
					?>
					<div class="col-md-8">
						<div class="card">
				
							<div class="body">
								<div class="bso-agrement-info">
									<div class="user-info-row">
										<div class="row">
											<div class="col-sm-4">
												<label><?=__('Name child')?></label>
											</div>
											<div class="col-sm-8">
												<p><?=$this->Decryption->mc_decrypt($user['firstname'],$user['encryptionkey']).' '.$this->Decryption->mc_decrypt($user['lastname'],$user['encryptionkey']);?></p>
											</div>
										</div>
									</div>
									<div class="user-info-row">
										<div class="row">
											<div class="col-sm-4">
												<label><?=__('Date of birth')?></label>
											</div>
											<div class="col-sm-8">
												<p><?= $dobnew;?></p>
											</div>
										</div>
									</div>
									<div class="user-info-row">
										<div class="row">
											<div class="col-sm-4">
												<label><?=__('Address')?></label>
											</div>
											<div class="col-sm-8">
												<p><?= $this->Decryption->mc_decrypt($user['address'],$user['encryptionkey']);?></p>
											</div>
										</div>
									</div>
									<div class="user-info-row">
										<div class="row">
											<div class="col-sm-4">
												<label><?=__('Postcode')?></label>
											</div>
											<div class="col-sm-8">
												<p><?= $this->Decryption->mc_decrypt($user['post_code'],$user['encryptionkey']);?></p>
											</div>
										</div>
									</div>
									<div class="user-info-row">
										<div class="row">
											<div class="col-sm-4">
												<label><?=__('residence')?></label>
											</div>
											<div class="col-sm-8">
												<p><?= $this->Decryption->mc_decrypt($user['residence'],$user['encryptionkey']);?></p>
											</div>
										</div>
									</div>
									<div class="user-info-row">
										<div class="row">
											<div class="col-sm-4">
												<label><?=__('telephone number')?></label>
											</div>
											<div class="col-sm-8">
												<p><?= $this->Decryption->mc_decrypt($parent['mobile_no'],$parent['encryptionkey']);?></p>
											</div>
										</div>
									</div>
									<div class="user-info-row">
										<div class="row">
											<div class="col-sm-4">
												<label><?=__('School')?></label>
											</div>
											<div class="col-sm-8">
												<p><?= $school['name'];?></p>
											</div>
										</div>
									</div>
									<div class="user-info-row">
										<div class="row">
											<div class="col-sm-4">
												<label><?=__('Name of parents / guardians')?></label>
											</div>
											<div class="col-sm-8">
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
											<div class="col-sm-4">
												<label><?=__('Registration date')?></label>
											</div>
											<div class="col-sm-8">
												<p><?= date('d-m-Y', strtotime($user['created']));?></p>
											</div>
										</div>
									</div>
									<div class="user-info-row">
										<div class="row">
											<div class="col-sm-4">
												<label><?=__('Date of entry:')?></label>
											</div>
											<div class="col-sm-8">
												<p><?= date('d-m-Y', strtotime($joiningdate));?></p>
											</div>
										</div>
									</div>
									<div class="user-info-row">
										<div class="row">
											<div class="col-sm-4">
												<label><?=__('Daycare on the following days')?></label>
											</div>
											<div class="col-sm-8">
												<p><b><?= $day;?></b></p>
											<?php 
												//foreach ($Recptions as $key => $value) {
													
											?>
												
											<?php //} ?>
												
											</div>
										</div>
									</div>
									<div class="user-info-row">
										<label><?=__('Hereby, the undersigned declares to adhere to the associated obligations')?></label>
										<div class="row">
											<div class="col-sm-6">
												<p class="mt_70"><b><?=__('date:-')?> </b><?=date('d-m-Y');?></p>
											</div>
											<div class="col-sm-6">
												<?php 
											$parentid = $parent['uuid'];
											
											 ?>
												<div class="ulpd-signature mt_15">
													<label><?=__("client's signature:-")?></label>
													<div class="input-file-outer profile-input-file">
														<div class="input-file-in">
															<?php
																		 $chlid_id = $user['id'];
																		 $price;
																		// pr($parent);die;
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
														<?php 
														$child_id = $this->request->query('child_id');
														$day = $this->request->query('day');
														$service_id = $this->request->query('service_id');
														echo $this->Form->control('joiningdate', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $joiningdate]);
														echo $this->Form->control('cost', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $cost]);
														echo $this->Form->control('day', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $day]);
														echo $this->Form->control('child_id', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $child_id]);
				   										echo $this->Form->control('service_id', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $service_id]);
														?>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!-- <div class="user-info-row">
										<div class="row">
											<div class="col-sm-12">
												<p class=""><b><?php //__('Place:-')?></b>Sint-Michielsgestel</p>
											</div>
											
										</div>
									</div> -->
													
								</div>
					</div>
				</div>
					</div>
				</div>
				
				
			</div>
			
		<div class="buy-plan-footer">
				<div class="row">
					<div class="col-xs-5">
						<!-- <a href="select-joiningdate.php" class="btn btn-default btn-round-lg"> Back</a> -->
						<a href="#" class="btn btn-default btn-round-lg back"> Back</a>
						<?php /*echo $this->Html->link(
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
		
    </section>
    <!-- /.content -->
  </div>

  <script>
	 function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#EmployeeImg')
                        .attr('src', e.target.result)
                        .width(150)
                        .height(150);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
</script>