<?php
   /**
   * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
   * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
   *
   * Licensed under The MIT License
   * For full copyright and license information, please see the LICENSE.txt
   * Redistributions of files must retain the above copyright notice.
   *
   * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
   * @link          https://cakephp.org CakePHP(tm) Project
   * @since         0.10.0
   * @license       https://opensource.org/licenses/mit-license.php MIT License
   */
   use Cake\ORM\TableRegistry;
   $cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
   <head>
      <?= $this->Html->charset() ?>
      <title><?=__('BSO')?></title>
      <?= $this->Html->meta('icon') ?>
      <?= $this->fetch('meta') ?>
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <!-- Bootstrap 3.3.7 -->
      <?= $this->Html->css('/bower_components/bootstrap/dist/css/bootstrap.min.css'); ?>
      <!-- Font Awesome -->
      <?= $this->Html->css('/bower_components/font-awesome/css/font-awesome.min.css'); ?>
      <!-- Ionicons -->
      <?= $this->Html->css('/bower_components/Ionicons/css/ionicons.min.css'); ?>
      <?= $this->Html->css('/dist/css/AdminLTE.min.css'); ?>
      <?= $this->Html->css('/dist/css/AdminLTE.min.css'); ?>
      <?= $this->Html->css('/bower_components/morris.js/morris.css'); ?>
      <?= $this->Html->css('/bower_components/jvectormap/jquery-jvectormap.css'); ?>
      <?= $this->Html->css('/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css'); ?>
      <?= $this->Html->css('/bower_components/bootstrap-daterangepicker/daterangepicker.css'); ?>  
      <?php // $this->Html->css('/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css'); ?>
      <?= $this->Html->css('/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css'); ?>
      
      <?= $this->Html->css('/dist/css/multi-select.css'); ?>
      <?= $this->Html->css('/dist/css/bootstrap-material-datetimepicker.css'); ?>
      
      <?php //echo $this->Html->css('custom.css');?>
      <?= $this->Html->css('jquery-confirm.min.css') ?>
      <?= $this->Html->css('jquery-ui.css') ?>

      <?= $this->Html->css('/bower_components/fullcalendar/dist/fullcalendar.min.css'); ?>
     
       <?= $this->Html->css('/dist/css/custom.css'); ?>
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
   </head>
   <script>
      var baseurl ="<?php  echo BASE_URL; ?>";
   </script>
   <?php   
      $lastWord = $this->request->action;
      $people = array("users", "manageChildren", "manageGuardian","buyServices","myinvoices","mypreviousServices","myServices");
      
      if (in_array($lastWord, $people))
      {
          $lastWord = $lastWord;
      
      }
      else
      {
      
          $getresponse = $this->Hylitersidebar->hylitersidebarfunction($lastWord);
          $lastWord = $getresponse ;
      }
      ?> 
   <body class="hold-transition blue-theme sidebar-mini">
      <?php
         $dataid=$this->request->getSession()->read('Auth.User.id');
         $uuid=$this->request->getSession()->read('Auth.User.uuid');
         $encryptionkey=$this->request->getSession()->read('Auth.User.encryptionkey');
         $created =$this->request->getSession()->read('Auth.User.created');
         $dataimage=$this->request->getSession()->read('Auth.User.image');
         $name = $this->Decryption->mc_decrypt($this->request->getSession()->read('Auth.User.firstname'),$encryptionkey).' '.$this->Decryption->mc_decrypt($this->request->getSession()->read('Auth.User.lastname'),$encryptionkey);
         ?> 
      <div class="wrapper">
         <header class="main-header">
            <a href="<?= BASE_URL.'users/index'?>" class="logo theme-bg">
               <!-- mini logo for sidebar mini 50x50 pixels -->
               <span class="logo-mini"><img src="<?= BASE_URL.'img/bso-icon.png'?>" class="" alt=""></span>
               <!-- logo for regular state and mobile devices -->
               <span class="logo-lg"><img src="<?= BASE_URL.'img/bso-logo.png'?>" class="" alt=""></span>
            </a>
           
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
               <!-- Sidebar toggle button-->
               <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
               <span class="sr-only"><?=__('Toggle navigation')?></span>
               </a>
               <div class="navbar-custom-menu">
                  <ul class="nav navbar-nav">
                     <!-- Notifications: style can be found in dropdown.less -->
                     <li class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-warning">10</span>
                        </a>
                        <ul class="dropdown-menu">
                           <li class="header">You have 10 notifications</li>
                           <li>
                              <!-- inner menu: contains the actual data -->
                              <ul class="menu">
                                 <li>
                                    <a href="#">
                                    <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                    </a>
                                 </li>
                                 <li>
                                    <a href="#">
                                    <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                                    page and may cause design problems
                                    </a>
                                 </li>
                                 <li>
                                    <a href="#">
                                    <i class="fa fa-users text-red"></i> 5 new members joined
                                    </a>
                                 </li>
                                 <li>
                                    <a href="#">
                                    <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                                    </a>
                                 </li>
                                 <li>
                                    <a href="#">
                                    <i class="fa fa-user text-red"></i> You changed your username
                                    </a>
                                 </li>
                              </ul>
                           </li>
                           <li class="footer"><a href="#">View all</a></li>
                        </ul>
                     </li>
                     <!-- User Account: style can be found in dropdown.less -->
                     <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?= $this->Html->image(($dataimage!='') ? USER_PICTURE_FOLDER_URL_PATH.$uuid.'/'.$dataimage: '/dist/img/teacher.jpg', ['alt' => $name,'class' => 'user-image']) ?>
                        <span class="hidden-xs"><?= $name ?></span>
                        </a>
                        <ul class="dropdown-menu">
                           <!-- User image -->
                           <li class="user-header">
                              <?= $this->Html->image(($dataimage!='') ? USER_PICTURE_FOLDER_URL_PATH.$uuid.'/'.$dataimage: '/dist/img/teacher.jpg', ['alt' => $name,'class' => 'img-circle']) ?>
                              <p>
                                 <?= $name ?>  - <?= __('Parent')?>
                                 <small><?=__('Member since').' '.date('m-Y',strtotime($created)) ?></small>
                              </p>
                           </li>
                           <!-- Menu Body -->
                           <li class="user-body">
                              <div class="row">
                                 <div class="col-xs-4 text-center">
                                    <a href="#">Action1</a>
                                 </div>
                                 <div class="col-xs-4 text-center">
                                    <a href="#">Gallery</a>
                                 </div>
                                 <div class="col-xs-4 text-center">
                                    <a href="#">Action2</a>
                                 </div>
                              </div>
                              <!-- /.row -->
                           </li>
                           <!-- Menu Footer-->
                           <li class="user-footer">
                              <div class="pull-left">
                                 <?php echo $this->Html->link(__('Profile'),['controller' => 'users', 'action' => 'profileEdit', 'prefix' => 'parent', $uuid],['escapeTitle' => false,'class'=>'btn btn-default btn-flat']);
                                    ?>
                              </div>
                              <div class="pull-right">
                                 <?php echo $this->Html->link(__('Sign Out'),['controller' => 'users', 'action' => 'logout', 'prefix' => false],['class'=>'btn btn-default btn-flat','escape' => false]);
                                    ?>
                              </div>
                           </li>
                        </ul>
                     </li>
                     <li class="lang-select">
                        <?php
                        $language = array('nl_NL'=>__('NL'),'en_US'=>__('EN'));
                        ?>
                <?php echo $this->Form->create('',['class'=>'form-inline','type'=>'GET']); 
                        $session = $this->request->session();
                        $lang = $this->request->getSession()->read('Guest.language');
                ?>
                    
               <?=$this->Form->select('language',$language,['label' => false, 'class' => 'language form-control show-tick', 'id' => 'langppk', 'value' => $lang]);?>
                  <?php echo $this->Form->end(); ?>
                     </li>
                     <!-- Control Sidebar Toggle Button -->
                  </ul>
               </div>
            </nav>
         </header>
         <!-- Left side column. contains the logo and sidebar -->
         <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
               <!-- Sidebar user panel -->
               <div class="user-panel">
                  <div class="pull-left image">
                     <?= $this->Html->image(($dataimage!='') ? USER_PICTURE_FOLDER_URL_PATH.$uuid.'/'.$dataimage: '/dist/img/teacher.jpg', ['alt' => $name,'class' => 'img-circle']) ?>
                  </div>
                  <div class="pull-left info">
                     <p> <?= $name ?> </p>
                     <a href="#"><i class="fa fa-circle text-success"></i><?=('Online')?></a>
                  </div>
               </div>
               <!-- sidebar menu: : style can be found in sidebar.less -->
               <ul class="sidebar-menu" data-widget="tree">
                  <li class="header"><?=__('MAIN NAVIGATION')?></li>
                  <li class="<?php if($lastWord == 'users'){echo "active" ;}?>">
                     <?php 
                        echo $this->Html->link('<i class="fa fa-dashboard"></i><span>'.__('Dashboard').'</span>',
                        ['controller' => 'users', 'action' => 'index','prefix'=>'parent'],['escape' => false,'class'=>'pull-right-container'],'<span class="pull-right-container"></span>'); 
                        ?>
                  </li>
                  <li class="<?php if($lastWord == 'manageChildren'){echo "active" ;}?>">
                     <?php 
                        echo $this->Html->link('<i class="fa fa-dashboard"> </i><span>'.__('Manage Children').'</span>',
                        ['controller' => 'users', 'action' => 'manageChildren','prefix'=>'parent'],['escape' => false,'class'=>''],'<span class="pull-right-container"></span>'); 
                    ?>
                  </li>
                  <li class="<?php if($lastWord == 'manageGuardian'){echo "active" ;}?>">
                     <?php 
                        echo $this->Html->link('<i class="fa fa-dashboard"> </i><span>'.__('Manage Guardian').'</span>',
                        ['controller' => 'users', 'action' => 'manageGuardian','prefix'=>'parent'],['escape' => false,'class'=>'']); 
                        ?>
                  </li>
                  <li class="header"> <i class="fa fa-cogs"> </i><?=__('Services')?></li>
                  <li class="<?php if($lastWord == 'buyServices'){echo "active" ;}?>">
                     <?php 
                        echo $this->Html->link('<i class="fa fa-circle-o"></i>'.__('Buy Services'),
                        ['controller' => 'users', 'action' => 'buyServices','prefix'=>'parent'],['escape' => false,'class'=>'']); 
                        ?>
                  </li>
                  <li class="<?php if($lastWord == 'myServices'){echo "active" ;}?>">
                     <?php 
                        echo $this->Html->link('<i class="fa fa-circle-o"></i>'.__('My Services'),
                        ['controller' => 'users', 'action' => 'myServices',$uuid,'prefix'=>'parent'],['escape' => false,'class'=>'']); 
                        ?>
                  </li>
                  <li class="<?php if($lastWord == 'mypreviousServices'){echo "active" ;}?>">
                     <?php 
                        echo $this->Html->link('<i class="fa fa-circle-o"></i>'.__('My Previous Services'),
                        ['controller' => 'users', 'action' => 'mypreviousServices',$uuid,'prefix'=>'parent'],['escape' => false,'class'=>'']); 
                        ?>
                  </li>
                   <li class="<?php if($lastWord == 'manageChildren'){echo "active" ;}?>">
                     <?php 
                        echo $this->Html->link('<i class="fa fa-circle-o"></i>'.__('Attendance'),
                        ['controller' => 'users', 'action' => 'manageChildren','prefix'=>'parent'],['escape' => false,'class'=>'']); 
                        ?>
                  </li>
                  <li>
                     <?php 
                        // echo $this->Html->link('<i class="fa fa-circle-o"></i>Holidays',
                        // ['controller' => 'users', 'action' => 'myinvoices','prefix'=>'parent'],['escape' => false,'class'=>'']); 
                     ?>
                        
                  </li>
                  <li class="<?php if($lastWord == 'myinvoices'){echo "active" ;}?>">
                        <?php 
                        echo $this->Html->link('<i class="fa fa-dashboard"> </i>'.__('My Invoices'),
                        ['controller' => 'users', 'action' => 'myinvoices',$uuid,'prefix'=>'parent'],['escape' => false,'class'=>'']); 
                        ?>
                  </li>
               </ul>
            </section>
            <!-- /.sidebar -->
         </aside>
         <?= $this->Flash->render() ?>
         <?= $this->fetch('content') ?>
         <!-- /.content-wrapper -->
         <footer class="main-footer">
            <strong><?=__('Copyright &copy; 2018-2019')?><a href="javascript:void(0)"><?=__('Bolder Buren')?></a>.</strong> <?=__('All rights
            reserved')?>.
         </footer>
         <!-- Add the sidebar's background. This div must be placed
            immediately after the control sidebar -->
         <div class="control-sidebar-bg"></div>
      </div>
      <!-- ./wrapper -->
      <?php echo $this->Html->script('/bower_components/jquery/dist/jquery.min.js') ?>
      <!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="crossorigin="anonymous"></script> -->
      <?php echo $this->Html->script('/bower_components/jquery-ui/jquery-ui.min.js') ?>
      <?= $this->Html->script('/bower_components/bootstrap/dist/js/bootstrap.min.js') ?>
      <?= $this->Html->script('/bower_components/raphael/raphael.min.js') ?>
      <?= $this->Html->script('/bower_components/morris.js/morris.min.js') ?>
      <?= $this->Html->script('/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') ?>
      <?= $this->Html->script('/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') ?>
      <?= $this->Html->script('/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') ?>
      <?= $this->Html->script('/bower_components/jquery-knob/dist/jquery.knob.min.js') ?>
      <?= $this->Html->script('/bower_components/moment/min/moment.min.js') ?>
      <?= $this->Html->script('/bower_components/bootstrap-daterangepicker/daterangepicker.js') ?>
      <?= $this->Html->script('/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') ?>
      <?= $this->Html->script('jquery-confirm.min.js') ?>
      <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.0/jquery.validate.min.js"></script>
      <?php //$this->Html->script('/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') ?>
      <?= $this->Html->script('/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') ?>
      <?= $this->Html->script('/bower_components/fastclick/lib/fastclick.js') ?>
      <?= $this->Html->script('/dist/js/adminlte.min.js') ?>
      <?= $this->Html->script('/dist/js/pages/dashboard.js') ?>
      <?= $this->Html->script('/bower_components/datatables.net/js/jquery.dataTables.min.js') ?>
      <?= $this->Html->script('/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') ?>
      <?= $this->Html->script('/dist/js/demo.js') ?>
      <?= $this->Html->script('custom.js') ?>
      <?= $this->Html->script('datatable.js') ?>
      <?= $this->Html->script('/dist/js/jquery.multi-select.js') ?>
      <?= $this->Html->script('/dist/js/time-piker.js') ?>
      <?= $this->Html->script('/dist/js/bootstrap-datetimepicker.js') ?>

        <!-- ChartJS -->
       <?php //$this->Html->script('/bower_components/chart.js/Chart.js') ?>
        <!-- fullCalendar -->
        <?= $this->Html->script('/bower_components/moment/moment.js') ?>
        <?= $this->Html->script('/bower_components/fullcalendar/dist/fullcalendar.min.js') ?>
        <?= $this->Html->script('attendance.js') ?>
        <script>
         // For equil height of all Products
  
   
        ////
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
        // $(this).draggable({
        //   zIndex        : 1070,
        //   revert        : true, // will cause the event to go back to its
        //   revertDuration: 0  //  original position after the drag
        // })

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
        right : 'year,month,agendaWeek,agendaDay'
      },
      buttonText: {
        today: 'today',
        year: 'year',
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
           $('#example1').DataTable()
           $('#example2').DataTable({
             'paging'      : true,
             'lengthChange': false,
             'searching'   : false,
             'ordering'    : true,
             'info'        : true,
             'autoWidth'   : false
           })
         })
      </script>
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
            format: 'dd-mm-yyyy', 
             autoclose: true
           })
         $('#datepickerJoin').datepicker({
            format: 'dd-mm-yyyy',
             autoclose: true
           })
         $('.datepicker').datepicker({
            format: 'dd-mm-yyyy',
             autoclose: true
           })
         
         })
      </script>
      <script>
         function readURL(input) {
                   if (input.files && input.files[0]) {
                       var reader = new FileReader();
         
                       reader.onload = function (e) {
                           $('#UplodImg')
                               .attr('src', e.target.result)
                               .width(150)
                               .height(150);
                       };
         
                       reader.readAsDataURL(input.files[0]);
                   }
               }
      </script>
   </body>
</html>