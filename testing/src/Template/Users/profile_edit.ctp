<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2 class="text-uppercase"><i class="fa fa-user-circle-o"> </i>User Pofile</h2>
			<?= $this->Flash->render() ?>
		</div>
		<div class="row clearfix">
			<!-- Task Info -->
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="card data-table-outer">
					<div class="header">
						<h2 class="text-uppercase"><?=$user->firstname.' '.$user->lastname;?></h2>
					</div>
					<div class="body">
						<div class="form-common profile-upload-cs">
							<?php echo $this->Form->create($user,['class'=>'form-inline-cs','type'=>'file']);?>
							<div class="row">
								<div class="col-sm-4 col-md-3">
									<div class="form-group upload-img">
										<span class="text-info text-small p-b-10">Image size should be 1:1</span>
										<div class="input-file-outer">
											<div class="input-file-in">
												<?php 
													if(!empty($this->request->getSession()->read('Auth.User.image'))){
														echo $this->Html->link($this->Html->image(USER_PICTURE_FOLDER_URL_PATH.$user['uuid'].'/'.$this->request->getSession()->read('Auth.User.image'), ['alt' => 'John','class' => 'img-responsive max-width-user-pic','id'=>'UplodImg']),'',['escapeTitle' => false,]);
													}else{												
														echo $this->Html->link($this->Html->image('blank-avatar.png', ['alt' => 'John','class' => 'img-responsive max-width-user-pic','id'=>'UplodImg']),'',['escapeTitle' => false,]);
													}
												?>
											</div>
											<span class="text-info text-small p-t-10">Only PNG and JPEG image will uplode.</span>
											<?= $this->Form->control('image', ['label' => false,'onchange'=>'readURL(this);','class'=>'input-file','type' => 'file']);?>
											<button class="btn bg-blue input-file-btn"> Change image</button>
										</div>
									</div>
								</div>
								<div class="col-sm-8 col-md-8">
									<div class="form-group">
										<label>First Name  *</label>
										<?= $this->Form->control('firstname',  ['label' => false, 'class' => 'form-control', 'placeholder' => 'First Name']); ?>
									</div>
									<div class="form-group">
										<!-- <label>Last Name  *</label> -->
										<?= $this->Form->control('lastname',  ['label' => false, 'class' => 'form-control', 'placeholder' => 'Last Name','type'=>'hidden']); ?>
									</div>
									<div class="form-group">
										<label>Email Address  *</label>
										<?= $this->Form->control('email',     ['label' => false, 'class' => 'form-control', 'placeholder' => 'Email Address','readonly'=> true]);?>
									</div>
									<div class="form-group">
										<label>Mobile Number  *</label>
										<span id="errmsg" style="color:red;"></span>
										<?= $this->Form->control('mobile_no', ['label' => false, 'class' => 'form-control', 'placeholder' => 'xxxxxxxxxx']);?>
									</div>
									<div class="form-group">
										<label>Postcode *</label>
										<?= $this->Form->control('post_code', ['label' => false, 'class' => 'form-control', 'placeholder' => 'xxxx-xx-x']);?>
									</div>
									<div class="form-group">
										<label>Address *</label>
										<?= $this->Form->control('address',   ['type'=>'textarea','label' => false, 'class' => 'form-control', 'placeholder' => 'Address']);?>
									</div>
									<fieldset>
										<legend>Change Password:</legend>
										<div id="message">
										  <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
										  <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
										  <p id="number" class="invalid">A <b>number</b></p>
										  <p id="length" class="invalid">Minimum <b>8 characters</b></p>
										</div>
										<div class="form-group">
											<label for="password">Password <i style="font-size:12px">(Password must contain atleast one capital letter and alphanumeric characters.)</i></label>
											<?= $this->Form->control('password', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Password','value'=>'','pattern'=>"(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"]);?>
										</div>
										<div class="form-group">
											<label>Confirm Password</label>
											<?= $this->Form->control('confirm_password', ['type'=>'password','label' => false, 'class' => 'form-control', 'placeholder' => 'Confirm password','value'=>'']);?>
										</div>
									</fieldset>
									<div class="form-group text-right">
										<button type="submit" class="btn btn-lg bg-teal"> Save</button>
									</div>

								</div>
							</div>
							<?php	echo $this->Form->end();  ?>
						</div>
					</div>
				</div>
			</div>
  </div>
	</div>
</section>
				
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

			<!-- #END# Task Info -->
		