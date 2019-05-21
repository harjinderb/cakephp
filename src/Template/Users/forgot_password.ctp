<div class="select-lang text-right">
   <?php
      $language = array('nl_NL'=>__('Dutch'),'en_US'=>__('English'));
  ?>
                <?php echo $this->Form->create('',['class'=>'form-inline','type'=>'GET']); 
                $lang = '';
                  $session = $this->request->session();
                        $lang = $this->request->getSession()->read('Guest.language');
                ?>
                    
                     <div class="form-group">
                      
                            <label class="mr_20"><?=__('Select your Language')?>*</label>
                        
                        
                            <?=$this->Form->select('language',$language,['label' => false, 'class' => 'language form-control show-tick', 'id' => 'langppk', 'value' => $lang]);?>
                      
              
                      </div>
    <?php echo $this->Form->end(); ?>
</div>
<div class="caring-title">
        <h1><?=__('Caring Little Explorers !!')?></h1>
    </div>
    <div class="login-box-outer">
        <div class="login-box">

          <div class="login-logo">
            <a href="index.php"><img src="/kindplanner_dta/img/bso-logo.png" alt="BSO"></a>
          </div>
          <!-- /.login-logo -->
          <div class="login-box-body">
            <p class="login-box-msg"><?=__('Forgot Your Password ?')?></p>

           <?= $this->Form->create("forgot_password",['type'=>'post','id'=>'forgotPassword']) ?>
              <div class="form-group has-feedback">
                <?= $this->Form->control('email',   ['label' => false, 'class' => 'form-control', 'placeholder' => 'Email']).'<span class="glyphicon glyphicon-envelope form-control-feedback"></span>'; ?>
              </div>
              <div class="row">
                <div class="col-xs-8">
                  <?php echo $this->Html->link(__('Back to login'),['prefix'=>false,'action' => 'login'],['escapeTitle' => false]); ?>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                   <?= $this->Form->button(__('Submit'),['class' => 'btn btn-theme btn-block btn-flat']);?>
                  <!-- <a href="change-password.php" class="btn btn-theme btn-block btn-flat">Sign In</a> -->
                </div>
                
              </div>
              
            <?= $this->Form->end() ;?>
          </div>
          <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->
    </div>