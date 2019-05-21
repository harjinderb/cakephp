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
         <script>
        var baseurl ="<?php  echo BASE_URL; ?>";
        </script>

        <?= $this->Html->css('/plugins/bootstrap/css/bootstrap.css'); ?>
        <!-- Bootstrap Select Css -->
        <?= $this->Html->css('/plugins/bootstrap-select/css/bootstrap-select.css') ?>
        <!-- Waves Effect Css -->
        <?= $this->Html->css('/plugins/node-waves/waves.css') ?>
        <!-- Animation Css -->
        <?= $this->Html->css('/plugins/animate-css/animate.css') ?>
        <!-- Sweetalert Css -->
        <?= $this->Html->css('/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') ?>
        <!-- Custom Css -->
        <?= $this->Html->css('fonts/css/font-awesome.css') ?>
        <?= $this->Html->css('/bower_components/select2/dist/css/select2.min.css') ?>

        <?= $this->Html->css('custom.css') ?>
        <?= $this->Html->css('jquery-confirm.min.css') ?>
        <?= $this->fetch('css') ?>
        <?= $this->fetch('script') ?>
    </head>
    <?php   
    $url = $this->request->getUri(); 
    $lastWord = substr($url, strrpos($url, '/') + 1);
    $people = array("users", "manage-children", "manage-guardian", "buy-services","my-services");
    if (in_array($lastWord , $people))
    {
        $lastWord = $lastWord;
    }
    else
    {
            //pr($lastWord); die;
     $getresponse = $this->Parentside->parentsidefunction($lastWord);
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
       <body class="hold-transition blue-theme">
<div class="wrapper">
    <div class="container">
        <header class="buy-header">
            <div class="back-to-home">
                <!-- <a href="dashboard.php"> Back to Home page </a> -->
                <?php 
                /*echo $this->Html->link(
                        __('Back to Home page'),
                        ['controller' => 'users', 'action' => 'buyServices', 'prefix' => 'parent']
                        );*/ 
                ?>
            </div>
            <!-- Logo -->
            <div class="text-center">
                <a href="index.php" class="logo">
                    <span class="logo-lg"><b>Bolder</b> Buren</span>
                </a>
            </div>
            
            
        </header>


        
                    <?php
                        $dataid=$this->request->getSession()->read('Auth.User.id');
                        $uuid=$this->request->getSession()->read('Auth.User.uuid');
                        $dataimage=$this->request->getSession()->read('Auth.User.image');
                        $encryptionkey=$this->request->getSession()->read('Auth.User.encryptionkey');
                       // $dataimage=$this->request->getSession()->read('Auth.User.image');
                        $name = $this->Decryption->mc_decrypt($this->request->getSession()->read('Auth.User.firstname'),$encryptionkey).' '.$this->Decryption->mc_decrypt($this->request->getSession()->read('Auth.User.lastname'),$encryptionkey);
                    ?>
                  

        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
        <!-- Footer -->
        <div class="legal">
            <div class="copyright">
                Copyright &copy; 2017 - 2018
            </div>
        </div>
        <footer>
            <?= $this->Html->script('/plugins/jquery/jquery.min.js') ?>
            <?= $this->Html->script('jquery-ui.js') ?>
            <?= $this->Html->script('jquery.mask.min.js') ?>
            <?= $this->Html->script('jquery-confirm.min.js') ?>
            <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.0/jquery.validate.min.js"></script>
            <script type="text/javascript" src="http://3.80.40.31/development/webroot/bolder-buren-v2/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
            <script type="text/javascript" src="http://3.80.40.31/development/webroot/bolder-buren-v2/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
            <script type="text/javascript" src="http://3.80.40.31/development/webroot/bolder-buren-v2/dist/js/bootstrap-datetimepicker.js"></script>
            <?= $this->Html->script('/plugins/bootstrap/js/bootstrap.js') ?>
            <?= $this->Html->script('pages/forms/basic-form-elements.js') ?>
            <?= $this->Html->script('/plugins/node-waves/waves.js') ?>
            <!-- Custom js -->
            <?= $this->Html->script('admin.js') ?>
            <?= $this->Html->script('custom.js') ?>
             <?= $this->Html->script('joiningdate.js') ?>
             <?= $this->Html->script('/bower_components/select2/dist/js/select2.full.min.js') ?>
            
                <!-- Bootstrap Material Datetime Picker Plugin Js -->
            <?= $this->Html->script('/plugins/autosize/autosize.js') ?>
            <?= $this->Html->script('/plugins/momentjs/moment.js') ?>
            <?= $this->Html->script('/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') ?>
        </footer>
        <script>
        $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
        });
        </script>
         <script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
    
  })
</script>
    </body>
</html>