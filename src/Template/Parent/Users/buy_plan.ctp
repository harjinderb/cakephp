<div class="buy-content">
    <!-- Main content -->
    <section class="content">
		
			
				<div class="buy-plan">
				<div class="form-group">
					<label><?=__('Select Timeslot *')?></label>
					<?= $this->Flash->render() ?>

					<ul class="buy-check-list buy-check-inline">
					<?php
						if (empty($BsoServices->toArray())){
							echo "<label>".__('No Timeslot Available')."</label>";
						}
						$child_id = $this->request->query('child_id');
						$day = $this->request->query('day');
						$service_id = $this->request->query('service_id');
						echo $this->Form->create($BsoServices,['class'=>'','type'=>'GET','url' => ['controller'=>'Users', 'action' => 'selectPlan']]);
						foreach ($BsoServices as $key => $value) {
							// pr($value);die('val');					
						
						?>
						<li>
							<label class="buy-check">
							  <input type="checkbox" name="plans_id[]" class="buy-check__input selectplan" value=<?=$value['uuid']?>>
								<span class="buy-check__overly"><?=date("H:i:s", strtotime($value['start_time'])) .'-'.date("H:i:s", strtotime($value['end_time']))?></span>
							</label>
						</li>
						 <?php } 
						 echo $this->Form->control('day', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $day]);
						  echo $this->Form->control('child_id', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $child_id]);
						   echo $this->Form->control('service_id', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $service_id]);
						 ?>
						
						
					</ul>
					
				</div>
				</div>
		
			
			<div class="buy-plan-footer">
				<div class="row">
					<div class="col-xs-5">
						<a href="#" class="btn btn-default btn-round-lg back"> <?=__('Back')?></a>
						<!-- <a href="select-child.php" class="btn btn-default btn-round-lg"> Back</a> -->
						<?php
						/* echo $this->Html->link(
					                __('Back'),
					                ['controller' => 'users', 'action' => 'selectChild','day'=> $day],
					                ['class' => 'btn btn-default btn-round-lg','escape' => false]); */
					
						?>
					</div>
					<div class="col-xs-7 text-right">
						<!-- <a href="select-plan.php" class="btn btn-theme btn-round-lg"> Continue</a> -->
						<?php 
							echo $this->Form->button(__('Continue'),['class' => 'btn btn-theme btn-round-lg buyplans','id'=>'planselect','disabled'=>'disabled','escape' => false]);
							echo $this->Form->end(); 
				       ?>
					</div>
				</div>
			</div>
		
    </section>
    <!-- /.content -->
  </div>