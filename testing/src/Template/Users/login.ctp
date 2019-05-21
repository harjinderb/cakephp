<div class="login-box">
    <div class="logo text-center">
        <a href="javascript:void(0);"><!--span><img src="images/b_icon.png" alt="BSO"--></span> BSO</a>
        
    </div>
    <div class="card">
        <div class="body">
            <?= $this->Form->create("login",['type'=>'post','id'=>'sign_in']) ?>
            <div class="msg">Sign in to start your session</div>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">person</i>
                </span>
                <div class="form-line">
                    <?= $this->Form->control('email',   ['label' => false, 'class' => 'form-control', 'placeholder' => 'Username']); ?>
                    <!-- <input type="text" class="form-control" name="username" placeholder="Username" required autofocus> -->
                </div>
            </div>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">lock</i>
                </span>
                <div class="form-line">
                    <?= $this->Form->control('password',   ['label' => false, 'class' => 'form-control', 'placeholder' => 'Password']); ?>
                    
                </div>
            </div>
            <div class="row">
                <div class="col-xs-8 p-t-5">
                    <?= $this->Form->control('rememberme',   ['type'=>'checkbox','checked'=>true,'label' => false, 'class' => 'filled-in chk-col-pink','hiddenField'=>false]); ?>
                    
                    <label for="rememberme">Remember Me</label>
                </div>
                <div class="col-xs-4">
                    <?= $this->Form->button('SIGN IN',['class' => 'btn btn-block bg-blue-grey  waves-effect']);?>
                    <!-- <a href="users" class="btn btn-block bg-indigo  waves-effect" type="submit">SIGN IN</a> -->
                </div>
            </div>
            <div class="row m-t-15 m-b--20">
               
                 <?php   
                    $url = $this->request->getUri(); 
                  $lastWord = substr($url, strrpos($url, '/') + 1);
                  //pr($lastWord); die;
                  if($lastWord !== 'admin'){
                ?> 

                <div class="col-xs-6">
                    <?php echo $this->Html->link('Forgot Password?',['prefix'=>false,'action' => 'forgot-password'],['escapeTitle' => false]); ?>
                </div>
            <?php  } ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>