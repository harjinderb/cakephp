<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> <?= $user['firstname']."'".'s'?> <?=__('Attendance')?></h1>+
      <?= $this->Flash->render() ?>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-lg-3 col-md-4">
				<div class="box box-primary">
					<div class="box-body">
						<div class="profile-info-left">
							<div class="profile-image">
								<?php 
                              		if(!empty($user['image'])){
	                                echo $this->Html->link($this->Html->image(USER_PICTURE_FOLDER_URL_PATH.$user['uuid'].'/'.$user['image'], ['alt' => 'John','class' => 'img-responsive max-width-user-pic','id'=>'UplodImg']),'',['escapeTitle' => false,]);
	                            	}else{ ?>
                                                            
                                	<img id="UplodImg" src ='<?php echo $this->request->webroot.'img/no-img.jpg';?>' alt="Image Name" />
                            	<?php }?>
								<!-- <img src="../dist/img/avatar3.png" alt="Nina"> -->
							</div>
							<h3 class="admin-name"><?= $user['firstname'].' '.$user['lastname']?></h3>
							
							<div class="profile-highlight-info">
								<div class="row">
									<div class="col-xs-6">
										<b><?=__('Gender')?></b>
									</div>
									<div class="col-xs-6">
										<?php if($user->gender == 1){?>
											<?=__('Male')?>
										<?php } else {?>
											<?=__('Female')?>
										<?php }?>
										<!-- <p>Female</p> -->
									</div>
								</div>
							</div>
							<div class="profile-highlight-info">
								<div class="row">
									<div class="col-xs-6">
										<b><?=__('DOB')?></b>
									</div>
									<div class="col-xs-6">
										<p> <?=date('d-m-Y', strtotime($user->dob));?></p>
									</div>
								</div>
							</div>
							<div class="profile-highlight-info">
								<div class="row">
									<div class="col-xs-6">
										<b><?=__('School')?></b>
									</div>
									<div class="col-xs-6">
										<p><?= $Schools['name']?></p>
									</div>
								</div>
							</div>
							<div class="profile-highlight-info">
								<div class="row">
									<div class="col-xs-6">
										<b><?=__('Contact Number')?></b>
									</div>
									<div class="col-xs-6">
										<p><?= $parent['mobile_no']?></p>
									</div>
								</div>
							</div>
							<div class="profile-highlight-info">
								<div class="row">
									<div class="col-xs-6">
										<b><?=__('Pending Paymnet')?></b>
									</div>
									<div class="col-xs-6">
										<p></p>
									</div>
								</div>
							</div>
							<div class="profile-highlight-info">
								<div class="row">
									<div class="col-xs-6">
										<b><?=__('Pay by Date')?></b>
									</div>
									<div class="col-xs-6">
										<p></p>
									</div>
								</div>
							</div>
								
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-9 col-md-8">
				<div class="box box-primary">
					<?= $this->Form->hidden('child_id',   ['value'=> $user['uuid'],'id' => 'child_id']); ?>
					<div class="box-header bso-box-header">
						<h3 class="box-title"><?=__('Attendance')?> - <?= date('Y')?></h3>
					</div>
					<div class="box-body no-padding">
						 <div id="attendance"  class="attendance-wrap child-wrap"></div>
							<div class="attendance-info">
								<!-- <div class="row">
									<div class="col-md-3">
										<h4><?php //echo__(' Total Present')?>: <span class="present-color">41</span></h4>
									</div>
									<div class="col-md-3">
										<h4> <?//echo__('Total Leave')?>: <span class="leave-color">04</span></h4>
									</div>
									<div class="col-md-3">
										<h4><?//echo__(' Total Absent')?>: <span class="absent-color">05</span></h4>
									</div>
									<div class="col-md-3">
										<h4> <?//echo__('Total Holiday')?>: <span class="holoday-color">57</span></h4>
									</div>
								</div> -->
							</div>
					</div>
				<!-- /.box-body -->
				</div>
			  <!-- /.box -->
			</div>
		</div>	
		

    </section>
    <!-- /.content -->
  </div>