<!DOCTYPE html>
<html>
<head>

	<!-- head -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- demo stylesheet -->
    <link type="text/css" rel="stylesheet" href="<?= $this->request->webroot;?>calshedule/helpers/demo.css?v=2018.4.3487" />
    <link type="text/css" rel="stylesheet" href="<?= $this->request->webroot;?>calshedule/helpers/media/layout.css?v=2018.4.3487" />
    <link type="text/css" rel="stylesheet" href="<?= $this->request->webroot;?>calshedule/helpers/media/elements.css?v=2018.4.3487" />

	<!-- helper libraries -->
	<script src="<?= $this->request->webroot;?>calshedule/helpers/jquery-1.12.2.min.js" type="text/javascript"></script>
    
	<!-- daypilot libraries -->
  <script src="<?php echo $this->request->webroot;?>calshedule/js/daypilot-all.min.js?v=2018.4.3487" type="text/javascript"></script>

    <!-- daypilot themes -- -->
	<link type="text/css" rel="stylesheet" href="<?= $this->request->webroot;?>calshedule/themes/areas.css?v=2018.4.3487" />    
        
	
	<link type="text/css" rel="stylesheet" href="<?= $this->request->webroot;?>calshedule/themes/month_green.css?v=2018.4.3487" />    
	
    
   
	<link type="text/css" rel="stylesheet" href="<?= $this->request->webroot;?>calshedule/themes/calendar_green.css?v=2018.4.3487" />    
     
	<link type="text/css" rel="stylesheet" href="<?= $this->request->webroot;?>calshedule/themes/scheduler_green.css?v=2018.4.3487" />    

</head>
<div class="content-wrapper">
 <section class="content-header">
      <h1>Employee</h1>
   </section>
   <?= $this->Flash->render() ?>
   <section class="content">
      <div class="box box-primary">
         <div class="box-header bso-box-header">
            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
            <div class="header">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="col-sm-12">
                                	<h2>
                                		Employee Planning
                               		 </h2><br/>
                            	</div>
                            </div>
                            
                        </div>
            </div> 
        <div class="body">
        <div class="table-responsive">
        <table class="table table-bordered table-checkbox">                    
        <div class="shadow"></div>
        <div class="hideSkipLink">
        </div>
        <div class="main">
        	<div id="dp"></div>
                  <DayPilot:DayPilotMenu ID="DayPilotMenuSelection" runat="server" CssClassPrefix="menu_default">
            ...
            </DayPilot:DayPilotMenu>

            </table>
             </div>
             </div>
             </div>
             </div>
        </section>
		 <?php
        // pr($events_list);die;
         ?>

        <script type="text/javascript">
        	var emp_list = [];
        	
		function getMonday(d) {
		  d = new Date(d);
		  var day = d.getDay(),
		      diff = d.getDate() - day + (day == 0 ? -6 : 1);
		  return new Date(d.setDate(diff));
		}

		function convert(str) {
		    var date = new Date(str),
		        mnth = ("0" + (date.getMonth()+1)).slice(-2),
		        day  = ("0" + date.getDate()).slice(-2);
		    return [ date.getFullYear(), mnth, day ].join("-");
		}
		
    	var date = convert(getMonday(new Date()));
    	var dp = new DayPilot.Scheduler("dp");
  
    	dp.startDate =  date; // or just dp.startDate = "2013-03-25";
    	dp.days = 7;
    	dp.scale = "Day";
    
    	dp.timeHeaders = [
        // { groupBy: "Week", format: "MMM yyyy" },
        	{ groupBy: "Day", format: "ddd d MM yyyy" }
    	];
    	dp.bubble = new DayPilot.Bubble();
    	dp.treeEnabled = true;
    	dp.dynamicEventRenderingCacheSweeping = true;
		dp.eventHoverHandling = "Bubble";
	    dp.theme = "scheduler_green";
	    dp.cellWidth = 200;
        dp.eventDoubleClickHandling = "Enabled";
        // dp.cellHeight = 300;
        dp.eventHeight = 70;
	    dp.eventMovingStartEndEnabled = true;
	    dp.eventResizingStartEndEnabled = true;
	    dp.timeRangeSelectingStartEndEnabled = true;
	    dp.eventDeleteHandling = true;
	    dp.eventMoveHandling = "Disabled";
	    dp.eventResizeHandling = "Disabled";
        dp.contextMenu = true;
       // console.log(dp);
        
 
	    dp.resources = <?php echo  $employee_list ?>;
        //List of Events
	    dp.events.list = <?php echo $events_list?>;

       dp.rowHeaderColumns = [
          { title: 'Name', width: 100 },
          
      ];  

    dp.onBeforeEventRender = function(args) {
        args.e.bubbleHtml = "<div><b>" + args.e.text + "</b></div><div>Start: " + new DayPilot.Date(args.e.start).toString("M/d/yyyy") + "</div>";
    };

    dp.onEventDeleted = function(args) {
        //console.log(args.e.data.resource);
        $.confirm({
                            theme: 'light',
                            title: 'view details!!',content: ''+args.e.text(),
                            buttons: {
                                confirm: function () {
                                       $.post(baseurl + "users/deleteAsignteacher/"+ args.e.data.service_id +"/"+args.e.data.resource,
                                     {
                                         id: args.e.id()
                                     },
                                     function(response) {
                                         var e = dp.events.find(args.e.id());
                                        dp.events.remove(e).queue();
                                            console.log("Deleted.");
                                     });
                                },
                                 cancel: function () {
                                    // console.log("cancled.");
                                     //return false;
                                     //return false;
                         
                                 },
                            }
        });
        
       
    };

    dp.onEventDoubleClicked = function(args) {
        $.confirm({
                            theme: 'light',
                            title: 'view details!!',content: ''+args.e.text(),
                            buttons: {
                                OK: function () {
                                      
                                },
                               
                       
                            }
        });
        //alert("Event double-clicked: " + args.e.text());
    };
   
    dp.onEventClicked = function(args) {
       // alert("clicked: " + args.e.id() + " ctrl: " + args.ctrl);
       
    };
    dp.rowClickHandling = function(args) {
       // alert("ase");
    };
    dp.groupConcurrentEvents = true;
    dp.groupConcurrentEventsLimit = 100;
    
    dp.init();
    
    
