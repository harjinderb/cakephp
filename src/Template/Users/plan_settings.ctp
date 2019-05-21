<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?=__('Plan setting')?></h1>
      <?= $this->Flash->render() ?>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-primary">
					<div class="box-header bso-box-header">
						<h3 class="box-title"><?=__('Select Child')?></h3>							
					</div>
					 <div class="box-body">
              <table id="example1" class="table table-striped table-hover v-center cell-pd-15">
                <thead>
                <tr>
					<th>
						<div class="cst-check">
							<input type="checkbox" class="cst-check__input">
							<span class="check-holder"><i class="fa fa-check" aria-hidden="true"></i></span>
						</div>
					</th>
                  <th>#</th>
                  <th><?=__('Name')?></th>
                  <th><?=__('Image')?></th>
				  <th><?=__('Gender')?></th>
				  <th><?=__('DOB')?></th>
				  <!-- <th>REG ID:</th> -->
				 <!--  <th>Status</th> -->
				  <th><?=__('Action')?></th>
                </tr>
                </thead>
                <tbody>
                <?php 
                $i = 1;
                	//pr($users);die();
                	foreach ($users as $key => $value) {
                		$keycode = $value['encryptionkey'];
                ?>
				<tr>
                  <td>
					  <div class="cst-check">
							<input type="checkbox" class="cst-check__input">
							<span class="check-holder"><i class="fa fa-check" aria-hidden="true"></i></span>
						</div>
					</td>
					<td><?=$i?></td>
					<td><?= $this->Decryption->mc_decrypt($value['firstname'],$value['encryptionkey']).' '.$this->Decryption->mc_decrypt($value['lastname'],$value['encryptionkey'])?></td>
					<td><?php
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
									<?php }?></td>
					<td> <?=date('d-m-Y', strtotime($this->Decryption->mc_decrypt($value->dob,$value->encryptionkey)));?></td>
					<!-- <td>00234</td> -->
					<!-- <td> -->
						<?php
						// if($value['is_active'] == 1){ 
						// 	echo $this->Form->postLink(__('Deactivate'), ['controller' => 'Employees','action' => 'empDeactivate', $value->uuid, 'prefix' => 'employee'], ['class' => 'label label-bg-green label-110 label-round','confirm' => __('Are you sure you want to Deactivate {0}', trim($this->Decryption->mc_decrypt($value['firstname'],$keycode) .' '.$this->Decryption->mc_decrypt($value['lastname'],$keycode))),'escape' => false]);
						// }

						// if($value['is_active'] == 0){ 
						// 	echo $this->Form->postLink(__('Activate'), ['controller' => 'Employees','action' => 'empActivate', $value->uuid, 'prefix' => 'employee'], ['class' => 'label label-bg-orange label-110 label-round','confirm' => __('Are you sure you want to Activate {0}', trim($this->Decryption->mc_decrypt($value['firstname'],$keycode) .' '.$this->Decryption->mc_decrypt($value['lastname'],$keycode))),'escape' => false]);
						// } 	
						?>
					<!-- </td> -->
					
					<td>
						<div class="btn__group">
							<?php echo $this->Html->link(
				                __('Select New Plan'),
				                ['controller' => 'users', 'action' => 'selectPlan', $value->uuid],
				                ['class' => 'btn btn-green-border','escape' => false]); 
				            ?>
							<?php echo $this->Html->link(
				                __('Shift Plan'),
				                ['controller' => 'users', 'action' => 'shiftPlan', $value->uuid],
				                ['class' => 'btn btn-orange-border','escape' => false]); 

							echo $this->Html->link('view Attendance',['controller' => 'users', 'action' => 'attendance', $value->uuid],['class' => 'btn btn-dark-green-border','escape' => false]); 
				            ?>
							
						</div>
					</td>
                </tr>
				<?php $i++; }?>
				
			
                </tbody>
                
              </table>
            </div>
            <!-- /.box-body -->
				</div>
			</div>
		</div>
		

    </section>
    <!-- /.content -->
  </div>