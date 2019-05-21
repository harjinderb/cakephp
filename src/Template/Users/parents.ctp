
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?=__('Parent')?></h1>
      <?= $this->Flash->render() ?>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="box box-primary">
            <div class="box-header bso-box-header">
				<div class="row">
					<div class="col-xs-7">
						<h3 class="box-title"><?=__('Parent List')?></h3>
					</div>
					<div class="col-xs-5 text-right">
						<?php echo $this->Html->link(
	                     'Add new parent',
	                     ['controller' => 'users','action' => 'addparents'],
	                     ['escape' => false,'class'=>'btn btn-theme btn-round']);
						?>
					</div>
				</div>
              
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="parentlist" class="table table-striped table-hover v-center cell-pd-15">
                <thead>
                <tr>
					<th>
						<div class="cst-check">
							<input type="checkbox" class="cst-check__input">
							<span class="check-holder"><i class="fa fa-check" aria-hidden="true"></i></span>
						</div>
					</th>
                  <th>#</th>
                  <th><?=__('BSN No.')?></th>
                  <th><?=__('Name')?></th>
                  <th><?=__('Image')?></th>
        				  <th><?=__('Gender')?></th>
        				  <th><?=__('Status')?></th>
        				  <th><?=__('Action')?></th>
                </tr>
                </thead>
                <tbody>
                </tbody>
                
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>