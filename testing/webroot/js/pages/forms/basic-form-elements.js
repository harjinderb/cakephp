$(function () {
    //Textare auto growth
    autosize($('textarea.auto-growth'));

    //Datetimepicker plugin
    $('.datetimepicker').bootstrapMaterialDatePicker({
        format: 'dddd DD MMMM YYYY - HH:mm',
        clearButton: true,
        weekStart: 1
    });

    $('.datepicker').bootstrapMaterialDatePicker({
        format: 'DD MM YYYY',
        clearButton: true,
        weekStart: 1,
        time: false
    });
     var selecteddate = new Date();
    $('#date-start').bootstrapMaterialDatePicker({
        format: 'HH:mm',
        clearButton: true,
        // disableTimeRanges: [ selecteddate
        //     // ['10:00am', '10:20am'],
        //     // ['4:20pm', '5:00pm']
        // ],
        //   disabledTimeIntervals: [[moment({ h: 0 }), moment({ h: 8 })], [moment({ h: 18 }), moment({ h: 24 })]]

        date: false
    }).on('change', function(e, date){
       // alert(date); 
        //date.setTime(date + 20*60*1000);
        
          selecteddate = date.add(1,'minutes').format('HH:mm');
      console.log(selecteddate);
    $('#date-end').bootstrapMaterialDatePicker({
         format : 'HH:mm',
         minDate : selecteddate,
         currentDate   : selecteddate,
         clearButton: true, 
         date: false
    }).on('change', function(e, date){
        //alert('qwe');
            var starttime = $("#date-start").val();    
            var endtime = $("#date-end").val();
            var service_day = $("#service-day").val();
            var data = {
                "start": starttime,
                "end": endtime,
                "service_day" :service_day,
            };
            $.ajax({
                type: "POST",
                dataType: "html",
                url: baseurl + "users/servicesTeacher", //Relative or absolute path to response.php file
                data: data,
                success: function(data) {
                      //console.log(data);
                  
                     var obj = jQuery.parseJSON( data );
                     var setdata = '';
                     $(obj).each(function(key,value){

                        setdata +="<option value="+value['user_id']+">"+value['firstname']+" "+value['lastname']+"</option>";
                    
                    });
                     if(setdata == ''){
                        var setdata = "<option value="+'No teacher avalable in that time slot.'+" disabled>"+'No teacher avalable in that time slot.'+"</option>";
                    
                     }
                   console.log(setdata);
                    $('#undo_redo').html(setdata);
                     return false;
                }
                

            });

    });
    });
       
    
});