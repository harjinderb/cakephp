<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=__('Dashboard')?>+

        <small><?=__('BSO Admin Panel')?></small>
      </h1>
      <?= $this->Flash->render() ?>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="row">
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-b-blue info-box-cst">
        <span class="info-box-icon round-info-box-icon"><i class="fa fa-bookmark-o"></i></span>

        <div class="info-box-content">
          <span class="info-box-text"><?=__('Total Students')?></span>
          <span class="info-box-number"><?= count($childern)?></span>

          <div class="progress">
          <div class="progress-bar" style="width: <?= count($childern)?>%"></div>
          </div>
            <span class="progress-description">
            <?= count($childern)?>% Increased
            </span>
        </div>
        <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-b-green info-box-cst">
        <span class="info-box-icon round-info-box-icon"><i class="fa fa-thumbs-o-up"></i></span>

        <div class="info-box-content">
          <span class="info-box-text"><?=__('Student Available Today')?></span>
          <span class="info-box-number"><?= count($attendance)?></span>

          <div class="progress">
          <div class="progress-bar" style="width: <?= count($attendance)?>%"></div>
          </div>
            <span class="progress-description">
            <?= count($attendance)?>% Increased 
            </span>
        </div>
        <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-aqua info-box-cst">
        <span class="info-box-icon round-info-box-icon"><i class="fa fa-calendar"></i></span>

        <div class="info-box-content">
          <span class="info-box-text"><?=__('Total Services')?></span>
          <span class="info-box-number"><?= count($BsoServices)?></span>

          <div class="progress">
          <div class="progress-bar" style="width: <?= count($BsoServices)?>%"></div>
          </div>
            <span class="progress-description">
            <?= count($BsoServices)?>% Increased 
            </span>
        </div>
        <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-b-yellow info-box-cst">
        <span class="info-box-icon round-info-box-icon"><i class="fa fa-comments-o"></i></span>

        <div class="info-box-content">
          <span class="info-box-text"><?=__('Total Teachers')?></span>
          <span class="info-box-number"><?= count($employees)?></span>

          <div class="progress">
          <div class="progress-bar" style="width: <?= count($employees)?>%"></div>
          </div>
            <span class="progress-description">
            <?= count($employees)?>% Increased 
            </span>
        </div>
        <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
    </div>
      <!-- /.row -->
      
    <div class="row">
      <div class="col-md-8 mt_30">
        <div class="box box-primary">
          <div class="box-header bso-box-header">
            <h3 class="box-title"><?=__('Events Calender')?></h3>
          </div>
          <div class="box-body no-padding">
            <div id="bsoevent"></div>
          </div>
        </div>
        <!-- BAR CHART -->
          <!-- <div class="box box-primary">
          <div class="box-header bso-box-header">
            <h3 class="box-title"><?php //__('Children Chart')?></h3>
          </div>
          <div class="box-body">
            <div class="chart">
            <canvas id="barChart" style="height:230px"></canvas>
            </div>
          </div>
          
          <canvas id="pieChart" style="height:250px; display:none;"></canvas>
          <div class="chart" style="display:none;">
            <canvas id="areaChart" style="height:250px"></canvas>
          </div>
           <div class="chart" style="display:none;">
            <canvas id="lineChart" style="height:250px"></canvas>
            </div>
           /.box-body 
          </div> -->
          <!-- /.box -->
      </div>
      
      <div class="col-md-4 mt_30">
        <div class="small-box bg-b-blue info-box-cst small-box-height">
          <a href="<?= BASE_URL."employee/employees/add-employee"?>">
            <div class="inner">
              <p> </p>
              <h3><?=__('Add Employee')?></h3>
              
            </div>
            <div class="icon">
               <i class="fa fa-user-plus" aria-hidden="true"></i>
            </div>
            <span class="small-box-footer">
              <?=__('Add New Employee')?> <i class="fa fa-arrow-circle-right"></i>
            </span>
          </a>
        </div>
        <div class="small-box bg-b-green info-box-cst small-box-height">
          <a href="<?= BASE_URL."users/addparents"?>">
          <div class="inner">
            <p> </p>
            <h3><?=__('Add Parent')?></h3>
            
          </div>
          <div class="icon">
             <i class="fa fa-user-plus" aria-hidden="true"></i>
          </div>
          <span class="small-box-footer">
            <?=__('Add New Parent')?> <i class="fa fa-arrow-circle-right"></i>
          </span>
          </a>
          
        </div>
       <!--  <div class="small-box bg-aqua info-box-cst small-box-height">
          <a href="#">
          <div class="inner">
            <p> </p>
            <h3>Add Child</h3>
            
          </div>
          <div class="icon">
            <i class="fa fa-user-plus" aria-hidden="true"></i>
          </div>
          <span class="small-box-footer">
            Add New Child <i class="fa fa-arrow-circle-right"></i>
          </span>
          </a>
          
        </div> -->
    
        <div class="box box-primary">
          <div class="box-header bso-box-header">
            <h3 class="box-title"><?=__('Event List')?></h3>
          </div>
          <div class="box-body">
            <div class="home-event-list">
              <div class="home-single-event event-current">
                <div class="event-date-info">13 Dec, 10:30am</div>
                <h5 class="event-title">Nina Mcintire's Birthday Party</h5>
                <div class="event-view-btn">
                  <a href="javascript:void(0)" class="btn btn-theme-border" data-toggle="modal" data-target="#ViewEvent">View</a>
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
                <h5 class="event-title">Nina Mcintire's Birthday Party</h5>
                <div class="event-view-btn">
                  <a href="javascript:void(0)" class="btn btn-theme-border" data-toggle="modal" data-target="#ViewEvent">View</a>
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
                <h5 class="event-title">Nina Mcintire's Birthday Party</h5>
                <div class="event-view-btn">
                  <a href="javascript:void(0)" class="btn btn-theme-border" data-toggle="modal" data-target="#ViewEvent">View</a>
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
                <h5 class="event-title">Nina Mcintire's Birthday Party</h5>
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


  <!-- ChartJS -->
