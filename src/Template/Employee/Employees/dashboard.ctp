<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=__('Dashboard')?>
        <small><?=__('BSO Employee Panel')?></small>
      </h1>
    </section>

    <!-- Main content -->
    	<?= $this->Flash->render() ?>
    <section class="content">
		<div class="box box-primary">
			<div class="box-header bso-box-header">
			  <h3 class="box-title"><?=__('Today Classes')?></h3>
			</div>

			<div class="box-body">
				<table id="" class="table table-striped table-hover v-center cell-pd-15">
					<thead>
						<tr>
							<th>#</th>
							<th><?=__('Service')?></th>
							<th><?=__('Start Time')?> </th>
							<th><?=__('End Time')?></th>
							<th><?=__('Status')?></th>
							<th><?=__('Action')?></th>
						</tr>
					</thead>
					<tbody>
						<?php
							$uuid = $this->request->getSession()->read('Auth.User.uuid');
							if(empty($finalservices)){
								echo "<tr><td></td><td>No service avalible for today</td></tr>";
							}
							foreach ($finalservices as $key => $value) {
							
						?>
						<tr>
							<td>1</td>
							<td><?=$value[0]->service_day?></td>
							<td><?= date('H:i:s', strtotime($value[0]->start_time))?></td>
							<td><?= date('H:i:s', strtotime($value[0]->end_time))?></td>
							<td><span class="label label-bg-green label-110 label-round">Assigned</span></td>
							<td>

								<div class="btn__group">
									<?php
										$url = BASE_URL.'employee/employees/assign-students/'.$uuid.'/'.$value[0]->service_day;
									
					                ?>
									<a href="<?= $url;?>" class="btn btn-green-border"><?=__('View Student List')?></a>
								</div>
							</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
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
				<!-- BAR CHART -->
				  <div class="box box-primary">
					<canvas id="pieChart" style="height:250px; display:none;"></canvas>
					<div class="chart" style="display:none;">
						<canvas id="areaChart" style="height:250px"></canvas>
					</div>
					 <div class="chart" style="display:none;">
						<canvas id="lineChart" style="height:250px"></canvas>
					  </div>
					   <div class="chart" style="display:none;">
						<canvas id="barChart" style="height:230px"></canvas>
					  </div>
					<!-- /.box-body -->
				  </div>
				  <!-- /.box -->
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
					<!-- TO DO List -->
			  <div class="box box-primary">
				<div class="box-header">
				  <i class="ion ion-clipboard"></i>

				  <h3 class="box-title">To Do List</h3>

				  <div class="box-tools pull-right">
					<ul class="pagination pagination-sm inline">
					  <li><a href="#">&laquo;</a></li>
					  <li><a href="#">1</a></li>
					  <li><a href="#">2</a></li>
					  <li><a href="#">3</a></li>
					  <li><a href="#">&raquo;</a></li>
					</ul>
				  </div>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
				  <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
				  <ul class="todo-list">
					<li>
					  <!-- drag handle -->
					  <span class="handle">
							<i class="fa fa-ellipsis-v"></i>
							<i class="fa fa-ellipsis-v"></i>
						  </span>
					  <!-- checkbox -->
					  <input type="checkbox" value="">
					  <!-- todo text -->
					  <span class="text">Announcement for holiday</span>
					  <!-- Emphasis label -->
					  <small class="label label-danger"><i class="fa fa-clock-o"></i> 2 mins</small>
					  <!-- General tools such as edit or delete-->
					  <div class="tools">
						<i class="fa fa-edit"></i>
						<i class="fa fa-trash-o"></i>
					  </div>
					</li>
					<li>
						  <span class="handle">
							<i class="fa fa-ellipsis-v"></i>
							<i class="fa fa-ellipsis-v"></i>
						  </span>
					  <input type="checkbox" value="">
					  <span class="text">School picnic</span>
					  <small class="label label-info"><i class="fa fa-clock-o"></i> 4 hours</small>
					  <div class="tools">
						<i class="fa fa-edit"></i>
						<i class="fa fa-trash-o"></i>
					  </div>
					</li>
					<li>
						  <span class="handle">
							<i class="fa fa-ellipsis-v"></i>
							<i class="fa fa-ellipsis-v"></i>
						  </span>
					  <input type="checkbox" value="">
					  <span class="text">call bus driver</span>
					  <small class="label label-warning"><i class="fa fa-clock-o"></i> 1 day</small>
					  <div class="tools">
						<i class="fa fa-edit"></i>
						<i class="fa fa-trash-o"></i>
					  </div>
					</li>
					<li>
						  <span class="handle">
							<i class="fa fa-ellipsis-v"></i>
							<i class="fa fa-ellipsis-v"></i>
						  </span>
					  <input type="checkbox" value="">
					  <span class="text">Announcement for holiday</span>
					  <small class="label label-success"><i class="fa fa-clock-o"></i> 3 days</small>
					  <div class="tools">
						<i class="fa fa-edit"></i>
						<i class="fa fa-trash-o"></i>
					  </div>
					</li>
					<li>
						  <span class="handle">
							<i class="fa fa-ellipsis-v"></i>
							<i class="fa fa-ellipsis-v"></i>
						  </span>
					  <input type="checkbox" value="">
					  <span class="text">Check your messages and notifications</span>
					  <small class="label label-primary"><i class="fa fa-clock-o"></i> 1 week</small>
					  <div class="tools">
						<i class="fa fa-edit"></i>
						<i class="fa fa-trash-o"></i>
					  </div>
					</li>
					<li>
						  <span class="handle">
							<i class="fa fa-ellipsis-v"></i>
							<i class="fa fa-ellipsis-v"></i>
						  </span>
					  <input type="checkbox" value="">
					  <span class="text">Announcement for holiday</span>
					  <small class="label label-default"><i class="fa fa-clock-o"></i> 1 month</small>
					  <div class="tools">
						<i class="fa fa-edit"></i>
						<i class="fa fa-trash-o"></i>
					  </div>
					</li>
				  </ul>
				</div>
				<!-- /.box-body -->
				<div class="box-footer clearfix no-border">
					<form class="form-common">
						<div class="form-group">
							<input type="text" class="form-control" required="" placeholder="Add to do item in list">
						</div>
						<button type="button" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Add item</button>
					</form>
				</div>
			  </div>
			  <!-- /.box -->
			  
			  

			</div>
		</div>
      

    </section>
    <!-- /.content -->
  </div>
  
	
	
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
				</div>
            </div>
            <!-- /.modal-content -->
        </div>
          <!-- /.modal-dialog -->
    </div>
<!-- /.modal -->
 
  
  <!-- ChartJS -->
<script src="../bower_components/chart.js/Chart.js"></script>

  <!-- fullCalendar -->
<script src="../bower_components/moment/moment.js"></script>
<script src="../bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
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

<script>
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
    // This will get the first returned node in the jQuery collection.
    var areaChart       = new Chart(areaChartCanvas)

    var areaChartData = {
      labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      datasets: [
        {
          label               : 'Electronics',
          fillColor           : 'rgba(210, 214, 222, 1)',
          strokeColor         : 'rgba(210, 214, 222, 1)',
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [65, 59, 80, 81, 56, 55, 40]
        },
        {
          label               : 'Digital Goods',
          fillColor           : 'rgba(60,141,188,0.9)',
          strokeColor         : 'rgba(60,141,188,0.8)',
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [28, 48, 40, 19, 86, 27, 90]
        }
      ]
    }

    var areaChartOptions = {
      //Boolean - If we should show the scale at all
      showScale               : true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : false,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - Whether the line is curved between points
      bezierCurve             : true,
      //Number - Tension of the bezier curve between points
      bezierCurveTension      : 0.3,
      //Boolean - Whether to show a dot for each point
      pointDot                : false,
      //Number - Radius of each point dot in pixels
      pointDotRadius          : 4,
      //Number - Pixel width of point dot stroke
      pointDotStrokeWidth     : 1,
      //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius : 20,
      //Boolean - Whether to show a stroke for datasets
      datasetStroke           : true,
      //Number - Pixel width of dataset stroke
      datasetStrokeWidth      : 2,
      //Boolean - Whether to fill the dataset with a color
      datasetFill             : true,
      //String - A legend template
      legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio     : true,
      //Boolean - whether to make the chart responsive to window resizing
      responsive              : true
    }

    //Create the line chart
    areaChart.Line(areaChartData, areaChartOptions)

    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas          = $('#lineChart').get(0).getContext('2d')
    var lineChart                = new Chart(lineChartCanvas)
    var lineChartOptions         = areaChartOptions
    lineChartOptions.datasetFill = false
    lineChart.Line(areaChartData, lineChartOptions)

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieChart       = new Chart(pieChartCanvas)
    var PieData        = [
      {
        value    : 700,
        color    : '#f56954',
        highlight: '#f56954',
        label    : 'Chrome'
      },
      {
        value    : 500,
        color    : '#00a65a',
        highlight: '#00a65a',
        label    : 'IE'
      },
      {
        value    : 400,
        color    : '#f39c12',
        highlight: '#f39c12',
        label    : 'FireFox'
      },
      {
        value    : 600,
        color    : '#00c0ef',
        highlight: '#00c0ef',
        label    : 'Safari'
      },
      {
        value    : 300,
        color    : '#3c8dbc',
        highlight: '#3c8dbc',
        label    : 'Opera'
      },
      {
        value    : 100,
        color    : '#d2d6de',
        highlight: '#d2d6de',
        label    : 'Navigator'
      }
    ]
    var pieOptions     = {
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke    : true,
      //String - The colour of each segment stroke
      segmentStrokeColor   : '#fff',
      //Number - The width of each segment stroke
      segmentStrokeWidth   : 2,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 50, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps       : 100,
      //String - Animation easing effect
      animationEasing      : 'easeOutBounce',
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate        : true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale         : false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive           : true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio  : true,
      //String - A legend template
      legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    pieChart.Doughnut(PieData, pieOptions)

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas                   = $('#barChart').get(0).getContext('2d')
    var barChart                         = new Chart(barChartCanvas)
    var barChartData                     = areaChartData
    barChartData.datasets[1].fillColor   = '#00a65a'
    barChartData.datasets[1].strokeColor = '#00a65a'
    barChartData.datasets[1].pointColor  = '#00a65a'
    var barChartOptions                  = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero        : true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : true,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - If there is a stroke on each bar
      barShowStroke           : true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth          : 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing         : 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing       : 1,
      //String - A legend template
      legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to make the chart responsive
      responsive              : true,
      maintainAspectRatio     : true
    }

    barChartOptions.datasetFill = false
    barChart.Bar(barChartData, barChartOptions)
  })
</script>

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
