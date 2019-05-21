  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=__('Dashboard')?>
        <small><?=__('Parent Admin Panel')?></small>
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
    <div class="row">
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="small-box bg-b-blue info-box-cst">
          <div class="inner">
            <p><?=__('My Children')?></p>
            <h3><?php 
            if(empty($childern->toArray())){
              echo "0";
            }else{
              echo count($childern);
            }
            ?></h3>
          </div>
          <div class="icon">
             <i class="fa fa-child" aria-hidden="true"></i>
          </div>
          <?php 
            echo $this->Html->link('More info <i class="fa fa-arrow-circle-right"></i>',['controller' => 'users', 'action' => 'manageChildren', 'prefix' => 'parent'],['class'=>'small-box-footer','escape' => false]);
          ?>
          <!-- <a href="javascript:void(0)" class="small-box-footer">
            More info <i class="fa fa-arrow-circle-right"></i>
          </a> -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="small-box bg-b-green info-box-cst">
          <div class="inner">
            <p><?=__('My Services')?></p>
            <h3><?php 
           
            if(empty($plandata)){
              echo "0";
            }else{
              echo count($plandata);
            }
            ?></h3>
          </div>
          <div class="icon">
           <i class="fa fa-cogs" aria-hidden="true"></i>
          </div>
          <?php
            $uuid = $this->request->getSession()->read('Auth.User.uuid');
            echo $this->Html->link('More info <i class="fa fa-arrow-circle-right"></i>',
              ['controller' => 'users', 
                'action' => 'myServices',$uuid,
                 'prefix' => 'parent'],
              ['class'=>'small-box-footer','escape' => false]
            );
          ?>
          <!-- <a href="javascript:void(0)" class="small-box-footer">
            More info <i class="fa fa-arrow-circle-right"></i>
          </a> -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="small-box bg-aqua info-box-cst">
          <div class="inner">
            <p><?=__('Check Attendance')?></p>
            <h3><?=__('Attendance')?></h3>
          </div>
          <div class="icon">
            <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
          </div>
          <?php 
          echo $this->Html->link('More info <i class="fa fa-arrow-circle-right"></i>',['controller' => 'users', 'action' => 'manageChildren', 'prefix' => 'parent'],['class'=>'small-box-footer','escape' => false]);
           ?>
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="small-box bg-b-yellow info-box-cst">
          <div class="inner">
            <p><?=__('Due Amount')?></p>
            <h3><?= $users['currency_code'] . $totalbalance?> </h3>
          </div>
          <div class="icon">
           <i class="" aria-hidden="true"><?= $users['currency_code']?></i>
          </div>
          <a href="javascript:void(0)" class="small-box-footer">
            <?=__('More info')?> <i class="fa fa-arrow-circle-right"></i>
          </a>
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
    </div>
      <!-- /.row -->
      
     <div class="row">
      <div class="col-md-8 today-class-height">
        <div class="box box-primary">
          <div class="box-header bso-box-header">
            <h3 class="box-title"><?=__('Today Classes')?></h3>
          </div>
          <div class="box-body">
            <table id="" class="table table-striped table-hover v-center cell-pd-15">
              <?php
              
              ?>
              <thead>
                <tr>
                  <th>#</th>
                  <th>Child Name</th>
                  <th>Start Time </th>
                  <th>End Time</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  $i = 1;
                    foreach ($todatsplans as $key => $value) {
                      //pr($value);die;
                    
                ?>
                <tr>
                  <td><?= $i?></td>
                  <td><?=$this->Decryption->mc_decrypt($value['user']['firstname'],$value['user']['encryptionkey']).' '.' '.$this->Decryption->mc_decrypt($value['user']['lastname'],$value['user']['encryptionkey'])?></td>
                  <td><?= date('H:i:s',strtotime($value['start_time']))?></td>
                  <td><?= date('H:i:s',strtotime($value['end_time']))?></td>
                  
                </tr>
                <?php $i++ ; }?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      
      <div class="col-md-4">
        <div class="small-box bg-b-blue info-box-cst small-box-height">
          <a href="<?= BASE_URL."parent/users/add-child"?>">
            <div class="inner">
              <p> </p>
              <h3><?=__('Add Child')?></h3>
              
            </div>
            <div class="icon">
               <i class="fa fa-user-plus" aria-hidden="true"></i>
            </div>
            <span class="small-box-footer">
             <?=__(' Add New Child')?><i class="fa fa-arrow-circle-right"></i>
            </span>
          </a>
        </div>
        <div class="small-box bg-b-green info-box-cst small-box-height">

          <a href="<?= BASE_URL."parent/users/add-guardian"?>">
          <div class="inner">
            <p> </p>
            <h3><?=__('Add Guardian')?></h3>
            
          </div>
          <div class="icon">
             <i class="fa fa-user-plus" aria-hidden="true"></i>
          </div>

          <span class="small-box-footer">
            <?=__('Add New Guardian')?><i class="fa fa-arrow-circle-right"></i>
          </span>
          </a>
          
        </div>
        <div class="small-box bg-aqua info-box-cst small-box-height">
          <a href="<?= BASE_URL."parent/users/buy-services"?>">
          <div class="inner">
            <p> </p>
            <h3><?=__('Buy Service')?></h3>
            
          </div>
          <div class="icon">
             <i class="fa fa-cogs" aria-hidden="true"></i>
          </div>
          <span class="small-box-footer">
            <?=__('Buy New Service')?> <i class="fa fa-arrow-circle-right"></i>
          </span>
          </a>
          
        </div>
      </div>
     </div>
     
      
    <div class="row">
      <div class="col-md-8 mt_30">
        <div class="box box-primary">
          <div class="box-header bso-box-header">
            <h3 class="box-title"><?=__('Events Calender')?></h3>
          </div>
          <div class="box-body no-padding">
            <!-- THE CALENDAR -->
            <div id="calendar"></div>
          </div>
          <!-- /.box-body -->
        </div>
        
      </div>
      
      <div class="col-md-4 mt_30">
        <div class="box box-primary">
          <div class="box-header bso-box-header">
            <h3 class="box-title"><?=__('Event List')?></h3>
          </div>
          <div class="box-body">
            <div class="home-event-list">
              <div class="home-single-event event-current">
                <div class="event-date-info">13 Dec, 10:30am</div>
                <h5 class="event-title">Event title goes here</h5>
                <div class="event-view-btn">
                  <a href="javascript:void(0)" class="btn btn-theme-border" data-toggle="modal" data-target="#ViewEvent"><?=__('View')?></a>
                </div>
              </div>
              <div class="home-single-event">
                <div class="event-date-info">16 Dec, 12:30pm</div>
                <h5 class="event-title">Parent Teacher meeting</h5>
                <div class="event-view-btn">
                  <a href="javascript:void(0)" class="btn btn-theme-border" data-toggle="modal" data-target="#ViewEvent"><?=__('View')?></a>
                </div>
              </div>
              <div class="home-single-event">
                <div class="event-date-info">13 Dec, 10:30am</div>
                <h5 class="event-title">Event title goes here</h5>
                <div class="event-view-btn">
                  <a href="javascript:void(0)" class="btn btn-theme-border" data-toggle="modal" data-target="#ViewEvent"><?=__('View')?></a>
                </div>
              </div>
              <div class="home-single-event">
                <div class="event-date-info">16 Dec, 12:30pm</div>
                <h5 class="event-title">Parent Teacher meeting</h5>
                <div class="event-view-btn">
                  <a href="javascript:void(0)" class="btn btn-theme-border" data-toggle="modal" data-target="#ViewEvent">View</a>
                </div>
              </div>
              <div class="home-single-event">
                <div class="event-date-info">13 Dec, 10:30am</div>
                <h5 class="event-title">Event title goes here</h5>
                <div class="event-view-btn">
                  <a href="javascript:void(0)" class="btn btn-theme-border" data-toggle="modal" data-target="#ViewEvent"><?=__('View')?></a>
                </div>
              </div>
              <div class="home-single-event">
                <div class="event-date-info">16 Dec, 12:30pm</div>
                <h5 class="event-title">Parent Teacher meeting</h5>
                <div class="event-view-btn">
                  <a href="javascript:void(0)" class="btn btn-theme-border" data-toggle="modal" data-target="#ViewEvent">View</a>
                </div>
              </div>
              <div class="home-single-event">
                <div class="event-date-info">13 Dec, 10:30am</div>
                <h5 class="event-title">Event title goes here</h5>
                <div class="event-view-btn">
                  <a href="javascript:void(0)" class="btn btn-theme-border" data-toggle="modal" data-target="#ViewEvent">View</a>
                </div>
              </div>
              
              <div class="view-all-event">
                <a href="event-management.php"> View All Events</a>
              </div>
            </div>
          </div>
          <!-- /.box-body -->
        </div>
        <div class="box box-primary">
          <div class="box-header bso-box-header">
            <h3 class="box-title">My Children</h3>
          </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table table-striped table-hover v-center cell-pd-15">
            <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Image</th>
              <th>Gender</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
            <?php 
              $i = 1;
              foreach ($childe as $key => $value) {
               
            ?>
            <tr>
              <td><?= $i?></td>
              <td><?=$value['firstname'].' '.$value['lastname']?></td>
              <td>
                <?php
                      if (!empty($value['image'])) {
                            echo $this->Html->link($this->Html->image(USER_PICTURE_FOLDER_URL_PATH . $value['uuid'] . '/' . $value['image'], ['alt' => 'user', 'class' => 'table-img-thumb img-circle']), '', ['escapeTitle' => false]);
                        } else {
                            echo $this->Html->link($this->Html->image('blank-avatar.png', ['alt' => 'user', 'class' => 'table-img-thumb img-circle']), '', ['escapeTitle' => false]);
                        }
                      ?>
              </td>
              <td>
                <?php if($value->gender == 1){?>
                      Male
                    <?php } else {?>
                      Female
                    <?php }?>
              </td>
              
              <td>
                <div class="btn__group">
                  <a href="<?= BASE_URL.'parent/users/childview/'.$value['uuid']?>" class="btn btn-green-border">View</a>
                </div>
              </td>
            </tr>
            <?php 
                }
              ?>
            </tbody>
            
           </table>
        </div>
        
        </div>
        

      </div>
    </div>
      

    </section>
    <!-- /.content -->
  </div>
  
  
   <!--Edit Event Modal -->
   <div class="modal fade" id="EditEvent">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header service-header bg-b-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Event </h4>
              </div>
        <form action="" method="" class="form-common">
          <div class="modal-body">
            <div class="event-details">         
              <div class="form-group">
                <label>Event Name *</label>
                <input type="text" class="form-control"  value="Parent Teacher meeting"  required="">
              </div>
              <div class="form-group">
                <label>Event Start *</label>
                <div class="row">
                  <div class="col-xs-6">
                    <div class="input-group">
                      <input type="text" class="form-control" id="datepickerEdit" value="16/12/2018" required="">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="input-group">
                      <input type="text" id="timeEdit" class="form-control floating-label" value="12:30" placeholder="Time">
                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                   </div>
                  </div>
                </div>            
              </div>  
              <div class="form-group">
                <label>Event End *</label>
                <div class="row">
                  <div class="col-xs-6">
                    <div class="input-group">
                      <input type="text" class="form-control" id="datepickerEditNew" value="16/12/2018" required="">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="input-group">
                      <input type="text" id="timeEditNew" class="form-control floating-label" value="16:30" placeholder="Time">
                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                   </div>
                  </div>
                </div>            
              </div>              
              <div class="form-group">
                <label>Description</label>
                <textarea class="form-control textarea-100">Lorem Ipsum is simply dummy text of the printing and typesetting industry,Lorem Ipsum is simply dummy text of the printing and typesetting industry</textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer pt_0 bt_0 text-right">
            <button type="button" class="btn btn-default btn-round-md" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-theme btn-round-md">Save</a>
          </div>
        </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    
