<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2 class="text-uppercase"><i class="fa fa-user"> </i><?=__('Reset Your Password')?></h2>
			<?= $this->Flash->render() ?>
		</div>
		<div class="m-t-30 back-btn text-right">
			
			
		</div>
		
		<div class="card m-t-30">
			<div class="body">
				<div class="form-common">
				<div class="row">
					<div class="col-md-8 col-md-offset-2 p-t-30">
						<?php
						echo $this->Form->create($user ,['class'=>'form-inline-cs','type'=>'file']);
						?>
						
						<div class="form-group">
							<label for="password"><?=__('New Password  *')?> <i style="font-size:12px"><?=__('Password must contain atleast one capital letter and alphanumeric characters.')?></i></label>
							<div id="message">
							  <p id="letter" class="invalid"><?=__('A')?><b><?=__('lowercase')?></b> <?=__('letter')?></p>
							  <p id="capital" class="invalid"><?=__('A')?> <b><?=__('capital(uppercase)')?></b> <?=__('letter')?></p>
							  <p id="number" class="invalid"><?=__('A')?> <b><?=__('number')?></b></p>
							  <p id="length" class="invalid"><?=__('Minimum')?> <b><?=__('8 characters')?></b></p>
							</div>
							<?= $this->Form->control('password', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Password','value'=>'']);?>
						</div>
						<div class="form-group">
							<label><?=__('Confirm Password  *')?></label>
							<?= $this->Form->control('confirm_password', ['type'=>'password','label' => false, 'class' => 'form-control', 'placeholder' => 'Confirm password']);?>
						</div>
						<div class="text-right m-b-10 m-t-30">
							<?= $this->Form->button(__('Reset Password'),['class' => 'btn btn-lg bg-teal']);
							echo $this->Form->end();
							?>
						</div>
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>
</section>
<fieldset>
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

