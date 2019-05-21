<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
    <section class="content">
    	 <div class="block-header">
			<h2><?=__('Manage Calendar')?></h2>
			<?= $this->Flash->render() ?>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="box box-primary">
					
					<div class="box-body">
						<div class="row">
							<div class="col-xs-4">
								<h4><?=__('Yearly calendar')?></h4>
							</div>
							<div class="col-xs-4">
								<label class="switch">
									<input type="radio" class ="calendarfrmt" name="calendarfrmt" value="Year calendar" <?php if($Setting['calendarfrmt'] == 'Year calendar'){echo "checked";}?>>
									<span class="slider round"></span>
								</label>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-xs-4">
								<h4><?=__('School calendar')?></h4>
							</div>
							<div class="col-xs-4">
								<label class="switch">
									<input type="radio" class ="calendarfrmt" name="calendarfrmt" value="School calendar" <?php if($Setting['calendarfrmt'] == 'School calendar'){echo "checked";}?>>
									<span class="slider round"></span>
								</label>
							</div>
							<div class="col-xs-4">
								
								<div class="col-sm-6">	
								<label><?=__('School calendar Start')?></label>
								<?php 
								if($Setting['calendarfrmt'] == 'School calendar'){
								$start = date('d-m-Y', strtotime($Setting['schooldatestart']));
								$end = date('d-m-Y', strtotime($Setting['schooldateend']));
								}else{
									$start = '';
									$end = '';	
								}
								?>
								<?= $this->Form->control('schoolcalendarstart',   ['label' => false, 'class' => 'form-control datepicker', 'placeholder' => 'School calendar start', 'id'=> 'schooldatepicker','value' => $start]); ?>
								</div>
								<div class="col-sm-6">
								<label><?=__('School calendar End')?></label>
								<?= $this->Form->control('schoolcalendarend',   ['label' => false, 'class' => 'form-control datepicker', 'placeholder' => 'School calendar end', 'id'=> 'schooldatepickerEnd','value' => $end]); ?>
								</div>
								
							</div>	
						</div>
					</div>
					<!-- /.box-body -,'disabled' => 'disabled'-->
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8 mt_30">
				<div class="box box-primary">
					<div class="box-header bso-box-header">
						<div class="row">
							<div class="col-xs-7">
								<h3 class="box-title"><?=__('Holiday Calendar')?></h3>
							</div>
							<div class="col-xs-5 text-right">
								<a href="javascript:void(0)" class="btn btn-theme btn-round" data-toggle="modal" data-target="#CreateHoliday"> <?=__('Create new holiday')?></a>
							</div>
						</div>							
					</div>
					<div class="box-body no-padding">
					  <!-- THE CALENDAR -->
					  <div id="holidaycalender" class="hide-small-calendar calsetting-wrap"></div>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
			<div class="col-md-4 mt_30">
				<div class="box box-primary">
					<div class="box-header bso-box-header">
					  <h3 class="box-title"><?=__('Holiday List')?></h3>
					</div>
					<div class="box-body">
						<div class="home-event-list">
							
							<?php 
							//pr($Holiday);die;
							if(!empty($Holiday)){
							$Createddate = date("Y-m-d");
								foreach ($Holiday as $key => $value) {
									//pr($value);die;
								
							?>
							<div class="home-single-event <?php if($Createddate == date('Y-m-d', strtotime($value['holidaystartdate']))){ echo 'event-current';} ?> ">
								<div class="row">
								<div class="col-sm-6">	
								<label><?=__('Holiday Start')?></label>
								<div class="event-date-info"><?= date('d-m-Y', strtotime($value['holidaystartdate']));?></div>
								</div>
								<div class="col-sm-6">
								<label><?=__('Holiday End')?></label>
								<div class="event-date-info"><?= date('d-m-Y', strtotime($value['holidayenddate']));?></div>
								</div>
								</div>
								<h5 class="event-title" id="event_title<?= $value['id'] ?>"><?= $value['holidayname'];?></h5>
								<div class="event-view-btn">
									<!-- <a href="javascript:void(0)" data-toggle="modal" data-target="#ViewHoliday" class="btn btn-theme-border viewholiday" ,value = <?php// $value['id'];?>>View</a> -->
									<?= $this->Form->button('View',['data-toggle' =>'modal', 'data-target'=>'#ViewHoliday','class' => 'btn btn-theme-border viewholiday','value' => $value['id']]);
									?>
								</div>
							</div>
							<?php }
								}
							?>
							
							
							<div class="view-all-event">
								
								<a href="javascript:void(0)" data-toggle="modal" data-target="#CreateHoliday"><?=__('Create New Holiday')?></a>
							</div>
						</div>
					</div>
					<!-- /.box-body -->
				</div>
		</div>
		

    </section>
    <!-- /.content -->
  </div>
  <!--Create Event Modal -->
   <div class="modal fade" id="CreateHoliday">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header service-header bg-b-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?=__('Create New Holiday')?></h4>
              </div>
				<form action="" method="" class="form-common">
					<?= $this->Form->hidden('calsettings',   ['value'=> 'calsettings','id' => 'calsettings']); ?>
					<div class="modal-body">
						<div class="event-details">					
							<div class="form-group">
								<label><?=__('Holiday Name *')?></label>
								<!-- <input type="text" class="form-control" required> -->
								<?= $this->Form->control('holidayname',   ['label' => false, 'class' => 'form-control', 'placeholder' => 'Holiday Name']); ?>
							</div>
							<div class="form-group">
								<label><?=__('Holiday Start *')?></label>
								<div class="row">
									<div class="col-xs-6">
										<div class="input-group">
											<?= $this->Form->control('holidaystartdate',['type'=>'text','label' => false, 'class' => 'form-control','id'=>'datepicker' ]);?>
											<!-- <input type="text" class="form-control" id="datepicker" required=""> -->
											<div class="input-group-addon">
												<i class="fa fa-calendar"></i>
											</div>
										</div>
									</div>
									<div class="col-xs-6">
										<div class="input-group">
											<?= $this->Form->control('holidaystarttime',['type'=>'text','label' => false, 'class' => 'form-control','id'=>'time' ]);?>
											<!-- <input type="text" id="time" class="form-control floating-label" placeholder="Time"> -->
										<div class="input-group-addon">
										  <i class="fa fa-clock-o"></i>
										</div>
									 </div>
									</div>
								</div>						
							</div>	
							<div class="form-group">
								<label><?=__('Holiday End *')?></label>
								<div class="row">
									<div class="col-xs-6">
										<div class="input-group">
											<?= $this->Form->control('holidayenddate',['type'=>'text','label' => false, 'class' => 'form-control datepicker','id'=>'datepickerEnd' ]);?>
											<!-- <input type="text" class="form-control" id="datepickerEnd" required=""> -->
											<div class="input-group-addon">
												<i class="fa fa-calendar"></i>
											</div>
										</div>
									</div>
									<div class="col-xs-6">
										<div class="input-group">
											<?= $this->Form->control('holidayendtime',['type'=>'text','label' => false, 'class' => 'form-control','id'=>'timeNew' ]);?>
											<!-- <input type="text" id="timeNew" class="form-control floating-label" placeholder="Time"> -->
										<div class="input-group-addon">
										  <i class="fa fa-clock-o"></i>
										</div>
									 </div>
									</div>
								</div>						
							</div>							
							<div class="form-group">
								<label><?=__('Description')?></label>
								<?=$this->Form->input('holiday_description', array('type' => 'textarea','label' => false, 'class' => 'form-control textarea-100'));?>

								<!-- <textarea class="form-control textarea-100"></textarea> -->
							</div>
						</div>
					</div>
					<div class="modal-footer pt_0 bt_0 text-right">
						<button type="button" class="btn btn-default btn-round-md" data-dismiss="modal">Close</button>
						<?= $this->Form->button(__('Create'),['class' => 'btn btn-theme btn-round-md','data-dismiss'=>'modal','id'=>'saveholiday']);
						?>
						<!-- <button type="button" class="btn btn-theme btn-round-md" data-dismiss="modal">Create</a> -->
					</div>
				</form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
		
	 <!--Edit Event Modal -->
   <div class="modal fade" id="EditHoliday">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header service-header bg-b-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?=__('Edit Holiday')?> </h4>
              </div>
				<!-- <form action="" method="" class="form-common"> -->
					<?php echo $this->Form->create($Holiday,['class'=>'form-common','type'=>'file']); ?>
					<div class="modal-body editmodal">
						<img src=<?= '"'. BASE_URL.'/img/loading.gif"'?> class="" alt="">
					</div>
					
				</form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
		
<!--View Event Modal -->
   <div class="modal fade" id="ViewHoliday">
        <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header service-header bg-b-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
               
              </div>
				<div class="modal-body viewmodel">
					<img src=<?= '"'. BASE_URL.'/img/loading.gif"'?> class="" alt="">

				</div>
				
            </div>
           
        </div>
          
    </div>

    

          