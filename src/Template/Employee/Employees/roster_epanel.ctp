<!DOCTYPE html>
<html>
   <head>
      
      <link type="text/css" rel="stylesheet" href="<?= $this->request->webroot;?>calander/media/layout.css" />
      <link type="text/css" rel="stylesheet" href="<?= $this->request->webroot;?>calander/media/layout.css" />
      <link type="text/css" rel="stylesheet" href="<?= $this->request->webroot;?>calander/themes/calendar_green.css" />
      <link type="text/css" rel="stylesheet" href="<?= $this->request->webroot;?>calander/themes/calendar_traditional.css" />
      <link type="text/css" rel="stylesheet" href="<?= $this->request->webroot;?>calander/themes/calendar_transparent.css" />
      <link type="text/css" rel="stylesheet" href="<?= $this->request->webroot;?>calander/themes/calendar_white.css" />
      <!-- helper libraries -->
      <!-- daypilot libraries -->
      <script src="<?= $this->request->webroot;?>calander/js/daypilot/daypilot-all.min.js" type="text/javascript"></script>
   </head>
   <div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <!-- <section class="content-header">
      <h1>Attendance</h1>
      </section> -->
   <!-- Main content -->
   <section class="content">
      <div class="box box-primary">
         <div class="box-header bso-box-header">
            <div class="col-sm-6">
               <h3 class="box-title"><?=__('Employee Roster')?></h3>
            </div>
            <div class="col-sm-6 text-right">
               <?= $this->Html->link('<span>Check Employee Avalibelity</span>', ['controller' => 'Employees','action' => 'epanelAvailabelty',$id ,'prefix' => 'employee'], ['class' => 'btn btn bg-teal','escape' => false]);?>
            </div>
         </div>
         <!-- /.box-header -->
         <div class="box-body">
            <div class="card">
               <div class="header">
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="col-sm-12">
                           <h2>
                              <?=__('Name')?>: <?= $this->Decryption->mc_decrypt($profile['firstname'],$profile['encryptionkey']).''.''.$this->Decryption->mc_decrypt($profile['lastname'],$profile['encryptionkey'])?> 
                           </h2>
                        </div>
                        <?= $this->Flash->render() ?>
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
                           <div style="float:left; width: 160px;">
                              <div id="nav"></div>
                           </div>
                           <div style="margin-left: 160px;">
                              <!--  <div class="space">
                                 Theme: <select id="theme">
                                     <option value="calendar_default">Default</option>
                                     <option value="calendar_white">White</option>
                                     <option value="calendar_g">Google-Like</option>
                                     <option value="calendar_green">Green</option>
                                     <option value="calendar_traditional">Traditional</option>
                                     <option value="calendar_transparent">Transparent</option>
                                 </select>
                                 </div> -->
                              <div id="dp"></div>
                           </div>
                        </div>
                     </table>
                  </div>
               </div>
            </div>
         </div>
   </section>
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
      
      dp.eventDeleteHandling = "Update";
      dp.eventMoveHandling = "Disabled";
      dp.eventResizeHandling = "Disabled";
      
      dp.onEventDeleted = function(args) {
      
          $.confirm({
          theme: 'light',
          title: 'Alert!',content: 'Are you sure you want to Delete !',
          buttons: {
              confirm: function () {
                      $.post(baseurl + "employee/employees/rosterevent_delete/<?= $profile->uuid;?>",
                      {
                          id: args.e.id()
                      },
                      function() {
                          console.log("Deleted.");
                      });
              },
              cancel: function () {
                 // console.log("cancled.");
                  //return false;
                  return false;
      
              },
      
          }
      });
          
      };
      
      
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
          	//alert(baseurl);
              var data = dp.events.load(baseurl + "employee/employees/employeroster/<?= $profile->uuid;?>");
              console.log(data);
              dp.theme = "calendar_green";
              dp.update();
          }
      }
      
   </script>
   </div>
   <div class="clear">
   </div>
   </body>
</html>