<section class="content">

	<?php // $this->Html->css('kendo.material.min.css') ?>
	<?php //$this->Html->css('kendo.material.mobile.min.css') ?>

	<!-- 
	<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2018.2.620/styles/kendo.common-material.min.css" /> -->
                
    <script src="https://kendo.cdn.telerik.com/2018.2.620/js/jquery.min.js"></script>
     <?php // $this->Html->script('kendo.all.min.js') ;
    // pr($employees);die('emp');

     ?>

	<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1><?=__('Add Service')?></h1>
      <?= $this->Flash->render() ?>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="box box-primary">
         <div class="box-header bso-box-header">
            <div class="row">
               <div class="col-xs-7">
                  <h3 class="box-title"><?=__('add service details')?></h3>
               </div>
               <div class="col-xs-5 text-right">
               	<?php
								 echo $this->Html->link(
					                'Services List',
					                ['controller' => 'users', 'action' => 'manageServices'],
					                ['class' => 'btn btn-theme btn-round','escape' => false]); 
					            ?>
               </div>
            </div>
         </div>
         <!-- /.box-header -->
         <div class="box-body">
   			<div class="box-body">
						<div class="form-common">
							<?php echo $this->Form->create($service,['class'=>'myform']); ?>
								<div class="form-group">
									<label><?=__('Service Day')?> *</label>
									<?php $ServiceDays = array(''=>__('-- Please select day --'),'monday'=>__('Monday'),'tuesday'=>__('Tuesday'),'wednesday'=>__('Wednesday'),'thursday'=>__('Thursday'),'friday'=>__('Friday'),'saturday'=>__('Saturday'),'sunday'=>__('Sunday'));?>									
									<?= $this->Form->input('service_day', array('type'=>'select','label'=>false, 'class'=>'form-control show-tick serviceday', 'options'=>$ServiceDays)); ?>
								</div>
								<!-- <div class="form-group">
									<label><?__('Service Type *</label')?>> -->
									<?php
									/* $ServiceType = array(''=>'-- Please select day --','voorschoolse'=>'voorschoolse','tussenschoolse'=>'tussenschoolse','naschoolse'=>'naschoolse'); */
									?>									
									<?php
									/* $this->Form->input('service_type', array('type'=>'select','label'=>false, 'class'=>'form-control show-tick', 'options'=>$ServiceType)); */
									?>
									
								<!-- </div> -->
								<div class="form-group">
									<label><?=__('Age Group')?>*</label>
									<?php $minage_groupshow = AGEGROUPSHOW;
										  $maxage_groupshow=MAXAGEGROUPSHOW;	
									 ?>
									<div class="row demo-section k-content">
											<div class="col-sm-6">
												<div class="form-group service-date">
													<label><?=__('Min Age *</label>				')?>							
													<?= $this->Form->control('min_age',['type'=>'select','label' => false, 'class' => 'form-control', 'options'=>$minage_groupshow]); ?>									
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label><?=__('Max Age')?>*</label>
												<?= $this->Form->control('max_age',['type'=>'select','label' => false, 'class' => 'form-control', 'options'=>$maxage_groupshow]); ?>
												</div>
											</div>
									</div>
									
								</div>
								
								<div class="form-group">
									<div id="example">
											<div class="row demo-section k-content">
												<div class="col-sm-6">
													<div class="form-group">
													<span class="output"></span>
															
																							
													</div>
												</div>
											</div>
											<div class="row demo-section k-content">
											<div class="col-sm-6">
												<div class="form-group service-date">
													<label><?=__('Start Time')?> *</label>	
													<div class="input-group">										
														<?= $this->Form->control('start_time',['type'=>'text','id'=>'date-start','label' => false, 'class' => 'timepicker form-control', 'placeholder' => 'Start Time','id'=>'time'],['class' => '']); ?>
														<div class="input-group-addon">
															  <i class="fa fa-clock-o"></i>
															</div>
													</div>								
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label><?=__('End Time')?> *</label>											<div class="input-group">	
														<?= $this->Form->control('end_time',['type'=>'text','label' => false, 'id'=> 'date-end','class' => 'timepicker endtime form-control', 'placeholder ' => 'End Time','id'=>'timeNew']); ?>
															<div class="input-group-addon">
															  <i class="fa fa-clock-o"></i>
															</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row demo-section k-content">
											<div class="col-sm-6">
												<div class="form-group">
													<label><?=__('Max. Batch Subscription')?> *</label>
													<?= $this->Form->control('childin_batch',['type'=>'text','label' => false, 'class' => 'form-control', 'placeholder' => 'Number of childs in batch']); ?>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label><?=__('Add no of Teachers')?> *</label>
													<?= $this->Form->control('add_teacher_no',['type'=>'text','label' => false, 'class' => 'form-control', 'placeholder' => 'Number of childs in batch']); ?>
												</div>
											</div>
										</div>
										<div class="box box-default"><div class="box-header"><h3 class="box-title">Divide Child And Teachers In Groups</h3></div>
										<div class="row demo-section k-content childgroups">
												   <div class="col-sm-12">
											       	<a href="javascript:void(0)" class="btn btn-dark-green btn-round-md" data-attr="" id="check_edit_groups">Create group</a>
								            	         
								        	       </div>
								                </div>
											</div>

											<div class="col-sm-12 row childs_divide">
												<?php
													$key= 0;
													
												if(!empty($groups)){
													foreach ($groups as $key => $value) {
														
												?>
											     <div class="childrows">
											      	<div class="col-sm-3">
											      		<label><?=__('Add Child Group Name')?>*</label>
											      		<div class="input text">
											      			<input type="text" name="group[<?=$key?>][child_group_name]" class="form-control" placeholder="Child Group Name" id="child-group-name" value="<?= $value['child_group_name']?>">
											      			<input type="hidden" name="group[<?=$key?>][id]" class="form-control" placeholder="Child Group Name" id="child-group-name<?='-'.$key?>" value="<?= $value['id']?>">
											      		</div>
											      	</div>
											      	<div class="col-sm-3">
											      		<label><?=__('Add No of Childs In This Group')?>*</label>
											      		<div class="input text">
											      			<input type="text" name="group[<?=$key?>][no_of_childs]" class="form-control no_of_childs" placeholder="No of Childs" id="no-of-childs<?='-'.$key?>"value="<?= $value['no_of_childs']?>">
											      		</div>
											      	</div>
											      	<div class="col-sm-3">
											      		<label><?=__('Add No of Teachers In This Group')?>*</label>
											      		<div class="input text">
											      			<input type="text" name="group[<?=$key?>][no_of_teachers]" class="form-control no_of_teachers" placeholder="No of Teachers" id="no-of-teachers<?='-'.$key?>"value="<?= $value['no_of_teachers']?>">
											      		</div>
											      		<input type="hidden" name="group[<?=$key?>][service_id]" class="form-control" id="service_id" value="<?= $service['id']?>">
											      		
											      	</div>
											      	<div class="col-sm-3">
											      		<div class="removetag">
											      			<a href="javascript:void(0)" class="btn btn-orange btn-round-md" data-attr="" id="child_groups">Remove</a>
											      		</div>
											      	</div>
											     </div>
											 <?php }
											 		}
											 ?>
														
											</div>
											<?= $this->Form->control('keycount',['type'=>'hidden','label' => false, 'class' => 'form-control','value' =>$key]); ?>
										</div>
										<?php  
											//pr($GlobalSettings->currency);die;
										?>
										<div class="row">
										<?php if($Setting['priceweekly'] == 1){ ?>
											<div class="col-sm-4">
												<div class="form-group">
				<label><?=__('Price Weekly ('.$GlobalSettings->currency .' '.$GlobalSettings->currency_code .')')?> *</label>
													<?= $this->Form->control('price_weekly',['type'=>'text','label' => false, 'class' => 'form-control', 'placeholder' => 'Price Weekly']); ?>	
												</div>
											</div>
										<?php  } ?>
										<?php if($Setting['pricemonthly'] == 1){ ?>
											<div class="col-sm-4">
												<div class="form-group">
											<label><?=__('Price Monthly ('.$GlobalSettings->currency .' '.$GlobalSettings->currency_code .')')?>*</label>
													<?= $this->Form->control('price_monthly',['type'=>'text','label' => false, 'class' => 'form-control', 'placeholder' => 'Price Monthly']); ?>	
												</div>
											</div>
											<?php  } ?>
											<?php if($Setting['priceyearly'] == 1){ ?>
											<div class="col-sm-4">
												<div class="form-group">
									<label><?=__('Price Yearly ('.$GlobalSettings->currency .' '.$GlobalSettings->currency_code .')')?> *</label>
													<?= $this->Form->control('price_yearly',['type'=>'text','label' => false, 'class' => 'form-control', 'placeholder' => 'Price Yearly']); ?>
												</div>
											</div>
											<?php  } ?>
									
										</div>
										
								<div class="form-group text-right">
								<?= $this->Form->button(__('Add Service'),['class' => 'btn btn-theme btn-round-md','id'=>'buttonaddservice']);?>
								</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script>

	$(window).load(function() {
		 var selected = $('#service-day').val();
           var data = {
                "day": selected,
                };
            $.ajax({
                type: "POST",
                dataType: "html",
                url: baseurl + "users/getservices", //Relative or absolute path to response.php file
                data: data,
                success: function(data) {
                	//alert("data");
                   // console.log(data);
                    if(data.length !== 2){
                    var obj = jQuery.parseJSON( data );
                    var data ='<div class="container"><h2>Previous Time Slots</h2><p>previously you have selected these time slots for'+' '+' <b>'+ selected+'</b></p><table class="table table-bordered">';
                        data +='<thead><tr><th>Start time</th><th>End time</th><th>Min age</th><th>Max age</th></tr></thead>';
                    $(obj).each(function(key,value){
                        var ds = value["start_time"];
                        //var ns = ds.toTimeString();
                        console.log(ds);
                        data +='<tbody><tr><td>'+value["start_time"]+'</td><td>'+value["end_time"]+'</td><td>'+value["min_age"]+'</td><td>'+value["max_age"]+'</td></tr></tbody>';
                    
                    
                    });
                        data +='</table></div>';
                    $('.output').html(data);
                    return false;
                        }
                    }
            });
          

			// $("ul").on('click', 'li', function (e) {
			// 	if (e.ctrlKey || e.metaKey) {
			// 		$(this).toggleClass("selected");
			// 	} else {
			// 		$(this).addClass("selected").siblings().removeClass('selected');
			// 	}
			// }).sortable({
			// 	connectWith: "ul",
			// 	delay: 150, //Needed to prevent accidental drag when trying to select
			// 	revert: 0,
			// 	helper: function (e, item) {
			// 	//Basically, if you grab an unhighlighted item to drag, it will deselect (unhighlight) everything else
			// 	if (!item.hasClass('selected')) {
			// 		item.addClass('selected').siblings().removeClass('selected');
			// 	}

			// 	//////////////////////////////////////////////////////////////////////
			// 	//HERE'S HOW TO PASS THE SELECTED ITEMS TO THE `stop()` FUNCTION:

			// 	//Clone the selected items into an array
			// 	var elements = item.parent().children('.selected').clone();

			// 	//Add a property to `item` called 'multidrag` that contains the 
			// 	//  selected items, then remove the selected items from the source list
			// 	item.data('multidrag', elements).siblings('.selected').remove();

			// 	//Now the selected items exist in memory, attached to the `item`,
			// 	//  so we can access them later when we get to the `stop()` callback

			// 	//Create the helper
			// 	var helper = $('<li/>');
			// 		return helper.append(elements);
			// 	},
			// 	stop: function (e, ui) {
			// 	//Now we access those items that we stored in `item`s data!
			// 	var elements = ui.item.data('multidrag');

			// 	//`elements` now contains the originally selected items from the source list (the dragged items)!!

			// 	//Finally I insert the selected items after the `item`, then remove the `item`, since 
			// 	//  item is a duplicate of one of the selected items.
			// 	ui.item.after(elements).remove();
			// 	}

			// });

			jQuery(document).ready(function($) {
    $('#undo_redo').multiselect();
});
			 //  $("#date-start").click(function(event) {
    //         alert('qwe');
    //         var starttime = $("#date-start").val();    
    //         var endtime = $("#date-end").val();
    //         var service_day = $("#service-day").val();
    //         var data = {
    //             "start": starttime,
    //             "end": endtime,
    //             "service_day" :service_day,
    //         };
    //         $.ajax({
    //             type: "POST",
    //             dataType: "html",
    //             url: baseurl + "users/servicesTeacher", //Relative or absolute path to response.php file
    //             data: data,
    //             success: function(data) {
    //                   //console.log(data);
                  
    //                  var obj = jQuery.parseJSON( data );
    //                  var setdata = '';
    //                  $(obj).each(function(key,value){

    //                     setdata +="<option value="+value['user_id']+">"+value['firstname']+" "+value['lastname']+"</option>";
                    
    //                 });
    //                  if(setdata == ''){
    //                     var setdata = "<option value="+'No teacher avalable in that time slot.'+">"+'No teacher avalable in that time slot.'+"</option>";
                    
    //                  }
    //                console.log(setdata);
    //                 $('#undo_redo').html(setdata);
    //                  return false;
    //             }
                

    //         });
    //         //alert(endtime);
        
       
    // });
			  return false;
    });
	</script>