$(document).on('click', '.scheduler_green_rowheader_inner_text', function(event) {
    //alert("uiii");
        // var keycount = $("#keycount").val();
        // var newkeycount = parseInt(keycount) - 1;
        // $("#keycount").val(newkeycount);
        // $(this).parents('div.childrows').remove();
    });
</script>

  <!-- bottom -->
                </div>
	        </div>
        </div>
    </div>
<script type="text/javascript">
$(document).ready(function() {
    var url = window.location.href;
    var filename = url.substring(url.lastIndexOf('/')+1);
    if (filename === "") filename = "index.html";
    $(".menu a[href='" + filename + "']").addClass("selected");

    $(".menu-title").click(function() {
        $(".menu-body").toggle();
        if ($(".menu-body").is(":visible")) {
            scrollTo({
                top: pageYOffset + 100,
                behavior: "smooth"
            });
        }
    });
});
        
</script>
<!-- 
            <script type="text/javascript">

                var nav = new DayPilot.Navigator("nav");
                var selectDate = "thhr";
                //nav.showMonths = 3;
                //nav.skipMonths = 3;
                nav.selectMode = "week";
                nav.onTimeRangeSelected = function(args) {

                    dp.startDate = args.day;
                    selectDate = dp.startDate;

   //                 alert(selectDate);
                    dp.update();
                    //dp.events.load(baseurl + "employee/employees/employeroster/<?= $profile->uuid;?>");
                    loadEvents(selectDate);
                };
                nav.init();

                var dp = new DayPilot.Calendar("dp");
                dp.viewType = "Week";
                dp.locale = "en-us";

                dp.eventDeleteHandling = "Disabled";
                dp.eventMoveHandling = "Disabled";
                dp.eventResizeHandling = "Disabled";
            

                dp.onEventClick = function(args) {
                    $.confirm({
                        theme: 'light',
                        title: 'view details!!',content: ''+args.e.text(),
                        buttons: {
                            OK: function () {
                                  
                            },
                           
                   
                        }
                    });
                    //alert("clicked: " + args.e.text());
                };

                dp.init();

                loadEvents();

                function loadEvents(selectDate = null) {
                   // alert(selectDate);
                   dp.timeFormat = "Clock24Hours";
                   dp.headerDateFormat = "dddd";
                   dp.weekStarts = 2;
                   if(selectDate != null && selectDate != ''){
                    //alert(selectDate);
                        var data = dp.events.load(baseurl + "employee/employees/employeroster/<?= $profile->uuid;?>/" + selectDate);
                       // alert('asd');
                        console.log(data);
                        dp.theme = "calendar_green";
                        dp.update();
                    }else{
                        var data = dp.events.load(baseurl + "employee/employees/employeroster/<?= $profile->uuid;?>");
                       // console.log(data);
                        dp.theme = "calendar_green";
                        dp.update();
                    }
                }

            </script>

            

        </div>
        <div class="clear">
        </div> -->

</body>
</html>

