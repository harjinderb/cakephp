 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?=__('Guardian Detail')?></h1>
      <?= $this->Flash->render() ?>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="box box-primary mt_30">
            <div class="box-header bso-box-header">
				<div class="row">
					<div class="col-xs-7">
						<h3 class="box-title"><?=__('Guardian List')?></h3>
					</div>
					<div class="col-xs-5 text-right">
						<?php 
								echo $this->Html->link(
				                'Add new guardian',
				                ['controller' => 'users', 'action' => 'addGuardian'],
				                ['class' => 'btn btn-theme btn-round','escape' => false]); 
			            ?>
					</div>
				</div>
              
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="manageguardian" class="table table-striped table-hover v-center cell-pd-15">
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
        				  <th><?=__('Relation')?></th>
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
 <!--View Guardian Modal -->
   <div class="modal fade" id="ViewGuardian">
          
      
        </div>