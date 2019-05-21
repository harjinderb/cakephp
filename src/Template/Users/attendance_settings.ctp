<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?=__('Attendance Relief')?></h1>
      <?= $this->Flash->render() ?>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="box box-primary">
            <div class="box-header bso-box-header">
				<h3 class="box-title"><?=__('Attendance Relief Time')?></h3>
				<?= $this->Flash->render() ?>							
			</div>
            <!-- /.box-header -->
            <div class="box-body">
				<div class="row">
					<div class="col-sm-6">
						<?php echo $this->Form->create($Setting,['class'=>'myform','type'=>'file']); ?>
							<div class="form-group">
								<label><?=__('Relief time before class start')?> *</label>
								<span id="errmsg" style="color:red;"></span>
								<?= $this->Form->control('relieftimebeforeclass',   ['label' => false, 'class' => 'form-control time', 'placeholder' => '00:00:00']); ?>
								<!-- <input type="text" class="form-control" required="" placeholder="00:00"> -->
							</div>
							<div class="form-group">
								<label><?=__('Relief time after class end')?> *</label>

								<?= $this->Form->control('relieftimeafterclass',   ['label' => false, 'class' => 'form-control time', 'placeholder' => '00:00:00']); ?>
								
							</div>
							<div class="form-group text-right">
								
								<!-- <button class="btn btn-theme btn-round-md">Save</button> -->
							</div>
						
					</div>
				</div>
            </div>
            <!-- /.box-body -->
         </div>
          <!-- /.box -->
		<div class="box box-primary">
            <div class="box-header bso-box-header">
				<h3 class="box-title"><?=__('Overtime Cost')?></h3>							
			</div>
            <!-- /.box-header -->
            <div class="box-body">
				<div class="row">
					 <div class="col-sm-6">
						<div class="box-body">
						<div class="form-group">
									<label><?=__('Overtime Cost for one hour')?>(<?=$GlobalSettings->currency .' '.$GlobalSettings->currency_code?>)* </label>
									<span id="overtime" style="color:red;"></span>
									<?= $this->Form->control('overtimecost',   ['label' => false, 'class' => 'form-control']); ?>
									<!-- <input type="text" class="form-control" required=""> -->
								</div>
								<div class="form-group text-right">
									<?= $this->Form->button(__('Save'),['class' => 'btn btn-theme btn-round-md']);
									?>
								</div>
							<?php echo $this->Form->end(); ?>
						</div>
					
					</div>
				</div>
            </div>
            <!-- /.box-body -->
         </div>
          <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>