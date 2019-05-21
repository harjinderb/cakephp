<!-- Content Wrapper. Contains page content -->
  <div class="buy-content">
    <!-- Main content -->
    <section class="content">
		<?php echo $this->Form->create('',['class'=>'myform form-common','type'=>'file']); ?>
			<div class="buy-plan globel-setting">
				<h2 class="text-center mt_0"> Global Setting</h2>
				<?php
				?>
				<div class="form-group">
					<label>Select Time Zone *</label>
					<?= $this->Form->control('timezone',     ['label' => false, 'class' => 'form-control','value'=>$data['timezone'],'readonly'=> true]);
					?>
				</div>
				<div class="form-group">
					<label>Select Language *</label>
					<?=$this->Form->select('language',$data['languages'],['multiple' => false,'value' => [],'label' => false, 'class' => 'form-control select2','id'=>'language','type'=>'text']);?>
				</div>
				<div class="form-group">
					<label>Select Currency *</label>
					<?=$this->Form->select('currency',$data['currency_code'],['multiple' => false,'value' => [],'label' => false, 'class' => 'form-control select2','id'=>'currency','type'=>'text']);?>
				</div>
			</div>
		
			<div class="buy-plan-footer">
				<div class="row">
					<div class="col-xs-5">
					</div>
					<div class="col-xs-7 text-right">
						
						<a href="#" class="btn btn-theme btn-round-lg gsettings"> Continue</a>
					</div>
				</div>
			</div>
		 <?php echo $this->Form->end(); ?>  
    </section>
    <!-- /.content -->
  </div>
  
 