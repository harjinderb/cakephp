<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1><?=__('Plan setting for overtime')?></h1>
		<?= $this->Flash->render() ?>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="box box-primary">
			<div class="box-header bso-box-header">
				<h3 class="box-title"><?=__('Select Plan')?></h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<table id="example1" class="table table-striped table-hover v-center cell-pd-15">
					<thead>
						<tr>
							<th>#</th>
							<th><?=__('Day')?></th>
							<th><?=__('Start Time ')?></th>
							<th><?=__('End Time')?></th>
							<th><?=__('Action')?></th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$url = $this->request->getUri(); 
    						$lastWord = substr($url, strrpos($url, '/') + 1);
							$i = 1;
							//pr($BsoServices);
							foreach ($BsoServices as $key => $value) {
							?>
						<tr>
							<td><?= $i;?></td>
							<td><?= $value['service_day'];?></td>
							<td><?= date('h:i:s',strtotime($value['start_time'])) ?></td>
							<td><?= date('h:i:s',strtotime($value['end_time']))?></td>
							<input  class="filled-in chk-col-red" id="uuid" value="<?=$value['uuid']?>" type="hidden">
							<td>
								<div class="btn__group">
									<?= $this->Form->button(__('View'),['data-toggle' =>'modal', 'data-target'=>'#ViewService','class' => 'btn btn-green-border ViewService','value' => $value['uuid']]);
										?>
									<!-- <a href="javascript:void(0)" data-toggle="modal" data-target="#ViewService" class="btn btn-green-border ViewService" value = "<?php // $value['uuid']?>">View</a> -->
									<?= $this->Form->button(__('Assign Plan'),['data-toggle' =>'modal', 'data-target'=>'#AsignService','class' => 'btn btn-theme-border AsignService','value' => $value['uuid']]);
										?>
									<!-- <a href="javascript:void(0)" class="btn btn-theme-border" data-toggle ='modal' data-target ='#AsignService'>Assign Plan</a> ,'value' => $value['uuid']]-->
								</div>
							</td>
						</tr>
						<?php $i++; }?>
					</tbody>
				</table>
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</section>
	<!-- /.content -->
</div>
<!--View Service Modal -->
<div class="modal fade" id="ViewService">
	<div class="modal-dialog modal-width-450 viewselectmodel">
		<img src=<?= '"'. BASE_URL.'/img/loading.gif"'?> class="" alt="">
		<div class="modal-footer pt_0 bt_0 text-center">
			<button type="button" class="btn btn-default btn-round-md" data-dismiss="modal">Close</button>
			<?= $this->Form->button('Assign Plan',['data-toggle' =>'modal', 'data-target'=>'#AsignService','class' => 'btn btn-theme-border AsignService','value' => $value['uuid']]);
			?>
		</div>
	</div>
	<!-- /.modal-content -->
</div>

<div class="modal fade" id="AsignService">
	<?= $this->Form->control('child_id', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> $lastWord]);?>
<div class="modal-dialog Asignselectmodel">

	<img src=<?= '"'. BASE_URL.'/img/loading.gif"'?> class="" alt="">
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>