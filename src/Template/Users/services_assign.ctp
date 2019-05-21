<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?=__('Assign Teacher')?></h1>
      <?= $this->Flash->render() ?>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="box">
          <div class="box-header bso-box-header assign-teacher">
            <h3 class="box-title"><?=__('Regular Assign')?></h3>
          </div>
           <div class="box-body">
            <div class="assign-employe">
              <table class="table table-striped table-hover v-center">
                <thead>
                <tr>
                  <th>#</th>
                  <th><?=__('Emp. ID')?></th>
                  <th><?=__('Name')?></th>
                  <th><?=__('Action')?></th>
                </tr>
                </thead>
                <?= $this->Form->hidden('Bsoservices',   ['value'=> $BsoServices->uuid]); ?>
                <tbody class ="regularmodel">
                  <?php  
                   // pr($validemployees);die;
                    $i = 1;
                    foreach ($validemployees as $key => $value) {
                  ?>
                <tr>
                  <td><?= $i;?></td>
                  <td><?="Emp-ID".$value['user_id']?></td>
                  <td><?= $value['firstname']." ".$value['lastname']?></td>
                  <td><a href="javascript:void(0)" class="btn btn-theme-border nowassign" data-dismiss="modal" data-value =<?= $value['user_id']?>>Assign</a></td>
                </tr>
              <?php $i++ ; } ?>
                
                
                   
                </tbody>
                
              </table>
            </div>
           </div>
          
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="box">
          <div class="box-header bso-box-header assign-teacher">
            <h3 class="box-title"><?=__('Overtime Assign')?></h3>
          </div>
           <div class="box-body">
            <div class="assign-employe">
              <table class="table table-striped table-hover v-center">
                <thead>
                <tr>
                  <th>#</th>
                  <th><?=__('Emp. ID')?></th>
                  <th><?=__('Name')?></th>
                  <th><?=__('Action')?></th>
                </tr>
                </thead>
                <?= $this->Form->hidden('Bsoservices',   ['value'=> $BsoServices->uuid]); ?>
                <tbody class ="regularmodel">
                  <?php  
                    //pr($valid_employees);die;
                    $i = 1;
                    foreach ($valid_employees as $key => $value) {
                  ?>
                <tr>
                  <td><?= $i;?></td>
                  <td><?="Emp-ID".$value['id']?></td>
                  <td><?= $value['firstname']." ".$value['lastname']?></td>
                  <td><a href="javascript:void(0)" class="btn btn-theme-border nowassign" data-dismiss="modal" data-value =<?= $value['id']?>>Assign</a></td>
                </tr>
              <?php $i++ ; } ?>
                </tbody>
                
              </table>
            </div>
           </div>
          
        </div>
      </div>
    
    </div>
      
    <div class="box box-primary">
            <div class="box-header bso-box-header">
        <div class="row">
          <div class="col-xs-7">
            <h3 class="box-title"><?=__('Assigned Teacher')?></h3>
          </div>
        </div>
              
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-striped table-hover v-center cell-pd-15">
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
                  <th><?=__('Assigned Plan')?></th>
                  <th><?=__('Action')?></th>
                </tr>
                </thead>
                <tbody>
                  <?php 
                  $i = 1;
                  //pr($BsoServices);die;
                  foreach ($users as $key => $value) {
                                      
                  ?>
                <tr>
                  <td>
            <div class="cst-check">
              <input type="checkbox" class="cst-check__input">
              <span class="check-holder"><i class="fa fa-check" aria-hidden="true"></i></span>
            </div>
          </td>
          <td><?= $i ?></td>
          <td><?php 
          if(!empty($value['registration_id'])){
           echo 'Emp-ID'. $value->registration_id;
          }?></td>
          <td><?php
          if(!empty($value['firstname'])){
           echo $this->Decryption->mc_decrypt($value->firstname,$value->encryptionkey) .' '. $this->Decryption->mc_decrypt($value->lastname,$value->encryptionkey);
          }else{
            echo "No teacher Assign Yet";
          }
          ?></td>
          <td>
            <?php
            if($value['uuid'] != ''){
              if (!empty($value['image'])) {
                      echo $this->Html->link($this->Html->image(USER_PICTURE_FOLDER_URL_PATH . $value['uuid'] . '/' . $value['image'], ['alt' => 'user', 'class' => 'table-img-thumb img-circle']), '', ['escapeTitle' => false]);
                  } else {
                      echo $this->Html->link($this->Html->image('blank-avatar.png', ['alt' => 'user', 'class' => 'table-img-thumb img-circle']), '', ['escapeTitle' => false]);
                  }
              } 
              ?>
          </td>
          <td><?php 
          if($value['uuid'] != ''){
          echo $BsoServices->service_day.' '?>
          <span class="day-small"><?=date("H:i:s", strtotime($BsoServices['start_time'])) .'-'.date("H:i:s", strtotime($BsoServices['end_time']))?></span></td>
        <?php }?>
          <td>
            <?php
            //pr($value['uuid']);die;
              if($value['uuid'] != ''){
              //   echo $this->Html->link(
              //     'Delete',
              //     array('controller' => 'users', 'action' => 'deleteAsignteacher', 'prefix' => false, $BsoServices->id,$value['id']),
              //     array('confirm' => 'Are you sure you wish to delete this recipe?')
              // );
                echo $this->Form->postLink(__('<i class="fa fa fa-trash"> </i>' . ' ' . 'Delete'), ['controller' => 'users', 'action' => 'deleteAsignteacher', 'prefix' => false, $BsoServices->id,$value['id']], ['class' => 'btn btn-danger', 'confirm' => __('Are you sure you want to Delete {0}', $BsoServices->service_day.' '.date("H:i:s", strtotime($BsoServices['start_time'])) .'-'.date("H:i:s", strtotime($BsoServices['end_time']))), 'escape' => false]);
              }
            ?>
          </td>
                </tr>
            <?php $i ++ ;} ?>
         
                </tbody>
                
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  
  <!--Assign Regular Employee Modal -->
   <div class="modal fade" id="Regular-assign">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header employee-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Assign Teacher</h4>
              </div>
              <div class="modal-body">
          <table id="example1" class="table table-striped table-hover v-center cell-pd-15">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Emp. ID</th>
                  <th>Name</th>
          <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr>
          <td>1</td>
          <td>001</td>
          <td>Rakesh Kumar</td>
          <td><a href="javascript:void(0)" class="btn btn-theme-border" data-dismiss="modal">Assign</a></td>
                </tr>
         <tr>
                 
          <td>2</td>
          <td>002</td>
          <td>Rahul Manchanda</td>
          <td><a href="javascript:void(0)" class="btn btn-theme-border" data-dismiss="modal">Assign</a></td>
                </tr>
         <tr>
                 
          <td>3</td>
          <td>003</td>
          <td>Shikha Sharma</td>
          <td><a href="javascript:void(0)" class="btn btn-theme-border" data-dismiss="modal">Assign</a></td>
                </tr>
        
        
           
                </tbody>
                
              </table>
              </div>
              <div class="modal-footer pt_0 bt_0">
         <button type="button" class="btn btn-default btn-round-md" data-dismiss="modal">Close</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    
      <!--Overtime assign Employee Modal -->
   <div class="modal fade" id="Overtime-assign">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header employee-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Assign Teacher</h4>
              </div>
              <div class="modal-body">
          <table id="example1" class="table table-striped table-hover v-center cell-pd-15">
                <thead>
                <tr>
                  <th>#</th>
                  <th><?=__('Emp. ID')?></th>
                  <th><?=__('Name')?></th>
          <th><?=__('Action')?></th>
                </tr>
                </thead>
                <tbody>
                
        
         
           
                </tbody>
                
              </table>
              </div>
              <div class="modal-footer pt_0 bt_0">
         <button type="button" class="btn btn-default btn-round-md" data-dismiss="modal"><?=__('Close')?></button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->