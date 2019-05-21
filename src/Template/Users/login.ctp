<div class="select-lang text-right">
   <?php
      $language = array('nl_NL'=>__('Dutch'),'en_US'=>__('English'));
  ?>
                <?php echo $this->Form->create('',['class'=>'form-inline','type'=>'GET']); 
                  //$lang = 'nl_NL';
                  $session = $this->request->session();
                         $lang = $this->request->getSession()->read('Guest.language');
                        //die;
                ?>
                    
                     <div class="form-group">
                      
                           <!--   --><!-- <label class="mr_20"><?php //__('Select your Language')?>*</label> -->
                        
                        
                            <?=$this->Form->select('language',$language,['empty'=>__('Select your Language'),'label' => false, 'class' => 'language form-control show-tick', 'id' => 'langppk', 'value' => $lang]);?>
                      
              
                      </div>
    <?php echo $this->Form->end(); ?>
</div>

<div class="caring-title">
 
        <h1><?=__('Caring Little Explorers !!')?></h1>

    </div>
    <div class="login-box-outer">
        <div class="login-box">
      <?= $this->Flash->render() ?>
          <div class="login-logo">
            <a href="index.php"><img src="<?= BASE_URL.'img/bso-logo.png'?>" alt="BSO"></a>
          </div>
          <!-- /.login-logo -->
          <div class="login-box-body">
            <p class="login-box-msg"><?=__('Sign in to start your session')?></p>
            <?php
                 if($emailcookie != null){
                  $email = $emailcookie;
                  $password = $passwordcookie;
                 }else{
                    $email = '';
                    $password = '';
                 }
            ?>
           <?= $this->Form->create("login",['type'=>'post','id'=>'sign_in']) ?>
              <div class="form-group has-feedback">
                <?= $this->Form->control('email',   ['label' => false, 'class' => 'form-control', 'placeholder' => 'Username','value' => $email]).'<span class="glyphicon glyphicon-envelope form-control-feedback"></span>'; ?>
                <!-- <input type="email" class="form-control" placeholder="Email">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span> -->
              </div>
              <div class="form-group has-feedback">
                <?= $this->Form->control('password',   ['label' => false, 'class' => 'form-control', 'placeholder' => 'Password','value' => $password]).'<span class="glyphicon glyphicon-lock form-control-feedback"></span>'; ?>
                <!-- <input type="password" class="form-control" placeholder="Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span> -->
              </div>
              <div class="row">
                <div class="col-xs-8">
                  <div class="checkbox icheck">
                    <label>
                      <input type="checkbox" name="remember" value='1' <?php if($emailcookie != null){ echo "checked";}?>><?= __('Remember Me')?>
                    </label>
                  </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <?= $this->Form->button(__('Sign In'),['class' => 'btn btn-theme btn-block btn-flat']);?>
                  <!-- <a href="change-password.php" class="btn btn-theme btn-block btn-flat">Sign In</a> -->
                </div>
                <?php   
                    $url = $this->request->getUri(); 
                  $lastWord = substr($url, strrpos($url, '/') + 1);
                  //pr($lastWord); die;
                  if($lastWord !== 'admin'){
                ?> 
              </div>
            <?php echo $this->Html->link(__('I forgot my password?'),['prefix'=>false,'action' => 'forgot-password'],['escapeTitle' => false]); ?>

            <!-- <p class="mt_20 mt_0"><a href="#">I forgot my password</a></p> -->
            <?php  } ?>
            <?= $this->Form->end() ;?>
          </div>
          <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->
    </div>

    