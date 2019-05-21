<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?=__('Add Parent')?></h1>
      <?= $this->Flash->render() ?>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="box box-primary">
            <div class="box-header bso-box-header">
				<div class="row">
					<div class="col-xs-7">
						<h3 class="box-title"><?=__('Please enter parent details')?></h3>
					</div>
					<div class="col-xs-5 text-right">
						<?php echo $this->Html->link(
								'Go to parent list',
								['controller' => 'users', 'action' => 'parents'],
								['escape' => false,'class'=>'btn btn-theme btn-round']);
						?>
					</div>
				</div>
              
            </div>
            <!-- /.box-header -->
            <div class="box-body">
				<?php echo $this->Form->create($user,['class'=>'myform','type'=>'file']); ?>
					<div class="row">
						<div class="col-md-2 col-sm-3">
							<div class="form-group">
								<div class="input-file-outer profile-input-file">
									<div class="input-file-in">
                             	<img id="UplodImg" src="<?php echo $this->request->webroot.'img/no-img.jpg';?>" alt="Image Name"/>
                           		</div>
                           		<input type="file" class="input-file" id="" onchange="readURL(this);">
                           		<?= $this->Form->control('image', ['label' => false,'onchange'=>'readURL(this);','class'=>'input-file','type' => 'file','accept'=>'image/png, image/jpeg']);
                           		?>
                           		<button class="btn btn-change-profile input-file-btn"> Upload Image..</button>
								</div>
								</div>
							</div>
						<div class="col-md-10 col-sm-9">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label><?=__('First Name *')?></label>
										<?= $this->Form->control('firstname',   ['label' => false, 'class' => 'form-control', 'placeholder' => 'First Name','type'=>'text']); ?>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label><?=__('Last Name')?></label>
										<?= $this->Form->control('lastname',   ['label' => false, 'class' => 'form-control', 'placeholder' => 'Last Name','value'=> $user['lastname'],'type'=>'text']); ?>
									</div>
								</div>
							</div>
			
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label><?=__('Email Address *')?></label>
										<?= $this->Form->control('email',     ['label' => false, 'class' => 'form-control', 'placeholder' => 'Email Address']);
										?>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label><?=__('Mobile Number *')?></label>
										<?= $this->Form->control('mobile_no', ['label' => false, 'class' => 'form-control', 'placeholder' => 'xxxxxxxxxx','type'=>'text']);
										?>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label><?=__('BSN No. *')?></label>
								<?= $this->Form->control('bsn_no', ['label' => false, 'class' => 'form-control', 'placeholder' => 'xxxxxxxxxx','type'=>'text']);?>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label><?=__('Date of Birth *')?></label>
										<?= $this->Form->control('dob',['type'=>'text','label' => false, 'class' => 'datepicker form-control', 'placeholder' => 'DOB']);?>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label><?=__('Gender')?></label>
			                              <input name="gender" id="radio_48" class="with-gap radio-col-blue-grey" type="radio" value="1"> 
			                              <label for="radio_48" class="radio-label"><?=__('Male')?></label>
			                              <input name="gender" id="radio_49" class="with-gap radio-col-blue-grey" type="radio" value="2"> 
			                              <label for="radio_49" class="radio-label"><?=__('Female')?></label>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label><?=__('Bank Name *')?></label>
										<?= $this->Form->control('bank_name',['label' => false, 'class' => 'form-control', 'placeholder' => 'Bank Name','type'=>'text']);?>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label><?=__('Account Number *')?></label>
										<?= $this->Form->control('account', ['label' => false, 'class' => 'form-control', 'placeholder' => 'xxx-xxx-xxxx','type'=>'text']);?>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label><?=__('Pin Code *')?></label>
								<?= $this->Form->control('post_code', ['label' => false, 'class' => 'form-control', 'placeholder' => 'xxxx-xx-x','id'=>'autocomplete','data-mask'=>'0000-00-00']);?>
											<div class="ui-widget" style="margin-top:2em; font-family:Arial">
												
											</div>
							</div>	
							
							<div class="form-group">
								<label><?=__('Address (Area and Street) *')?></label>
								<?= $this->Form->control('address',   ['type'=>'textarea','label' => false, 'class' => 'form-control', 'placeholder' => 'Address','id'=>'address']);?>
							</div>
							
							
								
							<div class="form-group">
								<label><?=__('City/District *')?></label>
								<?= $this->Form->control('residence', ['type'=>'textarea','label' => false, 'class' => 'form-control', 'placeholder' => 'Residence','id'=>'city']);?>
							</div>
							
							<div class="form-group text-right">
								<?= $this->Form->button('Save Changes',['class' => 'btn btn-theme btn-round-md']);
                    			?>
							</div>
						</div>
					</div>

					
				<?php echo $this->Form->end(); ?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>