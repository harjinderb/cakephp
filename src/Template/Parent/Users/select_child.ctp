  <div class="buy-content">
    <!-- Main content -->
    <section class="content">
		
			<div class="buy-plan">
			
				<div class="form-group">
					<label><?=__('Select Child *')?></label>
					<ul class="buy-check-list">
						<?php 
							$day = isset($_GET['day']) ? $_GET['day'] : '';
							echo $this->Form->create('',['class'=>'','type'=>'GET','url' => ['controller'=>'Users', 'action' => 'buyPlan','day'=> $day]]);
								
							if(empty($user)){
								echo __('No Child Available');
							}
							foreach ($user as $key => $value) {
						?>
						<li>
							<label class="buy-check">
							  <input type="radio" name="child_id" class="buy-check__input  selectchild" value = <?=$value['uuid']?>>
								<span class="buy-check__overly"><?=$this->Decryption->mc_decrypt($value['firstname'],$value['encryptionkey']).' '.' '.$this->Decryption->mc_decrypt($value['lastname'],$value['encryptionkey'])?></span>
							</label>
						</li>
						<?php } 
						 echo $this->Form->control('day', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $day]);
						?>
						
					</ul>
					
				</div>
			</div>
		
		
			<div class="buy-plan-footer">
				<div class="row">
					<div class="col-xs-5">
					</div>
					<div class="col-xs-7 text-right">
						<?php 
							echo $this->Form->button(__('Continue'),['class' => 'btn btn-theme btn-round-lg','id'=>'childselect','disabled'=>'disabled','escape' => false]);
							echo $this->Form->end(); 
				       ?>
					</div>
				</div>
			</div>
		
    </section>
    <!-- /.content -->
  </div>