function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#UplodImg')
                .attr('src', e.target.result)
                .width(150)
                .height(150);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

$(function() {
    //$('#autocomplete').mask('0000-00-00');

    function log(message) {
        $("<div>").text(message).prependTo("#log");
        $("#log").scrollTop(0);
    }

    if ($("#autocomplete").length > 0) {
        $("#autocomplete").autocomplete({
            source: baseurl + "admin/users/autoload",
            minLength: 2,
            focus: function(event, ui) {
                $("#autocomplete").val(ui.item.label);

                return false;
            },
            select: function(event, ui) {

                console.log("Selected: " + ui.item.value + " aka " + ui.item.id + "address: " + ui.item.address + " aka " + ui.item.city);
                //console.log(ui.item.address);
                $('#address').html(ui.item.address);
                $('#city').html(ui.item.city);

            }
        });
    }
});

$(document).ready(function() {
    var total = 0;
    //input[name='no_of_childs[]']

    $('.usersetup').on('change', function() {
        //alert("I Am At alert");

        var selected = $(this).val();
        var role = $('#role').val();
        var bso_id = $('#bso_id').val();
        var parent_id = $('#parent_id').val();
        var allCheck = [];
        $("input[type=checkbox]").each(function() {


            if ($(this).is(':checked')) {
                var value = $(this).closest('tr').find($("input[type=checkbox]")).val();

                allCheck.push(value);
            }
        });


        if (selected == '1') {
            $.confirm({
                theme: 'light',
                title: 'Alert!',
                content: 'Are you sure you want to Deactivate !',
                buttons: {
                    confirm: function() {
                        updateusersetup(selected, role, bso_id, parent_id, allCheck);
                    },
                    cancel: function() {
                        //return false;

                    },

                }
            });
        }
        if (selected == '2') {
            $.confirm({
                theme: 'light',
                title: 'Alert!',
                content: 'Are you sure you want to Activate !',
                buttons: {
                    confirm: function() {
                        updateusersetup(selected, role, bso_id, parent_id, allCheck);
                    },
                    cancel: function() {
                        //return false;

                    },

                }
            });
        }
        if (selected == '3') {
            $.confirm({
                theme: 'light',
                title: 'Alert!',
                content: 'Are you sure you want to Delete !',
                buttons: {
                    confirm: function() {
                        updateusersetup(selected, role, bso_id, parent_id, allCheck);
                    },
                    cancel: function() {
                        // return false;

                    },

                }
            });
        }




    });

    function updateusersetup(selected, role, bso_id, parent_id, allCheck) {
        var data = {
            "action": selected,
            "ids": allCheck,
            "role": role,
            "bso_id": bso_id,
            "parent_id": parent_id
        };
        console.log(data);
        $.ajax({
            type: "POST",
            dataType: "html",
            url: baseurl + "users/usersetup", //Relative or absolute path to response.php file
            data: data,
            success: function(data) {
                //console.log(data);
                $('#checkall').prop('checked', false);
                $('.table_body').html(data);

                return false;
            }
        });
        return false;

    }

    ///////////////Services/////////////////
    $('#service-day').on('change', function() {
        //////(data.length !== 2)
        //alert($(this).val());
        var selected = $(this).val();
        var data = {
            "day": selected,
        };
        $.ajax({
            type: "POST",
            dataType: "html",
            url: baseurl + "users/getservices", //Relative or absolute path to response.php file
            data: data,
            success: function(data) {
                var obj = jQuery.parseJSON(data);
                console.log(obj);
                if (obj['length'] == 0) {
                    var data = '<div class="container"><h4>No Previous Time Slot Avalabel!</h4></div>';
                    $('.output').html(data);
                    return false;
                } else {
                    var obj = jQuery.parseJSON(data);
                    var data = '<div class="container"><h2>Previous Time Slots</h2><p>previously you have selected these time slots for' + ' ' + ' <b>' + selected + '</b></p><table class="table table-bordered">';
                    data += '<thead><tr><th>Start time</th><th>End time</th><th>Min age</th><th>Max age</th></tr></thead>';
                    $(obj).each(function(key, value) {
                        var ds = value["start_time"];
                        console.log(ds);
                        data += '<tbody><tr><td>' + value["start_time"] + '</td><td>' + value["end_time"] + '</td><td>' + value["min_age"] + '</td><td>' + value["max_age"] + '</td></tr></tbody>';

                    });
                    data += '</table></div>';
                    $('.output').html(data);
                    return false;
                }
            }
        });
        return false;

    });

    ///////////////Function End//////////


    /////////////////TAX/////////
    $('#service-tax1').on('change', function() {
        var selected = $(this).val();
        if (selected == 'Including') {
            $('#service-tax').removeAttr("disabled", false);

        }

    });
    ////////////END//////////////

    $('#checkall').click(function() {
        if ($('input #checkall:checked').length == $('input #checkall').length) {
           // alert("poi");
            var checked = $(this).prop('checked');
            $('.checkboxes').find('input:checkbox').prop('checked', checked);
            $('.usersetup').removeAttr("disabled");
        }
        if ($('input #checkall:checked').length != $('input #checkall').length) {
           // alert("oop");
            $('.usersetup').attr("disabled","disabled");
        }

    });

    $("input.cheks").change(function() {
       // alert("qwwe");
        if ($('input.cheks:checked').length == $('input.cheks').length) {
                //alert("qwer");
            var checked = $(this).prop('checked');
            $('.checkboxes').find('input:checkbox').prop('checked', checked);
            $('.usersetup').removeAttr("disabled");
        }
        if ($('input.cheks:checked').length != $('input.cheks').length) {
               // alert("qw89");
            //var checked = $(this).prop('checked');("required", "true");
            //$('.checkboxes').find('input:checkbox').prop('checked', checked);
           // $('.usersetup').attr("disabled","disabled");
           $('.usersetup').removeAttr("disabled");
        }
        if($('input.cheks:checked').length == $('input.cheks').not(':checked').length){
              $('.usersetup').removeAttr("disabled");
             // $('.usersetup').attr("disabled","disabled");
        }
        // if ($('input.checkall').not(':checked').length) {
        //     alert("isss");
        // }
        // if ($('input.cheks')) {
        //         alert("qw89");
        //     //var checked = $(this).prop('checked');("required", "true");
        //     //$('.checkboxes').find('input:checkbox').prop('checked', checked);
        //     $('.usersetup').attr("disabled","disabled");
        //   // $('.usersetup').removeAttr("disabled");
        // }
    });
    $(document).on('change', '.relation ', function() {
        var value = $(this).val();
        if (value == 3) {
            $(this).closest(".row").find(".showrelation").show();
            $(this).closest(".row").find(".showrelation").removeClass("hide");
        } else {
            $(this).closest(".row").find(".showrelation").css("display", "none");
            $('.showrelation input').removeAttr("required");
        }


    });

    $('#click1').on('click', function() {
        var count = $(this).attr('data-attr');

        var view1 = '<div class="row"><div class="col-sm-6"><div class="form-group"><label>Name</label>';
        view1 += '<div class="input text"><input type="text" name="data[' + count + '][name]" class="form-control" placeholder=" Name" id="name"><input type="hidden" name="ids[]"value="-1"></div></div></div>';
        view1 += '<div class="col-sm-6"><div class="form-group"><label>Relation with child *</label><select name="data[' + count + '][relation1]" class="relation form-control show-tick"><option value="0">Please select</option><option value="1">Son</option><option value="2">Daughter</option><option value="3">Other, Please specify below</option></select>';
        view1 += '</div></div><div class="col-sm-12"><div class="form-group showrelation" style="display:none;"><label>Please specify relation with child *</label><div class="input text"><input type="text" name="data[' + count + '][relation]" class="form-control" placeholder="Relation with child" id="relation"></div></div></div></div>';

        $("#view1").append(view1);
        count++;
        $(this).attr('data-attr', count);
    });

    $('#click2').on('click', function() {

        var view1 = '<div class="row"><div class="col-sm-6"><div class="form-group"><label>Opvang</label>';
        view1 += '<div class="input text focused"><input type="text" name="reception[]" class="form-control" id="reception"></div></div></div>';
        view1 += '<div class="col-sm-6"><label>Date *</label>';
        view1 += '<div class="input text"><input type="text" name="reception_date[]" class="datepicker form-control" placeholder="Datum intake" id="reception-date" data-dtp="dtp_T2LGW"></div></div></div>';

        $("#view2").append(view1).find('.datepicker').bootstrapMaterialDatePicker({
            format: 'dddd DD MMMM YYYY',
            clearButton: true,
            weekStart: 1,
            time: false
        });
    });

    $('#radio_50').on('click', function() {

        $('.Same').css("display", "block");
        $('.Differnt').css("display", "none");
        $('.showdiff').removeAttr("required");
    });
    $('#radio_51').on('click', function() {

        $('.Differnt').css("display", "block");
        $('.Same').css("display", "none");
        $('.showsame').removeAttr("required")
    });

    $('#radio_52').on('click', function() {

        $('#childbusy').css("display", "block");

    });
    $('#radio_53').on('click', function() {

        $('#childbusy').css("display", "none");

    });
    $('#radio_48').on('click', function() {

        $('#childlike').css("display", "block");

    });
    $('#radio_49').on('click', function() {

        $('#childlike').css("display", "none");

    });
    $('#radio_66').on('click', function() {

        $('#childargue').css("display", "block");

    });
    $('#radio_67').on('click', function() {

        $('#childargue').css("display", "none");

    });
    $('#radio_70').on('click', function() {

        $('#specialdiseases').css("display", "block");

    });
    $('#radio_71').on('click', function() {

        $('#specialdiseases').css("display", "none");

    });
    $('#radio_72').on('click', function() {

        $('#allergies').css("display", "block");

    });
    $('#radio_73').on('click', function() {

        $('#allergies').css("display", "none");

    });
    $('#radio_74').on('click', function() {

        $('#senses').css("display", "block");

    });
    $('#radio_75').on('click', function() {

        $('#senses').css("display", "none");

    });
    $('#radio_94').on('click', function() {

        $('#childalwaysunderstand').css("display", "block");

    });
    $('#radio_95').on('click', function() {

        $('#childalwaysunderstand').css("display", "none");

    });
    $('#radio_7').on('click', function() {

        $('#additionalinformation').css("display", "block");

    });
    $('#radio_8').on('click', function() {

        $('#additionalinformation').css("display", "none");

    });

    $('#radio_9').on('click', function() {

        $('#whomwithchild_likestoplay').css("display", "block");

    });
    $('#radio_10').on('click', function() {

        $('#whomwithchild_likestoplay').css("display", "none");

    });
    $('#radio_11').on('click', function() {

        $('#contactwithschool').css("display", "block");

    });
    $('#radio_12').on('click', function() {

        $('#contactwithschool').css("display", "none");

    });
    $(function active_li() {
        var interest = $('ul#credit').find('li.active a').text();
        //alert(interest);
    });
    /////////Functionality for  Basic Info ////////////
    $('.btnNext').click(function() {
        // alert("alert1");
        var formData = $(this).parents('#Persoonsgegevens').find("form").serialize();

        if (formData) {
            var ingestion_date = $('input[name=ingestion_date]').val();
            var reception = $('.reception').val();
            var receptiondate = $('.receptiondate').val();
            //alert(receptiondate .length);
            $('.removeit').remove();
            if (ingestion_date.length == 0) {
                $('input[name=ingestion_date]').parent().append('<p  class="removeit" style="color:red;">Ingestion Date is Required.</p>');
                return false;
            }


            if (reception.length >= 1 && receptiondate.length == 0) {
                $('.receptiondate').parent().append('<p  class="removeit" style="color:red;">Reception Date is Required.</p>');
                return false;
            }

            $.ajax({
                type: "POST",
                dataType: "html",
                url: baseurl + "parent/users/personaldata", //Persoonsgegevens data
                data: formData,
                success: function(data) {
                    if (data) {
                        $('.nav-tabs > .active').next('li').find('a').trigger('click');
                        return false;
                    }
                }
            });
        }


        var formgedragsociaal = $(this).parents('#gedragsociaal').find("form").serialize();
        if (formgedragsociaal) {
            $.ajax({
                type: "POST",
                dataType: "html",
                url: baseurl + "parent/users/socialbehavior", //Speelwerkgedrag && Sociale gegevens data
                data: formgedragsociaal,
                success: function(data) {
                    //console.log(data);
                    if (data) {
                        $('.nav-tabs > .active').next('li').find('a').trigger('click');
                        return false;
                    }
                }
            });
        }
        var medischemotioneel = $(this).parents('#medischemotioneel').find("form").serialize();
        if (medischemotioneel) {

            $.ajax({
                type: "POST",
                dataType: "html",
                url: baseurl + "parent/users/medicalemotional", //Medische gegevens && Emotionele gegevens data
                data: medischemotioneel,
                success: function(data) {
                    //console.log(data);
                    if (data) {
                        $('.nav-tabs > .active').next('li').find('a').trigger('click');
                        return false;
                    }
                }
            });
        }

        var Opvoedingsgegevens = $(this).parents('#Opvoedingsgegevens').find("form").serialize();
        if (Opvoedingsgegevens) {

            $.ajax({
                type: "POST",
                dataType: "html",
                url: baseurl + "parent/users/educationallanguage", //Opvoedingsgegevens && Taalontwikkeling data
                data: Opvoedingsgegevens,
                success: function(data) {
                    //console.log(data);
                    if (data) {
                        $('.nav-tabs > .active').next('li').find('a').trigger('click');
                        return false;
                    }
                }
            });
        }

        var Andereinformatie = $(this).parents('#Andereinformatie').find("form").serialize();
        if (Andereinformatie) {

            $.ajax({
                type: "POST",
                dataType: "html",
                url: baseurl + "parent/users/otherinformation", //Andereinformatie
                data: Andereinformatie,
                success: function(data) {
                    //console.log(data);
                    if (data) {
                        var url = baseurl + "parent/users/manage-children"
                        window.location.replace(url);
                        //$('.nav-tabs > .active').next('li').find('a').trigger('click');
                        return false;
                    }
                }
            });
        }
        return false;
    });

    $('.btnPrevious').click(function() {
        $('.nav-tabs > .active').prev('li').find('a').trigger('click');
    });
    $('.btnNextbso').click(function() {
        $('.nav-tabs > .active').next('li').find('a').trigger('click');
        return false;
    });

    $('.btnPreviousbso').click(function() {
        $('.nav-tabs > .active').prev('li').find('a').trigger('click');
        return false;
    });

    ////////////////// J Query  Validations ////////////////

    ////////////// Validate basic info of child //////////////////////////

    $('.reception').keyup(function() {

        var selected = $(this).val();
        if (selected) {
            $(".receptiondate").attr("required", "true");
        }

    });

    $('#autocomplete').keydown(function(e) {
       // alert("qwer");
        var specialKeys = new Array();
        specialKeys.push(8);
        var len = $(this).val().length;
     //   alert(len);
        if (len <= 3) {
            var keyCode = e.which ? e.which : e.keyCode
            var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1 || (keyCode >= 95 && keyCode <= 105));
            return ret;
        }

        if (len > 3 && len < 7) {

            var keyCode = e.which ? e.which : e.keyCode
            var ret = ((keyCode >= 65 && keyCode <= 90) || specialKeys.indexOf(keyCode) != -1);
            return ret;
        }

        if (len >= 7) {
            var keyCode = e.which ? e.which : e.keyCode
            var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1 || (keyCode >= 95 && keyCode <= 105));
            return ret;
        }


    });
    $("#mobile-no").keypress(function(e) {

        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {

            $("#errmsg").html("Digits Only").show().fadeOut("slow");
            return false;
        }
    });
    //////////// USERS  table info /////////////////

    // $('.myform').each(function () {

    $('.myform').validate({ // initialize the plugin
        //alert("qwe");
        rules: {
            firstname: {
                required: true,

            },
            email: {
                required: true,
                email: true,
                //regex: /^\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
            },
            mobile_no: {

                required: true,
                // regex: /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/
                //number: true,
            },
            post_code: {

                required: true,

            },
            address: {

                required: true,

            },
            dob: {

                required: true,

            },
            relation1: {

                required: true,

            },
            lastnamedob: {

                required: true,

            },
            gender: {

                required: true,
                //error.insertBefore(element);


            },
            joining_date: {

                required: true,

            },
            residence: {

                required: true,

            },
            price_weekly: {

                required: true,

            },
            price_monthly: {

                required: true,

            },
            price_yearly: {

                required: true,

            },
            password: {

                required: true,

            },
            confirm_password: {

                required: true,
                equalTo: "#password",

            },
            childin_batch: {
                required: true,
            },
            "child_group_name[]": {
                required: true,
            },
            "no_of_childs[]": {
                required: true,
            },
            "no_of_teachers[]": {
                required: true,
            }

        },    messages: {},
    errorPlacement: function(error, element) {
      var placement = $(element).data('error');
      if (placement) {
       // alert("I M Error");
        $(placement).append(error)
      } else {
        //alert("I M Error");
        error.insertBefore(element);
      }
    }


    });

    // });
    // $(this).validate({
    //            // your options
    //        });
    //     $("input[id='post-code']").keyup(function count() {
    //         //alert();
    //     var input = this.value;
    //     var regex = new RegExp(/^[0-9]{4}[a-z]{2}$/i);
    //     console.log(regex.test(input));
    // // });
    //     $('#confirm-password').keyup(function() {
    //        var pas = $('#password').val();
    //         var th = $(this).val();
    //     //   alert(pas);
    //        if(pas !=== th){

    //         console.log("confirm-password doesnot match with Password");
    //        }
    //         //$th.val( $th.val().replace(/[^a-zA-Z0-9]/g, function(str) { alert('You typed " ' + str + ' ".\n\nPlease use only letters and numbers.'); return ''; } ) );
    // });

    $('.clicks').click(function() {
        if ($(this).find('.cheks').is(':checked')) {
            //.removeAttr('checked');
            // alert("check box");
            $(this).find('.cheks').prop("checked", false);
        } else {
            $(this).find('.cheks').prop("checked", true);
        }


    });

    $(".submitservice").click(function(event) {
        if ($('input[type="checkbox"]').is(':checked')) {
            $(this).parents('form').submit();
        } else {
            $.confirm({
                theme: 'light',
                title: 'Alert!',
                content: 'Please Select Any Service!',
            });
            return false;
        }


    });
    $("#undo_redo").change(function(event) {

        var last_valid_selection = null;
        var noofteachers = $("#add-teacher-no").val();
        if ($('#undo_redo_to option').length >= noofteachers) {
            $(this).val(last_valid_selection);
            $.confirm({
                theme: 'light',
                title: 'Alert!',
                content: 'The Add no of Teachers may be empty or equal to the numbers you have selected!',
                buttons: {
                    ok: function() {
                        // updateusersetup(selected,role,bso_id,parent_id,allCheck);
                    },


                }
            });

        }
    });
    $("#min-age").change(function(event) {
        var minvalue = $("#min-age").val();
        var i = 0;
        for (i = 0; i <= 10; i++) {

            if (minvalue < i) {

                $("#max-age").children("option[value^=" + i + "]").show();
            } else {
                $("#max-age").children("option[value^=" + i + "]").hide();
            }

        }
    });

    $("#check_child_groups").click(function(event) {
        var is_valid = checkvalidate();
        var keycount = $("#keycount").val();
        if (is_valid) {
            var childs_in_batch = $("#childin-batch").val();

            var values = $(".no_of_childs").map(function() {
                return $(this).val();
            }).get();
            var total = 0;
            for (var i = 0; i < values.length; i++) {
                total += values[i] << 0;
            }

            if (parseInt(total) < parseInt(childs_in_batch)) {
                var no_of_childs = $("#child-groups").val();
                var service_day = $("#service-day").val();
                var service_type = $("#service-type").val();
                var newkeycount = parseInt(keycount) + 1;
                var name = service_day + ' ' + service_type + ' ' + newkeycount;

                var childdiv = '<div class="childrows"><div class="col-sm-3"><label>Add Child Group Name*</label><div class="input text">';
                childdiv += '<input type="text" name="child_group_name[]" class="form-control child_group_name" placeholder="Child Group Name" id="child-group-name-' + newkeycount + '" value="' + name + '"></div></div>';
                childdiv += '<div class="col-sm-3"><label>Add No of Childs In This Group*</label><div class="input text">';
                childdiv += '<input type="text" name="no_of_childs[]" value="" class="form-control no_of_childs" placeholder="No of Childs" id="no-of-childs-' + newkeycount + '"></div></div>';
                childdiv += '<div class="col-sm-3"><label>Add No of Teachers In This Group*</label><div class="input text">';
                childdiv += '<input type="text" name="no_of_teachers[]" value="" class="form-control no_of_teachers" placeholder="No of Teachers" id="no-of-teachers-' + newkeycount + '"></div></div><div class="col-sm-3"><div class="removetag"><a href="javascript:void(0)" class="btn bg-teal remove_block" data-attr="" id="child_groups">Remove</a></div></div></div></div>';
                $('.childs_divide').append(childdiv);
                $("#keycount").val(newkeycount);
            } else {
                $.confirm({
                    theme: 'light',
                    title: 'Alert!',
                    content: 'Your no of child and (Max. Batch Subscription) are complete !',
                    buttons: {
                        ok: function() {

                        },


                    }
                });
            }


        } else {


        }

    });

    $("#check_edit_groups").click(function(event) {
        var is_valid = checkvalidate();
        var keycount = $("#keycount").val();

        if (is_valid) {
            var childs_in_batch = $("#childin-batch").val();
            var values = $(".no_of_childs").map(function() {
                return $(this).val();
            }).get();
            var total = 0;

            for (var i = 0; i < values.length; i++) {
                total += values[i] << 0;
            }

            if (parseInt(total) < parseInt(childs_in_batch)) {
                var no_of_childs = $("#child-groups").val();
                var service_day = $("#service-day").val();
                var service_type = $("#service-type").val();
                var service_id = $("#service_id").val();
                var keycount = $("#keycount").val();

                if (keycount == 0) {
                    var newkeycount = '0';
                } else {
                    var newkeycount = parseInt(keycount) + 1;
                }
                var name = service_day + ' ' + service_type;
                var childdiv = '<div class="childrows"><div class="col-sm-3"><label>Add Child Group Name*</label><div class="input text">';
                childdiv += '<input type="text" name="group[' + newkeycount + '][child_group_name]"  class="form-control child_group_name" placeholder="Child Group Name" id="child-group-name-' + newkeycount + '" value="' + name + '"></div></div>';
                childdiv += '<div class="col-sm-3"><label>Add No of Childs In This Group*</label><div class="input text">';
                childdiv += '<input type="text" name="group[' + newkeycount + '][no_of_childs]" value="" class="form-control no_of_childs" placeholder="No of Childs" id="no-of-childs-' + newkeycount + '"></div></div>';
                childdiv += '<div class="col-sm-3"><label>Add No of Teachers In This Group*</label><div class="input text">';
                childdiv += '<input type="text" name="group[' + newkeycount + '][no_of_teachers]" value="" class="form-control no_of_teachers" placeholder="No of Teachers" id="no-of-teachers-' + newkeycount + '"></div><input type="hidden" name="group[' + newkeycount + '][service_id]" class="form-control" value="' + service_id + '"></div><div class="col-sm-3"><div class="removetag"><a href="javascript:void(0)" class="btn bg-teal remove_block" data-attr="" id="child_groups">Remove</a></div></div></div></div>';
                $('.childs_divide').append(childdiv);
                $("#keycount").val(newkeycount);

            } else {
                $.confirm({
                    theme: 'light',
                    title: 'Alert!',
                    content: 'Your no of child and (Max. Batch Subscription) are complete !',
                    buttons: {
                        ok: function() {

                        },


                    }
                });
            }
        } else {

        }

    });

    $("#buttonaddservice").click(function(event) {

        var is_valid = checkvalidate();
        //alert(is_valid);
        if (is_valid) {

        } else {
            $.confirm({
                theme: 'light',
                title: 'Alert!',
                content: 'Please fill all  fields of Divide Child And Teachers In Groups or remove extra fields) !',
                buttons: {
                    ok: function() {},


                }
            });

            return false;
        }

    });

    function checkvalidate() {
        var isValid = true;

        $('.childs_divide input[type="text"]').each(function() {

            if ($.trim($(this).val()) == '') {
                isValid = false;
                $(this).css({
                    "border": "1px solid red",
                    "background": "#FFCECE"
                });
            } else {
                $(this).css({
                    "border": "",
                    "background": ""
                });
            }
        });

        return isValid;
    }

    $('#childin-batch').keyup(function(event) {
        $('.no_of_childs').removeAttr("disabled");
    });

    $(document).on('click', '.remove_block', function(event) {
        var keycount = $("#keycount").val();
        var newkeycount = parseInt(keycount) - 1;
        $("#keycount").val(newkeycount);
        $(this).parents('div.childrows').remove();
    });

    $(document).on('blur', '.no_of_childs', function(event) {
      //  alert("qw");
        $(this).css({
            "border": "",
            "background": ""
        });
        var childs_in_batch = $("#childin-batch").val();
        var keycount = $("#keycount").val();
        var id = "no-of-childs-" + keycount;
        var nulls = '';
        var values = $(".no_of_childs").map(function() {
            return $(this).val();
        }).get();
        var total = 0;

        for (var i = 0; i < values.length; i++) {
            total += values[i] << 0;
        }

        // if (childs_in_batch !== '') {
        //     $('.no_of_teachers').removeAttr("disabled");
        // }

        if (parseInt(total) > parseInt(childs_in_batch)) {
            $.confirm({
                theme: 'light',
                title: 'Alert!',
                content: 'You cannot add this value because this value is grater than the value in(Max. Batch Subscription)!',
                buttons: {
                    ok: function() {},


                }
            });
            console.log("#" + id);
            $("#" + id).val(nulls);

        }

        if (childs_in_batch == '') {
            $.confirm({
                theme: 'light',
                title: 'Alert!',
                content: 'Please add value in (Max. Batch Subscription) field !',
                buttons: {
                    ok: function() {},


                }
            });
            console.log("#" + id);
            $("#" + id).val(nulls);
            return false;
        }




    });
    $(document).on('blur', '.no_of_teachers', function(event) {
        //alert("ww");
        var no_of_teacher = $("#add-teacher-no").val();
       // alert(no_of_teacher);
        var keycount = $("#keycount").val();
        var id = "no-of-teachers-" + keycount;
        var nulls = '';
        var values = $(".no_of_teachers").map(function() {
            return $(this).val();
        }).get();
        var total = 0;
        $(this).css({
            "border": "",
            "background": ""
        });

        for (var i = 0; i < values.length; i++) {
            total += values[i] << 0;
        }

        if (parseInt(total) > parseInt(no_of_teacher)) {

            $.confirm({
                theme: 'light',
                title: 'Alert!',
                content: 'You cannot add this value because this value is grater than the value in(Add no of Teachers)  !',
                buttons: {
                    ok: function() {},


                }
            });
            console.log("#" + id);
            $("#" + id).val(nulls);
        }

        if (no_of_teacher == '') {
            $.confirm({
                theme: 'light',
                title: 'Alert!',
                content: 'Please fill this field (Add no of Teachers) you have not added the total no of teachers  !',
                buttons: {
                    ok: function() {},


                }
            });
            console.log("#" + id);
            $("#" + id).val(nulls);
            return false;
        }



        var teachers = $('.no_of_teachers').val();


    });

    //$('#date-end').bootstrapMaterialDatePicker({date: false,weekStart : 0 }).on('change', function(e, date){
    //alert("ass");
    //});
    //$("#date-end").bootstrapMaterialDatePicker({
    ///comment get teachers
    // $("#add-teacher-no").click(function(event) {
    //         alert('qwe');
    //         var starttime = $("#date-start").val();
    //         var endtime = $("#date-end").val();
    //         var service_day = $("#service-day").val();
    //         var data = {
    //             "start": starttime,
    //             "end": endtime,
    //             "service_day" :service_day,
    //         };
    //         $.ajax({
    //             type: "POST",
    //             dataType: "html",
    //             url: baseurl + "users/servicesTeacher", //Relative or absolute path to response.php file
    //             data: data,
    //             success: function(data) {
    //                   //console.log(data);

    //                  var obj = jQuery.parseJSON( data );
    //                  var setdata = '';
    //                  $(obj).each(function(key,value){

    //                     setdata +="<option value="+value['user_id']+">"+value['firstname']+" "+value['lastname']+"</option>";

    //                 });
    //                  if(setdata == ''){
    //                     var setdata = "<option value="+'No teacher avalable in that time slot.'+">"+'No teacher avalable in that time slot.'+"</option>";

    //                  }
    //                console.log(setdata);
    //                 $('#undo_redo').html(setdata);
    //                  return false;
    //             }


    //         });
    //         //alert(endtime);


    // });




    ///////////////////////////////////////////////////////////////////////
    // $('#invoceterm1').click(function() {
    //     alert('i am clicked');
    //     if($(this).prop("checked") == true){
    //          //alert("Checkbox is checked.");
    //         $('#invoceterm2').attr("disabled","disabled");
               
    //         }
    //     else if($(this).prop("checked") == false){
    //         //alert("Checkbox is unchecked.");
    //         $('#invoceterm2').removeAttr("disabled", false);
    //     }

    // });

    // $('#invoceterm2').click(function() {
    //     alert('i am clicked');
    //     if($(this).prop("checked") == true){
    //          //alert("Checkbox is checked.");
    //         $('#invoceterm1').attr("disabled","disabled");
               
    //         }
    //     else if($(this).prop("checked") == false){
    //         //alert("Checkbox is unchecked.");
    //         $('#invoceterm1').removeAttr("disabled", false);
    //     }

    // });

    ///BSO SETTINGS////
    $('.invoicetype').on('click', function() {
        //alert("qwer");
        var selected = $(this).val();
        
        var data = {
            "invoicetype": selected,
        };
        $.ajax({
            type: "POST",
            dataType: "html",
            url: baseurl + "users/addinvoicetypeSettings", //Relative or absolute path to response.php file
            data: data,
            success: function(data) {
                location.reload();
                console.log(data);
              
            }
        });
        return false;
    });

    $('.invocesendfrmt').on('click', function() {
        //alert("ppo");
        var selected = $(this).val();
        var data = {
            "invocesendfrmt": selected,
        };
        $.ajax({
            type: "POST",
            dataType: "html",
            url: baseurl + "users/addinvocesendfrmtSettings", //Relative or absolute path to response.php file
            data: data,
            success: function(data) {
                location.reload();
                console.log(data);
              
            }
        });
        return false;
    });

    $('.calendarfrmt').on('click', function() {
        var selected = $(this).val();
        var schoolcalendarmonths = $('#schoolcalendarmonths').val();
        if(selected == 'Year calendar'){
            var schoolcalendarmonths = '';
        }else if(selected == 'School calendar'){
            if(schoolcalendarmonths == ''){
                $.confirm({
                theme: 'light',
                title: 'Alert!',
                content: 'School calendar Months! required',
                buttons: {
                    ok: function() {},


                }
                });
                //alert("School calendar Months! required");
                return false;
            }
            

        }
        var schoolcalendarmonths = schoolcalendarmonths;
        var data = {
            "calendarfrmt": selected,
            "schoolcalendarmonths": schoolcalendarmonths,
        };
        $.ajax({
            type: "POST",
            dataType: "html",
            url: baseurl + "users/addcalendarfrmtSettings", //Relative or absolute path to response.php file
            data: data,
            success: function(data) {
                location.reload();
                console.log(data);
              
            }
        });
        return false;
    });

    $('#saveholiday').on('click', function() {     
        //alert("saveholiday");
        var holidayname = $('#holidayname').val();
        var holidaystartdate = $('#datepicker').val();
        var holidaystarttime = $('#time').val();
        var holidayenddate = $('#datepickerEnd').val();
        var holidayendtime = $('#timeNew').val();
        var holiday_description = $('#holiday-description').val();
        var data = {
            "holidaystartdate": holidaystartdate,
            "holidayname": holidayname,
            "holidaystarttime": holidaystarttime,
            "holidayenddate": holidayenddate,
            "holidayendtime": holidayendtime,
            "holiday_description": holiday_description,
        };
        $.ajax({
            type: "POST",
            dataType: "html",
            url: baseurl + "users/addcalendarholiday", //Relative or absolute path to response.php file
            data: data,
            success: function(data) {
                location.reload();
                console.log(data);
              
            }
        });
        return false;
    });

    $('.viewholiday').on('click', function() {     
        var selected = $(this).val();
        var data = {
                "id": selected,
            };
        setTimeout(function(){            
            $.ajax({
                type: "POST",
                dataType: "html",
                url: baseurl + "users/viewcalendarholiday", //Relative or absolute path to response.php file
                data: data,
                success: function(data) {
                   var obj = jQuery.parseJSON(data);
                    console.log(obj);
                    var data = '<h4 class="modal-title">'+ obj['holidayname']+'</h4><div class="event-details"><div class="event-info-row"><label>Holiday Start</label><p>'+ obj['holidaystartdate']+' '+ obj['holidaystarttime'] +'</p></div>';
                        data +=  '<div class="event-info-row"><label>Holiday End</label><p>'+ obj['holidayenddate']+' '+ obj['holidayendtime'] +'</p></div>';
                        data += '<div class="event-info-row"><label>Description</label><p>'+ obj['holiday_description']+'</p></div></div>';
                        data += '<div class="modal-footer pt_0 bt_0 text-right"><button type="button" class="btn btn-default btn-round-md" data-dismiss="modal">Close</button>';
                        data += '<button type="button" class="btn btn-red btn-round-md" data-dismiss="modal" id="holidaydelete" value="'+ obj['id'] +'">Delete</button>';
                        data += '<button type="button" class="btn btn-theme btn-round-md" data-dismiss="modal" data-toggle="modal" data-target="#EditHoliday" value="'+ obj['id'] +'" id="holidayedit">Edit</a></div>';

                $('.viewmodel').html(data);            
                  
                }
            });    

        },500);
        
        
    });

    $(document).on('click', '#holidayedit ', function() {
        var selected = $(this).val();
        var data = {
                "id": selected,
        };

        setTimeout(function(){            
            $.ajax({
                type: "POST",
                dataType: "html",
                url: baseurl + "users/viewcalendarholiday", //Relative or absolute path to response.php file
                data: data,
                success: function(data) {
                   var obj = jQuery.parseJSON(data);
                    console.log(obj);
                     var data = '<div class="event-details"><div class="form-group"><label>Holiday Name *</label>';
                         data += '<div class="input text"><input type="text" name="holidayname" class="form-control" placeholder="Holiday Name"maxlength="255"id="holidaynameedit" value="'+ obj['holidayname']+'"></div></div>';
                         data += '<div class="form-group"><label>Holiday Start *</label><div class="row"><div class="col-xs-6"><div class="input-group"><div class="input text"><input type="text" name="holidaystartdate" class="form-control" id="datepickerEdit" value="'+ obj['holidaystartdate']+'"></div><div class="input-group-addon"><i class="fa fa-calendar"></i></div></div></div>';
                         data += '<div class="col-xs-6"><div class="input-group"><div class="input text"><input type="text" name="holidaystarttime" class="form-control" id="timeEdit" maxlength="255" data-dtp="dtp_TmUVl" value="'+ obj['holidaystarttime']+'"></div><div class="input-group-addon"><i class="fa fa-clock-o"></i></div></div></div></div></div>';
                         data += '<div class="form-group"><label>Holiday End *</label><div class="row"><div class="col-xs-6"><div class="input-group"><div class="input text"><input type="text" name="holidayenddate" class="form-control" id="datepickerEditNew" value="'+ obj['holidayenddate']+'"></div><div class="input-group-addon"><i class="fa fa-calendar"></i></div></div></div>';
                         data += '<div class="col-xs-6"><div class="input-group"><div class="input text"><input type="text" value="'+ obj['holidayendtime']+'" name="holidayendtime" class="form-control" id="timeEditNew" maxlength="255" data-dtp="dtp_7rcw9"></div><div class="input-group-addon"><i class="fa fa-clock-o"></i></div></div></div></div></div>';
                         data += '<div class="form-group"><label>Description</label><div class="input textarea"><textarea name="holiday_description" class="form-control textarea-100" id="holiday-descriptionedit" maxlength="255" rows="5">'+ obj['holiday_description']+'</textarea></div></div></div>';
                         data += '<div class="modal-footer pt_0 bt_0 text-right"><button type="button" class="btn btn-default btn-round-md" data-dismiss="modal">Close</button><button type="button" class="btn btn-theme btn-round-md" data-dismiss="modal" id="editsave" value="'+ obj['id'] +'">Save</a></div>';

                $('.editmodal').html(data);            
                  
                }
            });    

        },500);    

    }); 
     $(document).on('click', '#editsave ', function() {
        // alert("it is");
        var selected = $(this).val();
        var holidayname = $('#holidaynameedit').val();
        var holidaystartdate = $('#datepickerEdit').val();
        var holidaystarttime = $('#timeEdit').val();
        var holidayenddate = $('#datepickerEditNew').val();
        var holidayendtime = $('#timeEditNew').val();
        var holiday_description = $('#holiday-descriptionedit').val();
        var data = {
            "id" : selected,
            "holidaystartdate": holidaystartdate,
            "holidayname": holidayname,
            "holidaystarttime": holidaystarttime,
            "holidayenddate": holidayenddate,
            "holidayendtime": holidayendtime,
            "holiday_description": holiday_description,
        };

         setTimeout(function(){            
            $.ajax({
                type: "POST",
                dataType: "html",
                url: baseurl + "users/editcalendarholiday", //Relative or absolute path to response.php file
                data: data,
                success: function(data) {
                   var obj = jQuery.parseJSON(data);
                   $('#event_title'+ obj.id).html(obj.holidayname);
                   location.reload();
                }
            });    

        },500);
     });

     $(document).on('click', '#holidaydelete ', function() {
        var selected = $(this).val();
        var data = {
            "id" : selected,
        };

        setTimeout(function(){            
            $.ajax({
                type: "POST",
                dataType: "html",
                url: baseurl + "users/deletecalendarholiday", //Relative or absolute path to response.php file
                data: data,
                success: function(data) {
                   var obj = jQuery.parseJSON(data);

                   $('#event_title'+ obj.id).html();
                   location.reload();
                           
                  
                }
            });    

        },500);

      });  
     

});
 
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