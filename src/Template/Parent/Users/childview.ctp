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
	                            }else{?>
                                                            
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
									<?php 
										//pr();die;
									?>
									<div class="col-xs-6">
										<b><?=__('Pending Paymnet')?></b>
									</div>
									<div class="col-xs-6">
										<?php 
											if(!empty($invicebal)){


										?>
										<p><?= '('.$GlobalSettings['currency_code'].')'.$invicebal['balance']?></p>
									<?php } ?>
									</div>
								</div>
							</div>
							<div class="profile-highlight-info">
								<div class="row">
									<div class="col-xs-6">
										<b><?=__('Pay by Date')?></b>
									</div>
									<div class="col-xs-6">
										<?php 
											if(!empty($invicebal)){


										?>
										<p><?= date('d-m-Y',strtotime($invicebal['invdue_date']))?></p>
										<?php } ?>
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
							  <li class="active"><a href="#Services" data-toggle="tab"><?=__('Services')?></a></li>
							  <li><a href="#Persoonsgegevens" data-toggle="tab"><?=__('Personal data')?></a></li>
							  <li><a href="#Gedragsociaal" data-toggle="tab"><?=__('Behavior and Social')?></a></li>
							  <li><a href="#Medischemotioneel" data-toggle="tab"><?=__('Medical and emotional')?></a></li>
							  <li><a href="#Opvoedingsgegevens" data-toggle="tab"><?=__('Parenting data')?></a></li>
							  <li><a href="#Andereinformatie" data-toggle="tab"><?=__('Other information')?></a></li>
							  
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="Services">
									<h3><?=__('Services')?> </h3>
									<table class="table table-striped table-hover v-center cell-pd-15">
										<thead>
											<tr>	
											  <th>#</th>
											  <th><?=__('Day')?></th>
											  <th><?=__('Start Time')?></th>
											  <th><?=__('End Time')?></th>
											  <th><?=__('Status')?></th>										 
											</tr>
										</thead>
										<tbody>
											<?php
												$i = 1;
												$Currentdate = date("Y-m-d");
												//pr($contracts);die;
												foreach ($contracts as $key => $value) {
											?>
											<tr>										  
												<td><?= $i?></td>
												<td><?= $value->service_day?></td>
												<td><?= date('d-m-Y',strtotime($value->start_time))?></td>
												<td><?= date('d-m-Y',strtotime($value->end_time))?></td>
												<td>
												<?php 
												if ($value['expirey_date'] <= $Currentdate && $value['status'] !=='0') {
												?>
												<span class="label label-bg-orange label-110 label-round">Expired</span>
   												<?php
   													}
   												?>
   												<?php 
												if ($value['expirey_date'] >= $Currentdate && $value['status']=='2') {?>
													<span class="label label-bg-red label-110 label-round">Stoped</span>
												<?php	
													}
											 	?>
											 	<?php 
												if ($value['expirey_date'] >= $Currentdate && $value['status']=='1') {?>
													<span class="label label-bg-green label-110 label-round">Active</span>
												<?php	
													}
											 	?>
   												</td>										
											</tr>
											 <?php
											 	$i++; 
											 	}
											 ?>
										</tbody>										
									</table>
								</div>
								<!-- /.tab-pane -->
								
								<div class="tab-pane" id="Persoonsgegevens">
									<h3><?=__('Personal data')?></h3>
									<div class="child-info-form">
										<div class="user-info-row">
											<label><?=__('Name')?></label>
											<p><?= $user['firstname'].' '.$user['lastname']?></p>
										</div>
										<div class="user-info-row">
											<label><?=__('School')?> </label>
											<p><?= $Schools['name']?></p>
										</div>
										<div class="user-info-row">
											<label><?=__('Gender')?></label>
											<p>
											<?php if($user->gender == 1){?>
												<?=__('Male')?>
										<?php } else {?>
												<?=__('Female')?>
										    <?php }?>
										    </p>
										</div>
										<div class="user-info-row">
											<label><?=__('Date of Birth')?></label>
											<p><?=date('d-m-Y', strtotime($user->dob));?></p>
										</div>
										<div class="user-info-row">
											<label><?=__('Parent')?></label>
											<p><?= $parent['firstname'].' '.$parent['lastname']?></p>
											
										</div>
										<div class="user-info-row">
											<label><?=__('Guardian')?></label>
											<?php
												foreach ($guardian as $key => $value) {
											?>
											<p><?= $value['firstname'].' '.$value['lastname']?></p>
											<?php
												}
											?>
											
										</div>
										
										<div class="user-info-row">
											<label><?=__('Address')?></label>
											<p><?= $user['address']?>, <?= $user['post_code']?>  <?= $user['residence']?> </p>
										</div>
										<div class="user-info-row">
											<label><?=__('Mobile Number')?></label>
											<p><?= $parent['mobile_no']?></p>
											
										</div>
										<div class="user-info-row">
											<label><?=__('Additional telephone number (s) i.v.m. absence')?></label>
											<p>
											<?php 
												if(!empty($recption)){
													echo $recption['mobile_no'];
											}
											?>
										</p>
										</div>
										<!-- <div class="user-info-row">
											<label>Registration Date</label>
											<p><?php //date('d-m-Y', strtotime($user['created']))?></p>
										</div>
										<div class="user-info-row">
											<label>Reception on the following days</label>
											<p><b>30-08-2018: </b> Reception Info</p>
											<p><b>30-08-2018: </b> Reception Info</p>
											<p><b>30-08-2018: </b> Reception Info</p>
											<p><b>30-08-2018: </b> Reception Info</p>
										</div> -->
										
									</div>								
								</div>
							  <!-- /.tab-pane -->
							  
							  <!-- /.tab-pane -->
							  <?php 
							  		//pr($behaviorandSocial);die;
							  ?>
							 
								<div class="tab-pane" id="Gedragsociaal">
									<h3><?=__('Behavior and Social')?></h3>
									<div class="user-info-row">
										<label><?=__('Are there things your child likes to do? If so what?')?></label>
										<p>
											<?php  if($behaviorandSocial['childlike']== 2){echo __('No');}elseif($behaviorandSocial['childlike']== 1){ echo __('Yes');}else{
													echo __('Not Added Yet');
												}
											?>
										</p>
										<p class="ans-added" id='childlike' <?php if($behaviorandSocial['childlike']=='' || $behaviorandSocial['childlike']=='2'){echo "style = 'display:none'"; }?>><?= $behaviorandSocial['childlike']?>
										</p>
									</div>
									<div class="user-info-row">
										<label><?=__('Where does your child prefer to play?')?></label>
										<p>
											<?php  if($behaviorandSocial['childprefer']== 2){echo "buiten";}elseif($behaviorandSocial['childprefer']== 1){ echo "Binnen";}else{
													echo __('Not Added Yet');
												}
											?>
										</p>
									</div>
									<div class="user-info-row">
										<label><?=__('Can your child be focused on something for a longer period of time?')?></label>
										<p>
											<?php  if($behaviorandSocial['childbusy']== 2){echo __('No');}elseif($behaviorandSocial['childbusy']== 1){ echo __('Yes');}else{echo __('Not Added Yet');}?>
										</p>
										<p class="ans-added" id='childbusy' <?php if($behaviorandSocial['childbusy']=='' || $behaviorandSocial['childbusy']=='2'){echo "style = 'display:none'"; }?>><?= $behaviorandSocial['childbusy']?>
										</p>
									</div>
									
									
									<h3><?=__('3. Social information')?></h3>
									<div class="user-info-row">
										<label><?=__('Does the child have an interest in other children')?></label>
										<p>
											<?php  if($behaviorandSocial['childinterest_otherchildern']== 2){echo __('No');}	elseif($behaviorandSocial['childinterest_otherchildern']== 1){ echo __('Yes');}else{echo __('Not Added Yet');}
											?>
										</p>
									</div>
									<div class="user-info-row">
										<label><?=__('Does the child interact with peers in a pleasant way?')?></label>
										<p>
											<?php  if($behaviorandSocial['childhappypeers']== 2){echo __('No');}elseif($behaviorandSocial['childhappypeers']== 1){ echo __('Yes');}else{echo __('Not Added Yet');}
											?>
										</p>
									</div>
									<div class="user-info-row">
										<label><?=__('Does the child have boyfriends / girlfriends?')?></label>
										<p>
											<?php  if($behaviorandSocial['childhavebfgif']== 2){echo __('No');}elseif($behaviorandSocial['childhavebfgif']== 1){ echo __('Yes');}else{echo __('Not Added Yet');}
											?>
										</p>
									</div>
									<div class="user-info-row">
										<label><?=__('Does the child interact with brothers and sisters in a pleasant way?')?></label>
										<p>
											<?php  if($behaviorandSocial['childhappybrothersis']== 2){echo __('No');}elseif($behaviorandSocial['childhappybrothersis']== 1){ echo __('Yes');}else{echo __('Not Added Yet');}
											?>
										</p>
									</div>
									<div class="user-info-row">
										<label><?=__('Does the child interact with the parent (s) / caregiver (s) in a pleasant way?');?></label>
										<p>
											<?php  if($behaviorandSocial['childhappyparent']== 2){echo __('No');}elseif($behaviorandSocial['childhappyparent']== 1){ echo __('Yes');}else{echo __('Not Added Yet');}?>
										</p>
									</div>
									<div class="user-info-row">
										<label><?=__('Can the child move around in another?')?></label>
										<p>
											<?php  if($behaviorandSocial['childmove']== 2){echo __('No');}elseif($behaviorandSocial['childmove']== 1){ echo __('Yes');}else{echo __('Not Added Yet');}
											?>
										</p>
									</div>
									<div class="user-info-row">
										<label><?=__('Does the child often argue with others? If so, what is the (possible) cause of this and how does he / she resolve this')?></label>
										<p>
											<?php  if($behaviorandSocial['childargue']== 2){echo __('No');}elseif($behaviorandSocial['childargue']== 1){ echo __('Yes');}else{echo __('Not Added Yet');}?>
										</p>
										<p class="ans-added" id='childargue' <?php if($behaviorandSocial['childargue']=='' || $behaviorandSocial['childargue']=='2'){echo "style = 'display:none'"; }?>><?= $behaviorandSocial['childargue']?>
										</p>

									</div>
												
								</div>
								
							  <!-- /.tab-pane -->
								<div class="tab-pane" id="Medischemotioneel">
									<h3> <?=__('4. Medical information')?></h3>
									<div class="user-info-row">
										<label><?=__('Is there special illness? If so, what should the BSO know about this?')?></label>
										<p>
											<?php  if($medicalemotionals['specialdiseases']== 2){echo __('No');}elseif($medicalemotionals['specialdiseases']== 1){ echo __('Yes');}else{echo __('Not Added Yet');}
											?>
										</p>
										<p class="ans-added" id='specialdiseases' <?php if($medicalemotionals['specialdiseases']=='' || $medicalemotionals['specialdiseases']=='2'){echo "style = 'display:none'"; }?>><?= $medicalemotionals['specialdiseases']?>
									   </p>
									</div>
									<div class="user-info-row">
										<label><?=__('Is there any allergy? If so which, and how should the BSO take this into account?')?></label>
										<p>
											<?php  if($medicalemotionals['allergies']== 2){echo __('No');}elseif($medicalemotionals['allergies']== 1){ echo __('Yes');}else{echo __('Not Added Yet');}
											?>
										</p>
										<p class="ans-added" id='allergies' <?php if($medicalemotionals['allergies']=='' || $medicalemotionals['allergies']=='2'){echo "style = 'display:none'"; }?>><?= $medicalemotionals['allergies']?>
									   </p>
									</div>
									<div class="user-info-row">
										<label><?=__('Are there problems with the function of the senses?')?></label>
										<p>
											<?php  if($medicalemotionals['senses']== 2){echo __('No');}elseif($medicalemotionals['senses']== 1){ echo __('Yes');}?>
										</p>
										<p class="ans-added" id='senses' <?php if($medicalemotionals['senses']=='' || $medicalemotionals['senses']=='2'){echo "style = 'display:none'"; }?>><?= $medicalemotionals['senses']?>
									   </p>
									</div>
									<div class="user-info-row">
										<label><?=__('Has the motor development progressed normally?')?></label>
										<p>
											<?php  if($medicalemotionals['motordevelopment']== 2){echo __('No');}elseif($medicalemotionals['motordevelopment']== 1){ echo __('Yes');}else{echo __('Not Added Yet');}
											?>
										</p>
									</div>
									<div class="user-info-row">
										<label><?=__('Is your child potty-trained?')?></label>
										<p>
											<?php  if($medicalemotionals['childsick']== 2){echo __('No');}elseif($medicalemotionals['childsick']== 1){ echo __('Yes');}else{echo __('Not Added Yet');
										}?>
										</p>
									</div>
									
									<h3><?=__('5. Emotional data')?></h3>
									<div class="user-info-row">
										<label><?=__('Can the child express different emotions? How does he / she express that?')?></label>
										<p>
											<?php  if($medicalemotionals['differentemotions']== 2){echo __('No');}elseif($medicalemotionals['differentemotions']== 1){ echo __('Yes');}else{echo __('Not Added Yet');
												}
											?>
										</p>
										
									</div>
									<div class="user-info-row">
										<label><?=__('fear')?></label>
										<p>
											<?php  if($medicalemotionals['anxiety']== 2){echo __('No');}elseif($medicalemotionals['anxiety']== 1){ echo __('Yes');}else{echo __('Not Added Yet');
												}
											?>
										</p>
										
									</div>
									<div class="user-info-row">
										<label><?=__('joy')?></label>
										<p>
											<?php  if($medicalemotionals['blijheid']== 2){echo __('No');}elseif($medicalemotionals['blijheid']== 1){ echo __('Yes');}else{echo __('Not Added Yet');
												}
												?>
										</p>
										
									</div>
									<div class="user-info-row">
										<label><?=__('anger')?></label>
										<p>
											<?php  if($medicalemotionals['boosheid']== 2){echo __('No');}elseif($medicalemotionals['boosheid']== 1){ echo __('Yes');}else{echo __('Not Added Yet');
												}?>
										</p>
										
									</div>
									<div class="user-info-row">
										<label><?=__('sadness')?></label>
										<p>
											<?php  if($medicalemotionals['verdriet']== 2){echo __('No');}elseif($medicalemotionals['verdriet']== 1){ echo __('Yes');}else{echo __('Not Added Yet');
												}?>
										</p>
										
									</div>
								</div>
								
							  <!-- /.tab-pane -->
								<div class="tab-pane" id="Opvoedingsgegevens">
									<h3><?=__('6. Parenting data')?></h3>
									<div class="user-info-row">
										<label><?=__('Are there things in upbringing that you regularly encounter?')?></label>
										<p>
											<?php  if($educationallanguages['upbringing']== 2){echo __('No');}elseif($educationallanguages['upbringing']== 1){ echo __('Yes');}else{echo __('Not Added Yet');}
												?>
										</p>
									</div>
									
									
									<h3><?=__('7. Language development')?> </h3>
									<div class="user-info-row">
										<label><?=__('Is your child understandable?')?></label>
										<p>
											<?php  if($educationallanguages['childunderstandable']== 2){echo __('No');}elseif($educationallanguages['childunderstandable']== 1){ echo __('Yes');}else{echo __('Not Added Yet');}?>
										</p>
									</div>
									<div class="user-info-row">
										<label><?=__('Does your child always understand what you are saying?')?></label>
										<p>
											<?php  if($educationallanguages['childalwaysunderstand']== 2){echo __('No');}elseif($educationallanguages['childalwaysunderstand']== 1){ echo __('Yes');}else{echo __('Not Added Yet');}
											?>
										</p>
										<p class="ans-added" id='childalwaysunderstand' <?php if($educationallanguages['childalwaysunderstand']=='' || $educationallanguages['childalwaysunderstand']=='2'){echo "style = 'display:none'"; }?>><?= $educationallanguages['childalwaysunderstand']?>
									   </p>
									</div>
									<div class="user-info-row">
										<label><?=__('Does your child have sufficient vocabulary?')?></label>
										<p>
											<?php  if($educationallanguages['enoughvocabulary']== 2){echo __('No');}elseif($educationallanguages['enoughvocabulary']== 1){ echo __('Yes');}else{echo __('Not Added Yet');}
											?>
										</p>
									</div>
									<div class="user-info-row">
										<label><?=__('Does your child speak easily to others?')?></label>
										<p>
											<?php  if($educationallanguages['childspeakeasily']== 2){echo __('No');}elseif($educationallanguages['childspeakeasily']== 1){ echo __('Yes');}else{echo __('Not Added Yet');}
											?>
										</p>
									</div>
									<div class="user-info-row">
										<label><?=__('Your child is stuttering')?></label>
										<p>
											<?php  if($educationallanguages['stutteryourchild']== 2){echo __('No');}elseif($educationallanguages['stutteryourchild']== 1){ echo __('Yes');}else{echo __('Not Added Yet');}?>
										</p>
									</div>
								</div>
								<!-- /.tab-pane -->
								<div class="tab-pane" id="Andereinformatie">
									<h3><?=__('8. Other information')?></h3>
									<div class="user-info-row">
										<label><?=__('Nationality child')?></label>
										<p><?=$otherinformations['nationality_child']?></p>
									</div>
									
									<div class="user-info-row">
										<label><?=__('Soc./med. Indication')?></label>
										<p><?=$otherinformations['socmed_indicatie']?></p>
									</div>
									<div class="user-info-row">
										<label><?=__('General practitioner + tel. No')?></label>
										<p><?=$otherinformations['general_practitioner']?></p>
									</div>
									<div class="user-info-row">
										<label><?=__('Dentist + tel. No')?></label>
										<p><?=$otherinformations['dentist']?></p>
									</div>
									
									
									<h3><?=__('9. BSO')?> </h3>
									<div class="user-info-row">
										<label><?=__('Does the child want to go to the BSO?')?></label>
										<p>
											<?php  if($otherinformations['wantto_gobso']== 2){echo __('No');}elseif($otherinformations['wantto_gobso']== 1){ echo __('Yes');}else{echo __('Not Added Yet');}?>
										</p>
									</div>
									<div class="user-info-row">
										<label><?=__('Does your child visit a playgroup or daycare center?')?></label>
										<p><?php  if($otherinformations['visitaplayroom']== 2){echo __('No');}elseif($otherinformations['visitaplayroom']== 1){ echo __('Yes');}else{echo __('Not Added Yet');}?></p>
									</div>
									<div class="user-info-row">
										<label><?=__('Can we look forward to a transfer form with regard to this?')?></label>
										<p>
											<?php  if($otherinformations['seeatransfer']== 2){echo __('No');
										}elseif($otherinformations['seeatransfer']== 1){
										 echo __('Yes');}
										 else{echo __('Not Added Yet');}?>
										</p>
									</div>
									
									
									<h3><?=__('10. Other questions / comments')?> </h3>
									<div class="user-info-row">
										<label><?=__('Do you have additional information about your child?')?></label>
										<p>
											<?php  if($otherinformations['additionalinformation']== 2){echo __('No');}elseif($otherinformations['additionalinformation']== 1){ echo __('Yes');}else{echo __('Not Added Yet');}?>
										</p>
										<p class="ans-added" id='additionalinformation' <?php if($otherinformations['additionalinformation']=='' || $otherinformations['additionalinformation']=='2'){echo "style = 'display:none'"; }?>><?= $otherinformations['additionalinformation']?>
									   </p>
									</div>
									<div class="user-info-row">
										<label><?=__('Are there children with whom your child plays well / likes?')?></label>
										<p>
											<?php  if($otherinformations['whomwithchild_likestoplay']== 2){echo __('No');}elseif($otherinformations['whomwithchild_likestoplay']== 1){ echo __('Yes');}else{echo __('Not Added Yet');}?>
										</p>
										<p class="ans-added" id='whomwithchild_likestoplay' <?php if($otherinformations['whomwithchild_likestoplay']=='' || $otherinformations['whomwithchild_likestoplay']=='2'){echo "style = 'display:none'"; }?>><?= $otherinformations['whomwithchild_likestoplay']?>
									   </p>
									</div>
									
									<h3>Zorg </h3>
									<div class="user-info-row">
										<label><?=__('Can the school be contacted for childcare?')?></label>
										<p>
											<?php  if($otherinformations['additionalinformation']== 2){echo __('No');}elseif($otherinformations['additionalinformation']== 1){ echo __('Yes');}else{echo __('Not Added Yet');}?>
										</p>
										<p class="ans-added" id='additionalinformation' <?php if($otherinformations['additionalinformation']=='' || $otherinformations['additionalinformation']=='2'){echo "style = 'display:none'"; }?>><?= $otherinformations['additionalinformation']?>
									   </p>
									</div>
									<h3><?=__('12. What do parents expect from BSO Bolderburen?')?></h3>
									<p class="ans-added" id='parentsexpect' <?php if($otherinformations['parentsexpect']=='' || $otherinformations['parentsexpect']=='2'){echo "style = 'display:none'"; }?>><?= $otherinformations['parentsexpect']?>
									   </p>
								</div>
								
							</div>
							<!-- /.tab-content -->
						 
					  
					</div>
					</div>
				<!-- /.box-body -->
			  </div>
			  <!-- /.box -->
			  
			  <div class="text-right">
				<!-- <button class="btn btn-theme btn-round-md"><?php //('Next')?></button> -->
			  </div>
			</div>
		</div>	
		

    </section>
    <!-- /.content -->
  </div>