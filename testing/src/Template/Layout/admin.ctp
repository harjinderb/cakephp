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
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>BSO </title>
        <?= $this->Html->meta('icon') ?>
        <?= $this->fetch('meta') ?>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        
        <!-- Favicon-->
        <link rel="icon" href="favicon.ico" type="image/x-icon">
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
        <!-- Bootstrap Core Css -->
           <?= $this->Html->css('jquery-ui.css') ?>
           <?php // $this->Html->css('kendo.material.mobile.min.css') ?>
           <?php // $this->Html->css('kendo.common-material.min.css') ?>
           
         <script>
        var baseurl ="<?php  echo BASE_URL; ?>";
        </script>
        <script type="text/javascript" src="http://3.80.40.31/development/webroot/bolder-buren-v2/bower_components/bootstrap-daterangepicker/daterangepicker.css"></script>
        <script type="text/javascript" src="http://3.80.40.31/development/webroot/bolder-buren-v2/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css"></script>
        <?= $this->Html->css('/plugins/bootstrap/css/bootstrap.css'); ?>
        <!-- Bootstrap Select Css -->
        <?= $this->Html->css('/plugins/bootstrap-select/css/bootstrap-select.css') ?>
        <!-- Waves Effect Css -->
        <?= $this->Html->css('/plugins/node-waves/waves.css') ?>
        <!-- Animation Css -->
        <?= $this->Html->css('/plugins/animate-css/animate.css') ?>
        <?= $this->Html->css('/plugins/morris.js/morris.css') ?>
        <?= $this->Html->css('/plugins/fullcalendar/dist/fullcalendar.min.css') ?>
        <?= $this->Html->css('/plugins/fullcalendar/dist/fullcalendar.print.min.css') ?>
        <!-- Sweetalert Css -->
        <?= $this->Html->css('/plugins/sweetalert/sweetalert.css') ?>
        <?= $this->Html->css('/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') ?>

        <!-- Custom Css -->
        <?= $this->Html->css('fonts/css/font-awesome.css') ?>
        <?= $this->Html->css('style.css') ?>
        <?= $this->Html->css('custom.css') ?>
        <?= $this->Html->css('jquery-confirm.min.css') ?>
        <?= $this->fetch('css') ?>
        <?= $this->fetch('script') ?>
    </head>
   
  <?php   
    $url = $this->request->getUri(); 
    $lastWord = substr($url, strrpos($url, '/') + 1);
    $people = array("users", "employees", "parents","invoice","planning", "manage-services","calendar-settings","invoices");

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
    
    <body class="bso-theme">
        <!-- Page Loader -->
        <div class="page-loader-wrapper">
            <div class="loader">
                <div class="preloader">
                    <div class="spinner-layer pl-red">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
                <p>Please wait...</p>
            </div>
        </div>
        <!-- #END# Page Loader -->
        <!-- Overlay For Sidebars -->
        <div class="overlay"></div>
        <!-- #END# Overlay For Sidebars -->
        <!-- Top Bar -->
        <nav class="navbar">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                    <a href="javascript:void(0);" class="bars"></a>
                    <?php
                        echo $this->Html->link('<span class="logo-icon">'.$this->Html->image('bso-icon.png', ['class' => '']).'</span>',['controller' => 'users', 'action' => 'index', 'prefix' => false],['class'=>'navbar-brand','escape' => false]);
                    ?>
                </div>
                <div class="collapse navbar-collapse" id="navbar-collapse">
                    <!--<div class="search-bar-cs">
                        <form action="" method="" id="SearchBar">
                            <input type="text" class="form-control" placeholder="Search">
                            <button type="submit" class="search-icon-fixd"><i class="fa fa-search"> </i></button>
                            
                        </form>
                    </div>-->
                    <?php
                        $dataid=$this->request->getSession()->read('Auth.User.id');
                        $uuid=$this->request->getSession()->read('Auth.User.uuid');
                        $encryptionkey=$this->request->getSession()->read('Auth.User.encryptionkey');
                        $dataimage=$this->request->getSession()->read('Auth.User.image');
                        $name = $this->Decryption->mc_decrypt($this->request->getSession()->read('Auth.User.firstname'),$encryptionkey).' '.$this->Decryption->mc_decrypt($this->request->getSession()->read('Auth.User.lastname'),$encryptionkey);
                    ?>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="pull-right dropdown p-b-10">
                            <a href="javascript:void(0);" class="dropdown-toggle user-pic-small" data-toggle="dropdown">
                                <?= $this->Html->image(($dataimage!='') ? USER_PICTURE_FOLDER_URL_PATH.$uuid.'/'.$dataimage: 'blank-avatar.png', ['alt' => $name,'class' => 'user-img img-circle']) ?>
                                <?= $name ?>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <?php
                                        if(!empty($dataimage)){
                                            echo $this->Html->link($this->Html->image(USER_PICTURE_FOLDER_URL_PATH.$uuid.'/'.$dataimage, ['alt' => 'user','class' => 'user-img img-circle']),['controller' => 'users', 'action' => 'profile', 'prefix' => false, $uuid],['escapeTitle' => false,]);
                                        }else{
                                            echo $this->Html->link($this->Html->image('blank-avatar.png', ['alt' => 'user','class' => 'user-img img-circle']),['controller' => 'users', 'action' => 'profile', 'prefix' => false, $uuid],['escapeTitle' => false,]);
                                        }
                                    ?>
                                    <h4><?=$name?></h4>
                                    <!-- <p>Member since Feb. 2018</p> -->
                                </li>
                                <!-- Menu Body -->
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <?php echo $this->Html->link('My Profile',['controller' => 'users', 'action' => 'profile', 'prefix' => false, $uuid],['escapeTitle' => false,'class'=>'btn bg-blue-grey btn-lg']);
                                        ?>
                                    </div>
                                    <div class="pull-right">
                                        <?php echo $this->Html->link('Sign Out',['controller' => 'users', 'action' => 'logout', 'prefix' => false],['class'=>'btn bg-blue-grey btn-lg','escape' => false]);
                                        ?>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- #Top Bar -->
        <section>
            <!-- Left Sidebar -->
            <aside id="leftsidebar" class="sidebar">
                <!-- Menu -->
                <div class="menu">
                    <ul class="list">
                        <li class="header">MAIN NAVIGATION</li>
                        <li class="<?php if($lastWord == 'users'){echo "active" ;} ?>">
                            <?php echo $this->Html->link('<i class="fa fa-home nav-ico"> </i><span>Dashboard</span></i>',
                            ['controller' => 'users', 'action' => 'index','prefix'=>false],['escape' => false,'class'=>'']); ?>
                        </li>
                        <li class="header"><i class="fa fa-cogs nav-ico"> </i> Manage Users</li>
                        <li class="<?php if($lastWord == 'employees'){echo "active" ;}?>">
                            <?php echo $this->Html->link('Employee',
                            ['controller' => 'Employees', 'action' => 'employees','prefix'=>'employee'],['escape' => false,'class'=>'']); ?>
                        </li>
                        <li class="<?php if($lastWord == 'parents'){echo "active" ;} ?>">
                            <?php echo $this->Html->link('Parent',
                            ['controller' => 'users', 'action' => 'parents','prefix'=>false],['escape' => false,'class'=>'']); ?>
                        </li>
                        <li class="<?php if($lastWord == 'planning'){echo "active" ;} ?>">
                            <?php echo $this->Html->link('Planning',
                            ['controller' => 'Employees', 'action' => 'planning','prefix'=>'employee'],['escape' => false,'class'=>'']); ?>
                        </li>
                        <li class="<?php if($lastWord == 'invoices'){echo "active" ;} ?>">
                            <?php echo $this->Html->link('Invoice',
                            ['controller' => 'users', 'action' => 'invoices','prefix'=>false],['escape' => false,'class'=>'']); ?>
                        </li>
                        <li class="treeview">
                          <a href="#">
                            <i class="fa fa-cog"></i>
                            <span>Settings</span>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                          </a>
                          <ul class="treeview-menu">
                            <?php 
                           // echo $lastWord; die;
                            ?>
                            <li class="<?php if($lastWord == 'calendar-settings'){echo "active" ;} ?>">
                                <?php echo $this->Html->link('<i class="fa fa-circle-o"> </i><span>Calendar Setting</span></i>',
                                ['controller' => 'users', 'action' => 'calendarSettings','prefix'=>false],['escape' => false,'class'=>'']); ?>
                            </li>
                            <li class="<?php if($lastWord == 'invoice-settings'){echo "active" ;}?>">
                                <?php echo $this->Html->link('<i class="fa fa-circle-o"> </i><span>Invoice Setting</span></i>',
                                ['controller' => 'users', 'action' => 'invoiceSettings','prefix'=>false],['escape' => false,'class'=>'']); ?>
                            </li>
                            <!-- <li><a href="invoice-setting.php"><i class="fa fa-circle-o"></i>Invoice Setting</a></li> -->
                            <li><a href="#"><i class="fa fa-circle-o"></i> Plan Setting</a></li>
                            <li><a href="#"><i class="fa fa-circle-o"></i>Attendance setting</a></li>
                            <li><a href="#"><i class="fa fa-circle-o"></i> Overtime Cost</a></li>
                            <li><a href="#"><i class="fa fa-circle-o"></i> Services Setting</a></li>
                          </ul>
                        </li>
                        <li class="<?php if($lastWord == 'manage-services'){echo "active" ;} ?>">
                            <?php echo $this->Html->link('<i class="fa fa-cog nav-ico"> </i><span>Manage Services</span></i>',
                            ['controller' => 'users', 'action' => 'manageServices','prefix'=>false],['escape' => false,'class'=>'']); ?>
                        </li>
                        
                    </ul>
                </div>
                <!-- #Menu -->
            </aside>
            <!-- #END# Left Sidebar -->
        </section>
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
        <!-- Footer -->
        <div class="legal">
            <div class="copyright">
                Copyright &copy; 2017 - 2018
            </div>
        </div>
        <footer>
            <!-- Jquery Core Js -->
            <!-- Plugins js -->

                        <script type="text/javascript" src="http://3.80.40.31/development/webroot/bolder-buren-v2/bower_components/jquery/dist/jquery.min.js"></script>
                        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
  crossorigin="anonymous"></script>
                       <!--  <script type="text/javascript" src="http://3.80.40.31/development/webroot/bolder-buren-v2/bower_components/jquery-ui/jquery-ui.min.js"></script> -->
            <script type="text/javascript" src="http://3.80.40.31/development/webroot/bolder-buren-v2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
            <script src="/kindplanner_dta/testing/plugins/moment/moment.js"></script>            <script src="/kindplanner_dta/testing/plugins/fullcalendar/dist/fullcalendar.min.js"></script>    
            <script type="text/javascript" src="http://3.80.40.31/development/webroot/bolder-buren-v2/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
            <script type="text/javascript" src="http://3.80.40.31/development/webroot/bolder-buren-v2/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
            <script type="text/javascript" src="http://3.80.40.31/development/webroot/bolder-buren-v2/dist/js/bootstrap-datetimepicker.js"></script>
            <?php // $this->Html->script('/plugins/jquery/jquery.min.js') ?>
            <?php // $this->Html->script('jquery-ui.js') ?>
            <?= $this->Html->script('jquery-confirm.min.js') ?>
            <?= $this->Html->script('jquery.mask.min.js') ?>
            <?= $this->Html->script('multiselect.min.js') ?>
            <?= $this->Html->script('multiselect.js') ?>
            
            <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.0/jquery.validate.min.js"></script>
            <?php //$this->Html->script('/plugins/bootstrap/js/bootstrap.js') ?>
            <?= $this->Html->script('pages/forms/basic-form-elements.js') ?>
            <?= $this->Html->script('/plugins/node-waves/waves.js') ?>
            <!-- Custom js -->
            <?= $this->Html->script('admin.js') ?>
            <?= $this->Html->script('custom.js') ?>
            <?php // $this->Html->script('setting.js') ?>
            <?php // $this->Html->script('kendo.all.min.js') ?>
             
        <!--     <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 -->            <!-- Bootstrap Material Datetime Picker Plugin Js -->
            <?= $this->Html->script('/plugins/autosize/autosize.js') ?>
            <?php //$this->Html->script('/plugins/momentjs/moment.js') ?>
            <?= $this->Html->script('/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') ?>
        </footer>
        <script>
        $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
        });
        </script>
         <script type="text/javascript">
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
    });
     $('#datepickerEnd').datepicker({
      autoclose: true
    });
     $('#datepickerEdit').datepicker({
      autoclose: true
    });
     $('#datepickerEditNew').datepicker({
      autoclose: true
    });
    
  });
  </script>

    </body>
</html>