<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>Parent Detail</h2>
		</div>
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<div class="row">
							<div class="col-sm-6">
								<h2>
									<h2 class="text-uppercase"><?=$this->Decryption->mc_decrypt($profile->firstname,$profile->encryptionkey) .' '.' '. $this->Decryption->mc_decrypt($profile->lastname,$profile->encryptionkey);?></h2>
								</h2>
							</div>
							<div class="col-sm-6 text-right">
								<div class="cs-btn-group">
									<?php echo $this->Html->link(
									                'Add Child',
									                ['controller' => 'users', 'action' => 'addChild',$profile->uuid],
									                ['class' => 'btn bg-cyan','escape' => false]); 
									            ?>
									            <?php echo $this->Html->link(
									                'Add Guardian',
									                ['controller' => 'users', 'action' => 'addGuardian',$profile->uuid],
									                ['class' => 'btn bg-light-green','escape' => false]); 
									            ?>
									<!-- <a href="add-child.php" class="btn bg-cyan">Add new child</a>
									<a href="add-guardian.php" class="btn bg-light-green">Add new guardian</a> -->
								</div>
							</div>
						</div>
					</div>
					<div class="body">
						<div class="row">
							<div class="col-sm-4 col-md-3">
								<?php
								if(!empty($profile['image'])){
									echo $this->Html->link($this->Html->image(USER_PICTURE_FOLDER_URL_PATH.$profile['uuid'].'/'.$profile['image'], ['alt' => 'John','class' => 'img-responsive max-width-user-pic']),'',['escapeTitle' => false,]);
								}else{								
									echo $this->Html->link($this->Html->image('blank-avatar.png', ['alt' => 'John','class' => 'img-responsive max-width-user-pic']),'',['escapeTitle' => false,]);
								}
								?>
							</div>
							<div class="col-sm-8 col-md-9">
								<div class="user-info-row">
									<label>First Name</label>
									<p><?=$this->Decryption->mc_decrypt($profile->firstname,$profile->encryptionkey);?></p>
								</div>
								<div class="user-info-row">
									<label>Last Name</label>
									<p><?=$this->Decryption->mc_decrypt($profile->lastname,$profile->encryptionkey);?></p>
								</div>
								<div class="user-info-row">
									<label>Email Address</label>
									<p><?=$this->Decryption->emailDecode($profile->email);?></p>
								</div>
								<div class="user-info-row">
									<label>Mobile Number</label>
									<p><?=$this->Decryption->mc_decrypt($profile->mobile_no,$profile->encryptionkey);?></p>
								</div>
								<div class="user-info-row">
									<label>BSN No.</label>
									<p><?=$this->Decryption->mc_decrypt($profile->bsn_no,$profile->encryptionkey);?></p>
								</div>
								<div class="user-info-row">
									<label>Date of Birth</label>
									<p><?=date('d-m-Y', strtotime($this->Decryption->mc_decrypt($profile->dob,$profile->encryptionkey)));?></p>
								</div>
								<div class="user-info-row">
									<label>Gender</label>
									<p><?php if($profile->gender == 1){?>
										Male
										<?php } else {?>
										Female
									<?php }?></p>
								</div>
								<div class="user-info-row">
									<label>Your Bank</label>
									<p><?=$this->Decryption->mc_decrypt($profile->bank_name,$profile->encryptionkey);?></p>
								</div>
								<div class="user-info-row">
									<label>Account Number</label>
									<p><?=$this->Decryption->mc_decrypt($profile->account,$profile->encryptionkey);?></p>
								</div>
								
								<div class="user-info-row">
									<label>Postcode</label>
									<p><?=$this->Decryption->mc_decrypt($profile->post_code,$profile->encryptionkey);?></p>
								</div>
								<div class="user-info-row">
									<label>Woonplaats</label>
									<p><?=$this->Decryption->mc_decrypt($profile->residence,$profile->encryptionkey);?></p>
								</div>
								<div class="user-info-row">
									<label>Address</label>
									<p><?=$this->Decryption->mc_decrypt($profile->address,$profile->encryptionkey);?></p>
								</div>								<div class="user-info-row">
									<div class="cs-btn-group m-b-15">
										<?php echo $this->Html->link(
									                'Edit',
									                ['controller' => 'users', 'action' => 'editParents',$profile->uuid],
									                ['class' => 'btn bg-blue','escape' => false]); 
									          echo $this->Form->postLink(__('Delete'), ['controller' => 'users','action' => 'delete',$profile->uuid],
												 	['class' => 'btn bg-deep-orange','confirm' => __('Are you sure you want to Delete # {0}?'),'escape' => false]);
										?>
										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="header">
						<div class="row">
							<div class="col-sm-6">
								<h2 id="child-section">
									Childern List
								</h2>
							</div>
							<div class="col-sm-6 text-right">
								<?php echo $this->Html->link(
									                'Add Child',
									                ['controller' => 'users', 'action' => 'addChild',$profile->uuid],
									                ['class' => 'btn bg-cyan','escape' => false]); 
								foreach ($childs as $key => $childinfo) {
										# code..
									//	pr($childinfo);
									 $childinfo['uuid'];
									}
								?>
							</div>
						</div>
					</div>
					<div class="body">
						<div class="search-right text-right">
							<?= $this->Form->create('Search',['type'=>'get', 'url' => ['controller'=>'Users', 'action' => 'parentProfile', $profile->uuid, '#' => 'child-section'],
							]) ?>
                            <div class="form-group">
                            	<?php echo $this->Form->hidden('st',   ['value' => 'child-section']);?>
                                <?php echo $this->Form->control('ids',   ['label' => false, 'class'=>'search-input', 'placeholder' => 'Search...']
                                );?>
                                <?php echo $this->Form->control('role',   ['label' => false, 'class'=>'search-input','type'=>'hidden','value'=>'5']
                                );
                                ?>
                                
                                <?= $this->Form->button(__('Search'),['label' => false,'class' => 'btn bg-blue-grey search-btn']) ?>
                            </div>
                            <?= $this->Form->end() ?>
						</div>
						<div class="table-responsive">
							<table class="table table-bordered table-checkbox">
								<thead>
									<tr>
										<th>
											<div class="check-box-cs">
												<input id="checkall" class="filled-in chk-col-red customerIDCell"type="checkbox" value="0">
                                           		 <label for="checkall"></label>
                                           		  <input  class="filled-in chk-col-red" id="role" value="5" type="hidden">
										</th>
										</div>
										<th>#</th>
										<th>Name</th>
										<th>Image</th>
										<th>Gender</th>
										<th>DOB</th>
										<th>Relation</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$i=1; 
									$actionlist = array('Action', 'Delete');
									foreach ($childs as $key => $childdata) {
										# code..
										//pr($childdata);
										?>
									
									<tr>
										<td><div class="check-box-cs checkboxes">
								            	<input id="<?=$childdata['uuid'];?>" class="filled-in chk-col-red cheks" type="checkbox" value="<?=$childdata['id'];?>">
								           	 	<label for="<?=$childdata['uuid'];?>"></label>
								        	</div>
								    	</td>
								    	<input  class="filled-in chk-col-red" id="role" value="5" type="hidden">							            		
							    		<input  class="filled-in chk-col-red" id="bso_id" value="<?=$childdata['bso_id'];?>" type="hidden">
								    	<input  class="filled-in chk-col-red" id="parent_id" value="<?=$childdata['parent_id'];?>" type="hidden">
										<td><?=$i?></td>
										<td><?=$this->Decryption->mc_decrypt($childdata['firstname'],$profile->encryptionkey).' '.' '.$this->Decryption->mc_decrypt($childdata['lastname'],$profile->encryptionkey)?></td>
										<td> <?php
											if (!empty($childdata['image'])) {
										        echo $this->Html->link($this->Html->image(USER_PICTURE_FOLDER_URL_PATH . $childdata['uuid'] . '/' . $childdata['image'], ['alt' => 'user', 'class' => 'table-img-thumb img-circle']), '', ['escapeTitle' => false]);
										    } else {
										        echo $this->Html->link($this->Html->image('blank-avatar.png', ['alt' => 'user', 'class' => 'table-img-thumb img-circle']), '', ['escapeTitle' => false]);
										    }
									    ?></td>
										<td><?php if($childdata->gender == 1){?>
												Male
												<?php } else {?>
												Female
											<?php }?>
										</td>
										<td><?=date('d-m-Y', strtotime($this->Decryption->mc_decrypt($childdata['dob'],$profile->encryptionkey)));?></td>
										<td><?=$childdata['relation'];?></td>
										<td>
											<div class="cs-btn-group">
												<?php echo $this->Html->link('<i class="fa fa-pencil"> </i><span>Edit</span>',['controller' => 'users', 'action' => 'childEdit', $childdata->uuid],['class' => 'btn btn-info','escape' => false]);
												echo $this->Html->link('Basic Info',['controller' => 'users', 'action' => 'basicInfo', $childdata->uuid],['class' => 'btn bg-teal','escape' => false]);  
												echo $this->Form->postLink(__('<i class="fa fa fa-trash"> </i>'.' '.'Delete'), ['controller' => 'users','action' => 'empDelete', $childdata->id], ['class' => 'btn bg-deep-orange','confirm' => __('Are you sure you want to Delete # {0}?', trim($childdata->firstname)),'escape' => false]);?>
												
											</div>
										</td>
									</tr>
								
									<?php $i++ ;}
										if (!empty($value)) {}
    									?>
									
										<td colspan="8">
											<div class="btm-action pull-right">
												<?php $ServiceTyper = array(''=>'Action','3'=>'Delete'); ?>	
												<?= $this->Form->input('parent_id', array('type'=>'select','label'=>false, 'class'=>'form-control usersetup', 'options'=>$ServiceTyper)); ?>
									            <form>

									            </form>
												<!-- <form>
													<select class="form-control show-tick">
														<option value="">-- Action --</option>
														<option value="">Delete</option>
													</select>
												</form> -->
											</div>
										</td>
								</tbody>
							</table>
						</div>
						<div class="pagination-wrap">
							<?php
						echo "<div class='center'><ul class='pagination' style='margin:20px auto;'>";
							echo $this->Paginator->prev('< ' . __('previous'), array('tag' => 'li', 'currentTag' => 'a', 'currentClass' => 'disabled'), null, array('class' => 'prev disabled'));
							echo $this->Paginator->numbers(array('separator' => '','tag' => 'li', 'currentTag' => 'a', 'currentClass' => 'active'));
							echo $this->Paginator->next(__('next').' >', array('tag' => 'li', 'currentTag' => 'a', 'currentClass' => 'disabled'), null, array('class' => 'next disabled'));
						echo "</div></ul>";
						?>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="header">
						<div class="row">
							<div class="col-sm-6">
								<h2 id="guardian-section">
									Guardian List
								</h2>
							</div>
							<div class="col-sm-6 text-right">
							 <?php echo $this->Html->link(
									                'Add Guardian',
									                ['controller' => 'users', 'action' => 'addGuardian',$profile->uuid],
									                ['class' => 'btn bg-light-green','escape' => false]); 
									            ?>
							</div>
						</div>
					</div>
					<div class="body">
						<div class="search-right text-right">
						
                              <?= $this->Form->create('Search',['type'=>'get', 'url' => ['controller'=>'Users', 'action' => 'parentProfile', $profile->uuid, '#' => 'guardian-section'],
                          	]) ?>
                            <div class="form-group">
                            	<?php echo $this->Form->hidden('st',   ['value' => 'guardian-section']);?>
                                <?php echo $this->Form->control('ids',   ['label' => false, 'class'=>'search-input', 'placeholder' => 'Search...']
                                );?>
                                <?php echo $this->Form->control('role',   ['label' => false, 'class'=>'search-input','type'=>'hidden','value'=>'4']
                                );
                                ?>
                               
                                <?= $this->Form->button(__('Search'),['label' => false,'class' => 'btn bg-blue-grey search-btn']) ?>
                            </div>
                            <?= $this->Form->end() ?>
						</div>
						<div class="table-responsive">
							<table class="table table-bordered table-checkbox">
								<thead>
									<tr>
										<th>
											<div class="check-box-cs">
												<input id="checkall" class="filled-in chk-col-red customerIDCell"type="checkbox" value="0">
                                           		 <label for="checkall"></label>
                                           		 <input  class="filled-in chk-col-red" id="role" value="4" type="hidden">
										</th>
										</div>
										<th>#</th>
										<th>Name</th>
										<th>Image</th>
										<th>Gender</th>
										<th>DOB</th>
										<th>Relation</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody class="table_body">
									<?php 
									$i=1; 
									$actionlist = array('Action', 'Delete');
									foreach ($guardian as $key => $value) {
																		
										
									?>
									<tr>
										<td><div class="check-box-cs checkboxes">
								            	<input id="<?=$value['uuid'];?>" class="filled-in chk-col-red cheks" type="checkbox" value="<?=$value['id'];?>">
								           	 	<label for="<?=$value['uuid'];?>"></label>
								        	</div>
								    	</td>
								    	<input  class="filled-in chk-col-red" id="role" value="4" type="hidden">							            		
							    		<input  class="filled-in chk-col-red" id="bso_id" value="<?=$value['bso_id'];?>" type="hidden">
								    	<input  class="filled-in chk-col-red" id="parent_id" value="<?=$value['parent_id'];?>" type="hidden">
										<td><?=$i?></td>
										<td><?=$this->Decryption->mc_decrypt($value['firstname'],$profile->encryptionkey).' '.' '.$this->Decryption->mc_decrypt($value['lastname'],$profile->encryptionkey)?></td>
										<td> <?php
											if (!empty($value['image'])) {
										        echo $this->Html->link($this->Html->image(USER_PICTURE_FOLDER_URL_PATH . $value['uuid'] . '/' . $value['image'], ['alt' => 'user', 'class' => 'table-img-thumb img-circle']), '', ['escapeTitle' => false]);
										    } else {
										        echo $this->Html->link($this->Html->image('blank-avatar.png', ['alt' => 'user', 'class' => 'table-img-thumb img-circle']), '', ['escapeTitle' => false]);
										    }
									    ?></td>
										<td><?php if($value->gender == 1){?>
												Male
												<?php } else {?>
												Female
											<?php }?>
										</td>
										<td><?=date('d-m-Y', strtotime($this->Decryption->mc_decrypt($value['dob'],$profile->encryptionkey)));?></td>
										<td><?=$value['relation'];?>
										</td>
											<td><div class="cs-btn-group">
												<?php echo $this->Html->link('<i class="fa fa-pencil"> </i><span>Edit</span>',['controller' => 'users', 'action' => 'guardianEdit', $value->uuid],['class' => 'btn btn-info','escape' => false]); 
												echo $this->Form->postLink(__('<i class="fa fa fa-trash"> </i>'.' '.'Delete'), ['controller' => 'users','action' => 'empDelete', $value->id], ['class' => 'btn bg-deep-orange','confirm' => __('Are you sure you want to Delete # {0}?', trim($value->firstname)),'escape' => false]);?>
											</div>
										</td>
									</tr>
									<tr>
										<?php $i++ ;}
										if (!empty($value)) {
    									?>
									
									<tr>
										<td colspan="8">
											<div class="btm-action pull-right">
												<?php $ServiceType = array(''=>'Action','3'=>'Delete'); ?>	
												<?= $this->Form->input('parent_id', array('type'=>'select','label'=>false, 'class'=>'form-control usersetup', 'options'=>$ServiceType)); ?>
												<?php #$this->Form->select('parent_id', $actionlist, ['multiple' => false, 'value' => [], 'label' => false, 'class' => 'form-control usersetup']);?>
									            <form>

									            </form>
											</div>
										</td>
									</tr>
									<?php }?>
								</tbody>
							</table>
						</div>
						<div class="pagination-wrap">
							<?php
						echo "<div class='center'><ul class='pagination' style='margin:20px auto;'>";
							echo $this->Paginator->prev('< ' . __('previous'), array('tag' => 'li', 'currentTag' => 'a', 'currentClass' => 'disabled'), null, array('class' => 'prev disabled'));
							echo $this->Paginator->numbers(array('separator' => '','tag' => 'li', 'currentTag' => 'a', 'currentClass' => 'active'));
							echo $this->Paginator->next(__('next').' >', array('tag' => 'li', 'currentTag' => 'a', 'currentClass' => 'disabled'), null, array('class' => 'next disabled'));
						echo "</div></ul>";
						?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>