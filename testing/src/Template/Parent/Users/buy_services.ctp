<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Services</h2>
		</div>
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<div class="row">
							<div class="col-sm-2">		
								<h2>Services List</h2>
								<?= $this->Flash->render() ?>
							</div>	
							<div class="col-sm-10">
								<?= $this->Form->create('Searchservices',['type'=>'get', 'url' => ['controller'=>'Users', 'action' => 'buyServices'],
								]) ?>		
								<!-- <div class="col-sm-4">
									<div class="col-sm-3">
											
											<label>Min Age*</label>
											</div>
											<div class="col-sm-3">	

									
								
								
																	
									<?php // $this->Form->input('min_age', array('type'=>'text','label'=>false, 'class'=>'form-control show-tick')); ?>
							
								
									<?php
									/*$this->Form->select('servicefor',SERVICE_FOR,['multiple' => false,'value' => [],'label' => false, 'class' => 'form-control show-tick']);
									*/
									?>	
										</div>
									<div class="col-sm-3">
											
											<label>Max Age*</label>
											</div>
											<div class="col-sm-3">	

									
								
								
																	
									<?php// $this->Form->input('max_age', array('type'=>'text','label'=>false, 'class'=>'form-control show-tick')); ?>
							
								
									<?php
									/*$this->Form->select('servicefor',SERVICE_FOR,['multiple' => false,'value' => [],'label' => false, 'class' => 'form-control show-tick']);
									*/
									?>	
										</div>
											

								</div> -->
								<div class="col-sm-6">
									<div class="col-sm-3">
										<label>Start Time </label>	
										</div>
										<div class="col-sm-3">										
										<?= $this->Form->control('start_time',['type'=>'text','id'=>'date-start','label' => false, 'class' => 'timepicker form-control', 'placeholder' => 'Start Time']); ?>									
									</div>
									<div class="col-sm-3">
											<label>End Time </label>
										</div>
											<div class="col-sm-3">
										<?= $this->Form->control('end_time',['type'=>'text','label' => false, 'id'=> 'date-end','class' => 'timepicker form-control', 'placeholder' => 'End Time']); ?>
									</div>
								</div>
								<div class="col-sm-2">
								<?= $this->Form->button(__('Search'),['label' => false,'class' => 'btn bg-blue-grey search-btn']) ?>
								</div>
                            	<?= $this->Form->end() ?>
	
							</div>
						</div>		
					</div>
					<div class="body course-listing-wrap">
						<div class="row">
							
							<?= $this->Form->create('Buyservices',['type'=>'post', 'url' => ['controller'=>'Users', 'action' => 'buyPlan'],]) ?>	
							<?php 
								//pr($Contracts);die;
								foreach ($bsos as $key => $value) {
									//pr($value);die;
									$data = explode(',', $value['add_teacher']);
									 
									//pr($value['id']); die;
									// if (in_array($value['id'], $Contracts)) {
   						// 			$class="plan-head bg-deep-orange";
									//  	$button="btn bg-deep-orange";
									//  	$booked= "booked-plan";
									//  }
									//  else
									$booked='';
									if($value['service_type']== 'voorschoolse'){
										$class="plan-head bg-teal";
										$button="btn bg-teal";
										$booked= "";
										}elseif ($value['service_type']== 'tussenschoolse') {
											$class="plan-head bg-light-blue";
											$button="btn bg-light-blue";
											$booked= "";
										}else{
											$class="plan-head bg-cyan";
											$button="btn bg-cyan";
											$booked= "";
										}
									
								?>

							<div class="col-md-3 col-sm-4">
								<div class="single-plan">
									
									
									<div class="<?=$class;?>"> 
										<h1 class="plan-name">
											<?= $value['service_type'];?>
										</h1>
										<h3 class="plan-day">
											<?= $value['service_day'];?>
										</h3>
										<h6  class="<?= $booked;?>">
										<?php 
											// if (in_array($value['id'], $Contracts)) {
	   							// 			echo (__('Booked')); 
											// }
											 ?>
											
											</h6>
										
									</div>
									<div class="plan-info">
										<?php 
											$stime = explode(",", $value->start_time);
										 	$etime = explode(",", $value->end_time);
										 	$age_group = AGEGROUPSHOW;
										?> 
										<ul>
											<li><span><b>Start Time :</b></span> <span class="plan-val"><?= date("H:i:s", strtotime($value['start_time']));?></span></li>
											<li><span><b>End Time :</b></span> <span class="plan-val"><?= date("H:i:s", strtotime($value['end_time']));?></span></li>
											<li><span><b>Age Group</b></span> <span class="plan-val"></span><br/>
												<span><b>Min Age:</b></span> <span class="plan-val"><?= $value['min_age'];?></span>
												<span><b>Max Age:</b></span> <span class="plan-val"><?= $value['max_age'];?></span>
											</li>
											<li>
												<span><b>No Of Teachers Allotted:</b></span> <span class="plan-val"><?= count($data);?></span>
											</li>

											<li class="plan-divider">Price:</li>
											<?php if(!empty($value['price_weekly'])){?>
											<li class="price-info">€ <?= $value['price_weekly'];?> <span class="price-type">/Per-Day</span></li>
											<?php } ?>
											<?php if(!empty($value['price_monthly'])){?>
											<li class="price-info">€ <?= $value['price_monthly'];?> <span class="price-type">/Month</span></li>
											<?php } ?>
											<?php if(!empty($value['price_yearly'])){?>
											<li class="price-info">€ <?= $value['price_yearly'];?> <span class="price-type">/Year</span></li>
											<?php } ?>
											<?php 

													$uuid=$value['uuid'];
													
											?>
											<li>
											<a class="<?= $button .' '.'clicks';?>" href="javascript:void(0)">	
												<input id="<?=$value['uuid'];?>" class="filled-in chk-col-red cheks" name="planids[]" type="checkbox" value="<?=$value['uuid'];?>">
								           	 	<label for="<?=$value['uuid'];?>" style="top: 8px;"></label>
												Select Service
											</a>
											<?php 
							      					if(empty($uuid)){
														$uuid = '0';
													 }
													 //echo $this->Form->control('planids', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=>$value['uuid']]);
													echo $this->Form->button(__('Buy Service'),['class' => 'btn bg-deep-orange submitservice','escape' => false,'style'=>'float: right;
    																		  margin-right: 15px;'],['controller' => 'users', 'action' => 'buyPlan',$uuid])
							       ?>
									            
									          </li>  
										</ul>
									</div>
								</div>
							</div>
							<?php 
								}
							?>
							<?php 
							      if(empty($uuid)){
														$uuid = '0';
													 }
												
												
							echo $this->Form->button(__('Buy Service'),['class' => 'btn bg-deep-orange submitservice submitserviceFixed','escape ' => false,'style'=>'float: right;
    																		  margin-right: 15px;'],['controller' => 'users', 'action' => 'buyPlan',$uuid]) ?>
							<?= $this->Form->end() ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- <script type="text/javascript">
	$(document).ready(function() {
		$('.clicks').click(function(){
	       var selected = $(this). find('.cheks'). val();
	        
	        if(selected){
	           
	            if($("#" + selected).is(':checked'))
	            {
	                //.removeAttr('checked');
	               // alert("check box");
	                $("#" + selected).attr("checked", false);
	            }
	            else
	            {
	                $("#" + selected).attr("checked", true);
	            }
	        }
	        
	    });
    });
</script>> -->