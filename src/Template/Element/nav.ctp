<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);" class="bars"></a>
            <a href="<?= BASE_URL.'users/index'?>" class="logo theme-bg">
               <!-- mini logo for sidebar mini 50x50 pixels -->
               <!-- <span class="logo-mini"><img src="<?php // BASE_URL.'img/bso-icon.png'?>" class="" alt=""></span> -->
               <!-- logo for regular state and mobile devices -->
               <span class="logo-lg"><img src="<?= BASE_URL.'img/bso-logo.png'?>" class="" alt="" style="width: 230px;"></span>
            </a>
            <?php
               // echo $this->Html->link('<span class="logo-icon">'.$this->Html->image('bso-icon.png', ['class' => '']).'</span>',['controller' => 'users', 'action' => 'dashboard', 'prefix' => 'admin'],['class'=>'navbar-brand','escape' => false]);
            ?>
            
        </div>
        <?php
            $dataid=$this->request->getSession()->read('Auth.User.id');
            $uuid=$this->request->getSession()->read('Auth.User.uuid');
            $encryptionkey=$this->request->getSession()->read('Auth.User.encryptionkey');
            $dataimage=$this->request->getSession()->read('Auth.User.image');
            $name = $this->Decryption->mc_decrypt($this->request->getSession()->read('Auth.User.firstname'),$encryptionkey).' '.$this->Decryption->mc_decrypt($this->request->getSession()->read('Auth.User.lastname'),$encryptionkey);
        ?>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="pull-right dropdown p-b-10">
                    <a href="javascript:void(0);" class="dropdown-toggle user-pic-small" data-toggle="dropdown">
                        <?= $this->Html->image(($dataimage!='') ? USER_PICTURE_FOLDER_URL_PATH.$uuid.'/'.$dataimage: 'blank-avatar.png', ['alt' => $name,'class' => 'user-img img-circle']) ?>
                        <?= $name ?>
                        
                    </a>
                    
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <?php
                                if(!empty($dataimage)){
                                    echo $this->Html->link($this->Html->image(USER_PICTURE_FOLDER_URL_PATH.$uuid.'/'.$dataimage, ['alt' => 'user','class' => 'user-img img-circle']),['controller' => 'users', 'action' => 'Profile', 'prefix'=>'admin', $uuid],['escapeTitle' => false,]);
                                }else{
                                    echo $this->Html->link($this->Html->image('blank-avatar.png', ['alt' => 'user','class' => 'user-img img-circle']),['controller' => 'users', 'action' => 'Profile', 'prefix' => 'admin', $uuid],['escapeTitle' => false,]);
                                }
                            ?>
                            <h4><?=$name?></h4>
                        <!--     <p>Member since Feb. 2018</p> -->
                        </li>
                        <!-- Menu Body -->
                        <!-- Menu Footer-->
                        <li class="user-footer">
                         
                            <div class="pull-right" style="margin-right: 73px;">
                                <?php echo $this->Html->link('Sign Out',['controller' => 'users', 'action' => 'logout', 'prefix' => false],['class'=>'btn bg-blue-grey btn-lg','escape' => false]);
                                ?>                               
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>