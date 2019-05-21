
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?=__('Your Profile')?></h1>
      <?= $this->Flash->render() ?>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-md-4">
				<div class="box box-primary">
					<div class="box-body">
						<?php
						//pr($user);die;
						?>
						<div class="profile-info-left">
							<div class="profile-image">
								<?php 
									if(!empty($this->request->getSession()->read('Auth.User.image'))){
										echo $this->Html->link($this->Html->image(USER_PICTURE_FOLDER_URL_PATH.$user['uuid'].'/'.$this->request->getSession()->read('Auth.User.image'), ['alt' => 'John','class' => 'img-responsive max-width-user-pic','id'=>'UplodImg']),'',['escapeTitle' => false,]);
									}else{												
										echo $this->Html->link($this->Html->image('blank-avatar.png', ['alt' => 'John','class' => 'img-responsive max-width-user-pic','id'=>'UplodImg']),'',['escapeTitle' => false,]);
									}
								?>
							</div>
							<h3 class="admin-name"><?=$user['firstname'].' '.$user['lastname']?></h3>
							<p class="admin-email"><?=$user['email']?> </p>
							<div class="profile-highlight-info">
								<div class="row">
									<div class="col-xs-6">
										<b><?=__('Gender')?></b>
									</div>
									<div class="col-xs-6">
										<p>
										<?php if($user->gender == 1){?>
											<?=__('Male')?>
										<?php } else {?>
											<?=__('Female')?>
										<?php }?>
									</p>
									</div>
								</div>
							</div>
							
							<div class="profile-highlight-info">
								<div class="row">
									<div class="col-xs-6">
										<b><?=__('Role')?></b>
									</div>
									<div class="col-xs-6">
										<p><?php if($user->role_id == '4' && $user->parent_id == '0'){?>
											<?=__('Parent')?> 
										<?php } elseif($user->role_id == '4' && $user->parent_id != '0'){?>
											<?=__('Guardian')?>
										<?php }?></p>
									</div>
								</div>
							</div>
								
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div class="box box-primary">
					<div class="box-body">
						<div class="nav-tabs-custom cs-tab-round">
							<ul class="nav nav-tabs">
							  <li class="active"><a href="#GeneralInfo" data-toggle="tab"><?=__('General Info')?></a></li>
							  <li><a href="#ChangePassword" data-toggle="tab"><?=__('Change Password')?></a></li>
							</ul>
							<div class="tab-content">
							  <div class="tab-pane active" id="GeneralInfo">
							  	<?php echo $this->Form->create($user,['class'=>'myform profile-form','type'=>'file']); 
									// $relationset = $user['relation'];
									// $getresponse = $this->Relation->relationfunction($relationset);
								?>
								<!-- <form action="" method="" class="form-common profile-form"> -->
									<div class="form-group">
										<div class="row">
											<div class="col-lg-3">
												<label for="name"><?=__('First Name')?></label>
											</div>
											<div class="col-lg-6">
												<?= $this->Form->control('firstname',   ['label' => false, 'class' => 'form-control', 'placeholder' => 'First Name','type'=>'text']); ?>
												
											</div>
										</div>
									</div>
									<!-- <div class="form-group">
										<div class="row">
											<div class="col-lg-3">
												<label for="name"><?php //__('Last Name')?></label>
											</div>
											<div class="col-lg-6"> -->
												<?= $this->Form->control('lastname',   ['label' => false, 'class' => 'form-control', 'placeholder' => 'Last Name','type'=>'hidden']); 
                          						?>				
											<!-- </div>
										</div>
									</div> -->
									<div class="form-group">
										<div class="row">
											<div class="col-lg-3">
												<label for="name"><?=__('Email Address')?></label>
											</div>
											<div class="col-lg-6">											
												<?= $this->Form->control('email',     ['label' => false, 'class' => 'form-control', 'placeholder' => 'Email Address']);?>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-3">
												<label for="name"><?=__('Profile Image')?></label>
											</div>
											<div class="col-lg-6">
												<div class="input-file-outer profile-input-file">
					                           <div class="input-file-in">
					                              <?php 
													if(!empty($this->request->getSession()->read('Auth.User.image'))){
														echo $this->Html->link($this->Html->image(USER_PICTURE_FOLDER_URL_PATH.$user['uuid'].'/'.$this->request->getSession()->read('Auth.User.image'), ['alt' => 'John','class' => 'img-responsive max-width-user-pic','id'=>'UplodImg']),'',['escapeTitle' => false,]);
													}else{												
														echo $this->Html->link($this->Html->image('blank-avatar.png', ['alt' => 'John','class' => 'img-responsive max-width-user-pic','id'=>'UplodImg']),'',['escapeTitle' => false,]);
													}
												?>
					                           </div>
					                           <input type="file" class="input-file" id="" onchange="readURL(this);">
					                           <?= $this->Form->control('image', ['label' => false,'onchange'=>'readURL(this);','class'=>'input-file','type' => 'file','accept'=>'image/png, image/jpeg']);
					                           ?>
					                           <button class="btn btn-change-profile input-file-btn"> <?=__('Change..')?></button>
					                        </div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-3">
												<label for="name"><?=__('Gender')?></label>
											</div>
											<div class="col-lg-6">
												<?php if($user['gender'] =='1'){?>
											<input name="gender" id="radio_48" class="with-gap radio-col-blue-grey" type="radio" value="1" type="hidden" checked="checked">
											<label for="radio_48" class="radio-label"><?=__('Male')?></label>
											<input name="gender" id="radio_49" class="with-gap radio-col-blue-grey" type="radio" value="2" type="hidden">
											<label for="radio_49" class="radio-label"><?=__('Female')?></label>
											<?php }else{?>
											<input name="gender" id="radio_48" class="with-gap radio-col-blue-grey" type="radio" value="1" type="hidden">
											<label for="radio_48" class="radio-label"><?=__('Male')?></label>
											<input name="gender" id="radio_49" class="with-gap radio-col-blue-grey" type="radio" value="2" type="hidden" checked="checked">
											<label for="radio_49" class="radio-label"><?=__('Female')?></label>
											<?php } ?>
											</div>
										</div>
									</div>
									<!-- <div class="form-group">
										<div class="row">
											<div class="col-lg-3">
												<label for="name"><?php //__('Date of birth')?></label>
											</div>
											<div class="col-lg-6"> -->
												<?= $this->Form->control('dob',     ['type'=>'hidden','label' => false, 'class' => 'datepicker form-control', 'placeholder' => 'DOB','value'=>'']);?>
											<!-- </div>
										</div>
									</div> -->
									<div class="form-group">
										<div class="row">
											<div class="col-lg-3">
												<label for="name"><?=__('Pin Code')?></label>
											</div>
											<div class="col-lg-6">
												<?= $this->Form->control('post_code', ['label' => false, 'class' => 'form-control', 'placeholder' => 'xxxx-xx-x','id'=>'autocomplete','data-mask'=>'0000-00-00']);?>
												<div class="ui-widget" style="margin-top:2em; font-family:Arial">
												</div>
												
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-3">
												<label for="name"><?=__('Address (Area and Street)')?></label>
											</div>
											<div class="col-lg-6">
												<?= $this->Form->control('address',   ['type'=>'textarea','label' => false, 'class' => 'form-control', 'placeholder' => 'Address','id'=>'address']);?>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-3">
												<label for="name"><?=__('City/District')?></label>
											</div>
											<div class="col-lg-6">
												<?= $this->Form->control('residence', ['type'=>'textarea','label' => false, 'class' => 'form-control', 'placeholder' => 'Residence','id'=>'city']);?>
											</div>
										</div>
									</div>
										
									<div class="form-group text-right last-element">
										<div class="row">
											<div class="col-lg-3">
											</div>
											<div class="col-lg-6">
												<?= $this->Form->button('Update',['class' => 'btn btn-theme']);
                        						?>
												<!-- <button type="button" class="btn btn-theme ">Update</button> -->
											</div>
										</div>
									</div>
							<?php echo $this->Form->end(); ?>  
							  </div>
							  <!-- /.tab-pane -->
							  <div class="tab-pane" id="ChangePassword">
							  	<?php
							  	echo $this->Form->create('',['class'=>'myform profile-form','type'=>'POST','url' => ['controller'=>'Users', 'action' => 'newPassword', 'prefix' => false]]);
							  	?>
								
									<fieldset>
									<div class="form-group">
										<div class="row">
											<div id="message">
											<div class="col-lg-3">
												<label for="name"><?=__('Password Validations')?></label>
											</div>
											<div class="col-lg-6">
												  <p id="letter" class="invalid"><?=__('A')?> <b><?=__('lowercase')?></b><?=__('letter')?></p>
												  <p id="capital" class="invalid"><?=__('A')?> <b><?=__('capital (uppercase)')?></b> <?=__('letter')?></p>
												  <p id="number" class="invalid"><?=__('A')?><b><?=__('number')?></b></p>
												  <p id="length" class="invalid"><?=__('Minimum')?> <b><?=__('8 characters')?></b></p>
											</div>
											</div>
										</div>
									</div>
									
									<div class="form-group">
										<div class="row">
											<div class="col-lg-3">

												<label for="name"><?=__('New Password')?></label>
											</div>
											<div class="col-lg-6">
												
												<?= $this->Form->control('password', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Password','value'=>'','pattern'=>"(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"]);?>
											</div>
											<?= $this->Form->hidden('user_id',   ['value'=> $user['id']]); ?>
										</div>
									</div>

									<div class="form-group">
										<div class="row">
											<div class="col-lg-3">
												<label for="name"><?=__('Confirm New Password')?></label>
											</div>
											<div class="col-lg-6">
												
												<?= $this->Form->control('confirm_password', ['type'=>'password','label' => false, 'class' => 'form-control', 'placeholder' => 'Confirm password','value'=>'']);?>
											</div>
										</div>
									</div>
									</fieldset>
									<div class="form-group text-right last-element">
										<div class="row">
											<div class="col-lg-3">
											</div>
											<div class="col-lg-6">
												<?= $this->Form->button(__('Change Password'),['class' => 'btn btn-theme']);
                        						?>
												<!-- <button type="button" class="btn btn-theme ">Change Password</button> -->
											</div>
										</div>
									</div>
								<?php echo $this->Form->end(); ?> 
							  </div>
							  <!-- /.tab-pane -->
							  
							</div>
							<!-- /.tab-content -->
						 
					  
					</div>
					</div>
				<!-- /.box-body -->
			  </div>
			  <!-- /.box -->
			</div>
		</div>	
		

    </section>
    <!-- /.content -->
  </div>
  				
<script>
var myInput = document.getElementById("password");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");

// When the user clicks on the password field, show the message box
myInput.onfocus = function() {
    document.getElementById("message").style.display = "block";
}

// When the user clicks outside of the password field, hide the message box
myInput.onblur = function() {
    document.getElementById("message").style.display = "none";
}

// When the user starts to type something inside the password field
myInput.onkeyup = function() {
  // Validate lowercase letters
  var lowerCaseLetters = /[a-z]/g;
  if(myInput.value.match(lowerCaseLetters)) {  
    letter.classList.remove("invalid");
    letter.classList.add("valid");
  } else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
  }
  
  // Validate capital letters
  var upperCaseLetters = /[A-Z]/g;
  if(myInput.value.match(upperCaseLetters)) {  
    capital.classList.remove("invalid");
    capital.classList.add("valid");
  } else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
  }

  // Validate numbers
  var numbers = /[0-9]/g;
  if(myInput.value.match(numbers)) {  
    number.classList.remove("invalid");
    number.classList.add("valid");
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
  }
  
  // Validate length
  if(myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
}
</script>