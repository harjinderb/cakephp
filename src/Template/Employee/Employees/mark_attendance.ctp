<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?=__('Attendance')?></h1>
      <?= $this->Flash->render() ?>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="box box-primary">
            <div class="box-header bso-box-header">
				<h3 class="box-title"><?=__('Select Criteria')?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
				<form action="" method="" class="form-common">
					<div class="col-row">
						<?php 
							$days = ['monday' => __('Monday'), 'tuesday' => __('Tuesday'), 'wednesday' => __('Wednesday'),'thursday' =>  __('Thursday'), 'friday' =>  __('Friday'),'saturday' =>  __('Saturday'),'sunday' =>  __('Sunday')];
						?>
						<div class="col-md-4">
							<div class="form-group">
								<label><?=__('Service*')?></label>
								<?=$this->Form->input('day',['options'=>$days,'empty'=>__('Please select day'),'label' => false, 'class' => 'markattenday form-control show-tick','id'=>'markattenday','value'=>'']);?>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label><?=__('Timeslot*')?></label>
								<?=$this->Form->select('timeslot','',['options'=>'','empty'=>__('Please select day first'),'value' => '','label' => false, 'class' => 'form-control show-tick','id'=>'timeslot','type'=>'text']);?>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<?php
									$currentdate = date('d-m-Y');
								?>
								<label><?=__('Attendance Date*')?> </label>
								<?= $this->Form->control('atten_date',['type'=>'text','label' => false, 'class' => 'datepicker atten_date form-control','placeholder' =>  __('Date of Attendance')]);?>
									<!-- <input type="text" class="form-control" id="datepickerJoin"> -->
							</div>
						</div>
					</div>
				</form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
		  
		  <div class="box box-primary">
            <div class="box-header bso-box-header">
				<h3 class="box-title"><?=__('Student List')?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
				<?php echo $this->Form->create('',['class'=>'myform','type'=>'file']); ?>
					<table id="" class="table table-bordered table-striped table-hover v-center">
						<thead>
							<tr>
							  <th>#</th>
							  <th><?=__('Name')?> </th>
							  <th><?=__('Reg. No.')?></th>
							  <th><?=__('Attendance')?></th>
							  <th><?=__('Note')?></th>
							</tr>
						</thead>
						<tbody id="attendance-list">
							
							
							
						</tbody>
					</table>
					<div class="form-group text-right">
						<?= $this->Form->button(__('Save'),['class' => 'btn btn-theme btn-round-md', 'id'=> 'saveatten','disabled'=>'disabled']);
            			?>
					</div>
					<?php echo $this->Form->end(); ?> 
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>