<!--View Event Modal -->
   <div class="modal fade" id="ViewEvent">
        <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header service-header bg-b-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Parent Teacher meeting</h4>
              </div>
        <div class="modal-body">
          <div class="event-details">         
            <div class="event-info-row">
              <label>Event Start</label>
              <p>16 Dec, 12:30pm</p>
            </div>
            <div class="event-info-row">
              <label>Event End</label>
              <p>16 Dec, 04:30pm</p>
            </div>
            <div class="event-info-row">
              <label>Description</label>
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry,Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
            </div>
            
          </div>
        </div>
        <div class="modal-footer pt_0 bt_0 text-right">
          <button type="button" class="btn btn-default btn-round-md" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-red btn-round-md" data-dismiss="modal">Delete</button>
          <button type="button" class="btn btn-theme btn-round-md" data-dismiss="modal" data-toggle="modal" data-target="#EditEvent">Edit</a>
          
        </div>
            </div>
            <!-- /.modal-content -->
        </div>
          <!-- /.modal-dialog -->
    </div>
<!-- /.modal -->
    


 <!-- Page script -->
<script>
  $(function () {
 
    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })
     $('#datepickerEnd').datepicker({
      autoclose: true
    })
     $('#datepickerEdit').datepicker({
      autoclose: true
    })
     $('#datepickerEditNew').datepicker({
      autoclose: true
    })
    
  })
</script>
  <script type="text/javascript">
        $(document).ready(function()
        {
            

            $('#time').bootstrapMaterialDatePicker
            ({
                date: false,
                shortTime: false,
                format: 'HH:mm'
            });
            
            $('#timeNew').bootstrapMaterialDatePicker
            ({
                date: false,
                shortTime: false,
                format: 'HH:mm'
            });
            
            $('#timeEdit').bootstrapMaterialDatePicker
            ({
                date: false,
                shortTime: false,
                format: 'HH:mm'
            });
            $('#timeEditNew').bootstrapMaterialDatePicker
            ({
                date: false,
                shortTime: false,
                format: 'HH:mm'
            });


            
        });
        </script>