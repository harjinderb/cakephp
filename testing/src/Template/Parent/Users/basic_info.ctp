<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Child Basic Info</h2>
		</div>
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<div class="row">
							<div class="col-sm-3">
								<h2>
									Child Details
								</h2>

							</div>
							<div class="col-sm-3 errormsg" style="color:red;">  </div>
							<div class="col-sm-6 text-right">
								<a href="children.php" class="btn bg-blue-grey"> Go to child list</a>
							</div>
						</div>
					</div>
					<div class="body">
						<div class="form-common">
							<div class="other-info-form">
								<div class="row">
									<div class="col-sm-3">
										<ul class="nav nav-tabs" id="credit">
											<li class="active"><a data-toggle="tab" href="#Persoonsgegevens">Persoonsgegevens </a></li>
											<li><a data-toggle="tab" href="#gedragsociaal">Gedrag en Sociaal</a></li>
											<li><a data-toggle="tab" href="#medischemotioneel">Medisch en Emotioneel</a></li>
											<li><a data-toggle="tab" href="#Opvoedingsgegevens ">Opvoedingsgegevens </a></li>
											<li><a data-toggle="tab" href="#Andereinformatie">Andere informatie </a></li>
										</ul>
									</div>
									
									<div class="col-sm-9">
										<div class="tab-content">
											<div id="Persoonsgegevens" class="tab-pane fade in active">
												<?php 
												//pr($recption);die;
												echo $this->Form->create($recption, ['name'=>'personal', 'class'=>'basicinfo', 'type'=>'file']); ?>
												<h3>1. Persoonsgegevens </h3>
												<div class="form-group">
													<label>Datum intake *</label>
													<?= $this->Form->control('ingestion_date',['label' => false, 'class' => 'datepicker form-control', 'placeholder' => 'Datum intake','requied'=> true,'value'=>$this->Decryption->mc_decrypt($recption[0]['ingestion_date'],$user['encryptionkey'])]);?>
												</div>
												<div class="form-group">
													<p><b>Gezinssamenstelling</b></p>
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
																<label>Name</label>
																<?= $this->Form->control('name[]',   ['name'=>'data['.$key.'][name]', 'label' => false, 'class' => 'form-control', 'placeholder' => ' Name','value'=> $this->Decryption->mc_decrypt($value['firstname'],$value['encryptionkey']).' '.$this->Decryption->mc_decrypt($value['lastname'],$value['encryptionkey'])]); ?>
																<?= $this->Form->hidden('ids[]',   ['value'=> $id]); ?>
																
															</div>

														<?php 	}else{ 
															?>
															<div class="form-group">
																<label>Name</label>
																<?= $this->Form->control('name[]',   ['name'=>'data['.$key.'][name]', 'label' => false, 'class' => 'form-control', 'placeholder' => ' Name']); ?>
																<?= $this->Form->hidden('ids[]',   ['value'=> $id]); ?>
																
															</div>
														<?php } ?>
														</div>
														<div class="col-sm-6">
															<div class="form-group">
																<label>Relation with child *</label>
																<?= $this->Form->input('relation1[]', array('name'=>'data['.$key.'][relation1]', 'type'=>'select','label'=>false, 'class'=>'form-control show-tick serviceday', 'options'=>DEFAULTRELATIONS,'value'=> $getresponse)); ?>
										
															</div>
															</div>
															<?php if($getresponse == '3'){ ?>
															<div class="col-sm-12">
															<div class="form-group showrelation <?php echo $getresponse =='3' ? 'Show': 'hide' ?>">
																<label>Please specify relation with child *</label>
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
																<label>Name</label>
																<?= $this->Form->control('name[]',   ['name'=>'data['.$key.'][name]', 'label' => false, 'class' => 'form-control', 'placeholder' => ' Name','value'=> $this->Decryption->mc_decrypt($value['firstname'],$value['encryptionkey']).' '.$this->Decryption->mc_decrypt($value['lastname'],$value['encryptionkey'])]); ?>
																<?= $this->Form->hidden('ids[]',   ['value'=> $id]); ?>
																
															</div>

														<?php 	}else{ 
															?>
															<div class="form-group">
																<label>Name</label>
																<?= $this->Form->control('name[]',   ['name'=>'data['.$key.'][name]', 'label' => false, 'class' => 'form-control', 'placeholder' => ' Name']); ?>
																<?= $this->Form->hidden('ids[]',   ['value'=> $id]); ?>
																
															</div>
														<?php } ?>
														</div>
														<div class="col-sm-6">
															<div class="form-group">
																<label>Relation with child *</label>
																<?= $this->Form->input('relation1[]', array('type'=>'select','label'=>false, 'class'=>'form-control show-tick serviceday', 'options'=>DEFAULTRELATIONS,'value'=> $getresponse)); ?>
										
															</div>
															</div>
															<?php if($getresponse == '3'){ ?>
															<div class="col-sm-12">
															<div class="form-group showrelation">
																<label>Please specify relation with child *</label>
																<?= $this->Form->control('relation[]',   ['label' => false, 'class' => 'form-control', 'placeholder' => 'Relation with child', 'value'=> $relationset]); ?>
															</div>
															</div>
														<?php }?>
															</div>
														<?php }
														?>
													<div id="view1"></div>
													<div class="form-group text-right">
														<a href="javascript:void(0)" class="btn bg-teal" data-attr="<?= count($guardian) ?>" id="click1">Add More</a>
													</div>
													<div class="form-group">
														<label>Extra telefoonnummer(s) i.v.m. afwezigheid</label>
														<span id="errmsg" style="color:red;"></span>
														<?= $this->Form->control('mobile_no', ['label' => false, 'class' => 'form-control', 'placeholder' => 'xxxxxxxxxx','value'=> $this->Decryption->mc_decrypt($recption[0]['mobile_no'],$user['encryptionkey'])]);?>

														
													</div>
												</div>
												<div class="form-group">
													<p><b>Opvang op de volgende dagen</b></p>
													<?php 
													//pr($recption);die;
													if(!empty($recption[0])){
														//pr($recption[0]);die;
														foreach ($recption as $key => $value1) {
															//pr($value1);die;														
														?>
													<div class="row">
														<div class="col-sm-6">
															<div class="form-group">
																<label>Opvang</label>
																<?= $this->Form->control('reception[]',   ['label' => false, 'class' => 'form-control reception','value'=>$this->Decryption->mc_decrypt($value1['reception'],$user['encryptionkey']) ]);?>																</div>
														</div>
														<div class="col-sm-6">
															<label>Date *</label>
															<?= $this->Form->control('reception_date[]',['label' => false, 'class' => ' form-control receptiondate' , 'placeholder' => 'Datum intake', 'value' => $this->Decryption->mc_decrypt( $value1['reception_date'],$user['encryptionkey'])]);?>
														</div>
													</div>
												<?php 
												}
											}else{?>
												
													<div class="row">
														<div class="col-sm-6">
															<div class="form-group">
																<label>Opvang</label>
																<?= $this->Form->control('reception[]',   ['label' => false, 'class' => 'form-control reception']);?>																</div>
														</div>
														<div class="col-sm-6">
															<label>Date *</label>
															<?= $this->Form->control('reception_date[]',['label' => false, 'class' => 'datepicker form-control receptiondate' , 'placeholder' => 'Datum intake']);?>
														</div>
													</div>

												<?php } ?>
													<!--  -->
													<div id="view2"></div>
													<div class="form-group text-right">
														<a href="javascript:void(0)" class="btn bg-teal" id="click2">Add More</a>
													</div>
												</div>
												
												 <div class="form-group text-right m-t-20">
												<div class="cs-btn-group">
												
												<?= $this->Form->button('Next',['class' => 'btn btn-lg btnNext bg-teal']);
												?>
												
												</div>
												</div>
												<?php echo $this->Form->end(); ?>	
											</div>
											<!-----2start------>
											<div id="gedragsociaal" class="tab-pane fade">
												<?php echo $this->Form->create($behaviorandSocial, ['name'=>'social', 'class'=>'basicinfo', 'type'=>'file']); ?>
												<h3>2. Speelwerkgedrag </h3>
												<div class="form-group">
													<div class="row">
														<div class="col-sm-6">
															<label><b>Zijn er dingen die uw kind graag doet? Zo ja,wat?</b></label>
														</div>
														<div class="col-sm-4">
														<input name="group5" id="radio_48" class="with-gap radio-col-blue-grey" type="radio" value="1" 
														<?php  if($behaviorandSocial['childlike']!== null){echo "checked";}?>> 
														<label for="radio_48">ja</label>
														<input name="group5" id="radio_49" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($behaviorandSocial['childlike']=='2' ? 'checked' : '');?>> 
														<label for="radio_49">nee</label>
														</div>
													<div class="col-sm-12" id='childlike' <?php if($behaviorandSocial['childlike']=='' || $behaviorandSocial['childlike']=='2'){echo "style = 'display:none'"; }?>>
														<label>Geef alstublieft aan</label>
														<?= $this->Form->control('childlike',   ['label' => false, 'class' => 'form-control', 'placeholder' => 'Geef alstublieft aan']);?>
														
													</div>
													</div>
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b>Waar speelt uw kind het liefst?</b></label>
													</div>
													<div class="col-sm-4">
													<input name="childprefer" id="radio_50" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($behaviorandSocial['childprefer']=='1' ? 'checked' : '');?>> 
													<label for="radio_50">Binnen</label>
													<input name="childprefer" id="radio_51" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($behaviorandSocial['childprefer']=='2' ? 'checked' : '');?>> 
													<label for="radio_51">buiten</label>
													</div>
												</div>
													
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b>Kan uw kind gericht en langere tijd met iets bezig zijn?</b></label>
													</div>
													<div class="col-sm-4">
													<input name="allergy" id="radio_52" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php if($behaviorandSocial['childbusy']!== null){echo "checked";}?>> 
													<label for="radio_52">ja</label>
													<input name="allergy" id="radio_53" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($behaviorandSocial['childbusy']=='2' ? 'checked' : '');?>> 
													<label for="radio_53">nee</label>
													</div>
													<div class="col-sm-12" id='childbusy' <?php if($behaviorandSocial['childlike']=='' || $behaviorandSocial['childlike']=='2'){echo "style = 'display:none'"; }?>>
													<label>Geef alstublieft aan</label>
													<?= $this->Form->control('childbusy',   ['label' => false, 'class' => 'form-control', 'placeholder' => 'Geef alstublieft aan']);?>
													
													</div>
												</div>
													
													
												</div>
												<h3>3. Sociale gegevens </h3>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b>Heeft het kind belangstelling voor anderen kinderen</b></label>
													</div>
													<div class="col-sm-4">
													<input name="childinterest_otherchildern" id="radio_54" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($behaviorandSocial['childinterest_otherchildern']=='1' ? 'checked' : '');?>> 
													<label for="radio_54">ja</label>
													<input name="childinterest_otherchildern" id="radio_55" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($behaviorandSocial['childinterest_otherchildern']=='2' ? 'checked' : '');?>> 
													<label for="radio_55">nee</label>
													</div>
												</div>
													
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b>Gaat het kind op een prettige manier met leeftijdsgenoten om?</b></label>
													</div>
													<div class="col-sm-4">
													<input name="childhappypeers" id="radio_56" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($behaviorandSocial['childhappypeers']=='1' ? 'checked' : '');?>> 
													<label for="radio_56">ja</label>
													<input name="childhappypeers" id="radio_57" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($behaviorandSocial['childhappypeers']=='2' ? 'checked' : '');?>> 
													<label for="radio_57">nee</label>
													</div>
												</div>
													
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b>Heeft het kind vriendjes/ vriendinnetjes ?</b></label>
													</div>
													<div class="col-sm-4">
													<input name="childhavebfgif" id="radio_58" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($behaviorandSocial['childhavebfgif']=='1' ? 'checked' : '');?>> 
													<label for="radio_58">ja</label>
													<input name="childhavebfgif" id="radio_59" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($behaviorandSocial['childhavebfgif']=='2' ? 'checked' : '');?>> 
													<label for="radio_59">nee</label>
													</div>
												</div>
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b>Gaat het kind op een prettige manier met broertjes en zusjes om?</b></label>
													</div>
													<div class="col-sm-4">
													<input name="childhappybrothersis" id="radio_60" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($behaviorandSocial['childhappybrothersis']=='1' ? 'checked' : '');?>> 
													<label for="radio_60">ja</label>
													<input name="childhappybrothersis" id="radio_61" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($behaviorandSocial['childhappybrothersis']=='2' ? 'checked' : '');?>> 
													<label for="radio_61">nee</label>
													</div>
												</div>
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b>Gaat het kind op een prettige manier met de ouder(s) / verzorger(s) om?</b></label>
													</div>
													<div class="col-sm-4">
													<input name="childhappyparent" id="radio_62" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($behaviorandSocial['childhappyparent']=='1' ? 'checked' : '');?>> 
													<label for="radio_62">ja</label>
													<input name="childhappyparent" id="radio_63" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($behaviorandSocial['childhappyparent']=='2' ? 'checked' : '');?>> 
													<label for="radio_63">nee</label>
													</div>
												</div>
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b>Kan het kind zich in een ander verplaatsen?</b></label>
													</div>
													<div class="col-sm-4">
													<input name="childmove" id="radio_64" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($behaviorandSocial['childmove']=='1' ? 'checked' : '');?>> 
													<label for="radio_64">ja</label>
													<input name="childmove" id="radio_65" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($behaviorandSocial['childmove']=='2' ? 'checked' : '');?>> 
													<label for="radio_65">nee</label>
													</div>
												</div>
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b>Heeft het kind vaak ruzie met anderen? Zo ja, wat is daar de (mogelijke) oorzaak van en hoe lost hij/zij dit op</b></label>
													</div>
													<div class="col-sm-4">
													<input name="argue" id="radio_66" class="with-gap radio-col-blue-grey" type="radio" value="1"  <?php if($behaviorandSocial['childargue']!== null){echo "checked";}?>> 
													<label for="radio_66">ja</label>
													<input name="argue" id="radio_67" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($behaviorandSocial['childargue']=='2' ? 'checked' : '');?>> 
													<label for="radio_67">nee</label>
													</div>
													<div class="col-sm-12" id='childargue' <?php if($behaviorandSocial['childargue']=='' || $behaviorandSocial['childargue']=='2'){echo "style = 'display:none'"; }?>>
													<label>Geef alstublieft aan</label>
													<?= $this->Form->control('childargue',   ['label' => false, 'class' => 'form-control', 'placeholder' => 'Geef alstublieft aan']);?>
													<?= $this->Form->hidden('child_id',   ['value'=> $child_id]); ?>
													</div>
												</div>
													
													
												</div>
												<div class="form-group text-right m-t-20">
												<div class="cs-btn-group">
												<?= $this->Form->button('Previous',['class' => 'btn btn-lg btnPrevious bg-orange']);
												?>	
												<?= $this->Form->button('Next',['class' => 'btn btn-lg btnNext bg-teal']);
												?>
												
												</div>
												<?php echo $this->Form->end(); ?>
												</div>
											</div>
											<!-----3start------>
											<div id="medischemotioneel" class="tab-pane fade">
											<?php echo $this->Form->create($medicalemotionals, ['name'=>'medical', 'class'=>'basicinfo', 'type'=>'file']); ?>
												<h3>4. Medische gegevens </h3>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b>Is er sprake van bijzondere ziekten? Zo ja, wat moet de BSO daarvan weten?</b></label>
													</div>
													<div class="col-sm-4">
													<input name="group15" id="radio_70" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php if($medicalemotionals['specialdiseases']!= ''){echo "checked";}?>> 
													<label for="radio_70">ja</label>
													<input name="group15" id="radio_71" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($medicalemotionals['specialdiseases']=='2' ? 'checked' : '');?>> 
													<label for="radio_71">nee</label>
													</div>
													<div class="col-sm-12" id='specialdiseases' <?php if($medicalemotionals['specialdiseases']=='' || $medicalemotionals['specialdiseases']=='2'){echo "style = 'display:none'"; }?>>
													<label>Geef alstublieft aan</label>
													<?= $this->Form->control('specialdiseases',   ['label' => false, 'class' => 'form-control', 'placeholder' => 'Geef alstublieft aan']);?>
													
													</div>
												</div>
													
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b>Is er sprake van allergieën? Zo ja welke, en op welke manier moet de BSO daar rekening mee houden?</b></label>
													</div>
													<div class="col-sm-4">
													<input name="group16" id="radio_72" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php if($medicalemotionals['allergies']!= ''){echo "checked";}?> > 
													<label for="radio_72">ja</label>
													<input name="group16" id="radio_73" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($medicalemotionals['allergies']=='2' ? 'checked' : '');?>> 
													<label for="radio_73">nee</label>
													</div>
													<div class="col-sm-12" id='allergies' <?php if($medicalemotionals['allergies']=='' ||$medicalemotionals['allergies']=='2'){echo "style = 'display:none'"; }?>>
													<label>Geef alstublieft aan</label>
													<?= $this->Form->control('allergies',   ['label' => false, 'class' => 'form-control', 'placeholder' => 'Geef alstublieft aan']);?>
													
													</div>	
												</div>
													
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b>Zijn er problemen met de functie van de zintuigen?</b></label>
													</div>
													<div class="col-sm-4">
													<input name="group17" id="radio_74" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php if($medicalemotionals['senses']!= ''){echo "checked";}?>> 
													<label for="radio_74">ja</label>
													<input name="group17" id="radio_75" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($medicalemotionals['senses']=='2' ? 'checked' : '');?>> 
													<label for="radio_75">nee</label>
													</div>
													<div class="col-sm-12" id='senses' <?php if($medicalemotionals['senses']=='' || $medicalemotionals['senses']=='2'){echo "style = 'display:none'"; }?>>
													<label>Geef alstublieft aan</label>
													<?= $this->Form->control('senses',   ['label' => false, 'class' => 'form-control', 'placeholder' => 'Geef alstublieft aan']);?>
													
													</div>	
												</div>
													
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b>Is de motorische ontwikkeling normaal verlopen?</b></label>
													</div>
													<div class="col-sm-4">
													<input name="motordevelopment" id="radio_76" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($medicalemotionals['motordevelopment']=='1' ? 'checked' : '');?>> 
													<label for="radio_76">ja</label>
													<input name="motordevelopment" id="radio_77" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($medicalemotionals['motordevelopment']=='2' ? 'checked' : '');?>> 
													<label for="radio_77">nee</label>
													</div>
												</div>
											
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b>Is uw kind zindelijk?</b></label>
													</div>
													<div class="col-sm-4">
													<input name="childsick" id="radio_78" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($medicalemotionals['childsick']=='1' ? 'checked' : '');?>> 
													<label for="radio_78">ja</label>
													<input name="childsick" id="radio_79" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($medicalemotionals['childsick']=='2' ? 'checked' : '');?>> 
													<label for="radio_79">nee</label>
													</div>
												</div>
													
													
												</div>
												<h3>5. Emotionele gegevens </h3>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b>Kan het kind verschillende emoties uiten? Hoe uit hij/zij dat?</b></label>
													</div>
													<div class="col-sm-4">
													<input name="differentemotions" id="radio_80" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($medicalemotionals['differentemotions']=='1' ? 'checked' : '');?>> 
													<label for="radio_80">ja</label>
													<input name="differentemotions" id="radio_81" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($medicalemotionals['differentemotions']=='2' ? 'checked' : '');?>> 
													<label for="radio_81">nee</label>
													</div>
												</div>
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b>angst</b></label>
													</div>
													<div class="col-sm-4">
													<input name="anxiety" id="radio_82" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($medicalemotionals['anxiety']=='1' ? 'checked' : '');?>> 
													<label for="radio_82">ja</label>
													<input name="anxiety" id="radio_83" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($medicalemotionals['anxiety']=='2' ? 'checked' : '');?>> 
													<label for="radio_83">nee</label>
													</div>
												</div>
													
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b>blijheid</b></label>
													</div>
													<div class="col-sm-4">
													<input name="blijheid" id="radio_84" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($medicalemotionals['blijheid']=='1' ? 'checked' : '');?>> 
													<label for="radio_84">ja</label>
													<input name="blijheid" id="radio_85" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($medicalemotionals['blijheid']=='2' ? 'checked' : '');?>> 
													<label for="radio_85">nee</label>
													</div>
												</div>
												
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b>boosheid</b></label>
													</div>
													<div class="col-sm-4">
													<input name="boosheid" id="radio_86" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($medicalemotionals['boosheid']=='1' ? 'checked' : '');?>> 
													<label for="radio_86">ja</label>
													<input name="boosheid" id="radio_87" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($medicalemotionals['boosheid']=='2' ? 'checked' : '');?>> 
													<label for="radio_87">nee</label>
													</div>
												</div>
													
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b>verdriet</b></label>
													</div>
													<div class="col-sm-4">
													<input name="verdriet" id="radio_88" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($medicalemotionals['verdriet']=='1' ? 'checked' : '');?>> 
													<label for="radio_88">ja</label>
													<input name="verdriet" id="radio_89" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($medicalemotionals['verdriet']=='2' ? 'checked' : '');?>> 
													<label for="radio_89">nee</label>
													</div>
													<?= $this->Form->hidden('child_id',   ['value'=> $child_id]); ?>
												</div>
													
													
												</div>
												<div class="form-group text-right m-t-20">
												<div class="cs-btn-group">
												<?= $this->Form->button('Previous',['class' => 'btn btn-lg btnPrevious bg-orange']);
												?>	
												<?= $this->Form->button('Next',['class' => 'btn btn-lg btnNext bg-teal']);
												?>
												
												</div>
												<?php echo $this->Form->end(); ?>
												</div>
											</div>
											<!-----4start------>
											<div id="Opvoedingsgegevens" class="tab-pane fade">
												<?php echo $this->Form->create($educationallanguages, ['name'=>'medical', 'class'=>'basicinfo', 'type'=>'file']); ?>
												<h3>6. Opvoedingsgegevens </h3>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b>Zijn er dingen in de opvoeding waar u regelmatig tegen aanloopt?</b></label>
													</div>
													<div class="col-sm-4">
													<input name="upbringing" id="radio_90" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($educationallanguages['upbringing']=='1' ? 'checked' : '');?>> 
													<label for="radio_90">ja</label>
													<input name="upbringing" id="radio_91" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($educationallanguages['upbringing']=='2' ? 'checked' : '');?>> 
													<label for="radio_91">nee</label>
													</div>
												</div>
												
													
												</div>
												<h3>7. Taalontwikkeling </h3>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b>Is uw kind verstaanbaar?</b></label>
													</div>
													<div class="col-sm-4">
													<input name="childunderstandable" id="radio_92" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($educationallanguages['childunderstandable']=='1' ? 'checked' : '');?>> 
													<label for="radio_92">ja</label>
													<input name="childunderstandable" id="radio_93" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($educationallanguages['childunderstandable']=='2' ? 'checked' : '');?>> 
													<label for="radio_93">nee</label>
													</div>
												</div>
													
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b>Begrijpt uw kind steeds wat u zegt?</b></label>
													</div>
													<div class="col-sm-4">
													<input name="group23" id="radio_94" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php if($educationallanguages['childalwaysunderstand']!== null){echo "checked";}?>> 
													<label for="radio_94">ja</label>
													<input name="group23" id="radio_95" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($educationallanguages['childalwaysunderstand']=='2' ? 'checked' : '');?>> 
													<label for="radio_95">nee</label>
													</div>
													<div class="col-sm-12" id='childalwaysunderstand' <?php if($educationallanguages['childalwaysunderstand']=='' || $educationallanguages['childalwaysunderstand']=='2'){echo "style = 'display:none'"; }?>>
													<label>Geef alstublieft aan</label>
													<?= $this->Form->control('childalwaysunderstand',   ['label' => false, 'class' => 'form-control', 'placeholder' => 'Geef alstublieft aan']);?>
													
													</div>	
												</div>
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b>Heeft uw kind een voldoende woordenschat?</b></label>
													</div>
													<div class="col-sm-4">
														<input name="enoughvocabulary" id="radio_96" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($educationallanguages['enoughvocabulary']=='1' ? 'checked' : '');?>> 
														<label for="radio_96">ja</label>
														<input name="enoughvocabulary" id="radio_97" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($educationallanguages['enoughvocabulary']=='2' ? 'checked' : '');?>> 
														<label for="radio_97">nee</label>
													</div>
												</div>
													
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b>Spreekt uw kind makkelijk met anderen?</b></label>
													</div>
													<div class="col-sm-4">
													
													<input name="childspeakeasily" id="radio_98" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($educationallanguages['childspeakeasily']=='1' ? 'checked' : '');?>> 
													<label for="radio_98">ja</label>
													<input name="childspeakeasily" id="radio_99" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($educationallanguages['childspeakeasily']=='2' ? 'checked' : '');?>> 
													<label for="radio_99">nee</label>
													</div>
												</div>
													
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
														<label><b>Stottert uw kind</b></label>
													</div>
													<div class="col-sm-4">
														<input name="stutteryourchild" id="radio_100" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($educationallanguages['stutteryourchild']=='1' ? 'checked' : '');?>> 
														<label for="radio_100">ja</label>
														<input name="stutteryourchild" id="radio_101" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($educationallanguages['stutteryourchild']=='2' ? 'checked' : '');?>> 
														<label for="radio_101">nee</label>
													</div>
													<?= $this->Form->hidden('child_id',   ['value'=> $child_id]); ?>
												</div>
													
													
												</div>
												<div class="form-group text-right m-t-20">
												<div class="cs-btn-group">
												<?= $this->Form->button('Previous',['class' => 'btn btn-lg btnPrevious bg-orange']);
												?>	
												<?= $this->Form->button('Next',['class' => 'btn btn-lg btnNext bg-teal']);
												?>
												
												</div>
												<?php echo $this->Form->end(); ?>
												</div>
											</div>
											<!-----5start------>
											<div id="Andereinformatie" class="tab-pane fade">
												<?php echo $this->Form->create($otherinformations, ['name'=>'medical', 'class'=>'basicinfo', 'type'=>'file']); ?>
												<h3>8. Overige gegevens </h3>
												<div class="row">
													<div class="col-sm-6">
														<div class="form-group">
															<label>Nationaliteit kind</label>
															
															<?= $this->Form->control('nationality_child',   ['label' => false, 'class' => 'form-control', 'placeholder' => ' Nationality child']); ?>
														</div>
													</div>
													<div class="col-sm-6">
														<div class="form-group">
															<label>Soc./med. Indicatie</label>
															
															<?= $this->Form->control('socmed_indicatie',   ['label' => false, 'class' => 'form-control', 'placeholder' => ' Soc./med. Indicatie']); ?>
														</div>
													</div>
													
												</div>
												<div class="row">
													<div class="col-sm-6">
														<div class="form-group">
															<label>Huisarts + tel.nr</b></label>
															
															<?= $this->Form->control('general_practitioner',   ['label' => false, 'class' => 'form-control', 'placeholder' => 'Huisarts + tel.nr']); ?>
														</div>
													</div>
													<div class="col-sm-6">
														<div class="form-group">
															<label>Tandarts + tel. nr</label>
															
															<?= $this->Form->control('dentist',   ['label' => false, 'class' => 'form-control', 'placeholder' => 'Huisarts + tel.nr']); ?>
														</div>
													</div>
													
												</div>
												
												
												<h3>9. BSO </h3>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
														<label><b>Heeft het kind zin om naar de BSO te gaan?</b></label>
													</div>
													<div class="col-sm-4">
														<input name="wantto_gobso" id="radio_1" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($otherinformations['wantto_gobso']=='1' ? 'checked' : '');?>> 
														<label for="radio_1">ja</label>
														<input name="wantto_gobso" id="radio_2" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($otherinformations['wantto_gobso']=='2' ? 'checked' : '');?>> 
														<label for="radio_2">nee</label>
													</div>
												</div>
													
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
														<label><b>Bezoekt uw kind een peuterspeelzaal of kinderdagverblijf?</b></label>
													</div>
													<div class="col-sm-4">
														<input name="visitaplayroom" id="radio_3" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($otherinformations['visitaplayroom']=='1' ? 'checked' : '');?>> 
														<label for="radio_3">ja</label>
														<input name="visitaplayroom" id="radio_4" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($otherinformations['visitaplayroom']=='2' ? 'checked' : '');?>> 
														<label for="radio_4">nee</label>
													</div>
												</div>
													<br>
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
														<label><b>Kunnen wij t.z.t. een overdrachtsformulier tegemoet zien?</b></label>
													</div>
													<div class="col-sm-4">
														<input name="seeatransfer" id="radio_5" class="with-gap radio-col-blue-grey" type="radio" value="1" <?php echo ($otherinformations['seeatransfer']=='1' ? 'checked' : '');?>> 
														<label for="radio_5">ja</label>
														<input name="seeatransfer" id="radio_6" class="with-gap radio-col-blue-grey" type="radio" value="2" <?php echo ($otherinformations['seeatransfer']=='2' ? 'checked' : '');?>> 
														<label for="radio_6">nee</label>
													</div>
												</div>
													
													
												</div>
												<h3>10. Overige vragen/opmerkingen </h3>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
														<label><b>Hebt u nog aanvullende gegevens over uw kind?</b></label>
													</div>
													<div class="col-sm-4">
														<input name="group29" id="radio_7" class="with-gap radio-col-blue-grey" type="radio" <?php if($otherinformations['additionalinformation']!== null){echo "checked";}?>> 
														<label for="radio_7">ja</label>
														<input name="group29" id="radio_8" class="with-gap radio-col-blue-grey" type="radio" <?php echo ($otherinformations['additionalinformation']=='2' ? 'checked' : '');?>> 
														<label for="radio_8">nee</label>
													</div>
													<div class="col-sm-12" id='additionalinformation' <?php if($otherinformations['additionalinformation']=='' || $otherinformations['additionalinformation']=='2'){echo "style = 'display:none'"; }?>>
													<label>Geef alstublieft aan</label>
													<?= $this->Form->control('additionalinformation',   ['label' => false, 'class' => 'form-control', 'placeholder' => 'Geef alstublieft aan']);?>
													
													</div>
												</div>
													
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label><b>Zijn er kinderen met wie uw kind goed/graag speelt?</b></label>
													</div>
													<div class="col-sm-4">
														<input name="group30" id="radio_9" class="with-gap radio-col-blue-grey" type="radio"<?php if($otherinformations['whomwithchild_likestoplay']!== null){echo "checked";}?>> 
														<label for="radio_9">ja</label>
														<input name="group30" id="radio_10" class="with-gap radio-col-blue-grey" type="radio" <?php echo ($otherinformations['whomwithchild_likestoplay']=='2' ? 'checked' : '');?>> 
														<label for="radio_10">nee</label>
													</div>
													<div class="col-sm-12" id='whomwithchild_likestoplay' <?php if($otherinformations['additionalinformation']=='' || $otherinformations['additionalinformation']=='2'){echo "style = 'display:none'"; }?>>
													<label>Geef alstublieft aan</label>
													<?= $this->Form->control('whomwithchild_likestoplay',   ['label' => false, 'class' => 'form-control', 'placeholder' => 'Geef alstublieft aan']);?>
													
													</div>
												</div>
													
												</div>
												<h3>11. Zorg </h3>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
														<label><b>Bij zorg om het kind mag contact opgenomen worden met school?</b></label>
													</div>
													<div class="col-sm-4"> 
														<input name="group31" id="radio_11" class="with-gap radio-col-blue-grey" type="radio"<?php if($otherinformations['contactwithschool']!== null){echo "checked";}?>> 
														<label for="radio_11">ja</label>
														<input name="group31" id="radio_12" class="with-gap radio-col-blue-grey" type="radio" <?php echo ($otherinformations['contactwithschool']=='2' ? 'checked' : '');?>> 
														<label for="radio_12">nee</label>
													</div>
													<div class="col-sm-12" id='contactwithschool' <?php if($otherinformations['contactwithschool']=='' || $otherinformations['contactwithschool']=='2'){echo "style = 'display:none'"; }?>>
													<label>Geef alstublieft aan</label>
													<?= $this->Form->control('contactwithschool',   ['label' => false, 'class' => 'form-control', 'placeholder' => 'Geef alstublieft aan']);?>
													
													</div>
												</div>
													
													
												</div>
												<h3>12. Wat verwachten ouders van BSO Bolderburen? </h3>
												<div class="form-group">
														<?= $this->Form->control('parentsexpect',   ['type'=>'textarea','label' => false, 'class' => 'form-control', 'placeholder' => 'Geef alstublieft aan']);?>
														<?= $this->Form->hidden('child_id',   ['value'=> $child_id]); ?>
												</div>
												<div class="form-group text-right m-t-20">
												<div class="cs-btn-group">
												<?= $this->Form->button('Previous',['class' => 'btn btn-lg btnPrevious bg-orange']);
												?>	
												<?= $this->Form->button('Save',['class' => 'btn btn-lg btnNext bg-teal']);
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