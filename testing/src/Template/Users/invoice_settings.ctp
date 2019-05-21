<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Invoice Management</h1>
    </section>
    <?php
    //	pr($Setting);die;
    ?>
    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-primary">
					<div class="box-header bso-box-header">
						<h3 class="box-title">Manage Invoice</h3>							
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-xs-6">
								<h4>Generate invoice monthly</h4>
							</div>
							<div class="col-xs-6">
								<label class="switch">
									<input type="radio" class ="invoicetype" name="invoicetype" value="monthly" <?php if($Setting['invoicetype'] == 'monthly'){echo "checked";}?>>
									<span class="slider round"></span>
								</label>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-xs-6">
								<h4>Generate invoice weekly</h4>
							</div>
							<div class="col-xs-6">
								<label class="switch">
									<input type="radio" class ="invoicetype" name="invoicetype" value="weekly" <?php if($Setting['invoicetype'] == 'weekly'){echo "checked";}?>>
									<span class="slider round"></span>
								</label>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-xs-6">
								<h4>Generate invoice automatic</h4>
							</div>
							<div class="col-xs-6">
								<label class="switch">
									<input type="radio" class="invocesendfrmt" name="invocesendfrmt" value="automatic" <?php if($Setting['invocesendfrmt'] == 'automatic'){echo "checked";}?>>
									<span class="slider round"></span>
								</label>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-xs-6">
								<h4>Generate invoice Manually</h4>
							</div>
							<div class="col-xs-6">
								<label class="switch">
									<input type="radio" class="invocesendfrmt" name="invocesendfrmt" value="Manually" <?php if($Setting['invocesendfrmt'] == 'Manually'){echo "checked";}?>>
									<span class="slider round"></span>
								</label>
							</div>
						</div>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
		</div>
		

    </section>
    <!-- /.content -->
  </div>
 