  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?=__('Employee')?></h1>
      <?= $this->Flash->render() ?>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="box box-primary">
            <div class="box-header bso-box-header">
				<div class="row">
					<div class="col-xs-7">
						<h3 class="box-title"><?=__('Employee List')?></h3>
					</div>
					<div class="col-xs-5 text-right">
						<?php echo $this->Html->link(
	                     __('Add new employee'),
	                     ['controller' => 'Employees','action' => 'addEmployee', 'prefix' => 'employee'],
	                     ['escape' => false,'class'=>'btn btn-theme btn-round']);
						?>
					</div>
				</div>
              
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="employees" class="table table-striped table-hover v-center cell-pd-15">
                <thead>
                <tr>
					<th>
						<div class="cst-check">
							<input type="checkbox" class="cst-check__input">
							<span class="check-holder"><i class="fa fa-check" aria-hidden="true"></i></span>
						</div>
					</th>
                  <th>#</th>
                  <th><?=__('Emp. ID')?></th>
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
  
  <!--View Employee Modal -->
   <div class="modal fade" id="ViewEmpModal">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header employee-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?=__('Employee Details')?></h4>
              </div>
              <div class="modal-body">
				<div class="employee-info-modal">
					<div class="info-group">
						<?php if(!empty($user['image'])){
												echo $this->Html->link($this->Html->image(USER_PICTURE_FOLDER_URL_PATH.$user['uuid'].'/'.$user['image'], ['alt' => 'John','class' => 'img-responsive max-width-user-pic','id'=>'UplodImg']),'',['escapeTitle' => false,]);
											}else{ ?>
											
												<img id="UplodImg" src="<?php echo $this->request->webroot.'img/no-img.jpg';?>" alt="Image Name"/>
									<?php }
									?>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="info-group">
								<label><?=__('First Name')?></label>
								<p>Rahul</p>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="info-group">
								<label><?=__('Last Name')?></label>
								<p>Manchanda</p>
							</div>
						</div>						
					</div>
					<div class="info-group">
						<label>Email Address</label>
						<p>rahul.manchanda@offshoresolutions</p>
					</div>
					<div class="info-group">
						<label>Mobile Number</label>
						<p>9876543210</p>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="info-group">
								<label>Employee Id</label>
								<p>002</p>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="info-group">
								<label>Joining Date</label>
								<p>17 Nov. 2018</p>
							</div>
						</div>					
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="info-group">
								<label>Date of Birth</label>
								<p>16 Aug 1980</p>
							</div>
						</div>	
						<div class="col-sm-6">
							<div class="info-group">
								<label>Gender</label>
								<p>Male</p>
							</div>
						</div>	
					</div>
					<div class="info-group">
						<label>Address</label>
						<p>Schout Lieshoutstraat 2, 5251-TP Vlijmen </p>
					</div>
					
				</div>
              </div>
              <div class="modal-footer pt_0 bt_0">
               
                <a href="edit-employee.php" class="btn btn-theme btn-round-md">Edit</a>
                <button type="button" class="btn btn-red btn-round-md" data-dismiss="modal">Delete</button>
				 <button type="button" class="btn btn-default btn-round-md" data-dismiss="modal">Close</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
  