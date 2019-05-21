<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?=__('Service Setting Management')?></h1>
      <?= $this->Flash->render() ?>
    </section>
    <?php
    	//pr($Setting);die;
    ?>
    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-primary">
					<div class="box-header bso-box-header">
						<h3 class="box-title"><?=__('Manage Service')?></h3>							
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-xs-6">
								<h4><?=__('Price Weekly Service')?></h4>
							</div>
							<div class="col-xs-6">
								<label class="switch">
									<input type="checkbox" class ="priceweekly" name="priceweekly" value="1" <?php if($Setting['priceweekly'] == 1){echo "checked";}?>>
									<span class="slider round"></span>
								</label>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-xs-6">
								<h4><?=__('Price Monthly Service')?></h4>
							</div>
							<div class="col-xs-6">
								<label class="switch">
									<input type="checkbox" class ="pricemonthly" name="pricemonthly" value="1" <?php  if($Setting['pricemonthly'] == 1){echo "checked";}?>>
									<span class="slider round"></span>
								</label>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-xs-6">
								<h4><?=__('Price Yearly Service')?></h4>
							</div>
							<div class="col-xs-6">
								<label class="switch">
									<input type="checkbox" class="priceyearly" name="priceyearly" value="1" <?php  if($Setting['priceyearly'] == 1){echo "checked";}?>>
									<span class="slider round"></span>
								</label>
							</div>
						</div>
						<hr>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
		</div>
		

    </section>
    <!-- /.content -->
  </div>