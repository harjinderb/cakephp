<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2><?=__('Add BSO')?></h2>
			<?= $this->Flash->render() ?>
		</div>
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<div class="row">
							<div class="col-sm-6">
								<h2>
								<?=__('BSO Details')?>
								</h2>
							</div>
							<div class="col-sm-6 text-right">
								<?php echo $this->Html->link('<span>'.__('Go Back').'</span>',['controller' => 'users', 'action' => 'index'],['escape' => false,'class'=>'btn bg-blue-grey']);
								$counterylisting = $this->Counterylist->countries();

								?>
							</div>
						</div>
					</div>
					<div class="body">
						<div class="form-common profile-upload-cs">
							<div class="row">
								<?php echo $this->Form->create($user,['class'=>'myform','type'=>'file']); ?>
								<div class="row">
									<div class="col-sm-4 col-md-3">
										<div class="form-group upload-img">
											<span class="text-info text-small p-b-10"><?=__('Image size should be 1:1')?></span>
											<div class="input-file-outer">
												<div class="input-file-in">
													<img id="UplodImg" src ='<?php echo $this->request->webroot.'img/no-img.jpg';?>' alt="Image Name" />
												</div>
											<span class="text-info text-small p-t-10"><?=__('Only PNG and JPEG  format is allowed.')?></span>
												<input type="file" class="input-file" id="" onchange="readURL(this);">
												<?= $this->Form->control('image', ['label' => false,'onchange'=>'readURL(this);','class'=>'input-file','type' => 'file','accept'=>'image/png, image/jpeg']);?>
												<button class="btn bg-blue input-file-btn"> <?=__('Upload image')?></button>
											</div>
										</div>
									</div>

									<div class="col-sm-8 col-md-8">
										<div class="form-group">
										<label><?=__('Select Countery *')?></label>
										<?=$this->Form->select('countery',$counterylisting,['multiple' => false,'value'=> $countery_code,'label' => false, 'class' => 'form-control select2','id'=>'countery','type'=>'text']);?>
										</div>
										<div class="form-group region">
										<label><?=__('Select Timezone Region')?></label>
										<?=$this->Form->select('region',$regions,['multiple' => false,'value' => $regions,'label' => false, 'class' => 'form-control select2','id'=>'region','type'=>'text']);?>
										</div>
										<div class="form-group">
											<label><?=__('BSO Name  *')?></label>
											<?= $this->Form->control('firstname',   ['label' => false, 'class' => 'form-control', 'placeholder' =>  __('Name')]); ?>
										</div>
										<div class="form-group">
											<!-- <label>Last Name  *</label> -->
											<?= $this->Form->control('lastname',   ['label' => false, 'class' => 'form-control', 'placeholder' =>  __('Last Name'),'type'=>'hidden']); ?>
										</div>
										<div class="form-group">
											<label><?=__('Email Address  *')?></label>
											<?= $this->Form->control('email',     ['label' => false, 'class' => 'form-control', 'placeholder' =>  __('Email Address')]);?>
										</div>
										<div class="form-group">
											<label><?=__('Mobile Number  *')?></label>
											<span id="errmsg" style="color:red;"></span>
											<?= $this->Form->control('mobile_no', ['label' => false, 'class' => 'form-control', 'placeholder' => 'xxxxxxxxxx']);?>
										</div>
										<div class="form-group">
											<!-- <label>Gender</label> -->
											<!-- <input name="gender" id="radio_48" class="with-gap radio-col-blue-grey" type="radio" value="1" type="hidden"> -->
											<!-- 				<label for="radio_48">Male</label>
											-->
											<!-- <input name="gender" id="radio_49" class="with-gap radio-col-blue-grey" type="radio" value="2" type="hidden"> -->
											<!-- 	<label for="radio_49">Female</label> -->
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
											<!-- <label>Date of Birth *</label> -->
											<?= $this->Form->control('dob',     ['label' => false, 'class' => 'datepicker form-control', 'placeholder' =>  __('DOB'),'type'=>'hidden']);?>
										</div>
										<div class="form-group">
											<label><?=__('Post Code *')?></label>
											<?= $this->Form->control('post_code', ['label' => false, 'class' => 'form-control', 'placeholder' => 'xxxx-xx-x','id'=>'autocomplete','data-mask'=>'0000-00-00']);?>
											<div class="ui-widget" style="margin-top:2em; font-family:Arial">
												<!-- 				Result:
												-->			<!-- 	<div id="log" style="height: 200px; width: 300px; overflow: auto;" class="ui-widget-content"></div> -->
											</div>
										</div>
										<div class="form-group">
											<label><?=__('Address *')?></label>
											<?= $this->Form->control('address',   ['type'=>'textarea','label' => false, 'class' => 'form-control', 'placeholder' =>  __('Address'),'id'=>'address']);?>
										</div>
										<div class="form-group">
											<label><?=__('Woonplaats  *')?></label>
											<?= $this->Form->control('residence', ['type'=>'textarea','label' => false, 'class' => 'form-control', 'placeholder' =>  __('Residence'),'id'=>'city']);?>
										</div>
										<div class="form-group">
											<!-- <label for="password">Password  * <i style="font-size:12px">(Password must contain atleast one capital letter and alphanumeric characters.)</i></label> -->
											<?= $this->Form->control('password', ['type'=>'hidden','label' => false, 'class' => 'form-control', 'placeholder' =>  __('Password')]);?>
										</div>
										<div class="form-group">
											<!-- <label>Confirm Password  *</label> -->
											<?= $this->Form->control('confirm_password', ['type'=>'hidden','label' => false, 'class' => 'form-control', 'placeholder' =>  __('Confirm password')]);?>
										</div>
										<div class="form-group">
											<!--  -->
											<?= $this->Form->control('parent_id', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> '0']);?>
										</div>
										<!-- <div class="form-group">
											<label>BSO Image *</label>
											<?php //$this->Form->control('image', ['label' => false, 'type' => 'file']);?>
										</div> -->
										<!-- echo $this->Form->control('field', ['type' => 'file']); -->
										<div class="text-right m-b-10 m-t-30">
											<?= $this->Form->button(__('Create User'),['class' => 'btn btn-lg bg-teal']);
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
	</div>
</section>
