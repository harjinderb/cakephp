<div class="caring-title">
        <h1>Caring Little Explorers !!</h1>

    </div>
    <div class="login-box-outer">
        <div class="login-box">
      <?= $this->Flash->render() ?>
          <div class="login-logo">
            <a href="index.php"><img src="/development/img/bso-logo.png" alt="BSO"></a>
          </div>
          <!-- /.login-logo -->
          <div class="login-box-body">
            <p class="login-box-msg">Sign in to start your session</p>

           <?= $this->Form->create("login",['type'=>'post','id'=>'sign_in']) ?>
              <div class="form-group has-feedback">
                <?= $this->Form->control('email',   ['label' => false, 'class' => 'form-control', 'placeholder' => 'Username']).'<span class="glyphicon glyphicon-envelope form-control-feedback"></span>'; ?>
                <!-- <input type="email" class="form-control" placeholder="Email">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span> -->
              </div>
              <div class="form-group has-feedback">
                <?= $this->Form->control('password',   ['label' => false, 'class' => 'form-control', 'placeholder' => 'Password']).'<span class="glyphicon glyphicon-lock form-control-feedback"></span>'; ?>
                <!-- <input type="password" class="form-control" placeholder="Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span> -->
              </div>
              <div class="row">
                <div class="col-xs-8">
                  <div class="checkbox icheck">
                    <label>
                      <input type="checkbox"> Remember Me
                    </label>
                  </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <?= $this->Form->button('Sign In',['class' => 'btn btn-theme btn-block btn-flat']);?>
                  <!-- <a href="change-password.php" class="btn btn-theme btn-block btn-flat">Sign In</a> -->
                </div>
                <?php   
                    $url = $this->request->getUri(); 
                  $lastWord = substr($url, strrpos($url, '/') + 1);
                  //pr($lastWord); die;
                  if($lastWord !== 'admin'){
                ?> 
              </div>
            <?php echo $this->Html->link('I forgot my password?',['prefix'=>false,'action' => 'forgot-password'],['escapeTitle' => false]); ?>

            <!-- <p class="mt_20 mt_0"><a href="#">I forgot my password</a></p> -->
            <?php  } ?>
            <?= $this->Form->end() ;?>
          </div>
          <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->
    </div>