<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?=__('Child Basic Info')?></h1>
      <?= $this->Flash->render() ?>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-md-4">
				<div class="box box-primary">
					<div class="box-body">
						<div class="profile-info-left">
							<div class="profile-image">
								<?php 
                              if(!empty($user['image'])){
	                                echo $this->Html->link($this->Html->image(USER_PICTURE_FOLDER_URL_PATH.$user['uuid'].'/'.$user['image'], ['alt' => 'John','class' => 'img-responsive max-width-user-pic','id'=>'UplodImg']),'',['escapeTitle' => false,]);
	                            }else{ ?>
                                                            
                                <img id="UplodImg" src ='<?php echo $this->request->webroot.'img/no-img.jpg';?>' alt="Image Name" />
                            <?php }?>
								<!-- <img src="../dist/img/avatar3.png" alt="Nina"> -->
							</div>
							<?php
								//pr($parent);die;
							?>
							<h3 class="admin-name"><?= $user['firstname'].' '.$user['lastname']?></h3>
							
							<div class="profile-highlight-info">
								<div class="row">
									<div class="col-xs-6">
										<b><?=__('Gender')?></b>
									</div>
									<div class="col-xs-6">
										<?php if($user->gender == 1){?>
										<?=__('Male')?>
										<?php } else {?>
										<?=__('Female')?>
									<?php }?>
									</div>
								</div>
							</div>
							<div class="profile-highlight-info">
								<div class="row">
									<div class="col-xs-6">
										<b><?=__('DOB')?></b>
									</div>
									<div class="col-xs-6">
										<p> <?=date('d-m-Y', strtotime($user->dob));?></p>
									</div>
								</div>
							</div>
							<div class="profile-highlight-info">
								<div class="row">
									<div class="col-xs-6">
										<b><?=__('School')?></b>
									</div>
									<div class="col-xs-6">
										<p><?= $Schools['name']?></p>
									</div>
								</div>
							</div>
							<div class="profile-highlight-info">
								<div class="row">
									<div class="col-xs-6">
										<b><?=__('Contact Number')?></b>
									</div>
									<div class="col-xs-6">
										<p><?= $parent['mobile_no']?></p>
									</div>
								</div>
							</div>
							<div class="profile-highlight-info">
								<div class="row">
									<div class="col-xs-6">
										<b><?=__('Pending Paymnet')?></b>
									</div>
									<div class="col-xs-6">
										<p>&euro; 765,20</p>
									</div>
								</div>
							</div>
							<div class="profile-highlight-info">
								<div class="row">
									<div class="col-xs-6">
										<b><?=__('Pay by Date')?></b>
									</div>
									<div class="col-xs-6">
										<p>22 Jan 2019</p>
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
						<div class="nav-tabs-custom cs-tab-round child-view-info">
							<ul class="nav nav-tabs">
							  <li class="active"><a href="#Persoonsgegevens" data-toggle="tab"><?=__('Personal data')?></a></li>
							  <li><a href="#Gedragsociaal" data-toggle="tab"><?=__('Behavior and Social')?></a></li>
							  <li><a href="#Medischemotioneel" data-toggle="tab"><?=__('Medical and emotional')?></a></li>
							  <li><a href="#Opvoedingsgegevens" data-toggle="tab"><?=__('Parenting data')?></a></li>
							  <li><a href="#Andereinformatie" data-toggle="tab"><?=__('Other information')?></a></li>
							  
							</ul>
							<div class="tab-content">
										<div class="tab-content">
											<div id="Persoonsgegevens" class="tab-pane fade in active">
												<?php 
												echo $this->Form->create($recption, ['name'=>'personal', 'class'=>'form-common form-basic-info', 'type'=>'file']); ?>
												<h3><?=__('1. Personal data')?> </h3>
												<!-- <div class="form-group"> -->
													<!-- <label><?php //__('Datum intake *')?></label> -->
													<?php // $this->Form->control('ingestion_date',['label' => false, 'class' => 'form-control','id' =>'datepicker','data-dtp'=>'dtp_QF1Am','placeholder' => 'Datum intake','requied'=> true,'value'=>$this->Decryption->mc_decrypt($recption[0]['ingestion_date'],$user['encryptionkey'])]);?>
												<!-- </div> -->
												<div class="form-group">
													<p><b><?=__('Family composition')?></b></p>
													<?= $this->Form->hidden('parent_id',   ['value'=> $childparent]); ?>
													<?= $this->Form->hidden('bsoid',   ['value'=> $bsoid]); ?>
													<?= $this->Form->hidden('child_id',   ['value'=> $id]); ?>
													<?php 
													$key = 0;
														 $child_id = $id;
														
													if(!empty($guardian)){
														//pr($guardian);die;
													
													foreach ($guardian as $key => $value) {
													    if(empty($value)){
													    	$value = '';
													    	
													    } 
													   	
													$name = $value['firstname'].$value['lastname'];
													//$id = $value['id'];
													if(!empty($value['id'])){
														$id = $value['id'];	
													}else{
														$id = '-1'; 
													}
													$relationset = $value['relation'];

													$getresponse = $this->Relation->relationfunction($relationset);
 
													?>
													
													<div class="row">
														<div class="col-sm-6">
															<?php 
															if(!empty($value['firstname'])){
																?>
																<div class="form-group">
																<label><b><?=__('Name')?></b></label>
																<?= $this->Form->control('name[]',   ['name'=>'data['.$key.'][name]', 'label' => false, 'class' => 'form-control', 'placeholder' => ' Name','value'=> $this->Decryption->mc_decrypt($value['firstname'],$value['encryptionkey']).' '.$this->Decryption->mc_decrypt($value['lastname'],$value['encryptionkey'])]); ?>
																<?= $this->Form->hidden('ids[]',   ['value'=> $id]); ?>
																
															</div>

														<?php 	}else{ 
															?>
															<div class="form-group">
																<label><b><?=__('Name')?></b></label>
																<?= $this->Form->control('name[]',   ['name'=>'data['.$key.'][name]', 'label' => false, 'class' => 'form-control', 'placeholder' => ' Name']); ?>
																<?= $this->Form->hidden('ids[]',   ['value'=> $id]); ?>
																
															</div>
														<?php } ?>
														</div>
														<div class="col-sm-6">
															<div class="form-group">
																<label><b><?=__('Relation with child *')?></b></label>
																<?= $this->Form->input('relation1[]', array('name'=>'data['.$key.'][relation1]', 'type'=>'select','label'=>false, 'class'=>'form-control show-tick serviceday', 'options'=>DEFAULTRELATIONS,'value'=> $getresponse)); ?>
										
															</div>
															</div>
															<?php if($getresponse == '3'){ ?>
															<div class="col-sm-12">
															<div class="form-group showrelation <?php echo $getresponse =='3' ? 'Show': 'hide' ?>">
																<label><b><?=__('Please specify relation with child *')?></b></label>
																<?= $this->Form->control('relation[]',   ['name'=>'data['.$key.'][relation]', 'label' => false, 'class' => 'form-control', 'placeholder' => 'Relation with child', 'value'=> $relationset]); ?>
															</div>
															</div>
														<?php }?>
															</div>
															
														<?php }  
																}else{
														$getresponse = array('Please select','Son','Daughter','Other, Please specify below');
														$name = '';
														?>
																											<div class="row">
														<div class="col-sm-6">
															<?php 
															if(!empty($value['firstname'])){
																?>
																<div class="form-group">
																<label><b><?=__('Name')?></b></label>
																<?= $this->Form->control('name[]',   ['name'=>'data['.$key.'][name]', 'label' => false, 'class' => 'form-control', 'placeholder' => ' Name','value'=> $this->Decryption->mc_decrypt($value['firstname'],$value['encryptionkey']).' '.$this->Decryption->mc_decrypt($value['lastname'],$value['encryptionkey'])]); ?>
																<?= $this->Form->hidden('ids[]',   ['value'=> $id]); ?>
																
															</div>

														<?php 	}else{ 
															?>
															<div class="form-group">
																<label><b><?=__('Name')?></b></label>
																<?= $this->Form->control('name[]',   ['name'=>'data['.$key.'][name]', 'label' => false, 'class' => 'form-control', 'placeholder' => ' Name']); ?>
																<?= $this->Form->hidden('ids[]',   ['value'=> $id]); ?>
																
															</div>
														<?php } ?>
														</div>
														<div class="col-sm-6">
															<div class="form-group">
																<label><b><?=__('Relation with child *')?></b></label>
																<?= $this->Form->input('relation1[]', array('type'=>'select','label'=>false, 'class'=>'form-control show-tick serviceday', 'options'=>DEFAULTRELATIONS,'value'=> $getresponse)); ?>
										
															</div>
															</div>
															<?php if($getresponse == '3'){ ?>
															<div class="col-sm-12">
															<div class="form-group showrelation">
																<label><b><?=__('Please specify relation with child *')?></b></label>
																<?= $this->Form->control('relation[]',   ['label' => false, 'class' => 'form-control', 'placeholder' => 'Relation with child', 'value'=> $relationset]); ?>
															</div>
															</div>
														<?php }?>
															</div>
														<?php }
														?>
													<div id="view1"></div>
													<div class="form-group text-right">
														<a href="javascript:void(0)" class="btn bg-teal" data-attr="<?= count($guardian) ?>" id="click1"><?=__('Add More')?></a>
													</div>
													<div class="form-group">
														<label><b><?=__('Additional telephone number (s) i.v.m. absence')?></b></label>
														<span id="errmsg" style="color:red;"></span>
														<?= $this->Form->control('mobile_no', ['label' => false, 'class' => 'form-control', 'placeholder' => 'xxxxxxxxxx','value'=> $this->Decryption->mc_decrypt($recption[0]['mobile_no'],$user['encryptionkey'])]);?>

														
													</div>
												</div>
												<div class="form-group">
													<!-- <p><b><?php//__('Opvang op de volgende dagen')?></b></p> -->
													<?php 
													//pr($recption);die;
													// if(!empty($recption[0])){
													// 	//pr($recption[0]);die;
													// 	foreach ($recption as $key => $value1) {
															//pr($value1);die;														
														?>
													<!-- <div class="row">
														<div class="col-sm-6">
															<div class="form-group">
																<label><b>Opvang</b></label> -->
																<?php //$this->Form->control('reception[]',   ['label' => false, 'class' => 'form-control reception','value'=>$this->Decryption->mc_decrypt($value1['reception'],$user['encryptionkey']) ]);?>																<!-- </div>
														</div>
														<div class="col-sm-6">
															<label><b>Date *</b></label> -->
															<?php //$this->Form->control('reception_date[]',['label' => false, 'class' => ' form-control receptiondate','id' =>'datepicker','data-dtp'=>'dtp_QF1Am','data-dtp'=>'dtp_QF1Am' , 'placeholder' => 'Datum intake', 'value' => $this->Decryption->mc_decrypt( $value1['reception_date'],$user['encryptionkey'])]);?>
														<!-- </div>
													</div> -->
												<?php 
											// 	}
											// }else{

												?>
												
													<!-- <div class="row">
														<div class="col-sm-6">
															<div class="form-group">
																<label><b>Opvang</b></label>
																<?php // $this->Form->control('reception[]',   ['label' => false, 'class' => 'form-control reception']);?>																</div>
														</div>
														<div class="col-sm-6">
															<label><b>Date *</b></label>
															<?php // $this->Form->control('reception_date[]',['label' => false, 'class' => 'datepicker form-control receptiondate' ,'data-dtp'=>'dtp_QF1Am', 'placeholder' => 'Datum intake']);?>
														</div>
													</div> -->

												<?php// } ?>
													<!--  -->
													<div id="view2"></div>
													<div class="form-group text-right">
														<!-- <a href="javascript:void(0)" class="btn bg-teal" id="click2">Add More</a> -->
													</div>
												</div>
												
												 <div class="form-group text-right m-t-20">
												<div class="cs-btn-group">
												
												<?= $this->Form->button(__('Next'),['class' => 'btn btn-lg btnNext bg-teal']);
												?>
												
												</div>
												</div>
												<?php echo $this->Form->end(); ?>	
											</div>
											<!-----2start------>
											<div id="Gedragsociaal" class="tab-pane fade">
												<?php echo $this->Form->create($behaviorandSocial, ['name'=>'social', 'class'=>'form-common form-basic-info', 'type'=>'file']); ?>
												<h3><?=__('2. Playing behavior')?> </h3>
												<div class="form-group">
													<div class="row">
														<div class="col-sm-6">
															<label><b><?=__('Are there things your child likes to do? If so what?')?></b></label>
														</div>
														<div class="col-sm-4">
														<input name="group5" id="radio_48" class="with-gap radio-col-blue-grey" type="radio" value="1" 
														<?php  if($behaviorandSocial['childlike']!== null){echo "checked";}?>> 
														<label class="radio-label" for="radio_48"><?=__('Yes')?></label>
														<input name="group5" id="radio_49" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($behaviorandSocial['childlike']=='2' ? 'checked' : '');?>> 
														<label class="radio-label" for="radio_49"><?=__('No')?></label>
														</div>
													<div class="col-sm-12" id='childlike' <?php if($behaviorandSocial['childlike']=='' || $behaviorandSocial['childlike']=='2'){echo "style = 'display:none'"; }?>>
														<label><?=__('Please indicate')?></label>
														<?= $this->Form->control('childlike',   ['label' => false, 'class' => 'form-control', 'placeholder' => __('Please indicate')]);?>
														
													</div>
													</div>
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b><?=__('Where does your child prefer to play?')?></b></label>
													</div>
													<div class="col-sm-4">
													<input name="childprefer" id="radio_50" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($behaviorandSocial['childprefer']=='1' ? 'checked' : '');?>> 
													<label class="radio-label" for="radio_50"><?=__('Inside')?></label>
													<input name="childprefer" id="radio_51" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($behaviorandSocial['childprefer']=='2' ? 'checked' : '');?>> 
													<label class="radio-label" for="radio_51"><?=__('Outside')?></label>
													</div>
												</div>
													
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b><?=__('Can your child be focused on something for a longer period of time?')?></b></label>
													</div>
													<div class="col-sm-4">
													<input name="allergy" id="radio_52" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php if($behaviorandSocial['childbusy']!== null){echo "checked";}?>> 
													<label class="radio-label" for="radio_52"><?=__('Yes')?></label>
													<input name="allergy" id="radio_53" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($behaviorandSocial['childbusy']=='2' ? 'checked' : '');?>> 
													<label class="radio-label" for="radio_53"><?=__('No')?></label>
													</div>
													<div class="col-sm-12" id='childbusy' <?php if($behaviorandSocial['childlike']=='' || $behaviorandSocial['childlike']=='2'){echo "style = 'display:none'"; }?>>
													<label><?=('Please indicate')?></label>
													<?= $this->Form->control('childbusy',   ['label' => false, 'class' => 'form-control', 'placeholder' => __('Please indicate')]);?>
													
													</div>
												</div>
													
													
												</div>
												<h3><?=__('3. Social information')?> </h3>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b><?=__('Does the child have an interest in other children')?></b></label>
													</div>
													<div class="col-sm-4">
													<input name="childinterest_otherchildern" id="radio_54" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($behaviorandSocial['childinterest_otherchildern']=='1' ? 'checked' : '');?>> 
													<label class="radio-label" for="radio_54"><?=__('Yes')?></label>
													<input name="childinterest_otherchildern" id="radio_55" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($behaviorandSocial['childinterest_otherchildern']=='2' ? 'checked' : '');?>> 
													<label class="radio-label" for="radio_55"><?=__('No')?></label>
													</div>
												</div>
													
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b><?=__('Does the child interact with peers in a pleasant way?')?></b></label>
													</div>
													<div class="col-sm-4">
													<input name="childhappypeers" id="radio_56" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($behaviorandSocial['childhappypeers']=='1' ? 'checked' : '');?>> 
													<label class="radio-label" for="radio_56"><?=__('Yes')?></label>
													<input name="childhappypeers" id="radio_57" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($behaviorandSocial['childhappypeers']=='2' ? 'checked' : '');?>> 
													<label class="radio-label" for="radio_57"><?=__('No')?></label>
													</div>
												</div>
													
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b><?=__('Does the child have boyfriends / girlfriends?')?></b></label>
													</div>
													<div class="col-sm-4">
													<input name="childhavebfgif" id="radio_58" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($behaviorandSocial['childhavebfgif']=='1' ? 'checked' : '');?>> 
													<label class="radio-label" for="radio_58"><?=__('Yes')?></label>
													<input name="childhavebfgif" id="radio_59" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($behaviorandSocial['childhavebfgif']=='2' ? 'checked' : '');?>> 
													<label class="radio-label" for="radio_59"><?=__('No')?></label>
													</div>
												</div>
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b><?=__('Does the child interact with brothers and sisters in a pleasant way?')?></b></label>
													</div>
													<div class="col-sm-4">
													<input name="childhappybrothersis" id="radio_60" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($behaviorandSocial['childhappybrothersis']=='1' ? 'checked' : '');?>> 
													<label class="radio-label" for="radio_60"><?=__('Yes')?></label>
													<input name="childhappybrothersis" id="radio_61" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($behaviorandSocial['childhappybrothersis']=='2' ? 'checked' : '');?>> 
													<label class="radio-label" for="radio_61"><?=__('No')?></label>
													</div>
												</div>
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b><?=__('Does the child interact with the parent (s) / caregiver (s) in a pleasant way?');?></b></label>
													</div>
													<div class="col-sm-4">
													<input name="childhappyparent" id="radio_62" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($behaviorandSocial['childhappyparent']=='1' ? 'checked' : '');?>> 
													<label class="radio-label" for="radio_62"><?=__('Yes')?></label>
													<input name="childhappyparent" id="radio_63" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($behaviorandSocial['childhappyparent']=='2' ? 'checked' : '');?>> 
													<label class="radio-label" for="radio_63"><?=__('No')?></label>
													</div>
												</div>
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b><?=__('Can the child move around in another?')?></b></label>
													</div>
													<div class="col-sm-4">
													<input name="childmove" id="radio_64" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($behaviorandSocial['childmove']=='1' ? 'checked' : '');?>> 
													<label class="radio-label" for="radio_64"><?=__('Yes')?></label>
													<input name="childmove" id="radio_65" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($behaviorandSocial['childmove']=='2' ? 'checked' : '');?>> 
													<label class="radio-label" for="radio_65"><?=__('No')?></label>
													</div>
												</div>
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b><?=__('Does the child often argue with others? If so, what is the (possible) cause of this and how does he / she resolve this')?></b></label>
													</div>
													<div class="col-sm-4">
													<input name="argue" id="radio_66" class="with-gap radio-col-blue-grey" type="radio" value="1"  <?php if($behaviorandSocial['childargue']!== null){echo "checked";}?>> 
													<label class="radio-label" for="radio_66"><?=__('Yes')?></label>
													<input name="argue" id="radio_67" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($behaviorandSocial['childargue']=='2' ? 'checked' : '');?>> 
													<label class="radio-label" for="radio_67"><?=__('No')?></label>
													</div>
													<div class="col-sm-12" id='childargue' <?php if($behaviorandSocial['childargue']=='' || $behaviorandSocial['childargue']=='2'){echo "style = 'display:none'"; }?>>
													<label><?=__('Please indicate')?></label>
													<?= $this->Form->control('childargue',   ['label' => false, 'class' => 'form-control', 'placeholder' => __('Please indicate')]);?>
													<?= $this->Form->hidden('child_id',   ['value'=> $child_id]); ?>
													</div>
												</div>
													
													
												</div>
												<div class="form-group text-right m-t-20">
												<div class="cs-btn-group">
												<?= $this->Form->button(__('Previous'),['class' => 'btn btn-lg btnPrevious bg-orange']);
												?>	
												<?= $this->Form->button(__('Next'),['class' => 'btn btn-lg btnNext bg-teal']);
												?>
												
												</div>
												<?php echo $this->Form->end(); ?>
												</div>
											</div>
											<!-----3start------>
											<div id="Medischemotioneel" class="tab-pane fade">
											<?php echo $this->Form->create($medicalemotionals, ['name'=>'medical', 'class'=>'form-common form-basic-info', 'type'=>'file']); ?>
												<h3><?=__('4. Medical information')?></h3>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b><?=__('Is there special illness? If so, what should the BSO know about this?')?></b></label>
													</div>
													<div class="col-sm-4">
													<input name="group15" id="radio_70" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php if($medicalemotionals['specialdiseases']!= ''){echo "checked";}?>> 
													<label class="radio-label" for="radio_70"><?=__('Yes')?></label>
													<input name="group15" id="radio_71" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($medicalemotionals['specialdiseases']=='2' ? 'checked' : '');?>> 
													<label class="radio-label" for="radio_71"><?=__('No')?></label>
													</div>
													<div class="col-sm-12" id='specialdiseases' <?php if($medicalemotionals['specialdiseases']=='' || $medicalemotionals['specialdiseases']=='2'){echo "style = 'display:none'"; }?>>
													<label><?=__('Please indicate')?></label>
													<?= $this->Form->control('specialdiseases',   ['label' => false, 'class' => 'form-control', 'placeholder' => __('Please indicate')]);?>
													
													</div>
												</div>
													
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b><?=__('Is there any allergy? If so which, and how should the BSO take this into account?')?></b></label>
													</div>
													<div class="col-sm-4">
													<input name="group16" id="radio_72" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php if($medicalemotionals['allergies']!= ''){echo "checked";}?> > 
													<label class="radio-label" for="radio_72"><?=__('Yes')?></label>
													<input name="group16" id="radio_73" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($medicalemotionals['allergies']=='2' ? 'checked' : '');?>> 
													<label class="radio-label" for="radio_73"><?=__('No')?></label>
													</div>
													<div class="col-sm-12" id='allergies' <?php if($medicalemotionals['allergies']=='' ||$medicalemotionals['allergies']=='2'){echo "style = 'display:none'"; }?>>
													<label><?=__('Please indicate')?></label>
													<?= $this->Form->control('allergies',   ['label' => false, 'class' => 'form-control', 'placeholder' => __('Please indicate')]);?>
													
													</div>	
												</div>
													
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b><?=__('Are there problems with the function of the senses?')?></b></label>
													</div>
													<div class="col-sm-4">
													<input name="group17" id="radio_74" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php if($medicalemotionals['senses']!= ''){echo "checked";}?>> 
													<label class="radio-label" for="radio_74"><?=__('Yes')?></label>
													<input name="group17" id="radio_75" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($medicalemotionals['senses']=='2' ? 'checked' : '');?>> 
													<label class="radio-label" for="radio_75"><?=__('No')?></label>
													</div>
													<div class="col-sm-12" id='senses' <?php if($medicalemotionals['senses']=='' || $medicalemotionals['senses']=='2'){echo "style = 'display:none'"; }?>>
													<label><?=__('Please indicate')?></label>
													<?= $this->Form->control('senses',   ['label' => false, 'class' => 'form-control', 'placeholder' => __('Please indicate')]);?>
													
													</div>	
												</div>
													
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b><?=__('Has the motor development progressed normally?')?></b></label>
													</div>
													<div class="col-sm-4">
													<input name="motordevelopment" id="radio_76" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($medicalemotionals['motordevelopment']=='1' ? 'checked' : '');?>> 
													<label class="radio-label" for="radio_76"><?=__('Yes')?></label>
													<input name="motordevelopment" id="radio_77" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($medicalemotionals['motordevelopment']=='2' ? 'checked' : '');?>> 
													<label class="radio-label" for="radio_77"><?=__('No')?></label>
													</div>
												</div>
											
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b><?=__('Is your child potty-trained?')?></b></label>
													</div>
													<div class="col-sm-4">
													<input name="childsick" id="radio_78" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($medicalemotionals['childsick']=='1' ? 'checked' : '');?>> 
													<label class="radio-label" for="radio_78"><?=__('Yes')?></label>
													<input name="childsick" id="radio_79" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($medicalemotionals['childsick']=='2' ? 'checked' : '');?>> 
													<label class="radio-label" for="radio_79"><?=__('No')?></label>
													</div>
												</div>
													
													
												</div>
												<h3><?=__('5. Emotional data')?></h3>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b><?=__('Can the child express different emotions? How does he / she express that?')?></b></label>
													</div>
													<div class="col-sm-4">
													<input name="differentemotions" id="radio_80" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($medicalemotionals['differentemotions']=='1' ? 'checked' : '');?>> 
													<label class="radio-label" for="radio_80"><?=__('Yes')?></label>
													<input name="differentemotions" id="radio_81" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($medicalemotionals['differentemotions']=='2' ? 'checked' : '');?>><label class="radio-label" for="radio_81"><?=__('No')?></label>
													</div>
												</div>
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b><?=__('fear')?></b></label>
													</div>
													<div class="col-sm-4">
													<input name="anxiety" id="radio_82" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($medicalemotionals['anxiety']=='1' ? 'checked' : '');?>> 
													<label class="radio-label" for="radio_82"><?=__('Yes')?></label>
													<input name="anxiety" id="radio_83" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($medicalemotionals['anxiety']=='2' ? 'checked' : '');?>> 
													<label class="radio-label" for="radio_83"><?=__('No')?></label>
													</div>
												</div>
													
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b><?=__('joy')?></b></label>
													</div>
													<div class="col-sm-4">
													<input name="blijheid" id="radio_84" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($medicalemotionals['blijheid']=='1' ? 'checked' : '');?>> 
													<label class="radio-label" for="radio_84"><?=__('Yes')?></label>
													<input name="blijheid" id="radio_85" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($medicalemotionals['blijheid']=='2' ? 'checked' : '');?>> 
													<label class="radio-label" for="radio_85"><?=__('No')?></label>
													</div>
												</div>
												
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b><?=__('anger')?></b></label>
													</div>
													<div class="col-sm-4">
													<input name="boosheid" id="radio_86" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($medicalemotionals['boosheid']=='1' ? 'checked' : '');?>> 
													<label class="radio-label" for="radio_86"><?=__('Yes')?></label>
													<input name="boosheid" id="radio_87" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($medicalemotionals['boosheid']=='2' ? 'checked' : '');?>> 
													<label class="radio-label" for="radio_87"><?=__('No')?></label>
													</div>
												</div>
													
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b><?=__('sadness')?></b></label>
													</div>
													<div class="col-sm-4">
													<input name="verdriet" id="radio_88" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($medicalemotionals['verdriet']=='1' ? 'checked' : '');?>> 
													<label class="radio-label" for="radio_88"><?=__('Yes')?></label>
													<input name="verdriet" id="radio_89" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($medicalemotionals['verdriet']=='2' ? 'checked' : '');?>> 
													<label class="radio-label" for="radio_89"><?=__('No')?></label>
													</div>
													<?= $this->Form->hidden('child_id',   ['value'=> $child_id]); ?>
												</div>
													
													
												</div>
												<div class="form-group text-right m-t-20">
												<div class="cs-btn-group">
												<?= $this->Form->button(__('Previous'),['class' => 'btn btn-lg btnPrevious bg-orange']);
												?>	
												<?= $this->Form->button(__('Next'),['class' => 'btn btn-lg btnNext bg-teal']);
												?>
												
												</div>
												<?php echo $this->Form->end(); ?>
												</div>
											</div>
											<!-----4start------>
											<div id="Opvoedingsgegevens" class="tab-pane fade">
												<?php echo $this->Form->create($educationallanguages, ['name'=>'medical', 'class'=>'form-common form-basic-info', 'type'=>'file']); ?>
												<h3><?=__('6. Parenting data')?></h3>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b><?=__('Are there things in upbringing that you regularly encounter?')?></b></label>
													</div>
													<div class="col-sm-4">
													<input name="upbringing" id="radio_90" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($educationallanguages['upbringing']=='1' ? 'checked' : '');?>> 
													<label class="radio-label" for="radio_90"><?=__('Yes')?></label>
													<input name="upbringing" id="radio_91" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($educationallanguages['upbringing']=='2' ? 'checked' : '');?>> 
													<label class="radio-label" for="radio_91"><?=__('No')?></label>
													</div>
												</div>
												
													
												</div>
												<h3><?=__('7. Language development')?></h3>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b><?=__('Is your child understandable?')?></b></label>
													</div>
													<div class="col-sm-4">
													<input name="childunderstandable" id="radio_92" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($educationallanguages['childunderstandable']=='1' ? 'checked' : '');?>> 
													<label class="radio-label" for="radio_92"><?=__('Yes')?></label>
													<input name="childunderstandable" id="radio_93" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($educationallanguages['childunderstandable']=='2' ? 'checked' : '');?>> 
													<label class="radio-label" for="radio_93"><?=__('No')?></label>
													</div>
												</div>
													
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b><?=__('Does your child always understand what you are saying?')?></b></label>
													</div>
													<div class="col-sm-4">
													<input name="group23" id="radio_94" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php if($educationallanguages['childalwaysunderstand']!== null){echo "checked";}?>> 
													<label class="radio-label" for="radio_94"><?=__('Yes')?></label>
													<input name="group23" id="radio_95" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($educationallanguages['childalwaysunderstand']=='2' ? 'checked' : '');?>> 
													<label class="radio-label" for="radio_95"><?=__('No')?></label>
													</div>
													<div class="col-sm-12" id='childalwaysunderstand' <?php if($educationallanguages['childalwaysunderstand']=='' || $educationallanguages['childalwaysunderstand']=='2'){echo "style = 'display:none'"; }?>>
													<label><?=__('Please indicate')?></label>
													<?= $this->Form->control('childalwaysunderstand',   ['label' => false, 'class' => 'form-control', 'placeholder' => __('Please indicate')]);?>
													
													</div>	
												</div>
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b><?=__('Does your child have sufficient vocabulary?')?></b></label>
													</div>
													<div class="col-sm-4">
														<input name="enoughvocabulary" id="radio_96" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($educationallanguages['enoughvocabulary']=='1' ? 'checked' : '');?>> 
														<label class="radio-label" for="radio_96"><?=__('Yes')?></label>
														<input name="enoughvocabulary" id="radio_97" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($educationallanguages['enoughvocabulary']=='2' ? 'checked' : '');?>> 
														<label class="radio-label" for="radio_97"><?=__('No')?></label>
													</div>
												</div>
													
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b><?=__('Does your child speak easily to others?')?></b></label>
													</div>
													<div class="col-sm-4">
													
													<input name="childspeakeasily" id="radio_98" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($educationallanguages['childspeakeasily']=='1' ? 'checked' : '');?>> 
													<label class="radio-label" for="radio_98"><?=__('Yes')?></label>
													<input name="childspeakeasily" id="radio_99" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($educationallanguages['childspeakeasily']=='2' ? 'checked' : '');?>> 
													<label class="radio-label" for="radio_99"><?=__('No')?></label>
													</div>
												</div>
													
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
														<label><b><?=__('Your child is stuttering')?></b></label>
													</div>
													<div class="col-sm-4">
														<input name="stutteryourchild" id="radio_100" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($educationallanguages['stutteryourchild']=='1' ? 'checked' : '');?>> 
														<label class="radio-label" for="radio_100"><?=__('Yes')?></label>
														<input name="stutteryourchild" id="radio_101" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($educationallanguages['stutteryourchild']=='2' ? 'checked' : '');?>> 
														<label class="radio-label" for="radio_101"><?=__('No')?></label>
													</div>
													<?= $this->Form->hidden('child_id',   ['value'=> $child_id]); ?>
												</div>
													
													
												</div>
												<div class="form-group text-right m-t-20">
												<div class="cs-btn-group">
												<?= $this->Form->button(__('Previous'),['class' => 'btn btn-lg btnPrevious bg-orange']);
												?>	
												<?= $this->Form->button(__('Next'),['class' => 'btn btn-lg btnNext bg-teal']);
												?>
												
												</div>
												<?php echo $this->Form->end(); ?>
												</div>
											</div>
											<!-----5start------>
											<div id="Andereinformatie" class="tab-pane fade">
												<?php echo $this->Form->create($otherinformations, ['name'=>'medical', 'class'=>'form-common form-basic-info', 'type'=>'file']); ?>
												<h3><?=__('8. Other information')?></h3>
												<div class="row">
													<div class="col-sm-6">
														<div class="form-group">
															<label><?=__('Nationality child')?></label>
															
															<?= $this->Form->control('nationality_child',   ['label' => false, 'class' => 'form-control', 'placeholder' => __(' Nationality child')]); ?>
														</div>
													</div>
													<div class="col-sm-6">
														<div class="form-group">
															<label><?=__('Soc./med. Indication')?></label>
															
															<?= $this->Form->control('socmed_indicatie',   ['label' => false, 'class' => 'form-control', 'placeholder' => __('Soc./med. Indication')]); ?>
														</div>
													</div>
													
												</div>
												<div class="row">
													<div class="col-sm-6">
														<div class="form-group">
															<label><?=__('General practitioner + tel. No')?></b></label>
															
															<?= $this->Form->control('general_practitioner',   ['label' => false, 'class' => 'form-control', 'placeholder' => __('General practitioner + tel. No')]); ?>
														</div>
													</div>
													<div class="col-sm-6">
														<div class="form-group">
															<label><?=__('Dentist + tel. No')?></label>
															
															<?= $this->Form->control('dentist',   ['label' => false, 'class' => 'form-control', 'placeholder' => __('Dentist + tel. No')]); ?>
														</div>
													</div>
													
												</div>
												
												
												<h3><?=__('9. BSO')?> </h3>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
														<label><b><?=__('Does the child want to go to the BSO?')?></b></label>
													</div>
													<div class="col-sm-4">
														<input name="wantto_gobso" id="radio_1" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($otherinformations['wantto_gobso']=='1' ? 'checked' : '');?>> 
														<label class="radio-label" for="radio_1"><?=__('Yes')?></label>
														<input name="wantto_gobso" id="radio_2" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($otherinformations['wantto_gobso']=='2' ? 'checked' : '');?>> 
														<label class="radio-label" for="radio_2"><?=__('No')?></label>
													</div>
												</div>
													
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
														<label><b><?=__('Does your child visit a playgroup or daycare center?')?></b></label>
													</div>
													<div class="col-sm-4">
														<input name="visitaplayroom" id="radio_3" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($otherinformations['visitaplayroom']=='1' ? 'checked' : '');?>> 
														<label class="radio-label" for="radio_3"><?=__('Yes')?></label>
														<input name="visitaplayroom" id="radio_4" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($otherinformations['visitaplayroom']=='2' ? 'checked' : '');?>> 
														<label class="radio-label" for="radio_4"><?=__('No')?></label>
													</div>
												</div>
													<br>
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
														<label><b><?=__('Can we look forward to a transfer form with regard to this?')?></b></label>
													</div>
													<div class="col-sm-4">
														<input name="seeatransfer" id="radio_5" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($otherinformations['seeatransfer']=='1' ? 'checked' : '');?>> 
														<label class="radio-label" for="radio_5"><?=__('Yes')?></label>
														<input name="seeatransfer" id="radio_6" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($otherinformations['seeatransfer']=='2' ? 'checked' : '');?>> 
														<label class="radio-label" for="radio_6"><?=__('No')?></label>
													</div>
												</div>
													
													
												</div>
												<h3><?=__('10. Other questions / comments')?></h3>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
														<label><b><?=__('Do you have additional information about your child?')?></b></label>
													</div>
													<div class="col-sm-4">
														<input name="group29" id="radio_7" class="with-gap radio-col-blue-grey" type="radio" <?php if($otherinformations['additionalinformation']!== null){echo "checked";}?>> 
														<label class="radio-label" for="radio_7"><?=__('Yes')?></label>
														<input name="group29" id="radio_8" class="with-gap radio-col-blue-grey" type="radio" <?php echo ($otherinformations['additionalinformation']=='2' ? 'checked' : '');?>> 
														<label class="radio-label" for="radio_8"><?=__('No')?></label>
													</div>
													<div class="col-sm-12" id='additionalinformation' <?php if($otherinformations['additionalinformation']=='' || $otherinformations['additionalinformation']=='2'){echo "style = 'display:none'"; }?>>
													<label><?=__('Please indicate')?></label>
													<?= $this->Form->control('additionalinformation',   ['label' => false, 'class' => 'form-control', 'placeholder' => __('Please indicate')]);?>
													
													</div>
												</div>
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b><?=__('Are there children with whom your child plays well / likes?')?></b></label>
													</div>
													<div class="col-sm-4">
														<input name="group30" id="radio_9" class="with-gap radio-col-blue-grey" type="radio"<?php if($otherinformations['whomwithchild_likestoplay']!== null){echo "checked";}?>> 
														<label class="radio-label" for="radio_9"><?=__('Yes')?></label>
														<input name="group30" id="radio_10" class="with-gap radio-col-blue-grey" type="radio" <?php echo ($otherinformations['whomwithchild_likestoplay']=='2' ? 'checked' : '');?>> 
														<label class="radio-label" for="radio_10"><?=__('No')?></label>
													</div>
													<div class="col-sm-12" id='whomwithchild_likestoplay' <?php if($otherinformations['additionalinformation']=='' || $otherinformations['additionalinformation']=='2'){echo "style = 'display:none'"; }?>>
													<label><?=__('Please indicate')?></label>
													<?= $this->Form->control('whomwithchild_likestoplay',   ['label' => false, 'class' => 'form-control', 'placeholder' => __('Please indicate')]);?>
													
													</div>
												</div>
													
												</div>
												<h3><?=__('11. Care')?></h3>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
														<label><b><?=__('Can the school be contacted for childcare?')?></b></label>
													</div>
													<div class="col-sm-4"> 
														<input name="group31" id="radio_11" class="with-gap radio-col-blue-grey" type="radio"<?php if($otherinformations['contactwithschool']!== null){echo "checked";}?>> 
														<label class="radio-label" for="radio_11"><?=__('Yes')?></label>
														<input name="group31" id="radio_12" class="with-gap radio-col-blue-grey" type="radio" <?php echo ($otherinformations['contactwithschool']=='2' ? 'checked' : '');?>> 
														<label class="radio-label" for="radio_12"><?=__('No')?></label>
													</div>
													<div class="col-sm-12" id='contactwithschool' <?php if($otherinformations['contactwithschool']=='' || $otherinformations['contactwithschool']=='2'){echo "style = 'display:none'"; }?>>
													<label><?=__('Please indicate')?></label>
													<?= $this->Form->control('contactwithschool',   ['label' => false, 'class' => 'form-control', 'placeholder' => __('Please indicate')]);?>
													
													</div>
												</div>
													
													
												</div>
												<h3><?=__('12. What do parents expect from BSO Bolderburen?')?></h3>
												<div class="form-group">
														<?= $this->Form->control('parentsexpect',   ['type'=>'textarea','label' => false, 'class' => 'form-control', 'placeholder' =>  __('Please indicate')]);?>
														<?= $this->Form->hidden('child_id',   ['value'=> $child_id]); ?>
												</div>
												<div class="form-group text-right m-t-20">
												<div class="cs-btn-group">
												<?= $this->Form->button(__('Previous'),['class' => 'btn btn-lg btnPrevious bg-orange']);
												?>	
												<?= $this->Form->button(__('Save'),['class' => 'btn btn-lg btnNext bg-teal']);
												?>
												
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
			</div>
		</div>
	</div>
</section>