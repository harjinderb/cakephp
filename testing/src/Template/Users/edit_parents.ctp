<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Edit Parent</h2>
			<?= $this->Flash->render() ?>
		</div>
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<div class="row">
							<div class="col-sm-6">
								<h2>
									Parent Details
								</h2>
							</div>
							<div class="col-sm-6 text-right">
								<?php echo $this->Html->link(
								'Go to parent list',
								['controller' => 'users', 'action' => 'parents'],
								['escape' => false,'class'=>'btn bg-blue-grey']);
								$bankName = array('Please select','Yo Bank','No Bank','Q Bank');
								?>
							</div>
						</div>
					</div>
					<div class="body">
						<div class="form-common profile-upload-cs">
							<?php echo $this->Form->create($user,['class'=>'myform','type'=>'file']); ?>
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
											<label>Email Address  *</label>
											<?= $this->Form->control('email',     ['label' => false, 'class' => 'form-control', 'placeholder' => 'Email Address','value'=> $this->Decryption->emailDecode($user['email']),'readonly'=> true]);?>
										</div>
										<div class="form-group">
											<label>Mobile Number  *</label>
											<span id="errmsg" style="color:red;"></span>
											<?= $this->Form->control('mobile_no', ['label' => false, 'class' => 'form-control', 'placeholder' => 'xxxxxxxxxx','value'=> $this->Decryption->mc_decrypt($user['mobile_no'],$user['encryptionkey'])]);?>
										</div>
										<div class="form-group">
											<label>BSN No. *</label>
											<?= $this->Form->control('bsn_no', ['label' => false, 'class' => 'form-control', 'placeholder' => 'xxxxxxxxxx','value'=> $this->Decryption->mc_decrypt($user['bsn_no'],$user['encryptionkey'])]);?>
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
											<?= $this->Form->control('dob',['type'=>'text','label' => false, 'class' => 'datepicker form-control', 'placeholder' => 'DOB','value'=>date('d-m-Y', strtotime(base64_decode($user['dob'])))]);?>
										</div>
										<div class="form-group">
											<label>Your Bank *</label>
											<?= $this->Form->control('bank_name',['label' => false, 'class' => 'form-control', 'placeholder' => 'Bank Name','value'=> $this->Decryption->mc_decrypt($user['bank_name'],$user['encryptionkey'])]);?>
											<?php //$this->Form->select('bank_name',$bankName,['multiple' => false,'value' => [],'label' => false, 'class' => 'form-control show-tick']);?>
										</div>
										
										<div class="form-group">
											<label>Account Number *</label>
											<?= $this->Form->control('account', ['label' => false, 'class' => 'form-control', 'placeholder' => 'xxx-xxx-xxxx','value'=> $this->Decryption->mc_decrypt($user['account'],$user['encryptionkey'])]);?>
										</div>
										
										<div class="form-group">
											<label>Post Code *</label>
											<?= $this->Form->control('post_code', ['label' => false, 'class' => 'form-control', 'placeholder' => 'xxxx-xx-x','id'=>'autocomplete','data-mask'=>'0000-00-00','value'=> $this->Decryption->mc_decrypt($user['post_code'],$user['encryptionkey'])]);?>
											<div class="ui-widget" style="margin-top:2em; font-family:Arial">
												<!-- 				Result:
												-->			<!-- 	<div id="log" style="height: 200px; width: 300px; overflow: auto;" class="ui-widget-content"></div> -->
											</div>
										</div>
										<div class="form-group">
											<label>Address *</label>
											<?= $this->Form->control('address',   ['type'=>'textarea','label' => false, 'class' => 'form-control', 'placeholder' => 'Address','id'=>'address','value'=> $this->Decryption->mc_decrypt($user['address'],$user['encryptionkey'])]);?>
										</div>
										<div class="form-group">
											<label>Woonplaats  *</label>
											<?= $this->Form->control('residence', ['type'=>'textarea','label' => false, 'class' => 'form-control', 'placeholder' => 'Residence','id'=>'city','value'=> $this->Decryption->mc_decrypt($user['residence'],$user['encryptionkey'])]);?>
										</div>
										
										<!---<div class="form-group">
											<label for="password">Password  * <i style="font-size:12px">(Password must contain atleast one capital letter and alphanumeric characters.)</i></label>
											<?php //$this->Form->control('password', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Password','value'=>'']);?>
										</div>
										<div class="form-group">
											<label>Confirm Password  *</label>
											<?php // $this->Form->control('confirm_password', ['type'=>'password','label' => false, 'class' => 'form-control', 'placeholder' => 'Confirm password']);?>
										</div>--->
										<!-- <div class="form-group">
											<label>BSO Image *</label>
											<?php //$this->Form->control('image', ['label' => false, 'type' => 'file']);?>
										</div> -->
										<!-- echo $this->Form->control('field', ['type' => 'file']); -->
										<div class="text-right m-b-10 m-t-30">
											<?= $this->Form->button('Create User',['class' => 'btn btn-lg bg-teal']);
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
</section>