<script src="<?= $this->request->webroot ?>bower_components/chart.js/Chart.js"></script>

  <!-- fullCalendar -->
<script src="<?= $this->request->webroot ?>bower_components/moment/moment.js"></script>
<script src="<?= $this->request->webroot ?>bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
  <!-- Page specific script -->
<script>
  $(function () {
      /* initialize the external events
     -----------------------------------------------------------------*/
    function init_events(ele) {
      ele.each(function () {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        }

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject)

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex        : 1070,
          revert        : true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        })

      })
    }

    init_events($('#external-events div.external-event'))

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()
    $('#calendar').fullCalendar({
      header    : {
        left  : 'prev,next today',
        center: 'title',
        right : 'month,agendaWeek,agendaDay'
      },
      buttonText: {
        today: 'today',
        month: 'month',
        week : 'week',
        day  : 'day'
      },
      //Random default events
      events    : [
        {
          title          : 'All Day Event',
          start          : new Date(y, m, 1),
          backgroundColor: '#f56954', //red
          borderColor    : '#f56954' //red
        },
        {
          title          : 'Long Event',
          start          : new Date(y, m, d - 5),
          end            : new Date(y, m, d - 2),
          backgroundColor: '#f39c12', //yellow
          borderColor    : '#f39c12' //yellow
        },
        {
          title          : 'Meeting',
          start          : new Date(y, m, d, 10, 30),
          allDay         : false,
          backgroundColor: '#0073b7', //Blue
          borderColor    : '#0073b7' //Blue
        },
        {
          title          : 'Lunch',
          start          : new Date(y, m, d, 12, 0),
          end            : new Date(y, m, d, 14, 0),
          allDay         : false,
          backgroundColor: '#00c0ef', //Info (aqua)
          borderColor    : '#00c0ef' //Info (aqua)
        },
        {
          title          : 'Birthday Party',
          start          : new Date(y, m, d + 1, 19, 0),
          end            : new Date(y, m, d + 1, 22, 30),
          allDay         : false,
          backgroundColor: '#00a65a', //Success (green)
          borderColor    : '#00a65a' //Success (green)
        },
        {
          title          : 'Click for Google',
          start          : new Date(y, m, 28),
          end            : new Date(y, m, 29),
          url            : 'http://google.com/',
          backgroundColor: '#3c8dbc', //Primary (light-blue)
          borderColor    : '#3c8dbc' //Primary (light-blue)
        }
      ],
      editable  : true,
      droppable : true, // this allows things to be dropped onto the calendar !!!
      drop      : function (date, allDay) { // this function is called when something is dropped

        // retrieve the dropped element's stored Event Object
        var originalEventObject = $(this).data('eventObject')

        // we need to copy it, so that multiple events don't have a reference to the same object
        var copiedEventObject = $.extend({}, originalEventObject)

        // assign it the date that was reported
        copiedEventObject.start           = date
        copiedEventObject.allDay          = allDay
        copiedEventObject.backgroundColor = $(this).css('background-color')
        copiedEventObject.borderColor     = $(this).css('border-color')

        // render the event on the calendar
        // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
        $('#calendar').fullCalendar('renderEvent', copiedEventObject, true)

        // is the "remove after drop" checkbox checked?
        if ($('#drop-remove').is(':checked')) {
          // if so, remove the element from the "Draggable Events" list
          $(this).remove()
        }

      }
    })

    
  })
</script>