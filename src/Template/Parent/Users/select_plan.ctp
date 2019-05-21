<!-- Content Wrapper. Contains page content -->
  <div class="buy-content">
    <!-- Main content -->
    <section class="content">
		
		
			<div class="buy-plan">
				<?php 
							$child_id = $this->request->query('child_id');
							$day = $this->request->query('day');
							$service_id = $this->request->query('service_id');
						echo $this->Form->create('',['class'=>'','type'=>'GET','url' => ['controller'=>'Users', 'action' => 'bsoAgrement','day'=> $day]]);?>
				<div class="form-group">
					<label><?=__('Joining date *')?></label>
					<div class="input-group date">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<?= $this->Form->control('joiningdate',['type'=>'text','label' => false, 'class' => 'form-control pull-right','id' =>'datepicker']);?>
						<!-- <input type="text" name="joiningdate" class="form-control pull-right" id="datepicker"> -->
					</div>
					
				</div>
				<div class="form-group">
				<label><?=__('Select Plan')?></label>
					<ul class="buy-check-list select-plan-list">
						<?php
							foreach ($BsoServices as $key => $value) {
							
						?>
						<li>
							
							<label class="buy-check">
							  <input type="checkbox" name="<?='data['.$key.'][planname]'?>" class="buy-check__input plan" value=<?=$value[0]['uuid']?>>
								<span class="buy-check__overly"><span class="select-plan-timeslot"><?=date("H:i:s", strtotime($value[0]['start_time'])) .'-'.date("H:i:s", strtotime($value[0]['end_time']))?></span></span>
														</label>
							<div class="payment-option-radio">
								<label> <?=__('Select payment option *')?></label>
								<div class="row">
									<?php
									if($Setting->priceweekly == 1){ ?>
												<div class="col-xs-4">
													
													<label class="buy-radio-round">
													<input type="radio" name=<?='data['.$key.'][cost]'?> class="buy-radio-round__input cost" value=<?=$value[0]['price_weekly'].'-'.'price_weekly'?>>
														<span class="radio-label__radio-check"></span>
														<span><?=$GlobalSettings->currency_code?> <?= $value[0]['price_weekly']?>/Week</span>
													
													</label>
													
												</div>


									<?php
										}
									 if($Setting->pricemonthly == 1){ ?>
									<div class="col-xs-4">
										<label class="buy-radio-round">
											<input type="radio" name=<?='data['.$key.'][cost]'?> class="buy-radio-round__input cost" value=<?=$value[0]['price_monthly'].'-'.'price_monthly'?>>
											<span class="radio-label__radio-check"></span>
											<span><?=$GlobalSettings->currency_code?> <?= $value[0]['price_monthly']?> /Month</span>
										
										</label>
										
									</div>
									<?php
										}
									 if($Setting->priceyearly == 1){ ?>
									<div class="col-xs-4">
										<label class="buy-radio-round">
											<input type="radio" name="<?='data['.$key.'][cost]'?>" class="buy-radio-round__input cost"value=<?=$value[0]['price_yearly'].'-'.'price_yearly'?>>
											<span class="radio-label__radio-check"></span>
											<span><?=$GlobalSettings->currency_code?> <?= $value[0]['price_yearly']?> /Year</span>
										
										</label>
										
									</div>
									<?php } ?>
								</div>
								<label><?=__('Select plan repeat interval *')?></label>
								<div class="row">
									
									<!-- <div class="payment-option-radio"> -->
										<div class="col-xs-4">
										<label class="buy-radio-round">
											<input type="radio" name="<?='data['.$key.'][week]'?>" class="buy-radio-round__input week" value="everyweek">
											<span class="radio-label__radio-check"></span>
											<span><?=__('Every Week')?></span>
										</label>
										</div>
										<div class="col-xs-4">
										<label class="buy-radio-round">
											<input type="radio" name="<?='data['.$key.'][week]'?>" class="buy-radio-round__input week" value="every2nd&4thweek">
											<span class="radio-label__radio-check"></span>
											<span><?=__('Every 2nd & 4th Week')?></span>
										</label>
										</div>
										<div class="col-xs-4">
										<label class="buy-radio-round">
											<input type="radio" name="<?='data['.$key.'][week]'?>" class="buy-radio-round__input week" value="everyIst&3rdweek">
											<span class="radio-label__radio-check"></span>
											<span><?=__('Every Ist & 3rd Week')?></span>
										</label>
										</div>
									
								</div>
							</div>
							
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
						 <a href="#" class="btn btn-default btn-round-lg back"><?=__('Back')?></a>
						<?php 
							//pr($child_id);die;
							 //$id =$child_id['child_id']['child_id'];
						//,'child_id'=>$id
							
						/*echo $this->Html->link(
					                __('Back'),
					                ['controller' => 'users', 'action' => 'buyPlan','day'=> $day],
					                ['class' => 'btn btn-default btn-round-lg','escape' => false]); */
					
						?>
					</div>
					<div class="col-xs-7 text-right">
						<!-- <a href="select-joiningdate.php" class="btn btn-theme btn-round-lg"> Continue</a> -->
						<?php 
							echo $this->Form->button(__('Continue'),['class' => 'btn btn-theme btn-round-lg buyingplan','id'=>'planselect','disabled'=>'disabled','escape' => false]);
							echo $this->Form->end(); 
				       ?>
					</div>
				</div>
			</div>
		
    </section>
    <!-- /.content -->
  </div>