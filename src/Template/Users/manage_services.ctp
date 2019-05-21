 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?=__('Manage Services')?></h1>
      <?= $this->Flash->render() ?>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="box box-primary">
            <div class="box-header bso-box-header">
				<div class="row">
					<div class="col-xs-7">
						<h3 class="box-title"><?=__('Services List')?> </h3>
					</div>
					<div class="col-xs-5 text-right">
            <?php echo $this->Html->link(
                       'Add Service',
                       ['controller' => 'users','action' => 'addServices'],
                       ['escape' => false,'class'=>'btn btn-theme btn-round']);
            ?>
					</div>
				</div>
              
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="manageservices" class="table table-striped table-hover v-center cell-pd-15">
                <thead>
                <tr>
					<th>
						<div class="cst-check">
							<input type="checkbox" class="cst-check__input">
							<span class="check-holder"><i class="fa fa-check" aria-hidden="true"></i></span>
						</div>
					</th>
                  <th>#</th>
                  <th><?=__('Day')?></th>
                  <th><?=__('Start Time ')?></th>
				  <th><?=__('End Time')?></th>
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
  <!--View Service Modal -->
   <div class="modal fade" id="ViewService">
          <div class="modal-dialog modal-width-450">
            <div class="modal-content">
              <div class="modal-header service-header bg-b-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title service-name"><?=__('Tussenschoolse')?> </h4>
              </div>
              <div class="modal-body">
				<div class="service-info">
					<div class="service-info-row">
						<p> <b><?=__('Day:')?></b> <span><?=__('Dinsdag')?></span></p>
					</div>
					<div class="service-info-row">
						<p> <b><?=__('Start time:')?></b> <span><?=__('10:00 am')?> </span></p>
					</div>
					<div class="service-info-row">
						<p><b><?=__('End time:')?></b> <span><?=__('12:30 pm')?></span></p>
					</div>
					
					<div class="service-info-row">
						<p class="text-center"><b>Age Group</b></p>
						<p> <b>Min Age: </b> <span>4 </span></p>
						<p> <b>Max Age: </b> <span>6 </span></p>
					</div>
					<div class="service-info-row">
						<p> <b>No Of Teachers Allotted: </b> <span>01 </span></p>
					</div>
					<div class="service-info-row">
						<p class="text-center"><b>Price</b></p>
						<p> <b>Weekly: </b> <span>&euro; 50.25 </span></p>
						<p> <b>Monthly: </b> <span>&euro; 180.25 </span></p>
						<p> <b>Yearly: </b> <span>&euro; 2099.99 </span></p>
					</div>
					<div class="service-info-row">
						<p> <b>Status: </b> <span>Active </span></p>
					</div>
				</div>
              </div>
              <div class="modal-footer pt_0 bt_0 text-center">
                <button type="button" class="btn btn-default btn-round-md" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-orange btn-round-md" data-dismiss="modal">Deactivate</button>
                <button type="button" class="btn btn-red btn-round-md" data-dismiss="modal">Delete</button>
                <a href="add-service.php" class="btn btn-theme btn-round-md">Edit</a>
                
				
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->