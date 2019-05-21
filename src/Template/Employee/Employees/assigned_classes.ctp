<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1><?=__('Assigned Classes')?></h1>
		<?= $this->Flash->render() ?>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="box box-primary">
			<div class="box-body">
				<div class="nav-tabs-custom cs-tab-round child-view-info assigned-classes">
					<ul class="nav nav-tabs">
						<?php 
							$current_date = date('d-m-Y');
							$day = strtolower(date('l', strtotime($current_date)));
						?>
						<li <?php if($day == 'monday'){echo 'class="active"';}?>><a class="whichday" value="monday" data-toggle="tab"><?=__('Monday')?></a></li>
						<li <?php if($day == 'tuesday'){echo 'class="active"';}?>><a class="whichday" value="tuesday" data-toggle="tab"><?=__('Tuesday')?></a></li>
						<li <?php if($day == 'wednesday'){echo 'class="active"';}?>><a class="whichday" value="wednesday" data-toggle="tab"><?=__('Wednesday')?></a></li>
						<li <?php if($day == 'thursday'){echo 'class="active"';}?>><a class="whichday" value="thursday" data-toggle="tab"><?=__('Thursday')?></a></li>
						<li <?php if($day == 'friday'){echo 'class="active"';}?>><a class="whichday" value="friday" data-toggle="tab"><?=__('Friday')?></a></li>
						<li <?php if($day == 'saturday'){echo 'class="active"';}?>><a class="whichday" value="saturday" data-toggle="tab"><?=__('Saturday')?></a></li>
						<li <?php if($day == 'saturday'){echo 'class="active"';}?>><a class="whichday" value="sunday" data-toggle="tab"><?=__('Sunday')?></a></li>
					</ul>
					<div class="tab-content">
						<div class="">
							<table class="table table-striped table-hover v-center cell-pd-15">
								<thead>
									<tr>
										<th>#</th>
										<th><?=__('Service')?></th>
										<th><?=__('Start Time')?></th>
										<th><?=__('End Time')?></th>
										<th><?=__('Status')?></th>
										<th><?=__('Action')?></th>
									</tr>
								</thead>
								<tbody id="outputemp">

									
									<?php
									$uuid = $this->request->getSession()->read('Auth.User.uuid');
									$i = 1;
										//pr($finalservices);die;
										foreach ($finalservices as $key => $value) {
										//pr($value);die;
									
									?>

									<tr>
										<td><?= $i?></td>
										<td><?= $value[0]->service_day?></td>
										<td><?= date('h:i:s', strtotime($value[0]->start_time))?></td>
										<td><?= date('h:i:s', strtotime($value[0]->end_time))?></td>
										<td><span class="label label-bg-green label-110 label-round">Assigned</span></td>
										<td>
											<div class="btn__group">
												<?php 
										echo $this->Html->link('View Student List',['controller' => 'Employees', 'action' => 'assignStudents',$uuid,$value[0]->service_day,'prefix'=>'employee'],['escape' => false,'class'=>'btn btn-green-border']); ?>
												
											</div>
										</td>
									</tr>

								<?php $i++; } ?>
								</tbody>
							</table>
						</div>
						
						<!-- /.tab-pane -->
						
					</div>
				</div>
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</section>
	<!-- /.content -->
</div>