<div class="login-box">
    <div class="logo text-center">
        <a href="javascript:void(0);"><!--span><img src="images/b_icon.png" alt="BSO"--></span> BSO</a>
        
    </div>
    <div class="card">
        <div class="body">
            <?= $this->Form->create("forgot_password",['type'=>'post','id'=>'forgotPassword']) ?>
            <div class="msg">Enter your registered email.</div>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">Email</i>
                </span>
                <div class="form-line">
                    <?= $this->Form->control('email',   ['label' => false, 'class' => 'form-control', 'placeholder' => 'Email']); ?>
                </div>
            </div>
            <div class="col-xs-4">
                <?= $this->Form->button('Submit',['class' => 'btn btn-block bg-blue-grey  waves-effect']);?>
            </div>
        </div>
        
        <div class="row m-t-15 m-b--20">
            
            <div class="col-xs-6">
                <?php echo $this->Html->link('Sign In',['controller' => 'users', 'action' => 'login'],['escapeTitle' => false,]); ?>
            </div>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>
</div>