`<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?=__('Buy Service')?></h1>
      <?= $this->Flash->render() ?>
     </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			 <?= $this->Flash->render() ?>
			<?php
			$child_id = $this->request->query('child_id');
			$service_id = $this->request->query('service_id');
			$days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday','Saturday','Sunday'];
			foreach ($days as $key => $value) {
				
			?>

			<div class="col-lg-4 col-md-6 col-sm-6">
				<div class="box box-no-border">
					<div class="box-header bso-box-header">
						<div class="row">
							<div class="col-xs-7">
								<h3 class="box-title"><?=__($value)?></h3>
							</div>
							<div class="col-xs-5 text-right">
								<!-- <a href="select-child.php" class="btn btn-theme btn-round-md">Buy Now</a> --> 
								
								<?php echo $this->Html->link(
									                __('Buy Now'),
									                ['controller' => 'users', 'action' => 'buyPlan','day'=> $value,'child_id' => $child_id,'service_id' => $service_id,'prefix' => 'parent'],
									                ['class' => 'btn btn-theme btn-round-md','escape' => false]); 
								
									?>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php }?>
	</section>
    <!-- /.content -->
  </div>