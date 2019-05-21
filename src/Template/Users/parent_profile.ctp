<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?=__('Parent Detail')?></h1>
       <?= $this->Flash->render() ?>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="box box-primary">
            <div class="box-header bso-box-header">
				<div class="row">
					<div class="col-xs-7">
						<h3 class="box-title"><?=__('Details')?></h3>
					</div>
					<div class="col-xs-5 text-right">
						<?php echo $this->Html->link(
			                __('Add new child'),
			                ['controller' => 'users', 'action' => 'addChild',$profile->uuid],
			                ['class' => 'btn btn-theme btn-round','escape' => false]); 
		                ?>
						<?php 
								echo $this->Html->link(
					                __('Add new guardian'),
					                ['controller' => 'users', 'action' => 'addGuardian',$profile->uuid],
					                ['class' => 'btn btn-theme btn-round','escape' => false]); 
			            ?>
					</div>
				</div>
              
            </div>
            <!-- /.box-header -->
            <div class="box-body">
					<div class="row">
						<div class="col-md-2 col-sm-3">
							<div class="parent-img-left">
							<?php
								if(!empty($profile['image'])){
									echo $this->Html->link($this->Html->image(USER_PICTURE_FOLDER_URL_PATH.$profile['uuid'].'/'.$profile['image'], ['alt' => 'John','class' => 'img-responsive max-width-user-pic']),'',['escapeTitle' => false,]);
								}else{								
									echo $this->Html->link($this->Html->image('blank-avatar.png', ['alt' => 'John','class' => 'img-responsive max-width-user-pic']),'',['escapeTitle' => false,]);
								}
							?>
							</div>
						</div>
						<div class="col-md-10 col-sm-9">
							<div class="row">
								<div class="col-md-6">
									<div class="info-group">
										<label><?=__('First Name')?></label>
										<p><?=$profile->firstname?></p>
									</div>
								</div>
								<div class="col-md-6">
									<div class="info-group">
										<label><?=__('Last Name')?></label>
										<p><?=$profile->lastname?></p>
									</div>
								</div>
							</div>
			
							<div class="row">
								<div class="col-md-6">
									<div class="info-group">
										<label><?=__('Email Address')?></label>
										<p><?=$profile->email?></p>
									</div>
								</div>
								<div class="col-md-6">
									<div class="info-group">
										<label>Mobile Number</label>
										<p><?=$profile->mobile_no?></p>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="info-group">
										<label><?=__('Date of Birth')?></label>
										<p><?=date('d-m-Y', strtotime($profile->dob));?></p>
									</div>
								</div>
								<div class="col-md-6">
									<div class="info-group">
										<label><?=__('Gender')?></label>
										<p>
											<?php if($profile->gender == 1){?>
												<?=__('Male')?>
											<?php } else {?>
												<?=__('Female')?>
											<?php }?>
										</p>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="info-group">
										<label><?=__('BSN No')?>:</label>
										<p><?= $profile->bsn_no?></p>
									</div>
								</div>
								<div class="col-md-6">
									<div class="info-group">
										<label><?=__('Pin Code')?></label>
										<p><?=$profile->post_code?></p>
									</div>	
								</div>
							</div>	
							
							<div class="row">
								<div class="col-md-6">
									<div class="info-group">
										<label><?=__('Bank Name')?></label>
										<p><?=$profile->bank_name?></p>
									</div>
								</div>
								<div class="col-md-6">
									<div class="info-group">
										<label><?=__('Account Number')?></label>
										<p><?=$profile->account?></p>
									</div>	
								</div>
							</div>	
							
							<div class="info-group">
								<label><?=__('Address (Area and Street)')?></label>
								<p><?=$profile->address?></p>
							</div>
							<div class="info-group">
										<label><?=__('City/District')?> </label>
										<p><?=$profile->residence?></p>
							</div>
						</div>
					</div>

					
				</form>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
		  </div>
		  
		  <div class="box box-primary mt_30">
            <div class="box-header bso-box-header">
				<div class="row">
					<div class="col-xs-7">
						<h3 class="box-title"><?=__('Children List')?></h3>
					</div>
					<div class="col-xs-5 text-right">
						<?php echo $this->Html->link(
			                'Add new child',
			                ['controller' => 'users', 'action' => 'addChild',$profile->uuid],
			                ['class' => 'btn btn-theme btn-round','escape' => false]); 
		                ?>
					</div>
				</div>
              
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-striped table-hover v-center cell-pd-15">
                <thead>
                <tr>
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
                		$i = 1;
                		if(empty($childs)){
                			$childs = '';
                		}else{
                			$childs = $childs;
                		
                			foreach ($childs as $key => $childdata) {
										$childdata['uuid'];
									
					?>
                <tr>
                  <td><?=$i?></td>
					<td><?= $childdata['firstname'].' '.$childdata['lastname']?></td>
					<td>
						<?php
							if (!empty($childdata['image'])) {
						        echo $this->Html->link($this->Html->image(USER_PICTURE_FOLDER_URL_PATH . $childdata['uuid'] . '/' . $childdata['image'], ['alt' => 'user', 'class' => 'table-img-thumb img-circle']), '', ['escapeTitle' => false]);
						    } else {
						        echo $this->Html->link($this->Html->image('blank-avatar.png', ['alt' => 'user', 'class' => 'table-img-thumb img-circle']), '', ['escapeTitle' => false]);
						    }
					    ?>
				    </td>
					<td>
					<?php if($childdata->gender == 1){?>
							Male
							<?php } else {?>
							Female
					<?php }?>
					</td>
					<td><?=date('d-m-Y', strtotime($childdata['dob']));?></td>
					<td><?=$childdata['relation'];?></td>
					<td>
						<div class="btn__group">
							<!-- <a href="#" class="btn btn-green-border">View</a> -->
						<?php
							echo $this->Html->link('View',['controller' => 'users', 'action' => 'childview', $childdata->uuid],['class' => 'btn btn-green-border','escape' => false]);  
							echo $this->Html->link('Edit',['controller' => 'users', 'action' => 'childEdit', $childdata->uuid],['class' => 'btn btn-theme-border','escape' => false]);
							echo $this->Html->link('view Attendance',['controller' => 'users', 'action' => 'attendance', $childdata->uuid],['class' => 'btn btn-dark-green-border','escape' => false]); 	
							echo $this->Form->postLink(__('Delete'), ['controller' => 'users','action' => 'delete',$childdata->uuid],['class' => 'btn btn-red-border','confirm' => __('Are you sure you want to Delete # {0}?'),'escape' => false]);
					 	?>
						</div>
					</td>
                </tr>
			<?php $i++; } }?>
                </tbody>
                
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
		  
		  <div class="box box-primary mt_30">
            <div class="box-header bso-box-header">
				<div class="row">
					<div class="col-xs-7">
						<h3 class="box-title">Guardian List  </h3>
					</div>
					<div class="col-xs-5 text-right">
						<?php 
								echo $this->Html->link(
					                'Add new guardian',
					                ['controller' => 'users', 'action' => 'addGuardian',$profile->uuid],
					                ['class' => 'btn btn-theme btn-round','escape' => false]); 
			            ?>
					</div>
				</div>
              
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-striped table-hover v-center cell-pd-15">
                <thead>
                <tr>
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
                		$i =1;
                		if(empty($guardian)){
                			$guardian = '';
                		}else{
                			$guardian = $guardian;
                		
                		foreach ($guardian as $key => $value) {
					?>
                <tr>
                    <td><?=$i?></td>
					<td><?= $value['firstname'].' '.$value['lastname'];?></td>
					<td>
						<?php
								if (!empty($value['image'])) {
							        echo $this->Html->link($this->Html->image(USER_PICTURE_FOLDER_URL_PATH . $value['uuid'] . '/' . $value['image'], ['alt' => 'user', 'class' => 'table-img-thumb img-circle']), '', ['escapeTitle' => false]);
							    } else {
							        echo $this->Html->link($this->Html->image('blank-avatar.png', ['alt' => 'user', 'class' => 'table-img-thumb img-circle']), '', ['escapeTitle' => false]);
							    }
						    ?>
				    </td>
					<td><?php if($value->gender == 1){?>
							Male
							<?php } else {?>
							Female
						<?php }?>
					</td>
					<td><?=date('d-m-Y', strtotime($value['dob']));?></td>
					<td><?=$value['relation'];?></td>
					
					<td>
						<div class="btn__group">
							<a href="#" class="btn btn-green-border viewgurdn" attrid ="<?= $value->uuid?>">View</a>
							<?php 
								echo $this->Html->link('Edit',['controller' => 'users', 'action' => 'guardianEdit', $value->uuid],['class' => 'btn btn-theme-border','escape' => false]); 
								echo $this->Form->postLink(__('Delete'), ['controller' => 'users','action' => 'delete',$value->uuid],['class' => 'btn btn-red-border','confirm' => __('Are you sure you want to Delete # {0}?'),'escape' => false]);
							?>
						</div>
					</td>
                </tr>
			<?php $i++; }
			}
			?>
                </tbody>
                
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!--View Guardian Modal -->
   <div class="modal fade" id="ViewGuardian">
          
      
        </div>