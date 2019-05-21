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
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?=__('Bolder Buren')?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <?= $this->Html->css('/bower_components/bootstrap/dist/css/bootstrap.min.css')?>
  <!-- Font Awesome -->
  <?= $this->Html->css('/bower_components/font-awesome/css/font-awesome.min.css')?>
  <!-- Theme style -->
  <?= $this->Html->css('/dist/css/AdminLTE.min.css'); ?>
  <?= $this->Html->css('/plugins/iCheck/square/blue.css') ?>
  <?= $this->Html->css('/dist/css/custom.css'); ?>
  <?php //$this->Html->css('style.css') ?>
        
        </head>
        <body class="blue-theme login-page register-page">
        <?= $this->Flash->render() ?>
         <?= $this->fetch('content') ?>
        
        
    </body>
</html>
 <?= $this->Html->script('/bower_components/jquery/dist/jquery.min.js') ?>
 <?= $this->Html->script('/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') ?>
 <?= $this->Html->script('/bower_components/bootstrap/dist/js/bootstrap.min.js') ?>
 <?= $this->Html->script('/plugins/iCheck/icheck.min.js') ?>
 <?= $this->Html->script('custom.js') ?>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>