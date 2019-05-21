<div class="select-lang text-right">
   <?php
      $language = array('nl_NL'=>__('Dutch'),'en_US'=>__('English'));
  ?>
                <?php echo $this->Form->create('',['class'=>'form-inline','type'=>'file']); 
                  $lang = '';
                  $session = $this->request->session();
                        $lang = $this->request->getSession()->read('Guest.language');
                ?>
                    
                     <div class="form-group">
                      
                            <label class="mr_20"><?=__('Select your Language')?>*</label>
                        
                        
                            <?=$this->Form->select('language',$language,['empty'=>__('Please select language'),'label' => false, 'class' => 'language form-control show-tick', 'id' => 'langppk', 'value' => $lang]);?>
                      
              
                      </div>
    <?php echo $this->Form->end(); ?>
</div>
<div class="login-box-outer">
        <div class="login-box">
      <?= $this->Flash->render() ?>
          <div class="login-logo">
            <a href="index.php"><img src="<?= BASE_URL.'img/bso-logo.png'?>" alt="BSO"></a>
          </div>
          <!-- /.login-logo -->
          <div class="login-box-body">
            <p class="login-box-msg"><?=__('Reset Your Password')?></p>

           <?= $this->Form->create($user ,['class'=>'form-inline-cs']);?>
              <div class="form-group_">
							<label for="password"><?=__('New Password  *')?> </label>
							<?= $this->Form->control('password', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Password','value'=>'']);?>
							<i style="font-size:12px">(<?=__('Password must contain atleast one capital letter and alphanumeric characters.')?></i>
						</div>
              			<div class="form-group_">
							<label><?=__('Confirm Password  *')?></label>
							<?= $this->Form->control('confirm_password', ['type'=>'password','label' => false, 'class' => 'form-control', 'placeholder' => 'Confirm password']);?>
						</div>
             
<div class=" form-group text-right mt_30">
							<?= $this->Form->button(__('Reset Password'),['class' => ' btn btn-theme btn-block btn-flat']);
								echo $this->Form->end();
							?>
						</div>


          <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->
    </div>