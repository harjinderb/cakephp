$(document).ready(function() {
  var imgpath = baseurl +"uploads/users/";
	$('#managechild').DataTable({
		"processing": true,
		"serverSide": true,
		"ajax": baseurl + "parent/users/manageChildrendata",
        "columns": [
			{ "data": function ( data, type, row, meta ) {
      			return '<div class="cst-check"><input type="checkbox" class="cst-check__input"><span class="check-holder"><i class="fa fa-check" aria-hidden="true"></i></span></div>';
			}},
            { "data": "id"},
            { "data": "name"},
            { "data": function ( data, type, row, meta ) {
            	
      			return '<img src="'+ imgpath +data['uuid']+'/'+data['image']+'" alt="" class="table-img-thumb">';
			}},
            { "data": "gender"},
            { "data": "dob"},
			   {"data": function ( data, type, row, meta ) {
			   
			    return '<button href="javascript:void(0)" class="btn btn-orange-border applylevdata" type="button" attrid ="'+data['uuid']+'" data-toggle="modal" data-target="#ApplyLeave">Apply Leave</button>';
			   
			   }},
        	
        	{"data": function ( data, type, row, meta ){
            	var view ='<div class="btn__group"><a href="'+baseurl +'parent/users/childview/'+data['uuid']+'" class="btn btn-green-border">View</a>';
  					view += '<a href="'+baseurl +'parent/users/child-edit/'+data['uuid']+'" class="btn btn-theme-border">Edit</a>';
					view += '<a href="'+baseurl +'parent/users/basic-info/'+data['uuid']+'" class="btn btn-teal-border">Basic info</a>';
					view += '<a href="'+baseurl +'parent/users/attendance/'+data['uuid']+'" class="btn btn-dark-green-border">view Attendance</a>';
					view += '<a href="#" class="btn btn-red-border delt" attrid ="'+data['uuid']+'">Delete</a></div>';
				return view ;
			}},
        ]
	});
	$('#manageguardian').DataTable({
		"processing": true,
		"serverSide": true,
		"ajax": baseurl + "parent/users/manageGuardiandata",
        "columns": [
			{ "data": function ( data, type, row, meta ) {
      			return '<div class="cst-check"><input type="checkbox" class="cst-check__input"><span class="check-holder"><i class="fa fa-check" aria-hidden="true"></i></span></div>';
			}},
            { "data": "id"},
            { "data": "name"},
            { "data": function ( data, type, row, meta ) {
            	
      			return '<img src="'+ imgpath +data['uuid']+'/'+data['image']+'" alt="" class="table-img-thumb">';
			}},
            { "data": "gender"},
            { "data": "dob"},
            { "data": "relation"},
		   { "data": function ( data, type, row, meta ) {
		   if(data['status'] == 'Activated') {
		    return '<span class="label label-bg-green label-110 label-round">'+data['status']+'</span>';
		   }else{
		   return '<span class="label label-bg-orange label-110 label-round">'+data['status']+'</span>';
		   }
		   }},
        	
        	{"data": function ( data, type, row, meta ){
            	var view ='<div class="btn__group"><a href="#" class="btn btn-green-border viewgurdn" attrid ="'+data['uuid']+'">View</a>';
  					view += '<a href="'+baseurl +'parent/users/guardian-edit/'+data['uuid']+'" class="btn btn-theme-border">Edit</a>';
  					if(data['status'] == 'Activated') {
				    view += '<a href="#" class="btn btn-orange-border deactivgurdn" attrid ="'+data['uuid']+'">Deactivate</a>';
				   }else{
				   view += '<a href="#" class="btn btn-dark-green-border activgurdn" attrid ="'+data['uuid']+'">Activate</a>';
				   }
					
					view += '<a href="#" class="btn btn-red-border deltgurdn" attrid ="'+data['uuid']+'">Delete</a></div>';
				return view ;
			}},
        ]
	});
	$('#employees').DataTable({
		"processing": true,
		"serverSide": true,
		"ajax": baseurl + "employee/employees/employeesdata",
        "columns": [
			{ "data": function ( data, type, row, meta ) {
      			return '<div class="cst-check"><input type="checkbox" class="cst-check__input"><span class="check-holder"><i class="fa fa-check" aria-hidden="true"></i></span></div>';
			}},
            { "data": "id"},
            { "data": "id"},
            { "data": "name"},
            { "data": function ( data, type, row, meta ) {
            	
      			return '<img src="'+ imgpath +data['uuid']+'/'+data['image']+'" alt="" class="table-img-thumb">';
			}},
            { "data": "gender"},
   
   
		   { "data": function ( data, type, row, meta ) {
		   if(data['status'] == 'Activated') {
		    return '<span class="label label-bg-green label-110 label-round">'+data['status']+'</span>';
		   }else{
		   return '<span class="label label-bg-orange label-110 label-round">'+data['status']+'</span>';
		   }
		   }},
        	
	    	{"data": function ( data, type, row, meta ){
        	var view ='<div class="btn__group"><a href="#" class="btn btn-green-border viewemp" attrid ="'+data['uuid']+'">View</a>';
				view += '<a href="'+baseurl +'employee/employees/emp-edit/'+data['uuid']+'" class="btn btn-theme-border">Edit</a>';
					if(data['status'] == 'Activated') {
			    view += '<a href="#" class="btn btn-orange-border deactivemp" attrid ="'+data['uuid']+'">Deactivate</a>';
			   }else{
			   view += '<a href="#" class="btn btn-dark-green-border activemp" attrid ="'+data['uuid']+'">Activate</a>';
			   }
			view += '<a href="'+baseurl +'employee/employees/roster/'+data['uuid']+'" class="btn btn-teal-border">Roster</a>';
			view += '<a href="'+baseurl +'employee/employees/emp-attendance/'+data['uuid']+'" class="btn btn-dark-green-border">View Attendance</a>';
				
				view += '<a href="#" class="btn btn-red-border deltemp" attrid ="'+data['uuid']+'">Delete</a></div>';
			return view ;
		}},
        ]
	});
	$('#parentlist').DataTable({
		"processing": true,
		"serverSide": true,
		"ajax": {
	    	"url": baseurl + "users/parentsdata",
	    	"type": "POST",

	    },
		"columns": [
			{ "data": function ( data, type, row, meta ) {
      			return '<div class="cst-check"><input type="checkbox" class="cst-check__input"><span class="check-holder"><i class="fa fa-check" aria-hidden="true"></i></span></div>';
			}},
            { "data": "id"},
  			{ "data": "bsn_no"},
  
            { "data": "name"},
            { "data": function ( data, type, row, meta ) {
            	
      			return '<img src="'+ imgpath +data['uuid']+'/'+data['image']+'" alt="" class="table-img-thumb">';
			}},
            { "data": "gender"},
   
   
		   { "data": function ( data, type, row, meta ) {
		   if(data['status'] == 'Activated') {
		    return '<span class="label label-bg-green label-110 label-round">'+data['status']+'</span>';
		   }else{
		   return '<span class="label label-bg-orange label-110 label-round">'+data['status']+'</span>';
		   }
		   }},
        	
	    	{"data": function ( data, type, row, meta ){
        	var view ='<div class="btn__group"><a href="'+baseurl +'users/parent-profile/'+data['uuid']+'" class="btn btn-green-border viewemp" attrid ="'+data['uuid']+'">View</a>';
			   view += '<a href="'+baseurl +'users/edit-parents/'+data['uuid']+'" class="btn btn-theme-border">Edit</a>';
			   view += '<a href="'+baseurl +'users/add-child/'+data['uuid']+'" class="btn btn-dark-green-border">Add Child</a>';
			   view += '<a href="'+baseurl +'users/add-guardian/'+data['uuid']+'" class="btn btn-teal-border">Add Gurdian</a>';
			   view += '<a href="#" class="btn btn-red-border deltprnt" attrid ="'+data['uuid']+'">Delete</a></div>';
			return view ;
		}},
        ]
	});
	$('#invoicelist').DataTable({
		"processing": true,
		"serverSide": true,
		"ajax": baseurl + "users/invoicesdata",
  	    "columns": [
			{ "data": function ( data, type, row, meta ) {
      			return '<div class="cst-check"><input type="checkbox" class="cst-check__input"><span class="check-holder"><i class="fa fa-check" aria-hidden="true"></i></span></div>';
			}},
            { "data": "id"},
  			{ "data": "id"},
			{ "data": "name"},
			{ "data": "parent_name"},
			{ "data": " "},
			{ "data": 'previousinvoice'},
            {"data": function ( data, type, row, meta ){
            var view ='<div class="btn__group"><a href="'+baseurl +'users/child-services/'+data['uuid']+'" class="btn btn-green-border viewemp" attrid ="'+data['uuid']+'">View Services</a>';
			    view += '<a href="'+baseurl +'users/view-invoice/'+data['uuid']+'" class="btn btn-theme-border">View Invoice</a>';
			    view += '<a href="'+baseurl +'users/send-invoice/'+data['uuid']+'" class="btn btn-aqua-border deltprnt" attrid ="'+data['uuid']+'">Send Invoice</a></div>';
				//view += '<a href="'+baseurl +'users/receive-payment/'+data['uuid']+'" class="btn btn-orange-border" attrid ="'+data['uuid']+'">Receive Payment</a></div>';   
			return view ;
			}},

        ]
	});
	$('#manageservices').DataTable({
		"processing": true,
		"serverSide": true,
		"ajax": baseurl + "users/manageServicesdata",
  		   "columns": [
			{ "data": function ( data, type, row, meta ) {
      			return '<div class="cst-check"><input type="checkbox" class="cst-check__input"><span class="check-holder"><i class="fa fa-check" aria-hidden="true"></i></span></div>';
			}},
            { "data": "id"},
  			{ "data": "service_day"},
			{ "data": "start_time"},
			{ "data": "end_time"},
			{ "data": function ( data, type, row, meta ) {
      			return '<span class="label label-bg-green label-110 label-round">'+data['status']+'</span>';
			}},  
            {"data": function ( data, type, row, meta ){
        	var view ='<div class="btn__group"><a href="'+baseurl +'users/child-services/'+data['uuid']+'" class="btn btn-green-border viewemp" attrid ="'+data['uuid']+'">View</a>';
			    view += '<a href="'+baseurl +'users/edit-services/'+data['uuid']+'" class="btn btn-theme-border">Edit</a>';
			    view += '<a href="'+baseurl +'users/services-assign/'+data['uuid']+'" class="btn btn-orange-border">Assign</a>';
			    view += '<a href="#" class="btn btn-red-border deltprnt" attrid ="'+data['uuid']+'">Delete</a></div>';
			return view ;
			}},

        ]
	});

	$('#payments').DataTable({
		"processing": true,
		"serverSide": true,
		"ajax": {
	    	"url": baseurl + "users/paymentsdata",
	    	"data": {user_id : $('#childuu_id').val()},
	    	"type": "POST",

	    },
  		   "columns": [
			{ "data": function ( data, type, row, meta ) {
      			return '<div class="cst-check"><input type="checkbox" class="cst-check__input"><span class="check-holder"><i class="fa fa-check" aria-hidden="true"></i></span></div>';
			}},
            { "data": "id"},
  			{ "data": "name"},
  			{ "data": function ( data, type, row, meta ) {
            	
      			return '<img src="'+ imgpath +data['uuid']+'/'+data['image']+'" alt="" class="table-img-thumb">';
			}},
            { "data": "gender"},
			{ "data": "invoice_date"},
			{ "data": "invoice_amount"},
			{ "data": "payment_status"},
			{ "data": "paied_amt"},
			{ "data": "balance"},
			{ "data": "payment_mode"},
			// { "data": function ( data, type, row, meta ) {
   //    			return '<span class="label label-bg-green label-110 label-round">'+data['status']+'</span>';
			// }},  
   //          {"data": function ( data, type, row, meta ){
   //      	var view ='<div class="btn__group"><a href="'+baseurl +'users/receive-payment/'+data['uuid']+'/'+data['payment_id']+'" class="btn btn-orange-border" attrid ="'+data['uuid']+'">Receive Payment</a>';
			//     // view += '<a href="'+baseurl +'users/edit-services/'+data['uuid']+'" class="btn btn-theme-border">Edit</a>';
			//     // view += '<a href="'+baseurl +'users/services-assign/'+data['uuid']+'" class="btn btn-orange-border">Assign</a>';
			//     // view += '<a href="#" class="btn btn-red-border deltprnt" attrid ="'+data['uuid']+'">Delete</a></div>';
			// return view ;
			// }},

        ]
	});
	$('#childsinvoice').DataTable({	
		"processing": true,
		"serverSide": true,
		"ajax": baseurl + "users/invoiceHistorydata",
		 "columns": [
			{ "data": function ( data, type, row, meta ) {
      			return '<div class="cst-check"><input type="checkbox" class="cst-check__input"><span class="check-holder"><i class="fa fa-check" aria-hidden="true"></i></span></div>';
			}},
            { "data": "id"},
  			{ "data": "name"},
  			{ "data": function ( data, type, row, meta ) {
            	
      			return '<img src="'+ imgpath +data['uuid']+'/'+data['image']+'" alt="" class="table-img-thumb">';
			}},
            { "data": "gender"},
			{ "data": "dob"},
		  
            {"data": function ( data, type, row, meta ){
        	var view ='<div class="btn__group"><a href="'+baseurl +'users/receive-payment/'+data['uuid']+'/'+data['payment_id']+'" class="btn btn-orange-border" attrid ="'+data['uuid']+'">Receive Payment</a>';
			    // view += '<a href="'+baseurl +'users/edit-services/'+data['uuid']+'" class="btn btn-theme-border">Edit</a>';
			    // view += '<a href="'+baseurl +'users/services-assign/'+data['uuid']+'" class="btn btn-orange-border">Assign</a>';
			    // view += '<a href="#" class="btn btn-red-border deltprnt" attrid ="'+data['uuid']+'">Delete</a></div>';
			return view ;
			}},

       ]

	});	
	
	$('#paymenthistory').DataTable({
		"processing": true,
		"serverSide": true,
		"ajax": baseurl + "users/paymentHistory",
		 "columns": [
			{ "data": function ( data, type, row, meta ) {
      			return '<div class="cst-check"><input type="checkbox" class="cst-check__input"><span class="check-holder"><i class="fa fa-check" aria-hidden="true"></i></span></div>';
			}},
            { "data": "id"},
  			{ "data": "name"},
  			{ "data": "paid_date"},
			{ "data": "paied_amt"},
			{ "data": "payment_mode"},
		  
  //           {"data": function ( data, type, row, meta ){
  //       	var view ='<div class="btn__group"><a href="'+baseurl +'users/receive-payment/'+data['uuid']+'/'+data['payment_id']+'" class="btn btn-orange-border" attrid ="'+data['uuid']+'">Receive Payment</a>';
		// 	    // view += '<a href="'+baseurl +'users/edit-services/'+data['uuid']+'" class="btn btn-theme-border">Edit</a>';
		// 	    // view += '<a href="'+baseurl +'users/services-assign/'+data['uuid']+'" class="btn btn-orange-border">Assign</a>';
		// 	    // view += '<a href="#" class="btn btn-red-border deltprnt" attrid ="'+data['uuid']+'">Delete</a></div>';
		// 	return view ;
		// 	}},

        ]

	});			
		
});







