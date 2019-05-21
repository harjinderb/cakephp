<?php $cakeDescription = 'CakePHP: the rapid development php framework'; ?>
<!DOCTYPE html>
<html>
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <title> Super Admin | Kindplanner </title>
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
        <!--       <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        --><script>
        var baseurl ="<?php  echo BASE_URL; ?>";
        </script>
        <?= $this->Html->css('/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') ?>
        <?= $this->Html->css('/plugins/bootstrap/css/bootstrap.css') ?>
        <!-- Bootstrap Select Css -->
        <?= $this->Html->css('/plugins/bootstrap-select/css/bootstrap-select.css') ?>
        <!-- Waves Effect Css -->
       
        <?= $this->Html->css('/plugins/animate-css/animate.css') ?>
        <!-- Sweetalert Css -->
        
        <!-- Custom Css -->
        <?= $this->Html->css('fonts/css/font-awesome.css') ?>
        <?= $this->Html->css('style.css') ?>
        <?php // $this->Html->css('Admin/themes/theme-deep-purple.css') ?>
        <?= $this->Html->css('custom.css') ?>
        <?= $this->Html->css('jquery-confirm.min.css') ?>
        <?= $this->fetch('css') ?>
        <?= $this->fetch('script') ?>
    </head>
    <?php   
    $url = $this->request->getUri(); 
   // $data = explode('/', $url)[4];
   // pr($data);die;

  $lastWord = substr($url, strrpos($url, '/') + 1);
//echo $lastWord ;
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
        <?= $this->element('nav') ?>
        <!-- #Top Bar -->
        
        <!---ul class="title-area large-3 medium-4 columns">
        <li class="name">
            <h1><a href=""><?php // $this->fetch('title') ?></a></h1>
        </li>
    </ul--->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">MAIN NAVIGATION</li>users

                    <li class="<?php if($lastWord == 'dashboard'){echo "active" ;} ?>">
                        <?php echo $this->Html->link('<i class="fa fa-home nav-ico"> </i><span>Dashboard</span>',['controller' => 'users','action' => 'dashboard', 'prefix' => 'admin'],['id'=>'admindashboard','escape' => false]); ?>
                    </li>
                    <li class="<?php if (strpos($url, "users")!== false){echo "active" ;} if (strpos($url, "dashboard")!== false){echo "inactive" ;}?>">
                        <?php echo $this->Html->link(' <i class="fa fa-cog nav-ico"> </i><span>Manage BSO</span>',['controller' => 'users', 'action' => 'index'],
                        ['escape' => false,'class'=>'']); ?>
                    </li>
                    <li class="<?php // if($lastWord == 'AclManager'){echo "active" ;} ?>">
                        <?php //echo $this->Html->link('<i class="fa fa-cogs nav-ico"> </i><span>Manage ACL</span></i>',
                        //'/admin/AclManager',['escape' => false,'class'=>'']); ?>
                    </li>
                    
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    Copyright &copy; 2017 - 2018.
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
    </section>
    
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
    
    <footer>
        <!-- Plugins js -->
        <?= $this->Html->script('/plugins/jquery/jquery.min.js') ?>
        <?= $this->Html->script('jquery-ui.js') ?>

        <?= $this->Html->script('jquery-confirm.min.js') ?>
        <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.0/jquery.validate.min.js"></script>
        <?= $this->Html->script('jquery.mask.min.js') ?>
        <?= $this->Html->script('/plugins/bootstrap/js/bootstrap.js') ?>
        <?= $this->Html->script('pages/forms/basic-form-elements.js') ?>
        <?= $this->Html->script('/plugins/node-waves/waves.js') ?>
        <!-- Custom js -->
        <?= $this->Html->script('custom.js') ?>
        <?= $this->Html->script('admin.js') ?>
        
<!--         <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.0/jquery.validate.min.js"></script>
 -->        <!-- Bootstrap Material Datetime Picker Plugin Js -->
        <?= $this->Html->script('/plugins/autosize/autosize.js') ?>
        <?= $this->Html->script('/plugins/momentjs/moment.js') ?>
        <?= $this->Html->script('/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') ?>
    </footer>
</body>
</html>