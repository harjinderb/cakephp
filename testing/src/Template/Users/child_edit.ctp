<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Edit Child</h2>
		</div>
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<div class="row">
							<div class="col-sm-6">
								<h2>
									Child Details
								</h2>
							</div>
							<div class="col-sm-6 text-right">
								<?php echo $this->Html->link(
								'Go to parent list',
								['controller' => 'users', 'action' => 'parents'],
								['escape' => false,'class'=>'btn bg-blue-grey']);
								$relation = array('Please select','Son','Daughter','Other, Please specify below');
								
								// $parent_id = $parents['id'];
								// $post_code = $parents['post_code'];
								// $address = $parents['address'];
								// $Woonplaats=$parents['residence'];
								
								?>
							</div>
						</div>
					</div>
					<div class="body">
						<div class="form-common profile-upload-cs">
							<?php echo $this->Form->create($user,['class'=>'myform','type'=>'file']); 
								$relationset = $user['relation'];
								$getresponse = $this->Relation->relationfunction($relationset);
							?>
								<div class="row">
									<div class="col-sm-4 col-md-3">
										<div class="form-group upload-img">
											<span class="text-info text-small p-b-10">Image size should be 1:1</span>											
											<div class="input-file-outer">
												<div class="input-file-in">
													<?php if(!empty($user['image'])){
																echo $this->Html->link($this->Html->image(USER_PICTURE_FOLDER_URL_PATH.$user['uuid'].'/'.$user['image'], ['alt' => 'John','class' => 'img-responsive max-width-user-pic','id'=>'UplodImg']),'',['escapeTitle' => false,]);
															}else{ ?>
															
																<img id="UplodImg" src ='<?php echo $this->request->webroot.'img/no-img.jpg';?>' alt="Image Name" />
															<?php }
												?>
												</div>
												<span class="text-info text-small p-t-10">Only PNG and JPEG format is allowed.</span>
												<input type="file" class="input-file" id="" onchange="readURL(this);">
												<?= $this->Form->control('image', ['label' => false,'onchange'=>'readURL(this);','class'=>'input-file','type' => 'file','accept'=>'image/png, image/jpeg']);?>
												<button class="btn bg-blue input-file-btn"> Upload image</button>
											</div>
										</div>
									</div>
									
									<div class="col-sm-8 col-md-8">
										<div class="form-group">
											<label>First Name  *</label>
											<?= $this->Form->control('firstname',   ['label' => false, 'class' => 'form-control', 'placeholder' => 'First Name','value'=> $this->Decryption->mc_decrypt($user['firstname'],$user['encryptionkey'])]); ?>
										</div>
										<div class="form-group">
											<label>Last Name  *</label>
											<?= $this->Form->control('lastname',   ['label' => false, 'class' => 'form-control', 'placeholder' => 'Last Name','value'=> $this->Decryption->mc_decrypt($user['lastname'],$user['encryptionkey'])]); ?>
										</div>
										
										<div class="form-group">
											<label>School *</label>
											<?= $this->Form->control('school',   ['label' => false, 'class' => 'form-control', 'placeholder' => 'School Name']); ?>
											
										</div>
										<div class="form-group">
											<label>Gender</label>
											<?php if($user['gender'] =='1'){?>
											<input name="gender" id="radio_48" class="with-gap radio-col-blue-grey" type="radio" value="1" type="hidden" checked="checked">
											<label for="radio_48">Male</label>
											<input name="gender" id="radio_49" class="with-gap radio-col-blue-grey" type="radio" value="2" type="hidden">
											<label for="radio_49">Female</label>
											<?php }else{?>
											<input name="gender" id="radio_48" class="with-gap radio-col-blue-grey" type="radio" value="1" type="hidden">
											<label for="radio_48">Male</label>
											<input name="gender" id="radio_49" class="with-gap radio-col-blue-grey" type="radio" value="2" type="hidden" checked="checked">
											<label for="radio_49">Female</label>

										<?php } ?>

											<?php /*echo	$this->Form->input('gender', [
											'type' => 'radio',
											'options' => [
											['value' => 1, 'text' => __('Male'),'id'=>'radio_48','class'=>'with-gap radio-col-blue-grey'],
											['value' => 2, 'text' => __('Female'),'id'=>'radio_49','class'=>'with-gap radio-col-blue-grey'],
											],
											'templates' => [
											'nestingLabel' => '{{hidden}}<label{{attrs}}>{{text}}</label>{{input}}',
											'radioWrapper' => '<div class="radio">{{label}}</div>'
											]
											]); */
											?>
										</div>
										<div class="form-group">
											<label>Date of Birth *</label>
											<?= $this->Form->control('dob',['type'=>'text','label' => false, 'class' => 'datepicker form-control', 'placeholder' => 'DOB','value'=>date('d-m-Y', strtotime($this->Decryption->mc_decrypt($user['dob'],$user['encryptionkey'])))]);?>
										</div>
										<div class="form-group row">
											<label>Relation with child *</label>
											<?=$this->Form->select('relation1',$relation,['multiple' => false,'value' => [],'label' => false, 'class' => 'relation form-control show-tick','id'=>'relation','value'=>$getresponse]);?>
											
										
										<div class="form-group showrelation <?php echo $getresponse =='3' ? 'Show': 'hide' ?>">
											<label>Please specify relation with child *</label>
											<?= $this->Form->control('relation',   ['label' => false, 'class' => 'form-control', 'placeholder' => 'Relation with child','value'=> ($getresponse =='3' ? $relationset: '' )]); ?>
										</div>
										<!-- <div class="form-group">
											<label>Address *</label><br>
											<input name="group5" id="radio_50" class="with-gap radio-col-blue-grey" type="radio"> 
											<label for="radio_50">Same as parent</label>
											<input name="group5" id="radio_51" class="with-gap radio-col-blue-grey" type="radio"> 
											<label for="radio_51">Differnt address</label>
										</div> -->
										<div class="form-group Differnt">
											<label>Post Code *</label>
											<?= $this->Form->control('post_code', ['label' => false, 'class' => 'form-control', 'placeholder' => 'xxxx-xx-x','id'=>'autocomplete','data-mask'=>'0000-00-00','value'=> $this->Decryption->mc_decrypt($user['post_code'],$user['encryptionkey'])]);?>
											<div class="ui-widget" style="margin-top:2em; font-family:Arial">
												<!-- 				Result:
												-->			<!-- 	<div id="log" style="height: 200px; width: 300px; overflow: auto;" class="ui-widget-content"></div> -->
										</div>
										</div>
										<div class="form-group Differnt">
											<label>Address *</label>
											<?= $this->Form->control('address',   ['type'=>'textarea','label' => false, 'class' => 'form-control', 'placeholder' => 'Address','id'=>'address','value'=> $this->Decryption->mc_decrypt($user['address'],$user['encryptionkey'])]);?>
										</div>
										<div class="form-group Differnt">
											<label>Woonplaats  *</label>
											<?= $this->Form->control('residence', ['type'=>'textarea','label' => false, 'class' => 'form-control', 'placeholder' => 'Residence','id'=>'city','value'=> $this->Decryption->mc_decrypt($user['residence'],$user['encryptionkey'])]);?>
										</div>
										
										<div class="form-group">
											<!--  -->
											<?= $this->Form->control('parent_id', ['label' => false, 'class' => 'form-control','type'=>'hidden']);?>
										</div>
										
										<div class="form-group text-right">
										<?= $this->Form->button('Edit Child',['class' => 'btn btn-lg bg-teal']);
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