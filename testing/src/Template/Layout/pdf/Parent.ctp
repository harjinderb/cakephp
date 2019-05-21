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
         <script>
        var baseurl ="<?php  echo BASE_URL; ?>";
        </script>
        <?= $this->Html->css('jquery-ui.css', ['fullBase' => true]) ?>

        <?= $this->Html->css('/plugins/bootstrap/css/bootstrap.css', ['fullBase' => true]); ?>
        <!-- Bootstrap Select Css -->
        <?= $this->Html->css('/plugins/bootstrap-select/css/bootstrap-select.css', ['fullBase' => true]) ?>
        <!-- Waves Effect Css -->
        <?= $this->Html->css('/plugins/node-waves/waves.css', ['fullBase' => true]) ?>
        <!-- Animation Css -->
        <?= $this->Html->css('/plugins/animate-css/animate.css', ['fullBase' => true]) ?>
      
        <!-- Custom Css -->
       
        <?= $this->Html->css('style.css', ['fullBase' => true]) ?>
        <?= $this->Html->css('custom.css', ['fullBase' => true]) ?>
        <?= $this->Html->css('jquery-confirm.min.css', ['fullBase' => true]) ?>
        <?= $this->fetch('css') ?>
        <?= $this->fetch('script') ?>
    </head>

    <body class="bso-theme">
        <div class="overlay"></div>
        <?php
            $dataid=$this->request->getSession()->read('Auth.User.id');
            $uuid=$this->request->getSession()->read('Auth.User.uuid');
            $dataimage=$this->request->getSession()->read('Auth.User.image');
            $name = $this->request->getSession()->read('Auth.User.name');
        ?>   
        <?= $this->fetch('content') ?>
        <?= $this->Html->script('/plugins/jquery/jquery.min.js', ['fullBase' => true]) ?>
        <?= $this->Html->script('jquery-ui.js', ['fullBase' => true]) ?>
        <?= $this->Html->script('jquery.mask.min.js', ['fullBase' => true]) ?>
        <?= $this->Html->script('jquery-confirm.min.js', ['fullBase' => true]) ?>
        <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.0/jquery.validate.min.js"></script>
        <?= $this->Html->script('/plugins/bootstrap/js/bootstrap.js', ['fullBase' => true]) ?>
        <?= $this->Html->script('pages/forms/basic-form-elements.js', ['fullBase' => true]) ?>
        <?= $this->Html->script('/plugins/node-waves/waves.js', ['fullBase' => true]) ?>
        <!-- Custom js -->
        <?= $this->Html->script('admin.js', ['fullBase' => true]) ?>
        <?= $this->Html->script('custom.js', ['fullBase' => true]) ?>
        <!--     <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        -->            <!-- Bootstrap Material Datetime Picker Plugin Js -->
        <?= $this->Html->script('/plugins/autosize/autosize.js', ['fullBase' => true]) ?>
        <?= $this->Html->script('/plugins/momentjs/moment.js', ['fullBase' => true]) ?>
        <?= $this->Html->script('/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js', ['fullBase' => true]) ?>
    </body>
</html>