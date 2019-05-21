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
        });

      });
    }

    init_events($('#external-events div.external-event'))

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()


var events = [];
        
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
    

        events: function(start, end, timezone, callback) { 
            $.ajax({ 
            url: baseurl + "users/viewcalendarholidayevents", 
            type: 'POST', 
            data: { }, 
                success: function (doc) {
                    var events= '';
                    if(doc){
                        var obj = jQuery.parseJSON(doc);                        
                         events = obj;                    
                    }
                    callback(events);
                } 
            }); 
        },
  //       events: {
  //    url: '/myfeed.php',
  //   data: function() { // a function that returns an object
  //     return {
  //       dynamic_value: Math.random()
  //     };
  //   }
  // }   
      // events    : [
      //   {
      //     title          : 'New year',
      //     start          : new Date(y, m,  10),
      //     end            : new Date(y, m, 11),
      //     backgroundColor: '#f56954', //red
      //     borderColor    : '#f56954' //red
      //   },
       
      //   {
      //     title          : ' Half Day',
      //     start          : new Date(y, m, 30),
      //      backgroundColor: '#f56954', //red
      //     borderColor    : '#f56954' //red
      //   },
        
      //   {
      //     title          : 'Holiday PAGAL',
      //     start          : new Date(y, m, d + 1, ),
      //    backgroundColor: '#f56954', //red
      //     borderColor    : '#f56954' //red
      //   },
      //   {
      //     title          : 'Holiday Name',
      //     start          : new Date(y, m, 20),
      //     end            : new Date(y, m, 20),
      //    backgroundColor: '#f56954', //red
      //     borderColor    : '#f56954' //red
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
        $('#calendar').fullCalendar('renderEvent', copiedEventObject, true)

        // is the "remove after drop" checkbox checked?
        if ($('#drop-remove').is(':checked')) {
          // if so, remove the element from the "Draggable Events" list
          $(this).remove()
        }

      }
    });

    
  });

  //  $(function () {
 
  //   //Date range picker
  //   $('#reservation').daterangepicker()
  //   //Date range picker with time picker
  //   $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
  //   //Date range as a button
  //   $('#daterange-btn').daterangepicker(
  //     {
  //       ranges   : {
  //         'Today'       : [moment(), moment()],
  //         'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
  //         'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
  //         'Last 30 Days': [moment().subtract(29, 'days'), moment()],
  //         'This Month'  : [moment().startOf('month'), moment().endOf('month')],
  //         'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
  //       },
  //       startDate: moment().subtract(29, 'days'),
  //       endDate  : moment()
  //     },
  //     function (start, end) {
  //       $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
  //     }
  //   )

  //   //Date picker
  //   $('#datepicker').datepicker({
  //     autoclose: true
  //   })
  //    $('#datepickerEnd').datepicker({
  //     autoclose: true
  //   })
  //    $('#datepickerEdit').datepicker({
  //     autoclose: true
  //   })
  //    $('#datepickerEditNew').datepicker({
  //     autoclose: true
  //   })
    
  // })

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