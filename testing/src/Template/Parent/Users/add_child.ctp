<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Add Child</h2>
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
									['controller' => 'users', 'action' => 'manageChildren', 'prefix' => 'parent'],
									['escape' => false,'class'=>'btn bg-blue-grey']);
									$relation = array('Please select','Son','Daughter','Other, Please specify below');
									
									$parent_id = $parents['id'];
									$post_code = $parents['post_code'];
									$address = $parents['address'];
									$Woonplaats=$parents['residence'];
								?>
							</div>
						</div>
					</div>
					<div class="body">
						<div class="form-common profile-upload-cs">
							<?php echo $this->Form->create($user,['class'=>'','type'=>'file']); ?>
								<div class="row">
									<div class="col-sm-4 col-md-3">
										<div class="form-group upload-img">
											<span class="text-info text-small p-b-10">Image size should be 1:1</span>
											<div class="input-file-outer">
												<div class="input-file-in">
													<img id="UplodImg" src="<?php echo $this->request->webroot.'img/no-img.jpg';?>" alt="Image Name" />
												</div>
												<span class="text-info text-small p-t-10">Only PNG and JPEG format is allowed</span>
												<input type="file" class="input-file" id="" onchange="readURL(this);">
												<?= $this->Form->control('image', ['label' => false,'onchange'=>'readURL(this);','class'=>'input-file','type' => 'file','accept'=>'image/png, image/jpeg']);?>
											<button class="btn bg-blue input-file-btn"> Upload image</button>
											</div>
										</div>
									</div>
									<div class="col-sm-8 col-md-8">
										<div class="form-group">
											<label>First Name  *</label>
											<?= $this->Form->control('firstname',   ['label' => false, 'class' => 'form-control', 'placeholder' => 'First Name']); ?>
										</div>
										<div class="form-group">
											<label>Last Name  *</label>
											<?= $this->Form->control('lastname',   ['label' => false, 'class' => 'form-control', 'placeholder' => 'Last Name']); ?>
										</div>
										
										<div class="form-group">
											<label>School *</label>
											<?= $this->Form->control('school',   ['label' => false, 'class' => 'form-control', 'placeholder' => 'School Name']); ?>
											
										</div>
										<div class="form-group">
											<label>Gender</label>
											<input name="gender" id="radio_48" class="with-gap radio-col-blue-grey" type="radio" value="1" type="hidden">
											<label for="radio_48">Male</label>
											
											<input name="gender" id="radio_49" class="with-gap radio-col-blue-grey" type="radio" value="2" type="hidden">
											<label for="radio_49">Female</label>

											<?php 
											/*echo	$this->Form->input('gender', [
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
											<?= $this->Form->control('dob',['type'=>'text','label' => false, 'class' => 'datepicker form-control', 'placeholder' => 'DOB']);?>
										</div>
										<div class="form-group row">
											<label>Relation with child *</label>
											<?=$this->Form->select('relation1',$relation,['multiple' => false,'value' => [],'label' => false, 'class' => 'relation form-control show-tick']);?>
											
										
										
										<div class="form-group showrelation"  style="display:none;">
											<label>Please specify relation with child *</label>
											<?= $this->Form->control('relation',   ['label' => false, 'class' => 'form-control', 'placeholder' => 'Relation with child']); ?>
										</div>
										</div>
										
										<div class="form-group">
											<label>Address *</label><br>
											<input name="group5" id="radio_50" class="with-gap radio-col-blue-grey" type="radio"> 
											<label for="radio_50">Same as parent</label>
											<input name="group5" id="radio_51" class="with-gap radio-col-blue-grey" type="radio"> 
											<label for="radio_51">Differnt address</label>
										</div>
										<div class="form-group Differnt">
											<label>Post Code *</label>
											<?= $this->Form->control('post_code', ['label' => false, 'class' => 'showdiff form-control', 'placeholder' => 'xxxx-xx-x','id'=>'autocomplete','data-mask'=>'0000-00-00']);?>
											<div class="ui-widget" style="margin-top:2em; font-family:Arial">
												<!-- 				Result:
												-->			<!-- 	<div id="log" style="height: 200px; width: 300px; overflow: auto;" class="ui-widget-content"></div> -->
										</div>
										</div>
										<div class="form-group Differnt">
											<label>Address *</label>
											<?= $this->Form->control('address',   ['type'=>'textarea','label' => false, 'class' => 'showdiff form-control', 'placeholder' => 'Address','id'=>'address']);?>
										</div>
										<div class="form-group Differnt">
											<label>Woonplaats  *</label>
											<?= $this->Form->control('residence', ['type'=>'textarea','label' => false, 'class' => 'showdiff form-control', 'placeholder' => 'Residence','id'=>'city']);?>
										</div>
										<div class="form-group Same" style="display:none">
											<label>Post Code *</label>
											<?= $this->Form->control('post_code', ['label' => false, 'class' => 'showsame form-control','value'=> $this->Decryption->mc_decrypt($post_code,$parents['encryptionkey'])]);?>
											<div class="ui-widget" style="margin-top:2em; font-family:Arial">
												
										</div>
										</div>
										<div class="form-group Same" style="display:none">
											<label>Address *</label>
											<?= $this->Form->control('address',   ['label' => false, 'class' => 'showsame form-control','value'=> $this->Decryption->mc_decrypt($post_code,$parents['encryptionkey'])]);?>
										</div>
										<div class="form-group Same" style="display:none">
											<label>Woonplaats  *</label>
											<?= $this->Form->control('residence', ['label' => false, 'class' => 'showsame form-control','value'=> $this->Decryption->mc_decrypt($Woonplaats,$parents['encryptionkey'])]);?>
										</div>
										<div class="form-group">
											<!--  -->
											<?= $this->Form->control('parent_id', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=>$parent_id]);?>
										</div>
										
										<div class="form-group text-right">
										<?= $this->Form->button('Add Child',['class' => 'btn btn-lg bg-teal']);
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