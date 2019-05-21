<!-- Content Wrapper. Contains page content -->
  <div class="buy-content">
    <!-- Main content -->
    <section class="content">
		
		<?php 
			$day = isset($_GET['day']) ? $_GET['day'] : '';
			echo $this->Form->create('',['class'=>'form-common','type'=>'file','url' => ['controller'=>'Users', 'action' => 'bsoAgrement','day'=> $day]]);
		?>
			<div class="buy-plan">
				<div class="form-group">
					<label>Joining date *</label>
					<div class="input-group date">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<?= $this->Form->control('joiningdate',['type'=>'text','label' => false, 'class' => 'form-control pull-right','id' =>'datepicker']);?>
						<!-- <input type="text" name="joiningdate" class="form-control pull-right" id="datepicker"> -->
					</div>
					
				</div>
				<div class="form-grou">
					<label>Select plan repeat interval *</label>
					<div class="payment-option-radio">
						<label class="buy-radio-round buy-check-square">
							<input type="checkbox" name="firstweek" class="buy-radio-round__input week">
							<span class="radio-label__radio-check"></span>
							<span>First Week</span>
						</label>
						<label class="buy-radio-round buy-check-square mt_15">
							<input type="checkbox" name="secondweek" class="buy-radio-round__input week">
							<span class="radio-label__radio-check"></span>
							<span>Second Week</span>
						</label>
						<label class="buy-radio-round buy-check-square mt_15">
							<input type="checkbox" name="thirdweek" class="buy-radio-round__input week">
							<span class="radio-label__radio-check"></span>
							<span>Third Week</span>
						</label>
						<label class="buy-radio-round buy-check-square mt_15">
							<input type="checkbox" name="fourthweek" class="buy-radio-round__input week">
							<span class="radio-label__radio-check"></span>
							<span>Fourth Week</span>
						</label>
					</div>
				</div>
			</div>
		
			
			<div class="buy-plan-footer">
				<div class="row">
					<div class="col-xs-5">
						<!-- <a href="select-plan.php" class="btn btn-default btn-round-lg"> Back</a> -->
						<?php echo $this->Html->link(
					                __('Back'),
					                ['controller' => 'users', 'action' => 'selectChild','day'=> $day],
					                ['class' => 'btn btn-default btn-round-lg','escape' => false]); 
					
						?>
					</div>
					<div class="col-xs-7 text-right"><!-- 
						<a href="bso-agrement.php" class="btn btn-theme btn-round-lg"> Continue</a> -->
						<?php 
							echo $this->Form->button(__('Continue'),['class' => 'btn btn-theme btn-round-lg','id'=>'planselect','disabled'=>'disabled','escape' => false]);
							echo $this->Form->end(); 
				       ?>
					</div>
				</div>
			</div>
		
    </section>
    <!-- /.content -->
  </div>
 