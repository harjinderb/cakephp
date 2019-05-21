					<?php
					//pr($childe);die;
					//pr($dateday);die;
					if ($day != $dateday) {?>
						<tr><td></td>
								<td><?= __('Date not selected proper');?></td></tr>
				
				<?php 
				//return $this->redirect(['action' => 'markAttendance', 'prefix' => 'employee']);
				die;
					}
							$i = 1;	
							$attend = '';
							foreach ($childe as $key => $value) {
							if(!empty($value['attendances'])){
					?>
					<tr>
								<td><?=$i ?></td>
								<td><?= $value->firstname.''.$value->lastname?></td>
								<td>Reg: 00<?= $value->registration_id?></td>
								<td>
									<div class="row">
										<div class="col-xs-4">
											<?php
												if(!empty($value['attendances'])){
													echo $this->Form->control('attendance_id[]', ['name'=>'data['.$value->registration_id.'][attendance_id]','label' => false, 'class' => 'form-control','type'=>'hidden','value'=>$value['attendances'][0]['id']]);
												}
											?>
											<?= $this->Form->control('child_id[]', ['name'=>'data['.$value->registration_id.'][child_id]','label' => false, 'class' => 'form-control','type'=>'hidden','value'=>$value->id]);?>

											<?= $this->Form->control('bso_id[]', ['name'=>'data['.$value->registration_id.'][bso_id]','label' => false, 'class' => 'form-control','type'=>'hidden','value'=>$value->bso_id]);?>

											<?= $this->Form->control('contract_id[]', ['name'=>'data['.$value->registration_id.'][contract_id]','label' => false, 'class' => 'form-control','type'=>'hidden','value'=>$value->contract_id]);?>
											<input name="<?= 'data['.$value->registration_id.']['.'attendance'.']'?>" id="radio_48" class="with-gap radio-col-blue-grey attendance" type="radio" value="1" <?php if($value['attendances'][0]['type'] == 'Auth'){echo 'checked';}?>> 
											<label for="radio_48" class="radio-label"><?=__('Present')?></label>
										</div>
										<div class="col-xs-4">
											<input name="<?= 'data['.$value->registration_id.']['.'attendance'.']'?>" id="radio_49" class="with-gap radio-col-blue-grey attendance" type="radio" value="2" <?php if($value['attendances'][0]['type'] == 'Absent'){echo 'checked';}?>> 
											<label for="radio_49" class="radio-label"><?=__('Absent')?></label>
										</div>
										<div class="col-xs-4">
											<input name="<?= 'data['.$value->registration_id.']['.'attendance'.']'?>" id="radio_50" class="with-gap radio-col-blue-grey attendance" type="radio" value="3" <?php if($value['attendances'][0]['type'] == 'Leave'){echo 'checked';}?>> 
											<label for="radio_50" class="radio-label"><?=__('Leave')?></label>
										</div>
								
									</div>
								</td>
								
								<td>
									<div class="form-group">
										 <?= $this->Form->control('note[]',   ['name'=>'data['.$value->registration_id.'][note]','label' => false, 'class' => 'form-control', 'placeholder' => 'Note','type'=>'text','value'=>$value['attendances'][0]['note']]); 
                              				?>
									</div>
								</td>
					</tr>
					<?php }else{ ?>
						<tr>
								<td><?=$i ?></td>
								<td><?= $value->firstname.''.$value->lastname?></td>
								<td>Reg: 00<?= $value->registration_id?></td>
								<td>
									<div class="row">
										<div class="col-xs-4">
											<?php
												if(!empty($value['attendances'])){
													echo $this->Form->control('attendance_id[]', ['name'=>'data['.$value->registration_id.'][attendance_id]','label' => false, 'class' => 'form-control','type'=>'hidden','value'=>$value['attendances'][0]['id']]);
												}
											?>
											<?= $this->Form->control('child_id[]', ['name'=>'data['.$value->registration_id.'][child_id]','label' => false, 'class' => 'form-control','type'=>'hidden','value'=>$value->id]);?>

											<?= $this->Form->control('bso_id[]', ['name'=>'data['.$value->registration_id.'][bso_id]','label' => false, 'class' => 'form-control','type'=>'hidden','value'=>$value->bso_id]);?>

											<?= $this->Form->control('contract_id[]', ['name'=>'data['.$value->registration_id.'][contract_id]','label' => false, 'class' => 'form-control','type'=>'hidden','value'=>$value->contract_id]);?>
											<input name="<?= 'data['.$value->registration_id.']['.'attendance'.']'?>" id="radio_48" class="with-gap radio-col-blue-grey attendance" type="radio" value="1"> 
											<label for="radio_48" class="radio-label"><?=__('Present')?></label>
										</div>
										<div class="col-xs-4">
											<input name="<?= 'data['.$value->registration_id.']['.'attendance'.']'?>" id="radio_49" class="with-gap radio-col-blue-grey attendance" type="radio" value="2"> 
											<label for="radio_49" class="radio-label"><?=__('Absent')?></label>
										</div>
										<div class="col-xs-4">
											<input name="<?= 'data['.$value->registration_id.']['.'attendance'.']'?>" id="radio_50" class="with-gap radio-col-blue-grey attendance" type="radio" value="3"> 
											<label for="radio_50" class="radio-label"><?=__('Leave')?></label>
										</div>
								
									</div>
								</td>
								
								<td>
									<div class="form-group">
										 <?= $this->Form->control('note[]',   ['name'=>'data['.$value->registration_id.'][note]','label' => false, 'class' => 'form-control', 'placeholder' => 'Note','type'=>'text']); 
                              				?>
									</div>
								</td>
					</tr>

					<?php $i++; } }?>