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
$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
    <head>
        <?= $this->Html->charset() ?>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title>
        
        BSO
        </title>
        <!-- Favicon-->
        <link rel="icon" href="../../favicon.ico" type="image/x-icon">
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
        <!-- Bootstrap Core Css -->
        <?= $this->Html->css('/plugins/bootstrap/css/bootstrap.css') ?>
        <!-- Animation Css -->
        <?= $this->Html->css('/plugins/animate-css/animate.css') ?>
        <!-- Custom Css -->
        <?= $this->Html->css('style.css') ?>
        <?= $this->Html->css('custom.css') ?>
        <?= $this->Html->meta('icon') ?>
        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>
        <?= $this->fetch('script') ?>
    </head>
    <body class="login-page bg-theme">
        
        <?= $this->Flash->render() ?>
        
        <?= $this->fetch('content') ?>
        
        <footer>
            <!-- Jquery Core Js -->
            <?= $this->Html->script('/plugins/jquery/jquery.min.js') ?>
            <?= $this->Html->script('/plugins/bootstrap/js/bootstrap.js') ?>
            <!-- Waves Effect Plugin Js -->
            <?= $this->Html->script('/plugins/node-waves/waves.js') ?>
            <!-- Validation Plugin Js -->
            <?= $this->Html->script('/plugins/jquery-validation/jquery.validate.js') ?>
            <!-- Custom Js -->
            <?= $this->Html->script('admin.js') ?>
            <?= $this->Html->script('pages/examples/sign-in.js') ?>
            
        </footer>
    </body>
</html>