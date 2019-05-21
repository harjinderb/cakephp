<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?=__('Child List')?></h1>
      <?= $this->Flash->render() ?>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-primary">
					<div class="box-header bso-box-header">
						<h3 class="box-title"><?=__('Recive Payment For Child')?></h3>							
					</div>
					 <div class="box-body">
              <table id="childsinvoice" class="table table-striped table-hover v-center cell-pd-15">
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
			 	  <th><?=__('Action')?></th>
                </tr>
                </thead>
                 <tbody>
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