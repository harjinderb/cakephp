$(function () {
	event_obj = [];
	var calsettings = $('#calsettings').val();
  var date = new Date();
  date.getMonth() + 1
  var month = date.getMonth() + 1;
	var data = {
		"calsettings" : calsettings,
    "month" : month,
	};
    $.ajax({
        type: "POST",
        dataType: "html",
        url: baseurl + "users/calendar-settings", //Relative or absolute path to response.php file
        data: data,
            success: function(data) {
                var obj = jQuery.parseJSON(data);

                $.each(obj, function(key, value){
                	var date = new Date(value['start']);
	                    	var d    = date.getDate(),
						        m    = date.getMonth(),
						        y    = date.getFullYear();
					var date1 = new Date(value['end']);
	                    	var e    = date1.getDate(),
						        m    = date1.getMonth(),
						        y    = date1.getFullYear();	        
				       // alert(e);
                	event_obj.push({
                    		"title" : value['title'],
                    		"start" :  new Date(y, m, d),
                    		"end" :  new Date(y, m, e),
                    		"description" : value['description'],
                    		"backgroundColor" : value['backgroundColor'],
                    		"borderColor" : value['borderColor'],
                		
            		});
                });
               // console.log(event_obj);
               
            }
	});
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
     $(document).on('click', '.calsetting-wrap .fc-prev-button ', function() { 
            var calsettings = $('#calsettings').val();
            var get_month = $('#holidaycalender').fullCalendar('getDate');
            var date = get_month.format('');
            //alert(date);
            res = date.split("-");
            var month = res[1]; 
            var data = {
              "calsettings" : calsettings,
              "month" : month,
            };
            $.ajax({
                type: "POST",
                dataType: "html",
                url: baseurl + "users/calendar-settings", //Relative or absolute path to response.php file
                data: data,
                    success: function(data) {
                        var obj = jQuery.parseJSON(data);

                        $.each(obj, function(key, value){
                          var date = new Date(value['start']);
                                var d    = date.getDate(),
                            m    = date.getMonth(),
                            y    = date.getFullYear();
                  var date1 = new Date(value['end']);
                                var e    = date1.getDate(),
                            m    = date1.getMonth(),
                            y    = date1.getFullYear();         
                       // alert(e);
                          event_obj.push({
                                "title" : value['title'],
                                "start" :  new Date(y, m, d),
                                "end" :  new Date(y, m, e),
                                "description" : value['description'],
                                "backgroundColor" : value['backgroundColor'],
                                "borderColor" : value['borderColor'],
                            
                        });
                        });
                      $("#holidaycalender").fullCalendar('removeEvents'); 
                      $("#holidaycalender").fullCalendar('addEventSource', event_obj, true);
                       
                    }
          });

     });


     $(document).on('click', '.calsetting-wrap .fc-next-button ', function() {
        var calsettings = $('#calsettings').val();
            var get_month = $('#holidaycalender').fullCalendar('getDate');
            var date = get_month.format('');
            //alert(date);
            res = date.split("-");
            var month = res[1]; 
            var data = {
              "calsettings" : calsettings,
              "month" : month,
            };
            $.ajax({
                type: "POST",
                dataType: "html",
                url: baseurl + "users/calendar-settings", //Relative or absolute path to response.php file
                data: data,
                    success: function(data) {
                        var obj = jQuery.parseJSON(data);

                        $.each(obj, function(key, value){
                          var date = new Date(value['start']);
                                var d    = date.getDate(),
                            m    = date.getMonth(),
                            y    = date.getFullYear();
                  var date1 = new Date(value['end']);
                                var e    = date1.getDate(),
                            m    = date1.getMonth(),
                            y    = date1.getFullYear();         
                       // alert(e);
                          event_obj.push({
                                "title" : value['title'],
                                "start" :  new Date(y, m, d),
                                "end" :  new Date(y, m, e),
                                "description" : value['description'],
                                "backgroundColor" : value['backgroundColor'],
                                "borderColor" : value['borderColor'],
                            
                        });
                        });
                      $("#holidaycalender").fullCalendar('removeEvents'); 
                      $("#holidaycalender").fullCalendar('addEventSource', event_obj, true);
                       
                    }
          });


      });
    init_events($('#external-events div.external-event'))

    /* initialize the calendarholidaycalender
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    $( window ).on("load", function() {
    	console.log(event_obj);
    // var date = new Date()
    // var d    = date.getDate(),
    //     m    = date.getMonth(),
    //     y    = date.getFullYear()
    $('#holidaycalender').fullCalendar({
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
      events    : event_obj,
      // events    : [
      //   {
      //     title          : 'All Day Event',
      //     start          : new Date(y, m, 1),
      //     backgroundColor: '#f56954', //red
      //     borderColor    : '#f56954' //red
      //   },
      //   {
      //     title          : 'Long Event',
      //     start          : new Date(y, m, d - 5),
      //     end            : new Date(y, m, d - 2),
      //     backgroundColor: '#f39c12', //yellow
      //     borderColor    : '#f39c12' //yellow
      //   },
      //   {
      //     title          : 'Meeting',
      //     start          : new Date(y, m, d, 10, 30),
      //     allDay         : false,
      //     backgroundColor: '#0073b7', //Blue
      //     borderColor    : '#0073b7' //Blue
      //   },
      //   {
      //     title          : 'Lunch',
      //     start          : new Date(y, m, d, 12, 0),
      //     end            : new Date(y, m, d, 14, 0),
      //     allDay         : false,
      //     backgroundColor: '#00c0ef', //Info (aqua)
      //     borderColor    : '#00c0ef' //Info (aqua)
      //   },
      //   {
      //     title          : 'Birthday Party',
      //     start          : new Date(y, m, d + 1, 19, 0),
      //     end            : new Date(y, m, d + 1, 22, 30),
      //     allDay         : false,
      //     backgroundColor: '#00a65a', //Success (green)
      //     borderColor    : '#00a65a' //Success (green)
      //   },
      //   {
      //     title          : 'Click for Google',
      //     start          : new Date(y, m, 28),
      //     end            : new Date(y, m, 29),
      //     url            : 'http://google.com/',
      //     backgroundColor: '#3c8dbc', //Primary (light-blue)
      //     borderColor    : '#3c8dbc' //Primary (light-blue)
      //   }
      // ],
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
        $('#holidaycalender').fullCalendar('renderEvent', copiedEventObject, true)

        // is the "remove after drop" checkbox checked?
        if ($('#drop-remove').is(':checked')) {
          // if so, remove the element from the "Draggable Events" list
          $(this).remove()
        }

      }
    });


    });
}); 
    
  